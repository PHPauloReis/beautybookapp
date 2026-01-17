<?php

use App\Controllers\ManicuresController;
use League\Route\Router;

$router = new Router();

$router->map('GET', '/', [ManicuresController::class, 'index']);