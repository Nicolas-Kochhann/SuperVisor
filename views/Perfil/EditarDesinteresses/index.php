<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\models\Usuario;
use Src\models\Interesse;
require __DIR__."/../../../vendor/autoload.php";

session_start();

if(!isset($_SESSION['idUsuario'])){
    $_SESSION['error'] = 'É necessário entrar na sua conta antes disso.';
    header('Location: ../Login/');
}

$interesses = Interesse::listarTodos();

$usuario = Usuario::acharUsuario($_SESSION['idUsuario']);

if(isset($_POST['submit'])){
    if($usuario){
        
        if (isset($_POST['desinteresses'])) {
            $desinteresses = $_POST['desinteresses'];
        } else {
            $desinteresses = [];
        }

        $usuario->removerDesinteresses($usuario->acharDesinteresses());
        $usuario->cadastrarDesinteresses($desinteresses);
        //$usuario->atualizar();

        $_SESSION['pop-up']['mensagem'] = "Desinteresses atualizados";

        header("Location: ../");
        
    }
}
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

        <?php require __DIR__."/../../header.php"; ?>

        <main class="container-formulario">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Editar desinteresses</h1>
                <div class="bloco-interesses">
                    <!--Aqui são listados os desinteresses-->
                    <?php

                        foreach($interesses as $i){
                            if(in_array($i->getIdInteresse(), $usuario->acharInteresses())){
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

                    ?>
                </div>

                <button id="submit" name="submit" class="botao-strong">Salvar alterações</button>
                <a href="../" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
</body>
</html>