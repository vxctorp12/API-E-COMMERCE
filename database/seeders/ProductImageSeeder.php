<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Agregar imágenes a los productos existentes
        $existingProducts = Product::all();
        $unsplashIds = [
            'photo-1523275335684-37898b6baf30', // Reloj
            'photo-1505740420928-5e560c06d30e', // Auriculares
            'photo-1542291026-7eec264c27ff', // Zapatos
            'photo-1526170375885-4d8ecf77b99f', // Cámara polaroid
            'photo-1503602642458-232111445657', // Silla
            'photo-1584916201218-f4242ceb4809', // Bolso
        ];

        foreach ($existingProducts as $index => $product) {
            if (!$product->image_url) {
                $imageId = $unsplashIds[$index % count($unsplashIds)];
                $product->update([
                    'image_url' => "https://images.unsplash.com/{$imageId}?auto=format&fit=crop&q=80&w=800"
                ]);
            }
        }

        // 2. Agregar 3 productos nuevos
        Product::create([
            'name' => 'Lámpara Minimalista Aura',
            'description' => 'Ilumina tu espacio con esta elegante lámpara de diseño escandinavo.',
            'price' => 89.99,
            'stock' => 15,
            'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&q=80&w=800'
        ]);

        Product::create([
            'name' => 'Mochila Urbana de Cuero',
            'description' => 'Perfecta para la ciudad y el trabajo, con compartimento para laptop.',
            'price' => 125.00,
            'stock' => 8,
            'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&q=80&w=800'
        ]);

        Product::create([
            'name' => 'Termo Inteligente Acero',
            'description' => 'Mantiene tus bebidas calientes por 12 horas o frías por 24 horas.',
            'price' => 35.50,
            'stock' => 50,
            'image_url' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&q=80&w=800'
        ]);
    }
}
