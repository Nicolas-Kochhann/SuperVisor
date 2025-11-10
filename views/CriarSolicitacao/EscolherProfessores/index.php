<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../../vendor/autoload.php";

use Src\models\Usuario;

session_start();

if(!isset($_SESSION["idUsuario"])){
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../Login/");
    exit();
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$professores = Usuario::listarProfessores();

foreach($professores as $professor){
    $professor->calcularInteressesEmComum($usuarioLogado->acharInteresses());
    $professor->calcularDesinteressesEmComum($usuarioLogado->acharInteresses());
}


usort($professores, function($a, $b){ return $b->getInteressesEmComum() <=> $a->getInteressesEmComum(); });

if(isset($_POST['submit'])){
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperVisor</title>
    <link rel="stylesheet" href="../../../styles/style.css">
    <link rel="icon" href="../../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">

        <header class="cabecalho">
            <img src="../../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-listagem">
            <h2 class="titulo1">Selecione professores</h2>
            <h3 class="titulo2" style="color:#8b8b8b">Escolha pelo menos 1</h3>
            <form style="height:calc(100% - 70px)" action="index.php" method="POST">

            <div class="container-bloco-listagem-scrollavel">
                <?php
                
                echo"<p class='list-legend-green'>*Indica os interesses comuns entre você e o professor</p> <br> 
                <p class='list-legend-red'>*Indica seus interesses que o professor está desinteressado</p>"; // pq caralhos isso tá em um eco??????????????
                foreach($professores as $professor){
                    if(count($professor->acharInteresses()) < 3){
                        continue;
                    }
                    $foto_perfil = $professor->getFotoPerfil() ?? 'foto_perfil_padrao.svg';
                    echo "<div class='item-listagem'> <!-- DIV CRIADA PARA CADA ITEM DA LISTAGEM -->
                            <input class='input-selecionar-convite' type='checkbox' name='profesores[]' id='1' value='{$professor->getIdUsuario()}'> 
                            <label for='1' class='container-item-listagem item-listagem-clicavel'>
                                <div class='item-listagem'>
                                    <img class='foto-redonda-listagem' src='../../resources/users/{$foto_perfil}' alt='Foto de um professor'> <!-- FOTO DE PERFIL DO PROFESSOR NO src -->
                                    <p class='texto-listagem'>{$professor->getNome()}</p> <!-- NOME DO PROFESSOR -->
                                </div>
                            </label>
                            <div class='container-contadores-listagem'> 
                                <span class='contador-interesses-listagem'>{$professor->getInteressesEmComum()}</span> <!-- NUM DE INTERESSES EM COMUM COM O USUÁRIO LOGADO -->
                                <span class='contador-desinteresses-listagem'>{$professor->getDesinteressesEmComum()}</span> <!-- n sei o que escrever aqui, O CONTRÁRIO DO OUTRO span -->
                            </div>
                        </div>";
                }
                
                ?>
               
            </div>
            <div style="width:100%; display:flex; flex-direction:line-reverse">
                <button disabled style="margin: 0 0 0 auto; padding:10px; text-decoration:underline" class="botao-strong" name="submit" id="submit">Enviar Solicitação</button>
            </div>
            </form>
        </main>

    </div>
    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const button = document.getElementById('submit');

        function updateButtonState() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            button.disabled = !anyChecked;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateButtonState));
    </script>
</body>
</html>