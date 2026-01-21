<?php

use App\Controllers\AutenticacaoController;
use App\Controllers\ManicuresController;
use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [ManicuresController::class, 'index']);
$router->map('GET','/cadastrar', [ManicuresController::class, 'exibirForm']);
$router->map('POST','/cadastrar', [ManicuresController::class, 'gravar']);
$router->map('DELETE','/excluir/{id}', [ManicuresController::class, 'excluir']);

$router->map('GET','/login', [AutenticacaoController::class, 'exibirForm']);
$router->map('POST','/login', [AutenticacaoController::class, 'logar']);