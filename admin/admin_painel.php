<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$candidatos = $mysqli->query("SELECT c.id, c.presidente_nome, c.nome_chapa, c.foto_chapa, COUNT(v.id) as votos FROM chapas c LEFT JOIN votos v ON c.id = v.candidato_id GROUP BY c.id");
$total_votos = $mysqli->query("SELECT COUNT(*) as total FROM votos")->fetch_assoc()['total'] ?? 0;

// Para o gráfico
$labels = [];
$data = [];
while ($c = $candidatos->fetch_assoc()) {
    $labels[] = $c['nome_chapa'];
    $data[] = $c['votos'];
    $cards[] = $c; // armazenar para exibir abaixo
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Painel do Admin</title>
    <link rel="stylesheet" href="../css/painel.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Painel do Administrador</h2>
        <p>Bem-vindo, <strong><?php echo $_SESSION['admin']; ?></strong>!</p>
        <a href="admin_logout.php" class="sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
<?php
// Buscar configuração atual
$config = $mysqli->query("SELECT * FROM configuracoes LIMIT 1")->fetch_assoc();
?>

<h3>Configurar Período de Inscrição e Votação</h3>
<form method="POST">
    <label>Início das Inscrições:</label>
    <input type="datetime-local" name="inicio_inscricao" value="<?php echo $config['inicio_inscricao'] ? date('Y-m-d\TH:i', strtotime($config['inicio_inscricao'])) : ''; ?>" required>

    <label>Fim das Inscrições:</label>
    <input type="datetime-local" name="fim_inscricao" value="<?php echo $config['fim_inscricao'] ? date('Y-m-d\TH:i', strtotime($config['fim_inscricao'])) : ''; ?>" required>

    <label>Início da Votação:</label>
    <input type="datetime-local" name="inicio_votacao" value="<?php echo $config['inicio_votacao'] ? date('Y-m-d\TH:i', strtotime($config['inicio_votacao'])) : ''; ?>" required>

    <label>Fim da Votação:</label>
    <input type="datetime-local" name="fim_votacao" value="<?php echo $config['fim_votacao'] ? date('Y-m-d\TH:i', strtotime($config['fim_votacao'])) : ''; ?>" required>

    <button type="submit" name="salvar_config">Salvar Configurações</button>
</form>

<?php
// Atualizar configurações
if (isset($_POST['salvar_config'])) {
    $stmt = $mysqli->prepare("UPDATE configuracoes SET inicio_inscricao = ?, fim_inscricao = ?, inicio_votacao = ?, fim_votacao = ? WHERE id = 1");
    $stmt->bind_param("ssss", $_POST['inicio_inscricao'], $_POST['fim_inscricao'], $_POST['inicio_votacao'], $_POST['fim_votacao']);
    $stmt->execute();
    echo "<script>alert('Períodos atualizados com sucesso!');</script>";
}
?>

        <div id="chart-container">
            <canvas id="graficoVotos"></canvas>
        </div>

        <div>
        <?php foreach ($cards as $c): ?>
            <div class="card">
                <img src="../chapa_img/<?php echo $c['foto_chapa']; ?>">
                <p>Presidente: <?php echo $c['presidente_nome']; ?></p>
                <p>Chapa: <?php echo $c['nome_chapa']; ?></p>
                <?php 
                    $votos = $c['votos'];
                    $porcentagem = $total_votos > 0 ? ($votos / $total_votos) * 100 : 0;
                ?>
                <p>Votos: <?php echo $votos; ?> (<?php echo number_format($porcentagem, 2); ?>%)</p>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficoVotos');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Distribuição de Votos',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: [
                        '#0074D9', '#FF4136', '#2ECC40', '#FF851B', '#B10DC9',
                        '#7FDBFF', '#39CCCC', '#01FF70', '#85144b', '#F012BE'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Votos por Candidato'
                    }
                }
            }
        });
    </script>
        <script src="https://kit.fontawesome.com/22a4a36307.js" crossorigin="anonymous"></script>
</body>
</html>
