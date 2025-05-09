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
-- Table structure for table `comanda`
--

DROP TABLE IF EXISTS `comanda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comanda` (
  `id_comanda` int NOT NULL AUTO_INCREMENT,
  `data_abertura` date DEFAULT NULL,
  `hora_abertura` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Aberta',
  `qtd` int NOT NULL,
  PRIMARY KEY (`id_comanda`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comanda`
--

LOCK TABLES `comanda` WRITE;
/*!40000 ALTER TABLE `comanda` DISABLE KEYS */;
INSERT INTO `comanda` VALUES (1,'2025-05-13','16:00:00','aberta',9),(2,'2025-05-09','13:20:00','aberta',7),(3,'2025-05-10','14:30:00','fechada',11),(4,'2025-05-11','14:50:00','fechada',6),(5,'2025-05-03','10:00:00','fechada',10),(6,'2025-05-05','11:10:00','fechada',14),(7,'2025-05-07','12:20:00','aberta',11),(8,'2025-05-04','10:10:00','aberta',7),(9,'2025-05-04','10:40:00','aberta',5),(10,'2025-05-10','14:20:00','aberta',4),(11,'2025-05-10','14:00:00','aberta',5),(12,'2025-05-02','09:20:00','fechada',9),(13,'2025-05-01','08:40:00','fechada',3),(14,'2025-05-04','10:20:00','fechada',13),(15,'2025-05-11','15:00:00','aberta',12),(16,'2025-05-07','12:00:00','aberta',4),(17,'2025-05-01','08:10:00','aberta',10),(18,'2025-05-09','13:30:00','fechada',15),(19,'2025-05-06','11:40:00','aberta',3),(20,'2025-05-12','15:50:00','fechada',8),(21,'2025-05-12','15:30:00','fechada',10),(22,'2025-05-10','14:10:00','fechada',8),(23,'2025-05-06','11:50:00','fechada',10),(24,'2025-05-07','12:30:00','fechada',6),(25,'2025-05-02','09:00:00','aberta',8),(26,'2025-05-03','09:50:00','aberta',11),(28,'2025-05-06','11:30:00','fechada',7),(29,'2025-05-02','08:50:00','aberta',6),(30,'2025-05-08','12:50:00','fechada',13),(32,'2025-05-11','15:10:00','fechada',9),(33,'2025-05-06','11:20:00','aberta',9),(34,'2025-05-01','08:20:00','fechada',7),(35,'2025-05-04','10:30:00','aberta',12),(36,'2025-05-09','13:40:00','aberta',6),(37,'2025-05-03','09:40:00','fechada',4),(38,'2025-05-11','14:40:00','aberta',7),(39,'2025-05-02','09:10:00','fechada',2),(40,'2025-05-08','12:40:00','aberta',8),(41,'2025-05-03','09:30:00','aberta',15),(42,'2025-05-01','08:00:00','aberta',5),(43,'2025-05-13','16:30:00','fechada',5),(44,'2025-05-05','10:50:00','fechada',8),(45,'2025-05-07','12:10:00','fechada',5),(46,'2025-05-08','13:00:00','aberta',9),(47,'2025-05-09','13:50:00','fechada',10),(48,'2025-05-12','15:20:00','aberta',13),(49,'2025-05-05','11:00:00','aberta',6),(50,'2025-05-01','08:30:00','aberta',12),(51,'2025-05-08','13:10:00','fechada',12),(52,'2025-05-12','15:40:00','aberta',15),(53,'2025-05-13','16:10:00','fechada',7),(54,'2025-05-13','16:20:00','aberta',6),(55,'2025-05-14','16:40:00','aberta',14),(56,'2025-05-14','16:50:00','fechada',9),(57,'2025-05-14','17:00:00','aberta',11),(58,'2025-05-14','17:10:00','fechada',13),(59,'2025-05-15','17:20:00','aberta',6),(60,'2025-05-15','17:30:00','fechada',7),(61,'2025-05-15','17:40:00','aberta',10),(62,'2025-05-15','17:50:00','fechada',8);
/*!40000 ALTER TABLE `comanda` ENABLE KEYS */;
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
