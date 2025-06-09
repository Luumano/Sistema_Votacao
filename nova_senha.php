<?php
require 'db.php';


$token = $_GET['token'] ?? '';
$novaSenha = $_POST['senha'] ?? '';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token) {
    $stmt = $mysqli->prepare("SELECT id, token_expira FROM chapas WHERE token_recuperacao = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $chapa = $result->fetch_assoc();

    if ($chapa && strtotime($chapa['token_expira']) > time()) {
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE chapas SET senha = ?, token_recuperacao = NULL, token_expira = NULL WHERE id = ?");
        $stmt->bind_param("si", $hash, $chapa['id']);
        $stmt->execute();
        $mensagem = "Senha redefinida com sucesso.";
    } else {
        $mensagem = "Token inválido ou expirado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nova Senha</title>
    <link rel="stylesheet" href="css/auth.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Redefinir Senha</h2>
    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
        <a href="login_chapa.php">Ir para login</a>
    <?php elseif ($token): ?>
        <form method="POST">
            <label>Nova Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Atualizar Senha</button>
        </form>
    <?php else: ?>
        <p>Token inválido.</p>
    <?php endif; ?>
</body>
</html>
