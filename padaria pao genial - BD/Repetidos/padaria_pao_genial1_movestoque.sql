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
-- Table structure for table `movestoque`
--

DROP TABLE IF EXISTS `movestoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movestoque` (
  `id_movestoque` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `id_funcionario` int NOT NULL,
  `observacao` varchar(100) DEFAULT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id_movestoque`),
  KEY `id_produto` (`id_produto`),
  KEY `id_funcionario` (`id_funcionario`),
  CONSTRAINT `movestoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  CONSTRAINT `movestoque_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movestoque`
--

LOCK TABLES `movestoque` WRITE;
/*!40000 ALTER TABLE `movestoque` DISABLE KEYS */;
INSERT INTO `movestoque` VALUES (1,1,1,'Entrada de pães','2025-05-01 06:30:00',100),(2,2,1,'Entrada de bolos','2025-05-01 07:00:00',50),(3,3,2,'Entrada de tortas','2025-05-01 08:15:00',30),(4,4,2,'Entrada de pães de queijo','2025-05-01 09:00:00',75),(5,5,3,'Entrada de salgados','2025-05-01 10:00:00',150),(6,6,3,'Entrada de doces','2025-05-01 11:30:00',60),(7,7,4,'Saída de pães','2025-05-01 13:00:00',-20),(8,8,4,'Saída de bolos','2025-05-01 14:00:00',-10),(9,9,5,'Saída de tortas','2025-05-01 15:30:00',-5),(10,10,5,'Saída de pães de queijo','2025-05-01 16:00:00',-25),(11,1,6,'Saída de salgados','2025-05-01 17:15:00',-60),(12,2,6,'Saída de doces','2025-05-01 18:00:00',-30),(13,3,7,'Entrada de tortas','2025-05-02 06:45:00',40),(14,4,7,'Entrada de pães de queijo','2025-05-02 08:00:00',50),(15,5,8,'Entrada de salgados','2025-05-02 09:15:00',120),(16,6,8,'Entrada de doces','2025-05-02 10:30:00',80),(17,7,9,'Saída de pães','2025-05-02 11:00:00',-30),(18,8,9,'Saída de bolos','2025-05-02 12:15:00',-20),(19,9,10,'Saída de tortas','2025-05-02 13:00:00',-10),(20,10,10,'Saída de pães de queijo','2025-05-02 14:30:00',-30),(21,1,11,'Saída de salgados','2025-05-02 15:45:00',-50),(22,2,11,'Saída de doces','2025-05-02 16:30:00',-25),(23,3,12,'Entrada de tortas','2025-05-03 06:00:00',30),(24,4,12,'Entrada de pães de queijo','2025-05-03 07:15:00',60),(25,5,13,'Entrada de salgados','2025-05-03 08:45:00',150),(26,6,13,'Entrada de doces','2025-05-03 09:30:00',70),(27,7,14,'Saída de pães','2025-05-03 10:00:00',-20),(28,8,14,'Saída de bolos','2025-05-03 11:15:00',-10),(29,9,15,'Saída de tortas','2025-05-03 12:30:00',-15),(30,10,15,'Saída de pães de queijo','2025-05-03 13:30:00',-25),(31,1,16,'Saída de salgados','2025-05-03 14:00:00',-55),(32,2,16,'Saída de doces','2025-05-03 15:00:00',-20),(33,3,17,'Entrada de tortas','2025-05-04 06:30:00',45),(34,4,17,'Entrada de pães de queijo','2025-05-04 08:00:00',65),(35,5,18,'Entrada de salgados','2025-05-04 09:30:00',140),(36,6,18,'Entrada de doces','2025-05-04 10:45:00',75),(37,7,19,'Saída de pães','2025-05-04 11:15:00',-25),(38,8,19,'Saída de bolos','2025-05-04 12:30:00',-15),(39,9,20,'Saída de tortas','2025-05-04 14:00:00',-10),(40,10,20,'Saída de pães de queijo','2025-05-04 15:15:00',-30),(41,1,21,'Saída de salgados','2025-05-04 16:30:00',-50),(42,2,21,'Saída de doces','2025-05-04 17:00:00',-30),(43,3,22,'Entrada de tortas','2025-05-05 06:00:00',25),(44,4,22,'Entrada de pães de queijo','2025-05-05 07:30:00',55),(45,5,23,'Entrada de salgados','2025-05-05 09:00:00',130),(46,6,23,'Entrada de doces','2025-05-05 10:00:00',80),(47,7,24,'Saída de pães','2025-05-05 11:15:00',-20),(48,8,24,'Saída de bolos','2025-05-05 12:00:00',-15),(49,9,25,'Saída de tortas','2025-05-05 13:30:00',-10),(50,10,25,'Saída de pães de queijo','2025-05-05 14:30:00',-25),(51,1,26,'Saída de salgados','2025-05-05 16:00:00',-45),(52,2,26,'Saída de doces','2025-05-05 17:30:00',-30),(53,3,27,'Entrada de tortas','2025-05-06 06:30:00',35),(54,4,27,'Entrada de pães de queijo','2025-05-06 07:15:00',60),(55,5,28,'Entrada de salgados','2025-05-06 08:30:00',140),(56,6,28,'Entrada de doces','2025-05-06 09:00:00',85),(57,7,29,'Saída de pães','2025-05-06 10:00:00',-25),(58,8,29,'Saída de bolos','2025-05-06 11:30:00',-10),(59,9,30,'Saída de tortas','2025-05-06 13:00:00',-15),(60,10,30,'Saída de pães de queijo','2025-05-06 14:30:00',-35);
/*!40000 ALTER TABLE `movestoque` ENABLE KEYS */;
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
