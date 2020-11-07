<head>
    <meta charset="utf-8">
    <title>Login</title>
    	
</head>

<body>
<?php 
    require_once('navbar/navbar.php');

    if(isset($_SESSION['tipoLogin'])){
        header('location: projetos.php');
    }
?>

<br>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <h1>Recuperar Senha</h1>
            </div>
            <div class="col-sm-4 col-md-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuLateral" aria-controls="menuLateral" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span> Menu
                    </button>   
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-3">
            <nav class="navbar navbar-expand-lg navbar-light">
                <?php require_once("navbar/menu_lateral.php") ?>
            </nav>
        </div>
        <div class="col-xl-9 col-lg-9">
            <div class="row">
                <!-- <div class="col-md-4 offset-md-4">
                    <br><br><br><br><br>
                    <h1 class="text-center text-danger"><strong>SE FERROU</strong></h1>
                </div> -->
                <div class="col-sm-6 offset-sm-3 col-md-6 offset-md-3 col-lg-6 offset-lg-2 col-xl-5 offset-xl-3">
                    <form name="formLogin" class="form-group" method="POST" action="">
                        <div class="text-center mb-4">
                            <img class="mb-4" src="../imagens/logo.png" alt="" width="100" height="100">
                        </div>
                        <label for="inputCPF">Email</label>
                        <input type="email" id="inputEmail" class="form-control" name="email" 
                        placeholder="Digite seu email:" required autofocus>
                        
                        <h6 class="text-danger">Será enviado uma nova senha a este email</h6>
                        <br>
                        <input name="ok" type="hidden" id="ok" placeholder="Enviar e-mail">
                        <button type="submit" class="btn btn-lg btn-outline-primary btn-block">Enviar e-mail</button>
                        <a class="btn btn-lg btn-outline-danger btn-block" role="bottun" href="tela_login.php">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>

<?php 
    include("../bd/conexao.php");

    if(isset($_POST['ok'])){      
        $email = $_POST['email'];
        $sql = "select id, senha, email from login where email=?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("s", $email);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $usuario = mysqli_fetch_assoc($resultadoSql);
        if(isset($usuario)){
            
            $chave = md5($usuario['id'].$usuario['senha']);
            $link = "http://localhost/SGProjetos/views/alterar_senha.php?chave=".$chave;

            $sub = "Recuperação de senha";
            $msg = "Se você solicitou a recuperação de senha para seu login no Sistema de Gerenciamento de Projetos, acesse o link a seguir: 
".$link."
caso não tenha sido você, desconsidere este email
atenciosamente, suporte SGP.";
            
            $rec = $usuario['email'];
            //send email
            if(mail($rec,$sub,$msg)){
            ?>
                <script>
                    alert('Verifique seu email para acessar a recuperação de senha');
                </script>
            <?php
            } else {
            ?>
                <script>
                    alert('Falha ao enviar o email, tente novamente.');
                </script>
                <?php 
            }

        } else {
            ?>
                <script>
                    alert('O e-mail informado não está cadastrado');
                </script>
            <?php
        }
    }
?>  