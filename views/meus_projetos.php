<head>
    <meta charset="utf-8">
</head>
<?php include('protege.php');
protege(); ?>
<?php
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');

    if (!isset($_SESSION['id'])) {
        header("location: http://localhost/SGProjetos/views/tela_login.php");
    }
    if($conexao){
        $id = $_SESSION["id"];
        if($_SESSION["tipoLogin"]=="Professor"){
            $sql = "SELECT projeto.idProj, projeto.fotoProj, projeto.tituloProj, professor.nomeProf FROM projeto INNER 
            JOIN professor ON projeto.idProf = professor.idProf WHERE projeto.orienta IS NULL AND professor.idProf = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $id);
            if(isset($_SESSION["POrientar"])){
                $sql1 = "SELECT * FROM projeto INNER JOIN professor ON projeto.idProf = professor.idProf INNER JOIN 
                aluno ON projeto.idAluno = aluno.idAluno WHERE orienta IS NOT NULL AND professor.idProf = ?";
                $sql1prep = $conexao->prepare($sql1);
                $sql1prep->bind_param("i", $id);
                $sql1prep->execute();
                $resultadoSql1 = $sql1prep->get_result();
                $vetorUmRegistroProj = mysqli_fetch_assoc($resultadoSql1);
                $vetorTodosRegistrosProj = array();
                while($vetorUmRegistroProj != null){
                    array_push($vetorTodosRegistrosProj, $vetorUmRegistroProj);
                    $vetorUmRegistroProj = mysqli_fetch_assoc($resultadoSql1);
                }
                $orientar = "orientar";
                $texto = "Projetos aguardando aceitação para orientá-los";
                $texto2 = "Meus Projetos";
            }
        } else if($_SESSION["tipoLogin"]=="Aluno"){
            $sql1 = "SELECT * FROM projeto INNER JOIN aluno ON projeto.idAluno = aluno.idAluno WHERE aluno.idAluno = ?";
            $sql1prep = $conexao->prepare($sql1);
            $sql1prep->bind_param("i", $id);
            $sql1prep->execute();
            $resultadoSql1 = $sql1prep->get_result();
            $vetorUmRegistroProj = mysqli_fetch_assoc($resultadoSql1);
            $vetorTodosRegistrosProj = array();
            while($vetorUmRegistroProj != null){
                array_push($vetorTodosRegistrosProj, $vetorUmRegistroProj);
                $vetorUmRegistroProj = mysqli_fetch_assoc($resultadoSql1);
            }
            $texto = "Meus projetos";
            $texto2 = "Projetos que participo";

            $sql = "SELECT projeto.idProj, projeto.fotoProj, projeto.tituloProj, professor.nomeProf FROM projeto INNER 
            JOIN professor ON projeto.idProf = professor.idProf INNER JOIN alunosproj ON projeto.idProj = 
            alunosproj.idProj WHERE projeto.orienta IS NULL AND alunosproj.idAluno = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $id);
        }

        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        $vetorTodosRegistros = array();
        while($vetorUmRegistro != null){
            array_push($vetorTodosRegistros, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        }
        if(count($vetorTodosRegistros)==0){
            $semProj = "Você ainda não possui nenhum projeto cadastrado";
        }
    }else{
        echo('<h3 class="text-center"> Erro ao conectar </h3>');
    }
?>
<style>
form{
    margin-bottom: 0px;
}
</style>
<br>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9 col-lg-6 col-xl-6">
                <h1>Meus Projetos</h1>
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
            <?php if(isset($vetorTodosRegistrosProj) && count($vetorTodosRegistrosProj)!=0){ ?>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <h4><strong><?php echo($texto) ?></strong></h4>
                    </div>
                    <?php foreach($vetorTodosRegistrosProj as $umRegistro): ?>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card mb-4 shadow-sm">
                                <img src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
                                <div class="card-body" style="padding-bottom: 0px;">
                                    <p class="card-text"><h6><?=$umRegistro["tituloProj"]?></h6>Aluno Responsável: <?=$umRegistro["nomeAluno"]?></p>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="form-inline col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                            <form action="projeto.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                            </form> 

                                            <?php if(isset($_SESSION["tipoLogin"]) && ($_SESSION["id"]==$umRegistro['idProf'] || $_SESSION["id"]==$umRegistro['idAluno']) && !isset($orientar)){ ?>
                                                <form action="cadastro/cadastro_projetos.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>    
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php } ?>

            <?php if(isset($semProj)){?>
                <div class="text-center col-xl-9 col-lg-9">
                    <h4 class="text-warning"><?=$semProj?></h4>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <h4><strong><?php echo($texto2) ?></strong></h4>
                    </div>
                    <?php foreach($vetorTodosRegistros as $umRegistro): ?>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card mb-4 shadow-sm">
                                <img src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
                                <div class="card-body" style="padding-bottom: 0px;">
                                    <p class="card-text"><h6><?=$umRegistro["tituloProj"]?>
                                        <?php if($_SESSION['tipoLogin'] == "Aluno"){ ?>
                                            </h6>Professor: <?=$umRegistro["nomeProf"]?>
                                        <?php } ?>
                                    </p>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <?php if($_SESSION["tipoLogin"]=="Professor"){ ?>
                                            <div class="form-inline col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                <form action="projeto.php" method="post">
                                                    <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                                </form>
                                                <form action="cadastro/cadastro_projetos.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>    
                                                </form>
                                            </div>
                                        <?php }else if($_SESSION["tipoLogin"]=="Aluno"){ ?>
                                            <div class="btn-group">
                                                <form action="projeto.php" method="post">
                                                    <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>
