<?php

    session_start();

    if (isset($_SESSION['idUsuario'])) {
        header("Location:TelaInicial/");
    } else {
        header("Location:Login/");
    }

?>