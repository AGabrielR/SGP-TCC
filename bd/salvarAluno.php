<?php
    require_once("conexao.php");
    require_once("../views/navbar/navbar.php");
?>

<?php 
    if(isset($_POST['idEditar'])){
        $idEditar = $_POST['idEditar'];
        $idLoginEditar = $_POST['idLoginEditar'];
    }

    if($_POST['Senha']==""){
        $senha = "1";
    } else {
        $senha = md5(md5($_POST['Senha']));
    }
    $nome = $_POST['nome'];
    $RA = intval($_POST['RA']);
    $cpf = $_POST['CPF'];
    $campus = intval($_POST['Campus']);
    $curso = intval($_POST['Curso']);
    $email = $conexao->escape_string($_POST['Email']);
    $turma = $_POST['turma'];
    $tipo = "1";
    $area = array();
    $privilegio = 0;

    for ($i=0;$i<count($_POST['area']);$i++) {
        $area[$i] = intval($_POST['area'][$i]);
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
            $_SESSION['NomeAluno'] = $nome;
            $_SESSION['RaAluno'] = $RA;
            $_SESSION['CpfAluno'] = $cpf;
            $_SESSION['CampusAluno'] = $campus;
            $_SESSION['CursoAluno'] = $curso;
            $_SESSION['TurmaAluno'] = $turma;

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
            $a = $idLogin['id']; 
            var_dump($a, $nome, $curso, $campus, $cpf, $RA, $senha, $email, $turma, $privilegio);

            $sql = "insert into aluno(idLogin, nomeAluno, idCurso, idCampus, cpfAluno, raAluno,
            turma, privilegios) values(?,?,?,?,?,?,?,?)";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("isiisisi", $a, $nome, $curso, $campus, $cpf, $RA, $turma, $privilegio);
            $sqlprep->execute();

            $sql = "select idAluno from aluno where idLogin=?";
            $sqlprep = $conexao->prepare($sql);
            $sqlprep->bind_param("i", $idLogin['id']);
            $sqlprep->execute();
            $resultadoSql = $sqlprep->get_result();
            $idAluno = mysqli_fetch_assoc($resultadoSql);

            for ($i=0;$i<count($area);$i++) {
                $sql = "insert into areaIntAluno(idAluno, idArea) values(?,?)";
                $sqlprep = $conexao->prepare($sql);
                $sqlprep->bind_param("ii", $idAluno['idAluno'], $area[$i]);
                $sqlprep->execute();
            }
            if(!isset($_SESSION["ADMIN"])){
                header("location: ../views/tela_login.php");
            } else {
                $_SESSION['idAlunoEditado'] = $idAluno['idAluno'];
                header("location: ../views/perfil.php");
            }
        }
    }else{
        $sql = "UPDATE aluno set nomeAluno='$nome', idCurso='$curso', idCampus='$campus', 
        cpfAluno='$cpf', raAluno='$RA', turma='$turma' where idAluno='$idEditar';";
        mysqli_query($conexao, $sql);   

        if($senha=="1"){
            $sql = "UPDATE login set email='$email' where id='$idLoginEditar';";
            mysqli_query($conexao, $sql);
        }else{    
            $sql = "UPDATE login set email='$email', senha='$senha' where id='$idLoginEditar';";
            mysqli_query($conexao, $sql);
        }

        $sql = "select idArea from areaintaluno where idAluno = ?";
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
                $sql = "insert into areaIntAluno(idAluno, idArea) values(?,?)";
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
                $sql = "DELETE FROM areaintaluno WHERE areaintaluno.idArea = '$idaux' and 
                areaintaluno.idAluno = '$idEditar';";
                mysqli_query($conexao, $sql);
            }
            $aux = 0;
        }
        if(!isset($_SESSION["ADMIN"])){
            header("location: ../views/perfil.php");
        } else {
            $_SESSION['idAlunoEditado'] = $idEditar;
            header("location: ../views/perfil.php");
        }
        
    }
?>