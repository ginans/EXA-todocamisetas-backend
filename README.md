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

## Documentacion API

- Swagger UI: `http://localhost:8080/api/documentation`
- JSON generado: `storage/api-docs/api-docs.json`
- Regenerar docs: `docker compose exec app php artisan l5-swagger:generate`

## Coleccion Postman

- Archivo importable: `docs/postman/TodoCamisetas.postman_collection.json`
- Variable incluida: `baseUrl` (por defecto `http://localhost:8080`)

## Endpoints principales

- Camisetas: CRUD + precio final por cliente
- Clientes: CRUD + listado de camisetas por cliente
- Tallas: CRUD + asociacion/desasociacion con camisetas

## Reproducibilidad de dependencias

- El contenedor `app` instala dependencias automaticamente con `composer install` al iniciar.
- La instalacion usa `composer.lock`, por lo que mantiene exactamente las mismas versiones.
- No usar `composer update` salvo que el equipo acuerde actualizar versiones y commitear un nuevo lock.

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
