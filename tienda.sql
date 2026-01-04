-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: tienda
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `carro`
--

DROP TABLE IF EXISTS `carro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carro` (
  `id_carro` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `id_talla` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id_carro`),
  KEY `id_producto` (`id_producto`),
  KEY `id_talla` (`id_talla`),
  KEY `carro_ibfk_3` (`id_usuario`),
  CONSTRAINT `carro_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `carro_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `talla` (`id_talla`),
  CONSTRAINT `carro_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carro`
--

LOCK TABLES `carro` WRITE;
/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datos_usuario`
--

DROP TABLE IF EXISTS `datos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datos_usuario` (
  `id_datos` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `poblacion` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `codigo_postal` int DEFAULT NULL,
  `telefono` int NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_datos`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_usuario`
--

LOCK TABLES `datos_usuario` WRITE;
/*!40000 ALTER TABLE `datos_usuario` DISABLE KEYS */;
INSERT INTO `datos_usuario` VALUES (1,1,'Luis','Sosa García','08967455P','Calle sin salida 8',NULL,NULL,NULL,666666666,'luis@gmail.com'),(12,13,'Juan','Sosa Garcia','07253644L','Calle Juan XXIII 14','Tomares','Sevilla',78965,987456321,'juan@gmail.com');
/*!40000 ALTER TABLE `datos_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_de_compras`
--

DROP TABLE IF EXISTS `historial_de_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_de_compras` (
  `id_compras` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `id_talla` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_compras`),
  KEY `id_producto` (`id_producto`),
  KEY `id_talla` (`id_talla`),
  KEY `historial_de_compras_ibfk_3` (`id_usuario`),
  CONSTRAINT `historial_de_compras_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `historial_de_compras_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `talla` (`id_talla`),
  CONSTRAINT `historial_de_compras_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_de_compras`
--

LOCK TABLES `historial_de_compras` WRITE;
/*!40000 ALTER TABLE `historial_de_compras` DISABLE KEYS */;
INSERT INTO `historial_de_compras` VALUES (45,13,3,5,1,'2025-12-29 12:59:44',20.00,20.00);
/*!40000 ALTER TABLE `historial_de_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `precio` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Niki gladiator','30.00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac eleifend augue. Nullam et ultrices elit. Nullam nec turpis lorem.','fotos/foto1.png'),(2,'Odidas silver','30.00','Vivamus vehicula erat quis tristique elementum. Nullam sagittis felis quis dui tempus, id ullamcorper nibh faucibus.','fotos/foto2.jpg'),(3,'Isoc river','20.00','Phasellus semper, neque ut ultricies gravida, sem sem sagittis ipsum, nec consequat ex odio vitae mauris.','fotos/foto3.jpg'),(4,'Rotmen alua','45.50','Legestas nibh tincidunt a. Nam nec malesuada sem. Nulla dui libero, feugiat at lorem non, vestibulum sollicitudin lacus.','fotos/foto4.jpg'),(5,'Suin neg','80.00','Nam et facilisis tellus. Pellentesque tristique sem et diam feugiat, et accumsan tellus ultrices. Integer quis varius enim.','fotos/foto5.png'),(6,'Digmo tipl','15.95','Etiam mattis vestibulum efficitur. Maecenas in mauris et quam ullamcorper convallis.','fotos/foto6.jpg'),(7,'Godle ajrt','32.00','Integer at massa consequat, viverra ante at, auctor erat. Donec imperdiet lectus eu interdum dapibus.','fotos/foto7.jpg'),(8,'Rammu hermi','25.00','Vivamus vehicula erat quis tristique elementum. Nullam sagittis felis quis dui tempus, id ullamcorper nibh faucibus.','fotos/foto8.jpg'),(9,'Minti pro','22.50','Curabitur id ex congue, aliquam diam sed, malesuada sapien. Nullam luctus nunc eu faucibus venenatis. ','fotos/foto9.jpg'),(10,'Luktre II','36.00',' Proin facilisis elit ante, eu lobortis nibh porta pharetra. Mauris vitae gravida lectus. In porta sagittis tempor.','fotos/foto10.jpg'),(11,'Frilpo net','40.00','Etiam vitae lorem imperdiet, ornare elit eu, consequat velit. Maecenas laoreet malesuada est, nec placerat sem fringilla in.','fotos/foto11.jpg'),(12,'Zkm coolp','58.50','Sed aliquam interdum consectetur. Proin semper venenatis dui, id elementum velit laoreet vitae.','fotos/foto12.jpg'),(13,'Bun klar','12.90','Integer venenatis vulputate urna quis commodo. Nam venenatis feugiat tincidunt.','fotos/foto13.jpg'),(14,'Reti S','23.95','Nulla dui libero, feugiat at lorem non, vestibulum sollicitudin lacus. Donec vel finibus ante. Pellentesque risus urna, blandit quis finibus nec, facilisis in orci.','fotos/foto17.png'),(15,'Listra vor','18.00','Pellentesque luctus neque nec dui consectetur facilisis. Curabitur purus erat, sollicitudin a condimentum a, vulputate in neque.','fotos/foto15.png'),(16,'Jues kkk','29.50',' Nunc luctus libero ullamcorper odio vehicula ullamcorper. Integer at massa consequat, viverra ante at, auctor erat. ','fotos/foto16.png');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_talla`
--

DROP TABLE IF EXISTS `producto_talla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_talla` (
  `id_producto` int DEFAULT NULL,
  `id_talla` int DEFAULT NULL,
  `stock` int DEFAULT NULL,
  KEY `id_talla` (`id_talla`),
  KEY `producto_talla_ibfk_1` (`id_producto`),
  CONSTRAINT `producto_talla_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  CONSTRAINT `producto_talla_ibfk_2` FOREIGN KEY (`id_talla`) REFERENCES `talla` (`id_talla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_talla`
--

LOCK TABLES `producto_talla` WRITE;
/*!40000 ALTER TABLE `producto_talla` DISABLE KEYS */;
INSERT INTO `producto_talla` VALUES (1,1,9),(1,2,18),(1,3,6),(1,4,18),(1,5,0),(1,6,0),(1,7,7),(1,8,14),(1,9,18),(2,1,13),(2,2,13),(2,3,1),(2,4,12),(2,5,10),(2,6,0),(2,7,10),(2,8,4),(2,9,0),(3,1,0),(3,2,0),(3,3,0),(3,4,1),(3,5,0),(3,6,6),(3,7,13),(3,8,7),(3,9,0),(4,1,20),(4,2,0),(4,3,17),(4,4,0),(4,5,6),(4,6,12),(4,7,0),(4,8,1),(4,9,1),(5,1,8),(5,2,13),(5,3,12),(5,4,0),(5,5,8),(5,6,15),(5,7,11),(5,8,15),(5,9,1),(6,1,9),(6,2,8),(6,3,20),(6,4,4),(6,5,0),(6,6,20),(6,7,10),(6,8,16),(6,9,9),(7,1,0),(7,2,7),(7,3,21),(7,4,4),(7,5,10),(7,6,17),(7,7,17),(7,8,17),(7,9,20),(8,1,30),(8,2,0),(8,3,0),(8,4,0),(8,5,10),(8,6,15),(8,7,1),(8,8,20),(8,9,11),(9,1,40),(9,2,10),(9,3,26),(9,4,24),(9,5,19),(9,6,10),(9,7,0),(9,8,1),(9,9,7),(10,1,19),(10,2,1),(10,3,18),(10,4,20),(10,5,0),(10,6,0),(10,7,20),(10,8,0),(10,9,9),(11,1,12),(11,2,17),(11,3,14),(11,4,12),(11,5,3),(11,6,1),(11,7,3),(11,8,0),(11,9,5),(12,1,15),(12,2,18),(12,3,1),(12,4,10),(12,5,2),(12,6,0),(12,7,22),(12,8,9),(12,9,10),(13,1,1),(13,2,9),(13,3,1),(13,4,0),(13,5,1),(13,6,0),(13,7,1),(13,8,17),(13,9,0),(14,1,0),(14,2,27),(14,3,0),(14,4,0),(14,5,18),(14,6,1),(14,7,22),(14,8,18),(14,9,16),(15,1,1),(15,2,21),(15,3,10),(15,4,20),(15,5,21),(15,6,10),(15,7,10),(15,8,15),(15,9,15),(16,1,17),(16,2,20),(16,3,20),(16,4,10),(16,5,24),(16,6,1),(16,7,10),(16,8,19),(16,9,9);
/*!40000 ALTER TABLE `producto_talla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_del_rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'administrador'),(2,'cliente');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `talla`
--

DROP TABLE IF EXISTS `talla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `talla` (
  `id_talla` int NOT NULL AUTO_INCREMENT,
  `talla` varchar(5) NOT NULL,
  PRIMARY KEY (`id_talla`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `talla`
--

LOCK TABLES `talla` WRITE;
/*!40000 ALTER TABLE `talla` DISABLE KEYS */;
INSERT INTO `talla` VALUES (1,'36'),(2,'37'),(3,'38'),(4,'39'),(5,'40'),(6,'41'),(7,'42'),(8,'43'),(9,'44');
/*!40000 ALTER TABLE `talla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `contraseña` (`contrasena`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'luissosa','$2y$10$uUZWKTDnOELxFYtoyrwU8OOF2qRax5DnKihuov1wyY6SXcKBWVRRq'),(13,'Juan','$2y$10$ennDo2X4cbXPerP6TBACi.3biP1BWjAqBgwp6OcTgaTLatRYXrtNa');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_rol`
--

DROP TABLE IF EXISTS `usuario_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_rol` (
  `id_rol` int DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  KEY `id_rol` (`id_rol`),
  KEY `fk_usuario_rol` (`id_usuario`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_rol`
--

LOCK TABLES `usuario_rol` WRITE;
/*!40000 ALTER TABLE `usuario_rol` DISABLE KEYS */;
INSERT INTO `usuario_rol` VALUES (1,1),(2,13);
/*!40000 ALTER TABLE `usuario_rol` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-29 15:23:39
