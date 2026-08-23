<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'Documentación de los endpoints del e-commerce básico para el caso de estudio.',
    title: 'E-commerce API REST'
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Servidor API'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
class SwaggerConfig
{

}