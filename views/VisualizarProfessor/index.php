<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Src\models\Usuario;
use Src\models\Interesse;

session_start();

if (!isset($_SESSION['idUsuario'])) {
    $_SESSION['error'] = 'É necessário entrar na sua conta antes disso.';
    header('Location: ../Login/');
}

if(!isset($_GET['id'])){
    header('Location: ../TelaInicial/');
    exit();
}

$professor = Usuario::acharUsuario($_GET['id']);

if ($professor->getTipo() === "aluno") {
    header('Location: ../TelaInicial/');
}

$professorInteresses = $professor->acharInteresses();
$professorDesinteresses = $professor->acharDesinteresses();

$usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
$usuarioInteresses = $usuario->acharInteresses();
$usuarioDesinteresses = $usuario->acharDesinteresses();

$foto_perfil = $professor->getFotoPerfil() ?? 'foto_perfil_padrao.svg';

if ($professor->getDisponivel()) {
    $disponivel[0] = "Disponível";
    $disponivel[1] = "green";
} else {
    $disponivel[0] = "Indisponível";
    $disponivel[1] = "red";
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

        <?php require __DIR__."/../header.php"; ?>

        <main class="container-listagem" style="width:50%;">
            <div class="container-view-dados-professor">
                <img class="foto-redonda-listagem" src="../../resources/users/<?= $foto_perfil ?>" alt="Foto de perfil">
                <span class="container-dados-professor">
                    <div style="display: flex; gap: 10px">
                        <h2><?= $professor->getNome() ?> |</h2>
                        <h2 style="color:<?= $disponivel[1] ?>"><?= $disponivel[0] ?></h2>
                    </div>
                    <h3>Professor | <?= $professor->getEmail() ?></h3>
                </span>
            </div>
            <div style="margin: 0 0 15px 0">
                <p class='list-legend-green'>*Interesses em comum entre você e o professor</p>
                <p class='list-legend-red'>*Interesses seus que o professor marcou como desinteresse</p>
            </div>
            <h2 class="titulo-view">Interesses do Professor</h2>
            <div class="bloco-interesses" style="margin:0 0 20px 0">
            <?php
            foreach($professorInteresses as $professorInteresseId){
                $i = Interesse::acharInteresse($professorInteresseId);
                if(in_array($professorInteresseId, $usuarioInteresses)){
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label sem-pointer good">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    ';
                } else {
                    echo'
                    <div class="container-checkbox-interesse">
                    <label class="interesse-checkbox-label sem-pointer">'.$i->getDescricao().'</label> <!--Aqui vai o nome da tag ao invés de texto de exemplo-->
                    </div>
                    '; 
                }
            }

            ?> 
            </div>


            <?php
            if (count($professorDesinteresses) > 0) {
                echo '
                <h2 class="titulo-view">Desinteresses do Professor</h2>
                <div class="bloco-interesses" style="margin:0">';

                foreach ($professorDesinteresses as $professorDesinteresseId) {
                    $i = Interesse::acharInteresse($professorDesinteresseId);
                    if (in_array($professorDesinteresseId, $usuarioInteresses)) {
                        echo '
                        <div class="container-checkbox-interesse">
                        <label class="interesse-checkbox-label sem-pointer bad">' . $i->getDescricao() . '</label>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="container-checkbox-interesse">
                        <label class="interesse-checkbox-label sem-pointer">' . $i->getDescricao() . '</label>
                        </div>
                        ';
                    }
                }

                echo '</div>';
            }
            ?>
            <div style="width: 100%; margin-top:50px; bottom:20px; display: flex; flex-direction: column-reverse; gap: 10px; align-items: center;">
                <a style="font-size:23px" class="link-formulario" href="../ListarSolicitacao">Retornar</a>
            </div>
        </main>

    </div>
    <script src="../../scripts/menuButton.js"></script>
</body>

</html>