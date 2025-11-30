<?php
// Mostra todos os erros na tela
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require __DIR__."/../../../vendor/autoload.php";

use Src\models\Admin;

$msg = ""; 

if(isset($_POST['submit'])){
    if(Admin::autenticar($_POST['email'],$_POST['senha'])){
        header("location: ../TelaInicial/");
    } else {
        $msg="E-mail ou senha incorretos!";        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperVisor</title>
    <link rel="stylesheet" href="../../../styles/style.css">
    <link rel="icon" href="../../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">
        
        <header style="flex-direction: row" class="cabecalho admin-header">
            <img style="margin: 0 10px" src="../../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-formulario admin-container">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Login de Administrador</h1>
                <?php
                    if ($msg) {
                        echo "<span class='bloco-aviso'>$msg</span>";
                    }
                ?>
                <label for="email" class="label-form-grande obrigatorio">E-mail</label>
                <input type="email" name="email" id="email" class="input-form-grande" required>
                <label for="senha" class="label-form-grande obrigatorio">Senha</label>
                <div class="password-container">
                    <input class="input-form-grande" type="password" name="senha" id="senha" required>
                    <img class="show-password" id="show-password" src="../../../resources/images/eye.svg" alt="show passwd">
                </div>
                
                <p class="texto-obrigatorio">* indica algo obrigatório</p>
                <button disabled id="submit" name="submit" class="botao-strong">Acessar</button>
                <div class="container-formulario-links">
                    <a href="../../Login" class="link-formulario">Não Sou Administrador</a>
                </div>
            </form>
        </main>
    </div>
    <script src="../../../scripts/mostraSenha.js"></script>
    <script src="../../../scripts/requeridosPreenchidos.js"></script>
</body>
</html>