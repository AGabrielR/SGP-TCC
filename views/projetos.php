<head>
    <meta charset="utf-8">
</head>
<?php
    require_once('navbar/navbar.php');
    require_once('../bd/conexao.php');
    $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
    if($conexao){
        $projetoSql = "SELECT * FROM projeto";
        $resultadoProjeto = mysqli_query($conexao, $projetoSql);

        $totalProjetos = mysqli_num_rows($resultadoProjeto);
        $quantidade_por_pg = 10;
        $num_pg = ceil($totalProjetos/$quantidade_por_pg);
        $inicio = ($quantidade_por_pg*$pagina)-$quantidade_por_pg;
        
        $sql = "SELECT * FROM projeto LIMIT $inicio, $quantidade_por_pg";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosRegistros = array();
    
        while($vetorUmRegistro != null){
            array_push($vetorTodosRegistros, $vetorUmRegistro);
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
            <div class="col-sm-8 col-md-9  col-lg-6 col-xl-6">
                <h1>Projetos</h1>
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
                <?php foreach($vetorTodosRegistros as $umRegistro): ?>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card mb-4 shadow-sm">
                            <img  src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
                            <div class="card-body" style="padding-bottom: 0px;">
                                <?php if($umRegistro['idAluno']==NULL){ ?>
                                    <?php foreach($vetorProfessores as $vP){ ?>
                                        <?php if($vP['idProf'] == $umRegistro["idProf"]) { ?>
                                            <p class="card-text"><h6><?=$umRegistro["tituloProj"]?></h6>Professor: <?=$vP["nomeProf"]?></p>
                                        <?php break; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php foreach($vetorAlunos as $vA){ ?>
                                        <?php if($vA['idAluno'] == $umRegistro["idAluno"]) { ?>
                                            <p class="card-text"><h6><?=$umRegistro["tituloProj"]?></h6>Aluno Responsável: <?=$vA["nomeAluno"]?></p>
                                        <?php break; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="form-inline col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                        <form action="projeto.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                        </form>

                                        <?php if((isset($_SESSION["tipoLogin"]) && $_SESSION["tipoLogin"]=="Professor") || isset($_SESSION['ADMIN'])){ ?>
                                            <?php if($_SESSION["id"]==$umRegistro['idProf'] || isset($_SESSION['ADMIN'])){ ?>
                                                <form action="cadastro/cadastro_projetos.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>
                                                </form>
                                            <?php } ?>
                                        <?php } ?> 
                                            
                                        <?php if(isset($_SESSION['tipoLogin']) && $_SESSION['tipoLogin']!="Professor" && $umRegistro['vagasRestantes']!=0){ ?>
                                            <form action="perfil.php" method="post">
                                                <input type="hidden" name="id" value="<?=$umRegistro['idProf']?>">
                                                <input type="hidden" name="insc" value="1">
                                                <input type="hidden" name="tipo" value="Professor">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Inscrever-se</button>
                                            </form>
                                        <?php } else if($umRegistro['vagasRestantes']!=0 && !isset($_SESSION['tipoLogin'])) { ?>
                                            <form action="tela_login.php">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Inscrever-se</button>
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
            </div>
        </div>

    </div>
    <?php
        $pagina_anterior = $pagina - 1;
        $pagina_posterior = $pagina + 1;
    ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <?php if($pagina_anterior != 0){ ?>
                    <a class="page-link" href="projetos.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php }else{ ?>
                    <a class="page-link"><span aria-hidden="true">&laquo;</span></a>
                <?php }  ?>
            </li>
            <?php for($i = 1; $i < $num_pg + 1; $i++){ ?>
                <li class="page-item"><a class="page-link" href="projetos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item">
                <?php if($pagina_posterior <= $num_pg){ ?>
                    <a class="page-link" href="projetos.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php }else{ ?>
                    <a class="page-link"><span aria-hidden="true">&raquo;</span></a>
                <?php }  ?>
            </li>
        </ul>
    </nav>
</div>
<?php include_once('navbar/footer.php'); ?>
<script>
// $(document).ready(function() {
//     $('.multiple-select').select2();
// });

</script>
