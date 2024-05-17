<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        die("Você não pode acessar essa página pois você não está logado. <p><a href='/trabalho/ProjetoFinalPhp/index.php'>Clique aqui para fazer login</a></p>");
    }
?>