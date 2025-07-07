<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function enviarConfirmacaoEmail($para, $assunto, $mensagem) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mgermano578@gmail.com';         // <-- Substitua aqui
        $mail->Password = 'bjmhrjsijxdlwdfz';            // <-- Substitua aqui (senha de app do Gmail)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('mgermano578@gmail.com', 'Sistema de Votação');
        $mail->addAddress($para);

        // Conteúdo do e-mail
        $mail->isHTML(false);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        return false;
    }
}
?>