<?php 
    require_once('../navbar/navbar.php'); 
    require_once('../../bd/conexao.php');

    if (!isset($_POST["id"]) && isset($_SESSION['id']) && !isset($_SESSION["ADMIN"])) {
        header("location: http://localhost/SGProjetos/");
    }

    if(isset($_POST["id"])){
        if(($_SESSION['tipoLogin']=="Professor" && !isset($_POST['tipo'])) || (isset($_SESSION['ADMIN']) && $_POST['tipo'] == 'professor')){
            $idEditar = $_POST["id"];
            $nome = $_POST["nome"];
            if(isset($_POST['CPF'])){
                $cpf = $_POST['CPF'];
            } else {
                $cpf = "Sem CPF";
            }
            $siap = $_POST["siap"];
            $email = $_POST["email"];
            $campus = $_POST["campus"];
            if(is_numeric($_POST['telefone'])){
                $telefone = $_POST['telefone'];
            }
            $cont = 0;
            $sql = "select * from areaatuaprofessor where idProf = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $vetorAreaEditar = array();
            while($vetorUmRegistro != null){
                array_push($vetorAreaEditar, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }

            $sql = "select login.id from login inner join professor on login.id=professor.idLogin
            where idProf = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $senha = mysqli_fetch_assoc($resultadoSql);

            $sql = "select * from horariolivreprofessor where idProf = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $vetorHoraEditar = array();
            while($vetorUmRegistro != null){
                array_push($vetorHoraEditar, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }

        } else if (($_SESSION['tipoLogin']=="Aluno") || (isset($_SESSION['ADMIN']) && $_POST['tipo'] == 'aluno')){
            $idEditar = $_POST["id"];
            $nome = $_POST["nome"];
            $cpf = $_POST["CPF"];
            $ra = $_POST["RA"];
            $campus = $_POST["campus"];
            $curso = $_POST["curso"];
            $turma = $_POST['turma'];
            $email = $_POST['email'];

            $sql = "select login.id from login inner join aluno on login.id=aluno.idLogin
            where idAluno = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $senha = mysqli_fetch_assoc($resultadoSql);

            $sql = "select * from areaintaluno where idAluno = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $vetorAreaEditar = array();
            while($vetorUmRegistro != null){
                array_push($vetorAreaEditar, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }
        }
    }
    $sql = "select * from campus";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    $vetorTodosCampus = array();

    while($vetorUmRegistro != null){
        array_push($vetorTodosCampus, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    }

    $sql = "select * from curso";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistroCursos = mysqli_fetch_assoc($resultadoSQL);
    $vetorTodosCursos = array();

    while($vetorUmRegistroCursos != null){
        array_push($vetorTodosCursos, $vetorUmRegistroCursos);
        $vetorUmRegistroCursos = mysqli_fetch_assoc($resultadoSQL);
    }

    $sql = "select * from areainteresse";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistroArea = mysqli_fetch_assoc($resultadoSQL);
    $vetorTodasAreas = array();

    while($vetorUmRegistroArea != null){
        array_push($vetorTodasAreas, $vetorUmRegistroArea);
        $vetorUmRegistroArea = mysqli_fetch_assoc($resultadoSQL);
    }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Cadastro</title>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<link href="../../css/select2.min.css" rel="stylesheet" />
<script src="../../css/select2.min.js"></script>

<script type="text/javascript">
function fMasc(objeto,mascara) {
    obj=objeto
    masc=mascara
    setTimeout("fMascEx()",1)
}
function fMascEx() {
    obj.value=masc(obj.value)
}
function mTel(tel) {
    tel=tel.replace(/\D/g,"")
    tel=tel.replace(/^(\d)/,"($1")
    tel=tel.replace(/(.{3})(\d)/,"$1)$2")
    if(tel.length == 9) {
        tel=tel.replace(/(.{1})$/,"-$1")
    } else if (tel.length == 10) {
        tel=tel.replace(/(.{2})$/,"-$1")
    } else if (tel.length == 11) {
        tel=tel.replace(/(.{3})$/,"-$1")
    } else if (tel.length == 12) {
        tel=tel.replace(/(.{4})$/,"-$1")
    } else if (tel.length > 12) {
        tel=tel.replace(/(.{4})$/,"-$1")
    }
    return tel;
}
function mCNPJ(cnpj){
    cnpj=cnpj.replace(/\D/g,"")
    cnpj=cnpj.replace(/^(\d{2})(\d)/,"$1.$2")
    cnpj=cnpj.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
    cnpj=cnpj.replace(/\.(\d{3})(\d)/,".$1/$2")
    cnpj=cnpj.replace(/(\d{4})(\d)/,"$1-$2")
    return cnpj
}
function mCPF(cpf){
    cpf=cpf.replace(/\D/g,"")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return cpf
}
function mCEP(cep){
    cep=cep.replace(/\D/g,"")
    cep=cep.replace(/^(\d{2})(\d)/,"$1.$2")
    cep=cep.replace(/\.(\d{3})(\d)/,".$1-$2")
    return cep
}
function mNum(num){
    num=num.replace(/\D/g,"")
    return num
}

//=============
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){
	id('telefone').onkeypress = function(){
		mascara( this, mtel );
	}
}
//==================
function duplicarCampos(){
	var clone = document.getElementById('origem').cloneNode(true);
	var destino = document.getElementById('destino');
	destino.appendChild (clone);
	
	var camposClonados = clone.getElementsByTagName('input');
	
	for(i=0; i<camposClonados.length;i++){
		camposClonados[i].value = '';
	}
	
	
	
}

function removerCampos(id){
	var node1 = document.getElementById('destino');
	node1.removeChild(node1.childNodes[0]);
}

//=================================================================
function duplicarCamposArea(){
	var clone = document.getElementById('origemArea').cloneNode(true);
	var destino = document.getElementById('destinoArea');
	destino.appendChild (clone);
	
	var camposClonados = clone.getElementsByTagName('input');
	
	for(i=0; i<camposClonados.length;i++){
		camposClonados[i].value = '';
	}
	
}

function removerCamposArea(id){
	var node1 = document.getElementById('destinoArea');
	node1.removeChild(node1.childNodes[0]);
}
</script>
<?php 
if(isset($_SESSION["erroCadastro"])){ ?>
    <div class="bg-danger text-center">
        <h4 class="text-light"><?=$_SESSION["erroCadastro"]; ?></h4>
    </div>
<?php unset($_SESSION["erroCadastro"]);
} else {?>
<br>
<?php } ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-9 col-md-9">
                <?php if(!isset($idEditar)){ ?>
                    <h1>Cadastro</h1>
                <?php }else{ ?>
                    <h1>Editar Cadastro</h1>
                <?php } ?>
            </div>
            <div class="col-sm-3 col-md-3">
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
                <?php require_once("../navbar/menu_lateral.php") ?>
            </nav>
        </div>
        
        <div class="col-xl-9 col-lg-9">
            <div class="row">
                <?php if(!isset($idEditar)) {?>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item w-50 text-center"><a href="#C_Aluno" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">Aluno</a></li>
                    <li class="nav-item w-50 text-center"><a href="#C_Professor" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab">Professor</a></li>
                </ul>
               
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="C_Aluno">
                        <br>

                 <?php } 
                    if(!isset($idEditar) || isset($turma)){
                 ?>           
                            <form class="needs-validation was-validation" action="../../bd/salvarAluno.php" method="post" onsubmit="return validaSenha();">
                            
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                    <label for="inputNome">Nome:</label>
                                        <input type="text" id="inputNome" class="form-control" 
                                        placeholder="Digite seu nome" name="nome" <?php if(isset($idEditar)){ ?> 
                                        value="<?=($nome) ?>" <?php } else if(isset($_SESSION['NomeAluno'])) { ?> 
                                        value="<?=($_SESSION['NomeAluno']) ?>" <?php } ?> required autofocus>
                                    </div>
                            
                                    <div class="col-md-6 mb-3">
                                    <label for="inputCPF">CPF:</label>
                                    <label for="inputCPF" class="text-secondary"> não obrigatório:</label>
                                        <input type="tel" id="inputCPF" class="form-control" placeholder="Digite seu CPF" name="CPF" 
                                        <?php if(isset($idEditar) && $cpf!="Sem CPF"){ ?> value="<?=($cpf); ?>" <?php } else if(isset($_SESSION['CpfAluno'])) { ?> 
                                        value="<?=($_SESSION['CpfAluno']) ?>" <?php } ?> onkeydown="javascript: fMasc( this, mCPF );" 
                                        maxlength="14" minlength="14">
                                    </div>
                            
                                    <div class="col-md-6 mb-3">
                                    <label for="inputRA">RA:</label>
                                        <input type="number" id="inputRA" class="form-control" placeholder="Digite seu RA" name="RA" <?php if(isset($idEditar)){ ?> 
                                        value="<?=($ra) ?>" <?php } else if(isset($_SESSION['RaAluno'])) { ?> 
                                        value="<?=($_SESSION['RaAluno']) ?>" <?php } ?> required>
                                    </div>
                            
                                    <div class="form-group col-md-12 mb-3">
                                        <label for="Campus">Campus</label>
                                        <select class="form-control" id="Campus" name="Campus" required>
                                        <option value="" disabled selected>Selecione seu Campus:</option>
                                        <?php foreach($vetorTodosCampus as $vetorUmRegistro){ ?>
                                            <option value="<?=$vetorUmRegistro['idCampus']?>" <?php 
                                                if((isset($idEditar) && $campus==$vetorUmRegistro['nomeCampus']) ||
                                                (isset($_SESSION['CampusAluno']) && $vetorUmRegistro["idCampus"]==
                                                $_SESSION['CampusAluno'])){
                                                ?> selected <?php }?>>
                                                <?=$vetorUmRegistro['nomeCampus'];?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-12 mb-3">
                                    <label for="Curso">Curso:</label>
                                        <select class="form-control" id="Curso" name="Curso" required>
                                        <option value="" disabled selected>Selecione seu Curso</option>
                                        <?php foreach($vetorTodosCursos as $vetorUmRegistro){ ?>
                                            <option value="<?=$vetorUmRegistro['idCurso']?>"<?php 
                                                if((isset($idEditar) && $curso==$vetorUmRegistro['nomeCurso'])||
                                                (isset($_SESSION['CursoAluno']) && $vetorUmRegistro["idCurso"]==
                                                $_SESSION['CursoAluno'])){
                                                ?> selected <?php }?>>                                            
                                            <?=$vetorUmRegistro['nomeCurso'];?></option>
                                        <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="area">Área(s) de interesse:</label>
                                        <select class="form-control multiple-select" name="area[]" id="area" multiple="multiple" required
                                        style="width:100%;">
                                            <option value="" disabled>Selecione suas áreas de interesse</option>
                                            <?php foreach($vetorTodasAreas as $vetorUmRegistro){ ?>
                                                <option value="<?=$vetorUmRegistro['idArea'];?>"<?php 
                                                    if(isset($idEditar)){
                                                        foreach($vetorAreaEditar as $vAE){
                                                            if($vetorUmRegistro['idArea']==$vAE['idArea']){ 
                                                                ?> selected <?php 
                                                            }
                                                        }
                                                    } ?>><?=$vetorUmRegistro['nomeArea'];?></option>    
                                            <?php } ?>
                                        </select>
                                    </div> 
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="inputEmail">E-mail:</label>
                                        <input type="email" id="inputEmail" class="form-control" placeholder="Digite seu e-mail"
                                        <?php if(isset($idEditar)){ ?> value="<?=($email) ?>" <?php } ?>name="Email" required>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="inputTurma">Turma:</label>
                                        <input type="text" id="inputTurma" class="form-control" placeholder="Ex: 1027A" 
                                        <?php if(isset($idEditar)){ ?> value="<?=($turma) ?>" <?php } else if(isset($_SESSION['TurmaAluno'])) { ?> 
                                        value="<?=($_SESSION['TurmaAluno']) ?>" <?php } ?> name="turma" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="inputSenha">Senha:</label>
                                        <input type="password" id="inputSenha" class="form-control" placeholder="Digite uma senha" 
                                        <?php if(!isset($idEditar)){ ?> required <?php } ?> name="Senha" data-minlength="6" maxlength="16">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="inputConfirmaSenha">Confirmar senha:</label>
                                        <input type="password" id="inputConfirmaSenha" class="form-control" placeholder="Confirma senha"
                                        <?php if(!isset($idEditar)){ ?> required <?php } ?> name="confSenha" data-minlength="6">
                                    </div>

                                </div>
                                
                                <div class="row">

                                    <?php if(!isset($idEditar)){ ?>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-lg btn-outline-info btn-block">Salvar</button>
                                    </div>

                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-lg btn-outline-danger btn-block">Cancelar</button>
                                    </div>
                                    <?php }else{ ?>
                                        <input type="hidden" name="idEditar" value="<?php echo($idEditar);?>">
                                        <input type="hidden" name="idLoginEditar" value="<?php echo($senha['id']);?>">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-lg btn-outline-info btn-block">Editar</button>
                                        </div>

                                        <div class="col-md-6">
                                            <a class="btn btn-lg btn-outline-danger btn-block" role="bottun" href="../perfil.php">Cancelar</a>
                                        </div>
                                    <?php } ?>

                                </div>

                            </form>
                        <?php } ?>
                        </div>


                        <!-- CADASTRO PROFESSOR =========================================================== -->
                        <?php if(!isset($idEditar)) { ?>
                        <div role="tabpanel" class="tab-pane" id="C_Professor">
                        <br>
                        <?php } 
                            if(!isset($idEditar) || isset($siap)){
                        ?> 
                            <form action="../../bd/salvarProfessor.php" method="post" onsubmit="return ValidaHorario();">
                                
                                <div class="row">

                                    <div class="form-group col-md-12">
                                    <label for="inputNome">Nome:</label>
                                        <input type="text" id="inputNome" class="form-control" placeholder="Digite seu Nome" 
                                        <?php if(isset($idEditar)){ ?> value="<?=($nome) ?>" <?php } else if(isset($_SESSION['NomeProf'])) { ?> 
                                        value="<?=($_SESSION['NomeProf']) ?>" <?php } ?> name="nome" required autofocus>
                                    </div>

                                    <div class="form-group col-md-6">
                                    <label for="CPF">CPF:</label>
                                    <label for="inputCPF" class="text-secondary"> não obrigatório: </label>
                                        <input type="tel" id="inputCPF" class="form-control" placeholder="Digite seu CPF" 
                                        <?php if(isset($idEditar) && $cpf!="Sem CPF"){ ?> value="<?=($cpf) ?>" <?php } else if(isset($_SESSION['CpfProf'])) { ?> 
                                        value="<?=($_SESSION['CpfProf']) ?>" <?php } ?> name="CPF" onkeydown="javascript: fMasc( this, mCPF );" 
                                        maxlength="14" minlength="14">
                                    </div>

                                    <div class="form-group col-md-6">
                                    <label for="inputSiap">Siap:</label>
                                        <input type="number" id="inputSiap" class="form-control" placeholder="Digite seu Siap" 
                                        <?php if(isset($idEditar)){ ?> value="<?=($siap) ?>" <?php } else if(isset($_SESSION['SiapProf'])) { ?> 
                                        value="<?=($_SESSION['SiapProf']) ?>" <?php } ?> name="siap" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                    <label for="inputEmail">E-mail:</label>
                                        <input type="email" id="inputEmail" class="form-control" placeholder="Digite seu Email" 
                                        <?php if(isset($idEditar)){ ?> value="<?=($email) ?>" <?php } ?>name="email" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                    <label for="telefone">Telefone:</label>
                                    <label for="telefone" class="text-secondary"> não obrigatório: </label> 
                                    <label for="telefone" class="text-danger"> O número informado ficará visivel para os Alunos:</label>
                                    <label for="telefone"></label>
                                        <input type="text" id="telefone" class="form-control" placeholder="Digite seu telefone celular: (99) 99999-9999" 
                                        <?php if(isset($idEditar) && isset($telefone)){ ?> value="<?=($telefone) ?>" <?php } ?> name="telefone" maxlength="15" minlength="15">
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                    <label for="Campus">Campus:</label>
                                        <select class="form-control" id="Campus" name="Campus" required>
                                        <option value="" disabled selected>Selecione seu Campus</option>
                                        <?php foreach($vetorTodosCampus as $vetorUmRegistro){ ?>
                                            <option value="<?=$vetorUmRegistro['idCampus'];?>"<?php 
                                                if((isset($idEditar) && $campus==$vetorUmRegistro['nomeCampus'])||
                                                (isset($_SESSION['CampusProf']) && $vetorUmRegistro["idCampus"]==
                                                $_SESSION['CampusProf'])){
                                                ?> selected <?php }?>>
                                                <?=$vetorUmRegistro['nomeCampus'];?></option>
                                        <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="areaProf">Área(s) de atuação:</label>
                                        <select class="form-control multiple-select selArea" name="area[]" id="areaProf" multiple="multiple" required
                                        style="width:100%;">
                                            <option value="" disabled>Selecione suas áreas de atuação</option>
                                            <?php foreach($vetorTodasAreas as $vetorUmRegistro){ ?>
                                                <option value="<?=$vetorUmRegistro['idArea'];?>"<?php 
                                                    if(isset($idEditar)){
                                                        foreach($vetorAreaEditar as $vAE){
                                                            if($vetorUmRegistro['idArea']==$vAE['idArea']){ 
                                                                ?> selected <?php 
                                                            }
                                                        }
                                                    } ?>><?=$vetorUmRegistro['nomeArea'];?></option>    
                                            <?php } ?>
                                        </select>
                                        <label for="checkCadastroArea"><strong>Não encontrou sua Área? Clique para cadastrá-la</strong></label>
                                        <input type="checkbox" name="checkCadastroArea" id="checkCadastroArea" value="1">
                                    </div>       
                                    <div class="col-md-12 mb3">
                                        

                                        <div id="origemArea" class="divCadastroArea" hidden>
                                            <div class="form-group row">
                                                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                                    <label for="nomeArea">Nome da Área:</label>
                                                    <input type="text" class="form-control nomeArea" name="inputNome[]" id="inputNome">
                                                </div>
                                                
                                                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-plus" onclick="duplicarCamposArea();"></i></h2></div>
                                                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-minus" onclick="removerCamposArea(this);"></i></h2></div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 divCadastroArea hidden" id="destinoArea">
                                    </div>

                                    <div class="col-md-12">
                                    <label for="colocarH"><strong>Adicionar Horário para que os alunos lhe procurem?</strong></label>
                                    <input type="checkbox" name="colocarH" id="colocarH" value="1" <?php if(isset($vetorHoraEditar) && (count($vetorHoraEditar)>0)){?>
                                        checked <?php } ?>>  
                                        <?php 
                                            if(isset($vetorHoraEditar) && (count($vetorHoraEditar)>0)){
                                                foreach($vetorHoraEditar as $VHE):
                                        ?>
                                            <div id="<?php if($cont==0){ ?>origem<?php }else{ ?>destino<?php } ?>" class="horario" <?php if(!isset($vetorHoraEditar)){?> hidden <?php } ?> >
                                                <div class="form-group row">
                                                    <div class="col-xl-3">
                                                        <label for="dia">Dia da Semana</label>
                                                        <select name="dia[]" id="dia" class="form-control dia" required>
                                                                <option value="SEG"<?php if(isset($VHE) && $VHE['diaSemana']=="SEG"){?> selected <?php } ?>>Segunda</option>
                                                                <option value="TER"<?php if(isset($VHE) && $VHE['diaSemana']=="TER"){?> selected <?php } ?>>Terça</option>
                                                                <option value="QUA"<?php if(isset($VHE) && $VHE['diaSemana']=="QUA"){?> selected <?php } ?>>Quarta</option>
                                                                <option value="QUI"<?php if(isset($VHE) && $VHE['diaSemana']=="QUI"){?> selected <?php } ?>>Quinta</option>
                                                                <option value="SEX"<?php if(isset($VHE) && $VHE['diaSemana']=="SEX"){?> selected <?php } ?>>Sexta</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-7">
                                                        <label for="horario">Horário:</label>
                                                        <div class="row">
                                                            <label class="col-sm-1 col-md-1 col-lg-1 col-xl-1">Das:</label>
                                                            <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                                <input type="time" id="horario" name="horario[]" class="form-control hora" 
                                                                <?php if(isset($VHE)){?> value="<?php echo($VHE["horarioIni"]) ?>" <?php } ?>
                                                                min="07:00" max="22:00" required>
                                                            </div>
                                                            
                                                            <label class="col-sm-1 col-md-1 col-lg-1 col-xl-1">ás:</label>
                                                            <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                                <input type="time" id="horario" name="horario[]" class="form-control hora"
                                                                <?php if(isset($VHE)){?> value="<?php echo($VHE["horarioFin"]) ?>" <?php } ?>
                                                                min="07:00" max="22:00" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-plus" onclick="duplicarCampos();"></i></h2></div>
                                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-minus" onclick="removerCampos(this);"></i></h2></div>
                                                    
                                                </div>
                                            </div>
                                            <?php 
                                                $cont += 1;
                                                endforeach;
                                            ?>
                                        <?php } else {?>
                                            <div id="origem" class="horario" hidden>
                                                <div class="form-group row">
                                                    <div class="col-xl-3">
                                                        <label for="dia">Dia da Semana</label>
                                                        <select name="dia[]" id="dia" class="form-control dia">
                                                                <option value="SEG"<?php if(isset($VHE) && $VHE['diaSemana']=="SEG"){?> selected <?php } ?>>Segunda</option>
                                                                <option value="TER"<?php if(isset($VHE) && $VHE['diaSemana']=="TER"){?> selected <?php } ?>>Terça</option>
                                                                <option value="QUA"<?php if(isset($VHE) && $VHE['diaSemana']=="QUA"){?> selected <?php } ?>>Quarta</option>
                                                                <option value="QUI"<?php if(isset($VHE) && $VHE['diaSemana']=="QUI"){?> selected <?php } ?>>Quinta</option>
                                                                <option value="SEX"<?php if(isset($VHE) && $VHE['diaSemana']=="SEX"){?> selected <?php } ?>>Sexta</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-7">
                                                        <label for="horario">Horário:</label>
                                                        <div class="row">
                                                            <label class="col-sm-1 col-md-1 col-lg-1 col-xl-1">Das:</label>
                                                            <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                                <input type="time" id="horario" name="horario[]" class="form-control hora" 
                                                                <?php if(isset($VHE)){?> value="<?php echo($VHE["horarioIni"]) ?>" <?php } ?>
                                                                min="07:00" max="22:00">
                                                            </div>
                                                            
                                                            <label class="col-sm-1 col-md-1 col-lg-1 col-xl-1">ás:</label>
                                                            <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                                                                <input type="time" id="horario" name="horario[]" class="form-control hora"
                                                                <?php if(isset($VHE)){?> value="<?php echo($VHE["horarioFin"]) ?>" <?php } ?>
                                                                min="07:00" max="22:00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-plus" onclick="duplicarCampos();"></i></h2></div>
                                                    <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"><br><h2><i class="fa fa-minus" onclick="removerCampos(this);"></i></h2></div>
                                                    
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                
                                    <div class="col-md-12 horario hidden" id="destino">
                                    </div>
                                    

                                    <div class="form-group col-md-6">
                                    <label for="inputSenha">Senha:</label>
                                        <input type="password" id="inputSenha" class="form-control" placeholder="Senha" 
                                        <?php if(!isset($idEditar)){ ?> required <?php } ?> name="senha" data-minlength="6">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="inputConfirmaSenha">Confirmar senha:</label>
                                        <input type="password" id="inputConfirmaSenha" class="form-control" placeholder="Confirma Senha" 
                                        <?php if(!isset($idEditar)){ ?> required <?php } ?> name="confSenha" data-minlength="6" >
                                    </div>

                                </div>

                                <div class="row">
                                    <?php if(!isset($idEditar)){ ?>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-lg btn-outline-info btn-block">Salvar</button>
                                    </div>

                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-lg btn-outline-danger btn-block">Cancelar</button>
                                    </div>
                                    <?php }else{ ?>
                                        <input type="hidden" name="idEditar" value="<?php echo($idEditar);?>">
                                        <input type="hidden" name="idLoginEditar" value="<?php echo($senha['id']);?>">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-lg btn-outline-info btn-block">Editar</button>
                                        </div>

                                        <div class="col-md-6">
                                            <a class="btn btn-lg btn-outline-danger btn-block" role="bottun" href="../perfil.php">Cancelar</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </form>
                        <?php } ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>  
</div>

<?php include_once('../navbar/footer.php'); ?>

<script>
function ValidaHorario(){
    var erros = 0;
    var a = document.getElementById("colocarH");
    if(a.checked){
        var c = document.getElementsByClassName("hora");
        for (i = 0; i < c.length; i += 2) {
            hora1 = c[i].value.split(":");
            hora2 = c[i+1].value.split(":");
            h11 = parseInt(hora1[0]);
            h12 = parseInt(hora1[1]);
            h21 = parseInt(hora2[0]);
            h22 = parseInt(hora2[1]);
            
            if(h11 > h21){
                alert("O horario final do atendimento não pode ser anterior ao inicial:");
                erros += 1;
            } else if(h11==h21 && h12>h22){
                alert("O horario final do atendimento não pode ser anterior ao inicial:");
                erros += 1;
            } else if(h11==h21 && h12==h22){
                alert("O horario final do atendimento não pode ser igual ao inicial:");
                erros += 1;
            }
        }

        var b = document.getElementsByClassName("dia");
        if(b.length > 1){
            for (i = 0; i < b.length; i++) {
                for (j = i+1; j < b.length; j++) {
                    if(b[i].value == b[j].value){
                        hora11 = c[(i*2)].value.split(":");
                        hora12 = c[(i*2)+1].value.split(":");
                        hi1 = parseInt(hora11[0]);
                        mi1 = parseInt(hora11[1]);
                        hf1 = parseInt(hora12[0]);
                        mf1 = parseInt(hora12[1]);
                        
                        hora21 = c[(j*2)].value.split(":");
                        hora22 = c[(j*2)+1].value.split(":");
                        hi2 = parseInt(hora21[0]);
                        mi2 = parseInt(hora21[1]);
                        hf2 = parseInt(hora22[0]);
                        mf2 = parseInt(hora22[1]);

                        if((hi2 > hi1 && hi2 < hf1) || (hf2 > hi1 && hf2 < hf1)){
                            alert("sobreposição de horários:");
                            erros = erros + 1;
                        } else if((hi2 == hi1) && (mi2 > mi1 || mi2 == mi1)){
                            alert("sobreposição de horários:");
                            erros = erros + 1;
                        } else if((hf2 == hf1) && (mf2 > mf1 || mf2 == mf1)){
                            alert("sobreposição de horários:");
                            erros = erros + 1;
                        } else if((hi2 == hi1 && mi2 == mi1) && (hf2 == hf1 && mf2 == mf1)){
                            alert("sobreposição de horários:");
                            erros = erros + 1;
                        }
                    }
                }
            }
        }
    }

    if (validaSenha() == false) {
        erros = erros + 1;
    }

    if(erros > 0){
        return false;
    } else {
        return true;
    }

}

    function validarCPF(cpf) {	
        cpf = cpf.replace(/[^\d]+/g,'');	
        if(cpf == '') return false;	
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 || 
            cpf == "00000000000" || 
            cpf == "11111111111" || 
            cpf == "22222222222" || 
            cpf == "33333333333" || 
            cpf == "44444444444" || 
            cpf == "55555555555" || 
            cpf == "66666666666" || 
            cpf == "77777777777" || 
            cpf == "88888888888" || 
            cpf == "99999999999")
                return false;		
        // Valida 1o digito	
        add = 0;	
        for (i=0; i < 9; i ++)		
            add += parseInt(cpf.charAt(i)) * (10 - i);	
            rev = 11 - (add % 11);	
            if (rev == 10 || rev == 11)		
                rev = 0;	
            if (rev != parseInt(cpf.charAt(9)))		
                return false;		
        // Valida 2o digito	
        add = 0;	
        for (i = 0; i < 10; i ++)		
            add += parseInt(cpf.charAt(i)) * (11 - i);	
        rev = 11 - (add % 11);	
        if (rev == 10 || rev == 11)	
            rev = 0;	
        if (rev != parseInt(cpf.charAt(10)))
            return false;		
        return true;   
}

$(document).ready(function(){$("#botaoLogin").click(function(){
    if($("#inputCPF").val()==''){
        $("#saida").show();$("#saida").html("<div class='alert alert-secondary' role='alert'>Informe um CPF na Caixa Acima</div>");
        return false;
        }
    if(validarCPF($("#inputCPF").val())){
        // $("#saida").show();$("#saida").html("<div class='alert alert-success' role='alert'>CPF Válido!</div>");
        return true;
    }else{
        $("#saida").show();$("#saida").html("<div class='alert alert-danger' role='alert'>CPF Inválido!</div>");
        return false;
        }
    }
);

$("#inputCPF").mask("999.999.999-99");
});

$(document).ready(function() {
    $('.multiple-select').select2();
});

$(document).ready(function() {
    $('input:checkbox[name="colocarH"]').on("change", function() {
        var a = document.getElementsByClassName("horario");
        var b = document.getElementsByClassName("dia");
        var c = document.getElementsByClassName("hora");
        if (this.checked && this.value == '1') {
            for(i = 0; i < a.length; i++){
                a[i].removeAttribute("hidden");
            }
            for(i = 0; i < b.length; i++){
                b[i].setAttribute("required", ".dia");
            }
            for(i = 0; i < c.length; i++){
                c[i].setAttribute("required", ".hora");
            }
        } else {
            for(i = 0; i < a.length; i++){
                a[i].setAttribute("hidden", ".horario");
            }
            for(i = 0; i < b.length; i++){
                b[i].removeAttribute("required", ".dia");
            }
            for(i = 0; i < c.length; i++){
                c[i].removeAttribute("required", ".hora");
            }
        }
    });
});

$(document).ready(function() {
    $('input:checkbox[name="checkCadastroArea"]').on("change", function() {
        var a = document.getElementsByClassName("divCadastroArea");
        var b = document.getElementsByClassName("nomeArea");
        var c = document.getElementsByClassName("selArea");
        if (this.checked && this.value == '1') {
            for(i = 0; i < a.length; i++){
                a[i].removeAttribute("hidden");
            }
            for(i = 0; i < b.length; i++){
                b[i].setAttribute("required", ".nomeArea");
            }
            c[0].removeAttribute("required", ".selArea");
        } else {
            for(i = 0; i < a.length; i++){
                a[i].setAttribute("hidden", ".divCadastroArea");
            }
            for(i = 0; i < b.length; i++){
                b[i].removeAttribute("required", ".nomeArea");
            }
            c[0].setAttribute("required", ".selArea");
        }
    });
});

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
</body>
</html>
