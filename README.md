# TodoCamisetas Backend

Backend de la evaluacion TodoCamisetas, montado con Laravel 11 y Docker para asegurar compatibilidad de revision.

## Stack

- PHP 8.2
- Laravel 11
- L5 Swagger 11
- Nginx 1.27 Alpine
- MySQL 8.0

## Puesta en marcha

```bash
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

Aplicacion disponible en `http://localhost:8080`.

## Estructura base

- `app/Models`: entidades del dominio.
- `database/migrations`: esquema y relaciones de la base de datos.
- `routes`: rutas HTTP y endpoints de la API.
- `docker/php`: imagen PHP-FPM de la aplicacion.
- `docker/nginx`: configuracion del servidor web.

## Modelo inicial

La Tarea 1 deja definidos estos componentes principales del dominio:

- `clientes`
- `camisetas`
- `tallas`
- `camiseta_talla`
- `camiseta_cliente`

La implementacion de controladores, rutas CRUD, Swagger operativo y reglas de negocio se completa en las tareas siguientes.
