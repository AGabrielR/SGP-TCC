<?php 
    require_once('../views/navbar/navbar.php');
    require_once("conexao.php");

    $email = $conexao->escape_string($_POST["email"]);
    $senha = md5(md5($_POST["senha"]));

    $sql = "select * from login where email=?";
    $sqlprep = $conexao->prepare($sql);
    $sqlprep->bind_param("s", $email);
    $sqlprep->execute();
    $resultadoSql = $sqlprep->get_result();
    $vetorUmRegistro = mysqli_fetch_assoc($resultadoSql);

    if(isset($vetorUmRegistro)){
        if($vetorUmRegistro['senha']==$senha){
            if($vetorUmRegistro["tipo"]=='1'){
                $sqlAluno = "select * from aluno where idLogin=?";
                $sqlprepAluno = $conexao->prepare($sqlAluno);
                $sqlprepAluno->bind_param("i", $vetorUmRegistro["id"]);
                $sqlprepAluno->execute();
                $resultadoSqlAluno = $sqlprepAluno->get_result();
                $vetorAluno = mysqli_fetch_assoc($resultadoSqlAluno);

                $_SESSION["nome"]=$vetorAluno["nomeAluno"];
                $_SESSION["id"]=$vetorAluno["idAluno"];
                $_SESSION["prioridade"]=$vetorAluno["privilegios"];
                $_SESSION["tipoLogin"]="Aluno";
                header("location: ../index.php");
            } else if ($vetorUmRegistro["tipo"]=='2'){
                $sqlProf = "select * from professor where idLogin=?";
                $sqlprepProf = $conexao->prepare($sqlProf);
                $sqlprepProf->bind_param("i", $vetorUmRegistro["id"]);
                $sqlprepProf->execute();
                $resultadoSqlProf = $sqlprepProf->get_result();
                $vetorProf = mysqli_fetch_assoc($resultadoSqlProf);

                $_SESSION["nome"]=$vetorProf["nomeProf"];
                $_SESSION["id"]=$vetorProf["idProf"];
                $_SESSION["prioridade"]=$vetorProf["privilegios"];
                $_SESSION["tipoLogin"]="Professor";

                if($_SESSION['prioridade']==1){
                    $_SESSION["ADMIN"]="Administrador";
                }

                $id = $vetorProf["idProf"];
                $projetoSql = "SELECT * FROM `projeto` inner join professor on projeto.idProf = 
                professor.idProf where professor.idProf = '$id' and orienta is not null";
                $resultadoProjeto = mysqli_query($conexao, $projetoSql);

                $_SESSION['POrientar'] = mysqli_num_rows($resultadoProjeto);
                header("location: ../index.php");
            }
        } else {
            $_SESSION["erroLogin"]="Senha Incorreta";
            $_SESSION["erroEmail"]=$email;
            header("location: ../views/tela_Login.php");
        }
    } else {
        $_SESSION["erroLogin"]="Email não cadastrado";
        header("location: ../views/tela_Login.php");
    }
?>