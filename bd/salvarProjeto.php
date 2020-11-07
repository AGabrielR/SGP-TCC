<?php require_once("../views/navbar/navbar.php");?>
<?php require_once("conexao.php"); ?>
<body>  
<?php
//verifica se é uma edicão
    if(isset($_POST['tipo'])){
        $tipo = 'edicao';
        $idProj = $_POST['idProj'];
    }
//verifica se o input foto existe
    
    $arquivo = $_FILES["inputFoto"];
    $apagar = $_POST['apagar'];
    if($apagar == 1 || $apagar == 3){
        $novo_nome = "WallpaperIFMS.png";
        echo('não tem foto');
    } else if($apagar == 2){
        // $arquivo = $_FILES["inputFoto"];
        $extensao =  pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $novo_nome= md5(uniqid($arquivo['name'])).".".$extensao;
        $diretorio = "../imagemProjetos/";
        move_uploaded_file($_FILES["inputFoto"]['tmp_name'], $diretorio.$novo_nome);  
        echo('tem foto');    
    }
// verifica se é prof ou aluno quem está inserindo
    if ($_POST["TipoUsuario"]=="Aluno" || ($_POST["TipoUsuario"]=="Aluno" && isset($_POST['ADMIN']))){
        if(isset($_POST['Orientador'])){
            $Orientador = $_POST['Orientador'];
        } else {
            $Orientador = "sem";
        }     
    }

    $dataIni = $_POST['dataIni'];
    $dataFinal = $_POST['dataFinal'];
    $qtdVagas = $_POST['qtdVagas'];
    $alunosInsc = array();

    if(isset($_POST['alunosInsc'])){
        for ($i=0;$i<count($_POST['alunosInsc']);$i++) {
            $alunosInsc[$i] = intval($_POST['alunosInsc'][$i]);
        }
        $qtdInsc = count($alunosInsc);
        $qtdVagasRestantes = ($qtdVagas - $qtdInsc);
    } else {
        $qtdInsc = 0;
        $qtdVagasRestantes = $qtdVagas;
    }

    $resumo = $_POST["resumo"];
    $titulo = $_POST['titulo'];
    $area = array();
    for ($i=0;$i<count($_POST['area']);$i++) {
        $area[$i] = intval($_POST['area'][$i]);
    }


