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
-- Table structure for table `usuario`
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

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Ana Silva','ana.silva@gmail.com','r7yP1xZ9'),(2,'Bruno Costa','bruno.costa@gmail.com','C3vM5aN2'),(3,'Carlos Lima','carlos.lima@gmail.com','Qp9tL4bW'),(4,'Daniela Rocha','daniela.rocha@gmail.com','Xf6D3pE7'),(5,'Eduardo Alves','eduardo.alves@gmail.com','N8sK2oV1'),(6,'Fernanda Souza','fernanda.souza@gmail.com','Z1xL7tM9'),(7,'Gabriel Martins','gabriel.martins@gmail.com','V2aT8dR5'),(8,'Helena Dias','helena.dias@gmail.com','T3sW4kP6'),(9,'Igor Mendes','igor.mendes@gmail.com','M6cE9aY3'),(10,'Joana Pires','joana.pires@gmail.com','A5pN7zV4'),(11,'Kleber Ramos','kleber.ramos@gmail.com','B3tQ6dE8'),(12,'Larissa Cunha','larissa.cunha@gmail.com','J2vL5yX9'),(13,'Marcelo Torres','marcelo.torres@gmail.com','F8wD2rN6'),(14,'Natália Braga','natalia.braga@gmail.com','Y7sP3kM2'),(15,'Otávio Duarte','otavio.duarte@gmail.com','L1zT6bC5'),(16,'Paula Fernandes','paula.fernandes@gmail.com','H4aN9xW3'),(17,'Quésia Lopes','quesia.lopes@gmail.com','P9vK7cD1'),(18,'Rafael Vieira','rafael.vieira@gmail.com','E6mT2pA8'),(19,'Simone Teixeira','simone.teixeira@gmail.com','K2zW5yQ9'),(20,'Tiago Freitas','tiago.freitas@gmail.com','U3cP8dL7'),(21,'Ursula Matos','ursula.matos@gmail.com','D9aN6tV4'),(22,'Vinícius Andrade','vinicius.andrade@gmail.com','W4pX2yM5'),(23,'Wesley Rocha','wesley.rocha@gmail.com','N5vT1cZ8'),(24,'Xuxa de Souza','xuxa.souza@gmail.com','G7mP3dK2'),(25,'Yasmin Prado','yasmin.prado@gmail.com','S8bL6wQ1'),(26,'Zeca Amaral','zeca.amaral@gmail.com','C3xD9aN7'),(27,'Alice Ribeiro','alice.ribeiro@gmail.com','R4vP1tM6'),(28,'Bernardo Gomes','bernardo.gomes@gmail.com','L9sW8zY3'),(29,'Caio Monteiro','caio.monteiro@gmail.com','M2pN4dE5'),(30,'Débora Rezende','debora.rezende@gmail.com','Z7cT5xW1'),(31,'Eduarda Melo','eduarda.melo@gmail.com','T8vL2xP4'),(32,'Felipe Nogueira','felipe.nogueira@gmail.com','X9sA6rW2'),(33,'Giovanna Cardoso','giovanna.cardoso@gmail.com','L3zK5nT7'),(34,'Henrique Barros','henrique.barros@gmail.com','N1mP7vY8'),(35,'Isabela Neves','isabela.neves@gmail.com','C5xD3wA9'),(36,'Jonas Batista','jonas.batista@gmail.com','Q7rT1mX4'),(37,'Karen Lopes','karen.lopes@gmail.com','F9aW8pN2'),(38,'Lucas Moraes','lucas.moraes@gmail.com','D6zK4vT5'),(39,'Mariana Castro','mariana.castro@gmail.com','B8yN3cW6'),(40,'Nicolas Ferreira','nicolas.ferreira@gmail.com','V2pX5rM7'),(41,'Olívia Rocha','olivia.rocha@gmail.com','E4wL9aT3'),(42,'Pedro Albuquerque','pedro.albuquerque@gmail.com','Y6nM2zP9'),(43,'Quintino da Silva','quintino.silva@gmail.com','J5rT8cL2'),(44,'Renata Lima','renata.lima@gmail.com','G1pW3xV6'),(45,'Samuel Martins','samuel.martins@gmail.com','U9aK7nP1'),(46,'Talita Fernandes','talita.fernandes@gmail.com','K3mT6yX5'),(47,'Ubirajara Nunes','ubirajara.nunes@gmail.com','M8zP1rL4'),(48,'Vitória Meireles','vitoria.meireles@gmail.com','W2dK9xC7'),(49,'Washington Faria','washington.faria@gmail.com','A4tN5mV3'),(50,'Ximena Oliveira','ximena.oliveira@gmail.com','H6vP8zW2'),(51,'Yuri Guimarães','yuri.guimaraes@gmail.com','P7lT3cX9'),(52,'Zuleica Borges','zuleica.borges@gmail.com','S3wN2pK8'),(53,'Adriano Paiva','adriano.paiva@gmail.com','N9xV4rL1'),(54,'Bianca Assunção','bianca.assuncao@gmail.com','C2zM6pT4'),(55,'Cícero Ramos','cicero.ramos@gmail.com','F8tL7xY3'),(56,'Daniel Mota','daniel.mota@gmail.com','Q1pK3rW5'),(57,'Eliane Queiroz','eliane.queiroz@gmail.com','Z6nW2xC8'),(58,'Fabrício Peixoto','fabricio.peixoto@gmail.com','M3rL9pT2'),(59,'Gustavo Tavares','gustavo.tavares@gmail.com','E5xP7nV6'),(60,'Heloísa Duarte','heloisa.duarte@gmail.com','T9mK1yW4');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
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
