<?php

session_start();

if(!isset($_SESSION["idUsuario"])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

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
            <a class="cabecalho-link-botao" href="../Logout/">Sair</a>
        </header>
    
        <main class="container-listagem" style="background-color: red">
            <div>
                <img src="" alt="">
                <span>
                    <h2>Conrad von Hötzendorf</h2>
                    <h3>conrad.pereira@feliz.ifrs.edu.br</h3>
                </span>
            </div>

            <h2>Interesses</h2>
            <div class="bloco-interesses">

            </div>

            <h2>Desinteresses</h2>
            <div class="bloco-interesses">
            </div>

        </main>

    </div>
</body>
</html>