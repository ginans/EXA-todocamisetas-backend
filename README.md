# TodoCamisetas Backend

Backend de la evaluacion TodoCamisetas, montado con Laravel 11 y Docker para asegurar compatibilidad de revision.

## Stack

- PHP 8.2
- Laravel 11
- L5 Swagger 11
- Nginx 1.27 Alpine
- MySQL 8.0

## Requisitos

- Docker
- Docker Compose

## Puesta en marcha

Desde la raiz del proyecto:

```bash
cp .env.example .env
./scripts/up.sh
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

Comportamiento por sistema operativo al ejecutar `./scripts/up.sh`:

- Linux/WSL: aplica automaticamente UID/GID del usuario actual para evitar problemas de permisos en archivos.
- Windows/macOS: ejecuta `docker compose up -d --build` normal, sin configuraciones extra.

Si ya existen datos de pruebas anteriores y quieres reiniciar la base:

```bash
docker compose exec app php artisan migrate:fresh
```

Aplicacion disponible en `http://localhost:8080`.

## Verificacion rapida

```bash
curl -s http://localhost:8080/api/v1/clientes
curl -s http://localhost:8080/api/v1/camisetas
curl -s http://localhost:8080/api/v1/tallas
```

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

## Solucion de problemas comunes

- Si falla por puertos ocupados (`8080` o `3306`), liberar puerto o cambiar mapeo en `docker-compose.yml`.
- Si Swagger no refleja cambios nuevos, regenerar con:
	- `docker compose exec app php artisan l5-swagger:generate`

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
