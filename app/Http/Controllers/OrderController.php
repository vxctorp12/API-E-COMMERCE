<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;
use Exception;
use OpenApi\Attributes as OA;

class OrderController extends Controller
{
    #[OA\Post(
        path: '/orders',
        summary: 'Crear una orden y procesar el pago con Stripe',
        security: [['bearerAuth' => []]],
        tags: ['Órdenes y Pagos']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['items', 'stripe_token'],
            properties: [
                new OA\Property(
                    property: 'items',
                    type: 'array',
                    items: new OA\Items(
                        required: ['product_id', 'quantity'],
                        properties: [
                            new OA\Property(property: 'product_id', type: 'integer', example: 1),
                            new OA\Property(property: 'quantity', type: 'integer', example: 2)
                        ]
                    )
                ),
                new OA\Property(property: 'stripe_token', type: 'string', example: 'tok_visa')
            ]
        )
    )]
    #[OA\Response(response: 201, description: 'Orden procesada y pagada exitosamente')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    #[OA\Response(response: 422, description: 'Error de validación o error al procesar el pago')]
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $user = Auth::user();
        $items = $request->input('items');
        $stripeToken = $request->input('stripe_token');

        try {
            $orderResponse = DB::transaction(function () use ($user, $items, $stripeToken) {
                
                $totalAmount = 0;
                $orderItemsData = [];

                foreach ($items as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    
                    if ($product->stock < $item['quantity']) {
                        throw new Exception("Stock insuficiente para el producto: {$product->name}");
                    }

                    $subtotal = $product->price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'price' => $product->price, 
                        'quantity' => $item['quantity'],
                    ];
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                foreach ($orderItemsData as $itemData) {
                    $order->items()->create($itemData);
                    
                    Product::where('id', $itemData['product_id'])
                        ->decrement('stock', $itemData['quantity']);
                }

                Stripe::setApiKey(env('STRIPE_SECRET'));

                $charge = Charge::create([
                    'amount' => $totalAmount * 100, 
                    'currency' => 'usd',
                    'source' => $stripeToken,
                    'description' => "Compra Orden #{$order->id} - Usuario: {$user->email}",
                ]);

                Payment::create([
                    'order_id' => $order->id,
                    'stripe_payment_id' => $charge->id,
                    'amount' => $totalAmount,
                    'status' => $charge->status, 
                    'created_by' => $user->id,
                ]);

                if ($charge->status === 'succeeded') {
                    $order->update(['status' => 'paid']);
                }

                return $order->load(['items.product', 'payment']);
            });

            return response()->json([
                'message' => 'Orden procesada y pagada exitosamente',
                'order' => $orderResponse
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la orden',
                'details' => $e->getMessage()
            ], 422);
        }
    }
    
    #[OA\Get(
        path: '/orders',
        summary: 'Consultar el historial de compras del usuario autenticado',
        security: [['bearerAuth' => []]],
        tags: ['Órdenes y Pagos']
    )]
    #[OA\Response(response: 200, description: 'Listado de órdenes con sus ítems y pago')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    public function index(): JsonResponse
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return response()->json($orders);
    }
}