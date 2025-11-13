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
$usuario = '';

if(isset($_SESSION['idUsuario'])){
    $usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
}

if(isset($_POST['submit'])){
    if($usuario){
        $interesses = $_SESSION['cadastro']['interesses'];
        if (isset($_POST['desinteresses'])) {
            $desinteresses = $_POST['desinteresses'];
        } else {
            $desinteresses = [];
        }

        $usuario->removerInteresses($usuario->acharInteresses());
        $usuario->removerDesinteresses($usuario->acharDesinteresses());

        $usuario->cadastrarInteresses($interesses);
        $usuario->cadastrarDesinteresses($desinteresses);
        //$usuario->atualizar();
        unset($_SESSION['cadastro']);
        header("Location: ../index.php");
        
    } else {
        $nome = $_SESSION['cadastro']['nome'];
        $email = $_SESSION['cadastro']['email'];
        $foto_perfil = $_SESSION['cadastro']['foto_perfil'];
        $senha = $_SESSION['cadastro']['senha'];
        $interesses = $_SESSION['cadastro']['interesses'];
        if (isset($_POST['desinteresses'])) {
            $desinteresses = $_POST['desinteresses'];
        } else {
            $desinteresses = [];
        }

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
                <p class="info">Você poderá mudá-los depois</p>
                <div class="bloco-interesses">
                    <!--Aqui são listados os desinteresses-->
                    <?php

                    if($usuario){
                        foreach($interesses as $i){
                            if(in_array(strval($i->getIdInteresse()), $_SESSION['cadastro']['interesses'], true)){
                                continue;
                            }
                            if(in_array($i->getIdInteresse(), $usuario->acharDesinteresses())){
                                echo'
                                    <div class="container-checkbox-interesse">
                                    <input checked class="desinteresse-checkbox" type="checkbox" name="desinteresses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                                    <label class="desinteresse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                    </div>
                                ';
                            } else {
                                echo'
                                    <div class="container-checkbox-interesse">
                                    <input class="desinteresse-checkbox" type="checkbox" name="desinteresses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                                    <label class="desinteresse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                    </div>
                                ';
                            }
                        }
                    } else {
                        foreach($interesses as $i){
                            if(in_array($i->getIdInteresse(), $_SESSION['cadastro']['interesses'])){
                                continue;
                            }
                            echo'
                                <div class="container-checkbox-interesse">
                                <input class="desinteresse-checkbox" type="checkbox" name="desinteresses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                                <label class="desinteresse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                </div>
                            ';
                        }
                    }

                    ?>
                </div>

                <button id="submit" name="submit" class="botao-strong">Concluir Cadastro</button>
                <a href="../EscolherInteresses/" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
</body>
</html>