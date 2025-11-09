<?php

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
                <div> <!-- DIV CRIADA PARA CADA ITEM DA LISTAGEM -->
                    <input class="input-selecionar-convite" type="checkbox" name="1" id="1">
                    <label for="1" class="container-item-listagem item-listagem-clicavel">
                        <div class='item-listagem'>
                            <img class='foto-redonda-listagem' src='../../../resources/images/placeholders/professor.png' alt='Foto de um professor'> <!-- FOTO DE PERFIL DO PROFESSOR NO src -->
                            <p class='texto-listagem'>Conrad von Hötzendorf</p> <!-- NOME DO PROFESSOR -->
                        </div>
                    </label>
                </div>
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