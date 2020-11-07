<?php 
    require_once('navbar/navbar.php');

$chave = "";

if($_GET['chave']){
    if(isset($_SESSION['tipoLogin'])){
        header('location: projetos.php');
    }else{
        $chave = preg_replace('/[^[:alnum:]]/','',$_GET['chave']); 
    }
    
}else if(isset($_SESSION['tipoLogin'])){
    header('location: projetos.php');
}else{
    header('location: tela_login.php');
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
                <div class="col-sm-6 offset-sm-3 col-md-6 offset-md-3 col-lg-6 offset-lg-2 col-xl-5 offset-xl-3">
                    <form class="form-group" method="POST" action="../bd/altera_senha.php" onsubmit="return validaSenha();">
                        <div class="text-center mb-4">
                            <img class="mb-4" src="../imagens/logo.png" alt="" width="100" height="100">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="inputCPF">Email:</label>
                            <input type="email" id="inputEmail" class="form-control" name="email" 
                            placeholder="Digite seu email:" required autofocus>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="inputSenha">Nova senha:</label>
                            <input type="password" id="inputSenha" class="form-control" placeholder="Digite uma senha" 
                            <?php if(!isset($idEditar)){ ?> required <?php } ?> name="Senha" data-minlength="6" maxlength="16">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="inputConfirmaSenha">Confirmar senha:</label>
                            <input type="password" id="inputConfirmaSenha" class="form-control" placeholder="Confirma senha"
                            <?php if(!isset($idEditar)){ ?> required <?php } ?> name="confSenha" data-minlength="6">
                        </div>

                        <input name="chave" type="hidden" id="chave" value="<?php echo($chave) ?>">
                        <button type="submit" class="btn btn-lg btn-outline-primary btn-block">Alterar senha</button>
                        <a class="btn btn-lg btn-outline-danger btn-block" role="bottun" href="tela_login.php">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>

<script>
function validaSenha(){
    var senha = document.getElementById("inputSenha");
    var cSenha = document.getElementById("inputConfirmaSenha");

    if(senha.value == cSenha.value){
        return true
    } else {
        alert('As senhas não estão iguais');
        return false
    }
}
</script>