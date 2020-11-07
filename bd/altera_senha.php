<?php
if(isset($_POST['chave'])){
   include("../bd/conexao.php"); 

    $email =  $conexao->escape_string($_POST['email']);
    $senha = md5(md5($_POST['Senha']));
    $chave = $_POST['chave'];

    $chave = preg_replace('/[^[:alnum:]]/','',$chave);

    $sql = "select id, senha, email from login where email=?";
    $sqlprep = $conexao->prepare($sql);
    $sqlprep->bind_param("s", $email);
    $sqlprep->execute();
    $resultadoSql = $sqlprep->get_result();
    $usuario = mysqli_fetch_assoc($resultadoSql);
    $chaveUsuario = md5($usuario['id'].$usuario['senha']);

    if($chave == $chaveUsuario){
        $idEditar = $usuario['id'];
        $sql = "UPDATE login set senha='$senha' where id='$idEditar';";
        mysqli_query($conexao, $sql);
        ?>
            <script>
                alert('Senha alterada com sucesso');
                window.location="../views/tela_login.php"
            </script>
        <?php
    } else {
        ?>
            <script>
                alert('Falha ao alterar a senha');
                window.location="../views/tela_login.php"
            </script>
        <?php
    }

} else {
    header('location: ../views/tela_login.php');
}
?>