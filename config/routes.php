<?php

use App\Controllers\ManicuresController;
use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [ManicuresController::class, 'index']);
$router->map('GET','/cadastrar', [ManicuresController::class, 'exibirForm']);
$router->map('POST','/cadastrar', [ManicuresController::class, 'gravar']);
$router->map('GET','/excluir/{id}', [ManicuresController::class, 'excluir']);