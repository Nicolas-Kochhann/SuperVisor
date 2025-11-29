<?php

session_start();

require_once __DIR__."/../../vendor/autoload.php";
use Src\models\Uploader;
use Src\models\Usuario;

$usuario = Usuario::acharUsuario($_SESSION["idUsuario"]);

$foto_perfil = $usuario->getFotoPerfil();

if(!$foto_perfil){
    header('Location: index.php');
}

Uploader::deleteImage($foto_perfil);

$usuario->removerFotoPerfil();
$_SESSION["imagem"] = null;

header('Location: index.php');