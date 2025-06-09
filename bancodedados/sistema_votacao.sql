-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09/06/2025 às 20:53
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_votacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adm`
--

DROP TABLE IF EXISTS `adm`;
CREATE TABLE IF NOT EXISTS `adm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `adm`
--

INSERT INTO `adm` (`id`, `usuario`, `senha`) VALUES
(1, 'CASI', '$2y$10$NfaTZLXgIJF4WOGc65IlTujN0L/IVmHJU7.cN/6XT7xdOplie525e');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chapas`
--

DROP TABLE IF EXISTS `chapas`;
CREATE TABLE IF NOT EXISTS `chapas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_chapa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `presidente_nome` varchar(100) NOT NULL,
  `presidente_foto` varchar(255) NOT NULL,
  `proposta` text NOT NULL,
  `foto_chapa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL,
  `token_recuperacao` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `chapas`
--

INSERT INTO `chapas` (`id`, `nome_chapa`, `presidente_nome`, `presidente_foto`, `proposta`, `foto_chapa`, `senha`, `data_criacao`, `email`, `token_recuperacao`, `token_expira`) VALUES
(1, 'Solução', 'Vicente Neto', 'hospedagem.png', 'Mudar tudo no curso de SI\r\nFazer uma revolução', 'hospedagem.png', NULL, '2025-06-05 14:43:32', '', NULL, NULL),
(2, 'EVENA', 'Germano', 'ouvidos.jpg', 'Otima Chapa\r\nVolte em nós', 'imagem.jpg', '4231', '2025-06-05 14:43:32', '', NULL, NULL),
(3, 'EVENE', 'Germano', 'hospedagem.png', 'A melhor chapa de todas', 'OIP (1).jpeg', '$2y$10$Wb5OWwCept7fhamTIPQgpOXbOjBMbZmCtnkJCWGc7rWlLZVCZ/Tba', '2025-06-09 17:15:41', 'mgermano@alu.ufc.br', '77851fe21789db03fd52b40afb540e7c', '2025-06-09 21:32:03'),
(4, 'Lipqi', 'Livia', 'OIP (2).jpeg', 'Vamos ser do bem', 'hospedagem.png', '$2y$10$eW4s7YzoS2UyAkfLbMHChOEU4J4xQPVNL68il13z8JR1.U14A2exK', '2025-06-09 17:32:08', 'mgermano@alu.ufc.br', NULL, NULL),
(5, 'Lipqia', 'Livia', 'OIP (2).jpeg', 'Vamos vencer', 'hospedagem.png', '$2y$10$5t8EVdia9/24XcGMjhDGHukqaxMuXEfhqhTjxrhLAlU.3neuIhHEi', '2025-06-09 17:41:35', 'mgermano@alu.ufc.br', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
CREATE TABLE IF NOT EXISTS `configuracoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inicio_inscricao` datetime DEFAULT NULL,
  `fim_inscricao` datetime DEFAULT NULL,
  `inicio_votacao` datetime DEFAULT NULL,
  `fim_votacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `inicio_inscricao`, `fim_inscricao`, `inicio_votacao`, `fim_votacao`) VALUES
(1, '2025-06-09 14:15:00', '2025-06-11 14:10:00', '2025-06-17 14:10:00', '2025-06-20 18:10:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `membros`
--

DROP TABLE IF EXISTS `membros`;
CREATE TABLE IF NOT EXISTS `membros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chapa_id` int DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `diretoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chapa_id` (`chapa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `membros`
--

INSERT INTO `membros` (`id`, `chapa_id`, `nome`, `foto`, `diretoria`) VALUES
(1, 1, 'Germano', 'gato.jpg', 'Diretor Financeiro'),
(2, 2, 'Vicente', 'ouvidos.jpg', 'Vice-Presidente'),
(3, 2, 'Camila', 'gato.jpg', 'Secretário'),
(4, 3, 'Vicente', 'Imagem do WhatsApp de 2025-06-05 à(s) 10.42.03_b9a0fda8.jpg', 'Vice-Presidente'),
(5, 3, 'Livia', 'Planta-estrutura.png', 'Diretor Financeiro'),
(6, 4, 'Vicente', 'OIP (1).jpeg', 'Diretor de Eventos'),
(7, 5, 'Vicente', 'OIP (2).jpeg', 'Diretor Acadêmico');

-- --------------------------------------------------------

--
-- Estrutura para tabela `votos`
--

DROP TABLE IF EXISTS `votos`;
CREATE TABLE IF NOT EXISTS `votos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `candidato_id` int DEFAULT NULL,
  `data_voto` datetime DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `votos`
--

INSERT INTO `votos` (`id`, `matricula`, `email`, `candidato_id`, `data_voto`, `nome`) VALUES
(20, '516777', 'vneto50@alu.ufc.br', 1, '2025-06-05 14:52:05', 'VICENTE FERNANDES DUARTE NETO'),
(22, '542272', 'mgermano@alu.ufc.br', 2, '2025-06-05 17:52:55', 'Luiz Germano'),
(19, '516780', 'vneto50@alu.ufc.br', 5, '2025-06-05 00:02:00', 'VICENTE FERNANDES DUARTE NETO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
