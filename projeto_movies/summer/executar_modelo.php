<?php
ini_set('memory_limit', '2048M');

function processaDados(): array
{
    $filename = 'summer_movies.csv';
    $dados = [];

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        fgetcsv($handle); // Ignora o cabeçalho
        while (($data = fgetcsv($handle)) !== FALSE) {
            $dados[] = [
                'titulo' => $data[2],
                'avaliacao' => (float) $data[9],
                'tempo_exibicao' => (float) $data[5]
            ];
        }
        fclose($handle);
    }
    return $dados;
}

function calculaMedia(): array
{
    $dados = processaDados();
    $tempo_intervalos = [];

    foreach ($dados as $filme) {
        $tempo = round($filme['tempo_exibicao']);
        if (!isset($tempo_intervalos[$tempo])) {
            $tempo_intervalos[$tempo] = ['soma_avaliacoes' => 0, 'count' => 0];
        }
        $tempo_intervalos[$tempo]['soma_avaliacoes'] += $filme['avaliacao'];
        $tempo_intervalos[$tempo]['count']++;
    }

    return array_map(function ($valores) {
        return $valores['soma_avaliacoes'] / $valores['count'];
    }, $tempo_intervalos);
}

function tempoIdealExibicao(): array
{
    $medias_avaliacoes = calculaMedia();
    return array_keys($medias_avaliacoes, max($medias_avaliacoes));
}

function predicaoAvaliacao(float $tempo_exibicao, array $melhor_tempo): int
{
    return in_array(round($tempo_exibicao), $melhor_tempo) ? 1 : 0;
}

function avaliarPrecisao(): float
{
    $dados = processaDados();
    $melhor_tempo = tempoIdealExibicao();
    $labels = [];
    $predictions = [];

    foreach ($dados as $filme) {
        $labels[] = $filme['avaliacao'] > 4000 ? 1 : 0;  
        $predictions[] = predicaoAvaliacao($filme['tempo_exibicao'], $melhor_tempo);
    }

    return precisao($labels, $predictions);
}

function precisao(array $labels, array $predictions): float
{
    $corretos = array_sum(array_map(function ($label, $prediction) {
        return $label === $prediction ? 1 : 0;
    }, $labels, $predictions));

    return $corretos / count($labels);
}

function calculaAcuraciaEPrecisao(array $dados): array
{
    $labels = [];
    $predictions = [];
    foreach ($dados as $filme) {
        $labels[] = $filme['avaliacao'] > 4000 ? 1 : 0;  
        $predictions[] = predicaoAvaliacao($filme['tempo_exibicao'], tempoIdealExibicao());
    }

    $true_positives = $true_negatives = $false_positives = $false_negatives = 0;

    foreach ($labels as $i => $label) {
        if ($label == 1 && $predictions[$i] == 1) {
            $true_positives++;
        } elseif ($label == 0 && $predictions[$i] == 0) {
            $true_negatives++;
        } elseif ($label == 0 && $predictions[$i] == 1) {
            $false_positives++;
        } elseif ($label == 1 && $predictions[$i] == 0) {
            $false_negatives++;
        }
    }

    $accuracy = ($true_positives + $true_negatives) / count($labels);
    $precision = $true_positives ? $true_positives / ($true_positives + $false_positives) : 0;

    return [$accuracy, $precision];
}

$dados = processaDados();
$tempo_ideal = tempoIdealExibicao();
$precisao = round(avaliarPrecisao(), 2);
list($accuracy, $precision) = calculaAcuraciaEPrecisao($dados);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executar Modelo</title>
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
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77d7ff 3px solid;
        }

        header a,
        header h1 {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        nav ul {
            padding: 0;
            list-style: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
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
        <div class="container">
            <h1>Executar Modelo</h1>
            <nav>
                <ul>
                <li><a href="executar_modelo.php">Executar Modelo</a></li>
                    <li><a href="arvore_decisao.php">Avaliação de Filmes</a></li>
                    <li><a href="knn_form.php">Classificação de Filmes com KNN</a></li>
                    <li><a href="knn_model.php">Avaliação Modelo KNN</a></li><br><br>
                    <li><a href="view_graficos.php">Menu graficos</a></li>
                    <li><a href="view_basedados.php">Base de dados</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <article>
            <h1>Métricas do Modelo</h1>
            <h3>Tempo ideal de exibição: <?php echo implode(', ', $tempo_ideal); ?> minutos</h3>
            <h3>A precisão do modelo é: <?php echo ($precisao * 100) . "%"; ?></h3>
            <h3>Acurácia: <?php echo round($accuracy * 100, 2); ?>%</h3>
            <h2>Gráfico de Regressão Linear</h2>
            <img src="regressao_linear.php" alt="Gráfico de Regressão Linear">
        </article>
    </div>
    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>
</body>
</html>
