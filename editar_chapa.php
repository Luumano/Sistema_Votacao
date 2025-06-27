<?php
require 'db.php';
session_start();

// Verifica se o ID da chapa está na sessão
$chapa_id = $_SESSION['chapa_id'] ?? null;

if (!$chapa_id) {
    echo "Você não tem permissão para editar esta chapa.";
    exit();
}

// Busca os dados da chapa
$stmt = $mysqli->prepare("SELECT * FROM chapas WHERE id = ?");
$stmt->bind_param("i", $chapa_id);
$stmt->execute();
$result = $stmt->get_result();
$chapa = $result->fetch_assoc();

if (!$chapa) {
    echo "Chapa não encontrada.";
    exit();
}

// Busca os membros da chapa
$stmt = $mysqli->prepare("SELECT * FROM membros WHERE chapa_id = ?");
$stmt->bind_param("i", $chapa_id);
$stmt->execute();
$result_membros = $stmt->get_result();
$membros = $result_membros->fetch_all(MYSQLI_ASSOC);

// Verifica tempo limite para edição (48h)
if (!isset($chapa['data_criacao']) || empty($chapa['data_criacao'])) {
    echo "Erro: data de criação da chapa não encontrada.";
    exit();
}

$timestamp_criacao = strtotime($chapa['data_criacao']);

if ($timestamp_criacao === false) {
    echo "Erro: formato inválido da data de criação.";
    exit();
}

$tempo_limite = $timestamp_criacao + (48 * 3600);
if (time() > $tempo_limite) {
    echo "O prazo para editar a chapa expirou.";
    exit();
}

// Função auxiliar para salvar imagem de forma segura
function salvarImagem($file, $diretorio) {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nomeSeguro = uniqid() . "." . $ext;
    $caminho = $diretorio . "/" . $nomeSeguro;
    $tipo = mime_content_type($file['tmp_name']);

    $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($tipo, $permitidos)) {
        return false;
    }

    if (move_uploaded_file($file['tmp_name'], $caminho)) {
        return $nomeSeguro;
    }
    return false;
}

// Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = trim($_POST['nome_chapa']);
    $novo_presidente = trim($_POST['presidente_nome']);
    $nova_proposta = trim($_POST['proposta']);

    // Atualiza a foto se houver nova
    if (!empty($_FILES['presidente_foto']['name'])) {
        $nova_foto = salvarImagem($_FILES['presidente_foto'], "img");
        if (!$nova_foto) {
            echo "<script>alert('Erro ao enviar a nova foto. Formato inválido.'); window.history.back();</script>";
            exit();
        }
    } else {
        $nova_foto = $chapa['presidente_foto'];
    }

    // Atualiza no banco
    $stmt = $mysqli->prepare("UPDATE chapas SET nome_chapa = ?, presidente_nome = ?, presidente_foto = ?, proposta = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $novo_nome, $novo_presidente, $nova_foto, $nova_proposta, $chapa_id);
    $stmt->execute();

    echo "<script>alert('Chapa atualizada com sucesso!'); window.location.href = 'index.php';</script>";
    exit();
}
if (isset($_POST['membros'])) {
    foreach ($_POST['membros'] as $membro_id => $dados_membro) {
        $nome_membro = trim($dados_membro['nome']);
        $foto_membro = $membros[array_search($membro_id, array_column($membros, 'id'))]['foto']; // Foto atual

        // Verifica se foi enviada nova foto
        if (!empty($_FILES['membros']['name'][$membro_id]['foto'])) {
            $file = [
                'name' => $_FILES['membros']['name'][$membro_id]['foto'],
                'type' => $_FILES['membros']['type'][$membro_id]['foto'],
                'tmp_name' => $_FILES['membros']['tmp_name'][$membro_id]['foto'],
                'error' => $_FILES['membros']['error'][$membro_id]['foto'],
                'size' => $_FILES['membros']['size'][$membro_id]['foto'],
            ];

            $nova_foto = salvarImagem($file, "img");
            if ($nova_foto) {
                $foto_membro = $nova_foto;
            }
        }

        $stmt = $mysqli->prepare("UPDATE membros_chapa SET nome = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome_membro, $foto_membro, $membro_id);
        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Chapa</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        img {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Editar Chapa</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nome da Chapa:</label>
        <input type="text" name="nome_chapa" value="<?php echo htmlspecialchars($chapa['nome_chapa']); ?>" required>
        
        <label>Nome do Presidente:</label>
        <input type="text" name="presidente_nome" value="<?php echo htmlspecialchars($chapa['presidente_nome']); ?>" required>

        <label>Foto Atual do Presidente:</label><br>
        <img src="img/<?php echo htmlspecialchars($chapa['presidente_foto']); ?>" width="150"><br>

        <label>Nova Foto (opcional):</label>
        <input type="file" name="presidente_foto" accept="image/*">

        <label>Proposta:</label>
        <textarea name="proposta" rows="5" required><?php echo htmlspecialchars($chapa['proposta']); ?></textarea>

        <h3>Membros da Chapa</h3>
        <?php foreach ($membros as $index => $membro): ?>
            <div style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                <label>Nome do Membro <?php echo $index + 1; ?>:</label>
                <input type="text" name="membros[<?php echo $membro['id']; ?>][nome]" 
                    value="<?php echo htmlspecialchars($membro['nome']); ?>" required>

                <label>Foto Atual:</label><br>
                <img src="membros_img/<?php echo htmlspecialchars($membro['foto']); ?>" width="100"><br>

                <label>Nova Foto (opcional):</label>
                <input type="file" name="membros[<?php echo $membro['id']; ?>][foto]" accept="image/*">
            </div>
        <?php endforeach; ?>


        <button type="submit">Salvar Alterações</button>
        <a href="index.php" class="voltar">Cancelar</a>
    </form>
</div>
</body>
</html>
