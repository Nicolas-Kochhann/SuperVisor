<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperVisor</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="icon" href="../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">

        <header class="cabecalho">
            <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-formulario">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Desinteresses</h1>
                <p class="info">Agora, você pode escolher alguns desinteresses</p>
                <p class="info">Você pode mudá-los depois</p>
                <div class="bloco-interesses">
                    <!--Aqui são listados os desinteresses-->
                    <div class="container-checkbox-interesse">
                        <input class="desinteresse-checkbox" type="checkbox" name="1" id="1"> <!--Aqui vai o ID da tag no BD (?)-->
                        <label class="desinteresse-checkbox-label" for="1">Exemplo</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                </div>

                <button id="submit" name="submit" class="botao-strong">Próximo</button>
                <a href="" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
</body>
</html>