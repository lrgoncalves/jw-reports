-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 52.67.55.3    Database: jw-reports
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.16.04.1

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
-- Table structure for table `field_services`
--

DROP TABLE IF EXISTS `field_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publisher_id` int(10) unsigned NOT NULL,
  `year_service_id` int(10) unsigned NOT NULL,
  `service_type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `month` int(11) DEFAULT NULL,
  `placements` int(11) DEFAULT NULL,
  `videos` int(11) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `return_visits` int(11) DEFAULT NULL,
  `studies` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_services_publisher_id_foreign` (`publisher_id`),
  KEY `field_services_year_service_id_foreign` (`year_service_id`),
  KEY `field_services_service_type_id_foreign` (`service_type_id`),
  CONSTRAINT `field_services_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`),
  CONSTRAINT `field_services_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`),
  CONSTRAINT `field_services_year_service_id_foreign` FOREIGN KEY (`year_service_id`) REFERENCES `year_services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_services`
--

LOCK TABLES `field_services` WRITE;
/*!40000 ALTER TABLE `field_services` DISABLE KEYS */;
INSERT INTO `field_services` VALUES (2,5,3,1,9,42,NULL,75,11,3,'2019-10-01 22:26:50','2019-10-01 22:26:50'),(3,6,3,1,9,13,1,75,13,5,'2019-10-01 22:30:10','2019-10-01 22:30:10'),(4,8,3,1,9,11,2,77,24,6,'2019-10-01 22:33:04','2019-10-01 22:33:04'),(5,1,3,1,9,3,10,12,4,1,'2019-10-01 22:37:32','2019-10-01 22:37:32');
/*!40000 ALTER TABLE `field_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `attendance` int(11) DEFAULT NULL,
  `observations` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (1,'2019-09-30',92,'teste 1','2019-09-30 01:11:57','2019-09-30 01:12:33');
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (9,'2014_10_12_000000_create_users_table',1),(10,'2014_10_12_100000_create_password_resets_table',1),(11,'2019_08_25_151700_create_service_types_table',1),(12,'2019_08_25_151850_create_publishers_table',1),(13,'2019_09_06_080959_create_publisher_service_types_table',1),(14,'2019_09_06_081506_create_year_services_table',1),(15,'2019_09_06_081609_create_field_services_table',1),(16,'2019_09_06_081953_create_meetings_table',1),(17,'2019_09_29_233239_create_pioneers_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pioneers`
--

DROP TABLE IF EXISTS `pioneers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pioneers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `publisher_id` int(10) unsigned NOT NULL,
  `service_type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `start_at` date NOT NULL,
  `finish_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pioneers_publisher_id_foreign` (`publisher_id`),
  KEY `pioneers_service_type_id_foreign` (`service_type_id`),
  CONSTRAINT `pioneers_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`),
  CONSTRAINT `pioneers_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pioneers`
--

LOCK TABLES `pioneers` WRITE;
/*!40000 ALTER TABLE `pioneers` DISABLE KEYS */;
/*!40000 ALTER TABLE `pioneers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publisher_service_types`
--

DROP TABLE IF EXISTS `publisher_service_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publisher_service_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publisher_id` int(10) unsigned NOT NULL,
  `service_type_id` int(10) unsigned NOT NULL,
  `start_at` date NOT NULL,
  `finish_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publisher_service_types_publisher_id_foreign` (`publisher_id`),
  KEY `publisher_service_types_service_type_id_foreign` (`service_type_id`),
  CONSTRAINT `publisher_service_types_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`),
  CONSTRAINT `publisher_service_types_service_type_id_foreign` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher_service_types`
--

LOCK TABLES `publisher_service_types` WRITE;
/*!40000 ALTER TABLE `publisher_service_types` DISABLE KEYS */;
INSERT INTO `publisher_service_types` VALUES (1,2,4,'2019-09-01',NULL,'2019-09-30 00:04:34','2019-09-30 00:04:34'),(2,4,4,'2016-12-01',NULL,'2019-09-30 00:37:55','2019-10-01 22:40:02'),(3,2,3,'2019-08-01','2019-08-31','2019-09-30 00:48:49','2019-09-30 00:48:49'),(4,5,4,'2019-01-01',NULL,'2019-10-01 22:25:16','2019-10-01 22:25:16'),(5,6,4,'2014-04-01',NULL,'2019-10-01 22:29:00','2019-10-01 22:29:00'),(6,8,4,'2019-09-01',NULL,'2019-10-01 22:32:30','2019-10-01 22:32:30'),(7,10,4,'2008-11-01',NULL,'2019-10-01 22:41:54','2019-10-01 22:41:54'),(8,11,4,'2014-09-01',NULL,'2019-10-01 22:43:32','2019-10-01 22:43:32'),(9,12,4,'2019-09-01',NULL,'2019-10-01 22:46:31','2019-10-01 22:46:31'),(10,20,4,'2017-06-01',NULL,'2019-10-01 22:57:12','2019-10-01 22:57:12'),(11,21,4,'2018-09-01',NULL,'2019-10-01 23:09:37','2019-10-01 23:09:37'),(12,15,4,'2015-08-01',NULL,'2019-10-01 23:10:02','2019-10-01 23:10:02'),(13,22,4,'2010-09-01',NULL,'2019-10-01 23:10:31','2019-10-01 23:10:31'),(14,23,4,'2008-11-01',NULL,'2019-10-01 23:11:00','2019-10-01 23:11:00'),(15,24,4,'2019-01-01',NULL,'2019-10-01 23:11:21','2019-10-01 23:11:21'),(16,25,4,'2013-09-01',NULL,'2019-10-01 23:11:40','2019-10-01 23:11:40'),(17,26,4,'2010-09-01',NULL,'2019-10-01 23:11:59','2019-10-01 23:11:59'),(18,27,4,'2015-08-01',NULL,'2019-10-01 23:12:25','2019-10-01 23:12:25'),(19,28,4,'2016-09-01',NULL,'2019-10-01 23:13:52','2019-10-01 23:13:52'),(20,19,4,'2006-06-01',NULL,'2019-10-01 23:14:40','2019-10-01 23:14:40'),(21,31,4,'2018-01-01',NULL,'2019-10-01 23:15:00','2019-10-01 23:15:00'),(22,33,4,'2018-02-01',NULL,'2019-10-01 23:15:17','2019-10-01 23:15:17');
/*!40000 ALTER TABLE `publisher_service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publishers`
--

DROP TABLE IF EXISTS `publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publishers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `householder_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `baptize_date` date DEFAULT NULL,
  `pioneer_code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publishers_householder_id_foreign` (`householder_id`),
  CONSTRAINT `publishers_householder_id_foreign` FOREIGN KEY (`householder_id`) REFERENCES `publishers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` VALUES (1,NULL,'Leandro da Rocha Gonçalves','1986-06-18','2010-12-11',NULL,'2019-09-29 23:36:14','2019-09-29 23:36:14'),(2,1,'Talita Pereira Sousa Gonçalves','1985-10-24','1996-02-04',285629,'2019-09-29 23:36:36','2019-10-01 22:59:18'),(3,NULL,'José Messias de Souza Barbosa',NULL,NULL,NULL,'2019-09-30 00:37:05','2019-10-01 22:38:42'),(4,3,'Sirlene Vasconcellos da Rocha Barbosa','1962-07-05','1975-11-30',90907,'2019-09-30 00:37:22','2019-10-01 22:39:36'),(5,NULL,'Jane Monteiro Escuri da Silva','1961-07-21','1982-04-24',276959,'2019-10-01 22:20:44','2019-10-01 22:24:46'),(6,7,'Katia Cilene Marques dos Santos','1984-08-16','2002-04-20',133447,'2019-10-01 22:28:23','2019-10-01 22:29:31'),(7,NULL,'Thiago Gomes Baptista',NULL,NULL,NULL,'2019-10-01 22:29:19','2019-10-01 22:29:19'),(8,3,'Thayra Vasconcellos da Rocha Barbosa','1990-04-30','2002-08-31',120254,'2019-10-01 22:31:52','2019-10-01 22:31:52'),(9,NULL,'Diego Gomes Baptista','1988-01-13','2004-04-01',NULL,'2019-10-01 22:40:31','2019-10-01 22:50:30'),(10,9,'Daiana Souza de Oliveira Baptista','1994-10-19','2007-03-25',139265,'2019-10-01 22:41:28','2019-10-01 22:41:28'),(11,NULL,'Maria Alice Gomes Baptista','1956-02-16','2008-04-05',204376,'2019-10-01 22:42:56','2019-10-01 22:42:56'),(12,13,'Ana Julia da Silva Barbosa','2003-11-28','2017-12-09',283442,'2019-10-01 22:45:01','2019-10-01 22:46:00'),(13,NULL,'Tiago Araújo Barbosa','1982-06-30','1998-12-12',NULL,'2019-10-01 22:45:46','2019-10-01 22:51:20'),(14,NULL,'Nicanor Henrique Barreto','1962-11-02','1975-12-21',NULL,'2019-10-01 22:48:04','2019-10-01 22:48:04'),(15,NULL,'Kingsley Nkemjika Duru','1968-06-01','1988-01-01',NULL,'2019-10-01 22:48:54','2019-10-01 22:48:54'),(16,NULL,'André Luis Esteves da Rosa','1973-05-18','1995-12-16',NULL,'2019-10-01 22:49:49','2019-10-01 22:49:49'),(17,NULL,'Victor Carneiro da Silva Machado','1992-07-02','2007-05-11',NULL,'2019-10-01 22:52:09','2019-10-01 22:52:09'),(18,16,'Guilherme Souza da Rosa','1998-10-06','2011-12-11',NULL,'2019-10-01 22:52:43','2019-10-01 22:52:43'),(19,NULL,'Fernando Joaquim da Silva','1953-05-05','1983-12-31',NULL,'2019-10-01 22:53:19','2019-10-01 22:53:19'),(20,14,'Natália José da Silva Barreto','1975-12-25','1997-07-19',151066,'2019-10-01 22:54:25','2019-10-01 22:54:25'),(21,NULL,'Renata Maciel da Silva Costa','1975-10-03','2010-12-12',272522,'2019-10-01 22:55:53','2019-10-01 22:55:53'),(22,NULL,'Maria José de Farias Gomes','1949-04-03','1995-07-15',156976,'2019-10-01 22:58:23','2019-10-01 22:58:23'),(23,NULL,'Salita Silva dos Santos Lopes','1977-01-15','2006-11-04',139161,'2019-10-01 23:00:12','2019-10-01 23:00:12'),(24,17,'Sara Santos Machado','1992-01-19','2004-10-23',154752,'2019-10-01 23:00:56','2019-10-01 23:00:56'),(25,NULL,'Lucimar de Oliveira Mendes','1975-09-15','2009-12-12',194045,'2019-10-01 23:02:05','2019-10-01 23:02:05'),(26,NULL,'Maria Lucilha de Carvalho Moraes','1960-05-13','1988-08-28',53570,'2019-10-01 23:03:04','2019-10-01 23:03:04'),(27,15,'Silvânia da Silva Nóbrega','1977-10-12','1992-04-25',8920,'2019-10-01 23:03:52','2019-10-01 23:03:52'),(28,29,'Sheila Queiroga Pires Werderits','1979-07-12','2014-02-09',237957,'2019-10-01 23:04:47','2019-10-01 23:05:13'),(29,NULL,'Tiago Francisco Rosa Werderits',NULL,NULL,NULL,'2019-10-01 23:04:58','2019-10-01 23:04:58'),(30,NULL,'Antonio Silvestre da Silva',NULL,NULL,NULL,'2019-10-01 23:06:22','2019-10-01 23:06:22'),(31,30,'Valéria Silvestre da Silva','1962-10-08','1987-12-19',262329,'2019-10-01 23:07:07','2019-10-01 23:07:07'),(32,NULL,'Florisvaldo Lemos de Souza',NULL,NULL,NULL,'2019-10-01 23:07:28','2019-10-01 23:07:28'),(33,32,'Iza Oliveira de Souza','1959-01-02','1981-07-25',148584,'2019-10-01 23:08:11','2019-10-01 23:08:11');
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_types`
--

DROP TABLE IF EXISTS `service_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_types`
--

LOCK TABLES `service_types` WRITE;
/*!40000 ALTER TABLE `service_types` DISABLE KEYS */;
INSERT INTO `service_types` VALUES (1,'Publicador','2019-09-29 23:34:44','2019-09-29 23:34:44'),(2,'Pioneiro Auxiliar 30h','2019-09-29 23:34:44','2019-09-29 23:34:44'),(3,'Pioneiro Auxiliar 50h','2019-09-29 23:34:45','2019-09-29 23:34:45'),(4,'Pioneiro Regular','2019-09-29 23:34:45','2019-09-29 23:34:45');
/*!40000 ALTER TABLE `service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Leandro','leandro.rocha@bennu.tv','$2y$10$eu4ZiDM2gkk7Bb3O3n8U8OBk1oFUiY50sLDIi8K7CtYn4Bvuh6sRC',NULL,'2019-09-29 23:34:45','2019-09-29 23:34:45',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `year_services`
--

DROP TABLE IF EXISTS `year_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `year_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_at` date NOT NULL,
  `finish_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `year_services`
--

LOCK TABLES `year_services` WRITE;
/*!40000 ALTER TABLE `year_services` DISABLE KEYS */;
INSERT INTO `year_services` VALUES (1,'2018-09-01','2019-08-31','2019-09-29 23:35:12','2019-09-29 23:35:12'),(3,'2019-09-01','2020-08-31','2019-10-01 22:20:06','2019-10-01 22:20:06');
/*!40000 ALTER TABLE `year_services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-01 23:16:49
