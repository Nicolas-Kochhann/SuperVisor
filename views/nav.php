<aside class="menu" id="menu">
    <?php
    if (isset($_SESSION["tipo"])) {
        if($_SESSION["tipo"]=="professor"){
            echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
        }else{
            echo "<a href='../MinhasSolicitacoes'>Ver minhas solicitações</a>
            <a href='../CriarSolicitacao/index.php' >Nova Solicitação</a>
            <a href='../TelaInicial/index.php'>Ver Professores</a>";
        }   
        echo "<a href='../Perfil/index.php'>Editar Perfil</a>";
        echo "<a href='billyorg.com/2025/projeto/grupo4/index.php?id={$_SESSION['idUsuario']}'>AAGIS</a>";
        echo "<a href='../Logout/'>Sair</a>";
    }
    ?>  
    
    
    <a href="../../Logout/">Sair</a>  
</aside>
