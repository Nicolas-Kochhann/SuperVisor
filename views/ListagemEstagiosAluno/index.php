<?php

session_start()

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SVAAGIS</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="icon" href="../../resources/images/favicon.ico">
</head>
<body>
    <div class="container">

        <?php require __DIR__."/../header.php"; ?>

        <main class="container-listagem-estagios">
            <table class="tabela-listagem-estagios">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Orientador</th>
                        <th>Período</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Anselmi</td>
                        <td>Túlio Baségio</td>
                        <td>04/04/2025 - 01/10/2025</td>
                        <td>Ativo</td>
                        <td><span style="display: flex; gap: 10px">
                            <a href="https://billyorg.com/2025/projeto/grupo4/editar.php?idEstagio=">Editar</a>
                            <p>|</p>
                            <a href="https://billyorg.com/2025/projeto/grupo4/visualizacao.php?idEstagio=">Visualizar Dados</a>
                            <p>|</p>
                            <a href="https://billyorg.com/2025/projeto/grupo4/listagemDoc.php?idEstagio=">Documentos</a>
                        </span></td>
                    </tr>
                    <tr>
                        <td>Anselmi</td>
                        <td>Túlio Baségio</td>
                        <td>04/04/2025 - 01/10/2025</td>
                        <td>Ativo</td>
                        <td><span style="display: flex; gap: 10px">
                            <a href="https://billyorg.com/2025/projeto/grupo4/editar.php?idEstagio=">Completar Cadastro</a>
                        </span></td>
                    </tr>
                </tbody>
            </table>
        </main>

    </div>

    <script src="../../scripts/menuButton.js"></script>
</body>
</html>