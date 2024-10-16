<?php

function dataMenor(): array
{
    
    require('dadosMenor.php');

    $data = array(
        array(simple_titleME()[0], average_ratingME()[0], runtime_minutesME()[0], num_votesME()[0]),
        array(simple_titleME()[1], average_ratingME()[1], runtime_minutesME()[1], num_votesME()[1]),
        array(simple_titleME()[2], average_ratingME()[2], runtime_minutesME()[2], num_votesME()[2]),
        array(simple_titleME()[3], average_ratingME()[3], runtime_minutesME()[3], num_votesME()[3]),
        array(simple_titleME()[4], average_ratingME()[4], runtime_minutesME()[4], num_votesME()[4]),
        array(simple_titleME()[5], average_ratingME()[5], runtime_minutesME()[5], num_votesME()[5]),
        array(simple_titleME()[6], average_ratingME()[6], runtime_minutesME()[6], num_votesME()[6]),
        array(simple_titleME()[7], average_ratingME()[7], runtime_minutesME()[7], num_votesME()[7]),
        array(simple_titleME()[8], average_ratingME()[8], runtime_minutesME()[8], num_votesME()[8]),
        array(simple_titleME()[9], average_ratingME()[9], runtime_minutesME()[9], num_votesME()[9]),
        array(simple_titleME()[10], average_ratingME()[10], runtime_minutesME()[10], num_votesME()[10]),
        array(simple_titleME()[11], average_ratingME()[11], runtime_minutesME()[11], num_votesME()[11]),
        array(simple_titleME()[12], average_ratingME()[12], runtime_minutesME()[12], num_votesME()[12]),
        array(simple_titleME()[13], average_ratingME()[13], runtime_minutesME()[13], num_votesME()[13]),
        array(simple_titleME()[14], average_ratingME()[14], runtime_minutesME()[14], num_votesME()[14])
    );

    return($data);

}


?>