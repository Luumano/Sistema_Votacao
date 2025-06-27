<?php
session_start();
if (isset($_SESSION['votou'])) {
  header("Location: votar.php");
  exit();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login - Sistema de Votação do Centro Acadêmico</title>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="container">
    <h2><i class="fa-solid fa-check-to-slot"></i> Login do Eleitor</h2>
    <form action="votar.php" method="POST">
      <label for="matricula"><i class="fa-solid fa-shield"></i> Matricula:</label>
      <input type="text" name="matricula" placeholder="Matrícula" required>
      <label for="nome"><i class="fa-regular fa-circle-user"></i> Nome Completo:</label>
      <input type="text" name="nome" placeholder="Nome completo" required>
      <label for="institucional"><i class="fa-solid fa-envelope"></i> Email Institucional:</label>
      <input type="email" name="email" placeholder="Email institucional (@alu.ufc.br)" required>
      <button type="submit"><i class="fa-solid fa-right-to-bracket"></i> Entrar</button>
    </form>
              <!-- Adicione este botão abaixo do formulário -->
 <a href="propostas.php" class="btn-proposta">Ver Propostas dos Candidatos</a>
<a href="registrar_chapa.php" class="btn-cadastrar"><i class="fa-solid fa-arrow-left"></i> Cadastrar Chapa</a>
<a href="login_editar_chapa.php" class="btn-editar"><i class="fa-solid fa-user-pen"></i> Editar Chapa</a>
<a href="apuracao.php" class="btn-resultado"><i class="fa-solid fa-chart-line"></i> Ver Apuração</a>

  </div>
    <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>