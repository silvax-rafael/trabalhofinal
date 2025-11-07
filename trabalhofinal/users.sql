-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/09/2025 às 13:36
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `controle_medicamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `data_nascimento`, `email`, `senha`) VALUES
(1, 'salafrario', '2025-09-10', 'gui@gmail.com', '$2y$10$bgxwICX91ttssO5zXF1h8uuI5gZF7Nl64lrBOQzDSoTTWA4MXQzBa'),
(2, 'salafrario', '2025-09-10', 'gui@gmail.com', '$2y$10$Ss.qpR5uOGD3Cn.jZ1WY8umbKdrgjR2hplIXYssys6EESPJBBF6EK'),
(3, 'salafrario', '2025-09-10', 'gui@gmail.com', '$2y$10$TZiGepPpn9zE7nGYUmA86Og0JYrKwKylr6pxuC5pda9bCkWkdX/ba'),
(4, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$0g1hngF72MR/vPcYBwPPteK4IWRmzogoNUKiYdgUW1gMCTPyXlmsi'),
(5, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$nnkHYLJHN7ZLwSPsSnEGT./6KtQlucR.kabCzAVVNgbUeNPjcxOSC'),
(6, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$m9bo0LFtoTYgCApdkYx.1uop6g5ie8gINJs0ITYq8taW2EBSZItHq'),
(7, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$syom/FHsZlP9BeSnYXkr8.9L83aC.xATc1c9YmsADWf5oefzLvaPS'),
(8, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$q5Bg2qnIysePTL9LIDZAOe1eAoSJYRY05vDRxjsOmsDHcp.TA747m'),
(9, 'Thiago', '2025-09-19', 'gui@gmail.com', '$2y$10$2xwC6owyCb8n4n/QHovaaucAoIec1hRXGeDjHZQRPAWhkTscoSKVe');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