// verifica se é edicao com ou sem imagem
    if(isset($tipo)){
        if($_SESSION['tipoLogin']=="Professor"){
            if($apagar == 1){
                $sql = "UPDATE projeto SET tituloProj='$titulo', dataIniProj='$dataIni', dataFinProj='$dataFinal', 
                resumoProj='$resumo', vagasProj='$qtdVagas', inscritosProj='$qtdInsc', 
                vagasRestantes='$qtdVagasRestantes' WHERE idProj='$idProj';";
            } else {
                $sql = "SELECT fotoProj FROM projeto WHERE projeto.idProj = ?";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("i", $idProj);
                $sqlprep->execute();
                $resultadoSql = $sqlprep->get_result();
                $imgApagar = mysqli_fetch_assoc($resultadoSql);
                echo($imgApagar['fotoProj']);
                if($imgApagar['fotoProj'] != "WallpaperIFMS.png"){
                    $deletar = unlink('../imagemProjetos/'.$imgApagar['fotoProj']);
                }

                $sql = "UPDATE projeto SET tituloProj='$titulo', dataIniProj='$dataIni', dataFinProj='$dataFinal', 
                resumoProj='$resumo', fotoProj='$novo_nome', vagasProj='$qtdVagas', inscritosProj='$qtdInsc', 
                vagasRestantes='$qtdVagasRestantes' WHERE idProj='$idProj';";
                echo("fotoalterada");
            }

            mysqli_query($conexao, $sql);
            
            $sql = "SELECT idArea FROM areaprojeto WHERE idProjeto = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idProj);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $areaSalva = array();
            while($vetorUmRegistro != null){
                array_push($areaSalva, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }     

            $aux = 0;
            $idaux = 0;
            foreach($area as $areaa){
                foreach ($areaSalva as $areaS) {
                    if($areaa == $areaS['idArea']){
                        $aux = 1;
                        break;
                    }
                }
                if($aux == 0){
                    $sql = "INSERT INTO areaprojeto(idProjeto, idArea) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProj, $areaa);
                    $sqlprep->execute();
                }
                $aux = 0;
            }

            $aux = 0;
            foreach($areaSalva as $areaS){
                foreach ($area as $areaa) {
                    if($areaa == $areaS['idArea']){
                        $aux = 1;
                        break;
                        $idaux = $areaS['idArea'];
                    }
                }

                
                if($aux == 0){
                    $idaux = $areaS['idArea'];
                    $sql = "DELETE FROM areaprojeto WHERE areaprojeto.idArea = '$idaux' and 
                    areaprojeto.idProjeto = '$idProj';";
                    mysqli_query($conexao, $sql);
                }
                $aux = 0;
            }

            $sql = "SELECT idAluno FROM alunosproj WHERE idProj = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idProj);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $alunosSalvo = array();
            while($vetorUmRegistro != null){
                array_push($alunosSalvo, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }     

            $aux = 0;
            $idaux = 0;
            foreach($alunosInsc as $Aluno){
                foreach ($alunosSalvo as $AlunoS) {
                    if($Aluno == $AlunoS['idAluno']){
                        $aux = 1;
                        break;
                    }
                }
                if($aux == 0){
                    $sql = "INSERT INTO alunosproj(idProj, idAluno) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProj, $Aluno);
                    $sqlprep->execute();
                }
                $aux = 0;
            }

            $aux = 0;
            foreach($alunosSalvo as $AlunoS){
                foreach ($alunosInsc as $Aluno) {
                    if($Aluno == $AlunoS['idAluno']){
                        $aux = 1;
                        break;
                        $idaux = $AlunoS['idAluno'];
                    }
                }

                
                if($aux == 0){
                    $idaux = $AlunoS['idAluno'];
                    $sql = "DELETE FROM alunosproj WHERE alunosproj.idAluno = '$idaux' AND 
                    alunosproj.idProj = '$idProj';";
                    mysqli_query($conexao, $sql);
                }
                $aux = 0;
            }
            $_SESSION['tipoSalvamento']="Professor";

        //SE FOR ALUNO
        } else {
            if($apagar == 1){
                $sql = "UPDATE projeto SET tituloProj='$titulo', dataIniProj='$dataIni', dataFinProj='$dataFinal', 
                resumoProj='$resumo', vagasProj='$qtdVagas', inscritosProj='$qtdInsc', 
                vagasRestantes='$qtdVagasRestantes' WHERE idProj='$idProj';";
            } else {
                $sql = "SELECT fotoProj FROM projeto WHERE projeto.idProj = ?";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("i", $idProj);
                $sqlprep->execute();
                $resultadoSql = $sqlprep->get_result();
                $imgApagar = mysqli_fetch_assoc($resultadoSql);
                echo($imgApagar['fotoProj']);
                if($imgApagar['fotoProj'] != "WallpaperIFMS.png"){
                    $deletar = unlink('../imagemProjetos/'.$imgApagar['fotoProj']);
                }

                $sql = "UPDATE projeto SET tituloProj='$titulo', dataIniProj='$dataIni', dataFinProj='$dataFinal', 
                resumoProj='$resumo', fotoProj='$novo_nome', vagasProj='$qtdVagas', inscritosProj='$qtdInsc', 
                vagasRestantes='$qtdVagasRestantes' WHERE idProj='$idProj';";
                echo("fotoalterada");
            }
            mysqli_query($conexao, $sql);

            $sql = "SELECT * FROM projeto WHERE idProj=?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("s", $idProj);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorProjP = mysqli_fetch_assoc($resultadoSql);
            if ($Orientador!=$vetorProjP['idProf']) {
                $sql = "UPDATE projeto SET idProf='$Orientador', orienta='$orienta' WHERE idProj='$idProj'";
                mysqli_query($conexao, $sql);
            }

            $sql = "SELECT idArea FROM areaprojeto WHERE idProjeto = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idProj);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $areaSalva = array();
            while($vetorUmRegistro != null){
                array_push($areaSalva, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }     

            $aux = 0;
            $idaux = 0;
            foreach($area as $areaa){
                foreach ($areaSalva as $areaS) {
                    if($areaa == $areaS['idArea']){
                        $aux = 1;
                        break;
                    }
                }
                if($aux == 0){
                    $sql = "INSERT INTO areaprojeto(idProjeto, idArea) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProj, $areaa);
                    $sqlprep->execute();
                }
                $aux = 0;
            }

            $aux = 0;
            foreach($areaSalva as $areaS){
                foreach ($area as $areaa) {
                    if($areaa == $areaS['idArea']){
                        $aux = 1;
                        break;
                        $idaux = $areaS['idArea'];
                    }
                }

                
                if($aux == 0){
                    $idaux = $areaS['idArea'];
                    $sql = "DELETE FROM areaprojeto WHERE areaprojeto.idArea = '$idaux' AND 
                    areaprojeto.idProjeto = '$idProj';";
                    mysqli_query($conexao, $sql);
                }
                $aux = 0;
            }

            $sql = "SELECT idAluno FROM alunosproj WHERE idProj = ?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idProj);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            $alunosSalvo = array();
            while($vetorUmRegistro != null){
                array_push($alunosSalvo, $vetorUmRegistro);
                $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);
            }     

            $aux = 0;
            $idaux = 0;
            foreach($alunosInsc as $Aluno){
                foreach ($alunosSalvo as $AlunoS) {
                    if($Aluno == $AlunoS['idAluno']){
                        $aux = 1;
                        break;
                    }
                }
                if($aux == 0){
                    $sql = "INSERT INTO alunosproj(idProj, idAluno) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProj, $Aluno);
                    $sqlprep->execute();
                }
                $aux = 0;
            }

            $aux = 0;
            foreach($alunosSalvo as $AlunoS){
                foreach ($alunosInsc as $Aluno) {
                    if($Aluno == $AlunoS['idAluno']){
                        $aux = 1;
                        break;
                        $idaux = $AlunoS['idAluno'];
                    }
                }

                
                if($aux == 0 && $AlunoS['idAluno']!=$vetorProjP['idAluno']){
                    $idaux = $AlunoS['idAluno'];
                    $sql = "DELETE FROM alunosproj WHERE alunosproj.idAluno = '$idaux' AND 
                    alunosproj.idProj = '$idProj';";
                    mysqli_query($conexao, $sql);
                }
                $aux = 0;
            }  

            $_SESSION['tipoSalvamento']="Aluno";

        }
//se não for edicao
    } else {
        //verifica se existe um projeto com mesmo nome
        $sql = "SELECT * FROM projeto WHERE tituloProj=?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("s", $titulo);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);

        if(isset($vetorUmRegistro)) {
            $_SESSION["nomeProjeto"] = "Já existe um projeto com este nome: ".$titulo;
        } else {       

            if($_POST["TipoUsuario"]=="Professor"){
                if(!isset($_SESSION["ADMIN"])){
                    $sql = "INSERT INTO projeto(idProf, tituloProj, dataIniProj, dataFinProj, resumoProj, fotoProj, vagasProj,
                    inscritosProj, vagasRestantes) VALUES(?,?,?,?,?,?,?,?,?)";
                    $sqlprep=$conexao->prepare($sql);
                    $sqlprep->bind_param("isssssiii", $_SESSION["id"], $titulo, $dataIni, $dataFinal, $resumo, $novo_nome, $qtdVagas, $qtdInsc, $qtdVagasRestantes);
                    $sqlprep->execute();
                } else {
                    $sql = "INSERT INTO projeto(idProf, tituloProj, resumoProj, fotoProj, vagasProj, inscritosProj, 
                    vagasRestantes) VALUES(?,?,?,?,?,?,?)";
                    $sqlprep=$conexao->prepare($sql);
                    $sqlprep->bind_param("isssiii", $Orientador, $titulo, $resumo, $novo_nome, $qtdVagas, $qtdInsc, $qtdVagasRestantes);
                    $sqlprep->execute();
                }

                $sql = "SELECT projeto.idProj FROM projeto WHERE tituloProj=?";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("s", $titulo);
                $sqlprep->execute();
                $resultadoSql = $sqlprep->get_result();
                $idProjeto = mysqli_fetch_assoc($resultadoSql);
                $idProj = $idProjeto['idProj'];
                for ($i=0;$i<count($area);$i++) {
                    $sql = "INSERT INTO areaprojeto(idProjeto, idArea) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProjeto['idProj'], $area[$i]);
                    $sqlprep->execute();
                }   

                for ($i=0;$i<count($alunosInsc);$i++) {
                    $sql = "INSERT INTO alunosproj(idProj, idAluno) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProjeto['idProj'], $alunosInsc[$i]);
                    $sqlprep->execute();
                }
                $_SESSION['tipoSalvamento']="Professor";

            } else {
                if($Orientador=="sem"){
                    $sql = "INSERT INTO projeto(idAluno, tituloProj, resumoProj, fotoProj, vagasProj,
                    inscritosProj, vagasRestantes, orienta) VALUES(?,?,?,?,?,?,?,?)";
                    $sqlprep=$conexao->prepare($sql);
                    $sqlprep->bind_param("isssiiii", $_SESSION["id"], $titulo, $resumo, $novo_nome, $qtdVagas, $qtdInsc, $qtdVagasRestantes,$orienta);
                    $sqlprep->execute();
                    
                    $sql = "SELECT projeto.idProj FROM projeto WHERE tituloProj=?";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("s", $titulo);
                    $sqlprep->execute();
                    $resultadoSql = $sqlprep->get_result();
                    $idProjeto = mysqli_fetch_assoc($resultadoSql);

                    for ($i=0;$i<count($area);$i++) {
                        $sql = "INSERT INTO areaprojeto(idProjeto, idArea) VALUES(?,?)";
                        $sqlprep = $conexao->prepare($sql);
                        $sqlprep->bind_param("ii", $idProjeto['idProj'], $area[$i]);
                        $sqlprep->execute();
                    }
                } else {

                    $sql = "INSERT INTO projeto(idProf, idAluno, tituloProj, resumoProj, fotoProj, vagasProj,
                    inscritosProj, vagasRestantes, orienta) VALUES(?,?,?,?,?,?,?,?,?)";
                    $sqlprep=$conexao->prepare($sql);
                    $sqlprep->bind_param("iisssiiii", $Orientador, $_SESSION["id"], $titulo, $resumo, $novo_nome, $qtdVagas, $qtdInsc, $qtdVagasRestantes,$orienta);
                    $sqlprep->execute();
                    
                    $sql = "SELECT projeto.idProj FROM projeto WHERE tituloProj=?";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("s", $titulo);
                    $sqlprep->execute();
                    $resultadoSql = $sqlprep->get_result();
                    $idProjeto = mysqli_fetch_assoc($resultadoSql);

                    for ($i=0;$i<count($area);$i++) {
                        $sql = "INSERT INTO areaprojeto(idProjeto, idArea) VALUES(?,?)";
                        $sqlprep = $conexao->prepare($sql);
                        $sqlprep->bind_param("ii", $idProjeto['idProj'], $area[$i]);
                        $sqlprep->execute();
                    }
                    

                }
                echo($idProjeto['idProj']);
                for ($i=0;$i<count($alunosInsc);$i++) {
                    $sql = "INSERT INTO alunosproj(idProj, idAluno) VALUES(?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("ii", $idProjeto['idProj'], $alunosInsc[$i]);
                    $sqlprep->execute();
                }
                $sql = "INSERT INTO alunosproj(idProj, idAluno) VALUES(?,?)";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("ii", $idProjeto['idProj'], $_SESSION["id"]);
                $sqlprep->execute();
                $_SESSION['tipoSalvamento']="Aluno";
            }
            
        } 
    }  

    if(isset($_SESSION['nomeProjeto'])){
        header('location: ../views/cadastro/cadastro_projetos.php');
    } else {
        $_SESSION['idProj']=$idProj;
        header('location: ../views/projeto.php');
    }
?>
