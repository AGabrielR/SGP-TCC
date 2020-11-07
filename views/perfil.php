<head>
    <meta charset="utf-8">
</head>

<?php
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');

    if (!isset($_POST['id']) && !isset($_SESSION['id']) && !isset($_SESSION['idAlunoEditado'])) {
        header("location: http://localhost/SGProjetos/views/tela_login.php");
    }

    if (!isset($_POST['id'])) {
        $id = $_SESSION["id"];
        $titulo = "Meu Perfil";
    } 

    if (isset($_POST['id'])) {
        $id = $_POST["id"];
        if ($_POST['tipo']=="Professor") {
            $aux = "professor";
            $titulo = "Perfil do Professor";
        } else if ($_POST['tipo']=="Aluno") {
            $aux = "aluno";
            $titulo = "Perfil do Aluno";
        }
    }

    if (isset($_SESSION['idAlunoEditado'])) {
        $aux = "aluno";
        $id = $_SESSION['idAlunoEditado'];
        $titulo = "Perfil do Aluno";
        unset($_SESSION['idAlunoEditado']);
    } 

    if (isset($_SESSION['idProfessorEditado'])) {
        $aux = "professor";
        $id = $_SESSION['idProfessorEditado'];
        $titulo = "Perfil do Professor";
        unset($_SESSION['idProfessorEditado']);
    } 

    if(($_SESSION['tipoLogin']=="Professor" && !isset($_POST['id']) && !isset($aux)) || (isset($aux) && $aux == "professor")){
        $sql = "select * from professor inner join campus on campus.idCampus=professor.idCampus 
        inner join login on login.id=professor.idLogin where professor.idProf = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $perfil = mysqli_fetch_assoc($resultadoSql);

        $sql = "select areainteresse.nomeArea from areainteresse inner join areaatuaprofessor on 
        areaatuaprofessor.idArea=areainteresse.idArea INNER join professor on areaatuaprofessor.idProf 
        = professor.idProf where professor.idProf = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();

        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        $vetorAreasAtua = array();
        while($vetorUmRegistro != null){
            array_push($vetorAreasAtua, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        }
        
        $sql = "select * from campus inner join professor on campus.idCampus=professor.idCampus 
        where professor.idProf = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $campus = mysqli_fetch_assoc($resultadoSql);
        
        if($perfil['cpfProf']==""){
            $perfil['cpfProf'] = "Sem CPF";
        }

        $sql = "select diaSemana, horarioIni, horarioFin from horariolivreprofessor inner join professor on horariolivreprofessor.idProf
        =professor.idProf where professor.idProf = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();

        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        $vetorHorarios = array();
        while($vetorUmRegistro != null){
            array_push($vetorHorarios, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        }

    } 
    if (($_SESSION['tipoLogin']=="Aluno" && !isset($_POST['id'])) || (isset($aux) && $aux == "aluno")) {
        $sql = "select * from aluno inner join campus on campus.idCampus=aluno.idCampus 
        inner join login on login.id=aluno.idLogin where aluno.idAluno = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $perfil = mysqli_fetch_assoc($resultadoSql);

        $sql = "select areainteresse.nomeArea from areainteresse inner join areaintaluno on 
        areaintaluno.idArea=areainteresse.idArea INNER join Aluno on areaintaluno.idAluno
        = Aluno.idAluno where Aluno.idAluno = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();

        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        $vetorAreasInt = array();
        while($vetorUmRegistro != null){
            array_push($vetorAreasInt, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
        }
        
        $sql = "select * from campus inner join aluno on campus.idCampus=aluno.idCampus 
        where aluno.idAluno = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $campus = mysqli_fetch_assoc($resultadoSql);

        $sql = "select * from curso inner join aluno on curso.idCurso=aluno.idCurso 
        where aluno.idAluno = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $curso = mysqli_fetch_assoc($resultadoSql);
        
        if(isset($perfil['cpfAluno']) && $perfil['cpfAluno']==""){
            $perfil['cpfAluno'] = "Sem CPF";
        }
    }

?>

<?php if(isset($_POST['insc'])) { ?>
    <div class="bg-warning text-center">
        <h4 class="text-dark">Para realizar a inscrição é necessário autorização do professor responsável, entre em contato com ele para solicitá-la</h4>
    </div>
<?php } else if(isset($_POST['conversar'])) { ?>
    <div class="bg-info text-center">
        <h4 class="text-light">Procure o professor através de uma das formas de contato disponíveis</h4>
    </div>
<?php } else { ?>
<br>
<?php } ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <h1><?php echo($titulo) ?></h1>
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
            <?php if(($_SESSION['tipoLogin']=="Professor" && !isset($_POST['id']) && !isset($aux)) || 
                    (isset($_POST['id']) && $_POST['tipo']=="Professor") || (isset($aux) && $aux == "professor")){ ?>
                <form action="cadastro/cadastro_aluno_professor.php" method="POST">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <h4><strong>Informações básicas:</strong></h4>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNome">Nome:</label>
                            <input type="text" readonly class="form-control-plaintext text-black-50" 
                            id="inputNome" value="<?php echo($perfil['nomeProf']); ?>" name="nome">
                        </div>
                        <?php if(!isset($_POST['id'])){ ?>
                            <div class="form-group col-md-6">
                                <label for="CPF">CPF:</label>
                                <input type="tel" readonly class="form-control-plaintext  text-black-50" id="inputCPF" value="<?php echo($perfil['cpfProf']); ?>" name="CPF">
                            </div>
                        <?php } ?>
                        <div class="form-group col-md-6">
                            <label for="inputSiap">Siap:</label>
                            <input type="text" readonly class="form-control-plaintext text-black-50"  id="inputSiap" value="<?php echo($perfil['siap']); ?>" name="siap">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="campus">Campus:</label>
                            <input type="text" id="campus" readonly class="form-control-plaintext text-black-50"  value="<?php echo($campus['nomeCampus']); ?>" name="campus">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="areaProf">Área(s) de atuação:</label>
                            <?php foreach($vetorAreasAtua as $vetAux){ ?>
                                <input type="text" id="area" readonly class="form-control-plaintext text-black-50"  value="<?php echo($vetAux['nomeArea']); ?>" name="area">
                            <?php } ?>
                        </div>  

                        <div class="form-group col-md-12 mb-3">
                            <h4><strong>Formas de contato:</strong></h4>
                        </div>   

                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" id="email" readonly class="form-control-plaintext text-black-50"  value="<?php echo($perfil['email']); ?>" name="email">
                        </div>        

                        <div class="form-group col-md-6">
                            <label for="telefone">Telefone:</label>
                            <input type="text" id="telefone" readonly class="form-control-plaintext text-black-50"  value="<?php if(isset($perfil['telefone']) && $perfil['telefone']!="") { 
                                echo($perfil['telefone']); } else { echo("número de telefone não cadastrado"); }?>" name="telefone">
                        </div>  
                        
                        <?php if(count($vetorHorarios)==0){ ?>
                            <div class="form-group col-md-6">
                                <label for="horario">Horários livres para Atendimento ao aluno:</label>
                                <input type="text" id="horario" readonly class="form-control-plaintext text-black-50"  value="Nenhum horário cadastrado" name="horario">
                            </div> 
                        <?php }else{ ?>
                            <div class="form-group col-md-6">
                                <label for="horario">Horários livres para Atendimento ao aluno:</label>
                                <?php foreach ($vetorHorarios as $VH) { ?>
                                    <input type="text" id="horario" readonly class="form-control-plaintext text-black-50"  
                                    value="<?php echo($VH['diaSemana']." das: ".$VH['horarioIni']." as ".$VH['horarioFin']); ?>" name="horario">
                                <?php } ?>
                            </div> 
                        <?php } ?>
                        
                    </div>
                    <?php if(!isset($_POST['id']) || isset($_SESSION['ADMIN'])) { ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if(isset($_SESSION['ADMIN'])){ ?>
                                            <input type="hidden" name="tipo" value="professor">   
                                        <?php  } ?>
                                        <input type="hidden" name="id" value="<?=$perfil['idProf']?>">   
                                        <button type="submit" class="btn btn-lg btn-outline-info btn-block">editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            <?php } else if (($_SESSION['tipoLogin']=="Aluno" && !isset($_POST['id']) && !isset($aux)) || 
                            (isset($_POST['id']) && $_POST['tipo']=="Aluno") || $aux == "aluno"){ ?>
                <form action="cadastro/cadastro_aluno_professor.php" method="post">
                    <div class="row">
                
                        <div class="form-group col-md-12">
                        <label for="inputNome">Nome:</label>
                            <input type="text" id="inputNome" readonly class="form-control-plaintext text-black-50" 
                            name="nome" value="<?php echo($perfil['nomeAluno']); ?>">
                        </div>
                
                        <div class="form-group col-md-6">
                        <label for="inputCPF">CPF:</label>
                            <input type="tel" id="inputCPF" readonly class="form-control-plaintext text-black-50" name="CPF"
                            value="<?php echo($perfil['cpfAluno']); ?>">
                        </div>
                
                        <div class="form-group col-md-6">
                        <label for="inputRA">RA:</label>
                            <input type="text" id="inputRA" readonly class="form-control-plaintext text-black-50" name="RA" value="<?php echo($perfil['raAluno']); ?>">
                        </div>
                
                        <div class="form-group col-md-6 mb-3">
                            <label for="Campus">Campus:</label>
                            <input type="text" id="Campus" readonly class="form-control-plaintext text-black-50"  
                            value="<?php echo($campus['nomeCampus']); ?>" name="campus">
                        </div>
                        
                        <div class="form-group col-md-6 mb-3">
                        <label for="Curso">Curso:</label>
                            <input type="text" id="Curso" readonly class="form-control-plaintext text-black-50" 
                            value="<?php echo($curso['nomeCurso']); ?>" name="curso">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="area">Área(s) de interesse:</label>
                            <?php foreach($vetorAreasInt as $vetAux){ ?>
                                <input type="text" id="Area" readonly class="form-control-plaintext text-black-50" 
                                value="<?php echo($vetAux['nomeArea']) ?>">
                            <?php } ?>
                        </div> 
                        
                        <div class="col-md-6 mb-3">
                            <label for="inputEmail">Email</label>
                            <input type="email" id="inputEmail" readonly class="form-control-plaintext text-black-50" 
                             value="<?php echo($perfil['email']); ?>" name="email">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="inputTurma">Turma</label>
                            <input type="text" id="inputTurma" readonly class="form-control-plaintext text-black-50" 
                             value="<?php echo($perfil['turma']); ?>" name="turma">
                        </div>

                    </div>
                    
                    <?php if(!isset($_POST['id']) || isset($_SESSION['ADMIN'])) { ?>
                        <div class="row">

                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if(isset($_SESSION['ADMIN'])){ ?>
                                            <input type="hidden" name="tipo" value="aluno">   
                                        <?php  } ?>
                                        <input type="hidden" name="id" value="<?=$perfil['idAluno']?>">   
                                        <button type="submit" class="btn btn-lg btn-outline-info btn-block">editar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    
                </form>
            <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php include_once('navbar/footer.php'); ?>