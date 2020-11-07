<?php        
        
$host = "localhost";
$usuario = "root";
$senha = "";
$bd = "sgprojetos";

// $conexao = mysqli_connect($host, $usuario, $senha, $bd);

$conexao = new mysqli($host, $usuario, $senha, $bd);

if($conexao->connect_errno)
        echo('falha na conexão: ('.$conexao->connect_errno.') '.$conexao->connect_error);

?>