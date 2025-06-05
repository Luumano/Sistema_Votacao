<?php
session_start();
require '../db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Segurança

    $stmt = $mysqli->prepare("INSERT INTO adm (usuario, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();

    header("Location: admin_painel.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Administrador</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-user-plus"></i> Cadastrar Novo Administrador</h2>
        <form method="POST">
            <label for="usuario"><i class="fa-solid fa-user"></i> Usuário:</label>
            <input type="text" name="usuario" required>
            <label for="senha"><i class="fa-solid fa-lock"></i> Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>
