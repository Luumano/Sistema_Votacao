<?php
session_start();
require '../db.php'; // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $mysqli->prepare("SELECT * FROM adm WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        if (password_verify($senha, $admin['senha'])) {
            $_SESSION['admin'] = $admin['usuario']; // salva nome
            header("Location: admin_painel.php");
            exit();
        }
    }
    $erro = "Login inválido.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-users-rectangle"></i> Login do Administrador</h2>
        <?php if (isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>
        <form method="POST">
            <label for="usuario"><i class="fa-solid fa-user-secret"></i> Usuário:</label>
            <input type="text" name="usuario" required>
            <label for="senha"><i class="fa-solid fa-lock"></i> Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
        <a href="cadastro_admin.php">Cadastrar CA</a>
    </div>
    <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>
