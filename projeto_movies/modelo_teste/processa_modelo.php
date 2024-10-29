<?php
ini_set('memory_limit', '2048M');

function ProcessaDados(): array {
    $filename = 'summer_movies.csv';
    $dados = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
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

function CalculaMedia(): array {
    $dados = ProcessaDados();
    $tempo_intervalos = [];
    foreach ($dados as $filme) {
        $tempo = round($filme['tempo_exibicao']);
        if (!isset($tempo_intervalos[$tempo])) {
            $tempo_intervalos[$tempo] = ['soma_avaliacoes' => 0, 'count' => 0];
        }
        $tempo_intervalos[$tempo]['soma_avaliacoes'] += $filme['avaliacao'];
        $tempo_intervalos[$tempo]['count'] += 1;
    }
    $medias_avaliacoes = [];
    foreach ($tempo_intervalos as $tempo => $valores) {
        $medias_avaliacoes[$tempo] = $valores['soma_avaliacoes'] / $valores['count'];
    }
    return $medias_avaliacoes;
}

function TempoIdealExibição() {
    $medias_avaliacoes = CalculaMedia();
    $melhor_tempo = array_keys($medias_avaliacoes, max($medias_avaliacoes));
    return $melhor_tempo;
}

function PredicaoAvaliacao($tempo_exibicao, $melhor_tempo) {
    return in_array(round($tempo_exibicao), $melhor_tempo) ? 1 : 0;
}

function AvaliarPrecisao() {
    $dados = ProcessaDados();
    $melhor_tempo = TempoIdealExibição();
    $labels = [];
    $predictions = [];
    foreach ($dados as $filme) {
        $labels[] = $filme['avaliacao'] > 4000 ? 1 : 0;
        $predictions[] = PredicaoAvaliacao($filme['tempo_exibicao'], $melhor_tempo);
    }
    return Precisao($labels, $predictions);
}

function Precisao($labels, $predictions) {
    $corretos = 0;
    foreach ($labels as $i => $label) {
        if ($label == $predictions[$i]) {
            $corretos++;
        }
    }
    return $corretos / count($labels);
}

function CalculaAcuraciaEPrecisao(array $dados) {
    // Usar os dados para calcular a acurácia e precisão
    $sum_squared_errors = 0;
    $total_samples = count($dados);
    $mean_avaliacao = array_sum(array_column($dados, 'avaliacao')) / $total_samples;

    foreach ($dados as $filme) {
        $sum_squared_errors += pow(($filme['avaliacao'] - $mean_avaliacao), 2);
    }

    $mean_squared_error = $sum_squared_errors / $total_samples;
    $accuracy = 1 / (1 + sqrt($mean_squared_error));
    $precision = $mean_avaliacao; // Exemplo simplificado

    return [$accuracy, $precision];
}

$dados = ProcessaDados();
$medias_avaliacoes = CalculaMedia();
$tempo_ideal = TempoIdealExibição();
$precisao = round(AvaliarPrecisao(), 2);
list($accuracy, $precision) = CalculaAcuraciaEPrecisao($dados);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métricas do Modelo</title>
</head>
<body>
    <h1>Métricas do Modelo</h1>
    <p>Tempo ideal de exibição: <?php echo implode(', ', $tempo_ideal); ?> minutos</p>
    <h3>A precisão do modelo é: <?php echo ($precisao * 100) . "%"; ?></h3>
    <p>Acurácia: <?php echo round($accuracy, 2); ?></p>
    <h2>Gráfico de Regressão Linear</h2>
    <img src="regressao_linear.php" alt="Gráfico de Regressão Linear">
</body>
</html>

