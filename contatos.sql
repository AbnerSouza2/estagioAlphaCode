-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/02/2025 às 22:50
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
-- Banco de dados: `cadastros_alphacode`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `contatos`
--

CREATE TABLE `contatos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `profissao` varchar(100) NOT NULL,
  `whatsapp` tinyint(1) DEFAULT 0,
  `email_notificacao` tinyint(1) DEFAULT 0,
  `sms_notificacao` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contatos`
--

INSERT INTO `contatos` (`id`, `nome`, `email`, `telefone`, `celular`, `data_nascimento`, `profissao`, `whatsapp`, `email_notificacao`, `sms_notificacao`, `created_at`) VALUES
(69, 'Abner Souza', 'abnersouza26@gmail.com', '', '(19) 98134-4568', '1996-12-18', 'Desenvolvedor Full Stack', 1, 1, 1, '2025-02-20 20:10:36'),
(70, 'Maria Aparecida', 'maria3232@gmail.com', '(32) 2232-3232', '(19) 95285-8585', '1970-03-20', 'Cozinheira', 0, 1, 0, '2025-02-20 20:11:27'),
(83, 'Joao Paulo', 'joao@gmail.com', '(43) 4234-3242', '(31) 23123-2131', '2000-03-04', 'Desenvolvedor', 0, 1, 0, '2025-02-20 21:42:51'),
(85, 'Carlos Nobrega', 'carlos@gmail.com', '(42) 3324-3242', '(31) 23123-2131', '2000-03-04', 'nada', 0, 0, 0, '2025-02-20 21:46:24');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `contatos`
--
ALTER TABLE `contatos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `contatos`
--
ALTER TABLE `contatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
