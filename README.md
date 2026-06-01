# Backend - LUCEMIR Huachipa

API REST desarrollada en **Laravel 10** para la operación del sistema de alimentación de **Concesionario de Alimentos Lucemir - Huachipa**.

## Objetivo del backend

Este proyecto concentra la lógica de negocio para:

- autenticación de usuarios con **Laravel Sanctum**;
- gestión de **trabajadores**;
- gestión de **productos** y categorías;
- registro de **ventas** y **ventas pasadas**;
- aplicación de **subvenciones** parciales o completas;
- generación de **tickets** de impresión;
- exportación de reportes en **Excel** y **PDF**;
- abastecimiento de datos para el **dashboard**.

## Stack técnico

- PHP `^8.1`
- Laravel `^10.10`
- Sanctum para autenticación por token
- `maatwebsite/excel` para exportaciones
- `barryvdh/laravel-dompdf` para PDF
- `mike42/escpos-php` para impresión térmica

## Estructura relevante

```text
backend/
├─ app/
│  ├─ Exports/              # Reportes Excel
│  ├─ Http/
│  │  ├─ Controllers/       # Endpoints REST
│  │  ├─ Middleware/        # Middleware, incluida la licencia
│  │  ├─ Requests/          # Validaciones
│  │  └─ Traits/            # Lógica compartida
│  ├─ Imports/              # Importaciones de datos
│  └─ Models/               # Entidades principales y catálogos
├─ config/                  # Configuración Laravel + impresora + Excel + PDF
├─ database/
│  ├─ migrations/
│  └─ seeders/
├─ routes/
│  ├─ api.php               # API principal
│  └─ web.php               # Rutas utilitarias y fallback
└─ tests/                   # Actualmente sólo pruebas base de ejemplo
```

## Módulos principales

### Autenticación

- `POST /api/login`
- `POST /api/logout`

La autenticación usa `auth:sanctum` y el frontend envía el token como `Bearer`.

### Usuarios

- `GET /api/users`
- `POST /api/users`
- `GET /api/users/{id}`
- `PUT/PATCH /api/users/{id}`
- `DELETE /api/users/{id}`
- `GET /api/users/getAllResources`

### Trabajadores

Controlados desde `WorkerController`.

Capacidades detectadas:

- CRUD completo
- búsqueda sensible
- exportación a Excel y PDF
- catálogos auxiliares vía `getAllResources`

El modelo `Worker` incluye relaciones con área, centro de costo, sede, planilla, documento, cargo, empresa y otros catálogos laborales. También soporta:

- `allowed_meals` como arreglo;
- foto con URL pública generada;
- `SoftDeletes`.

### Productos

Controlados desde `ProductController`.

Capacidades detectadas:

- CRUD completo
- filtros de productos
- búsqueda exacta y sensible
- soporte de generación/actualización de código de barras

### Ventas

Controladas desde `SaleController`.

Capacidades detectadas:

- listado y CRUD
- registro de ventas normales
- registro con subvención
- generación de ticket
- totales por categoría
- totales de almuerzo
- recursos auxiliares para formularios

El modelo `Sale` está asociado a `Worker` y `SaleDetail`, y también usa `SoftDeletes`.

### Ventas pasadas

Controladas desde `PastSaleController`.

Se usan para gestionar operaciones históricas, con soporte para:

- listado;
- registro;
- subvención;
- ticket;
- eliminación.

### Consumos y reportes

Controlados desde `ConsumptionController`.

Exportaciones detectadas:

- consumo general;
- subvención;
- resumen por trabajador;
- subvención por día.

### Dashboard y perfil

- `HomeController`: métricas y recursos del dashboard.
- `ProfileController`: consulta y actualización del perfil del usuario.

## Rutas especiales observadas

En `routes/web.php` y `TestController` existen rutas operativas o utilitarias como:

- `/optimize`
- `/optimize-clear`
- `/genera-link-storage`
- `/api/pasarProductoAntiguos`
- `/api/workers-listado`

Estas rutas son útiles para soporte o migraciones puntuales, pero conviene **revisarlas antes de producción**.

## Variables de entorno importantes

El proyecto depende de `backend/.env`. Se creó una copia base desde `.env.example` porque el archivo no estaba presente.

Variables clave detectadas:

### Aplicación

- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `APP_DEBUG`
- `APP_URL`

### Base de datos

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

### Impresión de tickets

- `PRINTER_NAME`
- `PRINTER_COMPANY`
- `PRINTER_COMPANY_PHONE`

### Bridge biométrico .NET

- `BIOMETRIC_BRIDGE_URL`
- `BIOMETRIC_BRIDGE_TOKEN`
- `BIOMETRIC_BRIDGE_TIMEOUT`

## Instalación y arranque

### Requisitos

- PHP 8.1 o superior
- Composer
- MySQL o MariaDB

### Flujo recomendado

1. Instalar dependencias de Composer.
2. Revisar y completar `backend/.env`.
3. Generar `APP_KEY`.
4. Configurar base de datos.
5. Ejecutar migraciones.
6. Levantar Laravel en desarrollo.

## Huellas de trabajadores

El sistema mantiene el enrolamiento y guardado de huellas dentro del módulo de trabajadores. La identificación rápida en ventas puede apoyarse en un servicio local `biometric-bridge-dotnet/` que sincroniza huellas con Laravel, genera templates y mantiene una caché en memoria para búsquedas 1:N.

## Desarrollo frontend asociado

El frontend consume esta API mediante Axios usando la variable `VITE_API_URL`, por lo que la URL del backend debe incluir el prefijo `/api` esperado por la SPA.

## Estado actual observado

### Fortalezas

- estructura modular clara por dominio;
- uso de Requests para validaciones;
- soporte de exportaciones y ticketing;
- modelo de trabajadores con relaciones ricas para contexto laboral.

### Riesgos o puntos a revisar

1. **Licencia vencida hardcodeada**: `app/Http/Middleware/LicenseMiddleware.php` contiene fecha fija `2024-04-30`, lo que hoy provoca estado expirado si el middleware se aplica.
2. **Rutas utilitarias visibles**: hay endpoints de soporte y carga masiva que no deberían quedar abiertos sin control en producción.
3. **Pruebas automatizadas escasas**: en `tests/` sólo se encontraron `ExampleTest.php` de base.
4. **Datos masivos en rutas**: el endpoint `workers-listado` incluye datos inline que sería mejor mover a seeders o comandos.

## Archivos útiles para orientarse rápido

- `routes/api.php`
- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/WorkerController.php`
- `app/Http/Controllers/ProductController.php`
- `app/Http/Controllers/SaleController.php`
- `app/Http/Controllers/PastSaleController.php`
- `app/Http/Controllers/ConsumptionController.php`
- `app/Models/Worker.php`
- `app/Models/Sale.php`

## Recomendaciones siguientes

- mover scripts y cargas masivas fuera de rutas públicas;
- revisar la estrategia de licencia;
- agregar pruebas para autenticación, ventas, subvenciones y reportes;
- documentar ejemplos de requests/responses por módulo.
