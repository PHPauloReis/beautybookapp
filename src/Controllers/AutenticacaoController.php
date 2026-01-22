<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Support\FlashMessage;
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
        $flashMessage = FlashMessage::get();

        return $this->render('autenticacao/login', compact('flashMessage'));
    }

    public function logar(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();

        $email = $dados['email'];
        $senha = $dados['senha'];

        try {
            $usuarioSelecionado = $this->usuarioModel->obterPorEmail($email);

            if(!password_verify($senha, $usuarioSelecionado['senha'])) {
                FlashMessage::set("erro", "Credenciais inválidas");
                return new RedirectResponse("/login");
            }
        } catch (\Exception $e) {
            FlashMessage::set("erro", "Credenciais inválidas");
            return new RedirectResponse("/login");
        }

        return new RedirectResponse('/');
    }

    public function exibirFormEsqueciSenha(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessage = FlashMessage::get();

        return $this->render('autenticacao/esqueci_minha_senha', compact('flashMessage'));
    }

    public function enviarLinkRecuperacao(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();

        $email = $dados['email'];

        try {
            $usuarioSelecionado = $this->usuarioModel->obterPorEmail($email);
        } catch (\Exception $e) {
            FlashMessage::set("sucesso", "Link de recuperação enviado com sucesso");
            return new RedirectResponse("/esqueci-minha-senha");
        }

        FlashMessage::set("sucesso", "Link de recuperação enviado com sucesso");
        return new RedirectResponse("/esqueci-minha-senha");
    }
}