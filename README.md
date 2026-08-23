# 🛒 E-commerce API REST

API RESTful desarrollada con **Laravel 12** para gestionar las operaciones fundamentales de una tienda en línea.

El proyecto simula un entorno real de backend e implementa autenticación mediante JWT, gestión de productos y órdenes, validación de stock, procesamiento de pagos con Stripe y documentación interactiva mediante Swagger UI.

## 🚀 Características principales

* **Autenticación segura:** registro, inicio de sesión y cierre de sesión mediante **JSON Web Tokens (JWT)**.
* **Catálogo de productos:** CRUD completo de productos con protección de rutas, excepto el listado público.
* **Gestión de órdenes:** creación de órdenes de compra con validación de stock y cálculo automático de totales.
* **Procesamiento de pagos:** integración con **Stripe** para gestionar pagos mediante tarjetas en el entorno de pruebas.
* **Documentación interactiva:** documentación de la API basada en **OpenAPI** y accesible mediante Swagger UI.
* **Base de datos:** persistencia de usuarios, productos y órdenes mediante MySQL.
* **Datos iniciales:** seeders para facilitar la configuración y las pruebas del proyecto.

## 🛠️ Tecnologías utilizadas

| Tecnología     | Uso                                |
| -------------- | ---------------------------------- |
| **Laravel 12** | Framework backend                  |
| **PHP 8.2+**   | Lenguaje de programación           |
| **MySQL**      | Base de datos                      |
| **JWT Auth**   | Autenticación mediante tokens      |
| **Stripe**     | Procesamiento de pagos             |
| **L5-Swagger** | Documentación OpenAPI / Swagger UI |

### Principales paquetes

* [`php-open-source-saver/jwt-auth`](https://github.com/PHP-Open-Source-Saver/jwt-auth)
* [`stripe/stripe-php`](https://github.com/stripe/stripe-php)
* [`darkaonline/l5-swagger`](https://github.com/DarkaOnLine/L5-Swagger)

L5-Swagger permite documentar la API mediante OpenAPI y atributos nativos de PHP.

## 📋 Requisitos previos

Antes de comenzar, asegúrate de tener instalado:

* PHP >= 8.2
* Composer
* MySQL
* Git

También se recomienda contar con una cuenta de Stripe en modo **Test** para probar el procesamiento de pagos.

## 🔧 Instalación y configuración

### 1. Clonar el repositorio

```bash
git clone https://github.com/vxctorp12/API-E-COMMERCE.git
cd API-E-COMMERCE
```

### 2. Instalar las dependencias

```bash
composer install
```

### 3. Configurar las variables de entorno

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

En Windows, puedes copiar manualmente `.env.example` y renombrarlo como `.env` si `cp` no está disponible.

Después, configura las credenciales de la base de datos y Stripe:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

STRIPE_KEY=pk_test_tu_clave_publicable
STRIPE_SECRET=sk_test_tu_clave_secreta
```

> **Importante:** nunca subas al repositorio las claves secretas de Stripe ni el archivo `.env`.

### 4. Generar las claves de la aplicación

```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Ejecutar las migraciones y seeders

```bash
php artisan migrate --seed
```

Este comando crea las tablas necesarias y carga los datos iniciales definidos por el proyecto.

### 6. Generar la documentación de Swagger

```bash
php artisan l5-swagger:generate
```

### 7. Iniciar el servidor local

```bash
php artisan serve
```

La aplicación estará disponible normalmente en:

```text
http://localhost:8000
```

## 📖 Documentación de la API

Una vez iniciado el servidor, puedes acceder a Swagger UI desde:

**http://localhost:8000/api/documentation**

Desde esta interfaz puedes consultar:

* Endpoints disponibles.
* Parámetros de las solicitudes.
* Esquemas de respuesta.
* Requisitos de autenticación.
* Códigos de respuesta HTTP.
* Pruebas de los endpoints directamente desde el navegador.

## 🔐 Autenticación

Los endpoints protegidos requieren un **JWT válido**.

Después de iniciar sesión, utiliza el token recibido en el encabezado:

```http
Authorization: Bearer <token>
```

Swagger UI permite configurar el token y probar posteriormente los endpoints protegidos.

## 💳 Pruebas con Stripe

El proyecto utiliza las credenciales de Stripe en modo **Test**, por lo que no se realizan cargos reales.

Si el endpoint de creación de órdenes está implementado para recibir un token de tarjeta, puedes utilizar el token de prueba correspondiente, por ejemplo:

```json
{
    "stripe_token": "tok_visa"
}
```

Stripe también documenta tarjetas de prueba como `4242 4242 4242 4242` para escenarios de pago exitoso. La forma exacta de enviar el dato depende de cómo esté implementada la integración en este proyecto.

> **Nota:** utiliza únicamente datos y credenciales de prueba mientras trabajes con el entorno `test` de Stripe.

## 🧪 Pruebas

Laravel incluye soporte para pruebas mediante PHPUnit/Pest. Para ejecutar la suite disponible en el proyecto:

```bash
php artisan test
```

Las pruebas de funcionalidades pueden utilizarse para validar flujos como autenticación, productos, órdenes y pagos.

## 📌 Flujo general

El flujo principal de la aplicación es:

```text
Usuario
   │
   ├── Registro / Login
   │        │
   │        └── JWT
   │
   ├── Consulta de productos
   │
   ├── Creación de orden
   │        │
   │        ├── Validación de stock
   │        ├── Cálculo del total
   │        └── Procesamiento del pago
   │                 │
   │                 └── Stripe
   │
   └── Respuesta de la API
```

## 📂 Estructura general

La aplicación sigue la estructura convencional de Laravel, separando responsabilidades entre rutas, controladores, modelos, requests, servicios y recursos según corresponda.

```text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
└── ...

database/
├── migrations/
└── seeders/

routes/
└── api.php

storage/
└── ...

tests/
├── Feature/
└── Unit/
```

## 🔗 Repositorio

GitHub:

https://github.com/vxctorp12/API-E-COMMERCE

## 📄 Licencia

Este proyecto está disponible para fines educativos y de demostración, salvo que el repositorio indique una licencia diferente.
