-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/08/2025 às 22:06
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
(2, 'Farinhas Paulista Ltda', '12345678000101', 'vendas@farinhaspaulista.com.br', '(11) 3333-4444', '01001000', 'Rua das Farinhas', 100, 'Centro', 'São Paulo', 'SP', 'Carlos Silva'),
(3, 'Laticínios Mineiros S.A.', '23456789000112', 'contato@laticiniosmineiros.com', '(31) 5555-6666', '30120010', 'Avenida dos Laticínios', 250, 'Savassi', 'Belo Horizonte', 'MG', 'Ana Oliveira'),
(4, 'Doces Delícia Ltda', '34567890000123', 'vendas@docesdelicia.com', '(21) 7777-8888', '22010010', 'Rua dos Doces', 75, 'Copacabana', 'Rio de Janeiro', 'RJ', 'Paula Santos'),
(5, 'Carnes Premium S.A.', '45678901000134', 'compras@carnespremium.com.br', '(51) 9999-0000', '90010000', 'Avenida das Carnes', 300, 'Centro Histórico', 'Porto Alegre', 'RS', 'Roberto Mendes'),
(6, 'Hortifruti Natural Ltda', '56789012000145', 'contato@hortifrutinatural.com', '(41) 2222-3333', '80010000', 'Rua das Hortaliças', 150, 'Centro', 'Curitiba', 'PR', 'Maria Oliveira'),
(7, 'Bebidas Geladas S.A.', '67890123000156', 'vendas@bebidasgeladas.com.br', '(85) 4444-5555', '60010000', 'Avenida das Bebidas', 200, 'Meireles', 'Fortaleza', 'CE', 'João Costa'),
(8, 'Panificadora Estrela Ltda', '78901234000167', 'contato@panificadoraestrela.com', '(47) 6666-7777', '88010000', 'Rua dos Pães', 80, 'Centro', 'Florianópolis', 'SC', 'Pedro Almeida'),
(9, 'Queijos Finos S.A.', '89012345000178', 'vendas@queijosfinos.com.br', '(19) 8888-9999', '13010000', 'Avenida dos Queijos', 120, 'Cambuí', 'Campinas', 'SP', 'Fernanda Lima'),
(10, 'Chocolates Brasil Ltda', '90123456000189', 'contato@chocolatesbrasil.com', '(71) 1010-2020', '40010000', 'Rua do Cacau', 50, 'Comércio', 'Salvador', 'BA', 'Ricardo Souza'),
(11, 'Massas Italianas S.A.', '01234567000190', 'vendas@massasitalianas.com.br', '(54) 3030-4040', '95010000', 'Avenida das Massas', 180, 'Cinquentenário', 'Caxias do Sul', 'RS', 'Giovanni Rossi'),
(12, 'Frutas do Vale Ltda', '12345678000101', 'contato@frutasdovale.com', '(31) 5050-6060', '30010000', 'Rua das Frutas', 90, 'Santa Efigênia', 'Belo Horizonte', 'MG', 'Antônio Pereira'),
(13, 'Café Premium S.A.', '23456789000112', 'vendas@cafepremium.com.br', '(21) 7070-8080', '22020020', 'Avenida do Café', 60, 'Ipanema', 'Rio de Janeiro', 'RJ', 'Marcos Silva'),
(14, 'Embalagens Modernas Ltda', '34567890000123', 'contato@embalagensmodernas.com', '(11) 9090-1010', '01002000', 'Rua das Embalagens', 110, 'República', 'São Paulo', 'SP', 'Sandra Oliveira'),
(15, 'Temperos da Terra S.A.', '45678901000134', 'vendas@temperosdaterra.com.br', '(41) 2020-3030', '80020000', 'Avenida dos Temperos', 70, 'Batel', 'Curitiba', 'PR', 'José Santos'),
(16, 'Peixes Frescos Ltda', '56789012000145', 'contato@peixesfrescos.com', '(85) 4040-5050', '60020000', 'Rua dos Peixes', 40, 'Mucuripe', 'Fortaleza', 'CE', 'Carlos Ferreira'),
(17, 'Vinhos Finos S.A.', '67890123000156', 'vendas@vinhosfinos.com.br', '(54) 6060-7070', '95020000', 'Avenida dos Vinhos', 85, 'São Pelegrino', 'Caxias do Sul', 'RS', 'Paulo Costa'),
(18, 'Orgânicos Natural Ltda', '78901234000167', 'contato@organicosnatural.com', '(47) 8080-9090', '88020000', 'Rua dos Orgânicos', 95, 'Trindade', 'Florianópolis', 'SC', 'Ana Paula'),
(19, 'Congelados Rapido S.A.', '89012345000178', 'vendas@congeladosrapido.com.br', '(19) 1010-2020', '13020000', 'Avenida dos Congelados', 130, 'Taquaral', 'Campinas', 'SP', 'Roberto Alves'),
(20, 'Bolos Caseiros Ltda', '90123456000189', 'contato@boloscaseiros.com', '(71) 3030-4040', '40020000', 'Rua dos Bolos', 25, 'Pelourinho', 'Salvador', 'BA', 'Maria Santos'),
(21, 'Salgados Sabor S.A.', '01234567000190', 'vendas@salgadossabor.com.br', '(51) 5050-6060', '90020000', 'Avenida dos Salgados', 65, 'Moinhos de Vento', 'Porto Alegre', 'RS', 'Pedro Lima'),
(22, 'Sucos Naturais Ltda', '12345678000101', 'contato@sucosnaturais.com', '(31) 7070-8080', '30020000', 'Rua dos Sucos', 45, 'Lourdes', 'Belo Horizonte', 'MG', 'Fernanda Costa'),
(23, 'Pães Especiais S.A.', '23456789000112', 'vendas@paesespeciais.com.br', '(21) 9090-1010', '22030030', 'Avenida dos Pães', 85, 'Leblon', 'Rio de Janeiro', 'RJ', 'João Silva'),
(24, 'Frios Selecionados Ltda', '34567890000123', 'contato@friosselecionados.com', '(11) 2020-3030', '01003000', 'Rua dos Frios', 120, 'Bela Vista', 'São Paulo', 'SP', 'Carlos Oliveira'),
(25, 'Especiarias do Oriente S.A.', '45678901000134', 'vendas@especiariasdooriente.com.br', '(41) 4040-5050', '80030000', 'Avenida das Especiarias', 55, 'Água Verde', 'Curitiba', 'PR', 'Ana Mendes'),
(26, 'Aves Frescas Ltda', '56789012000145', 'contato@avesfrescas.com', '(85) 6060-7070', '60030000', 'Rua das Aves', 35, 'Aldeota', 'Fortaleza', 'CE', 'Paulo Souza'),
(27, 'Cereais Integrais S.A.', '67890123000156', 'vendas@cereaisintegrais.com.br', '(54) 8080-9090', '95030000', 'Avenida dos Cereais', 75, 'Exposição', 'Caxias do Sul', 'RS', 'Maria Oliveira'),
(28, 'Mel Pureza Ltda', '78901234000167', 'contato@melpureza.com', '(47) 1010-2020', '88030000', 'Rua do Mel', 30, 'Lagoa da Conceição', 'Florianópolis', 'SC', 'José Silva'),
(29, 'Massas Frescas S.A.', '89012345000178', 'vendas@massasfrescas.com.br', '(19) 3030-4040', '13030000', 'Avenida das Massas', 95, 'Bonfim', 'Campinas', 'SP', 'Antônio Costa'),
(30, 'Chás e Infusões Ltda', '90123456000189', 'contato@chaseinfusoes.com', '(71) 5050-6060', '40030000', 'Rua dos Chás', 40, 'Barra', 'Salvador', 'BA', 'Sandra Oliveira'),
(31, 'Condimentos Select S.A.', '01234567000190', 'vendas@condimentosselect.com.br', '(51) 7070-8080', '90030000', 'Avenida dos Condimentos', 60, 'Partenon', 'Porto Alegre', 'RS', 'Ricardo Lima');

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
  `senha` varchar(255) NOT NULL,
  `imagem_funcionario` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `id_funcao`, `nome_funcionario`, `cpf_funcionario`, `email_funcionario`, `cep_funcionario`, `rua_funcionario`, `telefone_funcionario`, `numero_funcionario`, `bairro_funcionario`, `cidade_funcionario`, `uf_funcionario`, `data_admissao`, `salario`, `senha`, `imagem_funcionario`) VALUES
