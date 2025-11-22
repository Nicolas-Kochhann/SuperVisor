<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__."/../../vendor/autoload.php";

if (!isset($_SESSION['idUsuario'])) {
    header("location:index.php");
    exit;
}

use Src\models\Usuario;
use Src\models\Solicitacao;

$usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
$solicitacao = Solicitacao::acharSolicitacaoPorId($_GET['id']);
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
<body>
    <?php if (isset($solicitacoesUsuario)): ?>
    <div class="solicitacoes-container">
        <?php foreach ($solicitacoesUsuario as $s): ?>
            <div class="solicitacao-card">
            <div class="info-estagio">
            <span class="negrito">
                <?php
                if ($s->getTipoEstagio() === 'nao-sei') {
                    echo "Estágio em {$s->getEmpresa()}";
                } else if ($s->getTipoEstagio() === 'nao-obrigatorio') {
                    echo "Estágio não obrigatório em {$s->getEmpresa()}";
                } else {
                    echo "Estágio obrigatório na {$s->getEmpresa()}";
                    
                }
                ?>
            </span>
                <?= date('d/m/Y', strtotime($s->getData())); ?>
            </div>
                

                <div class="status">
                 <?php 
                    if ($s->getStatus() === 0) {
                        echo "<span style='color: red;'>Recusado</span>";
                    } elseif ($s->getStatus() === 1) {
                        echo "<span style='color: green;'>Aceito</span>";
                    } else {
                        echo "<span style='color: blue;'>Pendente</span>";
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p>Nenhuma solicitação cadastrada ainda.</p>
    <?php endif; ?>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>

</body>
</html>