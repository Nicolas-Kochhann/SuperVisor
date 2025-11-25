<aside class="menu" id="menu">
    <?php
    if($_SESSION["tipo"]=="professor"){
    echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
    }else{
        echo "<a href='../CriarSolicitacao/index.php' >Nova Solicitação</a>
        <a href='../TelaInicial/index.php'>Tela Inicial</a>
        <a href='../MinhasSolicitacoes'>Ver minhas solicitações</a>";
    }   
    ?>  
    
    <a href="billyorg.com/2025/projeto/grupo4/index.php?id=<?= $_SESSION['idUsuario'] ?>">AAGIS</a>
    <a href="../Perfil/index.php">Editar Perfil</a>
    <a href="../Logout/">Sair</a>  
</aside>
