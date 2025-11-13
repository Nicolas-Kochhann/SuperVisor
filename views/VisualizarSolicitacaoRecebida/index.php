<?php

session_start()

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
            <div class="div-cabecalho">
            <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
            
            </div>

            <button class="menu-btn" id="menu-btn">☰</button>

            <?php require __DIR__."/../nav.php"; ?>
        </header>

        <main class="container-listagem" style="position:relative; width: 50%;">
            <h2 class="titulo1">Solicitação recebida</h2>
            <h3 class="titulo2" style="margin: 0 0 10px 0">de NOME | 12/12/25</h3>
            <hr>
            <p class="texto-visualizar-solicitacao">Empresa: </p>
            <p class="texto-visualizar-solicitacao">Área de Atuação: </p>
            <p class="texto-visualizar-solicitacao">Tipo de Estágio: </p>
            <p class="texto-visualizar-solicitacao">Carga Horária: horas semanais</p>
            <p class="texto-visualizar-solicitacao">Turno: </p>
            <p class="texto-visualizar-solicitacao">Obs.: </p>
            <div style="width: 100%; position:absolute; bottom:20px; display: flex; flex-direction: row-reverse; gap: 10px">
                <button type="button" class="botao-negar">Rejeitar</button>
                <button type="button" class="botao-aceitar">Aceitar</button>
            </div>
        </main>

    </div>
    <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>
</body>
</html>