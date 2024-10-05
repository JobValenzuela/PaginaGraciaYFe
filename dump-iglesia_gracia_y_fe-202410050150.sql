-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: iglesia_gracia_y_fe
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `consejerias`
--

DROP TABLE IF EXISTS `consejerias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consejerias` (
  `id_consejeria` bigint NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `lugar_consejeria` varchar(255) DEFAULT NULL,
  `hora_consejeria` time DEFAULT NULL,
  `id_miembro` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_consejeria`),
  KEY `id_miembro` (`id_miembro`),
  CONSTRAINT `consejerias_ibfk_1` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consejerias`
--

LOCK TABLES `consejerias` WRITE;
/*!40000 ALTER TABLE `consejerias` DISABLE KEYS */;
INSERT INTO `consejerias` VALUES (2,'2024-09-24','Consejeria de prueba','2024-11-09','Cuauhtemoc','21:22:00',17,'2024-09-25 06:32:53','2024-10-02 10:22:37'),(3,'2024-07-08','Consejeria de prueba 2','2025-01-09','Iglesia Gracia y fe','21:00:00',1,'2024-10-02 10:23:41','2024-10-02 10:23:41'),(4,'2024-10-23','pruebas de consejeria 32','2024-10-04','Casa de Sergio','20:00:00',2,'2024-10-02 10:24:24','2024-10-02 10:24:24'),(5,'2024-10-01','Consejeria de jovenes','2024-11-10','Cafe Colombia','20:00:00',16,'2024-10-02 10:25:07','2024-10-02 10:25:07'),(6,'2024-01-23','Consejeria individual','2024-10-01','Cafe junto al estadio','12:25:00',17,'2024-10-02 10:25:46','2024-10-02 10:25:46');
/*!40000 ALTER TABLE `consejerias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `publicidad` varchar(255) NOT NULL,
  `costo` float DEFAULT NULL,
  `id_miembro_encargado` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_miembro_encargado` (`id_miembro_encargado`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_miembro_encargado`) REFERENCES `miembros` (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Evento de prueba 2','reeggreg','2024-10-05','23:00:00','Anahuac','wejkrfgnlsnrel',253,1,'2024-09-19 14:02:04','2024-09-19 16:33:47'),(2,'Prueba','Evento de prueba','2004-12-12','12:24:00','Cuauhtemoc','524564ergv',NULL,1,'2024-09-19 16:34:34','2024-09-19 16:34:34');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `familias`
--

DROP TABLE IF EXISTS `familias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `familias` (
  `id_familia` bigint NOT NULL AUTO_INCREMENT,
  `nombre_familia` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_familia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `familias`
--

LOCK TABLES `familias` WRITE;
/*!40000 ALTER TABLE `familias` DISABLE KEYS */;
INSERT INTO `familias` VALUES (1,'HIJINIO','2024-09-19 07:24:52','2024-09-19 07:24:52'),(2,'VALENZUELA ORTIZ','2024-09-19 07:25:55','2024-09-25 05:15:18');
/*!40000 ALTER TABLE `familias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos_egresos`
--

DROP TABLE IF EXISTS `ingresos_egresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingresos_egresos` (
  `id_ingreso_egreso` bigint NOT NULL AUTO_INCREMENT,
  `tipo` enum('I','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cantidad` float NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL COMMENT 'Esta es la fecha del ingreso o egreso',
  `id_usuario` bigint DEFAULT NULL COMMENT 'Esta es la referencia de que usuario genera el registro',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_ingreso_egreso`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `ingresos_egresos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos_egresos`
--

LOCK TABLES `ingresos_egresos` WRITE;
/*!40000 ALTER TABLE `ingresos_egresos` DISABLE KEYS */;
INSERT INTO `ingresos_egresos` VALUES (1,'I','OFRENDAS',12.56,'OFRENDAS descripcion','2024-09-30',1,'2024-10-01 01:49:50','2024-10-01 02:09:07'),(2,'E','PAGO DE CFE',1259.36,'PAGO DE CFE descripcion','2024-09-12',1,'2024-10-01 01:51:27','2024-10-01 01:51:27'),(3,'E','PAGO JMAS',1250.23,NULL,'2024-02-13',1,'2024-10-02 05:09:04','2024-10-02 05:09:04'),(4,'E','PAGO JMAS',1250.23,NULL,'2024-04-13',1,'2024-10-02 05:09:13','2024-10-02 05:09:13'),(5,'E','PAGO JMAS',1250.23,NULL,'2024-06-13',1,'2024-10-02 05:09:16','2024-10-02 05:09:16'),(6,'E','PAGO CFE',2530.36,NULL,'2024-02-13',1,'2024-10-02 05:09:40','2024-10-02 05:09:40'),(7,'E','PAGO CFE',2530.36,NULL,'2024-04-13',1,'2024-10-02 05:09:45','2024-10-02 05:09:45'),(8,'E','PAGO CFE',230.36,NULL,'2023-12-13',1,'2024-10-02 05:10:03','2024-10-02 05:10:03'),(9,'I','OFRENDAS',900,NULL,'2023-12-13',1,'2024-10-02 05:10:32','2024-10-02 05:10:32'),(10,'I','OFRENDAS',92360,NULL,'2024-01-12',1,'2024-10-02 05:10:52','2024-10-02 05:10:52'),(11,'I','OFRENDAS',2360,NULL,'2024-01-23',1,'2024-10-02 05:11:16','2024-10-02 05:11:16'),(12,'I','OFRENDAS',260,NULL,'2024-01-31',1,'2024-10-02 05:11:25','2024-10-02 05:11:25'),(13,'I','DONACION',2000,NULL,'2024-04-30',1,'2024-10-02 05:12:12','2024-10-02 05:12:12');
/*!40000 ALTER TABLE `ingresos_egresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lideres_ministerios`
--

DROP TABLE IF EXISTS `lideres_ministerios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lideres_ministerios` (
  `id_lider_ministerio` bigint NOT NULL AUTO_INCREMENT,
  `id_miembro` bigint NOT NULL,
  `id_ministerio` bigint NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_lider_ministerio`),
  KEY `id_miembro` (`id_miembro`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `lideres_ministerios_ibfk_1` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`),
  CONSTRAINT `lideres_ministerios_ibfk_2` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lideres_ministerios`
--

LOCK TABLES `lideres_ministerios` WRITE;
/*!40000 ALTER TABLE `lideres_ministerios` DISABLE KEYS */;
INSERT INTO `lideres_ministerios` VALUES (1,1,1,'2024-09-18',NULL,'2024-09-19 11:39:17','2024-09-19 11:39:17'),(2,2,2,'2019-09-01',NULL,'2024-09-19 13:02:15','2024-09-19 13:02:15'),(3,4,3,'2022-04-24',NULL,'2024-09-19 13:02:40','2024-09-19 13:02:40');
/*!40000 ALTER TABLE `lideres_ministerios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `miembros`
--

DROP TABLE IF EXISTS `miembros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `miembros` (
  `id_miembro` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `apellido_2` varchar(50) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_llego` date NOT NULL,
  `fecha_membresia` date DEFAULT NULL,
  `fecha_bautizmo` date DEFAULT NULL,
  `fecha_bautizmo_agua` date DEFAULT NULL,
  `fecha_bautizmo_espiritu_santo` date DEFAULT NULL,
  `etapa_discipulado_juan` varchar(1) DEFAULT NULL,
  `fecha_inicio_dicipulado_juan` date DEFAULT NULL,
  `fecha_fin_dicipulado_juan` date DEFAULT NULL,
  `etapa_discipulado_hacia_la_meta_1` varchar(1) DEFAULT NULL,
  `fecha_inicio_dicipulado_hacia_la_meta_1` date DEFAULT NULL,
  `fecha_fin_dicipulado_hacia_la_meta_1` date DEFAULT NULL,
  `etapa_discipulado_hacia_la_meta_2` varchar(1) DEFAULT NULL,
  `fecha_inicio_dicipulado_hacia_la_meta_2` date DEFAULT NULL,
  `fecha_fin_dicipulado_hacia_la_meta_2` date DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `miembros`
--

LOCK TABLES `miembros` WRITE;
/*!40000 ALTER TABLE `miembros` DISABLE KEYS */;
INSERT INTO `miembros` VALUES (1,'Job Eleazar Valenzuela Ortiz',NULL,'6255846799','Cahpultepec y 60','Miguel Sigala','2004-02-11','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-17 19:01:31','2024-09-19 12:49:24'),(2,'Sergio Alberto Higinio Grijalva',NULL,'6251609254','Allende','Circuito de Allende Col. Ciudadela','1992-07-16','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 11:43:09','2024-09-19 12:07:38'),(3,'Javier Aminadab Valenzuela Ortiz',NULL,'6251206447','Chapultepec','Miguel Sigala','2012-12-02','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 11:47:59','2024-09-19 12:10:24'),(4,'Mayra Ivonne Gonzalez Duran',NULL,'6251976127','Allende','Circuito Allende Col. Ciudadela','1992-07-23','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:15:14','2024-09-19 12:15:14'),(5,'Hilda Maribel Duran Ramos',NULL,'6251002521','Albarterra','Cto. Albaterra','1974-03-27','2020-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:26:26','2024-09-19 12:26:26'),(6,'Maribel Gonzalez Bustillos',NULL,'6251049001','Aquiles Cerdan','Cto Aquiles Cerdan Col. Ciudadela','1981-05-20','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:29:53','2024-09-19 12:29:53'),(7,'Elsa Cecilia Calzadillas Ledezma',NULL,'6255897685','Allende','Cto. Allende Col. Ciudadela','1990-08-18','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:32:05','2024-09-19 12:32:05'),(8,'Carlos Alonso Martinez Rodriguez',NULL,'6251199371','Allende','Cto. Allende Col. Ciudadela','1990-11-20','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:36:31','2024-09-19 12:36:31'),(9,'Eli Abimael Valenzuela ORtiz',NULL,'6251301937','Chapultepec','Miguel Sigala','2005-04-09','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:38:30','2024-09-19 12:38:30'),(10,'Sandra Aracely Estrada Estrada',NULL,'6255798488','4 y Oaxaca','Reforma','2006-05-16','2021-01-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:42:03','2024-09-19 12:42:03'),(11,'Maria de la Luz Portillo Gonzalez',NULL,'6251507626','Calle','Colonia','1938-03-03','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:44:20','2024-09-19 12:44:20'),(12,'Estefany Cobos Duran',NULL,'6251531551','Cto','Ciudadela','1996-11-12','2020-01-05','2024-09-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:47:45','2024-09-19 12:47:45'),(13,'Daniel Ortega',NULL,'6251087645','cto','Ciudadela','1996-08-15','2020-01-01','2024-09-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:52:48','2024-09-19 12:52:48'),(14,'Evelyn Mendoza',NULL,'6251975035','calle','colonia','2004-09-06','2024-08-08','2024-09-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 12:58:10','2024-09-19 12:58:10'),(15,'Obed Alexis Ijinio Gonzalez',NULL,'6251101823','Allende','Cto Allende Col. Ciudadela','2008-10-20','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 13:06:38','2024-09-19 13:06:38'),(16,'Javier Rodolfo Valenzuela Galdean',NULL,'6251201841','Chapultepec','Miguel Sigala','1983-02-27','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 13:10:30','2024-09-19 13:10:30'),(17,'Oneida Amanda Ortiz Tello',NULL,'6251059476','Chapultepec','Miguel Sigala','1985-09-24','2019-09-01','2022-04-24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-09-19 13:11:39','2024-09-19 13:11:39');
/*!40000 ALTER TABLE `miembros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `miembros_familia`
--

DROP TABLE IF EXISTS `miembros_familia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `miembros_familia` (
  `id_miembro_familia` bigint NOT NULL AUTO_INCREMENT,
  `id_familia` bigint NOT NULL,
  `id_miembro` bigint NOT NULL,
  `rol_en_familia` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_miembro_familia`),
  KEY `id_familia` (`id_familia`),
  KEY `id_miembro` (`id_miembro`),
  CONSTRAINT `miembros_familia_ibfk_1` FOREIGN KEY (`id_familia`) REFERENCES `familias` (`id_familia`),
  CONSTRAINT `miembros_familia_ibfk_2` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `miembros_familia`
--

LOCK TABLES `miembros_familia` WRITE;
/*!40000 ALTER TABLE `miembros_familia` DISABLE KEYS */;
INSERT INTO `miembros_familia` VALUES (3,2,9,'HIJO','2024-09-19 07:35:18','2024-09-19 07:35:18'),(4,2,16,'PADRE','2024-09-19 07:35:29','2024-09-19 07:35:29'),(5,2,17,'MADRE','2024-09-19 07:35:44','2024-09-19 07:35:44'),(6,1,2,'PADRE','2024-10-01 01:58:23','2024-10-01 01:58:23'),(7,1,4,'MADRE','2024-10-01 01:58:36','2024-10-01 01:58:36');
/*!40000 ALTER TABLE `miembros_familia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ministerios`
--

DROP TABLE IF EXISTS `ministerios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ministerios` (
  `id_ministerio` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_ministerio`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministerios`
--

LOCK TABLES `ministerios` WRITE;
/*!40000 ALTER TABLE `ministerios` DISABLE KEYS */;
INSERT INTO `ministerios` VALUES (1,'Alabanza','Musica','2024-09-17 19:00:37','2024-09-19 12:59:36'),(2,'Tesorero','encargado de las finanzas','2024-09-19 13:00:05','2024-09-19 13:00:05'),(3,'Infantil','Niños','2024-09-19 13:00:29','2024-09-19 13:00:29'),(4,'Copastores','conjunto a pastores','2024-09-19 13:13:41','2024-09-19 13:13:41'),(5,'Pastor','Lideres principales de la Iglesia','2024-09-19 13:14:07','2024-09-19 13:14:48'),(6,'Visitantes','Encargados de darle seguimiento a los visitantes','2024-09-19 13:14:07','2024-09-19 13:14:07');
/*!40000 ALTER TABLE `ministerios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mobiliario`
--

DROP TABLE IF EXISTS `mobiliario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mobiliario` (
  `id_mobiliario` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `cantidad` float NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_miembro_encargado` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_mobiliario`),
  KEY `mobiliario_miembros_FK` (`id_miembro_encargado`),
  CONSTRAINT `mobiliario_miembros_FK` FOREIGN KEY (`id_miembro_encargado`) REFERENCES `miembros` (`id_miembro`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mobiliario`
--

LOCK TABLES `mobiliario` WRITE;
/*!40000 ALTER TABLE `mobiliario` DISABLE KEYS */;
INSERT INTO `mobiliario` VALUES (1,'Bateria',2,'Bateria completa',2,'2024-10-05 14:47:09','2024-10-05 14:49:33');
/*!40000 ALTER TABLE `mobiliario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participantes_ministerios`
--

DROP TABLE IF EXISTS `participantes_ministerios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participantes_ministerios` (
  `id_participante_ministerio` bigint NOT NULL AUTO_INCREMENT,
  `id_miembro` bigint NOT NULL,
  `id_ministerio` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_participante_ministerio`),
  KEY `id_miembro` (`id_miembro`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `participantes_ministerios_ibfk_1` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`),
  CONSTRAINT `participantes_ministerios_ibfk_2` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participantes_ministerios`
--

LOCK TABLES `participantes_ministerios` WRITE;
/*!40000 ALTER TABLE `participantes_ministerios` DISABLE KEYS */;
INSERT INTO `participantes_ministerios` VALUES (2,2,1,'2024-09-17 19:01:31'),(6,10,1,'2024-09-19 13:03:14'),(7,15,1,'2024-09-19 13:06:51'),(8,7,3,'2024-09-19 13:07:20'),(9,10,3,'2024-09-19 13:07:30'),(10,1,3,'2024-09-19 13:07:38'),(11,2,3,'2024-09-19 13:09:05'),(12,16,5,'2024-09-19 13:14:32'),(13,17,5,'2024-09-19 13:15:00');
/*!40000 ALTER TABLE `participantes_ministerios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `id_permiso` bigint NOT NULL AUTO_INCREMENT,
  `clave_permiso` varchar(40) NOT NULL,
  `nombre_publico` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `clave_permiso` (`clave_permiso`),
  UNIQUE KEY `nombre_publico` (`nombre_publico`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,'ADMIN','administrador','2024-10-02 02:24:58','2024-10-02 02:24:58');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos_roles`
--

DROP TABLE IF EXISTS `permisos_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos_roles` (
  `id_permiso_rol` bigint NOT NULL AUTO_INCREMENT,
  `id_rol` bigint NOT NULL,
  `id_permiso` bigint NOT NULL,
  PRIMARY KEY (`id_permiso_rol`),
  KEY `permisos_roles_roles_FK` (`id_rol`),
  KEY `permisos_roles_permisos_FK` (`id_permiso`),
  CONSTRAINT `permisos_roles_permisos_FK` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`),
  CONSTRAINT `permisos_roles_roles_FK` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos_roles`
--

LOCK TABLES `permisos_roles` WRITE;
/*!40000 ALTER TABLE `permisos_roles` DISABLE KEYS */;
INSERT INTO `permisos_roles` VALUES (1,1,1);
/*!40000 ALTER TABLE `permisos_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas_consejerias`
--

DROP TABLE IF EXISTS `personas_consejerias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas_consejerias` (
  `id_persona_consejeria` bigint NOT NULL AUTO_INCREMENT,
  `id_consejeria` bigint NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `observaciones_persona` text NOT NULL,
  `foto_expediente_clinico` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_persona_consejeria`),
  KEY `personas_consejerias_consejerias_FK` (`id_consejeria`),
  CONSTRAINT `personas_consejerias_consejerias_FK` FOREIGN KEY (`id_consejeria`) REFERENCES `consejerias` (`id_consejeria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas_consejerias`
--

LOCK TABLES `personas_consejerias` WRITE;
/*!40000 ALTER TABLE `personas_consejerias` DISABLE KEYS */;
INSERT INTO `personas_consejerias` VALUES (1,2,'Juan Andres de la torre','2004-02-02','Direccion 1','1234567896','Tiene problemas familiares','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(2,2,'Sanccho Panza','2024-06-06','Direccion 2','2356891256','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(3,2,'Jesus Pelon','2021-06-08','Direccion 3','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(4,2,'Dani Nauhal','2006-03-03','Direccion 6','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(5,2,'Rudy Orozco','2008-02-02','Direccion 5','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(6,3,'Venustiano Carranza','1999-02-02','Direccion 123','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(7,4,'Maria Morelos ','1985-06-05','Direccion Juan','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(8,5,'Miguel Hidalgo','2000-08-09','Miguel Sigala','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(9,6,'Harry Potter','1999-07-10','Reforma','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58'),(10,6,'Hermione ','1993-03-08','Periodista','1254785693','No hay observaciones','foto.png','2024-10-02 02:24:58','2024-10-02 02:24:58');
/*!40000 ALTER TABLE `personas_consejerias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peticiones_oracion`
--

DROP TABLE IF EXISTS `peticiones_oracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peticiones_oracion` (
  `id_peticion_oracion` bigint NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `descripcion_peticion` text NOT NULL,
  `fecha_peticion` date NOT NULL,
  `listo` tinyint(1) NOT NULL,
  `id_ministerio` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_peticion_oracion`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `peticiones_oracion_ibfk_1` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peticiones_oracion`
--

LOCK TABLES `peticiones_oracion` WRITE;
/*!40000 ALTER TABLE `peticiones_oracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `peticiones_oracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registros_consejeria`
--

DROP TABLE IF EXISTS `registros_consejeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registros_consejeria` (
  `id_registro_consejeria` bigint NOT NULL AUTO_INCREMENT,
  `id_consejeria` bigint NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_registro_consejeria`),
  KEY `id_consejeria` (`id_consejeria`),
  CONSTRAINT `registros_consejeria_ibfk_1` FOREIGN KEY (`id_consejeria`) REFERENCES `consejerias` (`id_consejeria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registros_consejeria`
--

LOCK TABLES `registros_consejeria` WRITE;
/*!40000 ALTER TABLE `registros_consejeria` DISABLE KEYS */;
/*!40000 ALTER TABLE `registros_consejeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_rol` bigint NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2024-10-02 02:24:58','2024-10-02 02:24:58');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` bigint NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `id_miembro` bigint NOT NULL,
  `id_rol` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_roles_FK` (`id_rol`),
  KEY `usuarios_miembros_FK` (`id_miembro`),
  CONSTRAINT `usuarios_miembros_FK` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`),
  CONSTRAINT `usuarios_roles_FK` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','$2y$12$haoFPSWCONk93AxyRSF2m.bmr8dYxsBvctG.h9NlsjQ2B8t0h.M2a','0e6bdb04af42d8babc2a9323ffb35c8d143348d6f69760d62086d90c8238dc53',1,1,'2024-10-02 10:03:56','2024-10-02 11:34:25');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitante`
--

DROP TABLE IF EXISTS `visitante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitante` (
  `id_visitante` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_visita` date NOT NULL,
  `id_ministerio` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_visitante`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `visitante_ibfk_1` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitante`
--

LOCK TABLES `visitante` WRITE;
/*!40000 ALTER TABLE `visitante` DISABLE KEYS */;
INSERT INTO `visitante` VALUES (1,'Job Valenzuela','6255846799','2024-09-19',6,'2024-09-19 08:13:25','2024-09-19 08:13:25');
/*!40000 ALTER TABLE `visitante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'iglesia_gracia_y_fe'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-05  0:50:11
