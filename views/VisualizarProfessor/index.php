<?php

session_start();

require_once __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;
use Src\models\Interesse;

session_start();

if(!isset($_SESSION['idUsuario'])){
    $_SESSION['error'] = 'É necessário entrar na sua conta antes disso.';
    header('Location: ../Login/');
}

$professor = Usuario::acharUsuario($_GET['id']);
$professorInteresses = $professor->acharInteresses();
$professorDesinteresses = $professor->acharDesinteresses();

$usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
$usuarioInteresses = $usuario->acharInteresses();
$usuarioDesinteresses = $usuario->acharDesinteresses();

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
                    <h2><?= $professor->getNome() ?></h2>
                    <h3><?= $professor->getEmail() ?></h3>
                </span>
            </div>

            <h2>Interesses</h2>
            <div class="bloco-interesses">
            <?php

            foreach($professorInteresses as $professorInteresseId){
                $i = Interesse::acharInteresse($professorInteresseId);
                if(in_array($professorInteresseId, $usuarioInteresses)){
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    ';
                } else if(in_array($professorInteresseId, $usuarioDesinteresses)){
                   echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    '; 
                } else {
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    '; 
                }
            }

            ?> 
            </div>

            <h2>Desinteresses</h2>
            <div class="bloco-interesses">
            <?php

            foreach($professorInteresses as $professorInteresseId){
                $i = Interesse::acharInteresse($professorInteresseId);
                if(in_array($professorDesinteresseId, $usuarioDesinteresses)){
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    ';
                } else if(in_array($professorDesinteresseId, $usuarioInteresses)){
                   echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    '; 
                } else {
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    '; 
                }
            }

            ?> 
            </div>

        </main>

    </div>
</body>
</html>