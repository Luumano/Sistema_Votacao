<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $foto = $_FILES['foto']['name'];
    $chapa = $_POST['chapa'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/" . $foto);
    $stmt = $mysqli->prepare("INSERT INTO candidatos (nome, foto, chapa) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $foto, $chapa);
    $stmt->execute();
    header("Location: admin_painel.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Candidato</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-address-card"></i> Adicionar Candidato</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nome_candidato"><i class="fa-solid fa-user"></i> Nome do Presidente:</label>
            <input type="text" name="nome" placeholder="Nome do candidato" required>
            <label for="imagem"><i class="fa-solid fa-file"></i> Imagem da Chapa:</label>
            <input type="file" name="foto" accept="image/*" required>
            <label for="nome_chapa"><i class="fa-solid fa-users-line"></i> Nome da Chapa:</label>
            <input type="text" name="chapa" placeholder="Nome da Chapa" required>
            <button type="submit">Adicionar</button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>
