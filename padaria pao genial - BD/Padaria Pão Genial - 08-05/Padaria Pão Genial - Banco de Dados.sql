CREATE DATABASE Padaria_Pao_Genial;
Use Padaria_Pao_Genial;

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE `estoque` (
  `id_produto` int not null,
  `id_estoque` int NOT NULL,
  `quant_atual` int DEFAULT NULL,
  `quant_max` int DEFAULT NULL,
  `quant_min` int NOT NULL,
  PRIMARY KEY (`id_estoque`),
  FOREIGN KEY(`id_produto`) References produto(`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `comanda`;
CREATE TABLE `comanda` (
  `id_comanda` int NOT NULL,
  `data_abertura` date DEFAULT NULL,
  `hora_abertura` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `qtd` int NOT NULL,
  PRIMARY KEY (`id_comanda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;





DROP TABLE IF EXISTS `venda`;
CREATE TABLE `venda` (
  `id_venda` int NOT NULL,
  `id_caixa` int NOT NULL,
  `id_formadepagamento` int NOT NULL,
  `data_dia` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `id_caixa` (`id_caixa`),
  KEY `id_formadepagamento` (`id_formadepagamento`),
  CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`id_caixa`) REFERENCES `caixa` (`id_caixa`),
  CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`id_formadepagamento`) REFERENCES `formadepagamento` (`id_formadepagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS `caixa`;
CREATE TABLE `caixa` (
  `id_caixa` int NOT NULL,
  `id_funcionario` int NOT NULL,
  `data_abertura` date DEFAULT NULL,
  `hora_abertura` time DEFAULT NULL,
  `data_fechamento` date DEFAULT NULL,
  `hora_fechamento` time DEFAULT NULL,
  `valor_inicial` decimal(10,2) DEFAULT NULL,
  `valor_final` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_caixa`),
  KEY `id_funcionario` (`id_funcionario`),
  CONSTRAINT `caixa_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id_produto` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `preco_unit` decimal(10,2) DEFAULT NULL,
  `uni_medida` varchar(20) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_fornecedor` (`id_fornecedor`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;





DROP TABLE IF EXISTS `movestoque`;
CREATE TABLE `movestoque` (
  `id_movestoque` int NOT NULL,
  `id_produto` int NOT NULL,
  `id_funcionario` int NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id_movestoque`),
  KEY `id_produto` (`id_produto`),
  KEY `id_funcionario` (`id_funcionario`),
  CONSTRAINT `movestoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  CONSTRAINT `movestoque_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `movcaixa`;
CREATE TABLE `movcaixa` (
  `id_movcaixa` int NOT NULL,
  `id_caixa` int NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  `observacao` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_movcaixa`),
  KEY `id_caixa` (`id_caixa`),
  CONSTRAINT `movcaixa_ibfk_1` FOREIGN KEY (`id_caixa`) REFERENCES `caixa` (`id_caixa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS `itemvenda`;
CREATE TABLE `itemvenda` (
  `id_itemvenda` int NOT NULL,
  `id_produto` int NOT NULL,
  `id_venda` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_un` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_itemvenda`),
  KEY `id_produto` (`id_produto`),
  KEY `id_venda` (`id_venda`),
  CONSTRAINT `itemvenda_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  CONSTRAINT `itemvenda_ibfk_2` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id_venda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE `funcionario` (
  `id_funcionario` int NOT NULL,
  `id_funcao` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `rua` varchar(30) DEFAULT NULL,
  `numero` int DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(20) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `data_admissao` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_funcionario`),
  KEY `id_funcao` (`id_funcao`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_funcao`) REFERENCES `funcao` (`id_funcao`),
  CONSTRAINT `funcionario_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `funcao`;
CREATE TABLE `funcao` (
  `id_funcao` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_funcao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE `fornecedor` (
  `id_fornecedor` int NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `cnpj` varchar(80) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




DROP TABLE IF EXISTS `formadepagamento`;
CREATE TABLE `formadepagamento` (
  `id_formadepagamento` int NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_formadepagamento`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DESCRIBE itemvenda;

CREATE TABLE `itemvenda` (
    id_itemvenda INT NOT NULL,
    id_produto INT NOT NULL,
    id_venda INT NOT NULL,
    quantidade INT NOT NULL,
    preco_un DECIMAL(10,2),
    PRIMARY KEY (id_itemvenda),
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto),
    FOREIGN KEY (id_venda) REFERENCES venda(id_venda)
);

--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `itemcomanda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemcomanda` (
  `id_itemcomanda` int NOT NULL AUTO_INCREMENT,
  `id_comanda` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_un` decimal(10,2) DEFAULT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_itemcomanda`),
  KEY `id_comanda` (`id_comanda`),
  KEY `id_produto` (`id_produto`),
  CONSTRAINT `itemcomanda_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id_comanda`),
  CONSTRAINT `itemcomanda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;