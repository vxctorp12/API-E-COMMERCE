<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: '/products',
        summary: 'Listar catálogo de productos (Público)',
        tags: ['Productos']
    )]
    #[OA\Response(response: 200, description: 'Listado paginado de productos')]
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->boolean('in_stock_only')) {
            $query->where('stock', '>', 0);
        }

        // Priorizar productos con inventario disponible (stock > 0) y luego los más recientes
        $products = $query->orderByRaw('CASE WHEN stock > 0 THEN 1 ELSE 0 END DESC')
            ->latest()
            ->paginate(12);

        return response()->json($products);
    }

    #[OA\Post(
        path: '/products',
        summary: 'Crear un nuevo producto',
        security: [['bearerAuth' => []]],
        tags: ['Productos']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name', 'price', 'stock'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Laptop Gamer'),
                new OA\Property(property: 'description', type: 'string', example: '16GB RAM, RTX 4060'),
                new OA\Property(property: 'price', type: 'number', format: 'float', example: 1250.00),
                new OA\Property(property: 'stock', type: 'integer', example: 10)
            ]
        )
    )]
    #[OA\Response(response: 201, description: 'Producto creado exitosamente')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    #[OA\Response(response: 422, description: 'Error de validación')]
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        $data['created_by'] = Auth::id();

        $product = Product::create($data);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => $product
        ], 201);
    }

    #[OA\Get(
        path: '/products/{product}',
        summary: 'Obtener el detalle de un producto específico (Público)',
        tags: ['Productos']
    )]
    #[OA\Parameter(
        name: 'product',
        description: 'ID del producto',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: 200, description: 'Detalle del producto')]
    #[OA\Response(response: 404, description: 'Producto no encontrado')]
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    #[OA\Put(
        path: '/products/{product}',
        summary: 'Actualizar un producto existente',
        security: [['bearerAuth' => []]],
        tags: ['Productos']
    )]
    #[OA\Parameter(
        name: 'product',
        description: 'ID del producto',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Laptop Gamer Pro'),
                new OA\Property(property: 'description', type: 'string', example: 'Actualización de RAM a 32GB'),
                new OA\Property(property: 'price', type: 'number', format: 'float', example: 1350.00),
                new OA\Property(property: 'stock', type: 'integer', example: 15)
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Producto actualizado exitosamente')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    #[OA\Response(response: 404, description: 'Producto no encontrado')]
    #[OA\Response(response: 422, description: 'Error de validación')]
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        
        $data['updated_by'] = Auth::id();

        $product->update($data);

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => $product
        ]);
    }

    #[OA\Delete(
        path: '/products/{product}',
        summary: 'Eliminar un producto (Soft Delete)',
        security: [['bearerAuth' => []]],
        tags: ['Productos']
    )]
    #[OA\Parameter(
        name: 'product',
        description: 'ID del producto',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(response: 200, description: 'Producto eliminado exitosamente')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    #[OA\Response(response: 404, description: 'Producto no encontrado')]
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}