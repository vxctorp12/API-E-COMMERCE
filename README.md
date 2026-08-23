# E-commerce API REST

Una API RESTful desarrollada en Laravel 12 para gestionar las operaciones fundamentales de una tienda en línea. Este proyecto simula un entorno real de backend, implementando seguridad, procesamiento de pagos y documentación interactiva.

## 🚀 Características Principales

* **Autenticación Segura:** Implementación de JSON Web Tokens (JWT) para el registro, inicio y cierre de sesión de usuarios.
* **Catálogo de Productos:** CRUD completo de productos con protección de rutas (excepto el listado público).
* **Gestión de Órdenes:** Creación de órdenes de compra con validación de stock y cálculo de totales.
* **Pasarela de Pagos:** Integración con **Stripe** para el procesamiento seguro de transacciones mediante tarjetas de crédito/débito.
* **Documentación OpenAPI:** Interfaz gráfica interactiva generada con Swagger UI para explorar y probar todos los endpoints.

## 🛠️ Tecnologías Utilizadas

* **Framework:** Laravel 12 (PHP 8.2+)
* **Base de Datos:** MySQL
* **Autenticación:** `php-open-source-saver/jwt-auth`
* **Pagos:** `stripe/stripe-php`
* **Documentación:** `darkaonline/l5-swagger` (Atributos PHP 8)

## 📋 Requisitos Previos

Asegúrate de tener instalado lo siguiente en tu entorno local:
* PHP >= 8.2
* Composer
* Servidor MySQL

## 🔧 Instalación y Configuración

Sigue estos pasos para levantar el proyecto en tu entorno local:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/vxctorp12/API-E-COMMERCE
   cd API-E-COMMERCE

2. **Instalar dependencias:**
   ```bash
   composer install

3. **Configurar variables de entorno:**
    Copia el archivo de ejemplo y renombralo **.env**
    ```bash
    cp .env.example .env

4. **Abre el archivo .env y configura tus credenciales de base de datos y de Stripe:**
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_bd
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

    STRIPE_KEY=pk_test_tu_clave_publicable
    STRIPE_SECRET=sk_test_tu_clave_secreta
    
5. **Generar claves de la aplicación:**
    ```bash
    php artisan key:generate
    php artisan jwt:secret

6. **Ejecutar migraciones y poblar la base de datos**
    ```bash
    php artisan migrate --seed

7. **Generar la documentación de swagger**
    ```bash
    php artisan l5-swagger:generate

8. **Inicializar el servidor local**
    ```bash
    php artisan serve

📖 Documentación de la API (Swagger)
Una vez que el servidor esté corriendo, puedes acceder a la documentación interactiva de la API ingresando a la siguiente URL en tu navegador:

👉 http://localhost:8000/api/documentation

Desde allí podrás ver los esquemas de datos, los parámetros requeridos y ejecutar pruebas reales contra los endpoints.

💳 Datos de Prueba (Stripe)
Para probar el endpoint de creación de órdenes y pagos sin una interfaz frontend, puedes enviar el valor tok_visa en el campo stripe_token del payload JSON. Esto simulará un cobro exitoso en el entorno de pruebas de Stripe.

