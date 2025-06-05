<?php
require 'db.php';

// Verifica se o período de inscrição está ativo
$config = $mysqli->query("SELECT * FROM configuracoes LIMIT 1")->fetch_assoc();
$agora = date('Y-m-d H:i:s');

if ($agora < $config['inicio_inscricao'] || $agora > $config['fim_inscricao']) {
    echo "<script>alert('O período de inscrição de chapas está encerrado ou ainda não começou.'); window.location.href = 'index.php';</script>";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chapa_nome = $_POST['chapa_nome'];
    $presidente_nome = $_POST['presidente_nome'];
    $proposta = $_POST['proposta'];
    $senha_plana = $_POST['senha'];
    $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

    // Upload da imagem do presidente
    $presidente_foto = $_FILES['presidente_foto']['name'];
    move_uploaded_file($_FILES['presidente_foto']['tmp_name'], "img/" . $presidente_foto);

    //upload da imagem da chapa
    $chapa_foto = $_FILES['chapa_foto']['name'];
    move_uploaded_file($_FILES['chapa_foto']['tmp_name'], "chapa_img/" . $chapa_foto);

    // Inserir a chapa
    $stmt = $mysqli->prepare("INSERT INTO chapas (nome_chapa, presidente_nome, presidente_foto, proposta, foto_chapa, senha) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $chapa_nome, $presidente_nome, $presidente_foto, $proposta, $chapa_foto, $senha_hash);
    $stmt->execute();
    $chapa_id = $mysqli->insert_id;

    foreach ($_POST['membro_nome'] as $index => $nome) {
        $diretoria = $_POST['membro_diretoria'][$index];
        $foto_nome = $_FILES['membro_foto']['name'][$index];
        $foto_tmp = $_FILES['membro_foto']['tmp_name'][$index];
        move_uploaded_file($foto_tmp, "membros_img/" . $foto_nome);

        $stmt = $mysqli->prepare("INSERT INTO membros (chapa_id, nome, foto, diretoria) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $chapa_id, $nome, $foto_nome, $diretoria);
        $stmt->execute();
    }


    echo "<script>alert('Chapa registrada com sucesso!'); window.location.href = 'index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrar Chapa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registrar.css">
    <style>
      .membro { margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Registrar Nova Chapa</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nome da Chapa:</label>
        <input type="text" name="chapa_nome" required>
        
        <label>Nome do Presidente:</label>
        <input type="text" name="presidente_nome" required>

        <label>Foto do Presidente:</label>
        <input type="file" name="presidente_foto" accept="image/*" required>

        <label>Senha para Edição:</label>
        <input type="password" name="senha" required placeholder="Senha para edição futura">

        <label>Foto da chapa:</label>
        <input type="file" name="chapa_foto" accept="image/*" required>

        <label>Proposta da Chapa:</label>
        <textarea name="proposta" rows="5" required></textarea>

        <h3>Membros da Equipe</h3>
         <div class="membro">
            <label>Nome do Membro:</label>
            <input type="text" name="membro_nome[]" placeholder="Nome do Membro" required>
            <label for="foto">Foto do membro da equipe</label>
            <input type="file" name="membro_foto[]" accept="image/*" required>
            <select name="membro_diretoria[]" required>
                <option value="">Selecione a Diretoria</option>
                <option value="Vice-Presidente">Vice-Presidente</option>
                <option value="Secretário">Secretário</option>
                <option value="Diretor Financeiro">Diretor Financeiro</option>
                <option value="Diretor de Comunicação">Diretor de Comunicação</option>
                <option value="Diretor de Eventos">Diretor de Eventos</option>
                <option value="Diretor Acadêmico">Diretor Acadêmico</option>
            </select>
        </div>
        <!-- Novo contêiner para membros adicionais -->
        <div id="membros"></div>

        <button type="button" onclick="adicionarMembro()">+ Adicionar Membro</button>
        <button type="submit">Registrar Chapa</button>
        <a href="index.php" class="voltar">Voltar</a>
    </form>
</div>
    <script src="js/registrar.js"></script>
</body>
</html>
