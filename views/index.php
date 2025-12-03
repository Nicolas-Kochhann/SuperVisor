<?php

    session_start();

    if (isset($_SESSION['idUsuario'])) {
        header("Location:TelaInicial/");
        if($_SESSION["tipo"]!="professor"){
            header("location: ListagemEstagiosAluno/");
            exit();     
        }else{
            header("location: ListarSolicitacao/");
            exit();
        }
    } else {
        header("Location:Login/");
    }

?>