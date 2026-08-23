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
   git clone [https://github.com/TU_USUARIO/TU_REPOSITORIO.git](https://github.com/TU_USUARIO/TU_REPOSITORIO.git)
   cd tu-repositorio