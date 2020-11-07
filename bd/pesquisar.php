<?php 
require_once("conexao.php");
require_once('../views/navbar/navbar.php');
    
if((!isset($_GET['pesquisar']) || $_GET['pesquisar']=="") && !isset($_POST['vagas'])){
	header("Location: ../index.php");
} else if(isset($_POST['vagas'])){
    $vagas = $_POST['vagas'];
    $valor_pesquisar = $_GET['pesquisar'];
} else {
	$valor_pesquisar = $_GET['pesquisar'];
} 

$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

if($conexao){
    if($valor_pesquisar!='vagas'){
        $projetoSql = "SELECT * FROM projeto WHERE tituloProj LIKE '%$valor_pesquisar%'";
        $resultadoProjeto = mysqli_query($conexao, $projetoSql);
        
        $totalProjetos = mysqli_num_rows($resultadoProjeto);
        $quantidade_por_pg = 10;
        $num_pg = ceil($totalProjetos/$quantidade_por_pg);
        $inicio = ($quantidade_por_pg*$pagina)-$quantidade_por_pg;

        $sql = "SELECT * WHERE tituloProj LIKE '%$valor_pesquisar%' LIMIT $inicio, $quantidade_por_pg";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosRegistrosProj = array();
        
        while($vetorUmRegistro != null){
            array_push($vetorTodosRegistrosProj, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        }
        $titulo = "Projetos com: \"".$valor_pesquisar."\" em seu nome";

        // $sql = "SELECT idProj, projeto.idProf, fotoProj, tituloProj, nomeProf, vagasRestantes from 
        // projeto inner join professor on projeto.idProf = professor.idProf inner join areaprojeto on 
        // areaprojeto.idProjeto=projeto.idProj inner JOIN areainteresse on areaprojeto.idArea=areainteresse.idArea 
        // WHERE areainteresse.nomeArea LIKE '%$valor_pesquisar%';";
        // $resultadoSQL= mysqli_query($conexao, $sql);
        // $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        // $vetorTodosRegistrosArea = array();
        
        // while($vetorUmRegistro != null){
        //     array_push($vetorTodosRegistrosArea, $vetorUmRegistro);
        //     $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        // }

        // if(count($vetorTodosRegistrosProj)==0 && count($vetorTodosRegistrosArea)==0){
        //     $nada="Nenhum registro encontrado";
        // }
        $pesquisa = "1";
    } else {
        $projetoSql = "SELECT * FROM projeto WHERE vagasRestantes!=0";
        $resultadoProjeto = mysqli_query($conexao, $projetoSql);

        $totalProjetos = mysqli_num_rows($resultadoProjeto);
        $quantidade_por_pg = 10;
        $num_pg = ceil($totalProjetos/$quantidade_por_pg);
        $inicio = ($quantidade_por_pg*$pagina)-$quantidade_por_pg;

        $sql = "SELECT * FROM projeto WHERE vagasRestantes!=0 LIMIT $inicio, $quantidade_por_pg";
        $resultadoSQL= mysqli_query($conexao, $sql);
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        $vetorTodosRegistrosProj = array();
        
        while($vetorUmRegistro != null){
            array_push($vetorTodosRegistrosProj, $vetorUmRegistro);
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSQL);
        } 
        $titulo = "Projetos com vaga: ";
        $pesquisa = "0";
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
<?php if(isset($nada)) { ?>
    <div class="bg-warning text-center">
        <h4 class="text-dark"><?php echo($nada) ?></h4>
    </div>
<?php } else { ?>
<br>
<?php } ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-8 col-md-9  col-lg-6 col-xl-6">
                <h1>Projetos</h1>
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
                <?php require_once("../views/navbar/menu_lateral.php") ?>
            </nav>
        </div>
        <div class="col-xl-9 col-lg-9">
            <?php if(!isset($nada) && count($vetorTodosRegistrosProj)!=0){ ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <h2><?php echo($titulo) ?></h2>
                    </div>
                    <?php foreach($vetorTodosRegistrosProj as $umRegistro): ?>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card mb-4 shadow-sm">
                                <img src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
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
                                            <form action="../views/projeto.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                            </form>
                                            <?php if((isset($_SESSION["tipoLogin"]) && $_SESSION["tipoLogin"]=="Professor") || (isset($_SESSION['ADMIN']))){ ?>
                                                <?php if($_SESSION["id"]==$umRegistro['idProf']){ ?>
                                                    <form action="../views/cadastro/cadastro_projetos.php" method="post">
                                                        <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Editar</button>
                                                    </form>
                                                <?php } ?>
                                            <?php } ?> 
                                            <?php if(isset($_SESSION['tipoLogin']) && $_SESSION['tipoLogin']!="Professor" && $umRegistro['vagasRestantes']!=0){?>
                                                <form action="../views/perfil.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$umRegistro['idProf']?>">
                                                    <input type="hidden" name="insc" value="1">
                                                    <input type="hidden" name="tipo" value="Professor">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="margin-left:5px;">Inscrever-se</button>
                                                </form>
                                            <?php } else if($umRegistro['vagasRestantes']!=0 && !isset($_SESSION['tipoLogin'])) { ?>
                                                <form action="../views/tela_login.php">
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
            <?php 
            } 
            if($pesquisa == 1) {
            ?>  
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                    <h4 ><a href="http://localhost/SGProjetos/views/tabela_projetos.php" class="text-warning">Para uma melhor pesquisa acesse a Tabela de Projetos</a></h4>
                </div>
                <br>
            <?php } ?>
            <!-- <?php if(!isset($nada) && isset($vetorTodosRegistrosArea) && count($vetorTodosRegistrosArea)!=0){ ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                        <h2>Projetos com correspondência de: "<?php echo($valor_pesquisar) ?>" em sua Área</h2>
                    </div>
                    <?php foreach($vetorTodosRegistrosArea as $umRegistro): ?>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card mb-4 shadow-sm">
                                <img src="../imagemProjetos/<?=$umRegistro["fotoProj"]?>" height="200em" focusable="false" role="img" aria-label="Placeholder: Thumbnail" style="object-fit:cover;">
                                <div class="card-body">
                                    <p class="card-text"><h6><?=$umRegistro["tituloProj"]?></h6>Prof: <?=$umRegistro["nomeProf"]?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <form action="../views/projeto.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo($umRegistro['idProj']); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                                            </form>
                                            <?php 
                                                if(isset($_SESSION["tipoLogin"]) && $_SESSION["tipoLogin"]=="Professor"){ 
                                                    if($_SESSION["id"]==$umRegistro['idProf']){ ?>
                                                        <form action="../views/cadastro/cadastro_projetos.php" method="post">
                                                            <input type="hidden" name="id" value="<?=$umRegistro['idProj']?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Editar</button>
                                                        </form>
                                                    <?php }
                                                } 
                                                if(isset($_SESSION['tipoLogin']) && $_SESSION['tipoLogin']!="Professor" && $umRegistro['vagasRestantes']!=0){?>
                                                    <form action="#">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Inscrever-se</button>
                                                    </form>
                                                <?php }else if($umRegistro['vagasRestantes']!=0 && !isset($_SESSION['tipoLogin'])) { ?>
                                                    <form action="../views/tela_login.php">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Inscrever-se</button>
                                                    </form>
                                                <?php } ?>
                                        </div>
                                        <small class="text-muted"><?=$umRegistro["vagasRestantes"];?> vaga(s)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php } ?>   -->
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
                    <a class="page-link" href="pesquisar.php?pesquisar=<?=$valor_pesquisar?>&pagina=<?=$pagina_anterior?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php }else{ ?>
                    <a class="page-link"><span aria-hidden="true">&laquo;</span></a>
                <?php }  ?>
            </li>
            <?php for($i = 1; $i < $num_pg + 1; $i++){ ?>
                <li class="page-item"><a class="page-link" href="pesquisar.php?pesquisar=<?=$valor_pesquisar?>&pagina=<?=$i?>"><?php echo $i; ?></a></li>
            <?php } ?>
            <li class="page-item">
                <?php if($pagina_posterior <= $num_pg){ ?>
                    <a class="page-link" href="pesquisar.php?pesquisar=<?=$valor_pesquisar?>&pagina=<?=$pagina_posterior?>" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php }else{ ?>
                    <a class="page-link"><span aria-hidden="true">&raquo;</span></a>
                <?php }  ?>
            </li>
        </ul>
    </nav>
</div>
<?php include_once('../views/navbar/footer.php'); ?>