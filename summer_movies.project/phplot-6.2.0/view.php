<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Gráficos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group h3 {
            margin-bottom: 10px;
            color: #555;
        }

        .link {
            margin-bottom: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <form action="view.php" method="post">
    <div class="form-group">
        <h1>Bem-vindo ao summer_movies project</h1>
        <div class="form-group">
            <h3>Escolha uma das opções abaixo</h3>
            <a href="menubasedados.php" class="link">Base da dados</a><br>
            <a href="menugraficos.php" class="link">Gerador de graficos</a>
    </div>
    </form>
</body>

</html>
