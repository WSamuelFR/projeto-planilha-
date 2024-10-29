<?php
require '../phplot-6.2.0/phplot.php';

function processaDados($filename): array
{
    $dados = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        fgetcsv($handle); // Ignora o cabeçalho
        while (($data = fgetcsv($handle)) !== FALSE) {
            $dados[] = [
                'tempo_exibicao' => (int)$data[5],
                'avaliacao' => (float)$data[8]
            ];
        }
        fclose($handle);
    }
    return $dados;
}

$dados = processaDados('summer_movies.csv');

// Cálculo da regressão
$tempo = [];
$avaliacao = [];
foreach ($dados as $filme) {
    $tempo[] = $filme['tempo_exibicao'];
    $avaliacao[] = $filme['avaliacao'];
}

$plot = new PHPlot(1000, 600);
$plot->SetTitle('Regressão Logística - Avaliação vs Tempo de Exibição');
$plot->SetXTitle('Tempo de Exibição (min)');
$plot->SetYTitle('Avaliação');

$data = [];
for ($i = 0; $i <= max($tempo); $i += 5) {
    $z = 1 / (1 + exp(-($i * 0.1))); // Ajuste o cálculo com base nos pesos
    $data[] = [$i, $z * 10]; // Escala a avaliação para 10
}

$plot->SetDataValues(array_merge(array_map(function($x, $y) {
    return [$x, $y];
}, $tempo, $avaliacao), $data));
$plot->SetDataType('data-data');
$plot->SetPlotType('points');

$plot->SetDataColors(['blue']);
$plot->SetPlotBorderType('full');
$plot->SetGridColor('gray');
$plot->SetLineWidths(2);
$plot->SetXTickLabelPos('plotdown');
$plot->SetYTickLabelPos('plotleft');
$plot->SetXTickPos('plotdown');
$plot->SetYTickPos('plotleft');
$plot->DrawGraph();
?>
