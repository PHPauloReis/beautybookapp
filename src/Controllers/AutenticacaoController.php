<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Services\EmailService;
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

        if (isset($_GET['message']) && $_GET['message'] === 'logout') {
            $flashMessage = [
                "tipo" => "sucesso",
                "mensagem" => "Desconectado com sucesso"
            ];
        }

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

        session_start();
        $_SESSION['usuario_id'] = $usuarioSelecionado['id'];
        $_SESSION['usuario_email'] = $usuarioSelecionado['email'];

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

            $tokenRecuperacaoSenha = bin2hex(random_bytes(16));

            $usuarioSelecionado['token_recuperacao_senha'] = $tokenRecuperacaoSenha;
            $this->usuarioModel->atualizar($usuarioSelecionado['id'], $usuarioSelecionado);

            EmailService::enviarEmail(
                $usuarioSelecionado['email'],
                "Link de recuperação de senha",
                "Clique no link para recuperar sua senha: <a href='http://localhost:8000/recuperar-senha?token={$tokenRecuperacaoSenha}'>Recuperar Senha</a>"
            );

        } catch (\Exception $e) {
            FlashMessage::set("sucesso", "Link de recuperação enviado com sucesso");
            return new RedirectResponse("/esqueci-minha-senha");
        }

        FlashMessage::set("sucesso", "Link de recuperação enviado com sucesso");
        return new RedirectResponse("/esqueci-minha-senha");
    }

    public function exibirFormRedefinicacaoSenha(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessage = FlashMessage::get();
        $token = $request->getQueryParams()['token'] ?? null;

        if (!$token) {
            FlashMessage::set("erro", "Token de recuperação de senha inválido");
            return new RedirectResponse("/esqueci-minha-senha");
        }

        try {
            $usuarioSelecionado = $this->usuarioModel->obterPorTokenRecuperacaoSenha($token);
        } catch (\Exception $e) {
            FlashMessage::set("erro", "Token de recuperação de senha inválido");
            return new RedirectResponse("/esqueci-minha-senha");
        }

        return $this->render('autenticacao/redefinir_senha', compact('flashMessage', 'token'));
    }

    public function redefinirSenha(ServerRequestInterface $request): ResponseInterface
    {
        $dados = $request->getParsedBody();

        $token = $dados['token'];
        $novaSenha = $dados['nova_senha'];
        $confirmacaoSenha = $dados['confirmar_senha'];

        if ($novaSenha !== $confirmacaoSenha) {
            FlashMessage::set("erro", "As senhas não coincidem");
            return new RedirectResponse("/recuperar-senha?token={$token}");
        }        

        try {
            $usuarioSelecionado = $this->usuarioModel->obterPorTokenRecuperacaoSenha($token);

            $usuarioSelecionado['senha'] = password_hash($novaSenha, PASSWORD_BCRYPT);
            $usuarioSelecionado['token_recuperacao_senha'] = "";

            $this->usuarioModel->atualizar($usuarioSelecionado['id'], $usuarioSelecionado);

            FlashMessage::set("sucesso", "Senha recuperada com sucesso");
            return new RedirectResponse("/login");
        } catch (\Exception $e) {
            FlashMessage::set("erro", "Token de recuperação de senha inválido");
            return new RedirectResponse("/esqueci-minha-senha");
        }
    }

    public function sair(ServerRequestInterface $request): ResponseInterface
    {
        session_start();
        session_destroy();
        
        return new RedirectResponse("/login?message=logout");
    }
}