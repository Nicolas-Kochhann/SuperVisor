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
                <label class="label-form-grande obrigatorio">Nome Completo
                    <input type="text" name="nome" id="nome" class="input-form-grande" required>
                </label>
                <label class="label-form-grande obrigatorio">E-mail
                    <input type="email" name="email" id="email" class="input-form-grande" required>
                </label>
                <label class="label-form-grande obrigatorio">Senha
                    <input type="password" name="senha" id="senha" pattern="(?=.*\d).{8,}" title="Deve conter 8 ou mais caracteres e pelo menos um número e uma letra" class="input-form-grande" required>
                </label>
                <div class="bloco-info">
                    <p>A senha deve conter:
                        <ul class="lista-info">
                            <li>8 caracteres ou mais</li>
                            <li>Pelo menos uma letra</li>
                            <li>Pelo menos um número</li>
                        </ul>
                    </p>
                </div>
                <p class="texto-obrigatorio">* - indica um dado obrigatório</p>
                <button class="botao-strong">Próximo</button>
                <a href="" class="link-formulario">Login</a>
            </form>
        </main>

    </div>
</body>
</html>