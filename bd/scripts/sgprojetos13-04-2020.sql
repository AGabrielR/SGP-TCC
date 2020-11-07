-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2020 às 19:10
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
(7, 5, 'Roberto Ajala da Costa Junior', 1, 1, '064.972.751-77', 123, '1027A', 0),
(8, 7, 'Roberto', 1, 1, '', 123, '1027A', 0);

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
(2, 8, 8),
(3, 9, 8),
(4, 10, 7),
(5, 15, 7);

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
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(9, 2, 2),
(10, 3, 1);

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
(3, 8, 2);

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
(4, 8, 2),
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
(19, 21, 3);

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
(1, 'Técnico em informática', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `email`, `senha`, `tipo`) VALUES
(5, 'as@4', '123123', 1),
(7, 'b@g.com', '123123', 1),
(9, 'jr.ayala2001@gmail.com', '123123', 2);

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
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`idProf`, `idLogin`, `nomeProf`, `cpfProf`, `idCampus`, `siap`, `privilegios`) VALUES
(3, 9, 'Roberto Ajala da Costa Junior', '064.972.751-77', 1, '123', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `idProj` int(11) NOT NULL,
  `idProf` int(11) NOT NULL,
  `tituloProj` varchar(255) NOT NULL,
  `dataIniProj` date DEFAULT NULL,
  `dataFinProj` date DEFAULT NULL,
  `resumoProj` mediumtext NOT NULL,
  `fotoProj` varchar(200) DEFAULT NULL,
  `vagasProj` int(11) NOT NULL,
  `inscritosProj` int(11) NOT NULL,
  `vagasRestantes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`idProj`, `idProf`, `tituloProj`, `dataIniProj`, `dataFinProj`, `resumoProj`, `fotoProj`, `vagasProj`, `inscritosProj`, `vagasRestantes`) VALUES
(8, 3, 'imgteste6', '1212-12-12', '1212-02-21', '121221', 'cf5cfa949ecfa564cc884089be12b0e9.jpg', 3, 1, 2),
(9, 3, 'asasas', '2012-02-02', '2014-12-21', '12121212', '13a8ad1729aa19b1629ff1ff64be7547.jpeg', 1, 1, 0),
(10, 3, 'asace', '1212-02-01', '2121-01-21', '121221', 'd5d53401c8dd752782281c1e475f4670.jpg', 1, 1, 0),
(12, 3, 'teste', '1111-11-11', '2222-02-22', 'wedwqewqe', '249c53e1d2a3d8b548cd3bc762bc7bb7.jpg', 2, 0, 2),
(13, 3, 'wacwae', '1111-11-11', '2222-02-22', 'resumo', '944333d52d4a8b49d3c6162dd6050294.webp', 1, 0, 1),
(14, 3, 'asdewac', '1212-12-12', '2222-12-21', 'wvvweivwi', '5c7593746a6d4cd36b68a288000293b8.jpg', 1, 0, 1),
(15, 3, 'Vit', '2002-01-22', '2101-12-02', 'uma linda morena que me ilude demais que não me assume logo', '181272b85c9802ba84c5d48b57aaacf3.jpeg', 1, 1, 0),
(16, 3, 'nanatsu', '1111-11-11', '2222-02-22', 'um belo animw/mangá', '8375f880e9947307c5508f7d371098d9.jpg', 3, 0, 3),
(17, 3, 'konosuba', '2222-02-22', '3333-04-02', 'não é echi, é muito bom, assista', '25110cabcfdb5b328d8e284e715d8552.jpg', 2, 0, 2),
(18, 3, 'overlord', '2211-12-12', '1133-12-12', 'é issekai', '72a1f6ad8d7eabd75025c525a8db3758.png', 1, 0, 1),
(19, 3, 'rakudai kishi no cavalry', '2121-02-21', '1221-12-12', 'é um anime muito bom', '2177e5bb61e7409db78448ea8c9e04f3.jpg', 1, 0, 1),
(20, 3, 'avatar a lenda de Aang', '0222-02-22', '2222-02-22', 'é muito bom, começa meio lento mas a ultima temp é linda', '81839793027cd040590d30b2a9ef1536.jpg', 3, 0, 3),
(21, 3, 'Antonio', '2002-08-26', '2098-05-01', 'é um cara bacana... meio feinho e nó cego... mas tem bom coração', '6f60573973d7bb86146127e40ca0b675.jpg', 1, 0, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`),
  ADD UNIQUE KEY `cpfAluno` (`cpfAluno`),
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
  ADD KEY `idProf` (`idProf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `areaintaluno`
--
ALTER TABLE `areaintaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `campus`
--
ALTER TABLE `campus`
  MODIFY `idCampus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`),
  ADD CONSTRAINT `professor_ibfk_3` FOREIGN KEY (`idLogin`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
