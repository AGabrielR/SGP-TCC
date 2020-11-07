<?php 

if(!function_exists("protege")){

    function protege(){
        
        if(!isset($_SESSION))
            session_start();

        if(!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])){
            header("location: http://localhost/SGProjetos/views/tela_login.php");
        }
    }
}

?>