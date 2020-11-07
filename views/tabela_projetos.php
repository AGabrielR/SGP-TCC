<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // include('protege.php');
    // protege(); 
    
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');
    $titulo = "Projetos";

    $sql = "SELECT * FROM projeto";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    $vetorTodosProj = array();
    while($vetorUmRegistro != null){
        array_push($vetorTodosProj, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    }

    $sql = "SELECT DISTINCT professor.idProf, professor.nomeProf FROM projeto INNER JOIN professor ON projeto.idProf = professor.idProf";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    $vetorProfessores = array();

    while($vetorUmRegistro != null){
        array_push($vetorProfessores, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    }

    $sql = "SELECT DISTINCT aluno.nomeAluno, aluno.idAluno FROM aluno INNER JOIN projeto ON aluno.idAluno = projeto.idAluno";
    $resultadoSQL= mysqli_query($conexao, $sql);
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    $vetorAlunos = array();

    while($vetorUmRegistro != null){
        array_push($vetorAlunos, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
    }

    $sql = "SELECT areaprojeto.idProjeto, areainteresse.nomeArea FROM areaprojeto INNER JOIN 
    areainteresse ON areaprojeto.idArea = areainteresse.idArea";
    $sqlprep = $conexao->prepare($sql);
    $sqlprep->execute();

    $resultadoSql = $sqlprep->get_result();
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    $vetorAreasProj = array();
    while($vetorUmRegistro != null){
        array_push($vetorAreasProj, $vetorUmRegistro);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
    }
    ?>
    <title><?php echo($titulo) ?></title>
    </head>
<body>
<br>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9  col-lg-6 col-xl-6">
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

        <?php if(isset($_SESSION["tipoLogin"]) && $_SESSION["tipoLogin"]=="Professor"){ ?>
            <h4><strong>Projetos dos Alunos</strong></h4>
            <div class="table-responsive">
                <table class="Tabela table table-striped table-hover display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nome do projeto</th>
                            <th>Aluno Resposável</th>
                            <th>Área(s)</th>
                            <th>Vagas</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($vetorTodosProj as $Vet) {?>
                            <?php if($Vet['idAluno'] != NULL){ ?>
                                <?php foreach($vetorAlunos as $vA){ ?>
                                    <?php if($vA['idAluno'] == $Vet['idAluno']){ ?>
                                        <tr>
                                            <td><?php echo($Vet["tituloProj"]); ?></td>
                                            <td><?php echo($vA["nomeAluno"]); ?></td>
                                            <td>
                                                <ul class="list-group">
                                                    <?php foreach($vetorAreasProj as $vetArea){
                                                        if($vetArea["idProjeto"]==$Vet["idProj"]){ ?>
                                                            <li><?php echo($vetArea["nomeArea"]);?></li>
                                                    <?php }
                                                    } ?>
                                                </ul>
                                            </td>
                                            <td><?php echo($Vet["vagasRestantes"]); ?></td>
                                            <td>
                                                <form action="projeto.php" method="post">
                                                    <input type="hidden" value="<?php echo($Vet['idProj']) ?>" name="id">
                                                    <button type="submit" class="btn btn-danger">Visualizar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php break; ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <br><br>

            <?php } ?>

            <h4><strong>Todos os Projetos</strong></h4>
            <div class="table-responsive">
                <table class="Tabela table table-striped table-hover display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nome do projeto</th>
                            <th>Resposável</th>
                            <th>Área(s)</th>
                            <th>Vagas</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach($vetorTodosProj as $Vet) {?>
                            <tr>
                                <td><?php echo($Vet["tituloProj"]); ?></td>
                                <td>
                                    <?php if($Vet['idAluno'] != NULL){ ?>
                                        <?php foreach($vetorAlunos as $vA){ ?>
                                            <?php if($vA['idAluno'] == $Vet['idAluno']){ ?>
                                                Aluno: <?php echo($vA['nomeAluno']); ?>
                                            <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php foreach($vetorProfessores as $vP){ ?>
                                            <?php if($vP['idProf'] == $Vet['idProf']){ ?>
                                                Professor: <?php echo($vP['nomeProf']); ?>
                                            <?php break; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <ul class="list-group">
                                        <?php foreach($vetorAreasProj as $vetArea){
                                            if($vetArea["idProjeto"]==$Vet["idProj"]){ ?>
                                                <li><?php echo($vetArea["nomeArea"]);?></li>
                                        <?php }
                                        } ?>

                                    </ul>
                                </td>
                                <td><?php echo($Vet["vagasRestantes"]); ?></td>
                                <td>
                                    <form action="projeto.php" method="post">
                                        <input type="hidden" value="<?php echo($Vet['idProj']) ?>" name="id">
                                        <button type="submit" class="btn btn-danger">Visualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
<br>
<?php include_once('navbar/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>  
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<script>
$(document).ready(function(){
    $('.Tabela').DataTable({
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior"
            }
        }
    });
});
</script>
</script>


