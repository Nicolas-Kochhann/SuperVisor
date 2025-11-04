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
    <title>Document</title>
</head>
<body>
    
</body>
</html>