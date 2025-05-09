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
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `id_fornecedor` int NOT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `preco_unit` decimal(10,2) DEFAULT NULL,
  `uni_medida` varchar(20) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_fornecedor` (`id_fornecedor`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,1,'Pão Francês','Pão francês fresquinho',0.80,'unidade','2025-05-10'),(2,2,'Bolo de Chocolate','Bolo de chocolate com recheio cremoso',15.00,'unidade','2025-05-15'),(3,3,'Torta de Maçã','Torta de maçã com massa folhada',20.00,'unidade','2025-05-12'),(4,4,'Pão de Queijo','Pão de queijo caseiro',1.00,'unidade','2025-05-07'),(5,5,'Coxinha','Coxinha de frango com massa crocante',2.50,'unidade','2025-05-08'),(6,6,'Brigadeiro','Docinho de brigadeiro de leite condensado',1.00,'unidade','2025-05-09'),(7,7,'Bolo de Cenoura','Bolo de cenoura com cobertura de chocolate',12.00,'unidade','2025-05-14'),(8,8,'Pão de Mel','Pão de mel coberto com chocolate',3.00,'unidade','2025-05-11'),(9,9,'Quiche de Frango','Quiche de frango com recheio cremoso',18.00,'unidade','2025-05-13'),(10,10,'Torta de Limão','Torta de limão com merengue',22.00,'unidade','2025-05-16'),(11,1,'Pão de Forma','Pão de forma macio e fofinho',5.00,'unidade','2025-05-12'),(12,2,'Bolo de Fubá','Bolo de fubá com pedaços de goiabada',10.00,'unidade','2025-05-17'),(13,3,'Pão Italiano','Pão italiano crocante por fora e macio por dentro',7.00,'unidade','2025-05-10'),(14,4,'Pizza','Pizza de calabresa',30.00,'unidade','2025-05-18'),(15,5,'Bolo de Banana','Bolo de banana com açúcar mascavo',14.00,'unidade','2025-05-19'),(16,6,'Alfajor','Docinho argentino com doce de leite',2.50,'unidade','2025-05-14'),(17,7,'Pão de Batata','Pão de batata leve e fofinho',1.50,'unidade','2025-05-15'),(18,8,'Churros','Churros recheados com doce de leite',3.00,'unidade','2025-05-20'),(19,9,'Torta de Frango','Torta de frango com recheio cremoso',20.00,'unidade','2025-05-21'),(20,10,'Bolo de Abacaxi','Bolo de abacaxi com creme',16.00,'unidade','2025-05-22'),(21,1,'Pão de Alho','Pão de alho delicioso e bem temperado',4.00,'unidade','2025-05-23'),(22,2,'Pão de Leite','Pão de leite fofinho e doce',1.20,'unidade','2025-05-24'),(23,3,'Bolo Prestígio','Bolo de chocolate e coco',17.00,'unidade','2025-05-25'),(24,4,'Empada de Frango','Empada de frango recheada',3.50,'unidade','2025-05-26'),(25,5,'Pão Doce','Pão doce com açúcar cristal',2.00,'unidade','2025-05-27'),(26,6,'Beijinho','Docinho de leite condensado e coco',1.50,'unidade','2025-05-28'),(27,7,'Biscoito de Polvilho','Biscoito de polvilho crocante',2.00,'unidade','2025-05-29'),(28,8,'Bolo de Morango','Bolo de morango com cobertura de chantilly',18.00,'unidade','2025-05-30'),(29,9,'Torta de Nozes','Torta de nozes com massa folhada',25.00,'unidade','2025-06-01'),(30,10,'Pastel de Carne','Pastel frito recheado com carne',3.50,'unidade','2025-06-02'),(31,1,'Pão Integral','Pão integral com grãos',6.00,'unidade','2025-06-03'),(32,2,'Bolo de Laranja','Bolo de laranja com cobertura de açúcar',12.00,'unidade','2025-06-04'),(33,3,'Torta de Chocolate','Torta de chocolate com creme',22.00,'unidade','2025-06-05'),(34,4,'Pão de Centeio','Pão de centeio com uma crosta crocante',8.00,'unidade','2025-06-06'),(35,5,'Coxinha de Frango','Coxinha de frango empanada',2.00,'unidade','2025-06-07'),(36,6,'Pudim','Pudim de leite condensado',8.00,'unidade','2025-06-08'),(37,7,'Torta de Morango','Torta de morango com creme de leite',20.00,'unidade','2025-06-09'),(38,8,'Pão de Batata Doce','Pão de batata doce integral',1.80,'unidade','2025-06-10'),(39,9,'Quiche de Legumes','Quiche de legumes e queijo',18.00,'unidade','2025-06-11'),(40,10,'Torta de Coco','Torta de coco com creme',23.00,'unidade','2025-06-12'),(41,1,'Bolo de Mandioca','Bolo de mandioca fofinho e delicioso',14.00,'unidade','2025-06-13'),(42,2,'Bolo de Maçã','Bolo de maçã com canela',13.00,'unidade','2025-06-14'),(43,3,'Pão de Mel Integral','Pão de mel integral com mel',5.00,'unidade','2025-06-15'),(44,4,'Pão de Milho','Pão de milho caseiro',3.00,'unidade','2025-06-16'),(45,5,'Empada de Palmito','Empada de palmito com massa crocante',4.50,'unidade','2025-06-17'),(46,6,'Mousse de Maracujá','Mousse de maracujá gelada',7.00,'unidade','2025-06-18'),(47,7,'Pão de Arroz','Pão de arroz sem glúten',8.00,'unidade','2025-06-19'),(48,8,'Torta de Pêssego','Torta de pêssego com creme',21.00,'unidade','2025-06-20'),(49,9,'Bolo de Batata Doce','Bolo de batata doce integral',15.00,'unidade','2025-06-21'),(50,10,'Churros de Chocolate','Churros recheados com chocolate',3.50,'unidade','2025-06-22'),(51,1,'Biscoito de Gergelim','Biscoito de gergelim crocante',2.50,'unidade','2025-06-23'),(52,2,'Bolo de Abóbora','Bolo de abóbora com nozes',14.00,'unidade','2025-06-24'),(53,3,'Pão de Amêndoas','Pão de amêndoas com sabor delicado',7.50,'unidade','2025-06-25'),(54,4,'Pão de Batata Doce','Pão de batata doce com massa leve',4.50,'unidade','2025-06-26'),(55,5,'Torta de Morango','Torta de morango com chantilly',20.00,'unidade','2025-06-27'),(56,6,'Coxinha de Catupiry','Coxinha de catupiry com recheio cremoso',3.00,'unidade','2025-06-28'),(57,7,'Torta de Ricota','Torta de ricota com massa folhada',22.00,'unidade','2025-06-29'),(58,8,'Bolo de Pão de Ló','Bolo de pão de ló com recheio leve',18.00,'unidade','2025-06-30'),(59,9,'Bolo de Cacau','Bolo de cacau com creme de chocolate',19.00,'unidade','2025-07-01'),(60,10,'Pastel de Queijo','Pastel frito recheado com queijo',4.00,'unidade','2025-07-02');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-08 17:04:20
