-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/09/2025 às 13:40
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
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `data_nascimento`, `usuario`, `senha`, `data_cadastro`) VALUES
(1, 'miguel', '2014-09-25', 'elderx@gmail.com', '$2y$10$ISTfAhBSBbUFiZgHZvT/jej0OOW9DPubZMCwW3x.l8lYgfUfmmaru', '2025-09-05 16:39:30'),
(2, 'Guilherme', '2007-03-05', 'guilherme.25@gmail.com', '$2y$10$qsE9NUlGaT6Jdb1iHl.UBuMmcwJkjUkNERUZ8Ud5.gLVGrpqXF7O2', '2025-09-05 16:50:31'),
(3, 'Valentina', '2008-04-08', 'valentinasesi@gmail.com', '$2y$10$7jKfbEesXwqeRdiOT4diaOHGYUrU3fDnGZNtOWGWJLP438r.hF9s2', '2025-09-05 16:58:13'),
(8, 'gilson', '2025-09-10', 'gilson245@gmail.com', '$2y$10$L21FAZ61rYbXlIb2MGfbleDCm8I.U.nprb054xDm5Vbc/EvcANaSy', '2025-09-05 17:17:37'),
(9, 'vinny', '2025-09-17', 'vinnydaora@gmail.com', '$2y$10$LuHM2mFnYJtdLvBzxdaqduIY8rCZ3dmpPN87ltHHIrNNRV16wxIne', '2025-09-05 17:23:33');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `usuario_2` (`usuario`);

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
