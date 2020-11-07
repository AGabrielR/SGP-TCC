-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Abr-2020 às 16:33
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
(7, 5, 'Roberto Ajala da Costa Junior', 1, 1, '', 123, '1027A', 0),
(8, 7, 'Roberto', 1, 1, '', 123, '1027A', 0),
(35, 38, 'Antonio', 1, 1, '041.591.959-19', 1452, '1027A', 0);

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
(4, 10, 7),
(5, 15, 7),
(9, 23, 8),
(10, 8, 7),
(11, 24, 8),
(12, 25, 7),
(14, 31, 7),
(16, 32, 35),
(17, 33, 8),
(18, 33, 35);

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
(29, 15, 3);

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
(8, 7, 2);

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
(3, 'matematica');

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
(6, 10, 3),
(8, 12, 2),
(9, 13, 1),
(10, 14, 3),
(11, 15, 3),
(12, 16, 2),
(13, 17, 2),
(14, 18, 3),
(15, 19, 2),
(16, 20, 1),
(17, 21, 1),
(18, 21, 2),
(19, 21, 3),
(20, 22, 1),
(23, 8, 2),
(24, 8, 3),
(25, 23, 3),
(26, 24, 2),
(27, 25, 2),
(33, 31, 1),
(35, 32, 3),
(36, 33, 1),
(37, 34, 2);

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
(64, 3, 'SEG', '11:11', '12:11'),
(65, 3, 'TER', '21:00', '22:00');

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
(60, 'r@g.com', '63ee451939ed580ef3c4b6f0109d1fd0', 2);

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
(3, 9, 'Roberto Ajala da Costa Junior', '064.972.751-77', 1, '123', '(99) 99999-9999', 0),
(4, 31, 'Antonio', '064.972.751-77', 1, '123', NULL, 0),
(13, 57, 'palma', '', 1, '165165', NULL, 0),
(14, 59, 'Hugo', '', 1, '959595', '(99) 99999-9998', 0),
(15, 60, 'Renan', '', 1, '4498', '(98) 98998-9899', 0);

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
(8, 3, NULL, 'Desenvolvimento de Sistema de Irrigação', '2020-12-12', '0000-00-00', 'Desenvolvimento de sistema para irrigação', 'WallpaperIFMS.png', 2, 1, 1, NULL),
(9, 3, NULL, 'Desenvolvimento de um protótipo para queima de ervas daninhas', '2020-02-10', '2020-03-09', 'um anime muito bom... pena que acabou...', 'WallpaperIFMS.png', 2, 1, 1, NULL),
(10, 3, NULL, 'asace', '1212-02-01', '2121-01-21', '121221', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(12, 3, NULL, 'teste', '1111-11-11', '2222-02-22', 'wedwqewqe', 'WallpaperIFMS.png', 2, 0, 2, NULL),
(13, 3, NULL, 'wacwae', '1111-11-11', '2222-02-22', 'resumo', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(14, 3, NULL, 'asdewac', '1212-12-12', '2222-12-21', 'wvvweivwi', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(15, 3, NULL, 'Vit', '2002-01-22', '2101-12-02', 'uma linda morena que me ilude demais que não me assume logo', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(16, 3, NULL, 'nanatsu', '1111-11-11', '2222-02-22', 'um belo animw/mangá', 'WallpaperIFMS.png', 3, 0, 3, NULL),
(17, 3, NULL, 'konosuba', '2222-02-22', '3333-04-02', 'não é echi, é muito bom, assista', 'WallpaperIFMS.png', 2, 0, 2, NULL),
(18, 3, NULL, 'overlord', '2211-12-12', '1133-12-12', 'é issekai', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(19, 3, NULL, 'rakudai kishi no cavalry', '2121-02-21', '1221-12-12', 'é um anime muito bom', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(20, 3, NULL, 'avatar a lenda de Aang', '0222-02-22', '2222-02-22', 'é muito bom, começa meio lento mas a ultima temp é linda', 'WallpaperIFMS.png', 3, 0, 3, NULL),
(21, 3, NULL, 'Antonio', '2002-08-26', '2098-05-01', 'é um cara bacana... meio feinho e nó cego... mas tem bom coração', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(22, 3, NULL, 'abracadabra', '2020-01-11', '0000-00-00', 'abra a cabra', 'WallpaperIFMS.png', 1, 0, 1, NULL),
(23, 3, NULL, 'wuba ', '1111-11-11', '1111-11-11', 'asoewavniwnv', 'WallpaperIFMS.png', 2, 1, 1, NULL),
(24, 3, NULL, 'erro', '1211-12-12', '2111-02-12', 'teste de erro', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(25, 3, NULL, 'teste erro', '1111-11-11', '1111-11-11', 'teste de aluno', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(31, NULL, 7, 'inserindo ed sem prof', '0000-00-00', '0000-00-00', 'teste de insercao pelo aluno sem o prof', 'WallpaperIFMS.png', 1, 1, 0, 0),
(32, 3, 7, 'teste ed com prof', '1111-11-11', '0000-00-00', 'inserindo pelo aluno com prof orientador', 'WallpaperIFMS.png', 1, 1, 0, NULL),
(33, 13, NULL, 'Estudo da implantação de uma AR para o IFMS', '2020-04-24', '0000-00-00', 'estudar a implantação de uma AR para o IFMS\r\n', 'WallpaperIFMS.png', 2, 2, 0, NULL),
(34, 13, NULL, 'teste', '1111-11-11', '0000-00-00', 'earbaerbaerbae', 'WallpaperIFMS.png', 1, 0, 1, NULL);

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
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `areaintaluno`
--
ALTER TABLE `areaintaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
