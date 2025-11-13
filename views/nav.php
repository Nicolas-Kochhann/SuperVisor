<aside class="menu" id="menu">
    <?php
    if($_SESSION["tipo"]=="professor"){
    echo"<a href='../ListarSolicitacao/index.php'>Ver minhas solicitações</a>";
    }else{
        echo "<a href='../CriarSolicitacao/index.php' >Nova Solicitacao</a>
        <a href='../TelaInicial/index.php' >Tela Inicial</a>";
    }   
    ?>  
    
</aside>