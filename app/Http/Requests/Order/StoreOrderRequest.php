<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validamos que se envíe un array de items y que no esté vacío
            'items' => 'required|array|min:1',
            // Validamos que cada elemento del array sea un array asociativo con 'product_id' y 'quantity'
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            // El token de pago que nos envía el frontend (generado por Stripe.js)
            'stripe_token' => 'required|string', 
        ];
    }
}