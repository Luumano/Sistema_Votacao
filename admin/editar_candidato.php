
<!-- admin/editar_candidato.php -->
<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$id = $_GET['id'];
$candidato = $mysqli->query("SELECT * FROM candidatos WHERE id = $id")->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $chapa = $_POST['chapa'];
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../img/" . $foto);
        $stmt = $mysqli->prepare("UPDATE candidatos SET nome=?, foto=?, chapa=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $foto, $chapa, $id);
    } else {
        $stmt = $mysqli->prepare("UPDATE candidatos SET nome=?, chapa=? WHERE id=?");
        $stmt->bind_param("ssi", $nome, $chapa, $id);
    }
    $stmt->execute();
    header("Location: admin_painel.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Candidato</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Editar Candidato</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" value="<?php echo $candidato['nome']; ?>" required>
            <input type="text" name="chapa" value="<?php echo $candidato['chapa']; ?>" required>
            <p>Foto atual:</p>
            <img src="../img/<?php echo $candidato['foto']; ?>" width="100px"><br>
            <input type="file" name="foto" accept="image/*">
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>