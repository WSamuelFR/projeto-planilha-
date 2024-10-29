<?php
function simple_titleMA()
{
    $filename = 'summer_movies.csv'; 
     
    $numero_da_linha = 100;
    
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); 

        
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $simple_title = array_search('simple_title', $header);

        
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; 

            if ($Tempo_exibicao > 100) { 
                $filteredRows[] = $data[$simple_title];
            }
            $linha_atual++;
        }

        fclose($handle);

        
        return ($filteredRows);

    }

}

function runtime_minutesMA()
{
    $filename = 'summer_movies.csv'; 
    
    $numero_da_linha = 100;
    
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); 

        
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $runtime_minutes = array_search('runtime_minutes', $header);

        
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; // Obtém a avaliação da coluna apropriada

            if ($Tempo_exibicao > 100) { 
                $filteredRows[] = $data[$runtime_minutes];
            }
            $linha_atual++;
        }

        fclose($handle);

        
        return ($filteredRows);

    }

}

function num_votesMA()
{
    $filename = 'summer_movies.csv'; 
    
    $numero_da_linha = 100;
    
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); 

        
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $num_votes = array_search('num_votes', $header);

        
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; 

            if ($Tempo_exibicao > 100) { 
                $filteredRows[] = $data[$num_votes];
            }
            $linha_atual++;
        }

        fclose($handle);

       
        return ($filteredRows);

    }

}

function average_ratingMA()
{
    $filename = 'summer_movies.csv'; 
     
    $numero_da_linha = 100;
    
    $linha_atual = 0;

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $header = fgetcsv($handle); 

        
        $indexTempo_exibicao = array_search('runtime_minutes', $header);
        $average_rating = array_search('average_rating', $header);

        
        $filteredRows = [];

        while (($data = fgetcsv($handle)) !== FALSE && $linha_atual < $numero_da_linha) {
            $Tempo_exibicao = (float) $data[$indexTempo_exibicao]; 

            if ($Tempo_exibicao > 100) { 
                $filteredRows[] = $data[$average_rating];
            }
            $linha_atual++;
        }

        fclose($handle);

        
        return ($filteredRows);

    }


}




?>