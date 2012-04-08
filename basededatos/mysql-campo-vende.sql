-- MySQL dump 10.13  Distrib 5.1.61, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: biendecampo
-- ------------------------------------------------------
-- Server version	5.1.61-0ubuntu0.11.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `atomic_photo_albums`
--

DROP TABLE IF EXISTS `atomic_photo_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomic_photo_albums` (
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomic_photo_albums`
--

LOCK TABLES `atomic_photo_albums` WRITE;
/*!40000 ALTER TABLE `atomic_photo_albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `atomic_photo_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomic_photo_comments`
--

DROP TABLE IF EXISTS `atomic_photo_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomic_photo_comments` (
  `tof_ID` int(11) DEFAULT NULL,
  `content` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` tinytext,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomic_photo_comments`
--

LOCK TABLES `atomic_photo_comments` WRITE;
/*!40000 ALTER TABLE `atomic_photo_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `atomic_photo_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomic_photo_photos`
--

DROP TABLE IF EXISTS `atomic_photo_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomic_photo_photos` (
  `album_ID` int(11) DEFAULT NULL,
  `filename` text,
  `nb_comments` int(11) DEFAULT NULL,
  `nb_views` int(11) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  `fecha_publicacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomic_photo_photos`
--

LOCK TABLES `atomic_photo_photos` WRITE;
/*!40000 ALTER TABLE `atomic_photo_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `atomic_photo_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomic_photo_users`
--

DROP TABLE IF EXISTS `atomic_photo_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomic_photo_users` (
  `nickname` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomic_photo_users`
--

LOCK TABLES `atomic_photo_users` WRITE;
/*!40000 ALTER TABLE `atomic_photo_users` DISABLE KEYS */;
INSERT INTO `atomic_photo_users` VALUES ('alejandro','polopatin',1,1),('martin','martin',1,2),('nicolas','nicolas',1,3);
/*!40000 ALTER TABLE `atomic_photo_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentariosxproductos`
--

DROP TABLE IF EXISTS `comentariosxproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentariosxproductos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_publicacion` date DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentariosxproductos`
--

LOCK TABLES `comentariosxproductos` WRITE;
/*!40000 ALTER TABLE `comentariosxproductos` DISABLE KEYS */;
INSERT INTO `comentariosxproductos` VALUES (5,'2012-04-18',1,3),(4,'2012-04-18',1,3);
/*!40000 ALTER TABLE `comentariosxproductos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentariosxproductosxidioma`
--

DROP TABLE IF EXISTS `comentariosxproductosxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentariosxproductosxidioma` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idioma` varchar(2) NOT NULL DEFAULT '',
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `comentario` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentariosxproductosxidioma`
--

LOCK TABLES `comentariosxproductosxidioma` WRITE;
/*!40000 ALTER TABLE `comentariosxproductosxidioma` DISABLE KEYS */;
INSERT INTO `comentariosxproductosxidioma` VALUES (4,'es','Alesito','alejandro_hotmail.com','<p>hola</p>'),(5,'es','alesito2','alejandro_hotmail.com','<p>todo bien?</p>');
/*!40000 ALTER TABLE `comentariosxproductosxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentariosxsecciones`
--

DROP TABLE IF EXISTS `comentariosxsecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentariosxsecciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_publicacion` date DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentariosxsecciones`
--

LOCK TABLES `comentariosxsecciones` WRITE;
/*!40000 ALTER TABLE `comentariosxsecciones` DISABLE KEYS */;
INSERT INTO `comentariosxsecciones` VALUES (1,'2012-04-17',1,11),(2,'2012-04-17',1,11);
/*!40000 ALTER TABLE `comentariosxsecciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentariosxseccionesxidioma`
--

DROP TABLE IF EXISTS `comentariosxseccionesxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentariosxseccionesxidioma` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idioma` varchar(2) NOT NULL DEFAULT '',
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `comentario` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentariosxseccionesxidioma`
--

LOCK TABLES `comentariosxseccionesxidioma` WRITE;
/*!40000 ALTER TABLE `comentariosxseccionesxidioma` DISABLE KEYS */;
INSERT INTO `comentariosxseccionesxidioma` VALUES (1,'es','Alesito','alejandro_hotmail.com','<p>hola como estas</p>'),(2,'es','Alesito','alejandro_hotmail.com','<p>hola como estas</p>');
/*!40000 ALTER TABLE `comentariosxseccionesxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `nombre_empresa` varchar(255) DEFAULT NULL,
  `dueno_empresa` varchar(255) DEFAULT NULL,
  `direccion_empresa` varchar(255) DEFAULT NULL,
  `telefono_empresa` varchar(15) DEFAULT NULL,
  `fax_empresa` varchar(15) DEFAULT NULL,
  `mail_empresa` varchar(30) DEFAULT NULL,
  `id` int(9) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES ('Campo-Vende.com.ar','Alejandro Doglioli','','','','alejandrodoglioli@gmail.com',0,'Todo lo relacionado con el campo<br> lo encontras en Campo-Vende.com.ar');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `idioma` varchar(2) DEFAULT NULL,
  `id_grupo_contacto` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enlaces`
--

DROP TABLE IF EXISTS `enlaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enlaces` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `url` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `descripcion` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `publicado` smallint(1) DEFAULT NULL,
  `orden` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enlaces`
--

LOCK TABLES `enlaces` WRITE;
/*!40000 ALTER TABLE `enlaces` DISABLE KEYS */;
INSERT INTO `enlaces` VALUES (1,'Alejandro Doglioli','http://www.alejandro-doglioli.com.ar','Sitio web oficial de Alejandro Doglioli',1,1),(5,'Coches y autos en Argentina','http://www.cochesargentina.com.ar','La guía más completa para conseguir tu auto usado o nuevo en Argentina.',1,2),(4,'Transporte de Hacienda El Furtivo','http://www.transporte-furtivo.com.ar','La empresa lider en el transporte de hacienda en Tres Arroyos.',1,3),(6,'Empleo en Argentina','http://www.empleo-argentina.com.ar','La guía más completa para conseguir empleo en Argentina.',1,4),(7,'Hoteles Baratos','http://www.hoteles-baratos.com.ar','La más completa guía de hoteles baratos en Argentina.',1,7),(8,'Rayaner vuelos','http://www.aeropuerto-barcelona.es/rayaner-vuelos-55.html','Rayaner vuelos',1,8),(9,'Ferries Europa','http://www.ferries-a.com','Reservá ya tu Ferrie a las principales ciudades Europeas',1,7),(10,'Recetas y menus','http://www.recetasymenus.com','Encuentra las recetas que estabas buscando.',1,8);
/*!40000 ALTER TABLE `enlaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feeds`
--

DROP TABLE IF EXISTS `feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feeds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feeds`
--

LOCK TABLES `feeds` WRITE;
/*!40000 ALTER TABLE `feeds` DISABLE KEYS */;
INSERT INTO `feeds` VALUES (1,1);
/*!40000 ALTER TABLE `feeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedsxidioma`
--

DROP TABLE IF EXISTS `feedsxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedsxidioma` (
  `id` int(11) unsigned NOT NULL,
  `idioma` varchar(2) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `fuente` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedsxidioma`
--

LOCK TABLES `feedsxidioma` WRITE;
/*!40000 ALTER TABLE `feedsxidioma` DISABLE KEYS */;
INSERT INTO `feedsxidioma` VALUES (1,'es','Clarin','http://www.clarin.com/rss/rural/','Clarin');
/*!40000 ALTER TABLE `feedsxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_contactos`
--

DROP TABLE IF EXISTS `grupos_contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_contactos`
--

LOCK TABLES `grupos_contactos` WRITE;
/*!40000 ALTER TABLE `grupos_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupos_contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idioma`
--

DROP TABLE IF EXISTS `idioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idioma` (
  `idioma` varchar(6) DEFAULT NULL,
  `nombre` text,
  `nombre_imagen` text,
  `orden` double DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idioma`
--

LOCK TABLES `idioma` WRITE;
/*!40000 ALTER TABLE `idioma` DISABLE KEYS */;
INSERT INTO `idioma` VALUES ('es','Español','es.png',1,1);
/*!40000 ALTER TABLE `idioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenesxnoticias`
--

DROP TABLE IF EXISTS `imagenesxnoticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenesxnoticias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `principio` int(1) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenesxnoticias`
--

LOCK TABLES `imagenesxnoticias` WRITE;
/*!40000 ALTER TABLE `imagenesxnoticias` DISABLE KEYS */;
INSERT INTO `imagenesxnoticias` VALUES (1,'Pensando-productores-Zona-Nucleo-significativas_CL','/images/noticias/Pensando-productores-Zona-Nucleo-significativas_CLAIMA20120204_0055_4.jpg',1,1,1),(2,'BUENA-COMPETIDORA-OCUPA-AMBIENTES-CHANCHO_CLAIMA20','/images/noticias/BUENA-COMPETIDORA-OCUPA-AMBIENTES-CHANCHO_CLAIMA20120121_0048_4.jpg',1,1,2),(3,'MORENO-PRODUCTOR-NOETINGER-CBA_CLAIMA20120121_0052','/images/noticias/MORENO-PRODUCTOR-NOETINGER-CBA_CLAIMA20120121_0052_4.jpg',1,1,3),(4,'NUTRITIVO-MATERIA-HACEN-ALIMENTO-CALIDAD_CLAIMA201','/images/noticias/NUTRITIVO-MATERIA-HACEN-ALIMENTO-CALIDAD_CLAIMA20120114_0035_4.jpg',1,1,4);
/*!40000 ALTER TABLE `imagenesxnoticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenesxproductos`
--

DROP TABLE IF EXISTS `imagenesxproductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenesxproductos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `principio` int(1) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenesxproductos`
--

LOCK TABLES `imagenesxproductos` WRITE;
/*!40000 ALTER TABLE `imagenesxproductos` DISABLE KEYS */;
INSERT INTO `imagenesxproductos` VALUES (1,'casa','/images/productos/1_P1030873.JPG',1,1,1),(2,'casa1','/images/productos/_P1030880.JPG',1,1,0),(6,'','/images/productos/9_',0,0,9),(8,'','/images/productos/3_',0,0,3),(9,'','/images/productos/7_',0,0,7);
/*!40000 ALTER TABLE `imagenesxproductos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenesxsecciones`
--

DROP TABLE IF EXISTS `imagenesxsecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenesxsecciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `principio` int(1) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenesxsecciones`
--

LOCK TABLES `imagenesxsecciones` WRITE;
/*!40000 ALTER TABLE `imagenesxsecciones` DISABLE KEYS */;
INSERT INTO `imagenesxsecciones` VALUES (1,'','/images/secciones/1_',0,0,1),(5,'','/images/secciones/3_',0,0,3),(4,'imagen1','/images/secciones/6_P1030875.JPG',1,1,6),(6,'imagen-2','/images/secciones/7_P1030926.JPG',1,1,7),(7,'imagen1','/images/secciones/11_P1030877.JPG',1,1,11);
/*!40000 ALTER TABLE `imagenesxsecciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id` int(11) DEFAULT NULL,
  `action` varchar(150) DEFAULT NULL,
  `path` text,
  `imagen_modulo` varchar(100) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `id_padre` tinyint(5) DEFAULT NULL,
  `orden` double DEFAULT NULL,
  `publica` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'albums','albums','category.png',0,0,1,1),(2,'listar_fotos','albums','product.png',0,0,2,1),(3,'secciones','secciones','option.png',1,0,3,1),(4,'listar_tiposeccion','secciones','calculate.png',1,0,4,0),(5,'listar_comentariosxsecciones','secciones','information.png',1,0,5,0),(7,'newsletters','newsletters','newsletter.png',1,0,7,0),(8,'listar_contactos','newsletters','mail.png',1,0,8,0),(9,'listar_grupos_contactos','newsletters','image.png',1,0,9,0),(10,'enlaces','enlaces','customer.png',1,0,10,1),(11,'noticias','noticias','report.png',1,0,11,1),(12,'listar_feeds','feeds','order.png',1,0,12,0),(6,'productos','productos','product.png',1,0,6,0),(13,'listar_comentariosxproductos','productos','product.png',1,0,13,0);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulosxidioma`
--

DROP TABLE IF EXISTS `modulosxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulosxidioma` (
  `id_modulo` int(11) DEFAULT NULL,
  `id_idioma` varchar(6) DEFAULT NULL,
  `nombre` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulosxidioma`
--

LOCK TABLES `modulosxidioma` WRITE;
/*!40000 ALTER TABLE `modulosxidioma` DISABLE KEYS */;
INSERT INTO `modulosxidioma` VALUES (1,'es','Albums'),(2,'es','Fotos'),(3,'es','Secciones'),(4,'es','Tipo Seccion'),(5,'es','Comentarios x Secciones'),(7,'es','Newsletters'),(8,'es','Contactos'),(9,'es','Grupos Contactos'),(10,'es','Enlaces'),(11,'es','Noticias'),(10,'en','Links'),(11,'en','News'),(10,'fr','Liens'),(11,'fr','Nouvelles'),(10,'it','Links'),(11,'it','News'),(10,'de','Links'),(11,'de','News'),(12,'es','Feeds'),(6,'es','Productos'),(13,'es','Comentarios x Productos');
/*!40000 ALTER TABLE `modulosxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `enviado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter`
--

LOCK TABLES `newsletter` WRITE;
/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletterxidioma`
--

DROP TABLE IF EXISTS `newsletterxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletterxidioma` (
  `id` int(10) unsigned NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `texto` text,
  `idioma` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletterxidioma`
--

LOCK TABLES `newsletterxidioma` WRITE;
/*!40000 ALTER TABLE `newsletterxidioma` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletterxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticias` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_publicacion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publicado` int(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (1,'2012-02-05 00:00:00',1,1),(2,'2012-02-05 00:00:00',1,1),(3,'2012-02-05 00:00:00',1,1),(4,'2012-02-05 00:00:00',1,1);
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticiasxidioma`
--

DROP TABLE IF EXISTS `noticiasxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticiasxidioma` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `headline` text,
  `noticia` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idioma` varchar(2) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticiasxidioma`
--

LOCK TABLES `noticiasxidioma` WRITE;
/*!40000 ALTER TABLE `noticiasxidioma` DISABLE KEYS */;
INSERT INTO `noticiasxidioma` VALUES (1,'El partido es difícil pero se puede empatar','Con las lluvias de esta semana, la soja y los maíces tardíos aun pueden rendir bien en muchos camp','Con las lluvias de esta semana, la soja y los maíces tardíos aun pueden rendir bien en muchos campos.<br /><br />Fuente: <a href=\"http://www.clarin.com/rural/partido-dificil-puede-empatar_0_640136040.html\" title=\"http://www.clarin.com/rural/partido-dificil-puede-empatar_0_640136040.html\" rel=\"nofollow\">http://www.clarin.com/rural/partido-dificil-puede-empatar_0_640136040.html</a>','NULL','es','Con las lluvias de esta semana, la soja y los maíces tardíos aun pueden rendir bien en muchos camp','El partido es difícil pero se puede empatar',''),(2,'Con la ganadería en la mira','La hacienda se viene arrinconando en los suelos marginales. Allí, la grama rhodes da pelea, aun con','La hacienda se viene arrinconando en los suelos marginales. Allí, la grama rhodes da pelea, aun con seca.<br /><br />Fuente: <a href=\"http://www.clarin.com/rural/ganaderia-mira_0_631736875.html\" title=\"http://www.clarin.com/rural/ganaderia-mira_0_631736875.html\" rel=\"nofollow\">http://www.clarin.com/rural/ganaderia-mira_0_631736875.html</a>','NULL','es','La hacienda se viene arrinconando en los suelos marginales. Allí, la grama rhodes da pelea, aun con','Con la ganadería en la mira',''),(3,'El manejo','','<br /><br />Fuente: <a href=\"http://www.clarin.com/rural/manejo_0_631736877.html\" title=\"http://www.clarin.com/rural/manejo_0_631736877.html\" rel=\"nofollow\">http://www.clarin.com/rural/manejo_0_631736877.html</a>','NULL','es','','El manejo',''),(4,'Seguro contra todo riesgo','Productores de varias zonas del país cuentan cómo el silo los ayuda a enfrentar los cíclicos per','Productores de varias zonas del país cuentan cómo el silo los ayuda a enfrentar los cíclicos períodos de sequía.<br /><br />Fuente: <a href=\"http://www.clarin.com/rural/Seguro-riesgo_0_627537278.html\" title=\"http://www.clarin.com/rural/Seguro-riesgo_0_627537278.html\" rel=\"nofollow\">http://www.clarin.com/rural/Seguro-riesgo_0_627537278.html</a>','NULL','es','Productores de varias zonas del país cuentan cómo el silo los ayuda a enfrentar los cíclicos per','Seguro contra todo riesgo','');
/*!40000 ALTER TABLE `noticiasxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_seccion` int(11) unsigned DEFAULT NULL,
  `id_usuario` int(11) unsigned DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,11,4,0,2,'0000-00-00','asas'),(3,11,3,1,0,'0000-00-00',''),(4,4,3,2,0,'0000-00-00',''),(5,4,3,2,0,'0000-00-00',''),(6,4,3,2,2,'0000-00-00',''),(7,4,3,0,2,'0000-00-00',''),(9,4,5,1,0,'0000-00-00',''),(10,2,0,1,0,'0000-00-00',''),(11,0,5,0,0,'0000-00-00',''),(12,2,0,1,0,'0000-00-00',''),(13,0,5,0,0,'0000-00-00','');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productosxidioma`
--

DROP TABLE IF EXISTS `productosxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productosxidioma` (
  `id` double NOT NULL,
  `idioma` varchar(6) NOT NULL,
  `contenido` text,
  `nombre` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productosxidioma`
--

LOCK TABLES `productosxidioma` WRITE;
/*!40000 ALTER TABLE `productosxidioma` DISABLE KEYS */;
INSERT INTO `productosxidioma` VALUES (0,'es','','','','',''),(1,'es','<p>esto es la prueba de mierda</p>','pruba','','',''),(3,'es','<p>hola esta es la descripcion de mierda</p>','producto3','','',''),(7,'es','','prueba2','','',''),(9,'es','','lote de vacas con ternero','','',''),(10,'es','','prueba','','',''),(11,'es','','p','','',''),(12,'es','','a','','',''),(13,'es','','','','','');
/*!40000 ALTER TABLE `productosxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secciones`
--

DROP TABLE IF EXISTS `secciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_padre` double DEFAULT NULL,
  `id_tiposeccion` int(11) NOT NULL DEFAULT '0',
  `publicado` tinyint(1) DEFAULT NULL,
  `menu_lateral` tinyint(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secciones`
--

LOCK TABLES `secciones` WRITE;
/*!40000 ALTER TABLE `secciones` DISABLE KEYS */;
INSERT INTO `secciones` VALUES (1,0,0,1,0,1,'2011-06-10',NULL),(2,0,0,1,1,2,'0000-00-00',NULL),(3,0,0,1,0,3,'0000-00-00',NULL),(4,0,0,1,1,1,'0000-00-00',NULL),(5,0,0,1,1,2,'0000-00-00',NULL),(6,0,0,1,1,1,'0000-00-00',''),(7,0,0,1,1,2,'0000-00-00',''),(8,0,0,1,1,0,'0000-00-00',NULL),(9,0,0,1,1,0,'0000-00-00',NULL),(10,0,0,1,1,0,'0000-00-00',NULL),(11,0,0,1,1,0,'0000-00-00','lAXCXa6UVkE'),(12,0,0,1,1,0,'0000-00-00','');
/*!40000 ALTER TABLE `secciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccionesxidioma`
--

DROP TABLE IF EXISTS `seccionesxidioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccionesxidioma` (
  `id` double NOT NULL,
  `idioma` varchar(6) NOT NULL,
  `contenido` text,
  `nombre` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccionesxidioma`
--

LOCK TABLES `seccionesxidioma` WRITE;
/*!40000 ALTER TABLE `seccionesxidioma` DISABLE KEYS */;
INSERT INTO `seccionesxidioma` VALUES (1,'es','<p>Martin comilon!!</p>','Home','','',''),(2,'es','','Empresas Transporte Cereales','','',''),(3,'es','<p>Mercados de hacienda</p>','Mercados','','',''),(4,'es','		<div id=\"cont_5668fb4d47dc41337586a912c2f1b34c\">\r\n		  <h2 id=\"h_5668fb4d47dc41337586a912c2f1b34c\"><a href=\"http://www.meteored.com.ar/\" title=\"El Tiempo\">El Tiempo</a><a id=\"a_5668fb4d47dc41337586a912c2f1b34c\" href=									\"http://www.meteored.com.ar/tiempo-en_Tandil-America+Sur-Argentina-Provincia+de+Buenos+Aires-SAZT-1-16924.html\" target=\"_blank\" title=\"El Tiempo en 	Tandil\" style=\"color:#808080;font-family:2;font-size:14px;\">El Tiempo en Tandil</a>\r\n		    <script type=\"text/javascript\" src=	\"http://www.meteored.com.ar/wid_loader/5668fb4d47dc41337586a912c2f1b34c\"></script>\r\n		  </h2>\r\n		  </div>\r\n','Clima','','',''),(5,'es','','Remates Hacienda','','',''),(6,'es','','Venta Campos','','',''),(7,'es','<p>Este lote de vaquillonas consta de <strong>35 vaquillonas Aerden Angus</strong>.</p>\r\n<p>Las mismas .. blba bla.</p>\r\n<!-- Video 1-->\r\n<p class=\"meta\">&nbsp;</p>\r\n<p class=\"meta\">Videos Hacienda</p>\r\n<div class=\"entry\">\r\n<p class=\"links\"><a href=\"#\" class=\"more\">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#\" class=\"comments\">Comments (33)</a></p>\r\n<iframe width=\"480\" height=\"390\" frameborder=\"0\" src=\"http://www.youtube.com/embed/xqdifFYWWmQ\" allowfullscreen=\"\"></iframe></div>\r\n<!-- Fin video-->','Venta Cereales','','',''),(8,'es','<p>Este lote de vaquillonas consta de <strong>35 vaquillonas Aerden Angus</strong>.</p>\r\n<p>Las mismas .. blba bla.</p>\r\n<!-- Video 1-->\r\n<p class=\"meta\">&nbsp;</p>\r\n<p class=\"meta\">Videos Hacienda</p>\r\n<div class=\"entry\">\r\n<p class=\"links\"><a href=\"#\" class=\"more\">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"#\" class=\"comments\">Comments (33)</a></p>\r\n<iframe width=\"480\" height=\"390\" frameborder=\"0\" src=\"http://www.youtube.com/embed/xqdifFYWWmQ\" allowfullscreen=\"\"></iframe></div>\r\n<!-- Fin video-->','Venta Maquinaria Agricola','','',''),(9,'es','','Venta Insumos Agropecuarios','','',''),(10,'es','','Empresas Transporte Hacienda','','',''),(11,'es','','Servicios Varios','','',''),(12,'es','','Compra-Venta Varias','','','');
/*!40000 ALTER TABLE `seccionesxidioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiposeccion`
--

DROP TABLE IF EXISTS `tiposeccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiposeccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiposeccion`
--

LOCK TABLES `tiposeccion` WRITE;
/*!40000 ALTER TABLE `tiposeccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `tiposeccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `passwd` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `crypt` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `aktiv` tinyint(4) NOT NULL DEFAULT '1',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `manager` tinyint(4) NOT NULL DEFAULT '0',
  `style` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'default',
  `lang` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT 'de',
  `expert` tinyint(4) DEFAULT '0',
  `siteid` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`passwd`,`aktiv`,`siteid`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='utf8_bin';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'alejandro','4f28417b46e7a61ebb5ee6ae1180f851','0$RI6n98.tTbI','ale_elaspero@hotmail.com',1224288775,1,1,1,'default','en',0,'tellmatic');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_sistema`
--

DROP TABLE IF EXISTS `usuarios_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL DEFAULT '',
  `apellido` varchar(30) DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(30) NOT NULL DEFAULT '',
  `domicilio` varchar(30) DEFAULT NULL,
  `ciudad` varchar(30) DEFAULT NULL,
  `provincia` varchar(30) DEFAULT '',
  `cp` varchar(6) DEFAULT '',
  `telefono` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `comercio` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_sistema`
--

LOCK TABLES `usuarios_sistema` WRITE;
/*!40000 ALTER TABLE `usuarios_sistema` DISABLE KEYS */;
INSERT INTO `usuarios_sistema` VALUES (2,'Alejandro','ab','alejandro','ab','maritorena','tandil','bs as','7000','1213','15631979',1),(4,'punieta','','a','','','','','','','',0),(3,'a','a','a','a','a','a','a','a','a','a',1),(5,'Martin','','ac','ab','','','','','','',0);
/*!40000 ALTER TABLE `usuarios_sistema` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-04-07 22:45:44
