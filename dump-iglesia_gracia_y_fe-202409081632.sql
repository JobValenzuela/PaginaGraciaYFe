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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consejerias`
--

/*!40000 ALTER TABLE `consejerias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_eventos` bigint NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `publicidad` varchar(255) NOT NULL,
  `costo` float DEFAULT NULL,
  `id_miembro_encargado` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_eventos`),
  KEY `id_miembro_encargado` (`id_miembro_encargado`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_miembro_encargado`) REFERENCES `miembros` (`id_miembro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
LOCK TABLES `familias` WRITE;
/*!40000 ALTER TABLE `familias` DISABLE KEYS */;
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
  `id_usuario` bigint NOT NULL COMMENT 'Esta es la referencia de que usuario genera el registro',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_ingreso_egreso`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `ingresos_egresos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos_egresos`
--

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
  `fecha_termino` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_lider_ministerio`),
  KEY `id_miembro` (`id_miembro`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `lideres_ministerios_ibfk_1` FOREIGN KEY (`id_miembro`) REFERENCES `miembros` (`id_miembro`),
  CONSTRAINT `lideres_ministerios_ibfk_2` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lideres_ministerios`
--

LOCK TABLES `lideres_ministerios` WRITE;
/*!40000 ALTER TABLE `lideres_ministerios` DISABLE KEYS */;
LOCK TABLES `miembros` WRITE;
/*!40000 ALTER TABLE `miembros` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `miembros_familia`
--

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
  `descripcion` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_ministerio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ministerios`
--

LOCK TABLES `ministerios` WRITE;
/*!40000 ALTER TABLE `ministerios` DISABLE KEYS */;
LOCK TABLES `mobiliario` WRITE;
/*!40000 ALTER TABLE `mobiliario` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participantes_ministerios`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
LOCK TABLES `permisos_roles` WRITE;
/*!40000 ALTER TABLE `permisos_roles` DISABLE KEYS */;
LOCK TABLES `personas_consejerias` WRITE;
/*!40000 ALTER TABLE `personas_consejerias` DISABLE KEYS */;
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
LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
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
  `nombre` varchar(50) NOT NULL,
  `apellido_1` varchar(50) NOT NULL,
  `apellido_2` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_visita` date NOT NULL,
  `id_ministerio` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_visitante`),
  KEY `id_ministerio` (`id_ministerio`),
  CONSTRAINT `visitante_ibfk_1` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerios` (`id_ministerio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitante`
--

LOCK TABLES `visitante` WRITE;
/*!40000 ALTER TABLE `visitante` DISABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-08 16:32:44
