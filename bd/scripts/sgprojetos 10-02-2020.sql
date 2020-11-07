-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10-Fev-2020 às 13:31
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgprojetos`
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
(0, 'Antonio Gabriel Ribeiro dos Reis', 1, 1, '046.536.841-70', 21017, 'antoniogab45', 'antonio.reis@estudante.ifms.edu.br', '1027A', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoproj`
--

CREATE TABLE `alunoproj` (
  `id` int(11) NOT NULL,
  `idAluno` int(11) NOT NULL,
  `idProj` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(3, 1, 3);

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
(2, 3, 3),
(3, 0, 1);

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
(1, 'Roberto Ajala da Costa Junior', '064.972.751-77', '123123', 1, 'jr.ayala2001@gmail.com', '123', 0),
(0, 'Antonio Reis', '990.929.160-64', 'antoniogab45', 1, 'antonio.reis@ifms.edu.br', '123456', 0);

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
  `fotoProj` varchar(200) DEFAULT 'WallpaperIFMS.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`idProj`, `idProf`, `tituloProj`, `dataIniProj`, `dataFinProj`, `resumoProj`, `fotoProj`) VALUES
(1, 1, 'Projeto dos Projetos', '2020-02-02', '2020-02-29', 'fsakhfvhfhkbashk', 'WallpaperIFMS.png'),
(2, 1, 'Projeto dos Projetos 2.0', '2222-02-22', '2222-02-23', '.', 'bcda84c9392eed96254bc5be62dd1710.png'),
(3, 0, 'Inexistente', '2020-02-10', '2021-12-15', 'afidviasdfsuihvjfjkh', '0364ced4a7bc4d3a59dbf2e6df88c3d1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`),
  ADD KEY `aluno_ibfk_1` (`idCurso`),
  ADD KEY `aluno_ibfk_2` (`idCampus`);

--
-- Indexes for table `alunoproj`
--
ALTER TABLE `alunoproj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idProj` (`idProj`);

--
-- Indexes for table `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idProf` (`idProf`);

--
-- Indexes for table `areaintaluno`
--
ALTER TABLE `areaintaluno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idArea` (`idArea`);

--
-- Indexes for table `areainteresse`
--
ALTER TABLE `areainteresse`
  ADD PRIMARY KEY (`idArea`);

--
-- Indexes for table `areaprojeto`
--
ALTER TABLE `areaprojeto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`idCampus`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idCurso`),
  ADD KEY `idCampus` (`idCampus`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD KEY `professor_ibfk_2` (`idCampus`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`idProj`),
  ADD KEY `idProf` (`idProf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areaatuaprofessor`
--
ALTER TABLE `areaatuaprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `areaintaluno`
--
ALTER TABLE `areaintaluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `areaprojeto`
--
ALTER TABLE `areaprojeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `idCampus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`),
  ADD CONSTRAINT `aluno_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `alunoproj`
--
ALTER TABLE `alunoproj`
  ADD CONSTRAINT `alunoproj_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `alunoproj_ibfk_2` FOREIGN KEY (`idProj`) REFERENCES `projeto` (`idProj`);

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
