<aside class="menu" id="menu">
    <?php
    if($_SESSION["tipo"]=="professor"){
    echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
    }else{
        echo "<a href='../CriarSolicitacao/' >Nova Solicitacao</a>
        <a href='../TelaInicial/' >Tela Inicial</a>";
    }
    
    ?>
    <a href="../Perfil/index.php">Editar Perfil</a>
    <a href="../Logout/">Sair</a>     
    
</aside>