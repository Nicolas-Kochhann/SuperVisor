<?php

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

        <main class="container-criar-solicitacao">
            <form class="form-criar-solicitacao" action="index.php" method="POST">
                <h2 class="titulo1">Criar Solicitação de Orientação</h2>
                <p>Tudo que você preencher aqui será visível para os professores selecionados.</p>

                <label for="empresa">Nome da Empresa</label>
                <input type="text" name="empresa" id="empresa">
                
                <label for="area-atuacao">Área de Atuação</label>
                <input type="text" name="area-atuacao" id="area-atuacao">

                <label for="tipo-estagio">Tipo de Estágio</label>
                <select name="tipo-estagio" id="tipo-estagio">
                    <option value="obrigatorio">Obrigatório</option>
                    <option value="nao-obrigatorio">Não Obrigatório</option>
                    <option value="nao-sei">Não Sei</option>
                </select>
            </form>
        </main>

    </div>
</body>
</html>