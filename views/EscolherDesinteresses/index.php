<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\models\Usuario;
use Src\models\Interesse;
require __DIR__."/../../vendor/autoload.php";

session_start();

$interesses = Interesse::listarTodos();

if(isset($_POST['submit'])){
    if($_SESSION['idUsuario']){
        $interesses = $_SESSION['cadastro']['interesses'];
        $desinteresses = $_POST['desinteresses'];
        $usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
        $usuario->setStatus(0);
        $usuario->cadastrarInteresses($interesses);
        $usuario->cadastrarDesinteresses($desinteresses);
        $usuario->atualizar();
        unset($_SESSION['cadastro']);
        header("Location: ../TelaInicial/");
    } else {
        $nome = $_SESSION['cadastro']['nome'];
        $email = $_SESSION['cadastro']['email'];
        $foto_perfil = $_SESSION['cadastro']['foto_perfil'];
        $senha = $_SESSION['cadastro']['senha'];
        $interesses = $_SESSION['cadastro']['interesses'];
        $desinteresses = $_POST['desinteresses'];

        $usuario = new Usuario($nome, $foto_perfil, $email, $senha);
        $usuario->setIdUsuario($usuario->cadastrar());
        $usuario->cadastrarInteresses($interesses);
        $usuario->cadastrarDesinteresses($desinteresses);

        session_unset();
        session_destroy();

        header("Location: ../Login/");
    }
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
        </header>

        <main class="container-formulario">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Desinteresses</h1>
                <p class="info">Agora, você pode escolher alguns desinteresses</p>
                <p class="info">Você pode mudá-los depois</p>
                <div class="bloco-interesses">
                    <!--Aqui são listados os desinteresses-->
                    <?php

                    foreach($interesses as $i){
                        echo'
                            <div class="container-checkbox-interesse">
                            <input class="desinteresse-checkbox" type="checkbox" name="desinteresses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                            <label class="desinteresse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                            </div>
                        ';
                    }

                    ?>
                </div>

                <button id="submit" name="submit" class="botao-strong">Concluir Cadastro</button>
                <a href="../EscolherInteresses/" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            let checkboxes = document.querySelectorAll("input[type='checkbox']");
            checkboxes.forEach((cb) => (cb.checked = false));
        });
    </script>
</body>
</html>