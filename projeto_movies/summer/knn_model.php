<?php
ini_set('memory_limit', '2048M');

function processaDados($filename): array
{
    $dados = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        fgetcsv($handle); 
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

function distanciaEuclidiana($a, $b): float
{
    return sqrt(pow($a['tempo_exibicao'] - $b['tempo_exibicao'], 2) +
                pow($a['num_votos'] - $b['num_votos'], 2));
}

function knn(array $dados, array $novo_filme, int $k): array
{
    foreach ($dados as $key => $filme) {
        $dados[$key]['distancia'] = distanciaEuclidiana($filme, $novo_filme);
    }

    usort($dados, function ($a, $b) {
        return $a['distancia'] <=> $b['distancia'];
    });

    $vizinhos = array_slice($dados, 0, $k);
    return $vizinhos;
}

function predicao(array $vizinhos): int
{
    $soma_avaliacoes = array_sum(array_column($vizinhos, 'avaliacao'));
    return $soma_avaliacoes / count($vizinhos);
}

function calculaPrecisao(array $dados, int $k): array
{
    $acertos = $total = 0;
    foreach ($dados as $filme) {
        $vizinhos = knn($dados, $filme, $k);
        $predicao = predicao($vizinhos);

        if (round($predicao) == round($filme['avaliacao'])) {
            $acertos++;
        }
        $total++;
    }

    $acuracia = $total > 0 ? $acertos / $total : 0;
    return [$acuracia, $acertos, $total];
}

$dados = processaDados('summer_movies.csv');
$k = 3; 
list($acuracia, $acertos, $total) = calculaPrecisao($dados, $k);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo KNN</title>
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
            <h1>Administração do Modelo de Precisão</h1>
            <nav>
                <ul>
                <li><a href="view_menu.php">Home</a></li>
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
        <h2>Métricas do Modelo KNN</h2>
            <h3>Acurácia: <?php echo round($acuracia * 100, 2) . '%'; ?></h3>
            <h3>Total de Filmes Avaliados: <?php echo $total; ?></h3>
            <h3>Acertos: <?php echo $acertos; ?></h3>
        </article>
    </div>

    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>

</body>
</html>
