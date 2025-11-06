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
                <input type="text" name="empresa" id="empresa" required>
                
                <label for="area-atuacao">Área de Atuação</label>
                <input type="text" name="area-atuacao" id="area-atuacao" required>

                <label for="tipo-estagio">Tipo de Estágio</label>
                <select name="tipo-estagio" id="tipo-estagio" required>
                    <option value="obrigatorio">Obrigatório</option>
                    <option value="nao-obrigatorio">Não Obrigatório</option>
                    <option value="nao-sei">Não Sei</option>
                </select>

                <span class="multi-input-box">
                    <label for="carga-horaria">Carga Horária Semanal</label>
                    <input type="number" name="carga-horaria" id="carga-horaria">

                    <label for="turno">Turno</label>
                    <select name="turno" id="turno">
                        <option value="manha">Manhã</option>
                        <option value=""></option>
                    </select>
                </span>

                <label for="obs">Obs.</label>
                <textarea name="obs" id="obs">-</textarea>
            </form>
        </main>

    </div>
</body>
</html>