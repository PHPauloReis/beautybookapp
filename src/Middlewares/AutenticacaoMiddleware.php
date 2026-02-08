<?php

namespace App\Middlewares;

use App\Support\FlashMessage;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AutenticacaoMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
            FlashMessage::set("erro", "Você precisa estar autenticado para acessar esta página");
            return new RedirectResponse("/login");
        }

        return $handler->handle($request);
    }
}
