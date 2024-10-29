<?php
require '../phplot-6.2.0/phplot.php';

// Caminho para o arquivo CSV
$csvFile = 'summer_movies.csv';
$data = [];

// Abrir o arquivo CSV e ler os dados
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    // Pular o cabeçalho
    fgetcsv($handle);

    // Ler os dados
    $count = 0;
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE && $count < 5) {
        $data[] = ["tconst" => $row[0], "runtime_minutes" => (int)$row[5], "num_votes" => (int)$row[9]];
        $count++;
    }
    fclose($handle);
}

// Preparar dados para o gráfico de regressão logística
$regression_data = [];
foreach ($data as $movie) {
    $regression_data[] = [$movie["num_votes"], $movie["runtime_minutes"]];
}

// Criar o gráfico
$plot = new PHPlot(800, 600);

// Títulos
$plot->SetTitle('Regressão Logística - Número de Votos vs Tempo de Execução');
$plot->SetXTitle('Número de Votos');
$plot->SetYTitle('Tempo de Execução (min)');

// Configurar os dados
$plot->SetDataValues($regression_data);
$plot->SetDataType('data-data'); // Importante para manter as coordenadas corretas

// Configurar o tipo de gráfico
$plot->SetPlotType('lines');

// Desenhar o gráfico de regressão logística
$plot->DrawGraph();
?>

