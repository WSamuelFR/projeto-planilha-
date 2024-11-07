<?php
require '../phplot-6.2.0/phplot.php';  

$csvFile = 'summer_movies.csv';
$data = [];


if (($handle = fopen($csvFile, "r")) !== FALSE) {
    fgetcsv($handle); 

    $count = 0;
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE && $count < 50) {
        if (isset($row[5], $row[9]) && is_numeric($row[5]) && is_numeric($row[9])) {
            $data[] = [
                "tconst" => $row[0],
                "runtime_minutes" => (int)$row[5],
                "num_votes" => (int)$row[9]
            ];
            $count++;
        }
    }
    fclose($handle);
}


$regression_data = [];
foreach ($data as $movie) {
    $regression_data[] = [$movie["num_votes"], $movie["runtime_minutes"]];
}


$plot = new PHPlot(1000, 600);
$plot->SetTitle('Regressão Linear - Número de Votos vs Tempo de Exibição');
$plot->SetXTitle('Número de Votos');
$plot->SetYTitle('Tempo de Execução (min)');


$plot->SetDataValues($regression_data);
$plot->SetDataType('data-data');
$plot->SetPlotType('linepoints');


$plot->SetDataColors(['blue']);
$plot->SetPlotBorderType('full');
$plot->SetGridColor('gray');
$plot->SetLineWidths(2);
$plot->SetXTickLabelPos('plotdown');
$plot->SetYTickLabelPos('plotleft');
$plot->SetDrawXGrid(TRUE);
$plot->SetDrawYGrid(TRUE);


$plot->DrawGraph();
?>

