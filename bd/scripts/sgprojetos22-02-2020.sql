-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Fev-2020 às 01:54
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

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
  `nomeAluno` varchar(255) DEFAULT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL,
  `cpfAluno` varchar(14) DEFAULT NULL,
  `raAluno` int(11) DEFAULT NULL,
  `senhaAluno` varchar(255) DEFAULT NULL,
  `emailAluno` varchar(255) DEFAULT NULL,
  `turma` varchar(5) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`idAluno`, `nomeAluno`, `idCurso`, `idCampus`, `cpfAluno`, `raAluno`, `senhaAluno`, `emailAluno`, `turma`, `privilegios`) VALUES
(1, 'Roberto', 1, 1, '064.972.751-77', 17337, '123', 'r', '1027A', 0),
(2, 'antonio', 1, 1, '3', 233, '123', 'w', '1027A', 0),
(3, 'assd', 1, 1, '23', 23, '2323', '22', '1027A', 0);

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
(1, 3, 1),
(2, 5, 1),
(3, 5, 2),
(4, 6, 2);

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
(9, 2, 2);

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
(1, 3, 1),
(2, 3, 3);

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
(1, 5, 2),
(2, 6, 3);

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
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `idProf` int(11) NOT NULL,
  `nomeProf` varchar(255) DEFAULT NULL,
  `cpfProf` varchar(14) DEFAULT NULL,
  `senhaProf` varchar(255) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL,
  `emailProf` varchar(255) DEFAULT NULL,
  `siap` varchar(255) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`idProf`, `nomeProf`, `cpfProf`, `senhaProf`, `idCampus`, `emailProf`, `siap`, `privilegios`) VALUES
(1, 'Roberto Ajala da Costa Junior', '064.972.751-77', '123123', 1, 'bebeto@g.com', '123213', 0),
(2, 'Roberto Ajala da Costa Junior', '529.494.685-86', '123123', 1, 'jr.ayala2001@gmail.com', '123132', 0);

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
(3, 1, 'projeto', '0000-00-00', '0000-00-00', '111', '1af0d53a476910d871756020c56b2ddb.png', 3, 2, 0),
(5, 1, 'projeto dos projetos', '1111-11-11', '1111-11-11', '1111', '91b9d997dd739aad1b867ad5d35d73b4.jpg', 3, 2, 0),
(6, 1, 'projeto dos projetos 1', '1111-11-11', '1111-11-11', '111', '04f57a196f5b71ebe672d47184b13d55.jpg', 3, 1, 2);

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
  ADD KEY `aluno_ibfk_2` (`idCampus`);

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
  ADD PRIMARY KEY (`id`);

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
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`idProf`),
  ADD KEY `professor_ibfk_2` (`idCampus`);

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
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `areaintaluno`
--
ALTER TABLE `areaintaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `areaprojeto`
--
ALTER TABLE `areaprojeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`),
  ADD CONSTRAINT `aluno_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `alunosproj`
--
ALTER TABLE `alunosproj`
  ADD CONSTRAINT `alunosproj_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `alunosproj_ibfk_2` FOREIGN KEY (`idProj`) REFERENCES `projeto` (`idProj`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
