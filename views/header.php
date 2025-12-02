<header class="cabecalho">
    <div class="menu-btn" id="menu-btn" href="../Perfil" class="container-mini-perfil">
        <p style="margin:0 10px 0 0"><?= $_SESSION["nome"] ?></p>
        <img style="height:100%; background-color: #ffffff;" class='foto-redonda-listagem' src='../../resources/users/<?php if($_SESSION["imagem"] !== null and $_SESSION["imagem"] !== ""){ echo $_SESSION["imagem"]; } else { echo "foto_perfil_padrao.svg"; } ?>'>
        <svg style="height:70%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#ffffff" d="M297.4 470.6C309.9 483.1 330.2 483.1 342.7 470.6L534.7 278.6C547.2 266.1 547.2 245.8 534.7 233.3C522.2 220.8 501.9 220.8 489.4 233.3L320 402.7L150.6 233.4C138.1 220.9 117.8 220.9 105.3 233.4C92.8 245.9 92.8 266.2 105.3 278.7L297.3 470.7z"/></svg>
    </div>

    <aside class="menu" id="menu">
        <?php
        if (isset($_SESSION["tipo"])) {
            if($_SESSION["tipo"]=="professor"){
                echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
            }else{
                echo "<a href='../MinhasSolicitacoes'>Minhas Solicitações</a>
                <a href='../TelaInicial/index.php'>Ver Professores</a>";
            }   
            echo "<a href='../Perfil/index.php'>Editar Perfil</a>";
            echo "<a href='https://billyorg.com/2025/projeto/grupo4/index.php?id={$_SESSION['idUsuario']}'>AAGIS</a>";
            echo "<a href='../Logout/'>Sair</a>";
        } else {
            echo "<a href='../../Logout/'>Sair</a>";
        }
        ?> 
        
    </aside>

    <div class="div-cabecalho">
        <img src="../../resources/images/logo.png" alt="Logo SuperVisor" class="logo-cabecalho">
    </div>
</header>


