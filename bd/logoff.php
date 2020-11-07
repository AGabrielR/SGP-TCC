<?php 
    require_once('conexao.php');
    require_once("../views/navbar/navbar.php");

    unset($_SESSION["nome"]);
    unset($_SESSION["prioridade"]);
    unset($_SESSION["tipoLogin"]);
    unset($_SESSION["id"]);
    if(isset($_SESSION["ADMIN"])){
        unset($_SESSION["ADMIN"]); 
    }

    session_destroy();

    header('location: ../index.php');
?>