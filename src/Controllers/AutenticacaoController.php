<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AutenticacaoController extends BaseController
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        return parent::__construct();
    }

    public function exibirForm(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('autenticacao/login');
    }

    public function logar(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();

        $email = $dados['email'];
        $senha = $dados['senha'];

        try {
            $usuarioSelecionado = $this->usuarioModel->obterPorEmail($email);

            if(password_verify($senha, $usuarioSelecionado['senha'])) {
                echo "Logado com sucesso";
            } else {
                echo "Senha incorreta";
            }

        } catch (\Exception $e) {
            $usuarioSelecionado = null;
        }

        return new RedirectResponse('/');
    }
}