<?php
$mysqli = new mysqli("localhost", "root", "", "sistema_votacao");
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}
?>