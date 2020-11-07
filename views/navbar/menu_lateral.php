<style>
ul#listaMenu > li {
    max-height: 40px;
}

#pesquisa{
    border-bottom: 10px;
}
</style>

<div class="collapse navbar-collapse" id="menuLateral">
    <ul class="navbar-nav mr-auto flex-column nav list-groupx" id='listaMenu'>
        <li class="nav-item" id="pesquisa">
            <form class="form-inline" method="GET" action="http://localhost/SGProjetos/bd/pesquisar.php">
                <div class="input-group">
                    <input type="text" name="pesquisar" id="pesquisar" class="form-control" placeholder="Buscar projeto">
                    <div class="input-group-btn">
                        <button class="btn btn-default form-control" type="submit">
                            <i class="fa fa-search"></i>
                            <!-- <img src="http://localhost/SGProjetos/imagens/pesquisa2.png" alt="pesquisar" style="width:1em;"> -->
                        </button>
                    </div>
                </div>
            </form>
        </li>
        <li class="nav-item">
            <a href="http://localhost/SGProjetos/views/tabela_projetos.php" class="nav-link">Tabela de Projetos</a>
        </li>

        <li class="nav-item">
            <a href="http://localhost/SGProjetos/index.php" class="nav-link">Projetos</a>
        </li>
        
        <?php if(isset($_SESSION["nome"])){ ?>
        <li class="nav-item">
            <a class="nav-link" href="http://localhost/SGProjetos/views/meus_projetos.php">Meus Projetos
            <?php if(isset($_SESSION['POrientar']) && $_SESSION['POrientar']> 0){ ?><span class="badge bg-danger text-light"><?php echo($_SESSION['POrientar']); ?></span><?php } ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://localhost/SGProjetos/views/perfil.php">Meu Perfil</a>
        </li>
        <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/tela_login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_aluno_professor.php">Cadastro</a>
            </li>
        <?php } ?>
        <?php if(isset($_SESSION["ADMIN"])){ ?>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_aluno_professor.php">Cadastro</a>
            </li>
        <?php } ?>
        <?php if(isset($_SESSION["tipoLogin"])){ ?>
            <?php if($_SESSION["tipoLogin"]=="Professor"){ ?>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_projetos.php">Inserir Projeto</a>
            </li>
            <?php if(isset($_SESSION["ADMIN"])) { ?> 
                <li class="nav-item">
                    <form method="POST" action="http://localhost/SGProjetos/views/alunos_professores.php">
                        <?php if(isset($_SESSION['ADMIN'])) { ?><input type="hidden" name="Professor"><?php } ?>
                        <button type="submit" class="nav-link btn btn-link">Professores</button>
                    </form>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/alunos_professores.php">Alunos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/projetosAlunos.php">Projetos dos Alunos</a>
            </li>

            <?php } else if($_SESSION["tipoLogin"]=="Aluno") {?>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/SGProjetos/views/alunos_professores.php">Professores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/SGProjetos/views/cadastro/cadastro_projetos.php">Inserir Projeto</a>
                </li>
            <?php } ?>
        <?php 
            } else { 
            $_SESSION['fazerLogin'] = 'Faça Login para Cadastrar projetos';
        ?>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/SGProjetos/views/tela_login.php">Inserir Projeto</a>
            </li>
        <?php } ?>
            <li class="nav-item">
                <form action="http://localhost/SGProjetos/bd/pesquisar.php?pesquisar=vagas" method="POST">
                    <input type="hidden" value="vagas" name="vagas">
                    <button type="submit" class="btn btn-link nav-link">Projetos com vaga</button>
                </form>
            </li>
    </ul>
</div>