<?php
require_once '../phplot-6.2.0/phplot.php'; // Certifique-se de que o caminho está correto

include('dataMaior.php');
include('dataMenor.php');

$dados = isset($_POST['dados']) ? $_POST['dados'] : '';


if ($dados == 0) {
    $data = dataMaior();

    $plot = new PHPlot(1500, 700); // Define o tamanho do gráfico
    $plot->SetImageBorderType('plain');
    // Defina o tipo de gráfico (barras)
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

    switch ($tipo) {
        case '0':
            $tp = 'bars';
            break;

        case '1':
            $tp = 'lines';
            break;

        case '2':
            $tp = 'linepoints';
            break;


        case '3':
            $tp = 'points';
            break;

        case '4':
            $tp = 'area';
            break;

        case '5':
            $tp = 'pie';
            break;

        case '6':
            $tp = 'stackedarea';
            break;

        case '7':
            $tp = 'stackedbars';
            break;

        case '8':
            $tp = 'thinbarline';
            break;

        default:

            break;
    }
    $plot->SetPlotType($tp);
    $plot->SetDataType('text-data');
    $plot->SetDataValues($data);

    $plot->SetTitle('Grafico runtime minutes');
    $plot->SetXTitle('summer movies title');
    $plot->SetYTitle('Values');

    $plot->SetLegend(array('average_rating', 'runtime_minutes', 'num_votes'));
    $plot->SetYDataLabelPos('plotin');

    $plot->DrawGraph();

} elseif ($dados == 1) {
    $data = dataMenor();

    $plot = new PHPlot(1500, 700); // Define o tamanho do gráfico
    $plot->SetImageBorderType('plain');
    // Defina o tipo de gráfico (barras)
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

    switch ($tipo) {
        case '0':
            $tp = 'bars';
            break;

        case '1':
            $tp = 'lines';
            break;

        case '2':
            $tp = 'linepoints';
            break;


        case '3':
            $tp = 'points';
            break;

        case '4':
            $tp = 'area';
            break;

        case '5':
            $tp = 'pie';
            break;

        case '6':
            $tp = 'stackedarea';
            break;

        case '7':
            $tp = 'stackedbars';
            break;

        case '8':
            $tp = 'thinbarline';
            break;

        default:

            break;
    }
    $plot->SetPlotType($tp);
    $plot->SetDataType('text-data');
    $plot->SetDataValues($data);

    $plot->SetTitle('Grafico runtime minutes');
    $plot->SetXTitle('summer movies title');
    $plot->SetYTitle('Values');

    $plot->SetLegend(array('average_rating', 'runtime_minutes', 'num_votes'));
    $plot->SetYDataLabelPos('plotin');

    $plot->DrawGraph();
    
}



?>