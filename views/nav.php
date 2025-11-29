<aside class="menu" id="menu">
    <?php
    if (isset($_SESSION["tipo"])) {
        if($_SESSION["tipo"]=="professor"){
            echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
        }else{
            echo "<a href='../MinhasSolicitacoes'>Minhas solicitações</a>
            <a href='../TelaInicial/index.php'>Ver Professores</a>";
        }   
        echo "<a href='../Perfil/index.php'>Editar Perfil</a>";
        echo "<a href='https://www.billyorg.com/2025/projeto/grupo4/index.php?id={$_SESSION['idUsuario']}'>AAGIS</a>";
        echo "<a href='../Logout/'>Sair</a>";
    } else {
        echo "<a href='../../Logout/'>Sair</a>";
    }
    ?> 
    
</aside>
