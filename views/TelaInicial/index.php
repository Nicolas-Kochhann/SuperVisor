
<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../vendor/autoload.php";
use Src\models\Usuario;

session_start();
if(!isset($_SESSION['idUsuario'])){
    header("location:index.php");
    exit();
}

$usuario = Usuario::acharUsuario($_SESSION["idUsuario"]);
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
            <?php
            $professores=Usuario::listarProfessores();
            foreach($professores as $professor) {
                
            }
    
            ?>
        </main>
    </div>
</body>
</html>