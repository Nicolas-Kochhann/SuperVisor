<?php 

session_start();

require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;
use Src\models\Uploader;

if (!isset($_SESSION['idUsuario'])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

$user = Usuario::acharUsuario($_SESSION['idUsuario']);
$interesses = $user->acharInteresses();
$desinteresses = $user->acharDesinteresses();
if(isset($_POST['editarPerfil'])){
  if(!empty($_FILES['fotoPerfil']['tmp_name'])){
      $savedImage = Uploader::uploadImage($_FILES['fotoPerfil']);
      if($user->getFotoPerfil() != null){
        Uploader::deleteImage($user->getFotoPerfil());
      }
      $user->setFotoPerfil($savedImage);
    }
    $user->setNome($_POST['nome']);
    $user->setStatus(0);
    if($user->validarSenha($_POST['senha'])){ $user->setSenha($_POST['senha']); }
    $user->setDisponivel($_POST['disponibilidade'] == "disponivel" ? true : false);
    $mudarSenha = $_POST['senha'] == "" ? false : true; 
    $user->atualizar($mudarSenha);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperVisor</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="icon" href="../../resourcesE" class="botao-strong"/images/favicon.ico">
</head>
<body>
<div class="container">
        <header class="cabecalho">
            <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
            <a class="cabecalho-link-botao" href="../Logout/">Sair</a>
        </header>
    <div class="container-formulario">
    <form class="formulario-grande editar-perfil-form" action="index.php" method="POST" enctype="multipart/form-data">
      <h1 class="titulo-formulario-grande">Editar perfil</h1>

      <div class="foto-container">
        <input type="file" id="fotoPerfil" name="fotoPerfil" accept=".jpeg, .jpg, .png">
        <label for="fotoPerfil" class="link-formulario">Alterar imagem</label>
      </div>

      <label for="nome" class="label-form-grande">Nome completo:</label>
      <input type="text" class="input-form-grande" name="nome" value="<?= htmlspecialchars($user->getNome()) ?>">

      <label for="senha" class="label-form-grande">Senha:</label>
      <input type="password" class="input-form-grande" name="senha">

      <div class="bloco-info">
                    <p>A senha deve conter:
                        <ul class="lista-info">
                            <li id="tamanho">8 caracteres ou mais</li>
                            <li id="letra">Pelo menos uma letra</li>
                            <li id="numero">Pelo menos um número</li>
                        </ul>
                    </p>
        </div>

      <?php
      
      if($user->getTipo() == 'professor'){
        echo'
        <div class="disponibilidade-container">
          <span class="label-form-grande">Disponível:</span>
          <label><input type="radio" name="disponibilidade" value="disponivel"> Sim</label>
          <label><input type="radio" name="disponibilidade" value="indisponivel"> Não</label>
        </div>
        ';
      }

      ?>

      <div class="links-edicao">
        <a href="EditarInteresses/" class="botao-strong">Editar interesses</a>
        <a href="EditarDesinteresses/" class="botao-strong">Editar desinteresses</a>
      </div>
      <button type="submit" name="editarPerfil" id="editarPerfil" class="botao-strong">Finalizar</button>
    </form>
  </div>

</div>
    
</body>
</html>