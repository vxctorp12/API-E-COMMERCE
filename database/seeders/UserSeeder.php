<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Admin API',
            'email' => 'admin@ecommerce.test',
            'password' => Hash::make('password123'),
        ]);

        // Usuario Cliente de Prueba
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@ecommerce.test',
            'password' => Hash::make('password123'),
        ]);
    }
}