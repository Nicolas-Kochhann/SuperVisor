<?php

session_start();

if(!isset($_SESSION['idUsuario'])){
    header('Location: ../Login/');
}

if(!$_SESSION['tipo'] === 'aluno'){
    header('Location: ../Login/');
}

var_dump($_SERVER['REQUEST_URI']);

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
    
</body>
</html>