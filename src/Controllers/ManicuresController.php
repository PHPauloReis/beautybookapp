<?php

namespace App\Controllers;

use App\Models\ManicureModel;
use App\Support\LoggerFactory;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ManicuresController extends BaseController
{
    private Logger $logger;
    private ManicureModel $manicureModel;

    public function __construct()
    {
        parent::__construct();
        $loggerFactory = new LoggerFactory();
        $this->logger = $loggerFactory->create('manicures');
        $this->manicureModel = new ManicureModel();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $manicures = $this->manicureModel->obterTodas();

        return $this->render('manicures/index', compact('manicures'));
    }

    public function exibirForm(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('manicures/form');
    }

    public function gravar(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();
        $this->manicureModel->gravar($dados);

        $this->logger->info('Manicure gravada com sucesso', $dados);

        return $this->render('manicures/index');
    }

    public function excluir(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $this->manicureModel->excluir($id);

        $this->logger->info('Manicure excluída com sucesso', compact('id'));

        return $this->render('manicures/index');
    }
}   