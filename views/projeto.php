<head>
    <meta charset="utf-8">
</head>

<?php
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');

    if(isset($_POST['orientar'])){
        $id = $_POST['id'];
        $sql = "UPDATE projeto set orienta=NULL where idProj='$id';";
        mysqli_query($conexao, $sql);

        $_SESSION['POrientar'] = $_SESSION['POrientar'] - 1;
        header('location: meus_projetos.php');
    } else if(isset($_POST['NOrientar'])){
        $id = $_POST['id'];
        $sql = "UPDATE projeto set idProf=NULL where idProj='$id';";
        mysqli_query($conexao, $sql);

        $_SESSION['POrientar'] = $_SESSION['POrientar'] - 1;
        header('location: meus_projetos.php');
    }

    $aux = 0;
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $sql = "select * from projeto where idProj= ?";
        $aux = 1;
    } 
    
    if(isset($_SESSION['idProj'])){
        $id = $_SESSION['idProj'];
        unset($_SESSION['idProj']);
        if($_SESSION['tipoSalvamento']=="Professor"){
            $Salvou = 1;
            $sql = "SELECT * FROM projeto INNER JOIN professor ON projeto.idProf = professor.idProf WHERE idProj= ?";
            unset($_SESSION['tipoSalvamento']);
        } else if ($_SESSION['tipoSalvamento']=="Aluno") {
            $Salvou = 1;
            $sql = "SELECT * FROM projeto INNER JOIN aluno ON aluno.idAluno = projeto.idAluno WHERE projeto.idProj = ?";
            unset($_SESSION['tipoSalvamento']);
        }
        $aux = 1;
    } 

    if($aux == 0) {
        header('location: projetos.php');
    } else {
        unset($aux);
    }

    $sqlprep = $conexao->prepare($sql);
    $sqlprep->bind_param("i", $id);
    $sqlprep->execute();
    $resultadoSql = $sqlprep->get_result();
    $umRegistro = mysqli_fetch_assoc($resultadoSql);

    if(isset($umRegistro['idProf']) && !isset($umRegistro['orienta'])){
        $sql = "SELECT professor.idProf, nomeProf FROM professor INNER JOIN projeto ON professor.idProf = 
        projeto.idProf WHERE projeto.idProj = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $nomeProf = mysqli_fetch_assoc($resultadoSql);
    } 
    
    if(isset($umRegistro['idAluno'])){
        $sql = "SELECT aluno.nomeAluno FROM aluno INNER JOIN projeto on aluno.idAluno = 
        projeto.idAluno where projeto.idProj = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $nomeAluno = mysqli_fetch_assoc($resultadoSql);
    }


    $sql = "SELECT areainteresse.nomeArea FROM areainteresse INNER JOIN areaprojeto ON 
    areaprojeto.idArea=areainteresse.idArea INNER JOIN projeto ON areaprojeto.idProjeto = 
    projeto.idProj WHERE projeto.idProj = ?";
    $sqlprep = $conexao->prepare($sql);
    $sqlprep->bind_param("i", $id);
    $sqlprep->execute();

    $resultadoSql = $sqlprep->get_result();
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    $vetorAreasProj = array();
    while($vetorUmRegistro != null){
        array_push($vetorAreasProj, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    }

    $sql = "SELECT aluno.nomeAluno, aluno.idAluno FROM aluno INNER JOIN alunosproj ON alunosproj.idAluno = 
    aluno.idAluno INNER JOIN projeto ON projeto.idProj = alunosproj.idProj WHERE projeto.idProj = ?";
    $sqlprep = $conexao->prepare($sql);
    $sqlprep->bind_param("i", $id);
    $sqlprep->execute();

    $resultadoSql = $sqlprep->get_result();
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    $vetorAlunos = array();
    while($vetorUmRegistro != null){
        array_push($vetorAlunos, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    }
    if(isset($_SESSION['id']) && $_SESSION['tipoLogin']=="Aluno"){       
        foreach($vetorAlunos as $Va){
            if($Va['idAluno']==$_SESSION['id']){
                $inscrito = "1";
            break;
            }
        }
    }
    ?>


<br>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <h3><?php echo($umRegistro['tituloProj']) ?></h3>
            </div>
            <div class="col-sm-4 col-md-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" 
                    data-target="#menuLateral" aria-controls="menuLateral" aria-expanded="false" 
                    aria-label="Toggle navigation">
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
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <div class="card mb-4 shadow-sm">
                        <img src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5 mb-3">
                    <?php if(isset($nomeProf)){ ?>
                        <label for="inputProf">Professor Responsável: </label>
                        <input type="text" id="inputProf"readonly class="form-control-plaintext text-black-50" name="prof" 
                        value="<?php echo($nomeProf['nomeProf']) ?>" >
                    <?php } else { ?>
                        <div class="text-danger">Sem Professor Orientador:</div>
                    <?php } ?>
                    <?php if(isset($nomeAluno)){ ?>
                        <label for="inputAluno">Aluno Responsável: </label>
                        <input type="text" id="inputAluno"readonly class="form-control-plaintext text-black-50" name="Aluno" 
                        value="<?php echo($nomeAluno['nomeAluno']) ?>" >
                    <?php } ?>

                    <label class="form-control-plaintext"><?php echo($umRegistro['vagasRestantes'].' vaga(s) restante(s)') ?></label>
                </div>
                <div class="col-sm-6 col-md-12 col-lg-12 col-xl-12 mb-3">
                    <label for="inputResumo">Resumo do Projeto: </label>
                    <div class="form-control-plaintext text-black-50"><?php echo($umRegistro['resumoProj']) ?></div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-7 col-xl-7 mb-3">
                    <label for="inputResumo">Aluno(s) incrito(s) no Projeto: </label>
                    <?php foreach($vetorAlunos as $vetAux){ ?>
                        <input type="text" id="inputResumo"readonly class="form-control-plaintext text-black-50" name="resumo" 
                        value="<?php echo($vetAux['nomeAluno']) ?>" >
                    <?php } 
                        if(count($vetorAlunos)==0){?>
                        <input type="text" id="inputResumo"readonly class="form-control-plaintext text-black-50" name="resumo" 
                        placeholder="Não há alunos inscritos">
                    <?php } ?>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-5 col-xl-5 mb-3">
                    <label for="inputArea">Área(s) atuação do Projeto: </label>
                    <?php foreach($vetorAreasProj as $vetAux){ ?>
                        <input type="text" id="inputResumo"readonly class="form-control-plaintext text-black-50" name="resumo" 
                        value="<?php echo($vetAux['nomeArea']) ?>" >
                    <?php } ?>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-7 col-xl-7 mb-3">
                    <label for="inputDataInicio">Data de Inicio:</label>
                    <input type="date" id="inputDataInicio" readonly class="form-control-plaintext text-black-50" name="dataIni" 
                    value="<?php echo($umRegistro['dataIniProj']) ?>">
                </div>

                <div class="col-sm-6 col-md-6 col-lg-5 col-xl-5 mb-3">
                    <label for="inputDataFin">Data final:</label>
                    <?php if($umRegistro['dataFinProj']!="0000-00-00"){?> 
                    <input type="date" id="inputDataFin" readonly class="form-control-plaintext text-black-50" name="dataFin" 
                    value="<?php echo($umRegistro['dataFinProj']) ?>">
                    <?php } else { ?> 
                    <input type="text" id="inputDataFin" readonly class="form-control-plaintext text-black-50" name="dataFin" 
                    placeholder="Não há data para término">
                    <?php } ?>
                </div>

                <?php if(isset($_SESSION['id'])){
                    if((isset($umRegistro['idProf']) && $umRegistro['idProf']==$_SESSION['id'] && !isset($umRegistro['orienta'])) || $umRegistro['idAluno']==$_SESSION['id'] || isset($Salvou) || isset($_SESSION['ADMIN'])){ ?>
                        <div class="col-xl-12">
                            <form action="cadastro/cadastro_projetos.php" method="post">
                                <input type="hidden" name="id" value="<?=$id?>">
                                <button type="submit" class="btn btn-lg btn-outline-info btn-block">Editar</button>
                            </form>
                        </div>
                    <?php } else if(isset($_SESSION['tipoLogin']) && $_SESSION['tipoLogin']=="Aluno" && $umRegistro['vagasRestantes']!=0 && !isset($inscrito)){  ?>
                        <div class="col-xl-12">
                            <form action="perfil.php" method="post">
                                <input type="hidden" name="id" value="<?=$umRegistro['idProf']?>">
                                <input type="hidden" name="tipo" value="Professor">
                                <input type="hidden" name="insc" value="1">
                                <button type="submmit" class="btn btn-lg btn-outline-info btn-block">Solicitar Inscrição</button>
                            </form>
                        </div>
                    <?php } else if(isset($inscrito) && $inscrito==1 && $umRegistro['idProf']!=null){  ?>
                        <div class="col-xl-12">
                            <form action="perfil.php" method="post">
                                <input type="hidden" name="conversar" value="1">
                                <input type="hidden" name="id" value="<?=$umRegistro['idProf']?>">
                                <input type="hidden" name="tipo" value="Professor">
                                <button type="submmit" class="btn btn-lg btn-outline-info btn-block">Conversar com o Professor</button>
                            </form>
                        </div>
                    <?php } ?>
                    <?php if(isset($umRegistro['idProf']) && $umRegistro['idProf']==$_SESSION['id'] && (isset($umRegistro['orienta']) && $umRegistro['orienta']==0)) {?>
                        <div class="col-xl-6">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?=$id?>">
                                <input type="hidden" name="orientar" value="1">
                                <button type="submit" class="btn btn-lg btn-outline-success btn-block">Aceitar Orientar Projeto</button>
                            </form>
                        </div>
                        <div class="col-xl-6">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?=$id?>">
                                <input type="hidden" name="NOrientar" value="1">
                                <button type="submit" class="btn btn-lg btn-outline-danger btn-block">Não Orientar Projeto</button>
                            </form>
                        </div> 
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>