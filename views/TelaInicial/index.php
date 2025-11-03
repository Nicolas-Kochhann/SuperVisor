<?php

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../vendor/autoload.php";

use Src\models\Usuario;

session_start();

if(!isset($_SESSION["idUsuario"])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$professores = Usuario::listarProfessores();

foreach($professores as $professor){
    $professor->calcularInteressesEmComum($usuarioLogado->acharInteresses());
    $professor->calcularDesinteressesEmComum($usuarioLogado->acharInteresses());
}

usort($professores, function($a, $b){ $a->getInteressesEmComum() <=> $b->getInteressesEmComum(); });

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

        <main class="container-listagem">

            <h2 class="titulo1">Olá, <?= $usuarioLogado->getNome() ?></h2>
            <h3 class="titulo2">Encontre orientadores</h3>

            <div class="container-item-listagem"> <!-- AQUI VÃO OS MINI-PERFIS -->
            <?php

            foreach($professores as $professor){
                $foto_perfil = $professor->getFotoPerfil() ?? 'foto_perfil_padrao.svg';
                echo "<div class='item-listagem'> <!-- DIV CRIADA PARA CADA ITEM DA LISTAGEM -->
                        <a class='link-perfil-listagem' href='../VisualizarProfessor/?id={$professor->getIdUsuario()}'> <!-- LINK DO PERFIL DO PROFESSOR NO href -->
                        <img class='foto-redonda-listagem' src='../../resources/images/{$foto_perfil}' alt='Foto de um professor'> <!-- FOTO DE PERFIL DO PROFESSOR NO src -->
                        <p class='texto-listagem'>{$professor->getNome()}</p> <!-- NOME DO PROFESSOR -->
                        </a>
                        <div class='container-contadores-listagem'> 
                            <span class='contador-interesses-listagem'>{$professor->getInteressesEmComum()}</span> <!-- NUM DE INTERESSES EM COMUM COM O USUÁRIO LOGADO -->
                            <span class='contador-desinteresses-listagem'>{$professor->getDesinteressesEmComum()}</span> <!-- n sei o que escrever aqui, O CONTRÁRIO DO OUTRO span -->
                        </div>
                    </div>";
            }

            ?> 

            <!--
                <div class="item-listagem">
                    <a class="link-perfil-listagem" href="">
                        <img class="foto-redonda-listagem" src="../../resources/images/placeholders/professor.png" alt="Foto de um professor">
                        <p class="texto-listagem">Conrad von Hötzendorf</p>
                    </a>
                    <div class="container-contadores-listagem"> 
                        <span class="contador-interesses-listagem">1</span>
                        <span class="contador-desinteresses-listagem">0</span>
                    </div>
                </div>
            -->

            </div>
            
        </main>
    </div>
</body>
</html>