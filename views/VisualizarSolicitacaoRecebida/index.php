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

if($_SESSION["tipo"]!="professor"){
   $_SESSION["error"] = "É necessário ser um professor.";
    header("location: ../TelaInicial/");
    exit();     
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$solicitacao = Solicitacao::acharSolicitacaoPorId($_GET['id']);

$aluno = Usuario::acharUsuario($solicitacao->getIdAluno());

$data = new DateTime($solicitacao->getData());
$tipoEst = "";
if($solicitacao->getTipoEstagio() == 'nao-obrigatorio'){
    $tipoEst = 'Não obrigatório';
}else if ($solicitacao->getTipoEstagio() == 'obrigatorio'){
    $tipoEst = "Obrigatório";
}else {
    $tipoEst = 'Não sei';
}

$turno = "";
if($solicitacao->getTurno() == 'manha'){
    $turno = 'Manhã';
}else if ($solicitacao->getTurno() == 'tarde'){
    $turno = "Tarde";
}else {
    $turno = 'Não sei';
}

if(isset($_POST['botao'])){
    if($_POST['botao'] == 'aceitar'){
        $solicitacao->setStatus(1);
    }else{
        $solicitacao->setStatus(0);
    }
    $solicitacao->atualizarStatus();
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
            <div class="div-cabecalho">
            <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
            
            </div>

            <button class="menu-btn" id="menu-btn">☰</button>

            <?php require __DIR__."/../nav.php"; ?>
        </header>

        <main class="container-listagem" style="position:relative; width: 50%;">
            <h2 class="titulo1">Solicitação recebida</h2>
            <h3 class="titulo2" style="margin: 0 0 10px 0">de <?=$aluno->getNome()?> | 12/12/25</h3>
            <hr>
            <p class="texto-visualizar-solicitacao">Empresa: <?=$solicitacao->getEmpresa()?></p>
            <p class="texto-visualizar-solicitacao">Área de Atuação: <?=$solicitacao->getAreaAtuacao()?></p>
            <p class="texto-visualizar-solicitacao">Tipo de Estágio: <?= $tipoEst?></p>
            <p class="texto-visualizar-solicitacao">Carga Horária: <?=$solicitacao->getCargaHorariaSemanal()?> horas semanais</p>
            <p class="texto-visualizar-solicitacao">Turno: <?=$turno?></p>
            <p class="texto-visualizar-solicitacao">Obs.: <?=$solicitacao->getObs()?></p>
            <?php
            if($solicitacao->verStatus($_SESSION['idUsuario']) == "Pendente"){
                echo'
                    <div style="width: 100%; position:absolute; bottom:20px; display: flex; flex-direction: row-reverse; gap: 10px">
                        <form action="index.php?id='. $solicitacao->getIdSolicitacao() .'" method="post">
                            <button type="submit" class="botao-negar" name="botao" value="negar">Rejeitar</button>
                            <button type="submit" class="botao-aceitar" name="botao" value="aceitar">Aceitar</button>
                        </form>
                    </div>
                ';  }
            ?>
            
        </main>

    </div>
    <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>
</body>
</html>