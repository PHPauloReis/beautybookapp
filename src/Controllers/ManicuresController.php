<?php

namespace App\Controllers;

use App\Models\ManicureModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ManicuresController extends BaseController
{
    private ManicureModel $manicureModel;

    public function __construct()
    {
        parent::__construct();
        $this->manicureModel = new ManicureModel();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $manicures = $this->manicureModel->obterTodas();

        return $this->render('index', compact('manicures'));
    }
}