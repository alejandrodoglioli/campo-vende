/*
SQLyog Community Edition- MySQL GUI v6.07
Host - 5.1.41-3ubuntu12.10 : Database - biendecampo
*********************************************************************
Server version : 5.1.41-3ubuntu12.10
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `biendecampo`;

USE `biendecampo`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `atomic_photo_albums` */

DROP TABLE IF EXISTS `atomic_photo_albums`;

CREATE TABLE `atomic_photo_albums` (
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `atomic_photo_albums` */

/*Table structure for table `atomic_photo_comments` */

DROP TABLE IF EXISTS `atomic_photo_comments`;

CREATE TABLE `atomic_photo_comments` (
  `tof_ID` int(11) DEFAULT NULL,
  `content` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` tinytext,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `atomic_photo_comments` */

/*Table structure for table `atomic_photo_photos` */

DROP TABLE IF EXISTS `atomic_photo_photos`;

CREATE TABLE `atomic_photo_photos` (
  `album_ID` int(11) DEFAULT NULL,
  `filename` text,
  `nb_comments` int(11) DEFAULT NULL,
  `nb_views` int(11) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  `fecha_publicacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `atomic_photo_photos` */

/*Table structure for table `atomic_photo_users` */

DROP TABLE IF EXISTS `atomic_photo_users`;

CREATE TABLE `atomic_photo_users` (
  `nickname` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `atomic_photo_users` */

insert  into `atomic_photo_users`(`nickname`,`password`,`is_admin`,`ID`) values ('alejandro','polopatin',1,1),('martin','martin',1,2);

/*Table structure for table `comentariosxsecciones` */

DROP TABLE IF EXISTS `comentariosxsecciones`;

CREATE TABLE `comentariosxsecciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_publicacion` date DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `comentariosxsecciones` */

/*Table structure for table `comentariosxseccionesxidioma` */

DROP TABLE IF EXISTS `comentariosxseccionesxidioma`;

CREATE TABLE `comentariosxseccionesxidioma` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idioma` varchar(2) NOT NULL DEFAULT '',
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `comentario` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `comentariosxseccionesxidioma` */

/*Table structure for table `configuracion` */

DROP TABLE IF EXISTS `configuracion`;

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

/*Data for the table `configuracion` */

insert  into `configuracion`(`nombre_empresa`,`dueno_empresa`,`direccion_empresa`,`telefono_empresa`,`fax_empresa`,`mail_empresa`,`id`,`slogan`) values ('mercampo.com.ar','Alejandro Doglioli','','','','alejandrodoglioli@gmail.com',0,'lo de \"merca\" no se refiere a la droga');

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `idioma` varchar(2) DEFAULT NULL,
  `id_grupo_contacto` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `contactos` */

/*Table structure for table `enlaces` */

DROP TABLE IF EXISTS `enlaces`;

CREATE TABLE `enlaces` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `url` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `descripcion` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `publicado` smallint(1) DEFAULT NULL,
  `orden` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `enlaces` */

insert  into `enlaces`(`id`,`titulo`,`url`,`descripcion`,`publicado`,`orden`) values (1,'Alejandro Doglioli','http://www.alejandro-doglioli.com.ar','Sitio web oficial de Alejandro Doglioli',1,1),(5,'Coches y autos en Argentina','http://www.cochesargentina.com.ar','La guía más completa para conseguir tu auto usado o nuevo en Argentina.',1,2),(4,'Transporte de Hacienda El Furtivo','http://www.transporte-furtivo.com.ar','La empresa lider en el transporte de hacienda en Tres Arroyos.',1,3),(6,'Empleo en Argentina','http://www.empleo-argentina.com.ar','La guía más completa para conseguir empleo en Argentina.',1,4),(7,'Hoteles Baratos','http://www.hoteles-baratos.com.ar','La más completa guía de hoteles baratos en Argentina.',1,7),(8,'Rayaner vuelos','http://www.aeropuerto-barcelona.es/rayaner-vuelos-55.html','Rayaner vuelos',1,8),(9,'Ferries Europa','http://www.ferries-a.com','Reservá ya tu Ferrie a las principales ciudades Europeas',1,7),(10,'Recetas y menus','http://www.recetasymenus.com','Encuentra las recetas que estabas buscando.',1,8);

/*Table structure for table `feeds` */

DROP TABLE IF EXISTS `feeds`;

CREATE TABLE `feeds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `feeds` */

/*Table structure for table `feedsxidioma` */

DROP TABLE IF EXISTS `feedsxidioma`;

CREATE TABLE `feedsxidioma` (
  `id` int(11) unsigned NOT NULL,
  `idioma` varchar(2) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `fuente` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `feedsxidioma` */

/*Table structure for table `grupos_contactos` */

DROP TABLE IF EXISTS `grupos_contactos`;

CREATE TABLE `grupos_contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `grupos_contactos` */

/*Table structure for table `idioma` */

DROP TABLE IF EXISTS `idioma`;

CREATE TABLE `idioma` (
  `idioma` varchar(6) DEFAULT NULL,
  `nombre` text,
  `nombre_imagen` text,
  `orden` double DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `idioma` */

insert  into `idioma`(`idioma`,`nombre`,`nombre_imagen`,`orden`,`publicado`) values ('es','Español','es.png',1,1);

/*Table structure for table `imagenesxnoticias` */

DROP TABLE IF EXISTS `imagenesxnoticias`;

CREATE TABLE `imagenesxnoticias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `principio` int(1) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_noticia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `imagenesxnoticias` */

/*Table structure for table `imagenesxsecciones` */

DROP TABLE IF EXISTS `imagenesxsecciones`;

CREATE TABLE `imagenesxsecciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `principio` int(1) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `imagenesxsecciones` */

insert  into `imagenesxsecciones`(`id`,`nombre`,`path`,`principio`,`publicado`,`id_seccion`) values (1,'','/images/secciones/1_',0,0,1),(2,'','/images/secciones/5_',0,0,5),(5,'','/images/secciones/3_',0,0,3),(4,'','/images/secciones/6_',0,0,6),(6,'','/images/secciones/7_',0,0,7);

/*Table structure for table `modulos` */

DROP TABLE IF EXISTS `modulos`;

CREATE TABLE `modulos` (
  `id` int(11) DEFAULT NULL,
  `action` varchar(150) DEFAULT NULL,
  `path` text,
  `imagen_modulo` varchar(100) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `id_padre` tinyint(5) DEFAULT NULL,
  `orden` double DEFAULT NULL,
  `publica` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `modulos` */

insert  into `modulos`(`id`,`action`,`path`,`imagen_modulo`,`habilitado`,`id_padre`,`orden`,`publica`) values (1,'albums','albums','category.png',0,0,1,1),(2,'listar_fotos','albums','product.png',0,0,2,1),(3,'secciones','secciones','option.png',1,0,3,1),(4,'listar_tiposeccion','secciones','calculate.png',1,0,4,0),(5,'listar_comentariosxsecciones','secciones','information.png',1,0,5,0),(6,'newsletters','newsletters','newsletter.png',1,0,6,0),(7,'listar_contactos','newsletters','mail.png',1,0,7,0),(8,'listar_grupos_contactos','newsletters','image.png',1,0,8,0),(9,'enlaces','enlaces','customer.png',1,0,9,1),(10,'noticias','noticias','report.png',1,0,10,1),(11,'listar_feeds','feeds','order.png',1,0,11,0);

/*Table structure for table `modulosxidioma` */

DROP TABLE IF EXISTS `modulosxidioma`;

CREATE TABLE `modulosxidioma` (
  `id_modulo` int(11) DEFAULT NULL,
  `id_idioma` varchar(6) DEFAULT NULL,
  `nombre` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `modulosxidioma` */

insert  into `modulosxidioma`(`id_modulo`,`id_idioma`,`nombre`) values (1,'es','Albums'),(2,'es','Fotos'),(3,'es','Secciones'),(4,'es','Tipo Seccion'),(5,'es','Comentarios x Secciones'),(6,'es','Newsletters'),(7,'es','Contactos'),(8,'es','Grupos Contactos'),(9,'es','Enlaces'),(10,'es','Noticias'),(9,'en','Links'),(10,'en','News'),(9,'fr','Liens'),(10,'fr','Nouvelles'),(9,'it','Links'),(10,'it','News'),(9,'de','Links'),(10,'de','News'),(11,'es','Feeds');

/*Table structure for table `newsletter` */

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `enviado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `newsletter` */

/*Table structure for table `newsletterxidioma` */

DROP TABLE IF EXISTS `newsletterxidioma`;

CREATE TABLE `newsletterxidioma` (
  `id` int(10) unsigned NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `texto` text,
  `idioma` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `newsletterxidioma` */

/*Table structure for table `noticias` */

DROP TABLE IF EXISTS `noticias`;

CREATE TABLE `noticias` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_publicacion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publicado` int(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `noticias` */

/*Table structure for table `noticiasxidioma` */

DROP TABLE IF EXISTS `noticiasxidioma`;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `noticiasxidioma` */

/*Table structure for table `secciones` */

DROP TABLE IF EXISTS `secciones`;

CREATE TABLE `secciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_padre` double DEFAULT NULL,
  `id_tiposeccion` int(11) NOT NULL DEFAULT '0',
  `publicado` tinyint(1) DEFAULT NULL,
  `menu_lateral` tinyint(1) DEFAULT NULL,
  `orden` tinyint(2) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `secciones` */

insert  into `secciones`(`id`,`id_padre`,`id_tiposeccion`,`publicado`,`menu_lateral`,`orden`,`fecha_publicacion`) values (1,0,0,1,0,1,'2011-06-10'),(2,0,0,1,0,2,'0000-00-00'),(3,0,0,1,0,3,'0000-00-00'),(4,0,0,1,1,1,'0000-00-00'),(5,0,0,1,1,2,'0000-00-00'),(6,4,0,1,1,1,'0000-00-00'),(7,4,0,1,1,2,'0000-00-00');

/*Table structure for table `seccionesxidioma` */

DROP TABLE IF EXISTS `seccionesxidioma`;

CREATE TABLE `seccionesxidioma` (
  `id` double NOT NULL,
  `idioma` varchar(6) NOT NULL,
  `contenido` text,
  `nombre` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `seccionesxidioma` */

insert  into `seccionesxidioma`(`id`,`idioma`,`contenido`,`nombre`,`description`,`keywords`,`title`) values (1,'es','<p>Martin comilon!!</p>','Home','','',''),(2,'es','<p>Mercados de hacienda</p>','Mercados','','',''),(3,'es','		<div id=\"cont_5668fb4d47dc41337586a912c2f1b34c\">\r\n		  <h2 id=\"h_5668fb4d47dc41337586a912c2f1b34c\"><a href=\"http://www.meteored.com.ar/\" title=\"El Tiempo\">El Tiempo</a><a id=\"a_5668fb4d47dc41337586a912c2f1b34c\" href=									\"http://www.meteored.com.ar/tiempo-en_Tandil-America+Sur-Argentina-Provincia+de+Buenos+Aires-SAZT-1-16924.html\" target=\"_blank\" title=\"El Tiempo en 	Tandil\" style=\"color:#808080;font-family:2;font-size:14px;\">El Tiempo en Tandil</a>\r\n		    <script type=\"text/javascript\" src=	\"http://www.meteored.com.ar/wid_loader/5668fb4d47dc41337586a912c2f1b34c\"></script>\r\n		  </h2>\r\n		  </div>\r\n','Clima','','',''),(4,'es','','Lotes Julio 2011','','',''),(5,'es','','Lotes Agosto 2011','','',''),(6,'es','<p>Este lote de vaquillonas consta de <strong>35 vaquillonas Aerden Angus</strong>.</p>\r\n<p>Las mismas .. blba bla.</p>\r\n<!-- Video 1-->\r\n<p class=\"meta\">&nbsp;</p>\r\n<p class=\"meta\">Videos Hacienda</p>\r\n<div class=\"entry\">\r\n<p class=\"links\"><a class=\"more\" href=\"#\">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"comments\" href=\"#\">Comments (33)</a></p>\r\n<iframe width=\"480\" height=\"390\" frameborder=\"0\" allowfullscreen=\"\" src=\"http://www.youtube.com/embed/xqdifFYWWmQ\"></iframe></div>\r\n<!-- Fin video-->','Lote 1','','',''),(7,'es','<p>Este lote de vaquillonas consta de <strong>35 vaquillonas Aerden Angus</strong>.</p>\r\n<p>Las mismas .. blba bla.</p>\r\n<!-- Video 1-->\r\n<p class=\"meta\">&nbsp;</p>\r\n<p class=\"meta\">Videos Hacienda</p>\r\n<div class=\"entry\">\r\n<p class=\"links\"><a class=\"more\" href=\"#\">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"comments\" href=\"#\">Comments (33)</a></p>\r\n<iframe width=\"480\" height=\"390\" frameborder=\"0\" allowfullscreen=\"\" src=\"http://www.youtube.com/embed/xqdifFYWWmQ\"></iframe></div>\r\n<!-- Fin video-->','Lote 2','','','');

/*Table structure for table `tiposeccion` */

DROP TABLE IF EXISTS `tiposeccion`;

CREATE TABLE `tiposeccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `publicado` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tiposeccion` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`passwd`,`crypt`,`email`,`last_login`,`aktiv`,`admin`,`manager`,`style`,`lang`,`expert`,`siteid`) values (1,'alejandro','4f28417b46e7a61ebb5ee6ae1180f851','0$RI6n98.tTbI','ale_elaspero@hotmail.com',1224288775,1,1,1,'default','en',0,'tellmatic');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
