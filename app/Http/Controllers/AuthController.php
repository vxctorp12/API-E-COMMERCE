<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: '/auth/register',
        summary: 'Registrar un nuevo usuario/cliente',
        tags: ['Autenticación']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name', 'email', 'password', 'password_confirmation'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Juan Pérez'),
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'juan@example.com'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'password123')
            ]
        )
    )]
    #[OA\Response(response: 201, description: 'Usuario registrado exitosamente')]
    #[OA\Response(response: 422, description: 'Error de validación')]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token, 'Usuario registrado exitosamente', 201);
    }

    #[OA\Post(
        path: '/auth/login',
        summary: 'Iniciar sesión y obtener token JWT',
        tags: ['Autenticación']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'juan@example.com'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123')
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Login exitoso, retorna el token')]
    #[OA\Response(response: 401, description: 'Credenciales inválidas')]
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return $this->respondWithToken($token, 'Login exitoso');
    }

    #[OA\Post(
        path: '/auth/logout',
        summary: 'Cerrar sesión e invalidar token JWT',
        security: [['bearerAuth' => []]],
        tags: ['Autenticación']
    )]
    #[OA\Response(response: 200, description: 'Sesión cerrada correctamente')]
    #[OA\Response(response: 401, description: 'No autorizado')]
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    protected function respondWithToken($token, $message, $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], $status);
    }
}