<?php
session_start();

require_once __DIR__."/../../vendor/autoload.php";

if (!isset($_SESSION['idUsuario'])) {
    header("location:index.php");
    exit;
}

require_once __DIR__."/../../Src/models/Usuario.php";
require_once __DIR__."/../../Src/models/Solicitacao.php";

use Src\models\Usuario;
use Src\models\Solicitacao;

$usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
$solicitacoesUsuario = Solicitacao::listarSolicitacoesAluno($_SESSION['idUsuario']);
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
    <?php if ($solicitacoesUsuario): ?>
    <div class="solicitacoes-container">
        <?php foreach ($solicitacoesUsuario as $s): ?>
            <div class="solicitacao-card">
                <p><strong>Empresa:</strong> <?= $s->getEmpresa(); ?></p>
                <p><strong>Tipo de Estágio:</strong> <?= $s->getTipoEstagio(); ?></p>
                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($s->getData())); ?></p>
                <p><strong>Status:</strong> 
                    <span class="status-<?= strtolower($s->getStatus()); ?>">
                        <?= $s->getStatus(); ?>
                    </span>
                </p>
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