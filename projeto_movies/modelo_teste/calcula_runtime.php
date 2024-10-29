<?php

ini_set('memory_limit', '2048M'); 

function ProcessaDados(): array {
    $filename = 'summer_movies.csv'; 
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); 
        $dados = [];
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

?>