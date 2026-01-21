<?php

namespace App\Controllers;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AutenticacaoController extends BaseController
{
    public function exibirForm(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('autenticacao/login');
    }

    public function logar(ServerRequestInterface $request): ResponseInterface
    {
        return new RedirectResponse('/');
    }
}