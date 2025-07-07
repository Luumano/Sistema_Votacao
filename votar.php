<?php
session_start();
require 'db.php';

date_default_timezone_set('America/Fortaleza');

// Recupera as configurações de votação do banco
$config = $mysqli->query("SELECT * FROM configuracoes LIMIT 1")->fetch_assoc();

$inicio = strtotime($config['inicio_votacao']);
$fim = strtotime($config['fim_votacao']);
$agora = time();

if ($agora < $inicio) {
    // Ainda não começou
    die("<!DOCTYPE html>
    <html>
    <head>
    <meta charset='UTF-8'>
    <title>Votação</title>
    <link rel='stylesheet' href='css/votar.css'>
    </head>
    <body>
    <div class='container'>
        <h2>A votação ainda não começou</h2>
        <p>Ela começará em <strong>" . date('d/m/Y \à\s H:i', $inicio) . "</strong>.</p>
    </div>
    </body>
    </html>");
}

if ($agora > $fim) {
    // Já encerrou
    die("<!DOCTYPE html>
    <html>
    <head>
    <meta charset='UTF-8'>
    <title>Votação Encerrada</title>
    <link rel='stylesheet' href='css/votar.css'>
    </head>
    <body>
    <div class='container'>
        <h2>A votação foi encerrada</h2>
        <p>Ela encerrou em <strong>" . date('d/m/Y \à\s H:i', $fim) . "</strong>.</p>
    </div>
    </body>
    </html>");
}

// Carrega os candidatos
$candidatos = $mysqli->query("SELECT * FROM chapas");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    if (!str_ends_with($email, '@alu.ufc.br')) {
        die("Email inválido. Use um email institucional @alu.ufc.br.");
    }

    $_SESSION['matricula'] = $matricula;
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;

    $stmt = $mysqli->prepare("SELECT * FROM votos WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Votação - Já votou</title>
            <link rel='stylesheet' href='css/votar.css'>
            <meta http-equiv='refresh' content='10;url=index.php'>
            <style>
                .container {
                    margin-top: 100px;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Você já votou</h2>
                <p>Você será redirecionado para a página inicial em 5 segundos...</p>
            </div>
        </body>
        </html>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Votar - Sistema de Votação</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/votar.css">
</head>
<body>
  <div class="container">
    <h2>Escolha seu candidato</h2>
    <form id="formVoto" action="confirmar_voto.php" method="POST" onsubmit="return confirmarVoto();">
      <?php while ($row = $candidatos->fetch_assoc()): ?>
        <div class="card">
          <img src="chapa_img/<?php echo $row['foto_chapa']; ?>" width="100%">
          <p>Presidente: <?php echo $row['presidente_nome']; ?></p>
          <p>Chapa: <?php echo $row['nome_chapa']; ?></p>
          <input type="radio" name="candidato_id" value="<?php echo $row['id']; ?>" required>
        </div>
      <?php endwhile; ?>
      <button type="submit">Confirmar Voto</button>
      <a href="logout.php" class="btn">Sair</a>
    </form>
  </div>
  <script src="js/votar.js"></script>
</body>
</html>
