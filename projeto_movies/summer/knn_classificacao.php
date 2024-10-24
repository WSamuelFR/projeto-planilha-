<?php
ini_set('memory_limit', '2048M');

function ProcessaDados(): array
{
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

function calcular_distancia($p1, $p2)
{
    return sqrt(pow($p1['tempo_exibicao'] - $p2['tempo_exibicao'], 2) + pow($p1['avaliacao'] - $p2['avaliacao'], 2));
}

function knn($dados, $ponto_novo, $k)
{
    if ($k <= 0) {
        throw new InvalidArgumentException('O valor de K deve ser maior que zero.');
    }
    $distancias = [];

    foreach ($dados as $dado) {
        $distancia = calcular_distancia($ponto_novo, $dado);
        $distancias[] = ['distancia' => $distancia, 'avaliacao' => $dado['avaliacao']];
    }

    usort($distancias, function ($a, $b) {
        return $a['distancia'] <=> $b['distancia'];
    });

    $vizinhos = array_slice($distancias, 0, $k);
    if (count($vizinhos) === 0) {
        throw new Exception('Nenhum vizinho encontrado. Verifique os dados de entrada.');
    }

    $soma_avaliacoes = 0;
    foreach ($vizinhos as $vizinho) {
        $soma_avaliacoes += $vizinho['avaliacao'];
    }

    return $soma_avaliacoes / count($vizinhos);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tempo_exibicao = (float) $_POST['tempo_exibicao'];
    $k = (int) $_POST['k'];

    try {
        $dados = ProcessaDados();
        $ponto_novo = ['tempo_exibicao' => $tempo_exibicao, 'avaliacao' => 0];
        $resultado = knn($dados, $ponto_novo, $k);
        $r = round($resultado, 2);
        header("Location: knn_form.php?resultado={$r}");
        exit();
    } catch (Exception $e) {
        header("Location: knn_form.php?erro=" . urlencode($e->getMessage()));
        exit();
    }
}

?>