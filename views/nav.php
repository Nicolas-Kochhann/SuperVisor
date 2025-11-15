<aside class="menu" id="menu">
    <?php
    if($_SESSION["tipo"]=="professor"){
    echo"<a href='../ListarSolicitacao/'>Ver minhas solicitações</a>";
    }else{
<<<<<<< HEAD
        echo "<a href='../CriarSolicitacao/index.php' >Nova Solicitação</a>";
    }   
    ?>  
    <a href="../TelaInicial/index.php" >Tela Inicial</a>
    <a href="../VisualizarSolicitacaoAluno">Ver minhas solicitações</a>
</aside>
=======
        echo "<a href='../CriarSolicitacao/' >Nova Solicitacao</a>
        <a href='../TelaInicial/' >Tela Inicial</a>";
    }

    
    ?>
    <a href="../Perfil/index.php">Editar Perfil</a>
    <a href="../Logout/">Sair</a>     
    
</aside>

>>>>>>> d8a4cad22a5b69e6bd8973b315dadf194999b248
