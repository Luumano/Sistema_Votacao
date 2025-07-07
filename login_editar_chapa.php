<?php
session_start();
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_chapa = $_POST['nome_chapa'];
    $senha = $_POST['senha'];

    // Buscar a hash da senha da chapa
    $stmt = $mysqli->prepare("SELECT id, senha FROM chapas WHERE nome_chapa = ?");
    $stmt->bind_param("s", $nome_chapa);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($chapa_id, $senha_hash);
        $stmt->fetch();

        // Verifica a senha digitada com o hash
        if (password_verify($senha, $senha_hash)) {
            $_SESSION['chapa_id'] = $chapa_id;
            header("Location: editar_chapa.php");
            exit();
        } else {
            $erro = "Nome da chapa ou senha incorretos.";
        }
    } else {
        $erro = "Nome da chapa ou senha incorretos.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Login para Edição de Chapa</title>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
</head>
<body>
<div class="container">
    <h2><i class="fa-solid fa-user-pen"></i> Acesso à Edição da Chapa</h2>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <form method="POST">
        <label>Nome da Chapa:</label>
        <input type="text" name="nome_chapa" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Entrar</button>
    </form>
    <a href="index.php" class="voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
</div>
<script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>
