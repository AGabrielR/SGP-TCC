-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Jun-2020 às 22:27
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sgprojetos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `idAluno` int(11) NOT NULL,
  `idLogin` int(11) NOT NULL,
  `nomeAluno` varchar(255) DEFAULT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL,
  `cpfAluno` varchar(14) DEFAULT NULL,
  `raAluno` int(11) DEFAULT NULL,
  `turma` varchar(5) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`idAluno`, `idLogin`, `nomeAluno`, `idCurso`, `idCampus`, `cpfAluno`, `raAluno`, `turma`, `privilegios`) VALUES
(7, 5, 'Roberto Ajala da Costa Junior', 1, 1, '', 123123, '1027A', 0),
(8, 7, 'Roberto', 1, 1, '', 123, '1027A', 0),
(35, 38, 'Antonio Gabriel', 1, 1, '041.591.959-19', 1452, '1027A', 0),
(70, 66, 'Gerson P. Neto', 1, 1, '', 123123, '1027A', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunosproj`
--

CREATE TABLE `alunosproj` (
  `id` int(11) NOT NULL,
  `idProj` int(11) NOT NULL,
  `idAluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunosproj`
--

INSERT INTO `alunosproj` (`id`, `idProj`, `idAluno`) VALUES
(3, 9, 8),
(10, 8, 7),
(14, 31, 7),
(16, 32, 35),
(17, 33, 8),
(18, 33, 35),
(20, 42, 7),
(22, 47, 7),
(23, 34, 35),
(24, 52, 7),
(26, 54, 35),
(27, 55, 35),
(29, 53, 35),
(30, 56, 70);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areaatuaprofessor`
--

CREATE TABLE `areaatuaprofessor` (
  `id` int(11) NOT NULL,
  `idProf` int(11) NOT NULL,
  `idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `areaatuaprofessor`
--

INSERT INTO `areaatuaprofessor` (`id`, `idProf`, `idArea`) VALUES
(11, 4, 2),
(17, 3, 2),
(18, 3, 3),
(26, 13, 1),
(27, 13, 2),
(28, 14, 2),
(29, 15, 3),
(31, 17, 5),
(32, 18, 6),
(35, 4, 1),
(36, 4, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areaintaluno`
--

CREATE TABLE `areaintaluno` (
  `id` int(11) NOT NULL,
  `idAluno` int(11) NOT NULL,
  `idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `areaintaluno`
--

INSERT INTO `areaintaluno` (`id`, `idAluno`, `idArea`) VALUES
(5, 8, 1),
(7, 35, 1),
(8, 7, 2),
(20, 69, 1),
(21, 70, 1),
(25, 70, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areainteresse`
--

CREATE TABLE `areainteresse` (
  `idArea` int(11) NOT NULL,
  `nomeArea` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `areainteresse`
--

INSERT INTO `areainteresse` (`idArea`, `nomeArea`) VALUES
(1, 'TI'),
(2, 'web'),
(3, 'matematica'),
(4, 'Filosofia'),
(5, 'Língua Portuguesa'),
(6, 'Teoria computacional');

-- --------------------------------------------------------

--
-- Estrutura da tabela `areaprojeto`
--

CREATE TABLE `areaprojeto` (
  `id` int(11) NOT NULL,
  `idProjeto` int(11) NOT NULL,
  `idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `areaprojeto`
--

INSERT INTO `areaprojeto` (`id`, `idProjeto`, `idArea`) VALUES
(5, 9, 3),
(23, 8, 2),
(33, 31, 1),
(35, 32, 3),
(36, 33, 1),
(37, 34, 2),
(45, 8, 1),
(46, 42, 1),
(47, 43, 3),
(51, 47, 2),
(52, 48, 4),
(53, 48, 6),
(54, 49, 3),
(55, 50, 1),
(56, 51, 2),
(57, 31, 2),
(58, 52, 2),
(59, 53, 1),
(60, 53, 5),
(61, 54, 1),
(62, 55, 1),
(63, 56, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `campus`
--

CREATE TABLE `campus` (
  `idCampus` int(11) NOT NULL,
  `nomeCampus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `campus`
--

INSERT INTO `campus` (`idCampus`, `nomeCampus`) VALUES
(1, 'Coxim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `idCurso` int(11) NOT NULL,
  `nomeCurso` varchar(255) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`idCurso`, `nomeCurso`, `idCampus`) VALUES
(1, 'Técnico em informática', 1),
(2, 'Tecnico em Alimentos', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `horariolivreprofessor`
--

CREATE TABLE `horariolivreprofessor` (
  `id` int(11) NOT NULL,
  `idProf` int(11) NOT NULL,
  `diaSemana` varchar(3) NOT NULL,
  `horarioIni` varchar(5) NOT NULL,
  `horarioFin` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `horariolivreprofessor`
--

INSERT INTO `horariolivreprofessor` (`id`, `idProf`, `diaSemana`, `horarioIni`, `horarioFin`) VALUES
(68, 3, 'SEG', '11:11', '12:11'),
(69, 3, 'TER', '21:00', '22:00'),
(71, 13, 'SEG', '07:00', '10:55'),
(72, 15, 'QUA', '15:20', '16:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `tipo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `email`, `senha`, `tipo`) VALUES
(5, 'as@4', '63ee451939ed580ef3c4b6f0109d1fd0', 1),
(7, 'ba@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 1),
(9, 'jr.ayala2001@gmail.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(31, 'beto@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(38, 'tonin@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 1),
(57, 'palminha@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(59, 'hugo@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(60, 'r@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(62, 'florinha@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(65, 'robertojrajala@gmail.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2),
(66, 'gersin@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `idProf` int(11) NOT NULL,
  `idLogin` int(11) NOT NULL,
  `nomeProf` varchar(255) DEFAULT NULL,
  `cpfProf` varchar(14) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL,
  `siap` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`idProf`, `idLogin`, `nomeProf`, `cpfProf`, `idCampus`, `siap`, `telefone`, `privilegios`) VALUES
(3, 9, 'Roberto Ajala da Costa Junior', '064.972.751-77', 1, '1234', '(99) 99999-9999', 1),
(4, 31, 'Antonio', '', 1, '1234', '', 0),
(13, 57, 'palma', '', 1, '16516', '', 0),
(14, 59, 'Hugo', '', 1, '959595', '', 0),
(15, 60, 'Renan', '', 1, '4498', '', 0),
(17, 62, 'Flora', '', 1, '123123', '', 0),
(18, 65, 'Roberto Junior', '213.42', 1, '12341243', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `idProj` int(11) NOT NULL,
  `idProf` int(11) DEFAULT NULL,
  `idAluno` int(11) DEFAULT NULL,
  `tituloProj` varchar(255) NOT NULL,
  `dataIniProj` date DEFAULT NULL,
  `dataFinProj` date DEFAULT NULL,
  `resumoProj` mediumtext NOT NULL,
  `fotoProj` varchar(200) DEFAULT NULL,
  `vagasProj` int(11) NOT NULL,
  `inscritosProj` int(11) NOT NULL,
  `vagasRestantes` int(11) NOT NULL,
  `orienta` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`idProj`, `idProf`, `idAluno`, `tituloProj`, `dataIniProj`, `dataFinProj`, `resumoProj`, `fotoProj`, `vagasProj`, `inscritosProj`, `vagasRestantes`, `orienta`) VALUES
(8, 3, NULL, 'DESENVOLVIMENTO DE UMA APLICAÇÃO WEB PARA GERENCIAMENTO E DIVULGAÇÃO DE PROJETOS ACADÊMICOS:', '2019-02-20', '0000-00-00', 'Criar um sistema web que facilite e dinamize as interações entre alunos e professores quanto a iniciação ou criação de projetos acadêmicos', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(9, 3, NULL, 'Desenvolvimento de um protótipo para queima de ervas daninhas', '2020-02-10', '2020-03-09', 'um anime muito bom... pena que acabou...', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(31, 0, 7, 'desenvolvimento de calculadora', '0000-00-00', '0000-00-00', 'desenvolver uma calculadora que faça contas', 'WallpaperIFMS.png', 1, 1, 0, 0),
(32, 3, 7, 'ZONEAMENTO AGROCLIMÁTICO DA BANANEIRA (Musa spp.) PARA A REGIÃO CENTRO-OESTE DO BRASIL', '2020-11-11', '0000-00-00', 'inserindo pelo aluno com prof orientador', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(33, 13, NULL, 'Estudo da implantação de uma AR para o IFMS', '2020-04-24', '0000-00-00', 'estudar a implantação de uma AR para o IFMS\r\n', 'WallpaperIFMS.png', 2, 2, 0, NULL),
(34, 13, NULL, 'Plataforma de controle de MIT com carga variável destinado a ensaios de Engenharia.', '2020-11-11', '0000-00-00', 'earbaerbaerbae', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(42, 13, 7, 'Desenvolvimento de site para consulta de notas', '2020-11-11', '0000-00-00', 'desenvolver sistema para consultar notas', 'WallpaperIFMS.png', 2, 1, 1, NULL),
(43, 3, NULL, 'Estudo sobre arraias no rio taquari', '2020-02-11', '0000-00-00', 'pesquisar sobre as arraias do rio', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(47, 3, 7, 'desenvolvimento de armadilha para inseto', '0000-00-00', '0000-00-00', 'fgsgsrgf srg ', 'WallpaperIFMS.png', 1, 1, 0, 0),
(48, 3, NULL, 'Tecnologias aplicadas ao monitoramento da qualidade físico-química do solo', '2020-10-15', '0000-00-00', 'desenvolver um sistema para controlar os alunos', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(49, 3, NULL, 'MAPEAMENTO DAS ÁREAS COM APTIDÃO AGROCLIMÁTICO DA CULTURA DO CAFÉ PARA O BRASIL', '2020-11-11', '0000-00-00', '1111', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(50, 13, NULL, 'Controle aplicado à dosimetria do oxigênio em ventiladores pulmonares de baixo custo.', '2020-11-11', '0000-00-00', 'irvvwopierjg', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(51, 13, NULL, 'Desenvolvimento de um instrumentista autômatotradutor e interpretador de partituras musicais', '2020-03-12', '0000-00-00', '121212', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(52, NULL, 7, '\"O que é ?\" Jogo para auxilar o ensino de Libras e SignWriting', NULL, NULL, 'desenvolvimento de jogo para auxiliar no ensino de Libras e SignWriting', '6dcb105b40287dd2e784f6002a106a0f.jpg', 1, 1, 0, 0),
(53, 0, 35, 'SISTEMA DE CORREÇÃO DE REDAÇÕES - SISRED', '0000-00-00', '0000-00-00', 'desenvolvimento de sistema para correção de redações', 'WallpaperIFMS.png', 2, 1, 1, 0),
(54, 14, 35, 'Estudo sobre a usabilidade de ambientes desktop Linux', NULL, NULL, 'Estudar sobre a usabilidade de ambientes desktop Linux', 'WallpaperIFMS.png', 1, 1, 0, 0),
(55, 0, 35, 'Identificação de sinais em Libras com o uso de técnicas de aprendizagem de máquina', '2020-05-11', '0000-00-00', 'Identificação de sinais em Libras com o uso de técnicas de aprendizagem de máquina', 'WallpaperIFMS.png', 2, 2, 0, 0),
(56, 15, NULL, 'Construção de ferramenta didática para o ensino de funções para estudantes ouvintes e/ou surdos', '2020-05-13', '0000-00-00', 'Construção de ferramenta didática para o ensino de funções para estudantes ouvintes e/ou surdos', 'WallpaperIFMS.png', 2, 1, 1, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`),
  ADD KEY `aluno_ibfk_1` (`idCurso`),
  ADD KEY `aluno_ibfk_2` (`idCampus`),
  ADD KEY `idLogin` (`idLogin`);

--
-- Índices para tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idProj` (`idProj`);

--
-- Índices para tabela `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idProf` (`idProf`);

--
-- Índices para tabela `areaintaluno`
--
ALTER TABLE `areaintaluno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idArea` (`idArea`);

--
-- Índices para tabela `areainteresse`
--
ALTER TABLE `areainteresse`
  ADD PRIMARY KEY (`idArea`);

--
-- Índices para tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idProjeto` (`idProjeto`);

--
-- Índices para tabela `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`idCampus`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idCurso`),
  ADD KEY `idCampus` (`idCampus`);

--
-- Índices para tabela `horariolivreprofessor`
--
ALTER TABLE `horariolivreprofessor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProf` (`idProf`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`idProf`),
  ADD KEY `professor_ibfk_2` (`idCampus`),
  ADD KEY `idLogin` (`idLogin`);

--
-- Índices para tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`idProj`),
  ADD KEY `idProf` (`idProf`),
  ADD KEY `idAluno` (`idAluno`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `areaintaluno`
--
ALTER TABLE `areaintaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `campus`
--
ALTER TABLE `campus`
  MODIFY `idCampus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `horariolivreprofessor`
--
ALTER TABLE `horariolivreprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`),
  ADD CONSTRAINT `aluno_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`),
  ADD CONSTRAINT `aluno_ibfk_3` FOREIGN KEY (`idLogin`) REFERENCES `login` (`id`);

--
-- Limitadores para a tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  ADD CONSTRAINT `alunosproj_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `alunosproj_ibfk_2` FOREIGN KEY (`idProj`) REFERENCES `projeto` (`idProj`);

--
-- Limitadores para a tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  ADD CONSTRAINT `areaprojeto_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areainteresse` (`idArea`),
  ADD CONSTRAINT `areaprojeto_ibfk_2` FOREIGN KEY (`idProjeto`) REFERENCES `projeto` (`idProj`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `horariolivreprofessor`
--
ALTER TABLE `horariolivreprofessor`
  ADD CONSTRAINT `horariolivreprofessor_ibfk_1` FOREIGN KEY (`idProf`) REFERENCES `professor` (`idProf`);

--
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`),
  ADD CONSTRAINT `professor_ibfk_3` FOREIGN KEY (`idLogin`) REFERENCES `login` (`id`);

--
-- Limitadores para a tabela `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `projeto_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
