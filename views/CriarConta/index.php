<?php
session_start();

// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\models\Usuario;
require __DIR__."/../../vendor/autoload.php";

$erro = '';

# Cadastro de Conta do Aluno
if(isset($_POST['submit'])){
    $usuario = new Usuario(
        $_POST['nome'],
        null,
        $_POST['email'], 
        $_POST['senha']
    );

    if(isset($_SESSION['idUsuario'])){
        $usuario->setIdUsuario($_SESSION['idUsuario']);
        $usuario->atualizar();
    } else if((Usuario::acharUsuarioPeloEmail($usuario->getEmail())) != null){
        $erro = 'Esse e-mail já está cadastrado. Por favor, faça <a class="texto-obrigatorio" href="../Login/">login</a>.';
    } else {
        try{
            $idUsuario = $usuario->cadastrar();
            $_SESSION['idUsuario'] = $idUsuario;
            header('Location: ../EscolherInteresses/');
        } catch(RuntimeException $e){
            $erro = $e->getMessage();
        }
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
                <span class="texto-obrigatorio"><?php echo $erro ?></span>
                <button id="submit" name="submit" class="botao-strong">Próximo</button>
                <a href="../Login/index.php" class="link-formulario">Login</a>
            </form>
        </main>
    </div>
    <script src="../../scripts/verificaSenha.js"></script>
    <script src="../../scripts/mostraSenha.js"></script>
</body>
</html>