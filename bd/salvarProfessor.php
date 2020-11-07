<?php
    require_once("conexao.php");
    require_once("../views/navbar/navbar.php");
?>

<?php 
    if(isset($_POST['idEditar'])){
        $idEditar = $_POST['idEditar'];
        $idLoginEditar = $_POST['idLoginEditar'];
    }

    if($_POST['senha']==""){
        $senha = "1";
    } else {
        $senha = md5(md5($_POST['senha']));
    }

    $nome =$_POST['nome'];
    $cpf = $_POST['CPF'];
    $siap = $_POST['siap'];
    $email = $conexao->escape_string($_POST['email']);
    $campus = intval($_POST['Campus']);
    $telefone = $_POST['telefone'];
    $privilegio = 0;
    $tipo = "2";
    $area = array();
    
    if(isset($_POST['colocarH'])){
        $dia = array();
        $hora = array();
        if(isset($_POST['dia'])){
            for ($i=0;$i<count($_POST['dia']);$i++) {
                $dia[$i] = $_POST['dia'][$i];
            }
            echo("<br>");
            for ($i=0;$i<count($_POST['horario']);$i++) {
                $hora[$i] = $_POST['horario'][$i];
            }
        }
    }
    
    for ($i=0;$i<count($_POST['area']);$i++) {
        $area[$i] = intval($_POST['area'][$i]);
    }

    if(isset($_POST['checkCadastroArea'])){
        if(isset($_POST['inputNome'])){
            for ($i=0;$i<count($_POST['inputNome']);$i++) {
                $sql = "select * from areaInteresse where nomeArea=?";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("s", $_POST['inputNome'][$i]);
                $sqlprep->execute();
                $resultadoSql = $sqlprep->get_result();
                $SelNomeArea = mysqli_fetch_assoc($resultadoSql);

                if(isset($SelNomeArea)){
                    array_push($area, $SelNomeArea['idArea']);
                } else {
                    $sql = "insert into areaInteresse(nomeArea) values(?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("s", $_POST['inputNome'][$i]);
                    $sqlprep->execute();
                    
                    $sql = "select idArea from areaInteresse where nomeArea=?";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("s", $_POST['inputNome'][$i]);
                    $sqlprep->execute();
                    $resultadoSql = $sqlprep->get_result();
                    $idArea = mysqli_fetch_assoc($resultadoSql);

                    array_push($area, $idArea['idArea']);
                }
            }
        }
    }

    if(!isset($_POST['idEditar'])){
        $sql = "select * from login where email=?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("s", $email);
        $sqlprep->execute();
        $resultadoSql = $sqlprep->get_result();
        $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);

        if(isset($vetorUmRegistro)){
            $_SESSION["erroCadastro"]="E-mail já cadastrado";
            $_SESSION['NomeProf'] = $nome;
            $_SESSION['SiapProf'] = $siap;
            $_SESSION['CpfProf'] = $cpf;
            $_SESSION['CampusProf'] = $campus;

            header("location: ../views/cadastro/cadastro_aluno_professor.php");
        } else {
            $sql = "insert into login(email, senha, tipo) values(?,?,?)";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("ssi", $email, $senha, $tipo);
            $sqlprep->execute();

            $sql = "select * from login where email=?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("s", $email);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $idLogin = mysqli_fetch_assoc($resultadoSql);

            $sql = "insert into professor(idLogin, nomeProf, cpfProf, idCampus, siap, telefone, privilegios) 
            values(?,?,?,?,?,?,?)";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("ississi", $idLogin["id"], $nome, $cpf, $campus, $siap, $telefone, $privilegio);
            $sqlprep->execute();
            // header("location: ../views/tela_login.php");

            $sql = "select idProf from professor where idLogin=?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idLogin["id"]);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $idProf = mysqli_fetch_assoc($resultadoSql);

            for ($i=0;$i<count($area);$i++) {
                $sql = "insert into areaAtuaProfessor(idProf, idArea) values(?,?)";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("ii", $idProf['idProf'], $area[$i]);
                $sqlprep->execute();
            }

            if(isset($_POST["colocarH"])){
                $j = 0;
                for ($i=0;$i<count($dia);$i++) {
                    $sql = "insert into horariolivreprofessor(idProf, diaSemana, horarioIni, horarioFin) 
                    values(?,?,?,?)";
                    $sqlprep = $conexao->prepare($sql);
                    $sqlprep->bind_param("isss", $idProf['idProf'], $dia[$i], $hora[$j], $hora[$j+1]);
                    $sqlprep->execute();
                    $j = $j + 2;
                }
            }
            if(!isset($_SESSION["ADMIN"])){
                header("location: ../views/tela_login.php");
            } else {
                $_SESSION['idProfessorEditado'] = $idProf['idProf'];
                header("location: ../views/perfil.php");
            }
        }
    }else{
        $sql = "UPDATE professor set nomeProf='$nome', cpfProf='$cpf', idCampus='$campus', 
        siap='$siap', telefone='$telefone' where idProf='$idEditar';";
        mysqli_query($conexao, $sql);   
        if($senha=="1"){
            $sql = "UPDATE login set email='$email' where id='$idLoginEditar';";
            mysqli_query($conexao, $sql);
        }else{    
            $sql = "UPDATE login set email='$email', senha='$senha' where id='$idLoginEditar';";
            mysqli_query($conexao, $sql);
        }

        $sql = "select idArea from areaatuaprofessor where idProf = ?";
        $sqlprep = $conexao->prepare($sql);
        $sqlprep->bind_param("i", $idEditar);
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
                $sql = "insert into areaatuaprofessor(idProf, idArea) values(?,?)";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("ii", $idEditar, $areaa);
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
                $sql = "DELETE FROM areaatuaprofessor WHERE areaatuaprofessor.idArea = '$idaux' and 
                areaatuaprofessor.idProf = '$idEditar';";
                mysqli_query($conexao, $sql);
            }
            $aux = 0;
        }

//=======================
        $sql = "DELETE FROM horariolivreprofessor WHERE idProf = '$idEditar';";
        mysqli_query($conexao, $sql);
        if(isset($_POST['colocarH'])){
            $j = 0;
            for ($i=0;$i<count($dia);$i++) {
                $sql = "insert into horariolivreprofessor(idProf, diaSemana, horarioIni, horarioFin) 
                values(?,?,?,?)";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("isss", $idEditar, $dia[$i], $hora[$j], $hora[$j+1]);
                $sqlprep->execute();
                $j = $j + 2;
            }
        }
            
//=======================

        if(!isset($_SESSION["ADMIN"])){
            header("location: ../views/perfil.php");
        } else {
            $_SESSION['idProfessorEditado'] = $idEditar;
            header("location: ../views/perfil.php");
        }
    }
?>