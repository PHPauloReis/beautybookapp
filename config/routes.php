<?php

use App\Controllers\AutenticacaoController;
use App\Controllers\ManicuresController;
use App\Middlewares\AutenticacaoMiddleware;
use League\Route\Router;

$router = new Router();

// Rotas públicas (sem autenticação)
$router->map('GET','/login', [AutenticacaoController::class, 'exibirForm']);
$router->map('POST','/login', [AutenticacaoController::class, 'logar']);
$router->map('GET','/esqueci-minha-senha', [AutenticacaoController::class, 'exibirFormEsqueciSenha']);
$router->map('POST','/esqueci-minha-senha', [AutenticacaoController::class, 'enviarLinkRecuperacao']);
$router->map('GET','/recuperar-senha', [AutenticacaoController::class, 'exibirFormRedefinicacaoSenha']);
$router->map('POST','/recuperar-senha', [AutenticacaoController::class, 'redefinirSenha']);

// Rotas protegidas (requer autenticação)
$router->group('/protected', function ($route) {
    $route->map('GET', '', [ManicuresController::class, 'index']);
    $route->map('GET', '/cadastrar', [ManicuresController::class, 'exibirForm']);
    $route->map('POST', '/cadastrar', [ManicuresController::class, 'gravar']);
    $route->map('DELETE', '/excluir/{id}', [ManicuresController::class, 'excluir']);
    $route->map('DELETE', '/sair', [AutenticacaoController::class, 'sair']);
})->middleware(new AutenticacaoMiddleware());

// Alias para rotas protegidas
$router->map('GET', '/', [ManicuresController::class, 'index'])->middleware(new AutenticacaoMiddleware());
$router->map('GET', '/cadastrar', [ManicuresController::class, 'exibirForm'])->middleware(new AutenticacaoMiddleware());
$router->map('POST', '/cadastrar', [ManicuresController::class, 'gravar'])->middleware(new AutenticacaoMiddleware());
$router->map('DELETE', '/excluir/{id}', [ManicuresController::class, 'excluir'])->middleware(new AutenticacaoMiddleware());
$router->map('DELETE', '/sair', [AutenticacaoController::class, 'sair'])->middleware(new AutenticacaoMiddleware());
