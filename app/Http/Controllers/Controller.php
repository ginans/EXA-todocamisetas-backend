<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'TodoCamisetas API',
    description: 'API REST para gestion de camisetas y clientes B2B de TodoCamisetas.'
)]
#[OA\Server(
    url: 'http://localhost:8080',
    description: 'Servidor local Docker'
)]
#[OA\Tag(name: 'Camisetas', description: 'Gestion de camisetas')]
#[OA\Tag(name: 'Clientes', description: 'Gestion de clientes')]
#[OA\Tag(name: 'Tallas', description: 'Gestion de tallas y asociacion a camisetas')]
abstract class Controller
{
    //
}
