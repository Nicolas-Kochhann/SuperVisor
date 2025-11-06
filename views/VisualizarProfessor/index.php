<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Src\models\Usuario;
use Src\models\Interesse;

session_start();

if (!isset($_SESSION['idUsuario'])) {
    $_SESSION['error'] = 'É necessário entrar na sua conta antes disso.';
    header('Location: ../Login/');
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

        <main class="container-listagem" style="width:50%;">
            <div class="container-view-dados-professor">
                <img class="foto-redonda-listagem" src="../../resources/images/<?= $foto_perfil ?>" alt="Foto de perfil">
                <span class="container-dados-professor">
                    <h2><?= $professor->getNome() ?></h2>
                    <h3><?= $professor->getEmail() ?></h3>
                </span>
            </div>

            <h2 class="titulo-view">Interesses</h2>


            <?php
            if (count($professorDesinteresses) > 0) {
                echo '
                <h2 class="titulo-view">Desinteresses</h2>
                <div class="bloco-interesses" style="margin:0">';

                foreach ($professorDesinteresses as $professorDesinteresseId) {
                    $i = Interesse::acharInteresse($professorDesinteresseId);
                    if (in_array($professorDesinteresseId, $usuarioDesinteresses)) {
                        echo '
                        <div class="container-checkbox-interesse">
                        <label class="interesse-checkbox-label sem-pointer good">' . $i->getDescricao() . '</label>
                        </div>
                        ';
                    } else if (in_array($professorDesinteresseId, $usuarioInteresses)) {
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

        </main>

    </div>
</body>

</html>