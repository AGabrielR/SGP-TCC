<!DOCTYPE html>
<html lang="pt-br">
<?php include('../protege.php');
protege(); ?>
<head>
    <meta charset="UTF-8">
    <title>Cadastro Projetos</title>
    <?php require_once('../navbar/navbar.php'); ?>
    <?php require_once('../../bd/conexao.php'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
        if(isset($_POST["id"])){
            $idEditar = $_POST["id"];
            $titulo = "Editar Projeto:";
            $sql = "SELECT * FROM projeto WHERE projeto.idProj = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorEdicao = mysqli_fetch_assoc($resultadoSql);

            
            $sql = "SELECT * FROM areaProjeto WHERE idProjeto = ?";
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
            
            $sql = "SELECT * FROM alunosProj WHERE idProj = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idEditar);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $vetorAlunosInscritos = array();
            while($vetorUmRegistro != null){
            array_push($vetorAlunosInscritos, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }

            if(isset($vetorEdicao['idProf']) && !isset($vetorEdicao['orienta'])) {
                $temProf = 1;
            }
            
        }else{
            $titulo = "Cadastro de Projeto:";
        }

        $sql = "SELECT * FROM Aluno";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosAlunos = array();
        while($vetorUmRegistroAluno != null){
            array_push($vetorTodosAlunos, $vetorUmRegistroAluno);
            $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
        }

        if($_SESSION['tipoLogin']=="Aluno" || isset($_SESSION["ADMIN"])){
            $sql = "SELECT * FROM professor";
            $resultadoSQL= mysqli_query($conexao, $sql);
            $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
            $vetorTodosProfs = array();
            while($vetorUmRegistroAluno != null){
                array_push($vetorTodosProfs, $vetorUmRegistroAluno);
                $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
            }
        }

        $id=intval($_SESSION["id"]);
        $sql = "SELECT * FROM areaInteresse";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosResultados = array();

        while($vetorUmRegistro != null){
            array_push($vetorTodosResultados, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        if(isset($vetorEdicao)){
            $foto = $vetorEdicao['fotoProj'];
        } else {
            $foto = "Escolha uma imagem";
        }
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<link href="../../css/select2.min.css" rel="stylesheet" />
<script src="../../css/select2.min.js"></script>

</head>
<style>
.hidden{
    display: none;
}

.show{
    display: block;
}
</style>

<body>
<?php if(isset($_SESSION["nomeProjeto"])){ ?>
        <div class="bg-danger text-center">
            <h4 class="text-light"><?=$_SESSION["nomeProjeto"]; ?></h4>
        </div>
    <?php unset($_SESSION["nomeProjeto"]);
    } else { ?>
        <br> 
    <?php } ?> 
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9  col-lg-6 col-xl-6">
                <h1><?php echo($titulo) ?></h1>
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
                <?php require_once("../navbar/menu_lateral.php") ?>
            </nav>
        </div>
        <div class="col-xl-9 col-lg-9">
            <form action="../../bd/salvarProjeto.php" method="post" enctype="multipart/form-data" onsubmit="return dateCont();">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label for="inputNome">Título do Projeto</label>
                        <input type="text" id="inputNome" class="form-control" placeholder="Digite o título do projeto" name="titulo" 
                        <?php if(isset($idEditar)){ ?> value="<?php echo($vetorEdicao['tituloProj']) ?>" 
                        <?php } ?> required autofocus>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="inputDataInicio">Data de Inicio</label>
                        <input type="date" id="inputDataInicio" class="form-control" name="dataIni" 
                        <?php if(isset($idEditar)){ ?> value="<?php echo($vetorEdicao['dataIniProj']) ?>" 
                        <?php } ?> <?php if($_SESSION['tipoLogin']!="Aluno"){ ?> required <?php } ?>>
                    </div>
                            
                    <div class="col-md-6 mb-3">
                        <label for="inputDataFinal">Data Final</label>
                        <input type="date" id="inputDataFinal" class="form-control" name="dataFinal"
                        <?php if(isset($idEditar)){ ?> value="<?php echo($vetorEdicao['dataFinProj']) ?>" 
                        <?php } ?>>
                    </div>

                    <div class="col-md-12 mb-3">
                        <?php if($_SESSION['tipoLogin']!="Aluno"){ ?>
                            <label for="inputResumo">Resumo do Projeto</label>
                        <?php } else { ?>
                            <label for="inputResumo">Ideia Central do Projeto</label>
                        <?php } ?>
                        <textarea class="form-control" rows="3" maxlength="500" placeholder="Limite de 500 caracteres" 
                         id="inputResumo" name="resumo" required><?php if(isset($idEditar)){ echo($vetorEdicao['resumoProj']); } ?></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="inputFoto">Foto do projeto:</label>
                        <label for="inputFoto" class="text-black-50"> será inserida uma imagem padrão caso nenhuma seja selecionada</label> 
                        <div class="row">

                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input id="inputFoto" type="file" name="inputFoto" class="custom-file-input" <?php if(isset($idEditar)){ ?> 
                                    value="<?=$vetorEdicao['fotoProj']?>" <?php } ?>>
                                    <label for="inputFoto" class="custom-file-label text-truncate" id="cFoto"><?=$foto?></label>
                                    <label for="inputFoto" class="custom-file-label text-truncate hidden" id='sFoto'>Selecione uma imagem</label>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger active col-md-12" data-toggle="button" aria-pressed="true" autocomplete="on" onClick="tirarFoto()">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <input type="hidden" name="apagar" id="apagar" value="1">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="area">Área de atuação do Projeto</label>
                        <select class="form-control multiple-select" name="area[]" id="area" multiple="multiple" required
                        style="width:100%;">
                            <option value="" disabled>Selecione as áreas em que o projeto se encaixa</option>
                            <?php foreach($vetorTodosResultados as $vetorArea){?>
                                <option value="<?=$vetorArea['idArea'];?>" <?php 
                                    if(isset($vetorEdicao)){
                                        foreach($vetorAreaEditar as $vAE){
                                            if($vetorArea['idArea']==$vAE['idArea']){ 
                                                ?> selected <?php 
                                            }
                                        }
                                    } ?>><?=$vetorArea['nomeArea'];?></option>    
                            <?php } ?>
                        </select>
                    </div> 

                    <?php if($_SESSION['tipoLogin']=="Aluno" || (isset($_SESSION["ADMIN"]) && !isset($vetorEdicao))){ ?>
                        <div class="col-md-12 mb-3">
                            <label for="alunosInsc">Professor Orientador</label>
                            <select class="form-control" name="Orientador" id="POrientador" 
                            <?php if(isset($_SESSION['ADMIN'])){ ?> required <?php } ?>>
                                <?php if(isset($_SESSION['ADMIN'])){ ?> 
                                    <option value="" disabled <?php if(!isset($temProf)){ ?> selected <?php } ?> hidden>
                                        Selecione o Professor Orientador
                                    </option>
                                <?php } else { ?>
                                    <option value="" disabled <?php if(!isset($temProf)){ ?> selected <?php } ?> hidden>
                                        Selecione se o seu projeto já possuir um Professor orientador
                                    </option>
                                    <option class="alter" value="sem">
                                        Não possuo orientador
                                    </option>
                                <?php }  ?>
                                
                                <?php foreach($vetorTodosProfs as $vetorUmRegistro){ ?>
                                    <option  class="alter" value="<?=$vetorUmRegistro['idProf'];?>"
                                    <?php if(isset($temProf) && $temProf==1 && $vetorUmRegistro['idProf']==$vetorEdicao['idProf']) { ?> selected <?php } ?>>
                                    <?=$vetorUmRegistro['nomeProf'];?></option>    
                                <?php } ?>
                            </select>
                            <?php if(!isset($_SESSION["ADMIN"])){ ?>
                                <div class="text-danger">Será enviada uma solicitação para o professor, ele será adicionado como orientador caso ela seja aceita</div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="qtdVagas">Vagas:</label>
                            </div>
                            <!-- Vagas -->
                            <select class="custom-select" id="qtdVagas" name="qtdVagas" required>
                                <option selected disabled="disabled">Selecione a quantidades de vagas que o seu projeto possuirá (incluindo os que já participam)</option>
                                <option value="1" id="op1" class="selOp" <?php if(isset($vetorEdicao) && $vetorEdicao['vagasProj']==1){ ?> selected <?php } ?>>Uma</option>
                                <option value="2" id="op2" class="selOp" <?php if(isset($vetorEdicao) && $vetorEdicao['vagasProj']==2){ ?> selected <?php } ?>>Duas</option>
                                <option value="3" id="op3" class="selOp" <?php if(isset($vetorEdicao) && $vetorEdicao['vagasProj']==3){ ?> selected <?php } ?>>Três</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3 <?php if(!isset($vetorEdicao)){ ?> hidden <?php } ?>" id="selAlunos">
                        <label for="alunosInsc">Alunos que participam do Projeto</label>
                        <select class="form-control multiple-select" style="width:100%;" name="alunosInsc[]" id="alunosInsc"  
                        onchange="maxAllowedMultiselect(this)" multiple="multiple">
                            <option value="" disabled>Se houver selecione os Alunos que participam do projeto</option>
                            <option value="" class="hidden" id="msg" disabled></option>
                            <?php foreach($vetorTodosAlunos as $vetorUmRegistro){ ?>
                                <option  class="alter" value="<?=$vetorUmRegistro['idAluno'];?>"
                                <?php if(isset($vetorEdicao)){ 
                                    foreach($vetorAlunosInscritos as $vAI){
                                        if($vetorUmRegistro['idAluno']==$vAI['idAluno']){ 
                                            ?> selected <?php 
                                        }
                                    }} ?>
                                ><?=$vetorUmRegistro['nomeAluno'];?></option>    
                            <?php } ?>
                        </select>
                    </div>
                   

                    <?php if($_SESSION["tipoLogin"]!="Aluno"){ ?>
                        <input type="hidden" value="Professor" name="TipoUsuario">
                    <?php } else { ?>
                        <input type="hidden" value="Aluno" name="TipoUsuario">
                    <?php } ?>
                    
                    <?php if(isset($_SESSION['ADMIN'])){ ?>
                        <input type="hidden" value="ADMIN" name="ADMIN">
                    <?php } ?>

                </div>
                <div class="row">
                    <?php if(isset($vetorEdicao)){ ?>
                        <input type="hidden" value="edicao" name="tipo">
                        <input type="hidden" value="<?=$vetorEdicao['idProj']; ?>" name="idProj">
                    <?php } ?>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-lg btn-outline-info btn-block">Salvar</button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-lg btn-outline-danger btn-block" role="bottun" href="../meus_projetos.php">Cancelar</a>
                    </div>
                    
                </div>
            </form>
            <br>
        </div>
    </div>
</div>
</body>

<?php include_once('../navbar/footer.php'); ?>

<script>
$(document).ready(function () {

$('#qtdVagas').change(function () {
    $("#selInsc").removeClass("hidden");
    var OpSel = document.getElementById("qtdVagas");

    if(OpSel.value != 0){
        $("#selAlunos").removeClass("hidden");
        maxAllowedMultiselect(document.getElementById("alunosInsc"));
    } else {
        $("#selAlunos").addClass("hidden");
    }

});
});


function maxAllowedMultiselect(obj) {
    var aux = document.getElementById("qtdVagas");
    var maxAllowedCount = aux.value;
    var selectedOptions = jQuery('#'+obj.id+" option[value!=\'\']:selected");
    if (selectedOptions.length >= maxAllowedCount) {
        if (selectedOptions.length > maxAllowedCount) {
            selectedOptions.each(function(i) {
                if (i >= maxAllowedCount) {
                    jQuery(this).prop("selected",false);
                }
            });
        } 
        jQuery('#'+obj.id+' option[value!=\'\']').not(':selected').prop("disabled",true);
    } else {    
        jQuery('#'+obj.id+' option[value!=\'\']').prop("disabled",false);
    }
}

function dateCont(){
    var erros = 0;

    var date1 = new Date(document.getElementById("inputDataInicio").value);
    var now = new Date();  
    var diff = Math.abs(date1.getTime() - now.getTime());
    var diasDiferenca = Math.ceil(diff / (1000 * 60 * 60 * 24));
    
    if(diasDiferenca > 1825){
        alert("Data de Inicio Inválida");
        erros++;
    }
    
    var date2 = new Date(document.getElementById("inputDataFinal").value); 
    var dias1 = Math.ceil(date1.getTime() / (1000 * 60 * 60 * 24));
    var dias2 = Math.ceil(date2.getTime() / (1000 * 60 * 60 * 24));

    if(dias1 > dias2){
        alert('A Data Final não pode ser Anterior a Data inicial!');
        erros++;
    }
    
    if(erros > 0){
        return false;
    } else {
        return true;
    }

}


$(document).ready(function() {
    $('.multiple-select').select2();
});

$('.custom-file-input').on('change', function() { 
    let fileName = $(this).val().split('\\').pop(); 
    $("#cFoto").addClass("selected").html(fileName);
    $("#sFoto").addClass("selected").html(fileName);
    document.getElementById("apagar").value = "2";
});


function tirarFoto(){
    document.getElementById("apagar").value = "3";
    $("#sFoto").removeClass("hidden");
    $("#cFoto").addClass("hidden");
    $("#sFoto").addClass("selected").html('Selecione uma imagem');
}
</script>

</html>