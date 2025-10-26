<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;

$msg = ""; 

if(isset($_POST['submit'])){
    if(Usuario::autenticar($_POST['email'],$_POST['senha'])){
        $usuario = Usuario::acharUsuario($_SESSION['idUsuario']);
        if($_SESSION['status']==0 and count($usuario->acharInteresses()) >= 3){
            header( header: "location: ../TelaInicial/");
            exit();  
        }elseif($_SESSION["status"]==0 and count($usuario->acharInteresses()) < 3){
            header("location: ../EscolherInteresses/");
            exit();
        }else{
            $msg="Usuário inativo! solicite ativação ao Administrador";
        }
    }else{
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
                <p class="texto-obrigatorio"><?php echo $msg; ?></p>
                <button id="submit" name="submit" class="botao-strong">Acessar</button>
                <a href="../CriarConta/index.php" class="link-formulario">Cadastro</a>
            </form>
        </main>
    </div>
    <script src="../../scripts/mostraSenha.js"></script>
    <script>
        if (performance.navigation.type === 1) {
            const msgEl = document.querySelector('.texto-obrigatorio:last-of-type');
            if (msgEl) msgEl.textContent = "";
        }
    </script>
</body>
</html>