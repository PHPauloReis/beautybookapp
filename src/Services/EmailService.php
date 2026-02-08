<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class EmailService
{
    public static function enviarEmail(string $destinatario, string $assunto, string $mensagem): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->Username = '';
            $mail->Password = ' ';
            $mail->setFrom('sistema@beautybook.app.br', 'BeautyBook');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            
            $mail->send();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
