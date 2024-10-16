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
            <div class="container">
                <h1>Avaliação de Filmes</h1>
                <p>
                    o código classifica se a avaliação de um filme será alta ou baixa, com base no tempo de exibição,
                    utilizando uma árvore de decisão construída a partir dos dados de filmes no arquivo CSV
                </p>
                <form action="classify.php" method="post">
                    <label for="tempo_exibicao">Tempo de Exibição (minutos):</label>
                    <input type="number" id="tempo_exibicao" name="tempo_exibicao" required>
                    <button type="submit">Classificar</button>
                </form>
            </div>
        </article>
    </div>

    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>

</body>

</html>