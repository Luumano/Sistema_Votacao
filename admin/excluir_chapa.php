<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Remove imagem do servidor, se existir
    $query = $mysqli->prepare("SELECT foto FROM candidatos WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $candidato = $result->fetch_assoc();

    if ($candidato && file_exists("../img/" . $candidato['foto'])) {
        unlink("../img/" . $candidato['foto']);
    }

    // Deleta do banco
    $stmt = $mysqli->prepare("DELETE FROM candidatos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin_painel.php");
exit();
