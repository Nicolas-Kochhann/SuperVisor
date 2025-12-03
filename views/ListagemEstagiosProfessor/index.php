<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__."/../../vendor/autoload.php";

use Src\models\Usuario;
use Src\models\Estagio;

$limitePorPagina = 15;

$sub = 0;

$temEstagios = true;

do {

    $paginaAtual = (isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1) - $sub;

    if ($paginaAtual < 1) {
        $paginaAtual = 1;
    }

    $offset = ($paginaAtual - 1) * $limitePorPagina;

    $estagios = Estagio::findallLimit($limitePorPagina, $offset, $_SESSION["idUsuario"]);

    $sub++;

    if (count($estagios) === 0 && $paginaAtual === 1) {
        $temEstagios = false;
        break;
    }

} while (count($estagios) === 0);

if(!isset($_SESSION["idUsuario"])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

if($_SESSION["tipo"] !== "professor"){
   $_SESSION["error"] = "É necessário ser um professor.";
    header("location: ../ListagemEstagiosAluno/");
    exit();     
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SVA</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="icon" href="../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">

        <?php require __DIR__."/../header.php"; ?>

        <main class="container-listagem-estagios">
            <span style="display:flex; justify-content: space-between;">
                <h2 class="titulo1">Olá, <?= $usuarioLogado->getNome() ?></h2>
                <button class="botao-nova-solicitacao" onclick='window.location.href="https:/\/billyorg.com/2025/projeto/grupo4/cadastro.php"'>+ Novo Estágio</button>
            </span>
            <h3 class="titulo2">Veja seus estágios orientados</h3>
            <span style="display:flex; margin-top: 10px">
                <?php
                    $tamanhoProxPag = Estagio::lengthNextPageEstagios($limitePorPagina, $offset, $limitePorPagina);
                    if ($tamanhoProxPag === 0 && $paginaAtual === 1) {
                        // pass;
                        // Não exibe os botões se não tiver outra página para ir
                    } else {
                        echo "<div style='display:flex; gap: 10px; width: 30%'>";

                        if ($paginaAtual === 1) {
                            echo "<button class='botao-tabela' disabled><</button>";
                        } else {
                            $paginaAnterior = $paginaAtual - 1;
                            echo "<button class='botao-tabela' onclick="."window.location.href='./?pagina={$paginaAnterior}'"."><</button>";
                        }
                        
                        echo "<p style='height:100%; display:flex; align-items: center; justify-content: center; font-family: Roboto, sans-serif; font-size: 1.3rem'>{$paginaAtual}</p>";
                        
                        if ($tamanhoProxPag === 0) {
                            echo "<button class='botao-tabela' disabled>></button>";
                        } else {
                            $proxPag = $paginaAtual + 1;
                            echo "<button class='botao-tabela' onclick="."window.location.href='./?pagina={$proxPag}'".">></button>";
                        }
                        
                        echo "</div>";
                    }
                ?>
            </span>
            <?php if ($temEstagios): ?>
                <table class="tabela-listagem-estagios">
                    <thead>
                        <tr>
                            <th style="width:18%" class="header-tabela">Empresa</th>
                            <th style="width:18%" class="header-tabela">Aluno</th>
                            <th style="width:35ch" class="header-tabela">Período</th>
                            <th style="width:20ch" class="header-tabela">Status</th>
                            <th class="header-tabela">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 0;
                            
                            foreach ($estagios as $estagio) {
                                $idEstagio = $estagio->getIdEstagio();
                                $aluno = Usuario::acharUsuario($estagio->getIdAluno());
                                $dataInicio = new DateTime($estagio->getDataInicio());
                                $dataFim = new DateTime($estagio->getDataFim());
                                $statusLabel = Estagio::getStatusLabel($estagio->getStatus());

                                if ($count%2 === 0) {
                                    $classeLinha = "conteudo1";
                                } else {
                                    $classeLinha = "conteudo2";
                                }

                                $count++;

                                if ($estagio->getSetorEmpresa() == "") { // Literalmente o único teste que fazem pra saber se precisa concluir o cadastro do estágio
                                    echo "
                                        <tr>
                                            <td class='conteudo-tabela {$classeLinha} importante'>{$estagio->getEmpresa()}</td>
                                            <td class='conteudo-tabela {$classeLinha} importante'>{$aluno->getNome()}</td>
                                            <td class='conteudo-tabela {$classeLinha} importante'>PENDENTE</td>
                                            <td class='conteudo-tabela {$classeLinha} importante'>PENDENTE</td>
                                            <td class='conteudo-tabela {$classeLinha} importante'><span style='display: flex; gap: 10px'>
                                                <p>Aguardando aluno concluir cadastro</p>
                                            </span></td>
                                        </tr>
                                    ";
                                } 
                                else {
                                    echo "
                                        <tr>
                                            <td class='conteudo-tabela {$classeLinha}'>{$estagio->getEmpresa()}</td>
                                            <td class='conteudo-tabela {$classeLinha}'>{$aluno->getNome()}</td>
                                            <td class='conteudo-tabela {$classeLinha}'>{$dataInicio->format('d/m/Y')} - {$dataFim->format('d/m/Y')}</td>
                                            <td class='conteudo-tabela {$classeLinha}'>{$statusLabel}</td>
                                    ";
                                
                                    if ($estagio->getStatus() == 0 || $estagio->getStatus() == 1) { // Finalizado || Ativo
                                        echo "
                                            <td class='conteudo-tabela {$classeLinha}'><span style='display: flex; gap: 5px'>
                                                <a href='https://billyorg.com/2025/projeto/grupo4/editar.php?idEstagio={$idEstagio}'>Editar</a>
                                                <p>|</p>
                                                <a href='https://billyorg.com/2025/projeto/grupo4/visualizacao.php?idEstagio={$idEstagio}'>Visualizar Dados</a>
                                                <p>|</p>
                                                <a href='https://billyorg.com/2025/projeto/grupo4/listagemDoc.php?idEstagio={$idEstagio}'>Documentos</a>
                                            </span></td>
                                        ";
                                    } else { // Concluído
                                        echo "
                                            <td class='conteudo-tabela {$classeLinha}'>Inacessível (Estágio Concluído)</td>
                                        ";
                                    }
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            <?php else: ?>
                <hr style="margin-top: 20px">
                <p class='titulo2' style='margin: 15px 0 0 0; font-style: italic'>Nenhum estágio cadastrado.</p>
            <?php endif; ?>
        </main>

    </div>

    <script src="../../scripts/menuButton.js"></script>
</body>
</html>