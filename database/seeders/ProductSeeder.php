<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Gamer',
                'description' => 'Laptop de alto rendimiento para juegos, 16GB RAM, RTX 4060.',
                'price' => 1250.00,
                'stock' => 10,
                'created_by' => 1 
            ],
            [
                'name' => 'Smartphone Pro',
                'description' => 'Teléfono inteligente de última generación, pantalla OLED 120Hz.',
                'price' => 899.99,
                'stock' => 25,
                'created_by' => 1
            ],
            [
                'name' => 'Auriculares Inalámbricos',
                'description' => 'Auriculares con cancelación de ruido activa.',
                'price' => 150.50,
                'stock' => 50,
                'created_by' => 1
            ],
            [
                'name' => 'Monitor 4K',
                'description' => 'Monitor de 27 pulgadas resolución 4K, ideal para diseño.',
                'price' => 350.00,
                'stock' => 15,
                'created_by' => 1
            ],
            [
                'name' => 'Teclado Mecánico',
                'description' => 'Teclado mecánico switches rojos, retroiluminación RGB.',
                'price' => 75.00,
                'stock' => 30,
                'created_by' => 1
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}