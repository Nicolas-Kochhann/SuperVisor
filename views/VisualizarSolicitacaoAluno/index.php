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

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$solicitacao = Solicitacao::acharSolicitacaoPorId($_GET['id']);

if ($_SESSION["idUsuario"] != $solicitacao->getIdAluno()) {
    $_SESSION["erro"] = "Acesso negado.";
    header("Location: ../TelaInicial/");
}

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

$professores = $solicitacao->acharProfessoresSolicitacao($_GET['id']);

usort($professores, function($a, $b) {
    $statusA = $a['status'];
    $statusB = $b['status'];

    // Joga a aceita pra cima
    if ($statusA === "1" && $statusB !== "1") {
        return -1;
    }
    if ($statusA !== "1" && $statusB === "1") {
        return 1;
    }

    // Joga as recusadas para baixo
    if ($statusA === "0" && $statusB !== "0") {
        return 1;
    }
    if ($statusA !== "0" && $statusB === "0") {
        return -1;
    }

    return strcmp($statusA, $statusB);
});

if(isset($_POST['excluir'])){
    $solicitacao->delete();
    header('Location: ../MinhasSolicitacoes');
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
            <form style="display: flex" action="index.php?id=<?= $solicitacao->getIdSolicitacao()?>" method="post">
                <h2 class="titulo1">Solicitação de Orientação</h2>
                <?php
                
                if(!$solicitacao->verificarSeSolicitacaoFoiAceita()){
                    echo '<button class="botao-excluir-solicitacao" name="excluir">Excluir</button>';
                }

                ?>                
                
            </form>
            <h3 class="titulo2" style="margin: 0 0 10px 0">criada no dia <?= $data->format('d/m/Y') ?></h3>
            <hr>
            <p class="texto-visualizar-solicitacao">Empresa: <?=$solicitacao->getEmpresa()?></p>
            <p class="texto-visualizar-solicitacao">Área de Atuação: <?=$solicitacao->getAreaAtuacao()?></p>
            <p class="texto-visualizar-solicitacao">Tipo de Estágio: <?= $tipoEst?></p>
            <p class="texto-visualizar-solicitacao">Carga Horária: 
                <?php
                    if (null !== $solicitacao->getCargaHorariaSemanal()) {
                        echo "{$solicitacao->getCargaHorariaSemanal()} horas semanais";
                    } else {
                        echo "não informado";
                    }
                ?>
            </p>
            <p class="texto-visualizar-solicitacao">Turno: <?=$turno?></p>
            <?php
                if (null !== $solicitacao->getObs()) {
                    echo "<p class='texto-visualizar-solicitacao'>Obs.: {$solicitacao->getObs()}</p>";
                }
            ?>

            <div class="container-bloco-listagem-visualizar-solicitacao" >
                <?php
                foreach ($professores as $professor) {
                    //var_dump($professor);
                    //die();
                    
                    $foto_perfil = $professor["imagem"] ?? 'foto_perfil_padrao.svg';
                    $status = Solicitacao::traduzirStatus($professor['status']);
                    
                    switch ($professor['status']) {
                        case 0:
                            $cor = 'red';
                            break;
                        
                        case 1:
                            $cor = 'green';
                            break;
                        
                        case 2:
                            $cor = 'orange';
                            break;
                        
                        default:
                            $cor = 'black';
                            break;
                    }

                    echo "<div class='item-listagem'> <!-- DIV CRIADA PARA CADA ITEM DA LISTAGEM --> 
                                <img class='foto-redonda-listagem' src='../../resources/users/{$foto_perfil}' alt='Foto de um professor'>
                                <p class='texto-listagem'>{$professor["nome"]}</p>
                                <p style='margin: 0 15px 0 auto; color: {$cor}' class='texto-listagem'>{$status}</p>
                        </div>";
                }
                ?>
            </div>
            
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