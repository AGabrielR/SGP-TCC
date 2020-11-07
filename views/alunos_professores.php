<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    include('protege.php');
    protege(); 
    
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');
    if(($_SESSION["tipoLogin"]=="Professor" && !isset($_POST['Professor'])) || (isset($_POST['Aluno']) && isset($_SESSION['ADMIN']))){
        $titulo = "Alunos";
        //seleciona os alunos
        $sql = "SELECT aluno.idAluno, aluno.nomeAluno, curso.nomeCurso, aluno.turma, login.email 
        FROM aluno INNER JOIN curso ON curso.idCurso = aluno.idCurso INNER JOIN login ON 
        aluno.idLogin = login.id";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosAlunos = array();
        while($vetorUmRegistroAluno != null){
            array_push($vetorTodosAlunos, $vetorUmRegistroAluno);
            $vetorUmRegistroAluno = mysqli_fetch_assoc($resultadoSQL);
        }

        $sql = "SELECT areaintaluno.idAluno, areainteresse.nomeArea FROM areainteresse INNER JOIN 
        areaintaluno ON areainteresse.idArea = areaintaluno.idArea";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorAreasAlunos = array();
        while($vetorUmRegistro != null){
            array_push($vetorAreasAlunos, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }
    } else if(($_SESSION["tipoLogin"]=="Aluno" && !isset($_POST['Aluno'])) || (isset($_POST['Professor']) && isset($_SESSION['ADMIN']))) {
        //seleciona os professores
        $titulo = "Professores";
        $id=$_SESSION['id'];

        $sql = "SELECT professor.idProf, professor.nomeProf, campus.nomeCampus, login.email FROM 
        professor INNER JOIN campus ON professor.idCampus = campus.idCampus INNER JOIN login ON 
        professor.idLogin = login.id";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosProfs = array();
        while($vetorUmRegistro != null){
            array_push($vetorTodosProfs, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        $sql = "SELECT areaatuaprofessor.idProf, areaatuaprofessor.idArea, areainteresse.nomeArea 
        FROM areainteresse INNER JOIN areaatuaprofessor on areainteresse.idArea = 
        areaatuaprofessor.idArea";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorAreasProfessores = array();
        while($vetorUmRegistro != null){
            array_push($vetorAreasProfessores, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        $sql = "SELECT areaatuaprofessor.idProf, areaatuaprofessor.idArea, areainteresse.nomeArea 
        FROM areainteresse INNER JOIN areaatuaprofessor on areainteresse.idArea = areaatuaprofessor.idArea
        INNER JOIN areaintaluno ON areaatuaprofessor.idArea = areaintaluno.idArea INNER JOIN aluno ON 
        areaintaluno.idAluno = aluno.idAluno WHERE aluno.idAluno = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $id);
        $sqlprep->execute();
        $resultadoSQL= $sqlprep->get_result();;
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorAreasIguais = array();
        while($vetorUmRegistro != null){
            array_push($vetorAreasIguais, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }

        $vetorTodosProfsArea = array();
        foreach($vetorTodosProfs as $vP){
            foreach ($vetorAreasIguais as $vA) {
                if ($vA['idProf']==$vP['idProf']) {
                    array_push($vetorTodosProfsArea, $vP);
                break;
                }
            }
        }
    } 
    ?>
    <title><?php echo($titulo) ?></title>
    </head>
<body>
<br>
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
            <?php if($titulo == "Alunos"){ ?>
                <div class="table-responsive">
                    <table class="Tabela table table-striped table-hover display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome do Aluno</th>
                                <th>E-mail</th>
                                <th>Curso</th>
                                <th>Turma</th>
                                <th>Área Interesse</th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach($vetorTodosAlunos as $Vet) {?>
                                <tr>
                                    <td><?php echo($Vet["nomeAluno"]); ?></td>
                                    <td><?php echo($Vet["email"]); ?></td>
                                    <td><?php echo($Vet["nomeCurso"]); ?></td>
                                    <td><?php echo($Vet["turma"]); ?></td>
                                    <td>
                                        <ul class="list-group">
                                            <?php foreach($vetorAreasAlunos as $vetArea){
                                                if($vetArea["idAluno"]==$Vet["idAluno"]){ ?>
                                                    <li><?php echo($vetArea["nomeArea"]);?></li>
                                            <?php }
                                            } ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="perfil.php" method="post">
                                            <input type="hidden" value="Aluno" name="tipo">
                                            <input type="hidden" value="<?php echo($Vet['idAluno']) ?>" name="id">
                                            <button type="submit" class="btn btn-danger">Visualizar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>


            <?php } else if($titulo == "Professores"){ ?>
                <?php if(!isset($_SESSION['ADMIN'])){ ?>
                    <h1>Professores das minha(s) área(s) de interesse</h1>
                    <div class="table-responsive">
                        <table class="Tabela table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nome do Professor</th>
                                    <th>E-mail</th>
                                    <th>Campus</th>
                                    <th>Área de Atuação</th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php foreach($vetorTodosProfsArea as $Vet) {?>
                                    <tr>
                                        <td><?php echo($Vet["nomeProf"]); ?></td>
                                        <td><?php echo($Vet["email"]); ?></td>
                                        <td><?php echo($Vet["nomeCampus"]); ?></td>
                                        <td>
                                            <ul class="list-group">
                                                <?php foreach($vetorAreasIguais as $vetArea){
                                                    if($vetArea["idProf"]==$Vet["idProf"]){ ?>
                                                        <li><?php echo($vetArea["nomeArea"]);?></li>
                                                <?php }
                                                } ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <form action="perfil.php" method="post">
                                                <input type="hidden" value="Professor" name="tipo">
                                                <input type="hidden" value="<?php echo($Vet['idProf']) ?>" name="id">
                                                <button type="submit" class="btn btn-danger">Visualizar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br><br>
                    <h1>Todos os Professores</h1>
                <?php } ?>
                <div class="table-responsive">
                    <table id="" class="Tabela table table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome do Professor</th>
                                <th>E-mail</th>
                                <th>Campus</th>
                                <th>Área de Atuação</th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach($vetorTodosProfs as $Vet) {?>
                                <tr>
                                    <td><?php echo($Vet["nomeProf"]); ?></td>
                                    <td><?php echo($Vet["email"]); ?></td>
                                    <td><?php echo($Vet["nomeCampus"]); ?></td>
                                    <td>
                                        <ul class="list-group">
                                            <?php foreach($vetorAreasProfessores as $vetArea){
                                                if($vetArea["idProf"]==$Vet["idProf"]){ ?>
                                                    <li><?php echo($vetArea["nomeArea"]);?></li>
                                            <?php }
                                            } ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="perfil.php" method="post">
                                            <input type="hidden" value="Professor" name="tipo">
                                            <input type="hidden" value="<?php echo($Vet['idProf']) ?>" name="id">
                                            <button type="submit" class="btn btn-danger">Visualizar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

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

</body>
</html>