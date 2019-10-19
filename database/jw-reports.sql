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
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_services`
--

LOCK TABLES `field_services` WRITE;
/*!40000 ALTER TABLE `field_services` DISABLE KEYS */;
INSERT INTO `field_services` VALUES (2,5,3,4,9,42,NULL,75,11,3,'2019-10-01 22:26:50','2019-10-04 23:00:45'),(3,6,3,4,9,13,1,75,13,5,'2019-10-01 22:30:10','2019-10-04 23:06:14'),(4,8,3,4,9,11,2,77,24,6,'2019-10-01 22:33:04','2019-10-04 23:06:25'),(5,1,3,1,9,3,10,12,4,1,'2019-10-01 22:37:32','2019-10-01 22:37:32'),(6,11,3,4,9,27,2,82,15,2,'2019-10-02 23:15:16','2019-10-04 23:06:35'),(7,34,3,1,9,10,1,10,10,2,'2019-10-02 23:16:54','2019-10-02 23:16:54'),(8,4,3,4,9,82,3,90,38,7,'2019-10-02 23:17:53','2019-10-04 23:06:50'),(9,35,3,1,9,24,NULL,20,1,NULL,'2019-10-02 23:19:09','2019-10-02 23:19:09'),(10,16,3,1,9,NULL,NULL,11,2,NULL,'2019-10-02 23:21:39','2019-10-02 23:21:39'),(11,36,3,1,9,17,NULL,23,1,NULL,'2019-10-02 23:22:37','2019-10-02 23:22:37'),(12,18,3,1,9,NULL,1,7,3,1,'2019-10-02 23:23:10','2019-10-02 23:23:10'),(13,37,3,1,9,10,NULL,9,2,NULL,'2019-10-02 23:25:38','2019-10-02 23:25:38'),(14,38,3,1,9,19,5,51,17,6,'2019-10-02 23:27:35','2019-10-02 23:27:35'),(15,12,3,4,9,40,NULL,83,23,NULL,'2019-10-02 23:29:15','2019-10-04 23:07:15'),(16,39,3,1,9,4,NULL,18,3,1,'2019-10-03 17:23:37','2019-10-03 17:23:37'),(17,19,3,1,9,5,NULL,14,2,1,'2019-10-03 17:24:10','2019-10-03 17:24:10'),(18,40,3,1,9,18,NULL,12,NULL,NULL,'2019-10-03 17:25:19','2019-10-03 17:25:19'),(19,15,3,4,9,72,NULL,70,26,4,'2019-10-03 17:25:58','2019-10-04 23:07:33'),(20,41,3,1,9,30,4,25,10,2,'2019-10-03 17:28:16','2019-10-03 17:28:16'),(21,2,3,4,9,5,6,50,2,NULL,'2019-10-03 17:29:32','2019-10-04 23:10:37'),(22,42,3,1,9,NULL,4,7,9,1,'2019-10-03 17:31:29','2019-10-03 17:31:29'),(23,43,3,1,9,NULL,2,5,1,NULL,'2019-10-03 17:31:56','2019-10-03 17:31:56'),(24,7,3,1,9,20,NULL,15,1,NULL,'2019-10-03 17:32:23','2019-10-03 17:32:23'),(25,27,3,4,9,25,4,76,18,5,'2019-10-03 17:33:12','2019-10-04 23:10:58'),(26,44,3,1,9,5,NULL,5,4,3,'2019-10-03 21:58:48','2019-10-03 21:58:48'),(27,48,3,1,9,8,NULL,16,2,NULL,'2019-10-04 11:13:46','2019-10-04 11:13:46'),(28,30,3,1,9,3,NULL,20,4,1,'2019-10-05 11:22:10','2019-10-05 11:22:10'),(29,79,3,1,9,15,NULL,43,7,1,'2019-10-05 14:55:48','2019-10-05 14:55:48'),(30,81,3,1,9,4,NULL,12,NULL,NULL,'2019-10-05 23:46:15','2019-10-05 23:46:15'),(31,22,3,4,9,45,NULL,75,13,2,'2019-10-05 23:49:52','2019-10-05 23:49:52'),(32,84,3,3,9,7,3,43,4,1,'2019-10-05 23:50:30','2019-10-05 23:50:30'),(33,25,3,4,9,5,NULL,66,5,1,'2019-10-05 23:50:57','2019-10-05 23:50:57'),(34,83,3,3,9,32,2,59,17,1,'2019-10-05 23:51:27','2019-10-05 23:51:27'),(35,74,3,1,9,NULL,NULL,10,NULL,NULL,'2019-10-05 23:51:51','2019-10-05 23:51:51'),(36,82,3,1,9,18,NULL,10,2,NULL,'2019-10-05 23:52:39','2019-10-05 23:52:39'),(37,23,3,4,9,10,7,24,16,4,'2019-10-05 23:53:10','2019-10-05 23:53:10'),(38,80,3,1,9,12,NULL,14,NULL,NULL,'2019-10-05 23:53:40','2019-10-05 23:53:40'),(39,31,3,4,9,14,1,72,17,3,'2019-10-05 23:54:18','2019-10-05 23:54:18'),(40,91,3,1,9,7,NULL,6,NULL,NULL,'2019-10-05 23:54:52','2019-10-05 23:54:52'),(41,86,3,1,9,21,NULL,8,NULL,NULL,'2019-10-05 23:55:22','2019-10-05 23:55:22'),(42,87,3,1,9,19,NULL,8,2,NULL,'2019-10-05 23:55:47','2019-10-05 23:55:47'),(43,85,3,1,9,NULL,7,35,3,1,'2019-10-05 23:56:36','2019-10-05 23:56:36'),(44,49,3,3,9,20,NULL,42,30,5,'2019-10-05 23:57:02','2019-10-05 23:57:02'),(45,50,3,1,9,NULL,NULL,15,10,4,'2019-10-05 23:57:39','2019-10-05 23:57:39'),(46,58,3,1,9,31,NULL,25,1,NULL,'2019-10-05 23:58:01','2019-10-05 23:58:01'),(47,51,3,1,9,19,NULL,15,1,1,'2019-10-05 23:58:30','2019-10-05 23:58:30'),(48,62,3,1,9,15,NULL,45,NULL,NULL,'2019-10-05 23:59:30','2019-10-05 23:59:30'),(49,26,3,4,9,37,3,100,37,4,'2019-10-06 00:00:02','2019-10-06 00:00:02'),(50,72,3,1,9,21,NULL,37,2,NULL,'2019-10-06 00:00:28','2019-10-06 00:00:28'),(51,60,3,1,9,17,NULL,6,2,NULL,'2019-10-06 00:00:56','2019-10-06 00:00:56'),(52,67,3,3,9,1,NULL,52,3,2,'2019-10-06 16:26:39','2019-10-06 16:26:39'),(53,97,3,1,9,NULL,NULL,6,NULL,NULL,'2019-10-06 16:27:08','2019-10-06 16:27:08'),(54,46,3,1,9,293,1,55,15,4,'2019-10-06 16:29:03','2019-10-06 16:29:03'),(55,69,3,1,9,5,NULL,8,3,NULL,'2019-10-06 16:30:10','2019-10-06 16:30:10'),(56,56,3,1,9,20,NULL,17,NULL,NULL,'2019-10-06 16:31:04','2019-10-06 16:31:04'),(57,13,3,1,9,15,5,28,6,1,'2019-10-06 23:12:10','2019-10-06 23:12:10'),(58,63,3,1,9,5,NULL,12,NULL,NULL,'2019-10-07 11:24:47','2019-10-07 11:24:47'),(59,21,3,4,9,50,3,72,10,2,'2019-10-07 11:25:27','2019-10-07 11:25:27'),(60,29,3,1,9,5,4,16,11,2,'2019-10-07 11:26:01','2019-10-07 11:26:01'),(61,28,3,4,9,3,1,57,26,3,'2019-10-07 11:26:24','2019-10-07 11:26:24'),(62,59,3,1,9,31,NULL,17,2,1,'2019-10-07 11:27:12','2019-10-07 11:27:12'),(63,57,3,1,9,5,NULL,11,1,NULL,'2019-10-07 15:47:18','2019-10-07 15:47:18'),(64,9,3,1,9,4,NULL,16,5,2,'2019-10-07 21:57:29','2019-10-07 21:57:29'),(65,10,3,4,9,5,1,41,10,3,'2019-10-07 21:58:55','2019-10-07 21:58:55'),(66,52,3,1,9,4,NULL,13,NULL,NULL,'2019-10-07 22:45:09','2019-10-07 22:45:09'),(67,70,3,1,9,2,NULL,10,NULL,NULL,'2019-10-07 22:45:28','2019-10-07 22:45:28'),(68,66,3,1,9,6,NULL,31,2,2,'2019-10-09 09:37:24','2019-10-09 09:37:24'),(69,17,3,1,9,8,1,16,6,1,'2019-10-09 23:32:56','2019-10-09 23:32:56'),(70,24,3,4,9,13,1,64,17,NULL,'2019-10-09 23:33:24','2019-10-09 23:33:24'),(71,61,3,1,9,17,NULL,32,5,2,'2019-10-09 23:34:02','2019-10-09 23:34:02'),(72,68,3,1,9,3,NULL,20,NULL,NULL,'2019-10-09 23:35:00','2019-10-09 23:35:00'),(73,3,3,1,9,42,NULL,41,2,1,'2019-10-09 23:35:33','2019-10-09 23:35:33'),(74,47,3,1,9,8,NULL,10,1,NULL,'2019-10-12 16:00:52','2019-10-12 16:00:52'),(75,53,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-12 16:10:49','2019-10-12 16:10:49'),(76,54,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-12 16:26:39','2019-10-12 16:26:39'),(77,76,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-12 16:28:03','2019-10-12 16:28:03'),(78,75,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-12 16:28:15','2019-10-12 16:28:15'),(79,98,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-12 16:40:14','2019-10-12 16:40:14'),(80,65,3,1,9,NULL,NULL,NULL,NULL,NULL,'2019-10-13 07:11:48','2019-10-13 07:11:48'),(81,45,3,1,9,10,NULL,14,NULL,NULL,'2019-10-13 14:04:16','2019-10-13 14:04:16'),(82,78,3,1,9,9,NULL,4,NULL,NULL,'2019-10-13 14:04:55','2019-10-13 14:04:55'),(83,77,3,1,9,7,NULL,4,NULL,NULL,'2019-10-13 14:05:21','2019-10-13 14:05:21'),(84,20,3,4,9,35,3,60,21,6,'2019-10-13 14:05:53','2019-10-13 14:05:53'),(85,92,3,1,9,6,NULL,4,NULL,NULL,'2019-10-13 21:56:50','2019-10-13 21:56:50'),(86,14,3,1,9,8,NULL,10,NULL,NULL,'2019-10-13 21:57:11','2019-10-13 21:57:11'),(87,94,3,1,9,6,NULL,8,2,NULL,'2019-10-13 21:57:30','2019-10-13 21:57:30'),(88,95,1,1,8,15,NULL,5,2,2,'2019-10-13 22:32:08','2019-10-13 22:32:08'),(89,95,3,1,9,4,NULL,5,3,2,'2019-10-14 18:18:54','2019-10-14 18:18:54');
/*!40000 ALTER TABLE `field_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_members`
--

DROP TABLE IF EXISTS `group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_members`
--

LOCK TABLES `group_members` WRITE;
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
INSERT INTO `group_members` VALUES (1,1,1,'2019-10-04 00:06:23','2019-10-04 00:06:23'),(2,1,13,'2019-10-04 00:09:04','2019-10-04 00:09:04'),(3,1,11,'2019-10-04 00:09:14','2019-10-04 00:09:14'),(4,1,37,'2019-10-04 00:09:23','2019-10-04 00:09:23'),(5,1,49,'2019-10-04 00:09:31','2019-10-04 00:09:31'),(6,1,60,'2019-10-04 00:09:43','2019-10-04 00:09:43'),(8,1,61,'2019-10-04 00:10:13','2019-10-04 00:10:13'),(9,1,79,'2019-10-04 00:11:31','2019-10-04 00:11:31'),(10,1,55,'2019-10-04 00:11:43','2019-10-04 00:11:43'),(11,1,75,'2019-10-04 00:11:59','2019-10-04 00:11:59'),(12,1,74,'2019-10-04 00:12:25','2019-10-04 00:12:25'),(13,1,45,'2019-10-04 00:12:49','2019-10-04 00:12:49'),(14,1,65,'2019-10-04 00:13:00','2019-10-04 00:13:00'),(15,1,22,'2019-10-04 00:13:11','2019-10-04 00:13:11'),(16,2,14,'2019-10-04 00:14:00','2019-10-04 00:14:00'),(17,2,17,'2019-10-04 00:14:12','2019-10-04 00:14:12'),(18,2,5,'2019-10-04 00:14:28','2019-10-04 00:14:28'),(19,2,23,'2019-10-04 00:14:42','2019-10-04 00:14:42'),(20,4,16,'2019-10-04 00:14:53','2019-10-04 00:14:53'),(21,4,9,'2019-10-04 00:15:07','2019-10-04 00:15:07'),(22,4,50,'2019-10-04 00:16:36','2019-10-04 00:16:36'),(23,4,48,'2019-10-04 00:16:49','2019-10-04 00:16:49'),(24,4,42,'2019-10-04 00:17:01','2019-10-04 00:17:01'),(25,4,7,'2019-10-04 00:17:27','2019-10-04 00:17:27'),(26,4,30,'2019-10-04 00:17:36','2019-10-04 00:17:36'),(27,4,66,'2019-10-04 00:17:46','2019-10-04 00:17:46'),(28,3,15,'2019-10-04 00:18:30','2019-10-04 00:18:30'),(29,3,19,'2019-10-04 00:18:44','2019-10-04 00:18:44'),(30,3,3,'2019-10-04 00:18:51','2019-10-04 00:18:51'),(31,3,44,'2019-10-04 00:19:01','2019-10-04 00:19:01'),(32,3,29,'2019-10-04 00:19:13','2019-10-04 00:19:13'),(33,3,77,'2019-10-04 00:19:23','2019-10-04 00:19:23'),(34,3,64,'2019-10-04 00:19:38','2019-10-04 00:19:38'),(35,3,26,'2019-10-04 00:19:51','2019-10-04 00:19:51'),(36,3,21,'2019-10-04 00:20:05','2019-10-04 00:20:05'),(37,3,52,'2019-10-04 00:20:14','2019-10-04 00:20:14'),(38,2,94,'2019-10-06 00:04:07','2019-10-06 00:04:07'),(39,2,93,'2019-10-06 00:04:19','2019-10-06 00:04:19'),(40,2,83,'2019-10-06 00:04:30','2019-10-06 00:04:30'),(41,2,32,'2019-10-06 00:04:42','2019-10-06 00:04:42'),(42,2,85,'2019-10-06 00:06:54','2019-10-06 00:06:54'),(43,2,82,'2019-10-06 00:07:22','2019-10-06 00:07:22'),(44,2,35,'2019-10-06 00:07:54','2019-10-06 00:07:54'),(45,2,80,'2019-10-06 00:08:08','2019-10-06 00:08:08'),(46,2,88,'2019-10-06 00:08:33','2019-10-06 00:08:33'),(47,2,86,'2019-10-06 00:10:35','2019-10-06 00:10:35'),(48,4,76,'2019-10-06 00:11:23','2019-10-06 00:11:23'),(49,1,71,'2019-10-06 00:11:42','2019-10-06 00:11:42'),(50,3,73,'2019-10-06 00:13:44','2019-10-06 00:13:44'),(51,1,2,'2019-10-06 16:50:19','2019-10-06 16:50:19'),(52,1,12,'2019-10-06 16:55:57','2019-10-06 16:55:57'),(53,1,63,'2019-10-06 16:55:57','2019-10-06 16:55:57'),(54,1,62,'2019-10-06 16:56:19','2019-10-06 16:56:19'),(55,1,46,'2019-10-06 16:56:37','2019-10-06 16:56:37'),(56,1,34,'2019-10-06 22:49:59','2019-10-06 22:49:59'),(57,1,41,'2019-10-06 22:49:59','2019-10-06 22:49:59'),(58,3,53,'2019-10-06 22:51:14','2019-10-06 22:51:14'),(59,3,54,'2019-10-06 22:51:14','2019-10-06 22:51:14'),(60,3,70,'2019-10-06 22:51:14','2019-10-06 22:51:14'),(61,1,25,'2019-10-06 23:00:15','2019-10-06 23:00:15'),(62,3,39,'2019-10-06 23:00:27','2019-10-06 23:00:27'),(63,3,69,'2019-10-06 23:00:27','2019-10-06 23:00:27'),(64,3,78,'2019-10-06 23:00:35','2019-10-06 23:00:35'),(65,3,4,'2019-10-06 23:00:43','2019-10-06 23:00:43'),(66,3,8,'2019-10-06 23:00:43','2019-10-06 23:00:43'),(67,3,27,'2019-10-06 23:00:50','2019-10-06 23:00:50'),(68,3,72,'2019-10-06 23:01:05','2019-10-06 23:01:05'),(69,3,40,'2019-10-06 23:01:20','2019-10-06 23:01:20'),(70,3,28,'2019-10-06 23:01:32','2019-10-06 23:01:32'),(71,4,18,'2019-10-06 23:01:44','2019-10-06 23:01:44'),(72,4,36,'2019-10-06 23:01:44','2019-10-06 23:01:44'),(73,4,31,'2019-10-06 23:01:54','2019-10-06 23:01:54'),(74,4,47,'2019-10-06 23:01:54','2019-10-06 23:01:54'),(75,4,68,'2019-10-06 23:01:54','2019-10-06 23:01:54'),(76,4,38,'2019-10-06 23:02:04','2019-10-06 23:02:04'),(77,4,51,'2019-10-06 23:02:04','2019-10-06 23:02:04'),(78,4,56,'2019-10-06 23:02:04','2019-10-06 23:02:04'),(79,4,57,'2019-10-06 23:02:05','2019-10-06 23:02:05'),(80,4,58,'2019-10-06 23:02:05','2019-10-06 23:02:05'),(81,4,10,'2019-10-06 23:02:14','2019-10-06 23:02:14'),(82,4,67,'2019-10-06 23:02:25','2019-10-06 23:02:25'),(83,4,97,'2019-10-06 23:02:25','2019-10-06 23:02:25'),(84,4,59,'2019-10-06 23:03:14','2019-10-06 23:03:14'),(85,4,6,'2019-10-06 23:03:53','2019-10-06 23:03:53'),(86,2,33,'2019-10-06 23:04:06','2019-10-06 23:04:06'),(87,2,92,'2019-10-06 23:04:06','2019-10-06 23:04:06'),(88,2,89,'2019-10-06 23:04:22','2019-10-06 23:04:22'),(89,2,90,'2019-10-06 23:04:22','2019-10-06 23:04:22'),(90,2,91,'2019-10-06 23:05:04','2019-10-06 23:05:04'),(91,2,81,'2019-10-06 23:05:14','2019-10-06 23:05:14'),(92,2,84,'2019-10-06 23:05:15','2019-10-06 23:05:15'),(93,2,20,'2019-10-06 23:05:34','2019-10-06 23:05:34'),(94,2,24,'2019-10-06 23:05:49','2019-10-06 23:05:49'),(95,2,87,'2019-10-06 23:06:04','2019-10-06 23:06:04'),(96,4,43,'2019-10-06 23:06:25','2019-10-06 23:06:25'),(97,2,95,'2019-10-06 23:06:36','2019-10-06 23:06:36'),(98,1,98,'2019-10-06 23:06:46','2019-10-06 23:06:46'),(99,2,96,'2019-10-06 23:07:23','2019-10-06 23:07:23');
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `overseer_id` int(10) unsigned NOT NULL,
  `assistant_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_overseer_id_foreign` (`overseer_id`),
  KEY `groups_assistant_id_foreign` (`assistant_id`),
  CONSTRAINT `groups_assistant_id_foreign` FOREIGN KEY (`assistant_id`) REFERENCES `publishers` (`id`),
  CONSTRAINT `groups_overseer_id_foreign` FOREIGN KEY (`overseer_id`) REFERENCES `publishers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,1,13,'Arnaldo Tavares','2019-10-03 23:30:27','2019-10-03 23:30:27'),(2,14,17,'Vila Norma','2019-10-03 23:38:38','2019-10-03 23:38:38'),(3,15,19,'José Bittencourt','2019-10-03 23:40:19','2019-10-03 23:40:19'),(4,16,9,'Oswaldo Cruz','2019-10-03 23:41:26','2019-10-03 23:41:26');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (1,'2019-09-04',98,NULL,'2019-09-30 01:11:57','2019-10-09 23:36:46'),(2,'2019-09-07',100,NULL,'2019-10-09 23:37:08','2019-10-09 23:37:08'),(3,'2019-09-11',105,NULL,'2019-10-09 23:37:27','2019-10-09 23:37:27'),(4,'2019-09-14',116,NULL,'2019-10-09 23:37:52','2019-10-09 23:37:52'),(5,'2019-09-18',97,NULL,'2019-10-09 23:38:37','2019-10-09 23:38:37'),(6,'2019-09-20',110,NULL,'2019-10-09 23:38:59','2019-10-09 23:38:59'),(7,'2019-09-25',101,NULL,'2019-10-09 23:39:24','2019-10-09 23:39:24'),(8,'2019-09-28',99,NULL,'2019-10-09 23:39:41','2019-10-09 23:39:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (9,'2014_10_12_000000_create_users_table',1),(10,'2014_10_12_100000_create_password_resets_table',1),(11,'2019_08_25_151700_create_service_types_table',1),(12,'2019_08_25_151850_create_publishers_table',1),(13,'2019_09_06_080959_create_publisher_service_types_table',1),(14,'2019_09_06_081506_create_year_services_table',1),(15,'2019_09_06_081609_create_field_services_table',1),(16,'2019_09_06_081953_create_meetings_table',1),(17,'2019_09_29_233239_create_pioneers_table',1),(18,'2019_10_03_231402_create_groups_table',2),(19,'2019_10_13_230756_create_publisher_unhealthies_table',3);
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher_service_types`
--

LOCK TABLES `publisher_service_types` WRITE;
/*!40000 ALTER TABLE `publisher_service_types` DISABLE KEYS */;
INSERT INTO `publisher_service_types` VALUES (1,2,4,'2019-09-01',NULL,'2019-09-30 00:04:34','2019-09-30 00:04:34'),(2,4,4,'2016-12-01',NULL,'2019-09-30 00:37:55','2019-10-01 22:40:02'),(3,2,3,'2019-08-01','2019-08-31','2019-09-30 00:48:49','2019-09-30 00:48:49'),(4,5,4,'2019-01-01',NULL,'2019-10-01 22:25:16','2019-10-01 22:25:16'),(5,6,4,'2014-04-01',NULL,'2019-10-01 22:29:00','2019-10-01 22:29:00'),(6,8,4,'2019-09-01',NULL,'2019-10-01 22:32:30','2019-10-01 22:32:30'),(7,10,4,'2008-11-01',NULL,'2019-10-01 22:41:54','2019-10-01 22:41:54'),(8,11,4,'2014-09-01',NULL,'2019-10-01 22:43:32','2019-10-01 22:43:32'),(9,12,4,'2019-09-01',NULL,'2019-10-01 22:46:31','2019-10-01 22:46:31'),(10,20,4,'2017-06-01',NULL,'2019-10-01 22:57:12','2019-10-01 22:57:12'),(11,21,4,'2018-09-01',NULL,'2019-10-01 23:09:37','2019-10-01 23:09:37'),(12,15,4,'2015-08-01',NULL,'2019-10-01 23:10:02','2019-10-01 23:10:02'),(13,22,4,'2010-09-01',NULL,'2019-10-01 23:10:31','2019-10-01 23:10:31'),(14,23,4,'2008-11-01',NULL,'2019-10-01 23:11:00','2019-10-01 23:11:00'),(15,24,4,'2019-01-01',NULL,'2019-10-01 23:11:21','2019-10-01 23:11:21'),(16,25,4,'2013-09-01',NULL,'2019-10-01 23:11:40','2019-10-01 23:11:40'),(17,26,4,'2010-09-01',NULL,'2019-10-01 23:11:59','2019-10-01 23:11:59'),(18,27,4,'2015-08-01',NULL,'2019-10-01 23:12:25','2019-10-01 23:12:25'),(19,28,4,'2016-09-01',NULL,'2019-10-01 23:13:52','2019-10-01 23:13:52'),(20,19,4,'2006-06-01',NULL,'2019-10-01 23:14:40','2019-10-01 23:14:40'),(21,31,4,'2018-01-01',NULL,'2019-10-01 23:15:00','2019-10-01 23:15:00'),(22,33,4,'2018-02-01',NULL,'2019-10-01 23:15:17','2019-10-01 23:15:17'),(23,67,3,'2017-08-01',NULL,'2019-10-03 22:50:39','2019-10-03 22:50:39'),(24,49,3,'2019-09-01','2019-09-30','2019-10-04 23:41:04','2019-10-04 23:41:04'),(25,83,3,'2019-09-01',NULL,'2019-10-05 23:26:34','2019-10-05 23:26:34'),(26,84,3,'2018-09-01',NULL,'2019-10-05 23:27:06','2019-10-05 23:27:06');
/*!40000 ALTER TABLE `publisher_service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publisher_unhealthies`
--

DROP TABLE IF EXISTS `publisher_unhealthies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publisher_unhealthies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publisher_id` int(10) unsigned NOT NULL,
  `start_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publisher_unhealthies_publisher_id_foreign` (`publisher_id`),
  CONSTRAINT `publisher_unhealthies_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher_unhealthies`
--

LOCK TABLES `publisher_unhealthies` WRITE;
/*!40000 ALTER TABLE `publisher_unhealthies` DISABLE KEYS */;
INSERT INTO `publisher_unhealthies` VALUES (1,71,'2018-01-01','2019-10-13 23:22:14','2019-10-13 23:27:54');
/*!40000 ALTER TABLE `publisher_unhealthies` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` VALUES (1,NULL,'Leandro da Rocha Gonçalves','1986-06-18','2010-12-11',NULL,'2019-09-29 23:36:14','2019-09-29 23:36:14'),(2,1,'Talita Pereira Sousa Gonçalves','1985-10-24','1996-02-04',285629,'2019-09-29 23:36:36','2019-10-01 22:59:18'),(3,NULL,'José Messias de Souza Barbosa','1957-12-25','2008-04-05',NULL,'2019-09-30 00:37:05','2019-10-03 22:26:51'),(4,3,'Sirlene Vasconcellos da Rocha Barbosa','1962-07-05','1975-11-30',90907,'2019-09-30 00:37:22','2019-10-01 22:39:36'),(5,NULL,'Jane Monteiro Escuri da Silva','1961-07-21','1982-04-24',276959,'2019-10-01 22:20:44','2019-10-01 22:24:46'),(6,7,'Katia Cilene Marques dos Santos','1984-08-16','2002-04-20',133447,'2019-10-01 22:28:23','2019-10-01 22:29:31'),(7,NULL,'Thiago Gomes Baptista','1988-01-13','2006-04-01',NULL,'2019-10-01 22:29:19','2019-10-03 22:31:17'),(8,3,'Thayra Vasconcellos da Rocha Barbosa','1990-04-30','2002-08-31',120254,'2019-10-01 22:31:52','2019-10-01 22:31:52'),(9,NULL,'Diego Gomes Baptista','1988-01-13','2004-04-01',NULL,'2019-10-01 22:40:31','2019-10-01 22:50:30'),(10,9,'Daiana Souza de Oliveira Baptista','1994-10-19','2007-03-25',139265,'2019-10-01 22:41:28','2019-10-01 22:41:28'),(11,NULL,'Maria Alice Gomes Baptista','1956-02-16','2008-04-05',204376,'2019-10-01 22:42:56','2019-10-01 22:42:56'),(12,13,'Ana Julia da Silva Barbosa','2003-11-28','2017-12-09',283442,'2019-10-01 22:45:01','2019-10-01 22:46:00'),(13,NULL,'Tiago Araújo Barbosa','1982-06-30','1998-12-12',NULL,'2019-10-01 22:45:46','2019-10-01 22:51:20'),(14,NULL,'Nicanor Henrique Barreto','1962-11-02','1975-12-21',NULL,'2019-10-01 22:48:04','2019-10-01 22:48:04'),(15,NULL,'Kingsley Nkemjika Duru','1968-06-01','1988-01-01',NULL,'2019-10-01 22:48:54','2019-10-01 22:48:54'),(16,NULL,'André Luis Esteves da Rosa','1973-05-18','1995-12-16',NULL,'2019-10-01 22:49:49','2019-10-01 22:49:49'),(17,NULL,'Victor Carneiro da Silva Machado','1992-07-02','2007-05-11',NULL,'2019-10-01 22:52:09','2019-10-01 22:52:09'),(18,16,'Guilherme Souza da Rosa','1998-10-06','2011-12-11',NULL,'2019-10-01 22:52:43','2019-10-01 22:52:43'),(19,NULL,'Fernando Joaquim da Silva','1953-05-05','1983-12-31',NULL,'2019-10-01 22:53:19','2019-10-01 22:53:19'),(20,14,'Natália José da Silva Barreto','1975-12-25','1997-07-19',151066,'2019-10-01 22:54:25','2019-10-01 22:54:25'),(21,NULL,'Renata Maciel da Silva Costa','1975-10-03','2010-12-12',272522,'2019-10-01 22:55:53','2019-10-01 22:55:53'),(22,NULL,'Maria José de Farias Gomes','1949-04-03','1995-07-15',156976,'2019-10-01 22:58:23','2019-10-01 22:58:23'),(23,NULL,'Salita Silva dos Santos Lopes','1977-01-15','2006-11-04',139161,'2019-10-01 23:00:12','2019-10-01 23:00:12'),(24,17,'Sara Santos Machado','1992-01-19','2004-10-23',154752,'2019-10-01 23:00:56','2019-10-01 23:00:56'),(25,74,'Lucimar de Oliveira Mendes','1975-09-15','2009-12-12',194045,'2019-10-01 23:02:05','2019-10-03 22:57:56'),(26,NULL,'Maria Lucilha de Carvalho Moraes','1960-05-13','1988-08-28',53570,'2019-10-01 23:03:04','2019-10-01 23:03:04'),(27,15,'Silvânia da Silva Nóbrega','1977-10-12','1992-04-25',8920,'2019-10-01 23:03:52','2019-10-01 23:03:52'),(28,29,'Sheila Queiroga Pires Werderits','1979-07-12','2014-02-09',237957,'2019-10-01 23:04:47','2019-10-01 23:05:13'),(29,NULL,'Tiago Francisco Rosa Werderits','1985-04-14','1997-04-19',NULL,'2019-10-01 23:04:58','2019-10-03 22:32:41'),(30,NULL,'Antonio Silvestre da Silva','1960-07-14','1987-12-19',NULL,'2019-10-01 23:06:22','2019-10-03 22:28:09'),(31,30,'Valéria Silvestre da Silva','1962-10-08','1987-12-19',262329,'2019-10-01 23:07:07','2019-10-01 23:07:07'),(32,NULL,'Florisvaldo Lemos de Souza','1957-04-28','1981-07-25',NULL,'2019-10-01 23:07:28','2019-10-05 23:35:02'),(33,32,'Iza Oliveira de Souza','1959-01-02','1981-07-25',148584,'2019-10-01 23:08:11','2019-10-01 23:08:11'),(34,37,'Sandra Vasconcellos Rocha','1971-05-25','1985-08-23',NULL,'2019-10-02 23:16:25','2019-10-03 22:44:01'),(35,NULL,'Marlucia Alves França de Souza','1965-01-16','1985-07-30',NULL,'2019-10-02 23:18:42','2019-10-05 23:34:19'),(36,16,'Flávia Maria de Souza da Rosa','1972-11-12','1995-12-16',NULL,'2019-10-02 23:22:10','2019-10-03 23:00:04'),(37,NULL,'Maria Rosa Vasconcellos da Rocha','1934-01-28','1961-04-16',NULL,'2019-10-02 23:25:16','2019-10-03 22:44:48'),(38,50,'Suelen Sant\'ana de Oliveira Silva','1984-05-30','2013-10-26',203829,'2019-10-02 23:26:25','2019-10-03 22:55:35'),(39,19,'Pedro Lucas Maciel Da Silva Mendonça','2001-12-19','2014-06-27',NULL,'2019-10-03 17:23:15','2019-10-03 22:28:30'),(40,21,'Vanderley Correa Costa Júnior','1999-12-13','2015-07-04',NULL,'2019-10-03 17:24:49','2019-10-03 22:35:26'),(41,37,'Shirlei Vasconcellos da Rocha','1964-02-25','1985-08-23',NULL,'2019-10-03 17:27:53','2019-10-03 22:43:23'),(42,NULL,'Paulo Reinaldo Almeida dos Santos','1978-01-16','1997-12-13',NULL,'2019-10-03 17:30:49','2019-10-03 22:27:36'),(43,42,'Jaqueline Simoões Rocha','1980-04-27','1996-08-17',NULL,'2019-10-03 17:31:03','2019-10-03 22:48:21'),(44,NULL,'Sandra Cristina dos Santos Pereira','1975-12-15','1990-10-13',NULL,'2019-10-03 21:57:51','2019-10-05 23:20:12'),(45,NULL,'Iracema Raquel Da Silva','1941-08-15','2001-07-21',NULL,'2019-10-03 22:23:26','2019-10-03 22:23:26'),(46,60,'Ana Maria Cunha da Silva Menezes','1966-03-02','2008-04-05',NULL,'2019-10-03 22:24:09','2019-10-06 16:28:19'),(47,30,'Daniel Silvestre da Silva','1997-05-05','2008-11-15',NULL,'2019-10-03 22:30:08','2019-10-03 22:30:08'),(48,NULL,'Marcelo dos Santos Pimentel','1964-08-11','1995-07-15',NULL,'2019-10-03 22:30:43','2019-10-03 22:30:43'),(49,NULL,'Silas Vasconcellos da Rocha','1974-12-28','1991-10-29',NULL,'2019-10-03 22:31:54','2019-10-03 22:31:54'),(50,NULL,'Carlos Henrique Silva',NULL,'0001-01-01',NULL,'2019-10-03 22:33:18','2019-10-03 22:37:42'),(51,50,'Caio Henrique Rodrigues','2004-06-26','2017-04-15',NULL,'2019-10-03 22:33:51','2019-10-03 22:33:51'),(52,NULL,'Bianca Rodrigues e Silva','1979-03-04','2005-02-22',NULL,'2019-10-03 22:34:11','2019-10-03 22:57:01'),(53,52,'Robert Rodrigues da Silva','2004-07-06','2015-12-12',NULL,'2019-10-03 22:34:40','2019-10-03 22:34:40'),(54,52,'Benaia Rodrigues e Silva','2005-10-05','2015-12-12',NULL,'2019-10-03 22:36:28','2019-10-03 22:36:28'),(55,NULL,'José Carlos dos Santos Freitas','1948-04-26','1978-06-12',NULL,'2019-10-03 22:37:02','2019-10-03 22:37:02'),(56,50,'Yan Lincoln Silva de Oliveira','2009-04-30',NULL,NULL,'2019-10-03 22:38:14','2019-10-03 22:38:14'),(57,50,'Angelo Marcelo Silva Maurício','2002-06-21',NULL,NULL,'2019-10-03 22:38:41','2019-10-03 22:38:41'),(58,50,'Darline Shayene Martins Gonçalves','2004-11-04',NULL,NULL,'2019-10-03 22:39:45','2019-10-03 22:39:45'),(59,48,'Rosemere Brasil Pimentel','1960-03-01','1995-12-15',32558,'2019-10-03 22:40:33','2019-10-03 22:40:56'),(60,NULL,'Beatriz Rodrigues da Silva','1939-04-21','1984-12-08',NULL,'2019-10-03 22:41:56','2019-10-03 22:41:56'),(61,NULL,'Angela Maria Feliciano Leite',NULL,'2016-07-02',NULL,'2019-10-03 22:42:46','2019-10-03 22:42:46'),(62,49,'Brenda Cristiny Alves da Rocha','2007-03-04',NULL,NULL,'2019-10-03 22:45:22','2019-10-03 22:45:22'),(63,13,'Ana Paula da Silva Barbosa','1982-05-31','1997-12-17',NULL,'2019-10-03 22:46:05','2019-10-03 22:46:05'),(64,NULL,'Maria do Carmo Arruda da Silva','1936-12-16','1987-12-19',NULL,'2019-10-03 22:46:39','2019-10-03 22:46:39'),(65,NULL,'Maria C de Souza Caçula','1937-02-06','1969-03-08',NULL,'2019-10-03 22:47:30','2019-10-03 22:47:30'),(66,NULL,'Kelly Cristina Gonçalves Rodrigues','1983-06-05','2018-03-18',NULL,'2019-10-03 22:49:01','2019-10-03 22:49:01'),(67,66,'Katlen Cristina Rodrigues','1999-06-22','2017-04-15',NULL,'2019-10-03 22:49:43','2019-10-03 22:49:43'),(68,30,'Raquel Silvestre da Silva','1992-01-13','2016-07-22',NULL,'2019-10-03 22:51:22','2019-10-03 22:51:22'),(69,19,'Rita Luzia Maciel da Silva','1956-04-10','1989-12-07',NULL,'2019-10-03 22:52:05','2019-10-03 22:52:05'),(70,52,'Emily Rodrigues e Silva','2001-04-23','2014-05-17',NULL,'2019-10-03 22:52:54','2019-10-03 22:52:54'),(71,NULL,'Rosimar de Oliveira Sobrinho',NULL,'1996-03-30',NULL,'2019-10-03 22:53:34','2019-10-03 22:53:34'),(72,26,'Samanta de Carvalho Moraes','1986-07-04','1999-12-11',78906,'2019-10-03 22:53:50','2019-10-03 22:54:35'),(73,NULL,'Maria José Ribeiro da Silva','1978-11-04','0001-01-01',NULL,'2019-10-03 22:56:29','2019-10-03 22:56:29'),(74,NULL,'Vera Lúcia de Oliveira Mendes','1947-06-03','2015-11-22',NULL,'2019-10-03 22:57:44','2019-10-03 22:57:44'),(75,NULL,'Luci dos Santos Nogueira','1946-08-14','1967-09-01',NULL,'2019-10-03 22:58:40','2019-10-03 22:58:40'),(76,NULL,'Ivairda Luiza Mazala de Araújo','1935-06-09','1985-12-21',NULL,'2019-10-03 22:59:22','2019-10-03 22:59:22'),(77,NULL,'Jorge Arthour','1948-08-31','1964-01-02',NULL,'2019-10-03 23:00:25','2019-10-03 23:03:39'),(78,77,'Maria da Conceição Arthour','1949-08-10','1964-10-02',NULL,'2019-10-03 23:01:02','2019-10-03 23:01:02'),(79,NULL,'Alcineia Portes','1969-01-28','1991-01-06',256816,'2019-10-03 23:04:28','2019-10-03 23:04:28'),(80,NULL,'Marli Costa de Araújo de Abreu','1969-12-20','2005-06-20',NULL,'2019-10-05 23:19:31','2019-10-05 23:19:31'),(81,23,'Andrey dos Santos Lopes',NULL,NULL,NULL,'2019-10-05 23:21:28','2019-10-05 23:21:28'),(82,NULL,'Maria Roseli Santos da Silva','1947-11-26','1991-12-01',NULL,'2019-10-05 23:23:41','2019-10-05 23:52:16'),(83,NULL,'Alana Silva Alves de Carvalho','2002-03-22','2019-07-06',NULL,'2019-10-05 23:25:04','2019-10-05 23:25:04'),(84,23,'Adrielly dos Santos Lopes',NULL,'2013-10-26',NULL,'2019-10-05 23:25:56','2019-10-05 23:25:56'),(85,NULL,'Maria da Conceição Silva dos Santos','1943-11-06','1989-07-22',NULL,'2019-10-05 23:28:10','2019-10-05 23:28:10'),(86,NULL,'Valmir A Noblat','1972-12-03','1993-08-13',NULL,'2019-10-05 23:29:31','2019-10-05 23:29:31'),(87,86,'Luciana O Noblat','1982-01-07','1998-05-23',NULL,'2019-10-05 23:30:12','2019-10-05 23:30:12'),(88,NULL,'João Antônio da Silva Júnior','1948-03-06','1981-11-21',NULL,'2019-10-05 23:31:12','2019-10-05 23:31:12'),(89,88,'Maria Terezinha Nascimento da Silva','1959-10-29','1988-11-26',NULL,'2019-10-05 23:31:54','2019-10-05 23:31:54'),(90,88,'Jamile Nascimento da Silva','1978-12-31','1993-05-22',NULL,'2019-10-05 23:32:32','2019-10-05 23:32:32'),(91,80,'Maurício de Araújo de Abreu','2004-12-01',NULL,NULL,'2019-10-05 23:33:17','2019-10-05 23:33:17'),(92,32,'Lígia de Souza','1981-03-10','1996-08-17',NULL,'2019-10-05 23:36:13','2019-10-05 23:36:13'),(93,NULL,'Joselma P Gomes','1980-10-26','2003-02-22',NULL,'2019-10-05 23:37:31','2019-10-05 23:37:31'),(94,NULL,'Rafael Oliveira Souza','1983-12-28','1999-09-04',NULL,'2019-10-05 23:38:10','2019-10-05 23:38:10'),(95,94,'Paula Pessanha Gomes de Souza','1972-09-07','2007-11-03',NULL,'2019-10-05 23:39:07','2019-10-05 23:43:58'),(96,NULL,'Cheila de Carvalho',NULL,'0001-01-01',NULL,'2019-10-06 00:15:59','2019-10-06 00:15:59'),(97,66,'Luiz Henrique',NULL,NULL,NULL,'2019-10-06 00:16:48','2019-10-06 00:17:15'),(98,55,'Marilha Freitas',NULL,'0001-01-01',NULL,'2019-10-06 00:19:58','2019-10-06 00:19:58');
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

-- Dump completed on 2019-10-19  6:33:12
