<?php 
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;
use Src\models\Uploader;

$erro = '';

if (!isset($_SESSION['idUsuario'])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

$user = Usuario::acharUsuario($_SESSION['idUsuario']);
$interesses = $user->acharInteresses();
$desinteresses = $user->acharDesinteresses();
if(isset($_POST['editarPerfil'])){
  if($_POST['nome']){
    if(!empty($_FILES['fotoPerfil']['tmp_name'])){
        $savedImage = Uploader::uploadImage($_FILES['fotoPerfil']);
        if($user->getFotoPerfil() != null){
          Uploader::deleteImage($user->getFotoPerfil());
        }
        $user->setFotoPerfil($savedImage);
    }
    $user->setNome($_POST['nome']);
    if(Usuario::validarSenha($_POST['senha'])){$user->setSenha($_POST['senha']);}
    $user->setDisponivel($_POST['disponibilidade'] == "disponivel" ? true : false);
    $mudarSenha = $_POST['senha'] == "" ? false : true; 
      
    $user->atualizar($mudarSenha);

    $_SESSION['pop-up']['mensagem'] = "Perfil atualizado";

    header('Location: ../TelaInicial/');
    exit();

  } else {
    $erro = 'O campo nome deve estar preenchido';
  }
}

if($user->getFotoPerfil() === ""){
  $user->setFotoPerfil(null);
}

$foto_perfil = $user->getFotoPerfil() ?? 'foto_perfil_padrao.svg';

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
        
    <div class="container-formulario">
      <form class="formulario-grande editar-perfil-form" action="index.php" method="POST" enctype="multipart/form-data">
        <h1 class="titulo-formulario-grande">Editar perfil</h1>


      <div class="avatar-container">
        <img id="previewFoto" src="../../resources/users/<?= $foto_perfil ?>" alt="Foto de perfil" class="foto-perfil" style="height:140px; width:140px;">
        <button type="button" class="camera-btn" onclick="document.getElementById('fotoPerfil').click()">📷</button>
        <input type="file" id="fotoPerfil" name="fotoPerfil" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
      </div>

      <a class="link-formulario" href="excluirImagem.php">Excluir imagem</a>

      <label for="nome" class="label-form-grande obrigatorio">Nome completo:</label>
      <input type="text" class="input-form-grande" name="nome" value="<?= htmlspecialchars($user->getNome()) ?>">

      <label for="senha" class="label-form-grande obrigatorio">Senha</label>
                <div class="password-container">
                    <input class="input-form-grande" type="password" name="senha" id="senha">
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

      <?php
      
      if ($user->getTipo() == 'professor') {
          echo '
          <div class="disponibilidade-container">
            <span class="label-form-grande">Disponível:</span>

            <label>
              <input type="radio" name="disponibilidade" value="disponivel"
                ' . ($user->getDisponivel() ? "checked" : "") . '>
              Sim
            </label>

            <label>
              <input type="radio" name="disponibilidade" value="indisponivel"
                ' . (!$user->getDisponivel() ? "checked" : "") . '>
              Não
            </label>
          </div>
          ';
      }


      ?>

      <div class="links-edicao">
        <a href="EditarInteresses/" class="botao-strong">Editar interesses</a>
        <a href="EditarDesinteresses/" class="botao-strong">Editar desinteresses</a>
      </div>
      <?php

      if($erro){
        echo "<span class='bloco-erro'>$erro</span>";
      }

      ?>      
      <button type="submit" name="editarPerfil" id="submit" class="botao-strong">Finalizar</button>
      <a class="link-formulario" href="../TelaInicial">Cancelar</a>
    </form>
  </div>

</div>

<?php


  if(isset($_SESSION["pop-up"])){
    echo "<div id='popup' class='popup esconder'>{$_SESSION['pop-up']['mensagem']}</div>";
    unset($_SESSION["pop-up"]);
  }

  
?>
<script src="../../scripts/esconderPopUp.js"></script>
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
      const output = document.getElementById('previewFoto');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
<script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>

<script src="../../scripts/verificaSenha.js"></script>
<script src="../../scripts/mostraSenha.js"></script>


</body>
</html>

