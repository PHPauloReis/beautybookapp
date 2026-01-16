<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class HelloController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');

        $twig = new Environment($loader, [
            'cache' => __DIR__ . '/../cache',
            'debug' => true,
            'auto_reload' => true,
        ]);

        $twig->addExtension(new DebugExtension());

        return new HtmlResponse(
            $twig->render('index.html.twig')
        );
    }

    public function quemSomos(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('<h1>A Beautybook é uma empresa bla bla bla...</h1>');
        return $response;
    }
}