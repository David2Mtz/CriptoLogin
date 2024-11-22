-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: turismo404
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad` (
  `idCategorias` int NOT NULL,
  `idDestino` int NOT NULL,
  `idLugar` int DEFAULT NULL,
  `nombre` longtext,
  `Hora_ini` time DEFAULT NULL,
  `Hora_fin` time DEFAULT NULL,
  `costo` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`idCategorias`,`idDestino`),
  KEY `idDestino_idx` (`idDestino`),
  CONSTRAINT `idCategorias2` FOREIGN KEY (`idCategorias`) REFERENCES `categorias` (`idCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idDestino` FOREIGN KEY (`idDestino`) REFERENCES `destino` (`idDestino`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `idCategorias` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) DEFAULT NULL,
  `Imagen` longtext,
  PRIMARY KEY (`idCategorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destino`
--

DROP TABLE IF EXISTS `destino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destino` (
  `idDestino` int NOT NULL AUTO_INCREMENT,
  `idItinerario` int NOT NULL,
  `nombreDestino` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`idDestino`),
  KEY `idItinerario_idx` (`idItinerario`),
  CONSTRAINT `idItinerario` FOREIGN KEY (`idItinerario`) REFERENCES `itinerario` (`idItinerario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destino`
--

LOCK TABLES `destino` WRITE;
/*!40000 ALTER TABLE `destino` DISABLE KEYS */;
/*!40000 ALTER TABLE `destino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favoritos` (
  `idFavoritos` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idLugar` int DEFAULT NULL,
  PRIMARY KEY (`idFavoritos`),
  KEY `idUsuario_idx` (`idUsuario`),
  CONSTRAINT `idUsuario3` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favoritos`
--

LOCK TABLES `favoritos` WRITE;
/*!40000 ALTER TABLE `favoritos` DISABLE KEYS */;
/*!40000 ALTER TABLE `favoritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formulario`
--

DROP TABLE IF EXISTS `formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formulario` (
  `idFormulario` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `NoViajeros` int DEFAULT NULL,
  `lugarOrigen` longtext,
  `lugarDestino` longtext,
  PRIMARY KEY (`idFormulario`),
  KEY `idUsuario_idx` (`idUsuario`),
  CONSTRAINT `idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formulario`
--

LOCK TABLES `formulario` WRITE;
/*!40000 ALTER TABLE `formulario` DISABLE KEYS */;
/*!40000 ALTER TABLE `formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial`
--

DROP TABLE IF EXISTS `historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial` (
  `idUsuario` int NOT NULL,
  `idFormulario` int NOT NULL,
  PRIMARY KEY (`idUsuario`,`idFormulario`),
  KEY `idFormulario_idx` (`idFormulario`),
  CONSTRAINT `idFormulario` FOREIGN KEY (`idFormulario`) REFERENCES `formulario` (`idFormulario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idUsuario2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial`
--

LOCK TABLES `historial` WRITE;
/*!40000 ALTER TABLE `historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itinerario`
--

DROP TABLE IF EXISTS `itinerario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itinerario` (
  `idItinerario` int NOT NULL AUTO_INCREMENT,
  `idFormulario` int NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idItinerario`),
  KEY `idFormulario_idx` (`idFormulario`),
  CONSTRAINT `idFormulario2` FOREIGN KEY (`idFormulario`) REFERENCES `formulario` (`idFormulario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itinerario`
--

LOCK TABLES `itinerario` WRITE;
/*!40000 ALTER TABLE `itinerario` DISABLE KEYS */;
/*!40000 ALTER TABLE `itinerario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferencias`
--

DROP TABLE IF EXISTS `preferencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preferencias` (
  `idUsuario` int NOT NULL,
  `idCategorias` int NOT NULL,
  `idSubCat` int DEFAULT NULL,
  `idSubSubCat` int DEFAULT NULL,
  PRIMARY KEY (`idUsuario`,`idCategorias`),
  KEY `idUsuario_idx` (`idUsuario`),
  KEY `idCategorias_idx` (`idCategorias`),
  CONSTRAINT `idCategorias` FOREIGN KEY (`idCategorias`) REFERENCES `categorias` (`idCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `idUsuario4` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferencias`
--

LOCK TABLES `preferencias` WRITE;
/*!40000 ALTER TABLE `preferencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `preferencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `NumCel` varchar(10) NOT NULL,
  `Pais` varchar(30) NOT NULL,
  `Biografia` longtext NOT NULL,
  `Nacimiento` date NOT NULL,
  `IMAGEN` text,
  `Genero` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `fec_creac` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Tazim','Sahab Gutierritos','0000000000','Mexico','Lorem ipsum dolor sit amet, consectetur adipiscing elit. \nDonec mollis faucibus ipsum, sed varius enim consequat nec. Mauris a mollis metus. Sed bibendum consequat justo nec pellentesque. Donec in bibendum turpis.','2000-08-22','https://www.google.com/url?sa=i&url=https%3A%2F%2Fes.wikipedia.org%2Fwiki%2FUsuario_%2528inform%25C3%25A1tica%2529&psig=AOvVaw23Kn-00ZX9gbhLU27XvAf5&ust=1730473581854000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCIiRzsvyuIkDFQAAAAAdAAAAABAE','Masculino','tazim@gnail.com','password','2024-10-31 09:26:24');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

ALTER TABLE formulario 
ADD COLUMN presupuesto DECIMAL(10, 2) not null;
ALTER TABLE formulario 
ADD COLUMN FechaIni  DATE not null;
ALTER TABLE formulario 
ADD COLUMN FechaFin DATE not null; 
ALTER TABLE usuario 
ADD COLUMN token VARCHAR(32), 
ADD COLUMN verificado TINYINT(1) DEFAULT 0;


ALTER TABLE formulario 
add column prioridadTranporte int,
add column presupuestoTranporte DECIMAL(10, 2),
add column tipoTransporte VARCHAR(32),
add column tipoCarretera VARCHAR(32);

ALTER TABLE formulario 
add column prioridadHospedaje int,
add column presupuestoHospedaje DECIMAL(10, 2),
add column distanciaHospedaje DECIMAL(10, 2);

CREATE TABLE Alojamiento (
    idAlojamiento INT AUTO_INCREMENT PRIMARY KEY,
    Tipo VARCHAR(100) NOT NULL
);


INSERT INTO Alojamiento (Tipo) VALUES ("Hotel"),
("Hostal"),
("Airbnb"),
("Casa de huespedes");

CREATE TABLE PreferenciaAlojamiento (
    idFormulario INT,
    idAlojamiento INT,
    PRIMARY KEY (idFormulario, idAlojamiento),
    FOREIGN KEY (idFormulario) REFERENCES formulario(idFormulario)
		    ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (idAlojamiento) REFERENCES alojamiento(idAlojamiento)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE establecimientosComida (
    idEstablecimiento INT AUTO_INCREMENT PRIMARY KEY,
    Tipo VARCHAR(100) NOT NULL
);


INSERT INTO establecimientosComida (Tipo) VALUES ("Restaurante"),
("Cocina económica"),
("Cadenas comerciales"),
("Comida tradicional");


CREATE TABLE PreferenciaComida (
    idFormulario INT,
    idEstablecimiento INT,
    PRIMARY KEY (idFormulario, idEstablecimiento),
    FOREIGN KEY (idFormulario) REFERENCES formulario(idFormulario)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (idEstablecimiento) REFERENCES establecimientosComida(idEstablecimiento)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE tipoActividades (
    idTipoActividades INT AUTO_INCREMENT PRIMARY KEY,
    Tipo VARCHAR(100) NOT NULL
);

INSERT INTO tipoActividades (Tipo) VALUES ("Convencionales"),
("curiosas");

CREATE TABLE PreferenciaTipoActividades (
    idFormulario INT,
    idTipoActividades INT,
    PRIMARY KEY (idFormulario, idTipoActividades),
    FOREIGN KEY (idFormulario) REFERENCES formulario(idFormulario)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (idTipoActividades) REFERENCES tipoActividades(idTipoActividades)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

ALTER TABLE usuario 
ADD COLUMN token_password VARCHAR(32), 
ADD COLUMN fec_creac_password DATETIME,
ADD COLUMN token_password_expiracion DATETIME;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-31  9:29:00