(26, 29, 'Leonardo Costa Silva', '56789432105', 'leonardo.silva@paogenial.com', '89213600', 'Rua das Camélias', '(47) 3333-6666', 258, 'América', 'Joinville', 'SC', '2026-01-05', 3100.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(27, 30, 'Amanda Almeida Oliveira', '67890543216', 'amanda.oliveira@paogenial.com', '89213700', 'Avenida Paulo Zimmermann', '(47) 2222-7777', 369, 'Bucarein', 'Joinville', 'SC', '2026-02-10', 1900.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(28, 31, 'Bruno Santos Costa', '78901654327', 'bruno.costa@paogenial.com', '89213800', 'Rua das Hortênsias', '(47) 1111-8888', 147, 'Atiradores', 'Joinville', 'SC', '2026-03-15', 2400.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(29, 32, 'Carolina Oliveira Almeida', '89012765438', 'carolina.almeida@paogenial.com', '89213900', 'Avenida dos Imigrantes', '(47) 9999-2222', 258, 'Glória', 'Joinville', 'SC', '2026-04-20', 2100.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(30, 33, 'Eduardo Costa Santos', '90123876549', 'eduardo.santos@paogenial.com', '89214000', 'Rua das Begônias', '(47) 8888-3333', 369, 'Anita Garibaldi', 'Joinville', 'SC', '2026-05-25', 1700.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(31, 34, 'Larissa Silva Oliveira', '01234987650', 'larissa.oliveira@paogenial.com', '89214100', 'Avenida Dr. João Colin', '(47) 7777-4444', 147, 'Costa e Silva', 'Joinville', 'SC', '2026-06-30', 1500.00, '$2y$10$XcewEB1qndvf1nLAbhSAtuvIOlGfJ.4rSHkK7KvI/AQFDLtGdLVNu', NULL),
(32, 4, 'Katniss Ububu', '448.484.848', 'Katniss@gmail.com', '88888-88', 'Batata', '(47) 88888-8888', 1, 'Batata', 'Btataa', 'RJ', '2025-08-29', 500.00, '$2y$10$TxMKj5NpW5FY9L90AnZvHepAORpwrv7.zB63Kl4kEYxRmRzivBszW', NULL),
(34, 1, 'Katniss Ububu', '448.484.848', 'Katniss@gmail.com', '88888-88', 'Batata', '(47) 88888-8888', 1, 'Batata', 'Btataa', 'RJ', '2025-08-29', 500.00, '$2y$10$YIhl7gh7c7HFllLlUs1mO.T2vCZa4VDP9LSPfLezY.RfKbEHIkrcG', NULL),
(35, 1, 'Heleanor Dantas', '181.488.844', 'HeleanorD@gmail.com', '88201-05', 'Rua Aristides Machado', '(44) 44444-4444', 123, 'Areias', 'Tijucas', 'SC', '2025-08-29', 555.00, '$2y$10$6n02qZmmfEytdK4ThsKNGOYhTUOJEny4bimpoqTy5bNeUfs9BzGVW', 0xffd8ffe000104a46494600010100000100010000ffdb0084000906071313121513131315161517191a18181717171a1815171a17181717181817181a1e2820181a251e1718213121252a2b2e2e2e1a1f3338332d37282d2e2b010a0a0a0e0d0e1b10101a2d1d1f1f2b2d2d2d2d2d2d2d2d2d2d2d2d2d2b2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2b2d2d2d2d2d2d2d2d2d2d2dffc000110800e100e103012200021101031101ffc4001b00000105010100000000000000000000000500020304060107ffc40042100001020403050604040502040700000001021100032131041241055161718106132291a1f032b1c1d1425272e1142362b2f13392073482d21516435363a2c2ffc400190100030101010000000000000000000000000102030405ffc4002811000202020102050403000000000000000001021103213112220433415171326181911342b1ffda000c03010002110311003f00dc131c873471a24a38a84a10e30c5400363a614744201ad1d84621c44f090e7a0de49603ccc0048a30376ced04ca4296a53048274f281fb536a4d482c65a5bfa5d239ad4b48f48f39db3b5573d5e2595245922c4fe603e4fa421a40d5ad4b79abaa8951f1173524b924b240147d296852f0a145d67c9edfa8d63988c591c5b75006b01ad37f3dd5b1854a820e84972ab91ff006f3bf0768a194b1b312d925a586f05def42daf9c3644a091e2fc4029f902abf9477287517aa6baf4bd4d85e1989c402729b06293c18fd0fa0800830331c80ab02e788161c9e905b132fc056b616602f5b7124fd440a9e0784b572b116a8a7c87af386ff14ace97340a7f23550dd5f28016871c3a94a634667676141af588e74a09b03cfec043a4e394554d4bb68e6ae77c5fc5cca300a528dc80c91c2d4d6010dd97b65728dc94fe5269d371e223d27b31da54ce1909f1358dcf23ab6ee3d63c7e629b573e822e6cbc511301722a2a2e0bd08dfca150ecf7d94b7ac48f195ecf6d824f7730d6c14c4255e7d286a1f5d350853c213543888461cd1c300868850e11c22003844721185001c851c8e400157850d7842280ec723b9a2326101d850a1400316b00398c076afb68842cca42495218bb809715fc2efba35fda1c4f772262c5c24f28f0ec4ab323330cd9d456a3f12ca9567d1294847559e2c0c2389dab37101d4d907e10e126e7c5f99afbab14a624b0528fc5616a59cee1414d62ce0524004f40e2db9b76f6bd629e2d5995c5cd2d7b9e5ba02c8c2d88516274f5f1704e837f9c1192b71e2f11e6c0733a7210266cc0f4a936dcccd04e4e10e40c54e78900726b0e9d20b0a05e24292a716e0ed5d1cc3a448cc59af6bdaacda5be51a3d9bd959aaf114b0de6e6355b37b24135c83d47d225cd14b1332533642969ccd5ca03b35a9d6e3f7bc08da1b2f21b1b7d1aa63d7d1b218540b580e5c78406db5b1f32283f303cdcb1f7be23f93669fc479105647a56de77fb7530570134aa594bd856c587126cf1636cec35209a180852a1e1d3746a9d9834d1363309303acdb793f2d3cad1564ac820ea2c6084cc52084a521dae48a7487e2568ca4d052a6b998e807f886485765ed35d2b9922e07c62f6e22a78b5de3d23b35b48cc96972fc6cf7bf1a478c6171050acc923a594350418f46ec663428902c524f220bfda2595ca3d0818511cb5b8873c048e021186831c2a862118e4733475e100b2c2850a000842684d1d31407218a87110d5080040c761a04761019eedbcd1fc2cd06c526bc74f58f1ec22ace97f13a40d5468e780a9dd1bbff895b40a8a6424d3e2597e04253e649e9185c1afc553e1482edab9a0078c22d209252cef526a4d5922cc39b5ee4eac2066266ba95bc82fbc0d3ce2e62e6e5480cea35a5439163d05b41ea3132c974872a550ef2e430f4f480aa16cc92a9933c22ba708f52eccf67825216b72741f78a7d91ecd89290a58f19f4e11b8c325a319cedd23a210a56c649c2017afd209619004302627949894536371080d4681936402e209cf315562131c401b4363a56f48c56dcecabd523dfd63d3665a0662e582212934370525b3c3b138532d7955489a64a029637041f5a5c71f4ddabed96ce4919c062232797c2527e201d25fcfcaf1d5195ab38a71e974438697e20343f3afd1e34fd8f9a5131c8a1a7536e8e08300e44b05942c0b1e176f3f9bf082bb1e7e505643806c2fa2be613eb09f20968f5fc38a52257813b0769a26ca4e535663c08a373a41578643391c263b0d3008ec761a98718004f0a3994c2800291c30a1130c0e186187930c26181c2606edada88912cad4a6d00d547701afec77441b6f6ea64495cd5255953ad055d80a97773ba3ccf6c6d0c44f256d973021d7f1e53708457bb4e95a9dfb90d2076d8c6ae72e62cd0bd81b392001bcc0e925adcf99b01e87ce2c4b4b252033139947f482df588b068752186854cf5a13e46d12cd10fc51cae4ddabd74fbf03ca2ff63305de4e4a8d8579dc40dda128a9092017331693570c908291c0f889e34a9ac6e7b0f81c8804dcc296a25c137235f2cb574888f692524b00a591a2124fac5b5c825348c4768fb593f0cbeefba6569b883663afa7d6308c6d9d1295235f2bb6084ffa929491e67e50430ddadc22ed318e80fed1e3d37b5f8e39c9ca9c8c54950a87f03049209a972c297b413d993173669973a5897328acb94cb5949fc48a94aee375fa46dd3a31534d9eb68c74b5d52a07943488cc6c4d9a65adf338367bfef1a49abca2b183e4dd0cc440dc4181fb67b4a894bc843d1ef03c76b6428b2b324f114f3783a1b1f5a5a2af6925054b5bd291e679c92146effb9f9c6fbb5fb490ac3132d40e72100ee26efd2b184c261dd248b0763ef988df1da8ece6cb4e5a274d001bff006fde0aecf4e70529bbb04b556ce554dc00f94079a49e60bfc8c10d9690b395c82527210a60950055948e2decb45199a1ecfcf2a415215fcc4162355a4d891bc59daa32b8a18f40d938aef25857bf7f468f2cd9d20b1c44a268a6676494d1c52c7c418e8d631e89d92ac8cd56529443dda807ca192c370d221e61ad010361c0c70de1080073c28e42800271c8ec72181c2618a30e8866aa860030bff1131294f74a2a0dde254a4fe608d40de330f4dc2329b5717e16f0b9adeac483d34829dbac609ca520a584b3ab02e6848d4db95a30e56451cb6b7ad2c3a422d22da524209fc4aa00ef416f7c0c5fd863f9aec1ca5406e04a52dcbe36f381a89c72e5a0360017213625f797682585743a83501f54903df2825c151e43380c1a5584ef58121d239862a3d7281d2347b11395291ac01d8013fc3cda963342483f0b801408dc4898a07801ba0ec82cd1833aa28d660970b6a6c995392cb403b8b5472315366cda41c94330894549189c4762d0169985026653f0a9fc5c09156f768258fc2ccc42a5acca4a264b58521416580a6749f0174a9346a5e345dd987193be2fa999f4a294894012c183d228f6be7a932bc0ee775cf01ce83ac1459631576a0aa0f1fa44fa97e8790769d1889534a262b29c814909cc428ab2f85d3405944b9243a487b454ff00c46761fbb13e521489890b49294ba926d56a71d6bc63d6f686c695345509e141f6a46736c76404f2f3664c2c0b3a8a9b93d00e51b75a39de397299e77b72722637774416511a6601429e7fe60becec224c840a78926bc4eb01b6e617ba9a64dc2000ef725cbf941bd8aa796849b866e8411d1c261cb844c56d8027120bea0f2a8fa69166748ee8867f84295fd24b91cade90b69ca214ec48249601dabaf2a47105735a50aea74b58137dd4d4986261fd93311dd265fc24a54a994a245c798c879eeac7a3ec6959252116648fb98f3c3835a148284e612509ef00619939b3a407a2acedfd2c6e236980da8080159904d82d397c88252472260258723861885bc3898091af0e022311220c021758e43b2c2828026f1c31d8e18a018a8a78d9a94a492cdaee89b1d3c21049d23cc7b438998b9aa499cbf01a8ccc029b3300055814d85f70896ca4ac1bda69b9e64c22c4ea2b46a8177b79465e70a063bfcbdb41b9f269572fd49e1bc9278b40e9f2c7c26cf56d4d69f4e90932da1f809092d514aab40c01663ad8d9eadc1afa668c855400b71a0d79c330f820aa3096086abf853a9a9a9d00fbc43b616032520840a241d48d4ef3f7824ca8aad84b60ed43904808ff0052619854e186519406b8fc378dc4894e911e6fb2a6a44e960062090ae2ff006fac7a8609b288c7268df13b1f819b94c693053e919fee62f61e690c2e74119a66cf683732788af89c5161c6d11484125d44721f787ed290a58065948527453e520e8e2c62b6c8d15d2a730b6ba281e8cd0131f8dc4ca2f33bacbffc79f301c5c31f481389ed72a72d32e5824120159040b8a006fac1436d1b6426903f69cc0013178cd0ce231ddb6db424ca517a9a246f26d02dba13d2b3cf3b41382f11317a396e252129f983eb163671527c67e0d49df5cc79338e40ee8138ba096f5250e5f897af5262ccd9aa32c4b77b150fca294ea4d7836f31d2d1c89fa86b68ca49aa54086ea0ef0ff36bdef00e4495b848556a12d67624f5239de2bca9aa4d376fe1450dcd5f28b32545c2d06de229d29436d6add6171a1369ec31b23113f0e19472254456678a52ce87bc0c41a35694f2db60e7199200284cc4074909354e52c9f09d59b5eb02f64e290b43dd2b4d526ce2f4d41bb535e70fece1eee72a58f85680b0966ca5272948e0411e421921cd8b35b34b0a2a48aa09bb3b149e2921bd20bbc0cd9927c4a59672f6b0720d3efca08980967358ebc34c28009331df1d88a140019261a63a61a628453da08cc82387cab1e5fb765113d640252a3a8666480ae60117fb47a863d6c1e3cbbb593dd6e2c776f7d7ca3391a40133f121d85f79a5eea6f93c51c424050492cdbaa4effb4325ce35662a3606e396837435129854b9274b6ff383828b6bda699754d4b51ea0721a98a7b3de7621026124ad40393a9f8070199a91cc249ccad1c39de4559dba8e0f0cc43cb989283e24a8286b549043efb452426d87bb4f255266a328150e90d5b241aeb54c6bfb39b493365a483a407ed848ef8e171329412899296ea25981caa091fd47bc58e6384529285615495a5f229b30dd4bc6325da91b6374db3d1e5a9e2eca4d2943be33fb2f6825690417783b835c62b93a595e72a7c95060998836ae558e05e879b889d1b79028b4a927728807d62ce265e64c0b33f2ba262414f1b0e5f6316a8a8c632e4bb33684a2e49350cccff281388328789213d22be324e1c07af24ad43c8053454d8db325e7efa6672054216a252fbc837df5782904e2a3c053198eeee51592c3d98f20dafb5958bc40249c809091d0d6357ff10f6c832f203f13848fee5795230d8092c53c4b0eb4fac6d8a34ace1cd3b7d289716aa8e03f71f48b9b2a67f30215a9f64ea59e21c50cd30ef36e26ede5f28e62572d480002162f9ae6e2fadb818d199a65ddaf2d39c80cc1838e0f7f33e646e8ad859fdd953dd403720413e607a4523315ab9dc753f78bd80c4d1419d59680d43a41b0d54e7d210cd1f666690de13e1054b3a062aca0934097249a8f878c1fc1284d3dfb95098552d246a2a5653a90728483c091184d9c0aa664295a9272954b0ac99dc835ad41707ca3d164e2120244c47749664b785296666293e1661ba024398343262c18ab294400e730d0d3e943cc45a498091a447447151d3001c850a140017262351859e229cb8600fda73a863cefb4490bcd958a85586a2afce341b7a7afbd21c104785e8c750773b1f3e1186c663159812e082414b31772086deee22392d2a06cd494f8c860b05a9702a4574b798e3114c41cc950a6ada72022d4d4851dc9d40a8bb38fbc2c5a32a40a3019a966a0fac31d17e4a90802681e1539e4a00bb9e00ebbf8d46650a9998db3751a927e71736010b42e54cf8662c049dd3082ca1c88403c22a60e6282414d14e4beb6655c5fc4cfc5a05a1bd87365e214b9230ea979e52270992d64b0493982c247e2aac2b5672f4b6cf13800b4333d233dd94d94148973c21802a97525452de201cf53461e2148dac9451a30c8f66f8a348c094ccc2adc3943dbed1add85b6d0b218fdfac4bb4f001692e23198bc12a52b324907844dd9a1eb9227a4888f138242a3cf766f6a149004c0798b414ffce527f14c4a7996f9c030dcfd9b2d358c976b36fcbc3a32bf895f845dbe9153b43dbe9601128e7568df08e67ed1e6b88c4aa6cc2b597528d4fbb08d71e2bdb30cb992d47924c6e31739656abd80d00dc227cf477b374ad21b86c2b2988bfd2ff23e508a4d403a79b547ca37395172782a016870b0ca1be8df23f28966842f22d142a531451d2a052187024f97230fd9090453e24905bd1c71f9b07874d96944e0683c495280040a2812c93f0f2b6e261175b11ca12b197e14b578977f281c94333ea4f462c3eb05f18949529d83d0d2c59816dc5837ef15a661e89a87ca0926ca670c37901ab128a6ac2db1d4f8833669eed28173421804a43303a5e35983dba898bcb2877c18b80340cf5530378c4cac42ca40525f2860ab9238281d00eac3741bd8588caeb09254d952aab56ad994a2c180709a52a2940968d76cb50cca487083a1a1045fd735450b3eae4ae1be1077d633bb3310b65cd290caf1101f365000706c4901ed5e11a242e902258f68e131d78e130c471a147214001288a698b04407da38f0870a040d0ef8182d992ed725ea7f0d13cc55fdf18ca2cf783329ae52a24fc418313c74209d01e11a1daf88ef4909219c97dde4edcf9c65a6a2f519681de86a15a5810001c093be20d513e3a5248024e65160544867e3fa69aefde6956720a65f360775053efd043a56d252029058663e2cc2c53c0035e861f2172e6960998b092e5c8080ff00d5772d66ad21d0f5e82d9a851589841cb2d9428c0aab9523892c7801a41bd9db37301fa59f79b957578a188c582c2800a243d37135b9d1eb53a0befbb21820a979b5d781ddcbdef8894a8d2291decee08cb4ae51b2bc6382d153e6971d04175ca689d725aa2e0bc59329c08c5ecd5681c50f7803b67062354a94d14769e1b32624b479be330cd68cde3d0492f1e8789c13880b3f633e91a42544e48da3cea64b221fddd4f0f56bc1cdadb2b2ac2742a1d1e07cd94f308dea2fe65c728eb52b4704a14c9664c2fba9ebf17de2151725b7ff0088904a725b8746143cb4861a1b11466d410de6d7f28045bc0e202144d8817fc24598fd3d88931f342ca4bb1d0b336f05f4e07e4d0fd9527bc58d0ead471634d48ddaf386eda0ca0c4160013beece35d468d08b3b2f144808981da80f0f9fb1787c99eb4a8292a0a4d330a1141aa4c43832141ce85b88bd7d4430a8a42402e4bab71233283383a65b7da25ab2aeb90aff00139dd92949b90283f501f6fb44b80c4328215f0153915b160ad0d2dd1c44386da05682920b8fea602ee682a23986528ad8073a92ef62ff00688e0ad33d0654def125096015451736218b03e226843b37321a0c4b348c2a71eb2ddd90924a5399441582d5240a2430ddf48d8ecf9b9902ee2849043b3558f38a4ecce4a8bc0c70c363a4c51071a3b1c78500056618ca76a90540702ff43f4f2835b57692658651cb4a1341d0ea78461f6d76925ac2d12525c86ef35e3946878df8030fa5cb4869d6c038ac5280524356e45cb1f940b9e14f505b70367afe2a0f38b4055d8907dd627449fcc4206f516e341f8ba3c5ff001c52db175c9b2ae2c151428a413906670e4949525e8a0e5808444c32ca825790162c02439615f4bbdc44f3aa414dac01a96de77124bc5fecfcf4f79dd2c78668ca468ff84bf1a8ea9dd1328351b2e33b950024c852fe3a7f4f2dfe71bfec76db20e53f10151ffb88b3fea1fbea5b2f8cc1196b520dc58fe61707a8f57864a9a50a0a496526a0dc3fd41b36e8a9628ce1afc130c8e12dfe4f654cc0a008a82286254cdd200f65b6b266241b0550877c8bd5279b8f30758d1ad023cfdae4ef4d3473383104d961b843949889531a24a480b3f0f94ef49896461d0748b7398c4391a11465fb59b08290a29bb7d630b3f6778b381fd7d400a29fdb8f08f5f9b2828318c56dfd84505d0f949722fc411c418db1e4ad18e4c77b319fc3aa59252a0c4021ec52a177d1ade71571454ed9685e82b5660cdcbe620be2259416aad25d884b14bb9347e76f4b40c9b30332429f86b5a821aa3ac7526724a23f038812d4cb008bf10487d2c2bac56c54f757c4a219bc5763c7cbca1a52c6a3efc0c5cdad20012c80d9929a0e3efdd201568661e5652c58b80481ea07934584273800b38259b504951093bc17f33ac472d2172c68a0ec778bfa44d8735aa416a9068a1cf422d58965a564d28a90ea4a121dc667722e3c2fad7e267fa14d87212254d2078c8f0ee0096adb717e43a351370ab49770ab11917f44e5852674b04b28538b06d1c7026fc621bb452545ec0e20670e84860cd98905abe1371c3f78d3ecbc500024b806cfc78ee801865e7016944b511675325c58af28722a294a738bd2f19deaf214282ecd4ca185d053461b9b4817b899a8498740bd973d6a45812285cb5a9a3c1142df810588f5fb45a664d50e8ec26850c4795ed5c7cdc428a96b52bab0e8da70b738af9346b7be90953053d2beb1d96281f9f4bf58ec4a8c48f27bb5b8c7509636a1f4e2f13fbff10d5a78986921ece05b50db7c3d49bb746b8d431f7686ca3a5c7d21c1045adbbed03041ec72bf88c3a6737f3258699cb53ea15c015403ca0c11d818f089812af857e15036e07d58f05445b570bdccd28ab0aa78a4bb75b8e91cf8fb24e1f946d3ee8f5fec6ecdc7aa42b327c49345a778e1fd41cb1e91e9fb1369a67cb4a829dc3bef167e62c63c989825d9fdaaac3addfc0a35d7297f8870de227c461eaee5c95832f4e9f07acc4130473058a4cc4664b716d391d41d0c3d423cfa3bd32b6410d2989562180c49434221b3248218889911264800cbed2ecc85b941caaf6c5f7c0b0548fe5cf96337e64d97c4581f311beeee2a62f00958650062babdc9a3c83b41850958c80b12ecd5f7c62044bef4a5b2e614caa70492f502c4d74a3d758da7693b3aa09cc8f1006d578ca4bc60904e694b502e0870915e87e51bc656b46138a5b6478dc264395604b22a0a778bb006a6d6afac50958b5b8072ac68e18f0f56d2f0f4210bf178a5a3f5667dcce29fb440a4924af806e2778dd6ac6a63c1751b5509556481fd409f500186cd9d294ba2407be5729dfa9047511d9225a812a273580340473d08a8dd68bbb1f62a566930a544298101c0a8ab1670e2b5bc26d24349b64527c0974914b568c48df5dd42f1a9c1635250958604035486d08a35874f9d026270a2528203b0041e37abf415e7136cec3ac322a9cceda8b16a0884ec6d51b4c065090039f4726bcb7c5f9496faf581f829604b4ddca43fbf58bf24f846f8d168ca448f1d850a19278ea9fde9a44ca9a057af48aaa98cdbf96bc6392a5ea6a7dfac7698969331f4f7c61c016df0c4930f07e7e5001c60f5a1b38d3d9894288d21837fbfda1e951b6bbfdf3800ead95efe506712beff000c999ffa927c2b7b949d4fcdff0054065d6bbe2fec3c5649802aa95f815d6c4f234e4a319658eba9728d71bdd3e183ca63adefd22c6370bddcc522b4b72363f2f28ae0d2344d3568cda69d3343d94db8652932d47c24b209b027f01e074e263d1e54c4ad2e3a8d41dd1e2ea008adbde91aaeccf690a0a51314fa2566c468959f92bce38fc460fed13af066feb2376b4c40a8b52e605a5d3d46a22b6210d1c2ced4ece24c5b965e05f7841bd376917b0931e1032e04c44a4c5956f889a18aca73250b18c976bf66cb0872286ed77b86e348db2d1017b4bb3fbc92a00b115b38a6f06f0207b3ce27ca44ef8532e5909094a4ac25096b9249752ab617e0f027158228001058ea41624ea0967141a115bc5d998ceea62a5ad0a1a10820850a1197302751ae91262169989064ff0010c05960109df414023a53691cb2a6c07252fab16a6ee50570b8898820bb0b660cd402d4d1f740c7f10142ec4ee70e5c6e21cd60ee25b394d0a480482ef9af4caf5e239568d52498a21396652c15cc254adeb999520ffd2921ba44927303e1eed6123f0ac2f7b1162e388b3c0b4143292c2a41164dcb577537c73198f5a48128902aebb024d72a7380e052b7274a56228a9336587ef140292a4e5356a8bd7434e917f0ab70346a79386e869d2319b1711355312acc7406b4ccecdc411f4ebb1c3100005c1bd75372c7ce34898c916f370850dcdc21451078d8f117d3d22c253edbeb0d94da0e97f943aa6c0f5a0f3358ed311efec7bac741f7f68e64df53b8708785690011bf08e9622dd797c8fda1cb4bf3f7e715c9d0fbadfd2002cbb50da24160d10499e0f84df71a4486535a000c63ff009d25136ea47817c4581f36ff00718120fbf7ee904761e2405942fe1980a54343700f3a98a98a9265ad4837492398b83c88631963ed6e1f946b3ee4a5fb232212b8810e68479fbe91a9959a1ecd7691528844c3e0fc2b3f87fa55bd1c6e23d0a54c4cc0e2ecedcf51bc718f1958f7f7839d9eed0aa4109592658b7e6472de9e1fe0f1e7f0f7dd1fd1d5873d6a46ff0013878ad22694283da0861b1699a904105c386b286f1f688317878e068ee4ec2e54e0186881fb37134283a5472fda08a21887290f14b1a974a8703f28261348a1b44b216781f9414078e76a5244f0ce3c20beeb8f95e066204f232aa6af21e3e1f4a13782dda72f89237240f47fac07722895100dc3d0f03c23d2c58ee117f63cec93ef7f25094c8531befd0bf01e507366a261f12549a3fe250e96bf9c099f28b3b0a459d9b8eee963f9799e9452926ad42479446483454269e996a661f3126eeee351c4037e95e117b646124a8d3109497f8541492af563ef588a7cf92a24a24290d524cd510e466a387d5ef14e78cc02c023e46a6a0efa1e31859b51a691844a1407780b124104d2a0ea017a7f98d2e194ee95548f22f5046e34f378c36cf9c4a59570f53a5faeee91a8d9b8bcac54695487352c4b6b56a078717e8c99ad5a0c32ff0030f2fde1433be3f957efac722cce999dc76cb93395956832e69d400165b88a4c1ebca3398ed8f32497f893f98071d47e1f947a34fc2a26a72ac023dd4467f1b2e7618d42a749f39a91c09f8c7035e31cf8b34e1c6feccebc98633fb331a660dc4710e7e912490c1ddb9de340ad952a727bcc32920ea9b07dc45d0785a034e96a4ab2a8104162f1e8e3cd1c9c73ec7064c5287231eadef7441312e7d86874c9837c4495b9a346a6646a150d7d3ebf78b1271168866a85f5f230d42bdfbe5000442871e7e5f6821b593de2113daad916388b1f98e8201a17a41ad8caef133249fc61d3fad363f2f28cb2eaa5edfe1a63ddc7dca60c2f7ce2307d224074dfefac6a6623788e608793efdf48628d1a002fec4db6bc3aaae6592e522e3fa91c7e71e95b33692272010a05c508b1e9a1e11e43322cecadaab90b749f093e24e85b51b8f18e6cfe1d4fba3cff00a7461cfd3a9707aa620149cc34f96b0530f3410e200ecbdaa8c4a0106ad51af51173664e62527431e6b4d3a3d04ed0742e056dec4008009b973fa53e227e51702e309db8daec8201aafc09fd02aa3d6dd7845423d4ebdc89cba55988c5cf33264c99f9944d6e2a69d283a456787cc2406d6215a9a9edded1eca54a8f29bb3a54d6e5ec42c2cc19d19ace9bef0435fa0ff111cfa16dd7e715f107c3eec35899ab438ba66b64cb4aa4a650a294c56770d07ff51e6609e27664a04007f97f818bd13e173c4d7ca33385c4a9d2036660e2c4121d86fa93e5046449985c2b366570341a0def4f224479924cef45bc4c9972d8929725c2505c8ad4ab76fdff005bf8605494049041d0a01ad49aee781a704a29a2496d521edcef736ea225c0001252a70a2520001d9817cbd40871d0a45dfe113ba47fb47fd90a22fe0d1f98ff00b87da145d9146a24e91cda3f01850a38d1dacc2f667fe767fe91fdd163b65747e93fdd0a1474e1f397c1cf97c97f266cdbdf1862ae79c2851ea1e71557f1c4d2be83e51d8508076eeb05b60ffad2fdfe130a144e4fa1fc158feb5f2478aff557fa95fdca8e22fd3e90a14547e942972ce9d797da19374eb0a143110aadef744133ebf6850a188d3f623fd53c87f7c6d70ffeb2ba7d61428f2bc5798cf4fc3f968253be057e93f231e65daeff005a5fe84fcd71d850fc379889f11f419ec47c4397da2a1f893cfef0a147a679c2c57c4ae7f488e6ebfa7e8a850a265c1482b27fe615cd5fde60ee1be05f299f310a1479d23bd706a31369bfa93ffea04e1ffe647fd5fda61428988a469e142851b189ffd9);

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

--
-- Despejando dados para a tabela `item_comanda`
--

INSERT INTO `item_comanda` (`id_item_comanda`, `id_comanda`, `id_produto`, `quantidade`, `observacao`, `total`) VALUES
(1, 0, 9, 1, NULL, 3.50),
(2, 0, 31, 1, NULL, 9.90),
(3, 0, 9, 1, NULL, 3.50),
(4, 0, 31, 1, NULL, 9.90),
(5, 0, 31, 1, NULL, 9.90),
(6, 0, 31, 1, NULL, 9.90),
(7, 0, 31, 1, NULL, 9.90),
(8, 0, 31, 1, NULL, 9.90),
(9, 0, 31, 1, NULL, 9.90),
(10, 0, 31, 1, NULL, 9.90),
(11, 0, 31, 1, NULL, 9.90),
(12, 0, 31, 1, NULL, 9.90),
(13, 0, 31, 1, NULL, 9.90),
(14, 0, 31, 1, NULL, 9.90),
(15, 0, 31, 1, NULL, 9.90),
(16, 0, 31, 1, NULL, 9.90),
(17, 0, 31, 1, NULL, 9.90),
(18, 0, 6, 13, NULL, 336.70),
(19, 0, 9, 1, NULL, 3.50),
(20, 0, 31, 1, NULL, 9.90),
(21, 0, 9, 1, NULL, 3.50),
(22, 0, 9, 1, NULL, 3.50),
(23, 0, 9, 1, NULL, 3.50),
(24, 0, 9, 1, NULL, 3.50),
(25, 0, 9, 1, NULL, 3.50),
(26, 0, 9, 1, NULL, 3.50),
(27, 0, 9, 1, NULL, 3.50),
(28, 0, 9, 1, NULL, 3.50),
(29, 0, 9, 1, NULL, 3.50),
(30, 0, 9, 1, NULL, 3.50),
(31, 0, 9, 1, NULL, 3.50),
(32, 0, 9, 1, NULL, 3.50),
(33, 0, 9, 1, NULL, 3.50),
(34, 0, 9, 1, NULL, 3.50),
(35, 0, 9, 1, NULL, 3.50),
(36, 0, 9, 1, NULL, 3.50),
(37, 0, 9, 1, NULL, 3.50),
(38, 0, 31, 1, NULL, 9.90),
(39, 0, 9, 1, NULL, 3.50),
(40, 0, 18, 1, NULL, 4.90),
(41, 0, 22, 1, NULL, 8.90),
(42, 0, 19, 1, NULL, 5.90),
(43, 0, 3, 1, NULL, 8.90),
(44, 0, 6, 1222, NULL, 31649.80),
(45, 0, 6, 1, NULL, 25.90);

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
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_fornecedor`, `nome_produto`, `descricao`, `preco`, `unmedida`, `validade`, `imagem_produto`, `quantidade_produto`) VALUES
(2, 2, 'Pão Francês', 'Pão francês tradicional, crocante por fora e macio por dentro', 0.50, 'un', '2025-08-30', NULL, '200'),
(3, 8, 'Pão de Forma Integral', 'Pão de forma integral com grãos, ideal para sanduíches saudáveis', 8.90, 'un', '2025-09-05', NULL, '50'),
(4, 8, 'Croissant', 'Croissant folhado e amanteigado, perfeito para o café da manhã', 4.50, 'un', '2025-08-31', NULL, '80'),
(5, 8, 'Baguete', 'Baguete tradicional francesa, crocante e saborosa', 3.20, 'un', '2025-08-30', NULL, '40'),
(6, 9, 'Queijo Minas', 'Queijo minas frescal, leve e saboroso', 25.90, 'kg', '2025-09-10', NULL, '15'),
(7, 9, 'Queijo Prato', 'Queijo prato amarelo, derrete facilmente', 28.50, 'kg', '2025-09-12', NULL, '12'),
(8, 6, 'Tomate', 'Tomate vermelho maduro, perfeito para saladas', 6.90, 'kg', '2025-08-31', NULL, '30'),
(9, 6, 'Alface Crespa', 'Alface crespa fresca e crocante', 3.50, 'un', '2025-08-30', NULL, '25'),
(10, 4, 'Bolo de Chocolate', 'Bolo de chocolate fofinho com cobertura', 22.90, 'un', '2025-08-31', NULL, '10'),
(11, 4, 'Bolo de Cenoura', 'Bolo de cenoura com chocolate', 20.90, 'un', '2025-08-31', NULL, '8'),
(12, 10, 'Brigadeiro', 'Brigadeiro tradicional cremoso', 2.50, 'un', '2025-09-02', NULL, '100'),
(13, 10, 'Beijinho', 'Beijinho de coco cremoso', 2.50, 'un', '2025-09-02', NULL, '90'),
(14, 5, 'Presunto', 'Presunto cozido fatiado', 32.90, 'kg', '2025-09-08', NULL, '18'),
(15, 5, 'Peito de Peru', 'Peito de peru defumado fatiado', 36.90, 'kg', '2025-09-10', NULL, '15'),
(16, 7, 'Refrigerante Coca-Cola', 'Refrigerante Coca-Cola 2L', 9.90, 'un', '2025-12-15', NULL, '40'),
(17, 7, 'Suco de Laranja', 'Suco de laranja natural 1L', 8.50, 'un', '2025-09-05', NULL, '35'),
(18, 11, 'Macarrão Espaguete', 'Macarrão espaguete tipo 8', 4.90, 'un', '2026-08-29', NULL, '60'),
(19, 11, 'Macarrão Penne', 'Macarrão penne integral', 5.90, 'un', '2026-08-29', NULL, '45'),
(20, 3, 'Leite Integral', 'Leite integral pasteurizado 1L', 4.20, 'un', '2025-09-03', NULL, '70'),
(21, 3, 'Iogurte Natural', 'Iogurte natural cremoso', 6.90, 'un', '2025-09-04', NULL, '55'),
(22, 12, 'Maçã', 'Maçã vermelha importada', 8.90, 'kg', '2025-09-07', NULL, '25'),
(23, 12, 'Banana', 'Banana nanica madura', 4.90, 'kg', '2025-08-31', NULL, '35'),
(24, 13, 'Café Tradicional', 'Café tradicional moído 500g', 14.90, 'un', '2026-03-15', NULL, '30'),
(25, 13, 'Café Extra Forte', 'Café extra forte moído 500g', 16.90, 'un', '2026-03-15', NULL, '25'),
(26, 14, 'Sacola Plástica', 'Sacola plástica para embalagens', 0.10, 'un', NULL, NULL, '1000'),
(27, 15, 'Azeite de Oliva', 'Azeite de oliva extra virgem 500ml', 29.90, 'un', '2026-06-20', NULL, '20'),
(28, 15, 'Vinagre Balsâmico', 'Vinagre balsâmico de modena', 18.90, 'un', '2026-05-15', NULL, '18'),
(29, 16, 'Salmão', 'Salmão fresco filé', 89.90, 'kg', '2025-08-30', NULL, '8'),
(30, 17, 'Vinho Tinto', 'Vinho tinto seco garrafa 750ml', 45.90, 'un', '2027-08-29', NULL, '15'),
(31, 18, 'Arroz Integral', 'Arroz integral orgânico 1kg', 9.90, 'un', '2026-02-28', NULL, '40');

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
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `funcao`
--
ALTER TABLE `funcao`
  MODIFY `id_funcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `item_comanda`
--
ALTER TABLE `item_comanda`
  MODIFY `id_item_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
