<?php

# Cadastro de Conta do Aluno

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
            <form method="POST" action="" enctype="multipart/form-data" class="formulario-grande">
                <h1 class="titulo-formulario-grande">Cadastro</h1>
                <label for="nome" class="label-form-grande obrigatorio">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="input-form-grande" required>
                <label for="email" class="label-form-grande obrigatorio">E-mail</label>
                <input type="email" name="email" id="email" class="input-form-grande" required>
                <label for="senha" class="label-form-grande obrigatorio">Senha</label>
                <div class="password-container">
                    <input class="input-form-grande" type="password" name="senha" id="senha" required>
                    <img class="show-password" id="show-password" src="../../resources/images/eye.svg" alt="show passwd">
                </div>
                <div class="bloco-info">
                    <p>A senha deve conter:
                        <ul class="lista-info">
                            <li id="tamanho">8 caracteres ou mais</li>
                            <li id="letra">Pelo menos uma letra</li>
                            <li id="numero">Pelo menos um número</li>
                        </ul>
                    </p>
                </div>
                <p class="texto-obrigatorio">* indica algo obrigatório</p>
                <button class="botao-strong">Próximo</button>
                <a href="" class="link-formulario">Login</a>
            </form>
        </main>
    </div>
    <script src="../../scripts/verificaSenha.js"></script>
    <script src="../../scripts/mostraSenha.js"></script>
</body>
</html>