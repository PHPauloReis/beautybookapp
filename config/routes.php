<?php

use App\Controllers\HelloController;
use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [HelloController::class, 'index']);
$router->map('GET', '/quem-somos', [HelloController::class, 'quemSomos']);