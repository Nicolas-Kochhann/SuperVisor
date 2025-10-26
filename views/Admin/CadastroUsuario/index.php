<?php

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\models\Usuario;
require __DIR__."/../../vendor/autoload.php";

$erro = '';

if(isset($_POST['submit'])){
    if(Usuario::validarEmail($_POST['email']) and Usuario::validarSenha($_POST['senha'])){
        $usuario = new Usuario($nome, $foto_perfil, $email, $senha);
        $usuario->cadastrar();
        header('Location: ../../../index.php');
    } else {
        $erro = 'Email ou senha inválida';
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

        <header class="cabecalho">
            <img src="../../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-formulario">
            <form method="POST" action="index.php" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Cadastro de Usuário</h1>
                <label for="email" class="label-form-grande obrigatorio">E-mail</label>
                <input type="email" name="email" id="email" class="input-form-grande" required>
                <label for="senha" class="label-form-grande obrigatorio">Senha</label>
                <div class="password-container">
                    <input class="input-form-grande" type="password" name="senha" id="senha" required>
                    <img class="show-password" id="show-password" src="../../../resources/images/eye.svg" alt="show passwd">
                </div>
                <label for="nome" class="label-form-grande obrigatorio">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="input-form-grande" required>
                <p class="texto-obrigatorio">* indica algo obrigatório</p>
                <button id="submit" name="submit" class="botao-strong">Cadastrar</button>
                <a href="" class="link-formulario">Voltar</a>
            </form>
        </main>

    </div>
    <script src="../../../scripts/mostraSenha.js"></script>
</body>
</html>