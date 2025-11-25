<?php

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__."/../../../vendor/autoload.php";

use Src\models\Admin;

$msg = ""; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperVisor</title>
    <link rel="stylesheet" href="../../../styles/style.css">
    <link rel="icon" href="../../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">
        
        <header class="cabecalho admin-header">
            <div class="div-cabecalho">
            <img src="../../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
            
            </div>

            <button class="menu-btn" id="menu-btn">☰</button>

            <?php require __DIR__."/../../nav.php"; ?>
        </header>

        <main class="admin-container container-formulario">
            <div class="formulario-grande grid-admin">
                <h1 style="grid-column:1 / 3; margin-bottom: 10px;" class="titulo-formulario-grande">Olá, administrador</h1>
                <a href="../CadastroUsuario" class="item-admin">Cadastrar Usuário</a>
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