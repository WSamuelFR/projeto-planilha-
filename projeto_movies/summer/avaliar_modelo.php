<?php
// Aqui você inclui o código para avaliar a precisão, como discutimos antes.

require('calcula_runtime.php');

// Função de predição
function PredicaoAvaliacao($tempo_exibicao, $melhor_tempo)
{
    return in_array(round($tempo_exibicao), $melhor_tempo) ? 1 : 0;
}

// Função para avaliar a precisão usando CalculaMedia()
function AvaliarPrecisao()
{
    $dados = ProcessaDados();
    $melhor_tempo = TempoIdealExibição();
    $labels = [];
    $predictions = [];
    foreach ($dados as $filme) {
        $labels[] = $filme['avaliacao'] > 4000 ? 1 : 0; // 1 para filmes com avaliação > 7, 0 caso contrário
        $predictions[] = PredicaoAvaliacao($filme['tempo_exibicao'], $melhor_tempo);
    }
    return Precisao($labels, $predictions);
}

// Função para calcular a precisão
function Precisao($labels, $predictions)
{
    $corretos = 0;
    foreach ($labels as $i => $label) {
        if ($label == $predictions[$i]) {
            $corretos++;
        }
    }
    return $corretos / count($labels);
}

// Calcula a precisão do modelo
$precisao = round(AvaliarPrecisao(), 2);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliar Modelo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77d7ff 3px solid;
        }

        header a,
        header h1 {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        nav ul {
            padding: 0;
            list-style: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        article {
            padding: 20px;
            background: #fff;
            border: #77d7ff 1px solid;
            margin-top: 20px;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <h1>Avaliar Modelo</h1>
            <nav>
                <ul>
                    <li><a href="view_menu.php">Home</a></li>
                    <li><a href="executar_modelo.php">Executar Modelo</a></li>
                    <li><a href="avaliar_modelo.php">Avaliar Modelo</a></li>
                    <li><a href="arvore_decisao.php">Avaliação de Filmes</a></li>
                    <li><a href="view_graficos.php">Menu graficos</a></li>
                    <li><a href="view_basedados.php">Base de dados</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <article>
            <h2>Precisão do Modelo</h2>
            <p>Modelo Que Faz O Calculo Da Media Do Tempo Ideal De Exibição</p>
            <p>Usando Como Metrica O Voto Popular</p>
            <h3>A precisão do modelo é: <?php echo ($precisao * 100) . "%"; ?></h3>
        </article>
    </div>

    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>

</body>

</html>