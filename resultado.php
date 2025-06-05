<?php
require 'db.php';

// Consulta os candidatos com número de votos
$result = $mysqli->query("SELECT c.chapa, COUNT(v.id) AS votos FROM candidatos c LEFT JOIN votos v ON c.id = v.candidato_id GROUP BY c.id");

// Armazenar dados para gráfico
$candidatos = [];
$votos = [];
$total_votos = 0;

while ($row = $result->fetch_assoc()) {
    $candidatos[] = $row['chapa'];
    $votos[] = (int)$row['votos'];
    $total_votos += $row['votos'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Votação</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #003366, #0055a5);
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: white;
            color: #333;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        canvas {
            margin-top: 30px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            font-size: 18px;
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Resultado da Votação</h2>
        <p>Total de votos: <strong><?= $total_votos ?></strong></p>
        
        <ul>
            <?php foreach ($candidatos as $index => $nome): 
                $percent = $total_votos > 0 ? ($votos[$index] / $total_votos) * 100 : 0;
            ?>
                <li><?= htmlspecialchars($nome) ?>: <?= $votos[$index] ?> votos (<?= number_format($percent, 2) ?>%)</li>
            <?php endforeach; ?>
        </ul>

        <canvas id="grafico"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafico').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($candidatos) ?>,
                datasets: [{
                    data: <?= json_encode($votos) ?>,
                    backgroundColor: [
                        '#007BFF', '#FFC107', '#28A745', '#DC3545', '#6610f2', '#fd7e14'
                    ],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let total = <?= $total_votos ?>;
                                let value = context.raw;
                                let percent = (value / total * 100).toFixed(2);
                                return context.label + ': ' + value + ' votos (' + percent + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
