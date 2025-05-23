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
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda` (
  `id_venda` int NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` VALUES (1,1,1,'2025-05-08','08:15:00',45.50),(2,2,2,'2025-05-08','08:30:00',30.75),(3,3,3,'2025-05-08','09:00:00',60.00),(4,4,4,'2025-05-08','09:30:00',50.40),(5,5,1,'2025-05-08','10:00:00',72.20),(6,6,2,'2025-05-08','10:30:00',28.50),(7,7,3,'2025-05-08','11:00:00',55.00),(8,8,4,'2025-05-08','11:30:00',33.00),(9,9,1,'2025-05-08','12:00:00',40.60),(10,10,2,'2025-05-08','12:30:00',45.20),(11,1,3,'2025-05-08','13:00:00',67.80),(12,2,4,'2025-05-08','13:30:00',52.10),(13,3,1,'2025-05-08','14:00:00',30.90),(14,4,2,'2025-05-08','14:30:00',40.00),(15,5,3,'2025-05-08','15:00:00',78.30),(16,6,4,'2025-05-08','15:30:00',50.50),(17,7,1,'2025-05-08','16:00:00',55.80),(18,8,2,'2025-05-08','16:30:00',38.40),(19,9,3,'2025-05-08','17:00:00',62.60),(20,10,4,'2025-05-08','17:30:00',35.00),(21,1,1,'2025-05-09','08:15:00',48.30),(22,2,2,'2025-05-09','08:45:00',33.90),(23,3,3,'2025-05-09','09:15:00',57.00),(24,4,4,'2025-05-09','09:45:00',43.20),(25,5,1,'2025-05-09','10:15:00',69.50),(26,6,2,'2025-05-09','10:45:00',41.10),(27,7,3,'2025-05-09','11:15:00',61.90),(28,8,4,'2025-05-09','11:45:00',37.50),(29,9,1,'2025-05-09','12:15:00',47.80),(30,10,2,'2025-05-09','12:45:00',54.40),(31,1,3,'2025-05-09','13:15:00',80.00),(32,2,4,'2025-05-09','13:45:00',51.70),(33,3,1,'2025-05-09','14:15:00',32.90),(34,4,2,'2025-05-09','14:45:00',46.10),(35,5,3,'2025-05-09','15:15:00',75.20),(36,6,4,'2025-05-09','15:45:00',58.60),(37,7,1,'2025-05-09','16:15:00',56.30),(38,8,2,'2025-05-09','16:45:00',39.40),(39,9,3,'2025-05-09','17:15:00',65.50),(40,10,4,'2025-05-09','17:45:00',34.20),(41,1,1,'2025-05-10','08:30:00',50.00),(42,2,2,'2025-05-10','09:00:00',35.80),(43,3,3,'2025-05-10','09:30:00',60.90),(44,4,4,'2025-05-10','10:00:00',42.50),(45,5,1,'2025-05-10','10:30:00',68.10),(46,6,2,'2025-05-10','11:00:00',44.90),(47,7,3,'2025-05-10','11:30:00',63.20),(48,8,4,'2025-05-10','12:00:00',36.40),(49,9,1,'2025-05-10','12:30:00',48.50),(50,10,2,'2025-05-10','13:00:00',52.00),(51,1,3,'2025-05-10','13:30:00',72.00),(52,2,4,'2025-05-10','14:00:00',50.30),(53,3,1,'2025-05-10','14:30:00',33.40),(54,4,2,'2025-05-10','15:00:00',45.10),(55,5,3,'2025-05-10','15:30:00',79.60),(56,6,4,'2025-05-10','16:00:00',54.80),(57,7,1,'2025-05-10','16:30:00',60.20),(58,8,2,'2025-05-10','17:00:00',38.80),(59,9,3,'2025-05-10','17:30:00',66.40),(60,10,4,'2025-05-10','18:00:00',32.10);
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
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
