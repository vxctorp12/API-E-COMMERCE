<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    public function index(): JsonResponse
    {
        $products = Product::paginate(10);
        return response()->json($products);
    }

    
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


    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

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


    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente'
        ]);
    }
}