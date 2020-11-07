-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08-Jan-2020 às 00:24
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
  `idArea` int(11) DEFAULT NULL,
  `cpfAluno` varchar(14) DEFAULT NULL,
  `raAluno` int(11) DEFAULT NULL,
  `senhaAluno` varchar(255) DEFAULT NULL,
  `emailAluno` varchar(255) DEFAULT NULL,
  `turma` varchar(5) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`idAluno`, `nomeAluno`, `idCurso`, `idCampus`, `idArea`, `cpfAluno`, `raAluno`, `senhaAluno`, `emailAluno`, `turma`, `privilegios`) VALUES
(1, 'Antonio Gabriel', 1, 1, 1, '046.536.841-70', 21017, 'antoniogab45', 'gabrielreis130@gmail.com', '1027A', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `areainteresse`
--

CREATE TABLE `areainteresse` (
  `idArea` int(11) NOT NULL,
  `nomeArea` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `areainteresse`
--

INSERT INTO `areainteresse` (`idArea`, `nomeArea`) VALUES
(1, 'Tecnologia da Informação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `campus`
--

CREATE TABLE `campus` (
  `idCampus` int(11) NOT NULL,
  `nomeCampus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`idCurso`, `nomeCurso`, `idCampus`) VALUES
(1, 'Técnico em Informática', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `idProf` int(11) NOT NULL,
  `nomeProf` varchar(255) DEFAULT NULL,
  `cpfProf` varchar(14) DEFAULT NULL,
  `senhaProf` varchar(255) DEFAULT NULL,
  `idArea` int(11) DEFAULT NULL,
  `idCampus` int(11) DEFAULT NULL,
  `emailProf` varchar(255) DEFAULT NULL,
  `siap` varchar(255) DEFAULT NULL,
  `privilegios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`idProf`, `nomeProf`, `cpfProf`, `senhaProf`, `idArea`, `idCampus`, `emailProf`, `siap`, `privilegios`) VALUES
(1, 'Antonio Reis', '888.072.311-15', 'antonioreis', 1, 1, 'antonio_reis1979@hotmail.com', '123456', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `idProj` int(11) NOT NULL,
  `idAluno` int(11) DEFAULT NULL,
  `idProf` int(11) DEFAULT NULL,
  `tituloProj` varchar(255) DEFAULT NULL,
  `dataIniProj` date DEFAULT NULL,
  `dataFinProj` date DEFAULT NULL,
  `resumoProj` mediumtext,
  `fotoProj` varchar(200) DEFAULT NULL,
  `idArea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`),
  ADD UNIQUE KEY `emailAluno` (`emailAluno`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idCampus` (`idCampus`),
  ADD KEY `idArea` (`idArea`);

--
-- Indexes for table `areainteresse`
--
ALTER TABLE `areainteresse`
  ADD PRIMARY KEY (`idArea`);

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
  ADD PRIMARY KEY (`idProf`),
  ADD UNIQUE KEY `emailProf` (`emailProf`),
  ADD UNIQUE KEY `siap` (`siap`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idCampus` (`idCampus`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`idProj`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idProf` (`idProf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `areainteresse`
--
ALTER TABLE `areainteresse`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `idProf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProj` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`idCurso`),
  ADD CONSTRAINT `aluno_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`),
  ADD CONSTRAINT `aluno_ibfk_3` FOREIGN KEY (`idArea`) REFERENCES `areainteresse` (`idArea`);

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areainteresse` (`idArea`),
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`idCampus`) REFERENCES `campus` (`idCampus`);

--
-- Limitadores para a tabela `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `projeto_ibfk_1` FOREIGN KEY (`idArea`) REFERENCES `areainteresse` (`idArea`),
  ADD CONSTRAINT `projeto_ibfk_2` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `projeto_ibfk_3` FOREIGN KEY (`idProf`) REFERENCES `professor` (`idProf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
