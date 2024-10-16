<?php
function simple_titleMA()
{
    $filename = 'summer_movies.csv'; // Substitua pelo nome do seu arquivo CSV
    // define o numero de linhas 
    $numero_da_linha = 100;
    // define o numero de linhas
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); // Lê o cabeçalho do arquivo CSV

        // Encontra o índice do cabeçalho de avaliação
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $simple_title = array_search('simple_title', $header);

        // Array para armazenar as linhas filtradas
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; // Obtém a avaliação da coluna apropriada

            if ($Tempo_exibicao > 100) { // Ajuste a condição conforme necessário
                $filteredRows[] = $data[$simple_title];
            }
            $linha_atual++;
        }

        fclose($handle);

        // Exibe as linhas filtradas
        return ($filteredRows);

    }

}

function runtime_minutesMA()
{
    $filename = 'summer_movies.csv'; // Substitua pelo nome do seu arquivo CSV
    // define o numero de linhas 
    $numero_da_linha = 100;
    // define o numero de linhas
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); // Lê o cabeçalho do arquivo CSV

        // Encontra o índice do cabeçalho de avaliação
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $runtime_minutes = array_search('runtime_minutes', $header);

        // Array para armazenar as linhas filtradas
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; // Obtém a avaliação da coluna apropriada

            if ($Tempo_exibicao > 100) { // Ajuste a condição conforme necessário
                $filteredRows[] = $data[$runtime_minutes];
            }
            $linha_atual++;
        }

        fclose($handle);

        // Exibe as linhas filtradas
        return ($filteredRows);

    }

}

function num_votesMA()
{
    $filename = 'summer_movies.csv'; // Substitua pelo nome do seu arquivo CSV
    // define o numero de linhas 
    $numero_da_linha = 100;
    // define o numero de linhas
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); // Lê o cabeçalho do arquivo CSV

        // Encontra o índice do cabeçalho de avaliação
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $num_votes = array_search('num_votes', $header);

        // Array para armazenar as linhas filtradas
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; // Obtém a avaliação da coluna apropriada

            if ($Tempo_exibicao > 100) { // Ajuste a condição conforme necessário
                $filteredRows[] = $data[$num_votes];
            }
            $linha_atual++;
        }

        fclose($handle);

        // Exibe as linhas filtradas
        return ($filteredRows);

    }

}

function average_ratingMA()
{
    $filename = 'summer_movies.csv'; // Substitua pelo nome do seu arquivo CSV
    // define o numero de linhas 
    $numero_da_linha = 100;
    // define o numero de linhas
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); // Lê o cabeçalho do arquivo CSV

        // Encontra o índice do cabeçalho de avaliação
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $average_rating = array_search('average_rating', $header);

        // Array para armazenar as linhas filtradas
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; // Obtém a avaliação da coluna apropriada

            if ($Tempo_exibicao > 100) { // Ajuste a condição conforme necessário
                $filteredRows[] = $data[$average_rating];
            }
            $linha_atual++;
        }

        fclose($handle);

        // Exibe as linhas filtradas
        return ($filteredRows);

    }


}




?>