<?php
require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;

if(isset($_POST['submit'])){
    if($u=Usuario::autenticar($_POST['email'],$_POST['senha'])){
        session_start();
        $_SESSION['usuario']=$u;
        header("location: ../TelaInicial/index.php");
        exit();
    }else{
        header("location: index.php");
        exit();
    }
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
            <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-formulario">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Login</h1>
                <label for="email" class="label-form-grande obrigatorio">E-mail</label>
                <input type="email" name="email" id="email" class="input-form-grande" required>
                <label for="senha" class="label-form-grande obrigatorio">Senha</label>
                <div class="password-container">
                    <input class="input-form-grande" type="password" name="senha" id="senha" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <p class="texto-obrigatorio">* indica algo obrigatório</p>
                
                <button id="submit" name="submit" class="botao-strong">Acessar</button>
                <a href="" class="link-formulario">Cadastro</a>
            </form>
        </main>
    </div>
    <script src="../../scripts/mostraSenha.js"></script>
</body>
</html>