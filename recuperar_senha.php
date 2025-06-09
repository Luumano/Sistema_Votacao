<?php
require 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("SELECT id FROM chapas WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $token = bin2hex(random_bytes(16));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $mysqli->prepare("UPDATE chapas SET token_recuperacao = ?, token_expira = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expira, $email);
        $stmt->execute();

        // URL com o token
        $link = "http://localhost/sistema_votacao/nova_senha.php?token=" . $token;

        // Envia o e-mail com PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mgermano578@gmail.com';           // seu e-mail Gmail
            $mail->Password   = 'bjmhrjsijxdlwdfz';      // sua senha de aplicativo
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remetente e destinatário
            $mail->setFrom('mgermano578@gmail.com', 'Sistema de Votação');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha - Sistema de Votação Kurama';
            $mail->Body    = "Olá!<br><br>Aqui está o email para redefinição da sua senha.<br><br>Clique no link abaixo para redefinir sua senha:<br><br>
                             <a href='$link'>$link</a><br><br>
                             Este link expira em 1 hora.";

            $mail->send();
            echo "<script>alert('Verifique seu e-mail para redefinir sua senha.'); window.location='index.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Erro ao enviar e-mail: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('E-mail não encontrado.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css/auth.css">
    <meta charset="UTF-8">
</head>
<body>
    <div class="container">
        <h2>Recuperar Senha</h2>
        <form method="POST">
            <label>Informe o e-mail cadastrado:</label>
            <input type="email" name="email" required>
            <button type="submit">Enviar Link</button>
        </form>
    </div>
</body>
</html>
