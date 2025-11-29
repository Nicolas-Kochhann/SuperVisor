<?php

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../vendor/autoload.php";

use Src\models\Usuario;
use Src\models\Solicitacao;

session_start();

if(!isset($_SESSION["idUsuario"])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

if($_SESSION["tipo"]!="aluno"){
   $_SESSION["error"] = "É necessário ser um aluno.";
    header("location: ../TelaInicial/");
    exit();     
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$solicitacoes = $usuarioLogado->acharSolicitacoesDoAluno();

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

        <main class="container-listagem">
            <div style="display: flex">
                <h2 class="titulo1">Olá, <?= $usuarioLogado->getNome() ?></h2>
                <button class="botao-nova-solicitacao" onclick="window.location.href='../CriarSolicitacao'">+ Nova Solicitação</button>
            </div>
            <h3 class="titulo2">Veja suas solicitações</h3>

            <div class="container-item-listagem"> <!-- AQUI VÃO OS MINI-PERFIS -->
            <?php
        
            if (count($solicitacoes) !== 0) {
                foreach($solicitacoes as $solicitacao){
                    $aluno = Usuario::acharUsuario($solicitacao->getIdAluno());
                    $foto_perfil = $aluno->getFotoPerfil() ?? 'foto_perfil_padrao.svg';
                    $data = new DateTime($solicitacao->getData());
                    $tipoEst = "";
                    if($solicitacao->getTipoEstagio() == 'nao-obrigatorio'){
                        $tipoEst = 'não obrigatório';
                    }else if ($solicitacao->getTipoEstagio() == 'obrigatorio'){
                        $tipoEst = "obrigatório";
                    }
                    echo "<div class='item-listagem'>
                            <a class='link-perfil-listagem' style='flex:1' href='../VisualizarSolicitacaoAluno/?id={$solicitacao->getIdSolicitacao()}'>
                                <img class='foto-redonda-listagem' src='../../resources/users/{$foto_perfil}' alt='Foto do aluno'>
                                <span>
                                    <div class='caixa-nome-data'>
                                        <p class='texto-listagem'>{$aluno->getNome()}</p>
                                        <p class='texto-listagem' style='color:#505050'>".date_format($data,"d/m/Y ")."</p>
                                    </div>
                                    <p class='texto-listagem' style='color:black'>Estágio {$tipoEst} em {$solicitacao->getEmpresa()}</p>
                                </span>
                            </a>
                            <div>
                            </div>
                            <p class='status-listagem'> ". $solicitacao->verStatus($_SESSION['idUsuario'])."</p>

                        </div>";
                }
            } else {
                echo "<p class='titulo2' style='margin: 15px 0 0 0; font-style: italic'>Nenhuma solicitação enviada.</p>";
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

        <?php


        if(isset($_SESSION["pop-up"])){
            echo "<div id='popup' class='popup esconder'>{$_SESSION['pop-up']['mensagem']}</div>";
            unset($_SESSION["pop-up"]);
        }

        ?>

    <script src="../../scripts/esconderPopUp.js"></script>
    <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>