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

### Windows (Docker Desktop)

Usar los pasos normales de Docker (sin script):

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

### Linux/WSL

Para evitar problemas de permisos, usar el script que aplica UID/GID automaticamente:

```bash
cp .env.example .env
./scripts/up.sh
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

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

Diagrama del modelo de datos en PlantUML:

- `docs/diagramas/modelo-datos.puml`

![](https://www.plantuml.com/plantuml/png/jLHDRzD04BtlhnZrrA96AaXSegggILsmcWH87CJDsgmdoOBjiMRNXzBotrax3lQ66WGL5sjdtdoyDxFhQsCbsohFn4wd23dQ7QLcRnYBZ6JlIpJ2VDL5ALdce39fJ60jwtLbCL9KBFKtX0iXiB3QtiE9ohGxeZa1QU1Wm8C0U04wXJ6yYTv6yzZPev7x59Il6HD5ERBICdC1duB5v5smS21NjhFXyd8rZpwkmgih1wMQKIbDXPUWfCKjiPRE6yvNirF6RPL9FeUISOECHTtZh8wamafbATaJyAiSCCobzXcLn0eT-WKJSlLitUWcd4IpO7hw-lnLKvdHiKWJMNEFercuZ8FP1mTKPVeKyBqtEvbhWrQsmpjOmzDpQLL6FlciMlkKfJQUm-hoA8KoOZ-7KMdgQNjvqOXh0KzxXxiDpLVJwNu_ZdYMeQcbXf_ZFgGerLjAIgQqKfO6DloSETQjso4snp_Uly5RXaQnBlrxvcbv_hAJXc93rdSDakxYUfXZTNlNSAgJ1w2_fGkm7yPfh-FvpmPdJyffttmho7V-gwGs_N-Awbeqihh7z_Wu6j73yMx6pL_2fQ1e7CDnAMvqWOC5kzcCmTH_5KQ5YHIjztVXYlAIfH05EPFrTcU1DaS4nFkvUwJJC0vX4YmdmKq8M83Crux8xPt08eKwVR18sqtqPZM6NseUs1wX2pVnHJI9kpRNxbJbsGy0)


## Entrega

Integrantes del equipo:

- Gina Norambuena
- Fabian Malinarich

## Disclaimer

Este proyecto fue desarrollado por el equipo y conto con apoyo de GitHub Copilot como herramienta de asistencia tecnica.

Copilot se utilizo como coding partner para acelerar tareas operativas y mejorar la productividad en actividades como:

- estructuracion de archivos y documentacion tecnica;
- propuesta de implementaciones base y ajustes de configuracion;
- apoyo en depuracion y validacion de comandos.

Las decisiones de arquitectura, criterios de negocio, priorizacion de requerimientos y la responsabilidad intelectual del trabajo corresponden integramente al equipo.
