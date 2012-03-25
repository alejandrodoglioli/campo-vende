-- phpMyAdmin SQL Dump
-- version 2.11.9.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-10-2009 a las 11:51:15
-- Versión del servidor: 5.0.81
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `s032ae22_alojandome`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomic_photo_albums`
--

DROP TABLE IF EXISTS `atomic_photo_albums`;
CREATE TABLE IF NOT EXISTS `atomic_photo_albums` (
  `name` varchar(255) default NULL,
  `path` varchar(255) default NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL auto_increment,
  `publicado` int(1) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `atomic_photo_albums`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomic_photo_comments`
--

DROP TABLE IF EXISTS `atomic_photo_comments`;
CREATE TABLE IF NOT EXISTS `atomic_photo_comments` (
  `tof_ID` int(11) default NULL,
  `content` text,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL auto_increment,
  `nickname` tinytext,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `atomic_photo_comments`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomic_photo_photos`
--

DROP TABLE IF EXISTS `atomic_photo_photos`;
CREATE TABLE IF NOT EXISTS `atomic_photo_photos` (
  `album_ID` int(11) default NULL,
  `filename` text,
  `nb_comments` int(11) default NULL,
  `nb_views` int(11) default NULL,
  `ID` int(11) NOT NULL auto_increment,
  `publicado` int(1) default NULL,
  `fecha_publicacion` timestamp NULL default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `atomic_photo_photos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atomic_photo_users`
--

DROP TABLE IF EXISTS `atomic_photo_users`;
CREATE TABLE IF NOT EXISTS `atomic_photo_users` (
  `nickname` varchar(20) default NULL,
  `password` varchar(20) default NULL,
  `is_admin` tinyint(4) default NULL,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `atomic_photo_users`
--

INSERT INTO `atomic_photo_users` (`nickname`, `password`, `is_admin`, `ID`) VALUES
('alejandro', 'polopatin', 1, 2),
('Potro', '010282010283', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariosxsecciones`
--

DROP TABLE IF EXISTS `comentariosxsecciones`;
CREATE TABLE IF NOT EXISTS `comentariosxsecciones` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `fecha_publicacion` date default NULL,
  `publicado` int(1) default NULL,
  `id_seccion` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcar la base de datos para la tabla `comentariosxsecciones`
--

INSERT INTO `comentariosxsecciones` (`id`, `fecha_publicacion`, `publicado`, `id_seccion`) VALUES
(5, '2009-06-25', 1, 419),
(17, '2009-08-19', 0, 312),
(18, '2009-08-19', 0, 310),
(19, '2009-08-30', 0, 408),
(20, '2009-08-30', 0, 310);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariosxseccionesxidioma`
--

DROP TABLE IF EXISTS `comentariosxseccionesxidioma`;
CREATE TABLE IF NOT EXISTS `comentariosxseccionesxidioma` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `idioma` varchar(2) NOT NULL default '',
  `nombre` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `comentario` varchar(250) default NULL,
  PRIMARY KEY  (`id`,`idioma`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcar la base de datos para la tabla `comentariosxseccionesxidioma`
--

INSERT INTO `comentariosxseccionesxidioma` (`id`, `idioma`, `nombre`, `email`, `comentario`) VALUES
(5, 'es', 'Gerard', 'gerardfr@gmail.com', '<p>Yo he reservado ya mi ferry a Mallorca y la verdad es que estoy esperando el momento en que empiecen mis vacaciones. Marchamos el dia 1 de Agosto desde Barcelona y llegamos a Alcudia. Mooooola!!!!</p>'),
(17, 'es', '', '', ''),
(18, 'es', 'YIbfUUsFvUTjSCKDtY', 'ebuloi@jpaoow.com', 'OuGi5b  <a href="http://qezvoimhpqfs.com/">qezvoimhpqfs</a>, [url=http://clnavleermxm.com/]clnavleermxm[/url], [link=http://nopjvdmpkkpj.com/]nopjvdmpkkpj[/link], http://vgexkeegtdrn.com/'),
(19, 'es', '', '', ''),
(20, 'es', '', '', ''),
(21, 'es', '', '', ''),
(22, 'es', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `nombre_empresa` varchar(255) default NULL,
  `dueno_empresa` varchar(255) default NULL,
  `direccion_empresa` varchar(255) default NULL,
  `telefono_empresa` varchar(15) default NULL,
  `fax_empresa` varchar(15) default NULL,
  `mail_empresa` varchar(30) default NULL,
  `id` int(9) NOT NULL,
  `slogan` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`nombre_empresa`, `dueno_empresa`, `direccion_empresa`, `telefono_empresa`, `fax_empresa`, `mail_empresa`, `id`, `slogan`) VALUES
('Alojandome.com', 'Alejandro Doglioli', '', '', '', 'alejandrodoglioli@gmail.com', 0, 'Buscá tu alojamiento en alojandome.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

DROP TABLE IF EXISTS `contactos`;
CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int(9) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `apellido` varchar(50) default NULL,
  `email` varchar(255) NOT NULL,
  `idioma` varchar(2) default NULL,
  `id_grupo_contacto` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcar la base de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `apellido`, `email`, `idioma`, `id_grupo_contacto`) VALUES
(1, 'Ale', 'Doglioli', 'ale_elaspero@hotmail.com', 'es', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces`
--

DROP TABLE IF EXISTS `enlaces`;
CREATE TABLE IF NOT EXISTS `enlaces` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `titulo` varchar(50) character set latin1 collate latin1_spanish_ci default NULL,
  `url` varchar(250) character set latin1 collate latin1_spanish_ci default NULL,
  `descripcion` varchar(250) character set latin1 collate latin1_spanish_ci default NULL,
  `publicado` smallint(1) default NULL,
  `orden` int(6) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `enlaces`
--

INSERT INTO `enlaces` (`id`, `titulo`, `url`, `descripcion`, `publicado`, `orden`) VALUES
(1, 'Alejandro Doglioli', 'http://www.alejandro-doglioli.com.ar', 'Sitio web oficial de Alejandro Doglioli', 1, 1),
(5, 'Coches y autos en Argentina', 'http://www.cochesargentina.com.ar', 'La guía más completa para conseguir tu auto usado o nuevo en Argentina.', 1, 2),
(4, 'Transporte de Hacienda El Furtivo', 'http://www.transporte-furtivo.com.ar', 'La empresa lider en el transporte de hacienda en Tres Arroyos.', 1, 3),
(6, 'Empleo en Argentina', 'http://www.empleo-argentina.com.ar', 'La guía más completa para conseguir empleo en Argentina.', 1, 4),
(7, 'Hoteles Baratos', 'http://www.hoteles-baratos.com.ar', 'La más completa guía de hoteles baratos en Argentina.', 1, 7),
(8, 'Rayaner vuelos', 'http://www.aeropuerto-barcelona.es/rayaner-vuelos-55.html', 'Rayaner vuelos', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_contactos`
--

DROP TABLE IF EXISTS `grupos_contactos`;
CREATE TABLE IF NOT EXISTS `grupos_contactos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre_grupo` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `grupos_contactos`
--

INSERT INTO `grupos_contactos` (`id`, `nombre_grupo`) VALUES
(2, 'a'),
(3, 'b'),
(4, 'c'),
(5, 'd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

DROP TABLE IF EXISTS `idioma`;
CREATE TABLE IF NOT EXISTS `idioma` (
  `idioma` varchar(6) default NULL,
  `nombre` text,
  `nombre_imagen` text,
  `orden` double default NULL,
  `publicado` tinyint(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `idioma`
--

INSERT INTO `idioma` (`idioma`, `nombre`, `nombre_imagen`, `orden`, `publicado`) VALUES
('es', 'Español', 'es.png', 1, 1),
('en', 'English', 'en.png', 2, 1),
('fr', 'Français', 'fr.png', 3, 1),
('it', 'Italiano', 'it.png', 4, 1),
('de', 'Germany', 'de.png', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenesxsecciones`
--

DROP TABLE IF EXISTS `imagenesxsecciones`;
CREATE TABLE IF NOT EXISTS `imagenesxsecciones` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `path` varchar(200) default NULL,
  `principio` int(1) default NULL,
  `publicado` int(1) default NULL,
  `id_seccion` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Volcar la base de datos para la tabla `imagenesxsecciones`
--

INSERT INTO `imagenesxsecciones` (`id`, `nombre`, `path`, `principio`, `publicado`, `id_seccion`) VALUES
(86, '', '/images/secciones/1_', 0, 0, 1),
(88, '', '/images/secciones/597_', 0, 0, 597),
(89, '', '/images/secciones/3_', 0, 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(11) default NULL,
  `action` varchar(150) default NULL,
  `path` text,
  `imagen_modulo` varchar(100) default NULL,
  `habilitado` tinyint(1) default NULL,
  `id_padre` tinyint(5) default NULL,
  `orden` double default NULL,
  `publica` double default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `action`, `path`, `imagen_modulo`, `habilitado`, `id_padre`, `orden`, `publica`) VALUES
(1, 'albums', 'albums', 'category.png', 0, 0, 1, 1),
(2, 'listar_fotos', 'albums', 'product.png', 0, 0, 2, 1),
(3, 'secciones', 'secciones', 'option.png', 1, 0, 3, 1),
(4, 'listar_tiposeccion', 'secciones', 'calculate.png', 1, 0, 4, 0),
(5, 'listar_comentariosxsecciones', 'secciones', 'information.png', 1, 0, 5, 0),
(6, 'newsletters', 'newsletters', 'newsletter.png', 1, 0, 6, 0),
(7, 'listar_contactos', 'newsletters', 'mail.png', 1, 0, 7, 0),
(8, 'listar_grupos_contactos', 'newsletters', 'image.png', 1, 0, 8, 0),
(9, 'enlaces', 'enlaces', 'customer.png', 1, 0, 9, 1),
(10, 'noticias', 'noticias', 'report.png', 1, 0, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulosxidioma`
--

DROP TABLE IF EXISTS `modulosxidioma`;
CREATE TABLE IF NOT EXISTS `modulosxidioma` (
  `id_modulo` int(11) default NULL,
  `id_idioma` varchar(6) default NULL,
  `nombre` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `modulosxidioma`
--

INSERT INTO `modulosxidioma` (`id_modulo`, `id_idioma`, `nombre`) VALUES
(1, 'es', 'Albums'),
(2, 'es', 'Fotos'),
(3, 'es', 'Secciones'),
(4, 'es', 'Tipo Seccion'),
(5, 'es', 'Comentarios x Secciones'),
(6, 'es', 'Newsletters'),
(7, 'es', 'Contactos'),
(8, 'es', 'Grupos Contactos'),
(9, 'es', 'Enlaces'),
(10, 'es', 'Noticias'),
(9, 'en', 'Links'),
(10, 'en', 'News'),
(9, 'fr', 'Liens'),
(10, 'fr', 'Nouvelles'),
(9, 'it', 'Links'),
(10, 'it', 'News'),
(9, 'de', 'Links'),
(10, 'de', 'News');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `fecha` datetime default NULL,
  `enviado` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcar la base de datos para la tabla `newsletter`
--

INSERT INTO `newsletter` (`id`, `nombre`, `fecha`, `enviado`) VALUES
(12, 'as', '0000-00-00 00:00:00', 1),
(11, '12', '0000-00-00 00:00:00', 1),
(10, '1', '0000-00-00 00:00:00', 1),
(9, 'q', '2008-10-30 00:00:00', 1),
(8, 'Enero', '0000-00-00 00:00:00', 1),
(13, '13', '0000-00-00 00:00:00', 1),
(14, '123', '0000-00-00 00:00:00', 1),
(15, '1223', '2008-10-27 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletterxidioma`
--

DROP TABLE IF EXISTS `newsletterxidioma`;
CREATE TABLE IF NOT EXISTS `newsletterxidioma` (
  `id` int(10) unsigned NOT NULL,
  `subject` varchar(255) default NULL,
  `texto` text,
  `idioma` varchar(2) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `newsletterxidioma`
--

INSERT INTO `newsletterxidioma` (`id`, `subject`, `texto`, `idioma`) VALUES
(8, 'hola', '<p>dfsdfs</p>', 'es'),
(11, '12', '\r\n\r\n12\r\n', 'es'),
(12, 'as', '<p>as</p>', 'es'),
(13, '13', '<p>13</p>', 'es'),
(14, '123', '<p>132</p>', 'es'),
(15, '1223', '<p>1223</p>', 'es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `fecha_publicacion` datetime NOT NULL default '0000-00-00 00:00:00',
  `publicado` int(1) default NULL,
  `orden` tinyint(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `noticias`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticiasxidioma`
--

DROP TABLE IF EXISTS `noticiasxidioma`;
CREATE TABLE IF NOT EXISTS `noticiasxidioma` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `titulo` varchar(255) default NULL,
  `headline` text,
  `noticia` text NOT NULL,
  `email` varchar(255) default NULL,
  `idioma` varchar(2) NOT NULL default '',
  `description` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  PRIMARY KEY  (`id`,`idioma`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `noticiasxidioma`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

DROP TABLE IF EXISTS `secciones`;
CREATE TABLE IF NOT EXISTS `secciones` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_padre` double default NULL,
  `id_tiposeccion` int(11) NOT NULL default '0',
  `publicado` tinyint(1) default NULL,
  `menu_lateral` tinyint(1) default NULL,
  `orden` tinyint(2) default NULL,
  `fecha_publicacion` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id`, `id_padre`, `id_tiposeccion`, `publicado`, `menu_lateral`, `orden`, `fecha_publicacion`) VALUES
(1, 0, 0, 1, 0, 1, '0000-00-00'),
(2, 0, 1, 1, 1, 1, '0000-00-00'),
(3, 2, 1, 1, 0, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccionesxidioma`
--

DROP TABLE IF EXISTS `seccionesxidioma`;
CREATE TABLE IF NOT EXISTS `seccionesxidioma` (
  `id` double NOT NULL,
  `idioma` varchar(6) NOT NULL,
  `contenido` text,
  `nombre` varchar(150) default NULL,
  `description` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `title` varchar(225) default NULL,
  PRIMARY KEY  (`id`,`idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `seccionesxidioma`
--

INSERT INTO `seccionesxidioma` (`id`, `idioma`, `contenido`, `nombre`, `description`, `keywords`, `title`) VALUES
(1, 'de', '<div align="justify">Benutzen Sie die Links zu <span style="font-weight: bold;">Hostels</span>, <span style="font-weight: bold;">Hotels</span>, <span style="font-weight: bold;">Unterk&uuml;nften</span>, <span style="font-weight: bold;">Apartments </span>und <span style="font-weight: bold;">Hotels in Spanien</span>. G&uuml;nstige Preise, <span style="font-weight: bold;">preiswerte Hotel-Angebote Reservierungen f&uuml;r Apartments</span>, <span style="font-weight: bold;">Hostels </span>und <span style="font-weight: bold;">g&uuml;nstige Unterk&uuml;nfte</span> in jeder Stadt von Spanien. <br /><br /> Verwenden Sie die Suchmaschine, um den g&uuml;nstigsten Preis buchen. Vergleichen Sie die Dienstleistungen, f&uuml;r die saisonale Preise und Last-Minute-Angebote. <span style="font-weight: bold;">Suche zentrale Arten von Hotels</span>, <span style="font-weight: bold;">Tourismus-Portale</span> und Websites, auf die <span style="font-weight: bold;">Reserve und die Versorgung mit Unterk&uuml;nften in allen St&auml;dten</span> gewidmet und allen Provinzen Spaniens.</div>', 'Home', 'Discounted Hotels, Motels und Pensionen neu aktualisiert. Das ist Ihre Chance auf einen sehr günstigen Preis buchen. Freier Zugang zu finden, die am besten passen.', 'Billige Hostels, preiswerte Hotels, bietet die Unterkunft, Hotels Last-Minute Preis vergleichende Hotels, billige Hotelbuchung', 'Hostels in Spanien - Günstige Hotels Unterkunft und zentralen'),
(1, 'en', '<p align="justify">Use the links to find <strong>hostels</strong>, <strong>hotels</strong>, <strong>lodging</strong>, <strong>apartments </strong>and <strong>accommodation in Spain</strong>. Cheap prices, <strong>cheap hotel deals</strong>, <strong>reservations for apartments</strong>, <strong>hostels and cheap accommodation</strong> in every city of Spain. <br /> <br /> Use the search engine in order to book the most convenient price. Compare the services, for seasonal rates and last-minute promotions. Search central types of hotels, <strong>tourism portals</strong> and websites devoted to the reserve and supply of accommodation in all cities and all provinces of Spain.</p>', 'Home', 'Discounted hotels, hostels and accommodation newly updated. This is your chance to book a very cheap price. Free Access to find the best fit.', 'cheap hostels, cheap hotels, offers accommodation, hotels last minute, comparative price hotels, cheap hotel booking', 'Hostels in Spain - Discounted hotels accommodation and central'),
(1, 'es', '<p align="justify">Utiliza los enlaces para encontrar <strong>hostales</strong>, <strong>hoteles</strong>, <strong>albergues</strong>, <strong>apartamentos </strong>y<strong> alojamientos en Espa&ntilde;a</strong>. <strong>Precios de hostales</strong>, <strong>ofertas de hoteles econ&oacute;mico</strong>s, <strong>reservas de apartamentos de alquiler</strong>, <strong>posadas </strong>y <strong>alojamientos baratos</strong> en todas las ciudades de Espa&ntilde;a.</p>\r\n<p align="justify">Utiliza el buscador para hacer tu reserva al precio m&aacute;s conveniente. Compara los servicios, busca tarifas de temporada y promociones de &uacute;ltimo minuto. Consulta diferentes tipos de <strong>central hotelera</strong>, <strong>portales de turismo</strong> y sitios web dedicados a la reserva y oferta de alojamientos en todas las ciudades y todas las provincias de Espa&ntilde;a.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 'Home', 'Ofertas de hostales, hoteles y alojamientos recién actualizadas. Esta es tu oportunidad de reservar a precio muy barato. Acceso gratis para buscar la oferta más conveniente.', 'hostales baratos, hoteles economicos, ofertas alojamiento, hoteles last minute, comparativa precio hoteles, reserva hotel barato', 'Hostales en España - Ofertas alojamiento y central de hoteles'),
(1, 'fr', '<p align="justify">Utilisez les liens pour trouver des <span style="font-weight: bold;">auberges</span>, des <span style="font-weight: bold;">h&ocirc;tels</span>, <span style="font-weight: bold;"> appartements </span>et <span style="font-weight: bold;">logements en Espagne</span>. Cheap prix, <span style="font-weight: bold;">offres h&ocirc;tel bon march&eacute;</span>, <span style="font-weight: bold;">r&eacute;servations d''appartements</span>, <span style="font-weight: bold;">h&ocirc;tels </span>et <span style="font-weight: bold;">logement bon march&eacute;</span> dans toutes les villes d''Espagne. <br /> <br /> Utilisez le moteur de recherche afin de r&eacute;server le prix le plus commode. Comparer les services, pour les tarifs saisonniers et les promotions de derni&egrave;re minute. Types de <span style="font-weight: bold;">recherche central des h&ocirc;tels</span>, des <span style="font-weight: bold;">portails touristiques</span> et des sites Web consacr&eacute;s &agrave; la <span style="font-weight: bold;">r&eacute;serve et l''offre de logement</span> dans toutes les villes et toutes les provinces de l''Espagne.</p>', 'Home', 'Hôtels à prix réduits, hôtels et logements nouvellement mis à jour. Ceci est votre chance de réserver un prix très bon marché. Accès Gratuit pour trouver le meilleur ajustement.', 'auberges à bas prix, hôtels bon marché, offre un hébergement, hôtels de dernière minute, hôtels comparative des prix, réservation d''hôtel à bas prix', 'Auberges de Jeunesse en Espagne - Bonnes hébergement hôtels et le centre'),
(1, 'it', '<div align="justify">Utilizzare i link per trovare <strong>ostelli</strong>, <strong>alberghi</strong>, <strong> appartamenti </strong>e <strong>alloggi in Spagna</strong>. Prezzi economici, <strong>offerte hotel economici</strong>, <strong>prenotazioni per gli appartamenti</strong>, <strong>ostelli e bed &amp; breakfast</strong> in ogni citt&agrave; della Spagna. <br /><br /> Utilizzare il motore di ricerca per prenotare il prezzo pi&ugrave; conveniente. Confronta i servizi, le tariffe stagionali e le promozioni dell''ultimo minuto. Tipi di <strong>ricerca centrale di hotel</strong>, <strong>portali turistici</strong> e siti web dedicati alla <strong>riserva e l''offerta di alloggi</strong> in tutte le citt&agrave; e tutte le province della Spagna.</div>', 'Home', 'Hotel che offrono sconti, ostelli e alloggi di recente aggiornato. Questa è la tua possibilità di prenotare un prezzo molto conveniente. Accesso gratuito per trovare la soluzione migliore.', 'ricerca alberghi, alberghi economici, offre alloggio, last minute hotel, alberghi comparative dei prezzi, prenotazione hotel economici', 'Ostelli in Spagna - Discounted hotels alloggi e centrale'),
(2, 'de', '<p align="justify"><strong>Last-Minute-Angebote und vergleichende Hostels g&uuml;nstigen Preis</strong>. Suchen und klicken Sie auf die unterschiedlichen Entwicklungen der g&uuml;nstigen Zeitpunkt und profitieren Sie mit Rabatt f&uuml;r Online-Buchung. <br />\r\n<br />\r\nViele Angebote, Last-Minute-Preise und M&ouml;glichkeiten des Hostels in der Mitte der Stadt und Umgebung. Vergleichen Sie Preise, finden Sie die Details und die Buchung mit Sicherheit.</p>', 'Hostels', 'Last-Minute-Angebote und vergleichende Hostel Hostels günstigen Preis. Für schnell und sicher. Finden und vergleichen Sie die tatsächlichen Preise Reservierung Dienstleistungen.', 'Billige Hostels, billige Preis-Center bieten Hostel, billig, Spanien Hostels, Hostel 2, Hostels Renten', 'Cheap Hostels - Günstige Preis-Center - Versorgung Herberge'),
(2, 'en', '<p align="justify"><strong>Last minute deals and comparative hostels cheap price</strong>. Find and click on the different developments of cheap date and benefit with <strong>discounts for booking online</strong>. <br /> <br /> Many offers, last minute prices and opportunities of hostels in the center and around the city. Compare prices, find out the details and reservation services with safety and security.</p>', 'Hostels', 'Last minute deals and comparative hostel hostels cheap price. For fast and safe. Find and compare actual prices reservation services.', 'Cheap hostels, cheap price center, offer hostel, cheap in, Spain hostels, hostel 2, hostels pensions', 'Cheap hostels - Cheap price center - Supply hostel '),
(2, 'es', '<p align="justify"><strong>Ofertas de &uacute;ltimo minuto de hostal</strong> y comparativa de <strong>precios de hostales baratos</strong>. Busca y pulsa sobre las diferentes promociones actualizadas de <strong>hostales econ&oacute;micos</strong> y benef&iacute;ciate con importantes <strong>descuentos de reserva online</strong>.</p> <p align="justify">Muchas ofertas, precios y oportunidades <strong>last minute de hostales en el centro</strong> y alrededores de la ciudad. Compara las tarifas, conoce el detalle de los servicios y reserva con seguridad y garant&iacute;a.</p>', 'Hostales', 'Ofertas de último minuto de hostal y comparativa de precios de hostales baratos. Busca rápido y seguro. Encuentra precios actualizados y compara los servicios de reserva.', 'Hostales baratos, Precio hostales centro, Oferta hostal, hostales economicos en, hostales españa, hostal 2, hostales pensiones', 'Hostales baratos - Precio hostales centro - Oferta hostal'),
(2, 'fr', '<div align="justify">Offres de derni&egrave;re minute et des <strong>auberges </strong>de comparatif de <strong>prix bon march&eacute;</strong>. Trouvez et cliquez sur les diff&eacute;rents d&eacute;veloppements de la date &agrave; bas prix et de b&eacute;n&eacute;ficier des remises pour la <strong>r&eacute;servation en ligne</strong>. <br /><br /> De nombreuses offres, les <strong>prix de derni&egrave;re minute</strong> et les possibilit&eacute;s <strong>d''auberges de jeunesse</strong> dans le centre et autour de la ville. Comparer les prix, de conna&icirc;tre le d&eacute;tail et les services de r&eacute;servation aupr&egrave;s de la s&eacute;curit&eacute; et la s&eacute;curit&eacute;.</div>', 'Auberges', 'Offres de dernière minute et comparative auberges auberge prix bon marché. Pour un service rapide et sécuritaire. Trouver et de comparer les prix réels des services de réservation.', 'bon marché hotels, un centre de bas prix, l''auberge offre, Espagne auberges de jeunesse, Hostel 2, les pensions Auberges', 'Auberges - Centre prix réduit - Approvisionnement auberge'),
(2, 'it', '<div align="justify"><strong>Offerte Last minute e ostelli comparativa prezzo</strong>. Trova e fare clic sugli sviluppi diversi della data a basso costo e beneficio, con <strong>sconti per prenotazione online</strong>. <br /> <br /> Molte offerte, <strong>prezzi last minute</strong> e le <strong>opportunit&agrave; di ostelli</strong> al centro e intorno alla citt&agrave;. Confronta i prezzi, scoprire i dettagli e servizi di prenotazione con la sicurezza e la sicurezza.</div>', 'Ostelli', 'Offerte Last minute e comparativa ostelli ostello prezzo. Per una veloce e sicura. Trova e confronta i prezzi effettivi dei servizi di prenotazione.', 'Ostelli economici, centro prezzo, ostello offre, a buon mercato in, Ostelli Spagna, Hostel 2, pensioni ostelli', 'Ostelli economici - Centro prezzo - Ostello Supply'),
(3, 'de', '', 'Jugendherbergen in Spanien', '', '', 'Jugendherbergen in Spanien, Hostel in Spanien, Günstige Herberge in Spanien'),
(3, 'en', '', 'Hostels in Spain', '', '', 'Hostels in Spain, Hostel in Spain, Cheap hostel in Spain'),
(3, 'es', '', 'Hostales en España', '', '', 'Hostales en España, Hostel en España, Hostel barato en España'),
(3, 'fr', '', 'Auberges en Espagne', '', '', 'Auberges en Espagne, Auberges Espagne, Auberge bon marché en Espagne,'),
(3, 'it', '', 'Ostelli a Spagna', '', '', 'Ostelli a Spagna, Ostello a Spagna, Ostello economici a Spagna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposeccion`
--

DROP TABLE IF EXISTS `tiposeccion`;
CREATE TABLE IF NOT EXISTS `tiposeccion` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(150) default NULL,
  `publicado` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `tiposeccion`
--

INSERT INTO `tiposeccion` (`id`, `nombre`, `publicado`) VALUES
(1, 'Hostales', 1),
(2, 'Hoteles', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_bin NOT NULL default '',
  `passwd` varchar(128) collate utf8_bin NOT NULL default '',
  `crypt` varchar(128) collate utf8_bin NOT NULL default '',
  `email` varchar(255) collate utf8_bin NOT NULL default '',
  `last_login` int(11) NOT NULL default '0',
  `aktiv` tinyint(4) NOT NULL default '1',
  `admin` tinyint(4) NOT NULL default '0',
  `manager` tinyint(4) NOT NULL default '0',
  `style` varchar(64) collate utf8_bin NOT NULL default 'default',
  `lang` varchar(8) collate utf8_bin NOT NULL default 'de',
  `expert` tinyint(4) default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`,`passwd`,`aktiv`,`siteid`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `passwd`, `crypt`, `email`, `last_login`, `aktiv`, `admin`, `manager`, `style`, `lang`, `expert`, `siteid`) VALUES
(1, 'alejandro', '4f28417b46e7a61ebb5ee6ae1180f851', '0$RI6n98.tTbI', 'ale_elaspero@hotmail.com', 1224288775, 1, 1, 1, 'default', 'en', 0, 'tellmatic');
