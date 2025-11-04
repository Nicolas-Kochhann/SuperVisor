<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\models\Usuario;
use Src\models\Interesse;
require __DIR__."/../../vendor/autoload.php";

session_start();

$erro = '';

$interesses = Interesse::listarTodos();

$usuario = '';

if(isset($_SESSION['idUsuario'])){
    $usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
} 

if(isset($_POST['submit'])){
    if($_POST['interesses'] != null){
        if(count($_POST['interesses']) >= 3){
                $_SESSION['cadastro']['interesses'] = $_POST['interesses'];
                header('Location: ../EditarDesinteresses');   
        } else {
            $erro = 'Você deve selecionar ao menos 3 interesses';
        }
    } else {
        $erro = 'Você deve selecionar ao menos 3 interesses';
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
                <h1 class="titulo-formulario-grande">Interesses</h1>
                <p class="info">Selecione no mínimo 3 interesses</p>
                <p class="contador-interesse info" id="contador-interesses">0 / 3</p>

                <?php
                    if ($erro) {
                        echo "<span class='bloco-erro'>".$erro."</span>";
                    }
                ?>
                
                <div class="bloco-interesses">
                    <!--Aqui são listados os interesses-->
                    <?php
                    if($usuario){
                        foreach($interesses as $i){
                            if(in_array($i->getIdInteresse(), $usuario->acharInteresses())){
                                echo'
                                    <div class="container-checkbox-interesse">
                                    <input class="interesse-checkbox" type="checkbox" name="interesses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'" checked> <!--Aqui vai o ID da tag no BD (?)-->
                                    <label class="interesse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                    </div>
                                ';
                            } else {
                                echo'
                                    <div class="container-checkbox-interesse">
                                    <input class="interesse-checkbox" type="checkbox" name="interesses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                                    <label class="interesse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                    </div>
                                ';
                            }
                        }
                    } else {
                        foreach($interesses as $i){
                            echo'
                                <div class="container-checkbox-interesse">
                                <input class="interesse-checkbox" type="checkbox" name="interesses[]" id="'.$i->getIdInteresse().'" value="'.$i->getIdInteresse().'"> <!--Aqui vai o ID da tag no BD (?)-->
                                <label class="interesse-checkbox-label" for="'.$i->getIdInteresse().'">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                                </div>
                            ';
                        }
                    }
                    ?>
                    
                </div>
                <button disabled id="submit" name="submit" class="botao-strong">Próximo</button>
                <a href="../CriarConta/" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
    <script src="../../scripts/contarInteresses.js"></script>
</body>
</html>