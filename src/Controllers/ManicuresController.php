<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ManicuresController extends BaseController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('index');
    }

    public function exemplo2(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('exemplo2');
    }
}