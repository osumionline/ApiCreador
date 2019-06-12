-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: creador
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `include_file`
--

DROP TABLE IF EXISTS `include_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `include_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada archivo a incluir',
  `id_include_version` int(11) NOT NULL COMMENT 'Id de la version del include',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de archivo 0 CSS 1 JS',
  `filename` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del archivo a incluir',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_include_file_include_version_idx` (`id_include_version`),
  CONSTRAINT `fk_include_file_include_version` FOREIGN KEY (`id_include_version`) REFERENCES `include_version` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `include_file`
--

LOCK TABLES `include_file` WRITE;
/*!40000 ALTER TABLE `include_file` DISABLE KEYS */;
INSERT INTO `include_file` VALUES (1,1,1,'jquery-3.3.1.min.js','2019-04-09 00:00:00',NULL),(2,1,1,'jquery-3.3.1.min.map','2019-04-09 00:00:00',NULL),(3,2,1,'angular.min.js','2019-04-09 00:00:00',NULL),(4,2,1,'angular.min.js.map','2019-04-09 00:00:00',NULL),(5,2,1,'angular-animate.min.js','2019-04-09 00:00:00',NULL),(6,2,1,'angular-animate.min.js.map','2019-04-09 00:00:00',NULL),(7,2,1,'angular-aria.min.js','2019-04-09 00:00:00',NULL),(8,2,1,'angular-aria.min.js.map','2019-04-09 00:00:00',NULL),(9,2,1,'angular-messages.min.js','2019-04-09 00:00:00',NULL),(10,2,1,'angular-messages.min.js.map','2019-04-09 00:00:00',NULL),(11,2,1,'angular-route.min.js','2019-04-09 00:00:00',NULL),(12,2,1,'angular-route.min.js.map','2019-04-09 00:00:00',NULL),(13,2,1,'angular-sanitize.min.js','2019-04-09 00:00:00',NULL),(14,2,1,'angular-sanitize.min.js.map','2019-04-09 00:00:00',NULL),(15,3,0,'angular-material.min.css','2019-04-09 00:00:00',NULL),(16,3,1,'angular-material.min.js','2019-04-09 00:00:00',NULL),(17,4,0,'bootstrap.min.css','2019-04-09 00:00:00',NULL),(18,4,0,'bootstrap-grid.min.css','2019-04-09 00:00:00',NULL),(19,4,0,'bootstrap-reboot.min.css','2019-04-09 00:00:00',NULL),(20,4,1,'bootstrap.min.js','2019-04-09 00:00:00',NULL),(21,4,1,'bootstrap.min.js.map','2019-04-09 00:00:00',NULL),(22,4,1,'bootstrap.bundle.min.js','2019-04-09 00:00:00',NULL),(23,4,1,'bootstrap.bundle.min.js.map','2019-04-09 00:00:00',NULL);
/*!40000 ALTER TABLE `include_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `include_type`
--

DROP TABLE IF EXISTS `include_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `include_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para tipo de include',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de include',
  `show_include` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Indica si debe mostrarse en la lista de includes disponibles',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `include_type`
--

LOCK TABLES `include_type` WRITE;
/*!40000 ALTER TABLE `include_type` DISABLE KEYS */;
INSERT INTO `include_type` VALUES (1,'jQuery',1,'2019-04-09 00:00:00',NULL),(2,'Angular',1,'2019-04-09 00:00:00',NULL),(3,'Angular Material',1,'2019-04-09 00:00:00',NULL),(4,'Bootstrap',1,'2019-04-09 00:00:00',NULL);
/*!40000 ALTER TABLE `include_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `include_version`
--

DROP TABLE IF EXISTS `include_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `include_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id unico de la version del include',
  `id_include_type` int(11) NOT NULL COMMENT 'Id del tipo de include',
  `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Número de versión del tipo de include',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_include_version_include_type_idx` (`id_include_type`),
  CONSTRAINT `fk_include_version_include_type` FOREIGN KEY (`id_include_type`) REFERENCES `include_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `include_version`
--

LOCK TABLES `include_version` WRITE;
/*!40000 ALTER TABLE `include_version` DISABLE KEYS */;
INSERT INTO `include_version` VALUES (1,1,'3.3.1','2019-04-09 00:00:00',NULL),(2,2,'1.7.8','2019-04-09 00:00:00',NULL),(3,3,'1.1.18','2019-04-09 00:00:00',NULL),(4,4,'4.1.3','2019-04-09 00:00:00',NULL);
/*!40000 ALTER TABLE `include_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada modelo',
  `id_project` int(11) NOT NULL COMMENT 'Id del proyecto al que pertenece el modelo',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del modelo',
  `table_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre de la tabla en la base de datos',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_model_project_idx` (`id_project`),
  CONSTRAINT `fk_model_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (15,2,'User','user','2019-05-03 09:06:31','2019-05-08 10:50:29'),(16,2,'Project','project','2019-05-03 09:06:31','2019-05-08 10:50:29'),(17,2,'ProjectConfig','project_config','2019-05-03 09:06:31','2019-05-08 10:50:29'),(18,2,'ProjectConfigListItem','project_config_list_item','2019-05-03 09:16:26','2019-05-08 10:50:29'),(19,2,'Model','model','2019-05-03 09:25:17','2019-05-08 10:50:29'),(20,2,'Row','row','2019-05-03 09:31:59','2019-05-08 10:50:29'),(21,2,'IncludeType','include_type','2019-05-03 09:36:29','2019-05-08 10:50:29'),(22,2,'IncludeVersion','include_version','2019-05-03 09:38:52','2019-05-08 10:50:29'),(23,2,'IncludeFile','include_file','2019-05-03 09:42:45','2019-05-08 10:50:29'),(24,2,'ProjectInclude','project_include','2019-05-03 09:44:47','2019-05-08 10:50:29'),(25,3,'User','user','2019-05-14 17:37:54','2019-05-17 11:39:25'),(26,3,'Photo','photo','2019-05-14 17:37:54','2019-05-17 11:39:25');
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_user` int(11) NOT NULL COMMENT 'Id del usuario dueño del proyecto',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del proyecto',
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Slug del nombre del proyecto',
  `description` text COLLATE utf8_unicode_ci COMMENT 'Descripción del proyecto',
  `last_compilation` datetime DEFAULT NULL COMMENT 'Fecha de la última compilación',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_project_user_idx` (`id_user`),
  CONSTRAINT `fk_project_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (2,1,'API Creador','api-creador','API para la aplicación Creador','2019-05-27 12:31:55','2019-05-02 18:53:20','2019-05-27 12:31:55'),(3,1,'Demo','demo','Demo para OFW','2019-05-27 12:31:33','2019-05-14 17:37:54','2019-05-27 12:31:33');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_config`
--

DROP TABLE IF EXISTS `project_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_project` int(11) NOT NULL COMMENT 'Id del proyecto al que pertenece la configuración',
  `db_host` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Host de la base de datos',
  `db_user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre de usuario para la base de datos',
  `db_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Contraseña cifrada para la base de datos',
  `db_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre de la base de datos',
  `cookies_prefix` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Prefijo para las cookies',
  `cookies_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL para las cookies',
  `module_browser` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo browser 1 o no 0',
  `module_email` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo email 1 o no 0',
  `module_email_smtp` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo email smtp 1 o no 0',
  `module_ftp` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo ftp 1 o no 0',
  `module_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo image 1 o no 0',
  `module_pdf` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo pdf 1 o no 0',
  `module_translate` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo translate 1 o no 0',
  `module_crypt` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo crypt 1 o no 0',
  `module_file` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si habilitar el módulo file 1 o no 0',
  `base_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL base de la aplicación',
  `admin_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Dirección email para notificaciones al admin',
  `default_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Título por defecto para las páginas',
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Código de idioma por defecto',
  `smtp_host` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Host para el envío de emails por SMTP',
  `smtp_port` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Puerto para el envío de emails por SMTP',
  `smtp_secure` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tipo de cifrado para el envío de emails por SMTP',
  `smtp_user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre de usuario para el envío de emails por SMTP',
  `smtp_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Contraseña cifrada para el envío de emails por SMTP',
  `error_403` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL al que redirigir en caso de error 403',
  `error_404` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL al que redirigir en caso de error 404',
  `error_500` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'URL al que redirigir en caso de error 500',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_project_config_project_idx` (`id_project`),
  CONSTRAINT `fk_project_config_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_config`
--

LOCK TABLES `project_config` WRITE;
/*!40000 ALTER TABLE `project_config` DISABLE KEYS */;
INSERT INTO `project_config` VALUES (2,2,'localhost','creador','cE5sRUdRTzNJblF6bjQ5aGIwK0VuZz09OjqSJiAMcZ62epZ2EEM0WJP7','creador',NULL,NULL,0,1,0,0,0,0,0,1,0,'https://apicreador.osumi.es','inigo.gorosabel@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'https://creador.osumi.es',NULL,'2019-05-02 18:53:20','2019-05-08 10:50:29'),(3,3,'localhost','user','eHlKcll6a1h2SnFKNEhxaWJwRjhUdz09OjpSpqVVUBGHhHCouXVS4K4i','demo','osm','.osumi.es',0,1,0,0,1,0,0,1,1,'https://demo.osumi.es','inigo.gorosabel@gmail.com','Demo','es',NULL,NULL,NULL,NULL,NULL,NULL,'https://demo.osumi.es/not-found',NULL,'2019-05-14 17:37:54','2019-05-17 11:39:25');
/*!40000 ALTER TABLE `project_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_config_list_item`
--

DROP TABLE IF EXISTS `project_config_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_config_list_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_project_config` int(11) NOT NULL COMMENT 'Id de la configuración a la que hace referencia',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir',
  `key` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Clave para los tipos extra y dir',
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Valor del elemento de lista',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_project_config_list_item_project_config_idx` (`id_project_config`),
  CONSTRAINT `fk_project_config_list_item_project_config` FOREIGN KEY (`id_project_config`) REFERENCES `project_config` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_config_list_item`
--

LOCK TABLES `project_config_list_item` WRITE;
/*!40000 ALTER TABLE `project_config_list_item` DISABLE KEYS */;
INSERT INTO `project_config_list_item` VALUES (82,2,4,'crypt_key','IZc2VDu3432r4RnsH4Mg0YkIoHtWe+G11Ct9N94K06Q=','2019-05-08 10:50:29','2019-05-08 10:50:29'),(83,2,6,'include','/var/www/vhosts/osumi.es/apicreador.osumi.es/include/','2019-05-08 10:50:29','2019-05-08 10:50:29'),(87,3,0,NULL,'common','2019-05-17 11:39:25','2019-05-17 11:39:25'),(88,3,2,NULL,'common','2019-05-17 11:39:25','2019-05-17 11:39:25'),(89,3,4,'api_key','1234567890qwertyuiopasdfghjklñzx','2019-05-17 11:39:25','2019-05-17 11:39:25');
/*!40000 ALTER TABLE `project_config_list_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_include`
--

DROP TABLE IF EXISTS `project_include`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_include` (
  `id_project` int(11) NOT NULL COMMENT 'Id del proyecto en el que se incluye',
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de include',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_project`,`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_include`
--

LOCK TABLES `project_include` WRITE;
/*!40000 ALTER TABLE `project_include` DISABLE KEYS */;
INSERT INTO `project_include` VALUES (3,2,'2019-05-17 11:39:25','2019-05-17 11:39:25'),(3,3,'2019-05-17 11:39:25','2019-05-17 11:39:25');
/*!40000 ALTER TABLE `project_include` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `row`
--

DROP TABLE IF EXISTS `row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `row` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada campo del modelo',
  `id_model` int(11) NOT NULL COMMENT 'Id del modelo al que pertenece el campo',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del campo',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9',
  `size` int(11) DEFAULT NULL COMMENT 'Tamaño del campo',
  `auto_increment` tinyint(1) DEFAULT NULL COMMENT 'Indica si el campo es AUTO_INCREMENT 1 o no 0',
  `nullable` tinyint(1) DEFAULT NULL COMMENT 'Indica si el campo puede ser nulo 1 o no 0',
  `default` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Valor por defecto para un campo',
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Referencia a otra tabla',
  `comment` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Comentario para el campo',
  `order` int(11) NOT NULL COMMENT 'Orden del campo en el modelo',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`),
  KEY `fk_row_model_idx` (`id_model`),
  CONSTRAINT `fk_row_model` FOREIGN KEY (`id_model`) REFERENCES `model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `row`
--

LOCK TABLES `row` WRITE;
/*!40000 ALTER TABLE `row` DISABLE KEYS */;
INSERT INTO `row` VALUES (111,15,'id',1,NULL,1,1,NULL,NULL,'Id único de cada usuario',0,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(112,15,'username',5,50,0,0,NULL,NULL,'Nombre o nick del usuario',1,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(113,15,'pass',5,32,0,0,NULL,NULL,'Contraseña cifrada del usuario',2,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(114,15,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',3,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(115,15,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',4,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(116,16,'id',1,NULL,1,1,NULL,NULL,'Id único de cada proyecto',0,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(117,16,'id_user',4,NULL,0,0,NULL,'user.id','Id del usuario dueño del proyecto',1,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(118,16,'name',5,50,0,0,NULL,NULL,'Nombre del proyecto',2,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(119,16,'slug',5,50,0,0,NULL,NULL,'Slug del nombre del proyecto',3,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(120,16,'description',8,NULL,0,1,NULL,NULL,'Descripción del proyecto',4,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(121,16,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',6,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(122,16,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',7,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(123,17,'id',1,NULL,1,1,NULL,NULL,'Id único de cada configuración',0,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(124,17,'id_project',4,NULL,0,0,NULL,'project.id','Id del proyecto al que pertenece la configuración',1,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(125,17,'db_host',5,50,0,1,NULL,NULL,'Host de la base de datos',2,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(126,17,'db_user',5,50,0,1,NULL,NULL,'Nombre de usuario para la base de datos',3,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(127,17,'db_pass',5,100,0,1,NULL,NULL,'Contraseña cifrada para la base de datos',4,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(128,17,'db_name',5,50,0,1,NULL,NULL,'Nombre de la base de datos',5,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(129,17,'cookies_prefix',5,50,0,1,NULL,NULL,'Prefijo para las cookies',6,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(130,17,'cookies_url',5,100,0,1,NULL,NULL,'URL para las cookies',7,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(131,17,'module_browser',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo browser 1 o no 0',8,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(132,17,'module_email',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo email 1 o no 0',9,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(133,17,'module_email_smtp',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo email SMTP 1 o no 0',10,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(134,17,'module_ftp',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo ftp 1 o no 0',11,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(135,17,'module_image',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo image 1 o no 0',12,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(136,17,'module_pdf',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo pdf 1 o no 0',13,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(137,17,'module_translate',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo translate 1 o no 0',14,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(138,17,'module_crypt',7,NULL,0,1,NULL,NULL,'Indica si habilitar el módulo crypt 1 o no 0',15,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(139,17,'base_url',5,250,0,1,NULL,NULL,'URL base de la aplicación',16,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(140,17,'admin_email',5,100,0,1,NULL,NULL,'Dirección email para notificaciones al admin',17,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(141,17,'default_title',5,100,0,1,NULL,NULL,'Título por defecto para las páginas',18,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(142,17,'lang',5,2,0,1,NULL,NULL,'Código de idioma por defecto',19,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(143,17,'smtp_host',5,100,0,1,NULL,NULL,'Host para el envío de emails por SMTP',20,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(144,17,'smtp_port',5,5,0,1,NULL,NULL,'Puerto para el envío de emails por SMTP',21,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(145,17,'smtp_secure',5,10,0,1,NULL,NULL,'Tipo de cifrado para el envío de emails por SMTP',22,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(146,17,'smtp_user',5,50,0,1,NULL,NULL,'Nombre de usuario para el envío de emails por SMTP',23,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(147,17,'smtp_pass',5,100,0,1,NULL,NULL,'Contraseña cifrada para el envío de emails por SMTP',24,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(148,17,'error_403',5,100,0,1,NULL,NULL,'URL al que redirigir en caso de error 403',25,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(149,17,'error_404',5,100,0,1,NULL,NULL,'URL al que redirigir en caso de error 404',26,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(150,17,'error_500',5,100,0,1,NULL,NULL,'URL al que redirigir en caso de error 500',27,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(151,17,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',28,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(152,17,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',29,'2019-05-03 09:06:31','2019-05-08 10:50:29'),(153,18,'id',1,NULL,1,1,NULL,NULL,'Id único de cada elemento de lista',0,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(154,18,'id_project_config',4,NULL,0,0,NULL,'project_config.id','Id de la configuración a la que hace referencia',1,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(155,18,'type',4,NULL,0,0,NULL,NULL,'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir',2,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(156,18,'key',5,20,0,1,NULL,NULL,'Clave para los tipos extra y dir',3,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(157,18,'value',5,200,0,0,NULL,NULL,'Valor del elemento de lista',4,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(158,18,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',5,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(159,18,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',6,'2019-05-03 09:16:26','2019-05-08 10:50:29'),(160,19,'id',1,NULL,1,1,NULL,NULL,'Id única de cada tabla',0,'2019-05-03 09:25:17','2019-05-08 10:50:29'),(161,19,'project_id',4,NULL,0,0,NULL,'project.id','Id del proyecto al que pertenece la tabla',1,'2019-05-03 09:26:16','2019-05-08 10:50:29'),(162,19,'name',5,100,0,0,NULL,NULL,'Nombre del modelo',2,'2019-05-03 09:27:42','2019-05-08 10:50:29'),(163,19,'table_name',5,100,0,0,NULL,NULL,'Nombre de la tabla en la base de datos',3,'2019-05-03 09:27:42','2019-05-08 10:50:29'),(164,19,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',4,'2019-05-03 09:27:42','2019-05-08 10:50:29'),(165,19,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',5,'2019-05-03 09:27:42','2019-05-08 10:50:29'),(166,20,'id',1,NULL,1,1,NULL,NULL,'Id único de cada campo',0,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(167,20,'id_model',4,NULL,0,0,NULL,'model.id','Tabla a la que pertenece el campo',1,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(168,20,'name',5,50,0,0,NULL,NULL,'Nombre del campo',2,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(169,20,'type',4,NULL,0,0,NULL,NULL,'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9',3,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(170,20,'size',4,NULL,0,1,NULL,NULL,'Tamaño del campo',4,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(171,20,'auto_increment',7,NULL,0,1,NULL,NULL,'Indica si el campo es AUTO_INCREMENT',5,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(172,20,'nullable',7,NULL,0,1,NULL,NULL,'Indica si el campo puede ser nulo 1 o no 0',6,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(173,20,'default',5,250,0,1,NULL,NULL,'Valor por defecto para un campo',7,'2019-05-03 09:31:59','2019-05-08 10:50:29'),(174,20,'ref',5,50,0,1,NULL,NULL,'Referencia a otra tabla',8,'2019-05-03 09:34:21','2019-05-08 10:50:29'),(175,20,'comment',5,200,0,1,NULL,NULL,'Comentario para el campo',9,'2019-05-03 09:34:21','2019-05-08 10:50:29'),(176,20,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',11,'2019-05-03 09:34:21','2019-05-08 10:50:29'),(177,20,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',12,'2019-05-03 09:34:21','2019-05-08 10:50:29'),(178,21,'id',1,NULL,1,1,NULL,NULL,'Id único del tipo de include',0,'2019-05-03 09:36:29','2019-05-08 10:50:29'),(179,21,'name',5,50,0,0,NULL,NULL,'Nombre del tipo de include',1,'2019-05-03 09:36:29','2019-05-08 10:50:29'),(180,21,'show_include',7,NULL,0,1,'1',NULL,'Indica si debe mostrarse en la lista de includes disponibles',2,'2019-05-03 09:36:29','2019-05-08 10:50:29'),(181,21,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',3,'2019-05-03 09:36:29','2019-05-08 10:50:29'),(182,21,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',4,'2019-05-03 09:36:29','2019-05-08 10:50:29'),(183,22,'id',1,NULL,1,1,NULL,NULL,'Id único de la version del include',0,'2019-05-03 09:38:52','2019-05-08 10:50:29'),(184,22,'id_include_type',4,NULL,0,0,NULL,'include_type.id','Id del tipo de include',1,'2019-05-03 09:38:52','2019-05-08 10:50:29'),(185,22,'version',5,10,0,0,NULL,NULL,'Número de versión del tipo de include',2,'2019-05-03 09:38:52','2019-05-08 10:50:29'),(186,22,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',3,'2019-05-03 09:38:52','2019-05-08 10:50:29'),(187,22,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',4,'2019-05-03 09:38:52','2019-05-08 10:50:29'),(188,23,'id',1,NULL,1,1,NULL,NULL,'Id único para cada archivo a incluir',0,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(189,23,'id_include_version',4,NULL,0,0,NULL,'include_version.id','Id de la version del include',1,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(190,23,'type',4,NULL,0,0,NULL,NULL,'Tipo de archivo 0 CSS 1 JS',2,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(191,23,'filename',5,50,0,0,NULL,NULL,'Nombre del archivo a incluir',3,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(192,23,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',4,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(193,23,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',5,'2019-05-03 09:42:45','2019-05-08 10:50:29'),(194,24,'id_project',1,NULL,0,1,NULL,'project.id','Id del proyecto en el que se incluye',0,'2019-05-03 09:44:47','2019-05-08 10:50:29'),(195,24,'id_type',1,NULL,0,1,NULL,'include_version.id','Id del tipo de include',1,'2019-05-03 09:44:47','2019-05-08 10:50:29'),(196,24,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',2,'2019-05-03 09:44:47','2019-05-08 10:50:29'),(197,24,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',3,'2019-05-03 09:44:47','2019-05-08 10:50:29'),(198,16,'last_compilation',6,NULL,0,1,NULL,NULL,'Fecha de la última compilación',5,'2019-05-03 12:57:49','2019-05-08 10:50:29'),(199,20,'order',4,NULL,0,0,NULL,NULL,'Orden del campo en el modelo',10,'2019-05-03 13:01:34','2019-05-08 10:50:29'),(200,25,'id',1,NULL,1,1,NULL,NULL,'Clave única de cada usuario',0,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(201,25,'username',5,50,0,0,NULL,NULL,'Nombre de usuario',1,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(202,25,'pass',5,100,0,0,NULL,NULL,'Contraseña del usuario',2,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(203,25,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',3,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(204,25,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',4,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(205,26,'id',1,NULL,1,1,NULL,NULL,'Clave única de cada foto',0,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(206,26,'id_user',4,NULL,0,0,NULL,'user.id','Id del usuario dueño de la foto',1,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(207,26,'title',5,50,0,0,NULL,NULL,'Título de la foto',2,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(208,26,'created_at',2,NULL,0,1,NULL,NULL,'Fecha de creación del registro',3,'2019-05-14 17:37:54','2019-05-17 11:39:25'),(209,26,'updated_at',3,NULL,0,1,NULL,NULL,'Fecha de última modificación del registro',4,'2019-05-14 17:37:54','2019-05-17 11:39:25');
/*!40000 ALTER TABLE `row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada usuario',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre de usuario',
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Contraseña cifrada del usuario',
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` datetime DEFAULT NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'dunedain','$2y$10$5P4ODzjoJH7B2I6km8Qx4eVSPjajcR64XxLVyZlvYqgksvGh1PbXS','2019-04-03 17:04:00','2019-04-03 17:04:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-12 15:57:37
