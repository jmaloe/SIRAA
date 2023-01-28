-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: dbsiraapro
-- ------------------------------------------------------
-- Server version	5.1.69

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
-- Table structure for table `Registro_Actividades`
--

DROP TABLE IF EXISTS `Registro_Actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Registro_Actividades` (
  `cns_regActividades` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_catalogoactividades` smallint(5) unsigned NOT NULL,
  `id_programaEducativo` smallint(5) unsigned DEFAULT '0',
  `id_areaConocimiento` tinyint(3) unsigned DEFAULT NULL,
  `id_temario` int(10) unsigned DEFAULT NULL,
  `id_tipoValidacion` tinyint(3) unsigned DEFAULT NULL,
  `id_tipoPublico` tinyint(3) unsigned DEFAULT NULL,
  `id_sede` smallint(5) unsigned DEFAULT NULL,
  `id_dependencia` smallint(5) unsigned DEFAULT NULL,
  `id_modalidad` tinyint(3) unsigned DEFAULT NULL,
  `duracion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `cupoMinimo` smallint(5) unsigned DEFAULT NULL,
  `cupoMaximo` smallint(5) unsigned DEFAULT NULL,
  `costoUnach` decimal(11,2) DEFAULT NULL,
  `costoExternos` decimal(11,2) DEFAULT NULL,
  `aplico_dnc` tinyint(1) NOT NULL,
  `clave` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAprobacion` date DEFAULT NULL,
  `fechaCancelacion` date DEFAULT NULL,
  `usr_elaboro` int(10) unsigned NOT NULL,
  `usr_aprobo` int(10) unsigned DEFAULT '0',
  `usr_cancelo` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`cns_regActividades`),
  KEY `id_catalogoactividades` (`id_catalogoactividades`),
  KEY `id_areaConocimiento` (`id_areaConocimiento`),
  KEY `id_temario` (`id_temario`),
  KEY `id_tipoValidacion` (`id_tipoValidacion`),
  KEY `id_tipoPublico` (`id_tipoPublico`),
  KEY `id_sede` (`id_sede`),
  KEY `id_dependencia` (`id_dependencia`),
  KEY `id_modalidad` (`id_modalidad`),
  KEY `Registro_Actividades_ibfk_2` (`id_programaEducativo`),
  CONSTRAINT `Registro_Actividades_ibfk_1` FOREIGN KEY (`id_catalogoactividades`) REFERENCES `catalogo_actividades` (`id_catalogoactividades`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_2` FOREIGN KEY (`id_programaEducativo`) REFERENCES `programa_educativo` (`id_programaEducativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_3` FOREIGN KEY (`id_areaConocimiento`) REFERENCES `area_conocimiento` (`id_areaConocimiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_4` FOREIGN KEY (`id_temario`) REFERENCES `temario` (`id_temario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_5` FOREIGN KEY (`id_tipoValidacion`) REFERENCES `validacion_actividad` (`id_tipoValidacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_6` FOREIGN KEY (`id_tipoPublico`) REFERENCES `tipo_publico` (`id_tipoPublico`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_7` FOREIGN KEY (`id_sede`) REFERENCES `sede` (`id_sede`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_8` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Registro_Actividades_ibfk_9` FOREIGN KEY (`id_modalidad`) REFERENCES `modalidad` (`id_modalidad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `actividad_academica`
--

DROP TABLE IF EXISTS `actividad_academica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad_academica` (
  `id_actividadAcademica` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipoactividad` tinyint(3) unsigned DEFAULT NULL,
  `nombreActividad` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `descripcion` tinytext COLLATE utf8_spanish_ci,
  `prefijo` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_actividadAcademica`),
  KEY `id_tipoactividad` (`id_tipoactividad`),
  CONSTRAINT `actividad_academica_ibfk_1` FOREIGN KEY (`id_tipoactividad`) REFERENCES `tipo_actividad` (`id_tipoactividad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adscripcion`
--

DROP TABLE IF EXISTS `adscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adscripcion` (
  `id_adscripcion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_adscripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `area_conocimiento`
--

DROP TABLE IF EXISTS `area_conocimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_conocimiento` (
  `id_areaConocimiento` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_areaConocimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campus` (
  `id_campus` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_universidad` tinyint(3) unsigned DEFAULT NULL,
  `id_ciudad` smallint(5) unsigned DEFAULT NULL,
  `nombreCampus` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_campus`),
  KEY `id_universidad` (`id_universidad`),
  KEY `id_ciudad` (`id_ciudad`),
  CONSTRAINT `campus_ibfk_1` FOREIGN KEY (`id_universidad`) REFERENCES `universidad` (`id_universidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `campus_ibfk_2` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carpeta`
--

DROP TABLE IF EXISTS `carpeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carpeta` (
  `id_carpeta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carpeta`)
) ENGINE=InnoDB AUTO_INCREMENT=1085 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `catalogo_actividades`
--

DROP TABLE IF EXISTS `catalogo_actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_actividades` (
  `id_catalogoactividades` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_actividadAcademica` tinyint(3) unsigned DEFAULT NULL,
  `descripcion` tinytext COLLATE utf8_spanish_ci,
  `tiene_banner` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaCaptura` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_catalogoactividades`),
  KEY `id_actividadAcademica` (`id_actividadAcademica`),
  CONSTRAINT `catalogo_actividades_ibfk_1` FOREIGN KEY (`id_actividadAcademica`) REFERENCES `actividad_academica` (`id_actividadAcademica`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categoria_asistente`
--

DROP TABLE IF EXISTS `categoria_asistente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_asistente` (
  `id_categoria` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categoria_requisito`
--

DROP TABLE IF EXISTS `categoria_requisito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_requisito` (
  `id_cat_req` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_cat_req`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudad` (
  `id_ciudad` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_estado` smallint(5) unsigned DEFAULT NULL,
  `nombreCiudad` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_ciudad`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clasificacion_programas_educativos`
--

DROP TABLE IF EXISTS `clasificacion_programas_educativos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clasificacion_programas_educativos` (
  `id_clasifprogseducs` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_clasifprogseducs`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coordinador`
--

DROP TABLE IF EXISTS `coordinador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coordinador` (
  `id_coordinador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_persona` int(10) unsigned DEFAULT NULL,
  `id_carpeta` int(10) unsigned DEFAULT '0',
  `fechaDeAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_coordinador`),
  KEY `id_persona` (`id_persona`),
  KEY `id_carpeta` (`id_carpeta`),
  CONSTRAINT `coordinador_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `coordinador_ibfk_2` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dependencia`
--

DROP TABLE IF EXISTS `dependencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dependencia` (
  `id_dependencia` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_ciudad` smallint(5) unsigned DEFAULT NULL,
  `nombreDependencia` tinytext COLLATE utf8_spanish_ci,
  `direccion` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_dependencia`),
  KEY `id_ciudad` (`id_ciudad`),
  CONSTRAINT `dependencia_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_documentos`
--

DROP TABLE IF EXISTS `detalle_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_documentos` (
  `cns_documento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipoDocumento` smallint(5) unsigned NOT NULL,
  `id_carpeta` int(10) unsigned DEFAULT NULL,
  `name` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `mime` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `data` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cns_documento`),
  KEY `id_carpeta` (`id_carpeta`),
  KEY `id_tipoDocumento` (`id_tipoDocumento`),
  CONSTRAINT `detalle_documentos_ibfk_1` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_documentos_ibfk_2` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tipo_documento` (`id_tipoDocumento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_lista_asistencia`
--

DROP TABLE IF EXISTS `detalle_lista_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_lista_asistencia` (
  `no_registro` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_lista` int(10) unsigned DEFAULT NULL,
  `id_tipoasistente` tinyint(3) unsigned DEFAULT NULL,
  `id_categoria` tinyint(3) unsigned DEFAULT NULL,
  `folio` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_asistente` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` tinytext COLLATE utf8_spanish_ci,
  `usr_elaboro` int(10) unsigned DEFAULT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_valido` int(10) unsigned DEFAULT '0',
  `fechaValidacion` date DEFAULT NULL,
  PRIMARY KEY (`no_registro`),
  KEY `id_tipoasistente` (`id_tipoasistente`),
  KEY `id_categoria` (`id_categoria`),
  KEY `no_lista` (`no_lista`),
  CONSTRAINT `detalle_lista_asistencia_ibfk_1` FOREIGN KEY (`id_tipoasistente`) REFERENCES `tipo_asistente` (`id_tipoasistente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_lista_asistencia_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_asistente` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_lista_asistencia_ibfk_3` FOREIGN KEY (`no_lista`) REFERENCES `lista_asistencia` (`no_lista`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=974 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_registro_requisitos`
--

DROP TABLE IF EXISTS `detalle_registro_requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_registro_requisitos` (
  `cns_reg_requisitos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_regRequisito` int(10) unsigned DEFAULT NULL,
  `id_tipreq` int(10) unsigned DEFAULT NULL,
  `valor` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cns_reg_requisitos`),
  KEY `id_regRequisito` (`id_regRequisito`),
  KEY `id_tipreq` (`id_tipreq`),
  CONSTRAINT `detalle_registro_requisitos_ibfk_1` FOREIGN KEY (`id_regRequisito`) REFERENCES `registro_requisitos` (`id_regRequisito`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_registro_requisitos_ibfk_2` FOREIGN KEY (`id_tipreq`) REFERENCES `tipo_requisito` (`id_tipreq`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1331 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_sesiones`
--

DROP TABLE IF EXISTS `detalle_sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_sesiones` (
  `cns_detSesion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sesion` int(10) unsigned DEFAULT NULL,
  `fechaSesion` date NOT NULL,
  `horaInicial` time NOT NULL,
  `horaFinal` time NOT NULL,
  PRIMARY KEY (`cns_detSesion`),
  KEY `id_sesion` (`id_sesion`),
  CONSTRAINT `detalle_sesiones_ibfk_1` FOREIGN KEY (`id_sesion`) REFERENCES `sesiones` (`id_sesion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `detalle_temas`
--

DROP TABLE IF EXISTS `detalle_temas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_temas` (
  `cns_detalleTemas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_temario` int(10) unsigned DEFAULT NULL,
  `nombreModulo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `subtemas` text COLLATE utf8_spanish_ci NOT NULL,
  `proposito` text COLLATE utf8_spanish_ci NOT NULL,
  `estrategias_did` text COLLATE utf8_spanish_ci NOT NULL,
  `materiales_did` text COLLATE utf8_spanish_ci,
  `Hrs_teoricas` tinyint(3) unsigned NOT NULL,
  `Hrs_practicas` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`cns_detalleTemas`),
  KEY `id_temario` (`id_temario`),
  CONSTRAINT `detalle_temas_ibfk_1` FOREIGN KEY (`id_temario`) REFERENCES `temario` (`id_temario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id_estado` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_pais` tinyint(3) unsigned DEFAULT NULL,
  `nombreEstado` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_estado`),
  KEY `id_pais` (`id_pais`),
  CONSTRAINT `estado_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `facultad`
--

DROP TABLE IF EXISTS `facultad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facultad` (
  `id_facultad` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_campus` tinyint(3) unsigned DEFAULT NULL,
  `nombreFacultad` tinytext COLLATE utf8_spanish_ci,
  `direccion` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_facultad`),
  KEY `id_campus` (`id_campus`),
  CONSTRAINT `facultad_ibfk_1` FOREIGN KEY (`id_campus`) REFERENCES `campus` (`id_campus`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `formador`
--

DROP TABLE IF EXISTS `formador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formador` (
  `id_formador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_persona` int(10) unsigned DEFAULT NULL,
  `id_carpeta` int(10) unsigned DEFAULT '0',
  `id_tipoParticipante` tinyint(3) unsigned DEFAULT NULL,
  `fechaDeAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_formador`),
  KEY `id_persona` (`id_persona`),
  KEY `id_carpeta` (`id_carpeta`),
  KEY `id_tipoParticipante` (`id_tipoParticipante`),
  CONSTRAINT `formador_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `formador_ibfk_2` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `formador_ibfk_3` FOREIGN KEY (`id_tipoParticipante`) REFERENCES `tipo_participante` (`id_tipoParticipante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lista_asistencia`
--

DROP TABLE IF EXISTS `lista_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_asistencia` (
  `no_lista` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cns_regActividades` int(10) unsigned DEFAULT NULL,
  `id_carpeta` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`no_lista`),
  KEY `cns_regActividades` (`cns_regActividades`),
  KEY `id_carpeta` (`id_carpeta`),
  CONSTRAINT `lista_asistencia_ibfk_1` FOREIGN KEY (`cns_regActividades`) REFERENCES `Registro_Actividades` (`cns_regActividades`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lista_asistencia_ibfk_2` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modalidad`
--

DROP TABLE IF EXISTS `modalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidad` (
  `id_modalidad` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_modalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organizador`
--

DROP TABLE IF EXISTS `organizador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizador` (
  `id_organizador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_persona` int(10) unsigned DEFAULT NULL,
  `fechaDeAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_organizador`),
  KEY `id_persona` (`id_persona`),
  CONSTRAINT `organizador_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `id_pais` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombrePais` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participantes`
--

DROP TABLE IF EXISTS `participantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participantes` (
  `id_participantes` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cns_regActividades` int(10) unsigned DEFAULT NULL,
  `tag` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_participantes`),
  KEY `cns_regActividades` (`cns_regActividades`),
  CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`cns_regActividades`) REFERENCES `Registro_Actividades` (`cns_regActividades`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permisos_globales`
--

DROP TABLE IF EXISTS `permisos_globales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos_globales` (
  `idPermisoGlobal` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idRecurso` smallint(5) unsigned DEFAULT NULL,
  `idUser` smallint(5) unsigned DEFAULT NULL,
  `lectura` tinyint(1) NOT NULL,
  `escritura` tinyint(1) NOT NULL,
  `actualizacion` tinyint(1) NOT NULL,
  `eliminacion` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPermisoGlobal`),
  KEY `idRecurso` (`idRecurso`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `permisos_globales_ibfk_1` FOREIGN KEY (`idRecurso`) REFERENCES `recursos` (`idRecurso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisos_globales_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permisos_rol`
--

DROP TABLE IF EXISTS `permisos_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos_rol` (
  `idPermiso` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idRol` smallint(5) unsigned NOT NULL,
  `idRecurso` smallint(5) unsigned NOT NULL,
  `lectura` tinyint(1) NOT NULL,
  `escritura` tinyint(1) NOT NULL,
  `actualizacion` tinyint(1) NOT NULL,
  `eliminacion` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPermiso`),
  KEY `idRol` (`idRol`),
  KEY `idRecurso` (`idRecurso`),
  CONSTRAINT `permisos_rol_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisos_rol_ibfk_2` FOREIGN KEY (`idRecurso`) REFERENCES `recursos` (`idRecurso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=645 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `id_persona` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ciudad` smallint(5) unsigned DEFAULT NULL,
  `id_carpeta` int(10) unsigned DEFAULT '0',
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_paterno` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_materno` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `direccion` tinytext COLLATE utf8_spanish_ci,
  `telefono` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telCelular` decimal(10,0) DEFAULT NULL,
  `email` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_persona`),
  KEY `id_ciudad` (`id_ciudad`),
  KEY `persona_ibfk_1` (`id_carpeta`),
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `programa_educativo`
--

DROP TABLE IF EXISTS `programa_educativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa_educativo` (
  `id_programaEducativo` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_clasifprogseducs` tinyint(3) unsigned DEFAULT NULL,
  `nombrePrograma` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_programaEducativo`),
  KEY `id_clasifprogseducs` (`id_clasifprogseducs`),
  CONSTRAINT `programa_educativo_ibfk_1` FOREIGN KEY (`id_clasifprogseducs`) REFERENCES `clasificacion_programas_educativos` (`id_clasifprogseducs`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recursos`
--

DROP TABLE IF EXISTS `recursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recursos` (
  `idRecurso` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombreRecurso` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idRecurso`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regCoordinadores`
--

DROP TABLE IF EXISTS `regCoordinadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regCoordinadores` (
  `cns_coords` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_coordinador` int(10) unsigned DEFAULT NULL,
  `id_participantes` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cns_coords`),
  KEY `id_coordinador` (`id_coordinador`),
  KEY `id_participantes` (`id_participantes`),
  CONSTRAINT `regCoordinadores_ibfk_1` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `regCoordinadores_ibfk_2` FOREIGN KEY (`id_participantes`) REFERENCES `participantes` (`id_participantes`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regFormadores`
--

DROP TABLE IF EXISTS `regFormadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regFormadores` (
  `cns_formds` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_formador` int(10) unsigned DEFAULT NULL,
  `id_participantes` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cns_formds`),
  KEY `id_formador` (`id_formador`),
  KEY `id_participantes` (`id_participantes`),
  CONSTRAINT `regFormadores_ibfk_1` FOREIGN KEY (`id_formador`) REFERENCES `formador` (`id_formador`),
  CONSTRAINT `regFormadores_ibfk_2` FOREIGN KEY (`id_participantes`) REFERENCES `participantes` (`id_participantes`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regOrganizadores`
--

DROP TABLE IF EXISTS `regOrganizadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regOrganizadores` (
  `cns_orgsz` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_organizador` int(10) unsigned DEFAULT NULL,
  `id_participantes` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cns_orgsz`),
  KEY `id_organizador` (`id_organizador`),
  KEY `id_participantes` (`id_participantes`),
  CONSTRAINT `regOrganizadores_ibfk_1` FOREIGN KEY (`id_organizador`) REFERENCES `organizador` (`id_organizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `regOrganizadores_ibfk_2` FOREIGN KEY (`id_participantes`) REFERENCES `participantes` (`id_participantes`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `regResponsablesCDC`
--

DROP TABLE IF EXISTS `regResponsablesCDC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regResponsablesCDC` (
  `cns_respscdc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_responsable_cdc` int(10) unsigned DEFAULT NULL,
  `id_participantes` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cns_respscdc`),
  KEY `id_responsable_cdc` (`id_responsable_cdc`),
  KEY `id_participantes` (`id_participantes`),
  CONSTRAINT `regResponsablesCDC_ibfk_1` FOREIGN KEY (`id_responsable_cdc`) REFERENCES `responsableCDC` (`id_responsable_cdc`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `regResponsablesCDC_ibfk_2` FOREIGN KEY (`id_participantes`) REFERENCES `participantes` (`id_participantes`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro_requisitos`
--

DROP TABLE IF EXISTS `registro_requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_requisitos` (
  `id_regRequisito` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cns_regActividades` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_regRequisito`),
  KEY `cns_regActividades` (`cns_regActividades`),
  CONSTRAINT `registro_requisitos_ibfk_1` FOREIGN KEY (`cns_regActividades`) REFERENCES `Registro_Actividades` (`cns_regActividades`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `responsableCDC`
--

DROP TABLE IF EXISTS `responsableCDC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsableCDC` (
  `id_responsable_cdc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_persona` int(10) unsigned DEFAULT NULL,
  `id_carpeta` int(10) unsigned DEFAULT '0',
  `fechaDeAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_responsable_cdc`),
  KEY `id_persona` (`id_persona`),
  KEY `id_carpeta` (`id_carpeta`),
  CONSTRAINT `responsableCDC_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `responsableCDC_ibfk_2` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rol_del_usuario`
--

DROP TABLE IF EXISTS `rol_del_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_del_usuario` (
  `cns_rol_usuario` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idRol` smallint(5) unsigned DEFAULT NULL,
  `idUser` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`cns_rol_usuario`),
  KEY `idRol` (`idRol`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `rol_del_usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rol_del_usuario_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `idRol` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sede`
--

DROP TABLE IF EXISTS `sede`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sede` (
  `id_sede` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_facultad` smallint(5) unsigned DEFAULT NULL,
  `ubicacion` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_sede`),
  KEY `id_facultad` (`id_facultad`),
  CONSTRAINT `sede_ibfk_1` FOREIGN KEY (`id_facultad`) REFERENCES `facultad` (`id_facultad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sesiones`
--

DROP TABLE IF EXISTS `sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesiones` (
  `id_sesion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cns_regActividades` int(10) unsigned DEFAULT NULL,
  `fechaApertura` date NOT NULL,
  `fechaCierre` date NOT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sesion`),
  KEY `cns_regActividades` (`cns_regActividades`),
  CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`cns_regActividades`) REFERENCES `Registro_Actividades` (`cns_regActividades`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `temario`
--

DROP TABLE IF EXISTS `temario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temario` (
  `id_temario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_carpeta` int(10) unsigned DEFAULT NULL,
  `nombreTemario` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `criteriosEvaluacion` text COLLATE utf8_spanish_ci NOT NULL,
  `bibliografia` text COLLATE utf8_spanish_ci NOT NULL,
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_temario`),
  KEY `id_carpeta` (`id_carpeta`),
  CONSTRAINT `temario_ibfk_1` FOREIGN KEY (`id_carpeta`) REFERENCES `carpeta` (`id_carpeta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_actividad`
--

DROP TABLE IF EXISTS `tipo_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_actividad` (
  `id_tipoactividad` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipoactividad`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_asistente`
--

DROP TABLE IF EXISTS `tipo_asistente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_asistente` (
  `id_tipoasistente` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tag` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipoasistente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documento` (
  `id_tipoDocumento` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipoDocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_participante`
--

DROP TABLE IF EXISTS `tipo_participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_participante` (
  `id_tipoParticipante` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipoParticipante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_publico`
--

DROP TABLE IF EXISTS `tipo_publico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_publico` (
  `id_tipoPublico` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipoPublico`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_requisito`
--

DROP TABLE IF EXISTS `tipo_requisito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_requisito` (
  `id_tipreq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cat_req` int(10) unsigned DEFAULT NULL,
  `label` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `l_class` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `input` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `id_input` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `id_input_class` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `id_input_placeholder` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipreq`),
  KEY `id_cat_req` (`id_cat_req`),
  CONSTRAINT `tipo_requisito_ibfk_1` FOREIGN KEY (`id_cat_req`) REFERENCES `categoria_requisito` (`id_cat_req`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `universidad`
--

DROP TABLE IF EXISTS `universidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `universidad` (
  `id_universidad` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombreUniversidad` tinytext COLLATE utf8_spanish_ci,
  `slogan` tinytext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_universidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idUser` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_adscripcion` int(10) unsigned NOT NULL DEFAULT '0',
  `user` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `email` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `vigente` tinyint(1) DEFAULT '1',
  `creado_por` smallint(5) unsigned DEFAULT '1',
  `fechaCaptura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validacion_actividad`
--

DROP TABLE IF EXISTS `validacion_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validacion_actividad` (
  `id_tipoValidacion` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipoValidacion`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-22 13:37:05
