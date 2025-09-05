-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/09/2025 às 14:01
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
-- Estrutura para tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dose` varchar(50) NOT NULL,
  `horario` datetime NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pendente',
  `ultima_tomada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicamentos`
--

INSERT INTO `medicamentos` (`id`, `nome`, `dose`, `horario`, `data_cadastro`, `status`, `ultima_tomada`) VALUES
(12, 'Cefalexina', '500 mg', '2025-09-03 19:08:00', '2025-09-03 14:08:12', 'Em dia', '2025-09-03 19:13:10'),
(13, 'Doxiciclina', '500 mg', '2025-09-05 11:08:00', '2025-09-03 14:08:28', 'Em dia', '2025-09-05 12:24:06'),
(14, 'Domperidona', '100 mg', '2025-09-13 18:12:00', '2025-09-03 14:08:47', 'Em dia', '2025-09-05 12:24:05'),
(15, 'Paracetamol', '750 mg', '2025-09-04 10:40:00', '2025-09-03 17:15:40', 'Em dia', '2025-09-05 12:24:03'),
(16, 'Fluoxetina', '500 mg', '2025-09-05 07:23:00', '2025-09-05 10:23:30', 'Em dia', '2025-09-05 12:23:53'),
(17, 'Cefalexina', '100 mg', '2025-09-06 09:24:00', '2025-09-05 10:24:25', 'Pendente', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
