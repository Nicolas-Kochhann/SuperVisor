<?php

session_start();

$_SESSION = array(); // Reseta variáveis da sessão;

session_destroy();

header("location: ../Login");
exit();

?>