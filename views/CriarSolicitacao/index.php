<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__."/../../vendor/autoload.php";
use Src\models\Solicitacao;

session_start();

// Quando o submit tá setado, joga pra página de selecionar professores
// Isso provavelmente vai ser um inferno de fazer
// Boa sorte back enzos 👌
// fuck you asshole 👹👹

if (isset($_POST["submit"])) {
    /*
    echo $_POST['empresa'];
    echo "<br>";
    echo $_POST['area-atuacao'];
    echo "<br>";
    echo $_POST['tipo-estagio'];
    echo "<br>";
    echo $_POST['carga-horaria'];
    echo "<br>";
    echo $_POST['turno'];
    echo "<br>";
    echo $_POST['obs'];
    echo "<br>";
    */

    $_SESSION['solicitacao']['empresa'] = $_POST['empresa'];
    $_SESSION['solicitacao']['area-atuacao'] = $_POST['area-atuacao'];
    $_SESSION['solicitacao']['tipo-estagio'] = $_POST['tipo-estagio'];
    $_SESSION['solicitacao']['carga-horaria'] = $_POST['carga-horaria']== "" ? null : (int)$_POST['carga-horaria'];
    $_SESSION['solicitacao']['turno'] = $_POST['turno'];
    $_SESSION['solicitacao']['obs'] = $_POST['obs'] == "" ? null : "'" . $_POST['obs'] . "'";
    
    header("Location: ./EscolherProfessores/index.php");
    
}

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

        <main class="container-formulario">
            <form class="formulario-grande" action="index.php" method="POST">
                <h2 class="titulo1">Criar Solicitação de Orientação</h2>
                <p class="text-info">Tudo que você preencher aqui será visível para os professores selecionados.</p>

                <label for="empresa" class="label-form-grande obrigatorio">Nome da Empresa</label>
                <input class="input-form-grande" type="text" name="empresa" id="empresa" required>
                
                <label for="area-atuacao" class="label-form-grande obrigatorio">Área de Atuação</label>
                <input class="input-form-grande" type="text" name="area-atuacao" id="area-atuacao" required>
                
                <span class="multi-input-box">
                    <div style="flex:1">
                        <label for="tipo-estagio" class="label-form-grande obrigatorio">Tipo de Estágio</label>
                        <select class="input-form-grande" name="tipo-estagio" id="tipo-estagio" required>
                            <option value="obrigatorio">Obrigatório</option>
                            <option value="nao-obrigatorio">Não Obrigatório</option>
                            <option value="nao-sei">Não Sei</option>
                        </select>
                    </div>
                    <div style="flex:1">
                        <label for="turno" class="label-form-grande">Turno do Estágio</label>
                        <select class="input-form-grande" name="turno" id="turno">
                            <option value="nao-sei">Não Sei</option>
                            <option value="manha">Manhã</option>
                            <option value="tarde">Tarde</option>
                        </select>
                    </div>
                </span>

                <label for="carga-horaria" class="label-form-grande">Carga Horária Semanal</label>
                <input class="input-form-grande" style="width:10ch" type="number" name="carga-horaria" id="carga-horaria" min="1" max="30" value=null>

                <label for="obs" class="label-form-grande">Obs.</label>
                <textarea class="input-form-grande" name="obs" id="obs"></textarea>

                <button disabled class="botao-strong" id="submit" name="submit">Escolher Professores</button>
                <a class="link-formulario" href="../TelaInicial">Cancelar</a>
            </form>
        </main>

    </div>
    <script src="../../scripts/requeridosPreenchidos.js"></script>
    <script>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    menuBtn.addEventListener('click', () => {
        menu.classList.toggle('ativo');
    });
</script>
</body>
</html>