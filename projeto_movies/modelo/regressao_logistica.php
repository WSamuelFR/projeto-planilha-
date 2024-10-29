<?php
ini_set('memory_limit', '2048M');

function processaDados($filename): array
{
    $dados = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        fgetcsv($handle); // Ignora o cabeçalho
        while (($data = fgetcsv($handle)) !== FALSE) {
            $dados[] = [
                'tconst' => $data[0],
                'titulo' => $data[2],
                'tempo_exibicao' => (int)$data[5],
                'avaliacao' => (float)$data[8],
                'num_votos' => (int)$data[9]
            ];
        }
        fclose($handle);
    }
    return $dados;
}

function sigmoid($z): float
{
    return 1 / (1 + exp(-$z));
}

function regressaoLogistica(array $dados, float $alpha, int $iteracoes): array
{
    $n = count($dados);
    $peso = [0, 0]; // pesos para tempo de exibição e número de votos
    $predicoes = [];

    // Treinamento do modelo
    for ($i = 0; $i < $iteracoes; $i++) {
        foreach ($dados as $filme) {
            $z = $peso[0] * $filme['tempo_exibicao'] + $peso[1] * $filme['num_votos'];
            $predicao = sigmoid($z);
            $erro = $filme['avaliacao'] - $predicao;

            // Atualiza os pesos
            $peso[0] += $alpha * $erro * $filme['tempo_exibicao'];
            $peso[1] += $alpha * $erro * $filme['num_votos'];

            $predicoes[] = $predicao;
        }
    }

    return [$peso, $predicoes];
}

function calculaPrecisao(array $dados, array $predicoes): float
{
    $acertos = 0;
    $total = count($dados);

    foreach ($dados as $i => $filme) {
        if (round($predicoes[$i]) == round($filme['avaliacao'])) {
            $acertos++;
        }
    }

    return $total > 0 ? $acertos / $total : 0;
}

$dados = processaDados('summer_movies.csv');
$alpha = 0.01; // taxa de aprendizado
$iteracoes = 1000; // número de iterações

list($peso, $predicoes) = regressaoLogistica($dados, $alpha, $iteracoes);
$precisao = round(calculaPrecisao($dados, $predicoes) * 100, 2);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regressão Logística</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 30px 0;
            text-align: center;
        }
        article {
            padding: 20px;
            background: #fff;
            border: #77d7ff 1px solid;
            margin-top: 20px;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Regressão Logística</h1>
    </header>
    <div class="container">
        <article>
            <h2>Resultados do Modelo</h2>
            <h3>Precisão: <?php echo $precisao . '%'; ?></h3>
            <h3>Peso para Tempo de Exibição: <?php echo round($peso[0], 4); ?></h3>
            <h3>Peso para Número de Votos: <?php echo round($peso[1], 4); ?></h3>
        </article>
        <article>
            <h2>Gráfico da Regressão Logística</h2>
            <img src="grafico_regressao.php" alt="Gráfico de Regressão Logística">
        </article>
    </div>
    <footer>
        <p>&copy; 2024 Regressão Logística</p>
    </footer>
</body>
</html>
