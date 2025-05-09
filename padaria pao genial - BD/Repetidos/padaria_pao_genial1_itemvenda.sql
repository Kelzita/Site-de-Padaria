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
-- Table structure for table `itemvenda`
--

DROP TABLE IF EXISTS `itemvenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemvenda` (
  `id_itemvenda` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `id_venda` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_un` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_itemvenda`),
  KEY `id_produto` (`id_produto`),
  KEY `id_venda` (`id_venda`),
  CONSTRAINT `itemvenda_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  CONSTRAINT `itemvenda_ibfk_2` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id_venda`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemvenda`
--

LOCK TABLES `itemvenda` WRITE;
/*!40000 ALTER TABLE `itemvenda` DISABLE KEYS */;
INSERT INTO `itemvenda` VALUES (1,1,1,2,5.50),(2,2,2,1,3.00),(3,3,3,3,1.20),(4,4,4,5,2.50),(5,5,5,2,4.00),(6,6,6,6,3.80),(7,7,7,4,6.10),(8,8,8,3,2.90),(9,9,9,5,3.20),(10,10,10,1,2.30),(11,1,11,2,5.50),(12,2,12,4,3.00),(13,3,13,5,1.20),(14,4,14,3,2.50),(15,5,15,6,4.00),(16,6,16,2,3.80),(17,7,17,1,6.10),(18,8,18,5,2.90),(19,9,19,2,3.20),(20,10,20,3,2.30),(21,1,21,1,5.50),(22,2,22,3,3.00),(23,3,23,6,1.20),(24,4,24,4,2.50),(25,5,25,2,4.00),(26,6,26,5,3.80),(27,7,27,3,6.10),(28,8,28,2,2.90),(29,9,29,4,3.20),(30,10,30,5,2.30),(31,1,31,3,5.50),(32,2,32,2,3.00),(33,3,33,1,1.20),(34,4,34,6,2.50),(35,5,35,4,4.00),(36,6,36,2,3.80),(37,7,37,5,6.10),(38,8,38,3,2.90),(39,9,39,4,3.20),(40,10,40,6,2.30),(41,1,41,2,5.50),(42,2,42,5,3.00),(43,3,43,3,1.20),(44,4,44,1,2.50),(45,5,45,4,4.00),(46,6,46,2,3.80),(47,7,47,6,6.10),(48,8,48,3,2.90),(49,9,49,1,3.20),(50,10,50,5,2.30),(51,1,51,2,5.50),(52,2,52,6,3.00),(53,3,53,4,1.20),(54,4,54,1,2.50),(55,5,55,3,4.00),(56,6,56,5,3.80),(57,7,57,6,6.10),(58,8,58,4,2.90),(59,9,59,2,3.20),(60,10,60,1,2.30);
/*!40000 ALTER TABLE `itemvenda` ENABLE KEYS */;
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
