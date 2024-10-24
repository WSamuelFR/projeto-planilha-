<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
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

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="submit"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        input[type="submit"],
        input[type="text"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group h3 {
            margin-bottom: 10px;
            color: #555;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php $arquivo = fopen('summer_movies.csv', 'r'); ?>
    <?php if ($arquivo !== FALSE) { ?>
        <?php $cabecalho = fgetcsv($arquivo); ?>
        <?php $tconst = array_search('tconst', $cabecalho); ?>
        <?php $title_type = array_search('title_type', $cabecalho); ?>
        <?php $primary_title = array_search('primary_title', $cabecalho); ?>
        <?php $original_title = array_search('original_title', $cabecalho); ?>
        <?php $year = array_search('year', $cabecalho); ?>
        <?php $runtime_minutes = array_search('runtime_minutes', $cabecalho); ?>
        <?php $genres = array_search('genres', $cabecalho); ?>
        <?php $simple_title = array_search('simple_title', $cabecalho); ?>
        <?php $average_rating = array_search('average_rating', $cabecalho); ?>
        <?php $num_votes = array_search('num_votes', $cabecalho); ?>
        <?php $linha_atual = 1; ?>

        <header>
            <div class="container">
                <h1>Administração do Modelo de Precisão</h1>
                <nav>
                    <ul>
                    <li><a href="view_menu.php">Home</a></li>
                    <li><a href="executar_modelo.php">Executar Modelo</a></li>
                    <li><a href="avaliar_modelo.php">Avaliar Modelo</a></li>
                    <li><a href="arvore_decisao.php">Avaliação de Filmes</a></li>
                    <li><a href="knn_form.php">Classificação de Filmes com KNN</a></li>
                    <li><a href="view_graficos.php">Menu graficos</a></li><br><br>
                    <li><a href="view_basedados.php">Base de dados</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container">
            <article>
                <center>
                    <form action="#" method="post">
                        <div class="group-form">
                            <h1>Bem-vindo ao summer-movies project</h1>
                            <h3>escolha quantos dados deseja ler!</h3>
                            <input type="number" name="numero_linha">
                            <input type="submit" value="search"><br><br>
                    </form>
                </center>

                <?php $numero_linha = isset($_POST['numero_linha']) ? $_POST['numero_linha'] : ''; ?>
                <?php if ($numero_linha <> null) { ?>
                    <table border="3px">
                        <thead>
                            <tr>
                                <td>tconst</td>
                                <td>title_type</td>
                                <td>primary_title</td>
                                <td>original_title</td>
                                <td>year</td>
                                <td>runtime_minutes</td>
                                <td>genres</td>
                                <td>simple_title</td>
                                <td>average_rating</td>
                                <td>num_votes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while (($linha = fgetcsv($arquivo)) !== FALSE && $linha_atual < $numero_linha + 1) { ?>

                                <?php echo '<tr>
                        <td>' . $linha[$tconst] . '</td>
                        <td>' . $linha[$title_type] . '</td>
                        <td>' . $linha[$primary_title] . '</td>
                        <td>' . $linha[$original_title] . '</td>
                        <td>' . $linha[$year] . '</td>
                        <td>' . $linha[$runtime_minutes] . '</td>
                        <td>' . $linha[$genres] . '</td>
                        <td>' . $linha[$simple_title] . '</td>
                        <td>' . $linha[$average_rating] . '</td>
                        <td>' . $linha[$num_votes] . '</td>
                    </tr>'; ?>

                                <?php $linha_atual++; ?>
                            <?php } ?>
                        </tbody>'
                    </table>
                <?php } ?>

                <?php fclose($arquivo); ?>
            <?php } else { ?>
                <?php echo "Erro ao abrir o arquivo."; ?>
            <?php } ?>
    </div>

    </article>
    </div>

    <footer>
        <p>Administração do Modelo &copy; 2024</p>
    </footer>


</body>

</html>