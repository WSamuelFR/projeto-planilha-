<?php

require('calcula_runtime.php');

function gini_impurity($rows)
{
    $counts = array_count_values(array_map('strval', array_column($rows, 'avaliacao'))); // Converte valores para string
    $impurity = 1;
    foreach ($counts as $count) {
        $prob_of_lbl = $count / count($rows);
        $impurity -= $prob_of_lbl * $prob_of_lbl;
    }
    return $impurity;
}

function information_gain($left, $right, $current_uncertainty)
{
    $p = count($left) / (count($left) + count($right));
    return $current_uncertainty - $p * gini_impurity($left) - (1 - $p) * gini_impurity($right);
}

function find_best_split($data)
{
    $best_gain = 0;
    $best_split = null;
    $current_uncertainty = gini_impurity($data);
    foreach ($data as $row) {
        $threshold = $row['tempo_exibicao'];
        $true_rows = array_filter($data, function ($d) use ($threshold) {
            return $d['tempo_exibicao'] > $threshold; });
        $false_rows = array_filter($data, function ($d) use ($threshold) {
            return $d['tempo_exibicao'] <= $threshold; });
        if (count($true_rows) == 0 || count($false_rows) == 0)
            continue;
        $gain = information_gain($true_rows, $false_rows, $current_uncertainty);
        if ($gain > $best_gain) {
            $best_gain = $gain;
            $best_split = [
                'question' => $threshold,
                'true' => $true_rows,
                'false' => $false_rows
            ];
        }
    }
    return $best_split;
}

function most_common_label($labels)
{
    $values = array_count_values(array_map('strval', $labels)); // Converte valores para string
    arsort($values);
    return array_key_first($values);
}

function build_tree($data, $depth = 0)
{
    if (empty($data)) {
        return null;
    }
    $labels = array_column($data, 'avaliacao');
    if (count(array_unique($labels)) === 1) {
        return $labels[0];
    }
    $best_split = find_best_split($data);
    if (!$best_split) {
        return most_common_label($labels);
    }
    $true_branch = build_tree($best_split['true'], $depth + 1);
    $false_branch = build_tree($best_split['false'], $depth + 1);
    return [
        'question' => $best_split['question'],
        'true_branch' => $true_branch,
        'false_branch' => $false_branch
    ];
}

function classify($row, $node)
{
    if (!is_array($node)) {
        return $node;
    }
    $question = $node['question'];
    $answer = $row['tempo_exibicao'] > $question ? 'true_branch' : 'false_branch';
    return classify($row, $node[$answer]);
}

// Processa os dados e constrói a árvore de decisão
$data = ProcessaDados();
$tree = build_tree($data);

// Classifica os novos dados
$tempo_exibicao = $_POST['tempo_exibicao'];
$result = classify(['tempo_exibicao' => $tempo_exibicao], $tree);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Classificação</title>
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
            <h1>Avaliar Modelo</h1>
            <nav>
                <ul>
                    <li><a href="view_menu.php">Home</a></li>
                    <li><a href="executar_modelo.php">Executar Modelo</a></li>
                    <li><a href="avaliar_modelo.php">Avaliar Modelo</a></li>
                    <li><a href="arvore_decisao.php">Avaliação de Filmes</a></li>
                    <li><a href="view_graficos.php">Menu graficos</a></li>
                    <li><a href="view_basedados.php">Base de dados</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <article>
            <div class="container">
                <h1>Resultado da Classificação</h1>
                <p>
                o código classifica se a avaliação de um filme será alta ou baixa, com base no tempo de exibição, 
                utilizando uma árvore de decisão construída a partir dos dados de filmes no arquivo CSV
                </p>
                <h3>A avaliação prevista para um filme com exibição de <strong><?php echo $_POST['tempo_exibicao']; ?></strong> minutos.
                    é de <strong><?php echo $result; ?> Votos</strong>
                </h3>
                <a href="arvore_decisao.php">Voltar</a>
            </div>
        </article>
    </div>

    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>

</body>

</html>