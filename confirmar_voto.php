<?php
session_start();
require 'db.php';
require 'enviar_email.php';

if (!isset($_SESSION['matricula'], $_SESSION['nome'], $_SESSION['email'])) {
    die("Sessão inválida. Faça login novamente.");
}

if (!isset($_POST['candidato_id'])) {
    die("Candidato não selecionado.");
}

$candidato_id = intval($_POST['candidato_id']);
$matricula = $_SESSION['matricula'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$data = date('Y-m-d H:i:s');

// Verifica se o eleitor já votou
$stmt = $mysqli->prepare("SELECT id FROM votos WHERE matricula = ?");
$stmt->bind_param("s", $matricula);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("Você já votou.");
}

// Obtém dados do candidato
$stmt = $mysqli->prepare("SELECT presidente_nome, nome_chapa FROM chapas WHERE id = ?");
$stmt->bind_param("i", $candidato_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Candidato não encontrado.");
}
$candidato = $result->fetch_assoc();

// Registra o voto
$stmt = $mysqli->prepare("INSERT INTO votos (matricula, nome, email, candidato_id, data_voto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssds", $matricula, $nome, $email, $candidato_id, $data);
$stmt->execute();

// Envia e-mail de confirmação
$mensagem = "Confirmação de Voto\n\n".
            "Eleitor: $nome\n".
            "Matrícula: $matricula\n".
            "Data/Hora: $data\n".
            "Voto para Presidente: {$candidato['presidente_nome']}\n".
            "Chapa: {$candidato['nome_chapa']}\n\n".
            "Obrigado por participar da votação.";
            "Kurama agradece seu voto.";

enviarConfirmacaoEmail($email, "Confirmação de Voto - Kurama Sistema de Votação", $mensagem);

// Marca sessão e redireciona com confirmação
$_SESSION['votou'] = true;
if ($result->num_rows > 0) {
 echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Voto Confirmado</title>
        <link rel='stylesheet' href='css/votar.css'>
        <meta http-equiv='refresh' content='5;url=logout.php'>
        <style>
            .container {
                margin-top: 100px;
                text-align: center;
                font-family: Arial, sans-serif;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Seu voto está confirmado</h2>
            <p>Um email foi enviado para você com a confirmação do seu voto.</p>
            <p>Você será redirecionado para a página inicial em 5 segundos...</p>
        </div>
    </body>
    </html>";
    exit;
  }
?>
