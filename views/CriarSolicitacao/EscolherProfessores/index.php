<?php
// Mostra todos os erros na tela
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/../../../vendor/autoload.php";

use Src\models\Usuario;
use Src\models\Solicitacao;

session_start();

if (!isset($_SESSION["idUsuario"])) {
    $_SESSION["error"] = "É necessário entrar na sua conta antes disso.";
    header("location: ../../Login/");
    exit();
}

$usuarioLogado = Usuario::acharUsuario($_SESSION["idUsuario"]);

$professores = Usuario::listarProfessoresDisponiveis();

foreach ($professores as $professor) {
    $professor->calcularInteressesEmComum($usuarioLogado->acharInteresses());
    $professor->calcularDesinteressesEmComum($usuarioLogado->acharInteresses());
}


usort($professores, function ($a, $b) {
    return $b->getInteressesEmComum() <=> $a->getInteressesEmComum();
});

if (isset($_POST['submit'])) {
    $s = new Solicitacao(
        $_SESSION['solicitacao']['empresa'], 
        $_SESSION['solicitacao']['area-atuacao'], 
        $_SESSION['solicitacao']['tipo-estagio'], 
        $_SESSION['idUsuario']
    );

    $s->setCargaHorariaSemanal($_SESSION['solicitacao']['carga-horaria']);
    $s->setTurno($_SESSION['solicitacao']['turno']);
    $s->setObs($_SESSION['solicitacao']['obs']);

    $solicitacaoId = $s->cadastrar();

    foreach ($_POST['professores'] as $prof) {
        Solicitacao::relacionarProfessor($prof, $solicitacaoId, 2);
    }

    $_SESSION['pop-up']['mensagem'] = "Solicitação criada";

    header("Location: ../../MinhasSolicitacoes/");
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
    <div style="overflow-y: hidden;" class="container">

        <header style="flex-direction: row" class="cabecalho">
            <img style="margin: 0 10px" src="../../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
        </header>

        <main class="container-listagem-solicitacao">
            <h2 class="titulo1">Selecione professores</h2>
            <h3 class="titulo2" style="color:#8b8b8b">Escolha pelo menos 1</h3>
            <form style="height:calc(100% - 70px)" action="index.php" method="POST">

                <div class="container-bloco-listagem-scrollavel">
                    <?php
                    if (count($professores) !== 0) {
                        foreach ($professores as $professor) {
                            if (count($professor->acharInteresses()) < 3) {
                                continue;
                            }

                            if ($professor->getDisponivel() === false) {
                                continue;
                            }

                            $foto_perfil = $professor->getFotoPerfil() ?? 'foto_perfil_padrao.svg';
                            if ($foto_perfil === "") {
                                $foto_perfil = null;
                            }

                            echo "<div> <!-- DIV CRIADA PARA CADA ITEM DA LISTAGEM -->
                                <input class='input-selecionar-convite' type='checkbox' name='professores[]' id='{$professor->getIdUsuario()}' value='{$professor->getIdUsuario()}'> 
                                <label for='{$professor->getIdUsuario()}' class='container-item-listagem item-listagem-clicavel'>
                                    <div class='item-listagem'>
                                        <img class='foto-redonda-listagem' src='../../../resources/users/{$foto_perfil}' alt='Foto de um professor'> <!-- FOTO DE PERFIL DO PROFESSOR NO src -->
                                        <p class='texto-listagem'>{$professor->getNome()}</p> <!-- NOME DO PROFESSOR -->
                                        <div class='container-contadores-listagem'> 
                                            <span class='contador-interesses-listagem'>{$professor->getInteressesEmComum()}</span> <!-- NUM DE INTERESSES EM COMUM COM O USUÁRIO LOGADO -->
                                            <span class='contador-desinteresses-listagem'>{$professor->getDesinteressesEmComum()}</span> <!-- n sei o que escrever aqui, O CONTRÁRIO DO OUTRO span -->
                                        </div>
                                    </div>
                                </label>
                            </div>";
                        }
                    } else {
                        echo "<p class='titulo2' style='margin: 15px 0 0 0; font-style: italic'>Nenhum professor disponível atualmente.</p>";
                    }
                    ?>

                </div>
                <div style="width:100%; display:flex; flex-direction:line-reverse">
                    <a style="font-size:23px; align-content:center" class="link-formulario" href="..">Retornar</a>
                    <button disabled style="margin: 10px 0 0 auto; padding:10px; text-decoration:underline" class="botao-strong" name="submit" id="submit">Enviar Solicitação</button>
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