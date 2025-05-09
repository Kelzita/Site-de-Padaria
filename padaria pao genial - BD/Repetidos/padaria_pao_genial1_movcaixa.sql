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
-- Table structure for table `movcaixa`
--

DROP TABLE IF EXISTS `movcaixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movcaixa` (
  `id_movcaixa` int NOT NULL AUTO_INCREMENT,
  `id_caixa` int NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `observacao` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_movcaixa`),
  KEY `id_caixa` (`id_caixa`),
  CONSTRAINT `movcaixa_ibfk_1` FOREIGN KEY (`id_caixa`) REFERENCES `caixa` (`id_caixa`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movcaixa`
--

LOCK TABLES `movcaixa` WRITE;
/*!40000 ALTER TABLE `movcaixa` DISABLE KEYS */;
INSERT INTO `movcaixa` VALUES (1,1,50.00,'2025-05-01 06:30:00','Abertura de caixa'),(2,1,-20.00,'2025-05-01 08:00:00','Pagamento de venda 123'),(3,1,30.00,'2025-05-01 09:15:00','Venda de pães'),(4,2,50.00,'2025-05-01 14:30:00','Abertura de caixa'),(5,2,-15.00,'2025-05-01 16:00:00','Pagamento de venda 124'),(6,2,60.00,'2025-05-01 17:45:00','Venda de bolos'),(7,3,70.00,'2025-05-02 06:00:00','Abertura de caixa'),(8,3,-25.00,'2025-05-02 09:00:00','Pagamento de venda 125'),(9,3,80.00,'2025-05-02 11:30:00','Venda de tortas'),(10,4,100.00,'2025-05-02 14:00:00','Abertura de caixa'),(11,4,-30.00,'2025-05-02 15:45:00','Pagamento de venda 126'),(12,4,90.00,'2025-05-02 17:00:00','Venda de pães de queijo'),(13,5,60.00,'2025-05-03 06:30:00','Abertura de caixa'),(14,5,-20.00,'2025-05-03 08:30:00','Pagamento de venda 127'),(15,5,110.00,'2025-05-03 10:15:00','Venda de doces'),(16,6,55.00,'2025-05-03 14:30:00','Abertura de caixa'),(17,6,-40.00,'2025-05-03 16:00:00','Pagamento de venda 128'),(18,6,85.00,'2025-05-03 17:30:00','Venda de salgados'),(19,7,45.00,'2025-05-04 06:00:00','Abertura de caixa'),(20,7,-50.00,'2025-05-04 09:00:00','Pagamento de venda 129'),(21,7,100.00,'2025-05-04 12:30:00','Venda de bolos e tortas'),(22,8,80.00,'2025-05-04 13:00:00','Abertura de caixa'),(23,8,-30.00,'2025-05-04 14:00:00','Pagamento de venda 130'),(24,8,75.00,'2025-05-04 15:45:00','Venda de pães e pães de queijo'),(25,9,90.00,'2025-05-05 06:30:00','Abertura de caixa'),(26,9,-20.00,'2025-05-05 09:00:00','Pagamento de venda 131'),(27,9,100.00,'2025-05-05 10:30:00','Venda de doces e salgados'),(28,10,60.00,'2025-05-05 13:15:00','Abertura de caixa'),(29,10,-25.00,'2025-05-05 14:45:00','Pagamento de venda 132'),(30,10,110.00,'2025-05-05 16:00:00','Venda de bolos de aniversário'),(31,11,65.00,'2025-05-06 06:45:00','Abertura de caixa'),(32,11,-40.00,'2025-05-06 08:00:00','Pagamento de venda 133'),(33,11,85.00,'2025-05-06 09:30:00','Venda de tortas e doces'),(34,12,55.00,'2025-05-06 14:00:00','Abertura de caixa'),(35,12,-35.00,'2025-05-06 15:30:00','Pagamento de venda 134'),(36,12,95.00,'2025-05-06 17:15:00','Venda de pães e bolos'),(37,13,80.00,'2025-05-07 06:15:00','Abertura de caixa'),(38,13,-25.00,'2025-05-07 08:45:00','Pagamento de venda 135'),(39,13,120.00,'2025-05-07 10:00:00','Venda de pães e salgados'),(40,14,50.00,'2025-05-07 13:30:00','Abertura de caixa'),(41,14,-30.00,'2025-05-07 15:00:00','Pagamento de venda 136'),(42,14,90.00,'2025-05-07 17:30:00','Venda de bolos e doces'),(43,15,75.00,'2025-05-08 06:00:00','Abertura de caixa'),(44,15,-50.00,'2025-05-08 08:00:00','Pagamento de venda 137'),(45,15,85.00,'2025-05-08 09:30:00','Venda de salgados e pães'),(46,16,90.00,'2025-05-08 12:15:00','Abertura de caixa'),(47,16,-25.00,'2025-05-08 13:45:00','Pagamento de venda 138'),(48,16,110.00,'2025-05-08 15:00:00','Venda de pães e tortas'),(49,17,100.00,'2025-05-09 06:00:00','Abertura de caixa'),(50,17,-30.00,'2025-05-09 08:30:00','Pagamento de venda 139'),(51,17,115.00,'2025-05-09 09:45:00','Venda de bolos e doces'),(52,18,85.00,'2025-05-09 13:00:00','Abertura de caixa'),(53,18,-40.00,'2025-05-09 14:15:00','Pagamento de venda 140'),(54,18,95.00,'2025-05-09 16:30:00','Venda de salgados e tortas'),(55,19,60.00,'2025-05-10 06:30:00','Abertura de caixa'),(56,19,-50.00,'2025-05-10 08:00:00','Pagamento de venda 141'),(57,19,120.00,'2025-05-10 09:45:00','Venda de pães e tortas'),(58,20,70.00,'2025-05-10 12:30:00','Abertura de caixa'),(59,20,-30.00,'2025-05-10 14:00:00','Pagamento de venda 142'),(60,20,80.00,'2025-05-10 16:15:00','Venda de bolos e doces');
/*!40000 ALTER TABLE `movcaixa` ENABLE KEYS */;
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
