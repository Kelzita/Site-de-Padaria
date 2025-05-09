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
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `id_fornecedor` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `cnpj` varchar(80) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`),
  UNIQUE KEY `cnpj` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (1,'Forno Pão & Cia','12.345.678/0001-90','fornopao@cia.com.br','(11) 99999-0001'),(2,'Pão da Vovó','23.456.789/0001-01','paodavovo@padaria.com','(11) 99999-0002'),(3,'Padaria Dona Maria','34.567.890/0001-12','donamaria@padaria.com.br','(11) 99999-0003'),(4,'Pão Quentinho','45.678.901/0001-23','paoquentinho@padaria.com','(11) 99999-0004'),(5,'Sabor do Trigo','56.789.012/0001-34','sabordotrigo@padaria.com','(11) 99999-0005'),(6,'Delícias do Forno','67.890.123/0001-45','deliciasforno@padaria.com.br','(11) 99999-0006'),(7,'Padaria São José','78.901.234/0001-56','saonjose@padaria.com.br','(11) 99999-0007'),(8,'Pão & Cia','89.012.345/0001-67','paoecia@padaria.com','(11) 99999-0008'),(9,'Tradição Padeiro','90.123.456/0001-78','tradicaopadeiro@padaria.com','(11) 99999-0009'),(10,'Doce Pão','12.234.567/0001-89','docepao@padaria.com','(11) 99999-0010'),(11,'Pão da Vida','23.345.678/0001-90','paodavida@padaria.com','(11) 99999-0011'),(12,'Padeiro Mestre','34.456.789/0001-01','padeiromestre@padaria.com.br','(11) 99999-0012'),(13,'Forno de Ouro','45.567.890/0001-12','fornodeouro@padaria.com','(11) 99999-0013'),(14,'Padaria Pão de Mel','56.678.901/0001-23','paodemel@padaria.com.br','(11) 99999-0014'),(15,'Pão & Tradição','67.789.012/0001-34','paotradição@padaria.com','(11) 99999-0015'),(16,'Delícias do Pão','78.890.123/0001-45','deliciasdopao@padaria.com','(11) 99999-0016'),(17,'Pão Quente','89.901.234/0001-56','paoquente@padaria.com.br','(11) 99999-0017'),(18,'Pão com Sabor','90.012.345/0001-67','paosabor@padaria.com','(11) 99999-0018'),(19,'Forno Vivo','12.123.456/0001-78','fornovivo@padaria.com','(11) 99999-0019'),(20,'Pão Perfeito','23.234.567/0001-89','paoperfeito@padaria.com.br','(11) 99999-0020'),(21,'Padaria Ouro Branco','34.345.678/0001-90','oubranco@padaria.com.br','(11) 99999-0021'),(22,'Forno da Mãe','45.456.789/0001-01','fornodamae@padaria.com','(11) 99999-0022'),(23,'Delícias da Vovó','56.567.890/0001-12','deliciasvovo@padaria.com','(11) 99999-0023'),(24,'Pão de Cada Dia','67.678.901/0001-23','paodecadadia@padaria.com','(11) 99999-0024'),(25,'Sabor de Pão','78.789.012/0001-34','sabordepao@padaria.com','(11) 99999-0025'),(26,'Padaria da Esquina','89.890.123/0001-45','padariaesquina@padaria.com','(11) 99999-0026'),(27,'Pão Divino','90.012.234/0001-56','paodivino@padaria.com.br','(11) 99999-0027'),(28,'Padaria Pão de Luz','12.123.345/0001-67','paodeluz@padaria.com','(11) 99999-0028'),(29,'Tradição Pão','23.234.456/0001-78','tradicaopao@padaria.com.br','(11) 99999-0029'),(30,'Doce Pão de Mel','34.345.567/0001-89','docepao@padaria.com','(11) 99999-0030'),(31,'Sabor de Trigo','45.456.678/0001-90','sabordetrigo@padaria.com.br','(11) 99999-0031'),(32,'Padeiro da Vovó','56.567.789/0001-01','padeirovovo@padaria.com','(11) 99999-0032'),(33,'Pão e Companhia','67.678.890/0001-12','paocompanhiapao@padaria.com.br','(11) 99999-0033'),(34,'Forno e Pão','78.789.901/0001-23','fornoepao@padaria.com','(11) 99999-0034'),(35,'Pão do Mercado','89.890.012/0001-34','paodomercado@padaria.com','(11) 99999-0035'),(36,'Padaria Sabor & Pão','90.901.123/0001-45','saborepao@padaria.com.br','(11) 99999-0036'),(37,'Pão Rei','12.901.234/0001-56','paorei@padaria.com','(11) 99999-0037'),(38,'Tradição do Trigo','23.012.345/0001-67','tradicaotrigo@padaria.com','(11) 99999-0038'),(39,'Pão do Forno','34.123.456/0001-78','paodoforno@padaria.com.br','(11) 99999-0039'),(40,'Padaria Vovó Pão','45.234.567/0001-89','vovopao@padaria.com','(11) 99999-0040'),(41,'Delícias de Trigo','56.345.678/0001-90','deliciastrigo@padaria.com.br','(11) 99999-0041'),(42,'Pão Fino','67.456.789/0001-01','paofino@padaria.com','(11) 99999-0042'),(43,'Padaria São João','78.567.890/0001-12','saojoao@padaria.com.br','(11) 99999-0043'),(44,'Forno Real','89.678.901/0001-23','fornoreal@padaria.com','(11) 99999-0044'),(45,'Pão do Bem','90.789.012/0001-34','paodobem@padaria.com.br','(11) 99999-0045'),(46,'Pão Nobre','12.890.123/0001-45','paonobre@padaria.com','(11) 99999-0046'),(47,'Tradição de Pão','23.901.234/0001-56','tradicaodepao@padaria.com','(11) 99999-0047'),(48,'Sabor do Forno','34.012.345/0001-67','sabordoforno@padaria.com.br','(11) 99999-0048'),(49,'Pão Maravilhoso','45.123.456/0001-78','paomaravilhoso@padaria.com','(11) 99999-0049'),(50,'Delícias de Padeiro','56.234.567/0001-89','deliciaspadeiro@padaria.com','(11) 99999-0050'),(51,'Padaria Pão & Sabor','67.345.678/0001-90','paosabor@padaria.com','(11) 99999-0051'),(52,'Pão de Leite','78.456.789/0001-01','paodeleite@padaria.com','(11) 99999-0052'),(53,'Sabor Pão do Forno','89.567.890/0001-12','saborpao@padaria.com.br','(11) 99999-0053'),(54,'Padeiro de Ouro','90.678.901/0001-23','padeirodeouro@padaria.com','(11) 99999-0054'),(55,'Pão da Praça','12.789.012/0001-34','paodapracapadaria@padaria.com','(11) 99999-0055'),(56,'Delícias do Trigo','23.890.123/0001-45','deliciasdetrigo@padaria.com','(11) 99999-0056'),(57,'Padaria Forno e Pão','34.901.234/0001-56','fornoepao@padaria.com.br','(11) 99999-0057'),(58,'Sabor do Pão Quente','45.012.345/0001-67','sabordopaoquente@padaria.com','(11) 99999-0058'),(59,'Pão de Ouro','56.123.456/0001-78','paodeouro@padaria.com.br','(11) 99999-0059'),(60,'Forno do Padeiro','67.234.567/0001-89','fornodopadeiro@padaria.com','(11) 99999-0060');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
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
