<head>
    <meta charset="utf-8">
</head>

<?php
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');
    if($conexao){
        $sql = "SELECT idProj, projeto.idProf, projeto.idAluno, fotoProj, tituloProj, professor.nomeProf, aluno.nomeAluno, 
        vagasRestantes FROM projeto INNER JOIN professor ON projeto.idProf = professor.idProf INNER JOIN aluno ON 
        projeto.idAluno=aluno.idAluno WHERE projeto.orienta IS NULL";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosComOrientador = array();
    
        while($vetorUmRegistro != null){
            array_push($vetorTodosComOrientador, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        if(count($vetorTodosComOrientador)==0){
            $ComOrientador = "1";
        }



        $sql = "SELECT idProj, projeto.idAluno, fotoProj, tituloProj, aluno.nomeAluno, vagasRestantes FROM projeto INNER 
        JOIN aluno ON projeto.idAluno=aluno.idAluno WHERE projeto.orienta = 0";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosSemOrientador = array();
    
        while($vetorUmRegistro != null){
            array_push($vetorTodosSemOrientador, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        if(count($vetorTodosSemOrientador)==0){
            $SemOrientador = "1";
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
                <h1>Projetos de Alunos</h1>
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

        <?php if(isset($SemOrientador) && isset($ComOrientador)){?>
            <div class="text-center col-xl-9 col-lg-9">
                <h4 class="text-warning">Nenhum Aluno cadastrou projetos</h4>
            </div>
        <?php } else { ?>
            <div class="col-xl-9 col-lg-9">
                <div class="row">
                    <?php if(!isset($ComOrientador)){ ?>
                    <div class="text-center col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h4><strong>Projetos com Orientador</strong></h4>
                    </div>
                    <?php foreach($vetorTodosComOrientador as $umRegistro): ?>
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
                                            <?php if((isset($_SESSION["tipoLogin"]) && ($_SESSION["id"]==$umRegistro['idProf'] || $_SESSION["id"]==$umRegistro['idAluno'])) || (isset($_SESSION['ADMIN']))){ ?>
                                                <form action="cadastro/cadastro_projetos.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>    
                                                </form>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="margin-top:10px;">
                                            <?php if($umRegistro["vagasRestantes"] > 0) { ?>
                                                <span class="badge bg-success text-light"><?=$umRegistro["vagasRestantes"];?> vaga(s)</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger text-light">Sem vagas</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <?php } ?>
                </div>


                <div class="row">
                    <?php if(!isset($SemOrientador)){ ?>
                    <div class="text-center col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <h4><strong>Projetos sem Orientador</strong></h4>
                    </div>
                    <?php foreach($vetorTodosSemOrientador as $umRegistro): ?>
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
                                            <?php if((isset($_SESSION["tipoLogin"]) && $_SESSION["id"]==$umRegistro['idAluno']) || (isset($_SESSION['ADMIN']))){ ?>
                                                <form action="cadastro/cadastro_projetos.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>    
                                                </form>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2" style="margin-top:10px;">
                                            <?php if($umRegistro["vagasRestantes"] > 0) { ?>
                                                <span class="badge bg-success text-light"><?=$umRegistro["vagasRestantes"];?> vaga(s)</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger text-light">Sem vagas</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <?php } ?>
                </div>


            </div>
        <?php } ?>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>