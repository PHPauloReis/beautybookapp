<?php

namespace App\Controllers;

use App\Models\ManicureModel;
use App\Support\FlashMessage;
use App\Support\FormValidation;
use App\Support\LoggerFactory;
use Laminas\Diactoros\Response\RedirectResponse;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

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
        $flashMessage = FlashMessage::get();

        $busca = $request->getQueryParams()['search'] ?? '';

        if (!empty($busca)) {
            $manicures = $this->manicureModel->obterTodasComFiltro($busca);
        } else {
            $manicures = $this->manicureModel->obterTodas();
        }

        return $this->render('manicures/index', compact('manicures', 'flashMessage'));
    }

    public function exibirForm(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessage = FlashMessage::get();

        $errorBag = unserialize($flashMessage['mensagem'] ?? '');

        return $this->render('manicures/form', compact('flashMessage', 'errorBag'));
    }

    public function gravar(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();

        $validador = new FormValidation();

        $regrasDeValidacao = [
            'nome' => Validator::stringType()
                                ->setName('nome')
                                ->setTemplate('O campo nome deve ser uma string!')
                                ->notEmpty()
                                ->setTemplate('O campo nome não deve estar vazio!')
                                ->length(3, 100)
                                ->setTemplate('O campo nome deve ter entre 3 e 100 caracteres!'),


            'telefone' => Validator::stringType()
                                ->setName('telefone')
                                ->setTemplate('O campo telefone deve ser uma string!')
                                ->notEmpty()
                                ->setTemplate('O campo telefone não deve estar vazio!')
                                ->length(3, 100)
                                ->setTemplate('O campo telefone deve ter entre 10 e 100 caracteres!'),
        ];

        $erros = $validador->validate($dados, $regrasDeValidacao);

        if (!empty($erros)) {
            FlashMessage::set('errorBag', serialize($erros));
            return new RedirectResponse('/cadastrar');
        }

        $this->manicureModel->gravar($dados);

        FlashMessage::set('sucesso', 'Manicure gravada com sucesso!');
        $this->logger->info('Manicure gravada com sucesso', $dados);

        return new RedirectResponse('/');
    }

    public function excluir(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $this->manicureModel->excluir($id);

        FlashMessage::set('sucesso', 'Manicure excluída com sucesso!');
        $this->logger->info('Manicure excluída com sucesso', compact('id'));

        return new RedirectResponse('/');
    }
}   