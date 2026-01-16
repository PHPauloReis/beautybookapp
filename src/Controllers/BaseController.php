<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected Environment $twig;
    protected FilesystemLoader $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../Views');

        $this->twig = new Environment($this->loader, [
            'cache' => __DIR__ . '/../cache',
            'debug' => true,
            'auto_reload' => true,
        ]);

        $this->twig->addExtension(new DebugExtension());
    }

    public function render(string $template, array $dados = []): Response
    {
        return new HtmlResponse(
            $this->twig->render($template . '.html.twig', $dados)
        );
    }
}