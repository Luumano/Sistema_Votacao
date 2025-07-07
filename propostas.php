<?php
require 'db.php';

$chapas = $mysqli->query("SELECT DISTINCT nome_chapa FROM chapas ORDER BY nome_chapa");

$chapaSelecionada = $_GET['nome_chapa'] ?? null;
$proposta = null;

if ($chapaSelecionada) {
  $stmt = $mysqli->prepare("SELECT nome_chapa, presidente_nome, proposta, foto_chapa FROM chapas WHERE nome_chapa = ?");
  $stmt->bind_param("s", $chapaSelecionada);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $proposta = $resultado->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Propostas das Chapas</title>
  <link rel="stylesheet" href="css/propostas.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h2>Propostas das Chapas</h2>

    <form method="GET" action="propostas.php">
      <select name="nome_chapa" required onchange="this.form.submit()">
        <option value="">-- Selecione uma Chapa --</option>
        <?php while ($row = $chapas->fetch_assoc()): ?>
          <option value="<?php echo $row['nome_chapa']; ?>" <?php echo ($row['nome_chapa'] == $chapaSelecionada) ? 'selected' : ''; ?>>
            <?php echo $row['nome_chapa']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </form>

    <?php if ($proposta): ?>
      <div class="card">
        <img src="chapa_img/<?php echo $proposta['foto_chapa']; ?>" alt="Foto da chapa">
        <div class="card-content">
          <h3><?php echo $proposta['presidente_nome']; ?> <br><small>Chapa <?php echo $proposta['nome_chapa']; ?></small></h3>
          <p><strong>Proposta:</strong></p>
          <p><?php echo nl2br($proposta['proposta']); ?></p>
        </div>
      </div>
    <?php elseif ($chapaSelecionada): ?>
      <p class="erro">Nenhuma proposta encontrada para a chapa selecionada.</p>
    <?php endif; ?>

    <a href="index.php" class="voltar">Voltar</a>
  </div>
</body>
</html>
