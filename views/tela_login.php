<!-- Quando formos integrar ao PHP, esse head some daqui e fica só no Index-->

<!-- <head> -->
    <!-- <meta charset="utf-8"> -->
    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <!-- <link rel="stylesheet" href="../css/labels.css"> -->
    <!-- <link rel="stylesheet" href="../css/navbar.css"> -->
    <!-- <link rel="stylesheet" href="../css/ui.css"> -->
    <title>Login</title>
    <?php 
    require_once('navbar/navbar.php');

    if(isset($_SESSION["nome"])){  
        header('location:http://localhost/SGProjetos/');
    }?>
<!-- </head> -->

<body>
    <?php if(isset($_SESSION["erroLogin"])){ ?>
        <div class="bg-danger text-center">
            <h4 class="text-light"><?=$_SESSION["erroLogin"]; ?></h4>
        </div>
    <?php unset($_SESSION["erroLogin"]);
    } else { ?>
        <br> 
    <?php } ?> 

    
    <div class="container">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-8 col-md-9">
                    <h1>Login</h1>
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
                    <div class="col-sm-6 offset-sm-3 col-md-6 offset-md-3 col-lg-6 offset-lg-2 col-xl-5 offset-xl-3">
                        <form name="formLogin" class="form-group" method="POST" action="../bd/login.php">
                            <div class="text-center mb-4">
                                <img class="mb-4" src="../imagens/logo.png" alt="" width="100" height="100">
                            </div>
                            
                            <label for="inputCPF">E-mail</label>
                            <input type="email" id="inputEmail" class="form-control" name="email" 
                            <?php if(isset($_SESSION['erroEmail'])){ ?> value="<?php echo($_SESSION['erroEmail']) ?>" <?php } ?>
                            required autofocus>
                        
                            <label for="inputPassword">Senha</label>
                            <input type="password" id="inputPassword" class="form-control" name="senha" required>
                            <p><a href="esqueceu_senha.php">esqueceu a senha?</a></p>
                            <p><button class="btn btn-lg btn-outline-primary btn-block" type="submit" id="botaoLogin">Login</button></p>
                            <p><a href="cadastro/cadastro_aluno_professor.php" role="button" class="btn btn-lg btn-outline-success 
                            btn-block">não é inscrito? Inscreva-se</a></p>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</body>

<?php include_once('navbar/footer.php'); ?>