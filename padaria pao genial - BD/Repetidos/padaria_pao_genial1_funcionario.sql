-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: padaria_pao_genial1
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionario` (
  `id_funcionario` int NOT NULL AUTO_INCREMENT,
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
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `rg` (`rg`),
  KEY `id_funcao` (`id_funcao`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_funcao`) REFERENCES `funcao` (`id_funcao`),
  CONSTRAINT `funcionario_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (1,1,1,'Ana Silva','111.111.111-11','(11)91111-1111','ana.silva@example.com','Rua das Acácias',101,'Centro','São Paulo','SP','2021-01-10',2500.00,'11.111.111-1'),(2,2,2,'Bruno Costa','222.222.222-22','(21)92222-2222','bruno.costa@example.com','Av. Brasil',202,'Copacabana','Rio de Janeiro','RJ','2020-06-15',3200.00,'22.222.222-2'),(3,3,3,'Carlos Lima','333.333.333-33','(31)93333-3333','carlos.lima@example.com','Rua das Laranjeiras',303,'Savassi','Belo Horizonte','MG','2022-03-20',2800.00,'33.333.333-3'),(4,4,4,'Daniela Rocha','444.444.444-44','(41)94444-4444','daniela.rocha@example.com','Rua XV de Novembro',404,'Centro','Curitiba','PR','2023-09-01',3100.00,'44.444.444-4'),(5,5,5,'Eduardo Alves','555.555.555-55','(51)95555-5555','eduardo.alves@example.com','Av. Ipiranga',505,'Centro','Porto Alegre','RS','2020-12-10',2700.00,'55.555.555-5'),(6,1,6,'Fernanda Souza','666.666.666-66','(61)96666-6666','fernanda.souza@example.com','Rua das Palmeiras',606,'Asa Sul','Brasília','DF','2021-07-23',2900.00,'66.666.666-6'),(7,2,7,'Gabriel Martins','777.777.777-77','(71)97777-7777','gabriel.martins@example.com','Av. Sete de Setembro',707,'Pelourinho','Salvador','BA','2022-11-14',2600.00,'77.777.777-7'),(8,3,8,'Helena Dias','888.888.888-88','(81)98888-8888','helena.dias@example.com','Rua da Aurora',808,'Boa Vista','Recife','PE','2021-05-19',3000.00,'88.888.888-8'),(9,4,9,'Igor Mendes','999.999.999-99','(91)99999-9999','igor.mendes@example.com','Rua Nazaré',909,'Umarizal','Belém','PA','2020-08-30',2800.00,'99.999.999-9'),(10,5,10,'Joana Pires','000.000.000-00','(31)90000-0001','joana.pires@example.com','Avenida Brasília',1010,'Centro','Belo Horizonte','MG','2022-01-12',3100.00,'00.000.000-0'),(11,1,11,'Kleber Ramos','123.123.123-12','(41)91234-5678','kleber.ramos@example.com','Rua 15 de Novembro',1111,'Jardim das Américas','Curitiba','PR','2021-04-03',2900.00,'12.123.123-70'),(12,2,12,'Larissa Cunha','234.234.234-45','(51)92345-6789','larissa.cunha@example.com','Rua do Sol',1212,'Zona Norte','Porto Alegre','RS','2020-09-17',3200.00,'23.234.234-79'),(13,3,13,'Marcelo Torres','345.345.345-34','(61)93456-7890','marcelo.torres@example.com','Avenida Ibirapuera',1313,'Lago Sul','Brasília','DF','2019-12-25',2700.00,'34.345.345-3'),(14,4,14,'Natália Braga','456.456.456-45','(81)94567-8901','natalia.braga@example.com','Rua das Flores',1414,'Vila Rica','Recife','PE','2022-02-08',2500.00,'45.456.456-4'),(15,5,15,'Otávio Duarte','567.567.567-56','(31)95678-9012','otavio.duarte@example.com','Avenida São João',1515,'Centro','Belo Horizonte','MG','2020-11-04',3300.00,'56.567.567-5'),(16,1,16,'Paula Fernandes','678.678.678-67','(41)96789-0123','paula.fernandes@example.com','Rua das Palmeiras',1616,'Vila Itororó','Curitiba','PR','2021-03-22',3000.00,'67.678.678-6'),(17,2,17,'Quésia Lopes','789.789.789-78','(51)97789-1234','quesia.lopes@example.com','Avenida da Liberdade',1717,'Centro','Porto Alegre','RS','2020-05-10',2800.00,'78.789.789-7'),(18,3,18,'Rafael Vieira','890.890.890-89','(61)98890-2345','rafael.vieira@example.com','Rua das Hortências',1818,'Asa Norte','Brasília','DF','2021-09-19',2900.00,'89.890.890-8'),(19,4,19,'Simone Teixeira','901.901.901-90','(81)98800-5678','simone.teixeira@example.com','Rua do Carmo',1919,'Boa Vista','Recife','PE','2022-04-13',2600.00,'90.901.901-9'),(20,5,20,'Tiago Freitas','012.012.012-01','(31)91111-2233','tiago.freitas@example.com','Avenida Paulista',2020,'Centro','Belo Horizonte','MG','2023-01-18',3500.00,'01.012.012-0'),(21,1,21,'Ursula Matos','023.023.023-02','(41)92222-3344','ursula.matos@example.com','Rua das Palmeiras',2121,'Vila Madalena','São Paulo','SP','2022-10-10',2700.00,'02.023.023-0'),(22,2,22,'Vinícius Andrade','034.034.034-03','(51)93333-4455','vinicius.andrade@example.com','Rua dos Lírios',2222,'Zona Leste','Porto Alegre','RS','2020-11-07',3200.00,'03.034.034-1'),(23,3,23,'Wesley Rocha','045.045.045-04','(61)94444-5566','wesley.rocha@example.com','Avenida Central',2323,'Águas Claras','Brasília','DF','2023-02-14',3100.00,'04.045.045-2'),(24,4,24,'Xuxa de Souza','056.056.056-05','(81)95555-6677','xuxa.souza@example.com','Rua do Limoeiro',2424,'Boa Vista','Recife','PE','2021-04-18',2800.00,'05.056.056-3'),(25,5,25,'Yasmin Prado','067.067.067-06','(31)96666-7788','yasmin.prado@example.com','Avenida Júlio de Castilhos',2525,'Santa Efigênia','Belo Horizonte','MG','2022-06-25',2700.00,'06.067.067-4'),(26,1,26,'Zeca Amaral','078.078.078-07','(41)97777-8899','zeca.amaral@example.com','Rua da Liberdade',2626,'Bela Vista','Curitiba','PR','2021-08-12',2900.00,'07.078.078-5'),(27,2,27,'Alice Ribeiro','089.089.089-08','(51)98888-9000','alice.ribeiro@example.com','Avenida Paranaíba',2727,'Centro','Porto Alegre','RS','2020-07-09',3100.00,'08.089.089-6'),(28,3,28,'Bernardo Gomes','090.090.090-09','(61)99999-0111','bernardo.gomes@example.com','Rua dos Três Corações',2828,'Jardim do Sol','Brasília','DF','2022-05-30',3300.00,'09.090.090-7'),(29,4,29,'Caio Monteiro','101.101.101-10','(81)96666-2233','caio.monteiro@example.com','Rua das Palmeiras',2929,'Vila Guarujá','Recife','PE','2023-08-14',2700.00,'10.101.101-8'),(30,5,30,'Débora Rezende','112.112.112-11','(31)97777-3344','debora.rezende@example.com','Avenida Rio Branco',3030,'Floresta','Belo Horizonte','MG','2022-01-24',3000.00,'11.112.112-9'),(31,1,31,'Elias Moura','123.123.123-90','(41)93333-4455','elias.moura@example.com','Rua São José',3131,'Vila Hélio','Curitiba','PR','2021-02-22',2900.00,'12.123.123-1'),(32,2,32,'Fabiana Tavares','134.134.134-13','(51)94444-5566','fabiana.tavares@example.com','Rua do Carmo',3232,'Centro','Porto Alegre','RS','2022-03-15',3200.00,'13.134.134-2'),(33,3,33,'Gustavo Lacerda','145.145.145-14','(61)95555-6677','gustavo.lacerda@example.com','Rua das Margaridas',3333,'Asa Norte','Brasília','DF','2023-04-12',3300.00,'14.145.145-3'),(34,4,34,'Heloísa Mota','156.156.156-15','(81)96666-7788','heloisa.mota@example.com','Rua da Luz',3434,'Boa Vista','Recife','PE','2020-06-20',2800.00,'15.156.156-4'),(35,5,35,'Igor Ribeiro','167.167.167-16','(31)96666-8899','igor.ribeiro@example.com','Avenida São João',3535,'Jardim Leal','Belo Horizonte','MG','2022-07-21',3100.00,'16.167.167-5'),(36,1,36,'Joana Costa','178.178.178-17','(41)97777-9000','joana.costa@example.com','Rua das Palmeiras',3636,'Vila Hortência','Curitiba','PR','2021-05-14',2700.00,'17.178.178-6'),(37,2,37,'Karine Ribeiro','189.189.189-18','(51)98888-0111','karine.ribeiro@example.com','Avenida Presidente Vargas',3737,'Zona Sul','Porto Alegre','RS','2022-08-23',3200.00,'18.189.189-7'),(38,3,38,'Luiz Carlos','190.190.190-19','(61)99999-1234','luiz.carlos@example.com','Rua das Palmeiras',3838,'Taguatinga','Brasília','DF','2023-06-02',2800.00,'19.190.190-8'),(39,4,39,'Mariana Souza','201.201.201-20','(81)99999-1234','mariana.souza@example.com','Rua do Sol',3939,'Cordeiro','Recife','PE','2020-08-28',3000.00,'20.201.201-9'),(40,5,40,'Noemi Pereira','212.212.212-21','(31)93333-4455','noemi.pereira@example.com','Rua das Acácias',4040,'Centro','Belo Horizonte','MG','2021-09-11',2700.00,'21.212.212-0'),(41,1,41,'Olga Pinto','223.223.223-22','(41)92222-5566','olga.pinto@example.com','Rua da Praia',4141,'Vila Clara','Curitiba','PR','2022-07-08',3100.00,'22.223.223-1'),(42,2,42,'Pedro Marques','234.234.234-23','(51)93333-6677','pedro.marques@example.com','Rua dos Pescadores',4242,'Vila Nova','Porto Alegre','RS','2023-04-21',3000.00,'23.234.234-2'),(43,3,43,'Quelen Azevedo','245.245.245-24','(61)94444-7788','quelen.azevedo@example.com','Rua das Flores',4343,'Ceilândia','Brasília','DF','2022-10-19',3100.00,'24.245.245-3'),(44,4,44,'Rogério Costa','256.256.256-25','(81)95555-8899','rogerio.costa@example.com','Rua Jardim São Paulo',4444,'Boa Vista','Recife','PE','2020-03-07',2800.00,'25.256.256-4'),(45,5,45,'Sabrina Costa','267.267.267-26','(31)96666-9900','sabrina.costa@example.com','Avenida Maria Antônia',4545,'Centro','Belo Horizonte','MG','2021-01-28',3200.00,'26.267.267-5'),(46,1,46,'Thiago Lima','278.278.278-27','(41)92222-1111','thiago.lima@example.com','Rua do Sol',4646,'Vila Progresso','Curitiba','PR','2020-06-01',2700.00,'27.278.278-6'),(47,2,47,'Uillian Carvalho','289.289.289-28','(51)93333-7788','uillian.carvalho@example.com','Avenida Santos',4747,'Centro','Porto Alegre','RS','2022-09-14',3300.00,'28.289.289-7'),(48,3,48,'Vera Lúcia','300.300.300-29','(61)94444-8899','vera.lucia@example.com','Rua dos Girassóis',4848,'Taguatinga','Brasília','DF','2023-01-17',2900.00,'29.300.300-8'),(49,4,49,'Waldir Souza','311.311.311-30','(81)95555-9999','waldir.souza@example.com','Rua São João',4949,'Boa Vista','Recife','PE','2020-05-25',2800.00,'30.311.311-9'),(50,5,50,'Xênia Monteiro','322.322.322-31','(31)97777-0000','xenia.monteiro@example.com','Avenida Paulista',5050,'Bela Vista','Belo Horizonte','MG','2023-07-20',3100.00,'31.322.322-0'),(51,1,51,'Ygor Silva','333.333.333-32','(41)92222-0000','ygor.silva@example.com','Rua do Sol',5151,'Vila São João','Curitiba','PR','2021-08-16',2700.00,'32.333.333-1'),(52,2,52,'Zélia Tavares','344.344.344-33','(51)93333-8899','zelia.tavares@example.com','Rua Santos Dumont',5252,'Zona Sul','Porto Alegre','RS','2023-05-06',3300.00,'33.344.344-2'),(53,3,53,'André Nunes','355.355.355-34','(61)94444-0011','andre.nunes@example.com','Rua das Laranjeiras',5353,'Gama','Brasília','DF','2020-11-10',2900.00,'34.355.355-3'),(54,4,54,'Bárbara Rodrigues','366.366.366-35','(81)96666-1122','barbara.rodrigues@example.com','Rua dos Três Irmãos',5454,'Boa Vista','Recife','PE','2021-09-23',3200.00,'35.366.366-4'),(55,5,55,'Carlos Eduardo','377.377.377-36','(31)97777-2233','carlos.eduardo@example.com','Avenida Salgado Filho',5555,'Centro','Belo Horizonte','MG','2022-02-13',2700.00,'36.377.377-5'),(56,1,56,'Diana Araújo','388.388.388-37','(41)93333-1122','diana.araujo@example.com','Rua da Alegria',5656,'Vila Maria','Curitiba','PR','2023-06-28',2900.00,'37.388.388-6'),(57,2,57,'Eduarda Lima','399.399.399-38','(51)94444-2233','eduarda.lima@example.com','Avenida Brasil',5757,'Centro','Porto Alegre','RS','2020-04-17',3100.00,'38.399.399-7'),(58,3,58,'Fernando Ramos','410.410.410-39','(61)95555-3344','fernando.ramos@example.com','Rua da Paz',5858,'Águas Claras','Brasília','DF','2022-02-18',3000.00,'39.410.410-8'),(59,4,59,'Gabriela Costa','421.421.421-40','(81)93333-4455','gabriela.costa@example.com','Rua Coração',5959,'Boa Vista','Recife','PE','2021-03-08',3300.00,'40.421.421-9'),(60,5,60,'Helena Almeida','432.432.432-41','(31)94444-5566','helena.almeida@example.com','Avenida Rio Branco',6060,'Bairro Santa Cruz','Belo Horizonte','MG','2022-08-01',2800.00,'41.432.432-0');
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-08 17:04:19
