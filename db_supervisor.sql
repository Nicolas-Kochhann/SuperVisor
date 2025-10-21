-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/10/2025 às 20:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `db_supervisor` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_supervisor`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_supervisor`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `interesse`
--

CREATE TABLE `interesse` (
  `idInteresse` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_solicitacao`
--

CREATE TABLE `professor_solicitacao` (
  `fk_usuario_idUsuario` int(11) NOT NULL,
  `fk_solicitacao_idSolicitacao` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao`
--

CREATE TABLE `solicitacao` (
  `idSolicitacao` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `carga_horaria_semanal` int(11) DEFAULT NULL,
  `fk_usuario_idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `data_hora_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_desinteresse`
--

CREATE TABLE `usuario_desinteresse` (
  `fk_usuario_idUsuario` int(11) NOT NULL,
  `fk_interesse_idInteresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_interesse`
--

CREATE TABLE `usuario_interesse` (
  `fk_usuario_idUsuario` int(11) NOT NULL,
  `fk_interesse_idInteresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `interesse`
--
ALTER TABLE `interesse`
  ADD PRIMARY KEY (`idInteresse`);

--
-- Índices de tabela `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  ADD PRIMARY KEY (`fk_usuario_idUsuario`,`fk_solicitacao_idSolicitacao`),
  ADD KEY `FK_prof_solic_solicitacao` (`fk_solicitacao_idSolicitacao`);

--
-- Índices de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`idSolicitacao`),
  ADD KEY `FK_solicitacao_usuario` (`fk_usuario_idUsuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices de tabela `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  ADD PRIMARY KEY (`fk_usuario_idUsuario`,`fk_interesse_idInteresse`),
  ADD KEY `FK_usuario_desinteresse_interesse` (`fk_interesse_idInteresse`);

--
-- Índices de tabela `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  ADD PRIMARY KEY (`fk_usuario_idUsuario`,`fk_interesse_idInteresse`),
  ADD KEY `FK_usuario_interesse_interesse` (`fk_interesse_idInteresse`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `interesse`
--
ALTER TABLE `interesse`
  MODIFY `idInteresse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `idSolicitacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  ADD CONSTRAINT `FK_prof_solic_solicitacao` FOREIGN KEY (`fk_solicitacao_idSolicitacao`) REFERENCES `solicitacao` (`idSolicitacao`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_prof_solic_usuario` FOREIGN KEY (`fk_usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD CONSTRAINT `FK_solicitacao_usuario` FOREIGN KEY (`fk_usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  ADD CONSTRAINT `FK_usuario_desinteresse_interesse` FOREIGN KEY (`fk_interesse_idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_desinteresse_usuario` FOREIGN KEY (`fk_usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  ADD CONSTRAINT `FK_usuario_interesse_interesse` FOREIGN KEY (`fk_interesse_idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_interesse_usuario` FOREIGN KEY (`fk_usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
