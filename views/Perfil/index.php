<?php 

session_start();


require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;

if (isset($_SESSION['idUsuario'])){
    $user = Usuario::acharUsuario($_SESSION['idUsuario']);
}else{
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
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
            <a class="cabecalho-link-botao" href="../Logout/">Sair</a>
        </header>
        <div class="container-listagem" style="background-color: red">
            
        <h1>Editar perfil</h1>
        <form action='index.php'method='POST' enctype="multipart/form-data">
            <input type="file" name="fotoPerfil" accept=".jpeg, .jpg, .png">
            <label for="fotoPerfil">Alterar imagem</label>

            <label for="nome">Nome: </label>
            <input type="text" name="nome">

            <label for="senha">Senha: </label>
            <input type="password" name="senha">

            <label for="disponibilidade">Disponível:</label>
            <input type="radio" id="disponivel" name="disponibilidade" value="disponivel">
            <label for="disponivel">Sim</label>

            <input type="radio" id="indisponivel" name="disponibilidade" value="indisponivel">
            <label for="indisponivel">Não</label>



            <a href="editarInteresses.php">Editar interesses</a>
            <a href="editarDesinteresses.php">Editar desinteresses</a>
            <div>
                <img src="" alt="">
                <span>
                    <h2>Conrad von Hötzendorf</h2>
                    <h3>conrad.pereira@feliz.ifrs.edu.br</h3>
                </span>
            </div>

            <h2>Interesses</h2>
            <div class="bloco-interesses">

            </div>

            <h2>Desinteresses</h2>
            <div class="bloco-interesses">
            </div>

        </div>

    </div>

    <button name=editarPerfil id=editarPerfil>Finalizar</button>
    
</body>
</html>