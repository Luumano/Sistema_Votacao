<?php
header('Content-Type: application/json');
require 'db.php';

$result = $mysqli->query("SELECT nome_chapa, presidente_nome, foto_chapa, COUNT(*) as votos FROM votos  JOIN chapas ON votos.candidato_id = chapas.id  GROUP BY candidato_id");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
