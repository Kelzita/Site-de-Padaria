-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/08/2025 às 18:02
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
-- Banco de dados: `padaria_pao_genial`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `data_abertura` date DEFAULT NULL,
  `hora_abertura` time DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `razao_social` varchar(80) DEFAULT NULL,
  `cnpj_fornecedor` varchar(14) DEFAULT NULL,
  `email_fornecedor` varchar(80) DEFAULT NULL,
  `telefone_fornecedor` varchar(20) DEFAULT NULL,
  `cep_fornecedor` varchar(8) DEFAULT NULL,
  `rua_fornecedor` varchar(50) DEFAULT NULL,
  `numero_fornecedor` int(11) DEFAULT NULL,
  `bairro_fornecedor` varchar(80) DEFAULT NULL,
  `cidade_fornecedor` varchar(50) DEFAULT NULL,
  `uf_fornecedor` char(2) DEFAULT NULL,
  `responsavel` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `razao_social`, `cnpj_fornecedor`, `email_fornecedor`, `telefone_fornecedor`, `cep_fornecedor`, `rua_fornecedor`, `numero_fornecedor`, `bairro_fornecedor`, `cidade_fornecedor`, `uf_fornecedor`, `responsavel`) VALUES
(1, 'aaa', '111111', 'email@gmail.com', '(00) 00000-0000', '1111', '', 0, '', '', '', 'aaaa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcao`
--

CREATE TABLE `funcao` (
  `id_funcao` int(11) NOT NULL,
  `nome_funcao` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcao`
--

INSERT INTO `funcao` (`id_funcao`, `nome_funcao`) VALUES
(1, 'Administrador'),
(2, 'Gestor de Estoque'),
(3, 'Balconista'),
(4, 'Caixa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id_funcionario` int(11) NOT NULL,
  `id_funcao` int(11) NOT NULL,
  `nome_funcionario` varchar(80) DEFAULT NULL,
  `cpf_funcionario` varchar(11) DEFAULT NULL,
  `email_funcionario` varchar(80) DEFAULT NULL,
  `cep_funcionario` varchar(8) DEFAULT NULL,
  `rua_funcionario` varchar(50) DEFAULT NULL,
  `telefone_funcionario` varchar(20) DEFAULT NULL,
  `numero_funcionario` int(11) DEFAULT NULL,
  `bairro_funcionario` varchar(80) DEFAULT NULL,
  `cidade_funcionario` varchar(50) DEFAULT NULL,
  `uf_funcionario` char(2) DEFAULT NULL,
  `data_admissao` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `id_funcao`, `nome_funcionario`, `cpf_funcionario`, `email_funcionario`, `cep_funcionario`, `rua_funcionario`, `telefone_funcionario`, `numero_funcionario`, `bairro_funcionario`, `cidade_funcionario`, `uf_funcionario`, `data_admissao`, `salario`, `senha`) VALUES
(1, 1, 'Jamilly Rodrigues Froes', '036.621.212', 'jamillyrodriguesfroes@gmail.com', '89211-63', 'Rua Ilheus', '(92) 99278-8203', 400, 'Floresta', 'Joinville', 'SC', '2025-08-27', 11111.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_comanda`
--

CREATE TABLE `item_comanda` (
  `id_item_comanda` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `nome_produto` varchar(80) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `unmedida` char(10) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `imagem_produto` longblob DEFAULT NULL,
  `quantidade_produto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices de tabela `funcao`
--
ALTER TABLE `funcao`
  ADD PRIMARY KEY (`id_funcao`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `id_funcao` (`id_funcao`);

--
-- Índices de tabela `item_comanda`
--
ALTER TABLE `item_comanda`
  ADD PRIMARY KEY (`id_item_comanda`),
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcao`
--
ALTER TABLE `funcao`
  MODIFY `id_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `item_comanda`
--
ALTER TABLE `item_comanda`
  MODIFY `id_item_comanda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
