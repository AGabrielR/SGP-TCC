<?php if(!isset($_SESSION))
  session_start(); ?>
<head>
  <!-- <meta charset="utf-8"> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="http://localhost/SGProjetos/">
    <!-- Esse IMG entra o logo que o Zé vai "fazer" -->
    <img src="http://localhost/SGProjetos/views/navbar/logo.png" width="30" height="30" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="http://localhost/SGProjetos/">Todos os Projetos <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/SGProjetos/views/projetosAlunos.php">Projetos de Alunos<span class="sr-only">(current)</span></a>
      </li>
      <?php if(isset($_SESSION["nome"])){ ?>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/SGProjetos/views/meus_projetos.php">Meus Projetos
        <?php if(isset($_SESSION['POrientar']) && $_SESSION['POrientar']> 0){ ?><span class="badge bg-danger text-light"><?php echo($_SESSION['POrientar']); ?></span><?php } ?></a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION["tipoLogin"])){ ?>
        <?php if($_SESSION["tipoLogin"]=="Professor"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_projetos.php">Inserir Projeto</a>
          </li>
        <?php } else if($_SESSION["tipoLogin"]=="Aluno"){ ?>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_projetos.php">Inserir Projeto</a>
          </li>
      <?php }
        } else { 
          $_SESSION['fazerLogin'] = 'Faça Login para Cadastrar projetos';
      ?>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/SGProjetos/views/tela_login.php">Inserir Projeto</a>
        </li>
      <?php } ?>
    </ul>
    <?php if(!isset($_SESSION["nome"])){ ?>
      <a class="btn btn-outline-info my-2 my-sm-0 form-inline mt-2 mt-md-0"  href="http://localhost/SGProjetos/views/tela_login.php">Logar</a>
    <?php }else{ ?>
      <div class="text-right text-light" style="margin-right:10px">
        <a class="text-light" href="http://localhost/SGProjetos/views/perfil.php">
          <?php if(isset($_SESSION["ADMIN"])){ echo("ADMINISTRADOR: "); } echo($_SESSION["tipoLogin"]);?>: <?=$_SESSION["nome"]?>
        </a>
      </div>
      <div class="text-right">
        <a href="http://localhost/SGProjetos/bd/logoff.php" class="btn btn-outline-danger text-light">Sair</a>
      </div>
    <?php
    }
    ?>
  </div>
</nav>
</header> 

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
