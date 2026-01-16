<?php

use App\Controllers\ManicuresController;
use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [ManicuresController::class, 'index']);
$router->map('GET', '/exemplo2', [ManicuresController::class, 'exemplo2']);