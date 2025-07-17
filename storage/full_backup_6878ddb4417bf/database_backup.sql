-- MySQL dump 10.13  Distrib 9.3.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: posnex
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'Super Admin','superadmin','Imported Inventory from Excel','Imported 666 items from file: 07Jul2025_Products.xlsx','2025-07-15 05:00:14','2025-07-15 05:00:14'),(2,2,'Muwahid','employee','Created Sale','Sale Code: H001-00001, Customer: muwahid, Amount: 2882.88','2025-07-15 05:11:15','2025-07-15 05:11:15'),(3,2,'Muwahid','employee','Created Sale','Sale Code: H001-00001, Customer: hi, Amount: 2777.28','2025-07-15 05:47:52','2025-07-15 05:47:52'),(4,2,'Muwahid','employee','Created Sale','Sale Code: H001-00002, Customer: ahmed, Amount: 2777.28','2025-07-15 05:56:36','2025-07-15 05:56:36'),(5,2,'Muwahid','employee','Deleted Sale','Sale Code: H001-00001, Customer: hi, Amount: 2777.28','2025-07-15 06:11:53','2025-07-15 06:11:53'),(6,2,'Muwahid','employee','Deleted Sale','Sale Code: H001-00002, Customer: ahmed, Amount: 2777.28','2025-07-15 06:11:57','2025-07-15 06:11:57'),(7,1,'Super Admin','superadmin','Created Sale','Sale Code: H001-00001, Customer: TEST, Amount: 2777.28','2025-07-15 06:18:33','2025-07-15 06:18:33'),(8,1,'Super Admin','superadmin','Updated Sale','Sale Code: H001-00001, Customer: TEST, Amount: 2777.28','2025-07-15 06:26:55','2025-07-15 06:26:55'),(9,1,'Super Admin','superadmin','Deleted Sale','Sale Code: H001-00001, Customer: TEST, Amount: 2777.28','2025-07-15 06:32:51','2025-07-15 06:32:51'),(10,1,'Super Admin','superadmin','Created Sale','Sale Code: H001-00001, Customer: LI, Amount: 2777.28','2025-07-15 06:33:15','2025-07-15 06:33:15'),(11,1,'Super Admin','superadmin','Updated Sale','Sale Code: H001-00001, Customer: LI, Amount: 5554.56','2025-07-15 06:34:55','2025-07-15 06:34:55'),(12,1,'Super Admin','superadmin','Updated Sale','Sale Code: H001-00001, Customer: LI, Amount: 5554.56','2025-07-15 06:36:26','2025-07-15 06:36:26'),(13,1,'Super Admin','superadmin','Updated Sale','Sale Code: H001-00001, Customer: LI, Amount: 8331.84','2025-07-15 06:40:56','2025-07-15 06:40:56'),(14,1,'Super Admin','superadmin','Deleted Sale','Sale Code: H001-00001, Customer: LI, Amount: 8331.84','2025-07-15 06:43:42','2025-07-15 06:43:42'),(15,1,'Super Admin','superadmin','Imported Inventory from Excel','Imported 666 items from file: 07Jul2025_Products.xlsx','2025-07-15 09:58:52','2025-07-15 09:58:52'),(16,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00001, Customer: 22, Amount: 2761.5','2025-07-15 10:05:34','2025-07-15 10:05:34'),(17,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00001, Customer: 22, Amount: 2761.50','2025-07-15 10:06:50','2025-07-15 10:06:50'),(18,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00001, Customer: ji, Amount: 2761.5','2025-07-15 21:24:08','2025-07-15 21:24:08'),(19,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00002, Customer: hi, Amount: 3141.6','2025-07-15 21:27:17','2025-07-15 21:27:17'),(20,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00002, Customer: hi, Amount: 3141.60','2025-07-15 21:27:37','2025-07-15 21:27:37'),(21,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00001, Customer: ji, Amount: 2761.50','2025-07-15 21:27:42','2025-07-15 21:27:42'),(22,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00001, Customer: ehloo, Amount: 3335.4','2025-07-15 21:28:15','2025-07-15 21:28:15'),(23,1,'Super Admin','superadmin','Updated Sale','Sale Code: D003-00001, Customer: ehloo, Amount: 12688.8','2025-07-15 21:30:32','2025-07-15 21:30:32'),(24,1,'Super Admin','superadmin','Updated Sale','Sale Code: D003-00001, Customer: ehloo, Amount: 22939.8','2025-07-15 21:34:16','2025-07-15 21:34:16'),(25,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00002, Customer: jl, Amount: 3302.7','2025-07-15 21:36:26','2025-07-15 21:36:26'),(26,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00002, Customer: jl, Amount: 3302.70','2025-07-15 21:47:06','2025-07-15 21:47:06'),(27,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00001, Customer: ehloo, Amount: 22939.80','2025-07-15 21:47:09','2025-07-15 21:47:09'),(28,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00001, Customer: hey, Amount: 101','2025-07-15 21:50:19','2025-07-15 21:50:19'),(29,1,'Super Admin','superadmin','Data Exported','Exported Inventory Catalogue as PDF','2025-07-15 21:56:28','2025-07-15 21:56:28'),(30,1,'Super Admin','superadmin','Data Exported','Exported Inventory Catalogue as PDF','2025-07-15 21:56:48','2025-07-15 21:56:48'),(31,1,'Super Admin','superadmin','Data Exported','Exported Inventory as Excel','2025-07-15 21:57:27','2025-07-15 21:57:27'),(32,1,'Super Admin','superadmin','Created Inventory Item','Inventory Item: new adding','2025-07-15 21:59:06','2025-07-15 21:59:06'),(33,1,'Super Admin','superadmin','Updated Inventory Item','Inventory Item: new adding','2025-07-15 21:59:23','2025-07-15 21:59:23'),(34,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00002, Customer: jk, Amount: 3302.7','2025-07-15 22:06:19','2025-07-15 22:06:19'),(35,1,'Super Admin','superadmin','Changed Inventory Status','Item: new adding, Status: active → inactive','2025-07-15 22:25:11','2025-07-15 22:25:11'),(36,1,'Super Admin','superadmin','Changed Inventory Status','Item: new adding, Status: inactive → active','2025-07-15 22:25:55','2025-07-15 22:25:55'),(37,1,'Super Admin','superadmin','Bulk Deleted Inventory Items','Deleted 1 items: new adding','2025-07-15 22:26:55','2025-07-15 22:26:55'),(38,1,'Super Admin','superadmin','Created Supplier','Supplier: Muwahid','2025-07-15 23:33:01','2025-07-15 23:33:01'),(39,1,'Super Admin','superadmin','Created Purchase','Purchase: Supplier: Muwahid, Amount: 100','2025-07-15 23:34:46','2025-07-15 23:34:46'),(40,1,'Super Admin','superadmin','Data Exported','Exported Purchase Invoice as PDF','2025-07-15 23:34:47','2025-07-15 23:34:47'),(41,1,'Super Admin','superadmin','Created Supplier','Supplier: ahmed','2025-07-15 23:37:00','2025-07-15 23:37:00'),(42,1,'Super Admin','superadmin','Created Purchase','Purchase: Supplier: ahmed, Amount: 100','2025-07-15 23:37:44','2025-07-15 23:37:44'),(43,1,'Super Admin','superadmin','Data Exported','Exported Purchase Invoice as PDF','2025-07-15 23:37:45','2025-07-15 23:37:45'),(44,1,'Super Admin','superadmin','Data Exported','Exported Purchase Invoice as PDF','2025-07-16 01:11:45','2025-07-16 01:11:45'),(45,1,'Super Admin','superadmin','Created Customer','Customer: 8899','2025-07-16 04:07:28','2025-07-16 04:07:28'),(46,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 04:07:37','2025-07-16 04:07:37'),(47,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 04:07:38','2025-07-16 04:07:38'),(48,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00002, Customer: jk, Amount: 3302.70','2025-07-16 04:10:03','2025-07-16 04:10:03'),(49,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00001, Customer: hey, Amount: 101.00','2025-07-16 04:10:09','2025-07-16 04:10:09'),(50,1,'Super Admin','superadmin','Created Customer','Customer: ali','2025-07-16 04:10:45','2025-07-16 04:10:45'),(51,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00001, Customer: ali, Amount: 2972.43','2025-07-16 04:25:40','2025-07-16 04:25:40'),(52,1,'Super Admin','superadmin','Data Exported','Exported All Customers Report as PDF','2025-07-16 04:38:54','2025-07-16 04:38:54'),(53,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 04:39:10','2025-07-16 04:39:10'),(54,1,'Super Admin','superadmin','Data Exported','Exported Customer History as PDF','2025-07-16 04:41:16','2025-07-16 04:41:16'),(55,1,'Super Admin','superadmin','Data Exported','Exported Customer History as PDF','2025-07-16 04:41:30','2025-07-16 04:41:30'),(56,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 04:41:34','2025-07-16 04:41:34'),(57,1,'Super Admin','superadmin','Updated Sale','Sale Code: D003-00001, Customer: ali, Amount: 5944.86','2025-07-16 04:42:11','2025-07-16 04:42:11'),(58,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 04:43:19','2025-07-16 04:43:19'),(59,1,'Super Admin','superadmin','Created Sale','Sale Code: D003-00002, Customer: ali, Amount: 3400.67','2025-07-16 04:44:02','2025-07-16 04:44:02'),(60,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 04:44:23','2025-07-16 04:44:23'),(61,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 10:06:00','2025-07-16 10:06:00'),(62,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 10:06:21','2025-07-16 10:06:21'),(63,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00001, Customer: ali, Amount: 5944.86','2025-07-16 10:16:44','2025-07-16 10:16:44'),(64,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 10:17:04','2025-07-16 10:17:04'),(65,1,'Super Admin','superadmin','Created Payment','Customer ID: 1, Amount: 1000, Note: ','2025-07-16 10:17:20','2025-07-16 10:17:20'),(66,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 10:17:21','2025-07-16 10:17:21'),(67,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 10:17:46','2025-07-16 10:17:46'),(68,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 10:18:12','2025-07-16 10:18:12'),(69,1,'Super Admin','superadmin','Created Payment','Customer ID: 2, Amount: 2000, Note: ','2025-07-16 10:18:30','2025-07-16 10:18:30'),(70,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 10:18:31','2025-07-16 10:18:31'),(71,1,'Super Admin','superadmin','Data Exported','Exported All Customers Report as PDF','2025-07-16 10:29:26','2025-07-16 10:29:26'),(72,1,'Super Admin','superadmin','Data Exported','Exported All Customers Report as PDF','2025-07-16 10:35:25','2025-07-16 10:35:25'),(73,1,'Super Admin','superadmin','Data Exported','Exported All Customers Report as PDF','2025-07-16 10:55:12','2025-07-16 10:55:12'),(74,1,'Super Admin','superadmin','Data Exported','Exported Customer History as PDF','2025-07-16 10:55:17','2025-07-16 10:55:17'),(75,1,'Super Admin','superadmin','Data Exported','Exported Customer History as PDF','2025-07-16 11:02:25','2025-07-16 11:02:25'),(76,1,'Super Admin','superadmin','Data Exported','Exported All Customers Report as PDF','2025-07-16 11:04:22','2025-07-16 11:04:22'),(77,1,'Super Admin','superadmin','Data Exported','Exported Customer History as PDF','2025-07-16 11:06:35','2025-07-16 11:06:35'),(78,1,'Super Admin','superadmin','Viewed Customer History','Customer: 8899','2025-07-16 11:06:42','2025-07-16 11:06:42'),(79,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 11:06:51','2025-07-16 11:06:51'),(80,1,'Super Admin','superadmin','Processed Return','Sale ID: 14, Customer: ali','2025-07-16 11:23:53','2025-07-16 11:23:53'),(81,1,'Super Admin','superadmin','Deleted Sale','Sale Code: D003-00002, Customer: ali, Amount: 3400.67','2025-07-16 11:26:03','2025-07-16 11:26:03'),(82,1,'Super Admin','superadmin','Created Sale','Sale Code: I003-00001, Customer: ali, Amount: 4781.34','2025-07-16 11:26:59','2025-07-16 11:26:59'),(83,1,'Super Admin','superadmin','Processed Return','Sale ID: 15, Customer: ali','2025-07-16 11:28:32','2025-07-16 11:28:32'),(84,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 11:29:05','2025-07-16 11:29:05'),(85,1,'Super Admin','superadmin','Deleted Sale','Sale Code: I003-00001, Customer: ali, Amount: 4781.34','2025-07-16 11:30:02','2025-07-16 11:30:02'),(86,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 11:32:20','2025-07-16 11:32:20'),(87,1,'Super Admin','superadmin','Viewed Customer History','Customer: ali','2025-07-16 11:32:29','2025-07-16 11:32:29'),(88,1,'Super Admin','superadmin','Deleted Customer','Customer: 8899','2025-07-16 11:39:25','2025-07-16 11:39:25'),(89,1,'Super Admin','superadmin','Deleted Customer','Customer: ali','2025-07-16 11:39:29','2025-07-16 11:39:29'),(90,1,'Super Admin','superadmin','Deleted Supplier','Supplier: Muwahid','2025-07-16 11:42:39','2025-07-16 11:42:39'),(91,1,'Super Admin','superadmin','Created Sale','Sale Code: I003-00001, Customer: jkjk, Amount: 505','2025-07-16 11:48:40','2025-07-16 11:48:40'),(92,1,'Super Admin','superadmin','Created Distributor','Distributor: Muwahid','2025-07-16 12:02:14','2025-07-16 12:02:14'),(93,1,'Super Admin','superadmin','Viewed Distributor History','Muwahid','2025-07-16 12:04:27','2025-07-16 12:04:27'),(94,1,'Super Admin','superadmin','Data Exported','Exported Distributor History as PDF','2025-07-16 12:04:32','2025-07-16 12:04:32'),(95,1,'Super Admin','superadmin','Created Distributor','Distributor: osman','2025-07-16 12:09:31','2025-07-16 12:09:31'),(96,1,'Super Admin','superadmin','Deleted Distributor','Distributor: osman','2025-07-16 12:09:43','2025-07-16 12:09:43'),(97,1,'Super Admin','superadmin','Data Exported','Exported Distributor History as PDF','2025-07-16 12:10:09','2025-07-16 12:10:09'),(98,1,'Super Admin','superadmin','Data Exported','Exported Distributor History as PDF','2025-07-16 12:10:25','2025-07-16 12:10:25'),(99,1,'Super Admin','superadmin','Data Exported','Exported Distributor History as PDF','2025-07-16 12:22:43','2025-07-16 12:22:43'),(100,1,'Super Admin','admin','Created Shopkeeper','Shopkeeper: ali','2025-07-16 12:37:54','2025-07-16 12:37:54'),(101,1,'Super Admin','admin','Created Sale','Sale Code: I003-00002, Customer: , Amount: 9562.68','2025-07-16 12:44:05','2025-07-16 12:44:05'),(102,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 12:44:57','2025-07-16 12:44:57'),(103,1,'Super Admin','admin','Data Exported','Exported Shopkeeper History as PDF','2025-07-16 12:57:33','2025-07-16 12:57:33'),(104,1,'Super Admin','admin','Data Exported','Exported All Shopkeepers Report as PDF','2025-07-16 12:57:50','2025-07-16 12:57:50'),(105,1,'Super Admin','admin','Data Exported','Exported Distributor History as PDF','2025-07-16 13:03:17','2025-07-16 13:03:17'),(106,1,'Super Admin','admin','Created Sale','Sale Code: I003-00003, Customer: , Amount: 8917.29','2025-07-16 13:03:48','2025-07-16 13:03:48'),(107,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:04:19','2025-07-16 13:04:19'),(108,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:04:49','2025-07-16 13:04:49'),(109,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:04:55','2025-07-16 13:04:55'),(110,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:05:46','2025-07-16 13:05:46'),(111,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:06:12','2025-07-16 13:06:12'),(112,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:06:21','2025-07-16 13:06:21'),(113,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:07:23','2025-07-16 13:07:23'),(114,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:15:06','2025-07-16 13:15:06'),(115,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:15:15','2025-07-16 13:15:15'),(116,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:15:32','2025-07-16 13:15:32'),(117,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:15:43','2025-07-16 13:15:43'),(118,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:15:55','2025-07-16 13:15:55'),(119,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:09','2025-07-16 13:16:09'),(120,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:10','2025-07-16 13:16:10'),(121,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:20','2025-07-16 13:16:20'),(122,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:48','2025-07-16 13:16:48'),(123,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:57','2025-07-16 13:16:57'),(124,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:16:59','2025-07-16 13:16:59'),(125,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:17:04','2025-07-16 13:17:04'),(126,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:17:43','2025-07-16 13:17:43'),(127,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:17:44','2025-07-16 13:17:44'),(128,1,'Super Admin','admin','Data Exported','Exported Shopkeeper History as PDF','2025-07-16 13:38:45','2025-07-16 13:38:45'),(129,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:38:53','2025-07-16 13:38:53'),(130,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:41:36','2025-07-16 13:41:36'),(131,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:42:05','2025-07-16 13:42:05'),(132,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:48:55','2025-07-16 13:48:55'),(133,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:49:22','2025-07-16 13:49:22'),(134,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:49:32','2025-07-16 13:49:32'),(135,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:49:55','2025-07-16 13:49:55'),(136,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:50:23','2025-07-16 13:50:23'),(137,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:50:46','2025-07-16 13:50:46'),(138,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:51:04','2025-07-16 13:51:04'),(139,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:51:16','2025-07-16 13:51:16'),(140,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 13:54:58','2025-07-16 13:54:58'),(141,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 13:55:21','2025-07-16 13:55:21'),(142,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:00:54','2025-07-16 14:00:54'),(143,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:03:10','2025-07-16 14:03:10'),(144,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:03:18','2025-07-16 14:03:18'),(145,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:03:42','2025-07-16 14:03:42'),(146,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:04:20','2025-07-16 14:04:20'),(147,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:04:59','2025-07-16 14:04:59'),(148,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:05:12','2025-07-16 14:05:12'),(149,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 14:06:30','2025-07-16 14:06:30'),(150,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:06:39','2025-07-16 14:06:39'),(151,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:07:17','2025-07-16 14:07:17'),(152,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:08:03','2025-07-16 14:08:03'),(153,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:11:07','2025-07-16 14:11:07'),(154,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:15:11','2025-07-16 14:15:11'),(155,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:15:44','2025-07-16 14:15:44'),(156,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 14:16:31','2025-07-16 14:16:31'),(157,1,'Super Admin','admin','Deleted Supplier','Supplier: ahmed','2025-07-16 14:21:29','2025-07-16 14:21:29'),(158,1,'Super Admin','admin','Data Exported','Exported All Shopkeepers Report as PDF','2025-07-16 16:46:25','2025-07-16 16:46:25'),(159,1,'Super Admin','admin','Data Exported','Exported Shopkeeper History as PDF','2025-07-16 16:46:29','2025-07-16 16:46:29'),(160,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:46:52','2025-07-16 16:46:52'),(161,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:47:55','2025-07-16 16:47:55'),(162,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:47:59','2025-07-16 16:47:59'),(163,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:48:13','2025-07-16 16:48:13'),(164,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:48:25','2025-07-16 16:48:25'),(165,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:48:57','2025-07-16 16:48:57'),(166,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:49:05','2025-07-16 16:49:05'),(167,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:49:24','2025-07-16 16:49:24'),(168,1,'Super Admin','admin','Data Exported','Exported Shopkeeper History as PDF','2025-07-16 16:50:38','2025-07-16 16:50:38'),(169,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:50:46','2025-07-16 16:50:46'),(170,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:50:54','2025-07-16 16:50:54'),(171,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:51:46','2025-07-16 16:51:46'),(172,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:51:54','2025-07-16 16:51:54'),(173,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-16 16:52:24','2025-07-16 16:52:24'),(174,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:55:10','2025-07-16 16:55:10'),(175,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 16:59:38','2025-07-16 16:59:38'),(176,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:00:39','2025-07-16 17:00:39'),(177,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:03:53','2025-07-16 17:03:53'),(178,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:04:36','2025-07-16 17:04:36'),(179,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:05:05','2025-07-16 17:05:05'),(180,1,'Super Admin','admin','Created Supplier','Supplier: sss','2025-07-16 17:09:18','2025-07-16 17:09:18'),(181,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:14:24','2025-07-16 17:14:24'),(182,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:14:36','2025-07-16 17:14:36'),(183,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:16:43','2025-07-16 17:16:43'),(184,1,'Super Admin','admin','Updated Supplier','Supplier: ssss','2025-07-16 17:19:45','2025-07-16 17:19:45'),(185,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 17:27:08','2025-07-16 17:27:08'),(186,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-16 18:03:01','2025-07-16 18:03:01'),(187,1,'Super Admin','admin','Deleted Supplier','Supplier: ssss','2025-07-17 01:01:32','2025-07-17 01:01:32'),(188,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:02:38','2025-07-17 01:02:38'),(189,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:06:40','2025-07-17 01:06:40'),(190,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:07:56','2025-07-17 01:07:56'),(191,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:10:42','2025-07-17 01:10:42'),(192,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:13:23','2025-07-17 01:13:23'),(193,1,'Super Admin','admin','Viewed Distributor','Muwahid','2025-07-17 01:13:50','2025-07-17 01:13:50'),(194,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:14:10','2025-07-17 01:14:10'),(195,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:15:34','2025-07-17 01:15:34'),(196,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:19:03','2025-07-17 01:19:03'),(197,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:19:59','2025-07-17 01:19:59'),(198,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-17 01:20:05','2025-07-17 01:20:05'),(199,1,'Super Admin','admin','Viewed Shopkeeper','ali','2025-07-17 01:21:11','2025-07-17 01:21:11'),(200,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:21:33','2025-07-17 01:21:33'),(201,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:22:59','2025-07-17 01:22:59'),(202,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:24:18','2025-07-17 01:24:18'),(203,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:31:41','2025-07-17 01:31:41'),(204,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:37:11','2025-07-17 01:37:11'),(205,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:43:16','2025-07-17 01:43:16'),(206,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:45:05','2025-07-17 01:45:05'),(207,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:45:32','2025-07-17 01:45:32'),(208,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:45:41','2025-07-17 01:45:41'),(209,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:47:14','2025-07-17 01:47:14'),(210,1,'Super Admin','admin','Data Exported','Exported All Distributors Report as PDF','2025-07-17 01:48:15','2025-07-17 01:48:15'),(211,1,'Super Admin','admin','Created Employee','Employee: muwahid','2025-07-17 01:51:39','2025-07-17 01:51:39'),(212,1,'Super Admin','admin','Created Employee','Employee: muwahid','2025-07-17 01:51:40','2025-07-17 01:51:40'),(213,1,'Super Admin','admin','Deleted Employee','Employee: muwahid','2025-07-17 01:51:46','2025-07-17 01:51:46'),(214,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:53:14','2025-07-17 01:53:14'),(215,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:53:20','2025-07-17 01:53:20'),(216,1,'Super Admin','admin','Viewed Distributor History','Muwahid','2025-07-17 01:53:29','2025-07-17 01:53:29'),(217,1,'Super Admin','admin','Bulk Salary Payment','Employee ID: 1, Amount: 2000.00','2025-07-17 01:54:22','2025-07-17 01:54:22'),(218,1,'Super Admin','admin','Processed Return','Sale ID: 18, Customer: ','2025-07-17 01:58:19','2025-07-17 01:58:19'),(219,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:11:01','2025-07-17 02:11:01'),(220,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:11:12','2025-07-17 02:11:12'),(221,1,'Super Admin','admin','Updated Sale','Sale Code: I003-00003, Customer: , Amount: 5944.86','2025-07-17 02:16:37','2025-07-17 02:16:37'),(222,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:30:23','2025-07-17 02:30:23'),(223,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:30:48','2025-07-17 02:30:48'),(224,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:33:34','2025-07-17 02:33:34'),(225,1,'Super Admin','admin','Processed Return','Sale ID: 17, Customer: ','2025-07-17 02:39:49','2025-07-17 02:39:49'),(226,1,'Super Admin','admin','Processed Return','Sale ID: 18, Customer: ','2025-07-17 02:43:54','2025-07-17 02:43:54'),(227,1,'Super Admin','admin','Deleted Sale','Sale Code: I003-00003, Customer: , Amount: 5944.86','2025-07-17 02:50:03','2025-07-17 02:50:03'),(228,1,'Super Admin','admin','Deleted Sale','Sale Code: I003-00002, Customer: , Amount: 9562.68','2025-07-17 02:50:07','2025-07-17 02:50:07'),(229,1,'Super Admin','admin','Deleted Sale','Sale Code: I003-00001, Customer: jkjk, Amount: 505.00','2025-07-17 02:50:11','2025-07-17 02:50:11'),(230,1,'Super Admin','admin','Created Sale','Sale Code: I003-00001, Customer: , Amount: 11953.35','2025-07-17 02:51:05','2025-07-17 02:51:05'),(231,1,'Super Admin','admin','Processed Return','Sale ID: 19, Customer: ','2025-07-17 02:51:27','2025-07-17 02:51:27'),(232,1,'Super Admin','admin','Processed Return','Sale ID: 19, Customer: ','2025-07-17 02:56:39','2025-07-17 02:56:39'),(233,1,'Super Admin','admin','Processed Return','Sale ID: 19, Customer: ','2025-07-17 02:56:48','2025-07-17 02:56:48'),(234,1,'Super Admin','admin','Updated Sale','Sale Code: I003-00001, Customer: , Amount: 2390.67','2025-07-17 03:04:05','2025-07-17 03:04:05'),(235,1,'Super Admin','admin','Processed Return','Sale ID: 19, Customer: ','2025-07-17 03:04:25','2025-07-17 03:04:25'),(236,1,'Super Admin','admin','Created Sale','Sale Code: I003-00002, Customer: , Amount: 4781.34','2025-07-17 03:11:28','2025-07-17 03:11:28'),(237,1,'Super Admin','admin','Deleted Sale','Sale Code: I003-00001, Customer: , Amount: 2390.67','2025-07-17 03:17:45','2025-07-17 03:17:45'),(238,1,'Super Admin','admin','Deleted Sale','Sale Code: I003-00002, Customer: , Amount: 4781.34','2025-07-17 03:17:51','2025-07-17 03:17:51'),(239,1,'Super Admin','admin','Created Sale','Sale Code: I003-00001, Customer: , Amount: 2390.67','2025-07-17 03:25:43','2025-07-17 03:25:43'),(240,1,'Super Admin','admin','Processed Return','Sale ID: 21, Customer: ','2025-07-17 03:27:49','2025-07-17 03:27:49'),(241,1,'Super Admin','admin','Created Sale','Sale Code: I003-00002, Customer: shah, Amount: 330270','2025-07-17 04:36:46','2025-07-17 04:36:46'),(242,1,'Super Admin','admin','Processed Return','Sale ID: 22, Customer: shah','2025-07-17 04:37:24','2025-07-17 04:37:24'),(243,1,'Super Admin','admin','Deleted Supplier','Supplier: Muwahid','2025-07-17 04:40:11','2025-07-17 04:40:11'),(244,1,'Super Admin','admin','Deleted Supplier','Supplier: ahmed','2025-07-17 04:40:21','2025-07-17 04:40:21'),(245,1,'Super Admin','admin','Created Customer','Customer: rdkgjrg','2025-07-17 07:20:23','2025-07-17 07:20:23'),(246,1,'Super Admin','admin','Deleted Customer','Customer: rdkgjrg','2025-07-17 07:20:31','2025-07-17 07:20:31');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_company_id_foreign` (`company_id`),
  CONSTRAINT `categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxCash` decimal(5,2) NOT NULL DEFAULT '0.00',
  `taxCard` decimal(5,2) NOT NULL DEFAULT '0.00',
  `taxOnline` decimal(5,2) NOT NULL DEFAULT '0.00',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('wholesale','retail','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ntn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_cash` decimal(8,2) DEFAULT '0.00',
  `tax_card` decimal(8,2) DEFAULT '0.00',
  `tax_online` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (2,'Daisho Gold',2.00,2.00,2.00,NULL,NULL,'company_logos/zyN146r7VEK2iSB5ef2AgT92yiGRCEb1VIO3CzPN.jpg','both','033333333','exampe@email.com',NULL,NULL,'2025-07-15 07:20:21','2025-07-15 07:20:37',0.00,0.00,0.00),(3,'Irshad Autos',5.00,7.50,3.00,'www.daishogold.com','64-Macload Road, Lahore','company_logos/PU99SMe8Tg1JKnr1Nx58JcsCLI55tQy6vRtjDRSs.png','both','37312765-37232765','info@daishogold.co','1234567','+0987654321','2025-07-15 08:16:50','2025-07-16 10:13:33',1.00,0.00,0.00);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('retail','wholesale','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cel_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cnic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_company_id_foreign` (`company_id`),
  CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (3,'rdkgjrg','wholesale','8979',NULL,NULL,NULL,'8979',3,'2025-07-17 07:20:23','2025-07-17 07:20:31','2025-07-17 07:20:31');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distributor_payments`
--

DROP TABLE IF EXISTS `distributor_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributor_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('payment','commission','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `payment_date` date NOT NULL,
  `status` enum('pending','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_payments_distributor_id_foreign` (`distributor_id`),
  CONSTRAINT `distributor_payments_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distributor_payments`
--

LOCK TABLES `distributor_payments` WRITE;
/*!40000 ALTER TABLE `distributor_payments` DISABLE KEYS */;
INSERT INTO `distributor_payments` VALUES (5,1,100.00,'commission',NULL,'2025-07-17','completed',NULL,'2025-07-17 01:53:28','2025-07-17 01:53:28');
/*!40000 ALTER TABLE `distributor_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distributor_products`
--

DROP TABLE IF EXISTS `distributor_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributor_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assignment_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `inventory_id` bigint unsigned NOT NULL,
  `quantity_assigned` int NOT NULL,
  `quantity_remaining` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_value` decimal(10,2) NOT NULL,
  `assignment_date` date NOT NULL,
  `status` enum('active','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_products_inventory_id_foreign` (`inventory_id`),
  KEY `distributor_products_distributor_id_foreign` (`distributor_id`),
  CONSTRAINT `distributor_products_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `distributor_products_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distributor_products`
--

LOCK TABLES `distributor_products` WRITE;
/*!40000 ALTER TABLE `distributor_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `distributor_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distributors`
--

DROP TABLE IF EXISTS `distributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distributors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributors_company_id_foreign` (`company_id`),
  CONSTRAINT `distributors_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distributors`
--

LOCK TABLES `distributors` WRITE;
/*!40000 ALTER TABLE `distributors` DISABLE KEYS */;
INSERT INTO `distributors` VALUES (1,3,'Muwahid','0333','Lahore',10.00,'2025-07-16 12:02:14','2025-07-16 12:02:14');
/*!40000 ALTER TABLE `distributors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(12,2) NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_company_id_foreign` (`company_id`),
  CONSTRAINT `employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'muwahid','aa',2000.00,NULL,NULL,3,'2025-07-17 01:51:39','2025-07-17 01:51:39');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,2) NOT NULL,
  `paidBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentWay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_company_id_foreign` (`company_id`),
  CONSTRAINT `expenses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,'Distributor Commission','Commission paid to distributor ID: 1',100.00,'Super Admin','cash',3,'2025-07-17 01:53:28','2025-07-17 01:53:28'),(2,'Salary Payment','Salary paid to employee ID: 1',2000.00,'Super Admin','cash',3,'2025-07-17 01:54:22','2025-07-17 01:54:22');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_purchases`
--

DROP TABLE IF EXISTS `external_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `external_purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchaseE_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `purchase_amount` decimal(10,2) NOT NULL,
  `purchase_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `parent_sale_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_purchases_purchasee_id_unique` (`purchaseE_id`),
  KEY `external_purchases_company_id_foreign` (`company_id`),
  KEY `external_purchases_parent_sale_id_foreign` (`parent_sale_id`),
  CONSTRAINT `external_purchases_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `external_purchases_parent_sale_id_foreign` FOREIGN KEY (`parent_sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_purchases`
--

LOCK TABLES `external_purchases` WRITE;
/*!40000 ALTER TABLE `external_purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_sales`
--

DROP TABLE IF EXISTS `external_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `external_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `saleE_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaseE_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `parent_sale_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `external_sales_salee_id_unique` (`saleE_id`),
  KEY `external_sales_company_id_foreign` (`company_id`),
  KEY `external_sales_customer_id_foreign` (`customer_id`),
  KEY `external_sales_parent_sale_id_foreign` (`parent_sale_id`),
  CONSTRAINT `external_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `external_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `external_sales_parent_sale_id_foreign` FOREIGN KEY (`parent_sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_sales`
--

LOCK TABLES `external_sales` WRITE;
/*!40000 ALTER TABLE `external_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retail_amount` decimal(10,2) NOT NULL,
  `wholesale_amount` decimal(10,2) DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_supplier_id_foreign` (`supplier_id`),
  KEY `inventory_category_id_foreign` (`category_id`),
  KEY `inventory_company_id_foreign` (`company_id`),
  CONSTRAINT `inventory_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1334 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (667,'DS Sprocket Kit CD.70H',2630.00,2367.00,'hellow how are ','131',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-17 03:27:49'),(668,'DS Sprocket Kit CG.125H',3080.00,2772.00,'N/A','0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 21:27:37'),(669,'DS Sprocket Kit CG.125 Self-Start',3270.00,2943.00,'N/A','1',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-17 02:50:03'),(670,'DS Sprocket Kit 110L Deluxe 125H',3350.00,3015.00,'N/A','-3',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 21:47:09'),(671,'DS Sprocket Kit Yamaha YBR.125',3380.00,3042.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(672,'DS Sprocket Kit CD.100H',3310.00,2979.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(673,'DS Sprocket Kit CB.150H',3780.00,3402.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(674,'DS Sprocket Kit GS.150',3890.00,3501.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(675,'DS Sprocket Kit GD.110H',3270.00,2943.00,'N/A','-80',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-17 04:37:24'),(676,'DS Chain Lock 420',43.00,39.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(677,'DS Chain Lock 420H',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(678,'DS Chain Lock 428',53.00,48.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(679,'DS Chain Lock 428H',57.00,51.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(680,'DS Brake Shoe Short Spring 106H CD.70/CG.125',545.00,491.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(681,'DS Brake Shoe Short Spring 104H CG.125',705.00,635.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(682,'DS Disk Pad GS.150',450.00,405.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(683,'DS Disk Pad Deluxe 125',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(684,'DS Disk Pad YBR 125',450.00,405.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(685,'DS Disk Pad CB.150',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(686,'DS Filter Foam CG.125',345.00,311.00,'N/A','-20.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(687,'DS Filter Foam DLX.125',355.00,320.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(688,'DS Filter Foam CD.100',355.00,320.00,'N/A','-10.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(689,'DS Euro Filter CG.125',192.00,173.00,'N/A','-25.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(690,'DS Filter Foam GS.150',396.00,356.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(691,'DS Heavy Duty Spark Plug CD.70/JH.70',146.00,131.00,'N/A','-15.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(692,'DS Heavy Duty Spark Plug CG.125',155.00,140.00,'N/A','-25.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(693,'DS Connecting Rod Kit CD.70 (GB2)',1040.00,936.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(694,'DS Connecting Rod Kit CG.125 (383)',1430.00,1287.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(695,'DS Connecting Rod Kit JH.90',1040.00,936.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(696,'DS Connecting Rod Kit CG.125 DLX (KYH)',1500.00,1350.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(697,'DS Connecting Rod Kit CD.100 (GF6)',1120.00,1008.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(698,'DS Connecting Rod Kit CB.150',1860.00,1674.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(699,'DS Connecting Rod Kit YBR.125',1850.00,1665.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(700,'DS Connecting Rod Kit GD.110',1530.00,1377.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(701,'DS Connecting Rod Kit GS.150',1680.00,1512.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(702,'DS CAM Gear CG.125 (Fiber)',1750.00,1575.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(703,'DS CAM Gear CG.125 (Polyamide Fiber)',1785.00,1607.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(704,'DS CAM Gear CG.125 O/M',1850.00,1665.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(705,'DS CAM Gear CG.125 Euro 2',1950.00,1755.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(706,'DS CAM Gear CG.125 (Self-Start)',2200.00,1980.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(707,'DS Timing Chain Kit 82L CD.70',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(708,'DS Timing Chain Kit 84L JH.70',610.00,549.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(709,'DS Roller Got Set CD.70/JH.70/CD.100',105.00,95.00,'N/A','-8.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(710,'DS Timing Chain YBR.125',310.00,279.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(711,'DS Timing Chain CB.150',360.00,324.00,'N/A','-15.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(712,'DS Timing Chain GD.110',295.00,266.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(713,'DS Timing Chain GS.150',355.00,320.00,'N/A','-1.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(714,'DS Clutch Plate CD.70 Black',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(715,'DS Clutch Plate CD.70 CDi Green',390.00,351.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(716,'DS Clutch Plate CD.70 Golden',320.00,288.00,'N/A','-6.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(717,'DS Clutch Plate CD.70 (2022-2025)',490.00,441.00,'N/A','-9.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(718,'DS Clutch Plate CG.125 Black',520.00,468.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:43','2025-07-15 09:58:43'),(719,'DS Clutch Plate CG.125 Golden (Oversize)',680.00,612.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(720,'DS Clutch Plate CG.125 CDi Green',750.00,675.00,'N/A','-20.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(721,'DS Clutch Plate YBR.125 Golden',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(722,'DS Clutch Plate CB.150 A+ FCC',950.00,855.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(723,'DS Clutch Plate GD.110',650.00,585.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(724,'DS Clutch Plate GS.150',740.00,666.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(725,'DS Pressure Plate CD.70',153.00,138.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(726,'DS Clutch Plate CG.125',263.00,237.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(727,'DS Pressure Plate DLX.125',310.00,279.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(728,'DS Judder Plate Set Deluxe.125',340.00,306.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(729,'DS Clutch Box Complete CD.70',2450.00,2205.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(730,'DS Clutch Outer CD.70',435.00,392.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(731,'DS Clutch Housing CD.100',1550.00,1395.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(732,'DS Clutch Housing CG.125',1650.00,1485.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(733,'DS Clutch Housing Assy CG.125',2850.00,2565.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(734,'DS Bearing 6304 Set',720.00,648.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(735,'DS Bearing 63/28 Set',1290.00,1161.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(736,'DS Complete Engine Seal Kit CD.70',265.00,239.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(737,'DS Clutch Seal 12-21-4 CD.70',63.00,57.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(738,'DS Gear Shaft Seal 11-6-24-10 CD.70',63.00,57.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(739,'DS Kick Shaft Seal 13-7-24-5 CD.70',63.00,57.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(740,'DS Magnet Seal 18-9-30-5 CD.70',63.00,57.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(741,'DS Shock Seal 25-35-9 CD.70',93.00,84.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(742,'DS Sprocket Seal 17-29-5 CD.70',63.00,57.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(743,'DS Hub Seal CD.70 21-35-7 Front',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(744,'DS Shock Seal 27-37-10-5 JH.90',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(745,'DS Complete Engine Seal Kit CG.125',365.00,329.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(746,'DS Seal Clutch Varm 12-22-5 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(747,'DS Shaft Oil Seal 14-28-7 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(748,'DS Kick Shaft Seal 16-28-7 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(749,'DS Magnet Seal 22-35-7 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(750,'DS Shock Seal 27-39-10-5 CG.125',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(751,'DS Sprocket Seal 20-34-7 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(752,'DS Techometer 6-5-14-5-7 CG.125',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(753,'DS Hub Seal CG.125 21-37-7 Front',67.00,60.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(754,'DS Hub Seal CG.125 28-42-7 Black',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(755,'DS Clutch Varm Seal 6-25-6 CD.100',67.00,60.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(756,'DS Shock Seal 30-42-10-5 CD.100',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(757,'DS Shock Seal 31-43-10-5 DLX.125',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(758,'DS Shock Seal 30-40-10-5 YBR.125',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(759,'DS Shock Seal 31-43-10-5 CB.150',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(760,'DS Full Jain Kit CD.70 BIG',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(761,'DS Full Jain Kit CDi 70',450.00,405.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(762,'Full Jain Kit CD.70 Euro Model (2022-2025)',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(763,'DS Half Jain Kit CD.70 BIG',225.00,203.00,'N/A','-6.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(764,'DS Half Jain Kit Euro 70 (Model 2022-2025)',290.00,261.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(765,'DS Half Jain Kit CDi 70 (Steel Jain)',245.00,221.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(766,'DS Clutch Jain CD.70',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(767,'DS Carburetor Jain CD.70',7.00,6.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(768,'DS Cylinder Jain CD.70',54.00,49.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(769,'DS Head Gasket CD.70 BIG',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(770,'DS Head Gasket CD.70 Euro 2',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(771,'DS Head Tikki Round Jain CD.70',27.00,24.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(772,'DS Clutch Tikki Flower Jain CD.70',24.00,22.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(773,'DS Top Head Cover Jain CD.70',26.00,23.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(774,'DS Full Jain Kit CG.125',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(775,'DS Half Jain Kit CG.125',225.00,203.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(776,'DS Oil Pump Cap Jain CG.125',26.00,23.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(777,'DS Magnet Jain CG.125',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(778,'DS Head Gasket CG.125 N/M',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(779,'DS Carburetor Jain CG.125',9.00,8.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(780,'DS Cylinder Jain CG.125',64.00,58.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(781,'DS Clutch Jain CG.125',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(782,'DS Full Jain Kit CG.125 (Self-Start)',495.00,446.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(783,'DS Self Jain CG.125',85.00,77.00,'N/A','-1.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(784,'DS Full Jain Kit CD.100',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(785,'DS Half Jain Kit CD.100',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(786,'DS Cylinder Jain CD.100',105.00,95.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(787,'DS Head Gasket CD.100',110.00,99.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(788,'DS Full Jain Kit YBR.125',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(789,'DS Half Jain Kit YBR.125',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(790,'DS Head Gasket YBR.125',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(791,'DS Cylinder Jain YBR.125',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(792,'DS Clutch Jain YBR.125',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(793,'DS Self Jain YBR.125',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(794,'DS Full Jain Kit CB.150',550.00,495.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(795,'DS Half Jain Kit CB.150',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(796,'DS Self Jain CB.150',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(797,'DS Head Gasket CB.150',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:44','2025-07-15 09:58:44'),(798,'DS Cylinder Jain CB.150',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(799,'DS Clutch Jain CB.150',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(800,'DS Full Jain Kit GD.110',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(801,'DS Half Jain Kit GD.110',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(802,'DS Self Jain GD.110',85.00,77.00,'N/A','-1.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(803,'DS Head Gasket GD.110',95.00,86.00,'N/A','-5.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(804,'DS Cylinder Jain GD.110',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(805,'DS Clutch Jain GD.110',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(806,'DS Full Jain Kit GS.150',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(807,'DS Half Jain Kit GS.150',230.00,207.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(808,'DS Cylinder Jain GS.150',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(809,'DS Clutch Jain GS.150',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(810,'DS Head Gasket GS.150',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(811,'DS Self Jain GS.150',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(812,'DS Titanium Coated Ring Set CD.70 O/M',225.00,203.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(813,'DS Titanium Coated Ring Set CD.70 Euro 2 (2022-2025)',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(814,'DS Titanium Coated Ring Set N/M CG.125',330.00,297.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(815,'DS Titanium Coated Ring Set O/M CG.125',285.00,257.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(816,'DS Titanium Coated Ring Set Deluxe 125',345.00,311.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(817,'DS Titanium Coated Ring Set Yamaha YBR.125',365.00,329.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(818,'DS Titanium Coated Ring Set GD.110',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(819,'DS Titanium Coated Ring Set HD.110',285.00,257.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(820,'DS Titanium Coated Ring GN-5',275.00,248.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(821,'DS Complete Cylinder Kit 72cm³',2895.00,2606.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(822,'DS Complete Cylinder Kit 78cm³ (Aluminum)',2970.00,2673.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(823,'DS Complete Cylinder Kit CG.125',3350.00,3015.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(824,'DS Complete Cylinder Kit 97cm³',3250.00,2925.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(825,'DS Complete Cylinder Kit 107cm³',3450.00,3105.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(826,'DS Cylinder 72cm³',1900.00,1710.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(827,'DS Cylinder 78cm³',1930.00,1737.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(828,'DS Cylinder 97cm³',2420.00,2178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(829,'DS Cylinder 107cm³',2220.00,1998.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(830,'DS Rocker Pin CG.125 (Standard)',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(831,'DS Rocker Pin CG.125 (Old Model)',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(832,'DS Rocker Pin CG.125 (Oversize)',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(833,'DS Rocker Pin CD.70',68.00,61.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(834,'DS Rocker Pin Euro CD.70 (2024-2025)',185.00,167.00,'N/A','-7.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(835,'DS Rocker Set CG.125 O/M',550.00,495.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(836,'DS Rocker Set Euro CG.125 N/M',650.00,585.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(837,'DS Rocker Set CD.70 O/M',370.00,333.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(838,'DS Rocker Set Euro CD.70 N/M',920.00,828.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(839,'DS Rocker Plate CG.125 O/M',1080.00,972.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(840,'DS Rocker Plate Euro CG.125 N/M',1280.00,1152.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(841,'DS Handle Bearing (Cone Set)',385.00,347.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(842,'DS Handle Cone Set CD.70/CG.125',365.00,329.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(843,'DS Handle Cone Set YBR.125',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(844,'DS Handle Cone Set GS.150',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(845,'DS Handle Cone Set GD.110',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(846,'DS Handle Cone Set CB.150',580.00,522.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(847,'DS Wiring Complete CG.125',870.00,783.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(848,'DS Wiring Complete CD.70',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(849,'DS Wiring Complete CD.70 Euro',920.00,828.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(850,'DS Wiring Complete JH.70',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(851,'DS Wiring Complete CD.100',875.00,788.00,'N/A','-3.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(852,'DS Wiring Complete Deluxe 125',875.00,788.00,'N/A','-4.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(853,'DS Carburetor CD.70 O/M',2550.00,2295.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(854,'DS Carburetor CD.70 Euro 2',2550.00,2295.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(855,'DS Carburetor CG.125 O/M',3000.00,2700.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(856,'DS Carburetor Insulator O/M CG.125',320.00,288.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(857,'DS Carburetor Insulator N/M CG.125',390.00,351.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(858,'DS Carburetor Flute O/M CD.70',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(859,'DS Carburetor Flute N/M CD.70',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(860,'DS Carburetor Flute O/M CG.125',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(861,'DS Carburetor Flute N/M CG.125',103.00,93.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(862,'DS Valve Set CG.125 (Standard) CDi',660.00,594.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(863,'DS Valve Set CG.125 (Oversize)',660.00,594.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(864,'DS Valve Set JH.70 (Standard)',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(865,'DS Valve Set JH.70 (Oversize)',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(866,'DS Valve Set CD.70 (Standard)',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(867,'DS Valve Set CD.70 (Oversize)',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(868,'DS Valve Set CB.150',1080.00,972.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(869,'DS Valve Set YBR.125',1080.00,972.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(870,'DS Valve Set GD.110',680.00,612.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(871,'DS Valve Set GS.150',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(872,'DS Valve Guide Set JH.70',165.00,149.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(873,'DS Valve Guide Set CG.125',185.00,167.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(874,'DS Valve Retainer Set JH.70',136.00,122.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(875,'DS Valve Seal JH.70',103.00,93.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(876,'DS Valve Seal CG.125',108.00,97.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:45','2025-07-15 09:58:45'),(877,'DS Valve Seal CD.70',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(878,'DS Magnet Complete CD.70',3410.00,3069.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(879,'DS Magnet Complete JH.70',3410.00,3069.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(880,'DS Magnet Complete CG.125',3410.00,3069.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(881,'DS Magnet Coil CD.70 (Pure Copper)',1250.00,1125.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(882,'DS Magnet Coil JH.70 (Pure Copper)',1250.00,1125.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(883,'DS Magnet Coil CG.125 (Pure Copper)',1350.00,1215.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(884,'DS Magnet Coil CG.125 Self-Start (Pure Copper)',3300.00,2970.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(885,'DS Magnet Coil Plate CD.70',245.00,221.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(886,'DS Magnet Coil Plate JH.70',245.00,221.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(887,'DS Magnet Coil Plate Complete CG.125',390.00,351.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(888,'DS Starting Coil JH.70',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(889,'DS Starting Coil CD.70/CG.125',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(890,'DS Magnet O-Ring Set CG.125 (Standard)',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(891,'DS Magnet O-Ring Set CG.125 (Oversize)',85.00,77.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(892,'DS Magnet O-Ring Set CDi 70',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(893,'DS Magnet O-Ring Set JH.70',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(894,'DS Complete O-Ring Set CD.70',135.00,122.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(895,'DS Complete O-Ring Set CG.125',165.00,149.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(896,'Clutch Plate CG.125 FCC JAPAN',1330.00,1197.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(897,'Clutch Plate CD.70 FCC JAPAN',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(898,'Clutch Housing Complete CG.125 FCC JAPAN',3380.00,3042.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(899,'Clutch Housing Plain CG.125 FCC JAPAN',1850.00,1665.00,'N/A','-1.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(900,'Clutch Box Complete CG.125 FCC With Gear',5510.00,4959.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(901,'Clutch Box with Gear FCC JAPAN',2580.00,2322.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(902,'DS Gear Transmission Complete CD.70',2900.00,2610.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(903,'DS Gear Bolt Kit CD.70',135.00,122.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(904,'DS Foot Rest CD.70',375.00,338.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(905,'DS Chimta Bush CD.70',155.00,140.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(906,'DS Gear Primary Drive CD.70',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(907,'DS Plug Cap CD.70/CG.125 (Thailand)',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(908,'DS Plug Cap CD.70/CG.125 (China)',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(909,'DS Clutch Box Spring CD.70 Heavy Duty',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(910,'DS Kick Spring CD.70',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(911,'DS Clutch Varm Spring CD.70',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(912,'DS Clutch Box Rubber CD.70',108.00,97.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(913,'DS Clutch Bush CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(914,'DS Clutch Pusher CD.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(915,'DS Clutch Varm CD.70',185.00,167.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(916,'DS Gear Star CD.70',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(917,'DS CDi Unit CD.70 BIG',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(918,'DS CDi Unit JH.70 BIG',330.00,297.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(919,'DS Gear Shaft CD.70/JH.70',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(920,'DS CAM Shaft CD.70',660.00,594.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(921,'DS CAM Shaft CD.70 Euro 2',1080.00,972.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(922,'DS CAM Shaft JH.70',690.00,621.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(923,'DS CAM Shaft (Oversize 27.5)',920.00,828.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(924,'DS CAM Shaft (Oversize 28.5)',920.00,828.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(925,'DS Kick Shaft CD.70',440.00,396.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(926,'DS Tube Slide O/M CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(927,'DS Tube Slide N/M CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(928,'DS Mixture Screw Kit O/M CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(929,'DS Mixture Screw Kit N/M CD.70',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(930,'DS Needle Valve O/M CD.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(931,'DS Needle Valve N/M CD.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(932,'DS Oil Pump Gear Bush CD.70',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(933,'DS Oil Pump Complete CD.70',245.00,221.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(934,'DS Main Jet 72 CD.70',23.00,21.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(935,'DS Slow Jet CD.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(936,'DS Engine Daval Set CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(937,'DS Main Jet 78 JH.70',23.00,21.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(938,'DS Slow Jet JH.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(939,'DS Ignition Coil CD.70',390.00,351.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(940,'DS Ignition Coil JH.70',540.00,486.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(941,'DS Tappet Screw CD.70',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(942,'DS Stopper Patti CD.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(943,'DS Stopper Patti JH.70',48.00,43.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(944,'DS Tensioner Patti CD.70/JH.70',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(945,'DS Meter Gear Plastic CD.70',129.00,116.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(946,'DS Meter Gear CD.70 O/M',180.00,162.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(947,'DS Meter Gear JH.70 Metal',180.00,162.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(948,'DS Electric Horn (Water-Proof)',285.00,257.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(949,'DS Gear Transmission Complete CG.125',4200.00,3780.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(950,'DS Gear Bolt Kit CG.125',145.00,131.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(951,'DS Foot Rest CG.125',475.00,428.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(952,'DS Chimta Bush CG.125',165.00,149.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(953,'DS Gear Primary Drive CG.125',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(954,'DS Gear Primary Drive Deluxe 125',450.00,405.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:46','2025-07-15 09:58:46'),(955,'DS Gear Shaft Complete CG.125',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(956,'DS Gear Shaft Complete Deluxe 125',540.00,486.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(957,'DS Clutch Varm CG.125',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(958,'DS Clutch Varm CD.100',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(959,'DS CDi Unit CG.125 BIG',450.00,405.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(960,'DS Drum Bush CG.125 Heavy Duty',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(961,'DS Drum Bush Deluxe 125',390.00,351.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(962,'DS Engine Daval Set CG.125',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(963,'DS Clutch Box Spring CG.125',118.00,106.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(964,'DS Kick Spring CG.125',138.00,124.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(965,'DS Push Rod O/M CG.125',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(966,'DS Push Rod N/M CG.125',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(967,'DS Tube Slide O/M CG.125',108.00,97.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(968,'DS Tube Slide N/M CG.125 Euro 2',118.00,106.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(969,'DS Mixture Screw Kit O/M CG.125',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(970,'DS Mixture Screw Kit N/M CG.125 Euro 2',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(971,'DS RPM Gear CG.125',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(972,'DS RPM Gear CG.125 Euro',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(973,'DS RPM Gear Deluxe 125',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(974,'DS Needle Valve O/M CG.125',58.00,52.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(975,'DS Needle Valve N/M CG.125',58.00,52.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(976,'DS Oil Pump Complete CG.125',720.00,648.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(977,'DS Oil Pump Cap CG.125',345.00,311.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(978,'DS Meter Gear Deluxe 125 (Metal)',510.00,459.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(979,'DS Meter Gear CG.125 Plastic',129.00,116.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(980,'DS Meter Gear CB.150',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(981,'DS Meter Gear YBR.125',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(982,'DS Meter Gear GD.110',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(983,'DS Meter Gear GS.150',690.00,621.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(984,'DS Main Jet 95 CG.125',32.00,29.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(985,'DS Main Jet 105 Euro CG.125',32.00,29.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(986,'DS Ignition Coil CG.125',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(987,'DS Clutch Box Rubber CG.125',118.00,106.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(988,'DS Stopper Patti O/M CG.125',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(989,'DS Stopper Patti N/M CG.125',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(990,'DS Stopper Patti Euro 2 CG.125',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(991,'DS Plug Cap Deluxe 125',175.00,158.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(992,'DS Tappet Screw CG.125',26.00,23.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(993,'DS Chain Adjuster Complete Deluxe 125',265.00,239.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(994,'DS Side Cover Lock CD.70/JH.70/CG.125',145.00,131.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(995,'IBK Back Light CD.70',220.00,198.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(996,'IBK Back Light CG.125',248.00,223.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(997,'IBK Brake Cam Lever (Rear) CD.70',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(998,'IBK Brake Cam Lever (Front) CG.125',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(999,'IBK Brake Cam Lever (Rear) CG.125',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1000,'IBK Brake Cam Lever (Front) CD.70',158.00,142.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1001,'IBK Brake Pedal CD.70',440.00,396.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1002,'IBK Brake Pedal CG.125',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1003,'IBK Brake Pedal Spring CD.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1004,'IBK Brake Pedal Spring CG.125',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1005,'IBK Brake Rod CG.125',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1006,'IBK Brake Rod (H) CD.70',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1007,'IBK Brake Shoe Short Spring CD.70/CG.125',283.00,255.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1008,'HY Brake Shoe CD.70',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1009,'IBK Bridge Plate CD.70',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1010,'IBK Bridge Plate CG.125',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1011,'IBK Blow Pipe CD.70',70.00,63.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1012,'IBK Blow Pipe CG.125',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1013,'Moto Z Brake Shoe CD.70',223.00,201.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1014,'Moto Z Brake Shoe DLX.125',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1015,'IBK Brake Switch (Rear) CD.70 CDi',50.00,45.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1016,'IBK Brake Switch (Front) CD.70 CDi',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1017,'IBK Brake Cable CD.70',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1018,'IBK Brake Cable YB-ZEE',270.00,243.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1019,'IBK Brake Cable CD.70 2020',203.00,183.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1020,'IBK Brake Cable CD.100',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1021,'IBK Brake Cable CG.125 Euro 2',192.00,173.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1022,'IBK Brake Cable YBR.125',270.00,243.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1023,'IBK Brake Cable GD.110',240.00,216.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1024,'IBK Brake Cable GS.150',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1025,'IBK Brake Cable YD.100',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1026,'IBK Brake Cable YB.100',192.00,173.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1027,'IBK Brake Cable CG.125 Special Edition',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1028,'IBK Brake Cable CD.70 N/M Euro 2',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1029,'IBK Brake Cable CG.125 O/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1030,'IBK Brake Cable CG.125 N/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1031,'IBK Clutch Cable CD.70 O/M',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1032,'IBK Clutch Cable CD.70 N/M Euro 2',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:47','2025-07-15 09:58:47'),(1033,'IBK Clutch Cable GS.150',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1034,'IBK Clutch Cable GD.110',240.00,216.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1035,'IBK Clutch Cable CG.125 Special Edition',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1036,'IBK Clutch Cable CG.125 O/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1037,'IBK Clutch Cable YD.100',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1038,'IBK Clutch Cable YB.100',192.00,173.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1039,'IBK Clutch Cable CG.125 N/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1040,'IBK Clutch Cable CG.125 Small Hub',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1041,'IBK Clutch Cable CG.125 N/M Euro 2',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1042,'IBK Clutch Cable YBR.125',270.00,243.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1043,'IBK Clutch Cable DLX.125',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1044,'IBK Clutch Cable CD.100',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1045,'IBK Chowk Cable YB.100',110.00,99.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1046,'IBK Chowk Cable YD.100',110.00,99.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1047,'IBK Cable EX CD.70 CDi',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1048,'IBK Meter Cable CG.125',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1049,'IBK Meter Cable DLX.125',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1050,'IBK Meter Cable CD.70 Euro 2',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1051,'IBK Meter Cable CD.100',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1052,'IBK Meter Cable YBR.125',288.00,259.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1053,'IBK Meter Cable GS.150',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1054,'IBK Meter Cable GD.110',240.00,216.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1055,'IBK Meter Cable YD.100',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1056,'IBK Meter Cable YB.100',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1057,'IBK Meter Cable CG.125 Special Edition',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1058,'IBK Meter Cable CD.70 N/M',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1059,'IBK Meter Cable CD.70 O/M',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1060,'IBK Meter Cable CG.125 Small Hub O/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1061,'IBK Meter Cable CG.125 Large Hub O/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1062,'IBK Race Cable Double CG.125 N/M 2017',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1063,'IBK Race Cable DLX.125 4-Gear',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1064,'IBK Race Cable DLX.125 5-Gear',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1065,'IBK Race Cable YD.100',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1066,'IBK Race Cable YB.100',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1067,'IBK Race Cable GS.150',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1068,'IBK Race Cable GD.110',240.00,216.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1069,'IBK Race Cable CG.125 Special Edition',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1070,'IBK Race Cable CD.100 O/M',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1071,'IBK Race Cable CD.100 N/M',198.00,178.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1072,'IBK Race Cable YBR.125',278.00,250.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1073,'IBK RPM Cable CG.125',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1074,'IBK Race Cable CD.70 O/M',183.00,165.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1075,'IBK Race Cable CD.70 Euro 2',183.00,165.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1076,'IBK Race Cable CG.125',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1077,'IBK Race Cable CG.125 Euro 2',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1078,'IBK Cam Sprocket JH.70',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1079,'IBK Cam Sprocket CD.70 CDi',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1080,'IBK Carburetor Band CD.100',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1081,'IBK Carburetor Band CD.70 Euro 2',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1082,'IBK Carburetor Band 78 cm³ JH.70',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1083,'IBK CDi Unit Small CD.70',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1084,'IBK CDi Unit Small CG.125',255.00,230.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1085,'IBK CDi Unit Small JH.70',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1086,'IBK Chain Cover CD.70',1000.00,900.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1087,'IBK Chain Cover CG.125',1100.00,990.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1088,'IBK Chimta CD.70',1220.00,1098.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1089,'IBK Clutch Adjuster Patti Set CD.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1090,'IBK Clutch Outer JH.70',280.00,252.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1091,'IBK Clutch Box Spring 8-Pcs CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1092,'IBK Clutch Box Spring 4-Pcs CG.125',108.00,97.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1093,'IBK Clutch Box Spring Alter CD.70',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1094,'IBK Clutch Box Spring Alter CG.125',108.00,97.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1095,'IBK Clutch Bush CD.70',60.00,54.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1096,'IBK Clutch Oil Throw Kit CD.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1097,'IBK Clutch Plate CD.70',165.00,149.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1098,'IBK Clutch Plate CG.125',365.00,329.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1099,'IBK Clutch Sprocket Small CD.70',220.00,198.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1100,'IBK Chimta Complete CG.125',1320.00,1188.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1101,'IBK Clutch Box Tip Plate CG.125',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1102,'IBK Clutch Box Plate W/Bearing CD.70',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1103,'IBK Clutch Bush HD.110',80.00,72.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1104,'IBK Clutch Cover Plate CD.70',124.00,112.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1105,'IBK Clutch Nut Lock CD.70',49.00,44.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1106,'IBK Clutch Plate 5-Pcs CG.125-DX',440.00,396.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1107,'IBK Clutch Pusher Outer CD.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1108,'IBK Clutch Housing Steel CG.125',980.00,882.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:48','2025-07-15 09:58:48'),(1109,'IBK Clutch Housing Complete CG.125',1950.00,1755.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1110,'IBK Daval Pin Set CD.70',60.00,54.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1111,'IBK Daval Pin BIG CG.125',10.00,9.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1112,'IBK Daval Pin Set CG.125',70.00,63.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1113,'IBK Drum Bush CG.125 (Japan Standard)',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1114,'IBK Drum Rubber CD.70',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1115,'IBK Drum Patti (H) CD.70',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1116,'IBK Drum Plate Front CD.70',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1117,'IBK Drum Plate Rear CD.70',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1118,'IBK Drum Plate Front CG.125 12 Model',840.00,756.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1119,'IBK Drum Plate Front CG.125 15 Model',860.00,774.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1120,'IBK Drum Plate Rear CG.125',590.00,531.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1121,'IBK Drum Lock CG.125',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1122,'IBK Drum Rubber GS.150',314.00,283.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1123,'IBK Drive Plate CD.70 CDi',680.00,612.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1124,'IBK Euro Filter CG.125',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1125,'IBK Euro Pipe CG.125',88.00,79.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1126,'IBK Rear Axle CD.70',185.00,167.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1127,'IBK Front Axle CD.70',145.00,131.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1128,'IBK Center Axle CD.70',145.00,131.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1129,'IBK Rear Axle CG.125',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1130,'IBK Front Axle CG.125',185.00,167.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1131,'IBK Center Axle CG.125',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1132,'IBK Fuel Cock CD.70 CDi',225.00,203.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1133,'IBK Front Glass (Small) JH.70',225.00,203.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1134,'IBK Front Glass (Large) JH.70',325.00,293.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1135,'IBK Front Glass (Small) CD.70',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1136,'IBK Front Glass (Large) CD.70',295.00,266.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1137,'IBK Front Glass (Small) CG.125',225.00,203.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1138,'IBK Front Glass (Large) CG.125',340.00,306.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1139,'IBK Flasher 12V',100.00,90.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1140,'IBK Flasher Sound',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1141,'IBK Filter Bottle CD.70',168.00,151.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1142,'IBK Filter Foam CG.125',128.00,115.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1143,'IBK Air Filter CD.70 O/M',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1144,'IBK Air Filter CD.70 N/M Euro 2',80.00,72.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1145,'IBK Filter Lota CD.70 O/M',168.00,151.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1146,'IBK Filter Lota CD.70 N/M',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1147,'IBK Foot Rest CG.125',230.00,207.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1148,'IBK Foot Rest CD.70 O/M',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1149,'IBK Foot Rest CD.70 N/M',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1150,'IBK Foot Rest Deluxe 125',300.00,270.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1151,'IBK Foot Bar CD.70',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1152,'IBK Foot Bar CG.125',520.00,468.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1153,'IBK Foot Bar DLX.125 N/M',550.00,495.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1154,'MS Front Shock JH.70',3850.00,3465.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1155,'MS Front Shock CD.70',3750.00,3375.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1156,'MS Front Shock CG.125',4250.00,3825.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1157,'IBK Front Spring JH.70',530.00,477.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1158,'IBK Front Spring CD.70',530.00,477.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1159,'IBK Front Spring CG.125',530.00,477.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1160,'IBK Front Sprocket 14T CD.70',185.00,167.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1161,'IBK Front Sprocket 15T CD.70',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1162,'IBK Front Sprocket 15T CG.125',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1163,'IBK Gear Lever CD.70',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1164,'IBK Gear Lever CG.125',290.00,261.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1165,'IBK Gear Lever DLX.125',360.00,324.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1166,'IBK Handle Tee Complete CD.70 CDi',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1167,'IBK Handle Tee Complete CG.125',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1168,'IBK Handle Grip Set CG.125',168.00,151.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1169,'IBK Handle Grip Set CD.70',158.00,142.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1170,'IBK Handle Holder Plate CG.125',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1171,'IBK Handle Light Holder CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1172,'IBK Handle CD.70',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1173,'IBK Handle CG.125',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1174,'IBK Handle Cone Set CD.70',255.00,230.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1175,'IBK Hub Sprocket CD.70',345.00,311.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1176,'IBK Head Cover CG.125 O/M',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1177,'IBK Head Cover CG.125 N/M',980.00,882.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1178,'IBK Head Light Beam CD.70',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1179,'IBK Head Light CD.70',470.00,423.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1180,'IBK Head Light CG.125',470.00,423.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1181,'IBK Horn CD.70/CG.125',195.00,176.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:49','2025-07-15 09:58:49'),(1182,'IBK Head Stud 4-Pcs Golden CG.125',180.00,162.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1183,'IBK Head Stud 4-Pcs Black JH.70',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1184,'IBK Head Stud 4-Pcs Golden CD.70',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1185,'IBK Head Light Mirror CD.70',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1186,'IBK Head Light Case CG.125',55.00,50.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1187,'IBK Head Light Case CD.70',55.00,50.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1188,'IBK Hose Pipe CG.125',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1189,'IBK Indicator Rubber CG.125',50.00,45.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1190,'IBK Indicator Rubber CD.70 O/M',50.00,45.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1191,'IBK Indicator Rubber CD.70 N/M',50.00,45.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1192,'IBK Kick CD.70 O/M',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1193,'IBK Kick CG.125 CDi',880.00,792.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1194,'IBK Kick JH.70',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1195,'IBK Kick CG.125',530.00,477.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1196,'IBK Kick CD.70 N/M',460.00,414.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1197,'IBK Kick CD.70 O/M Box Pack',310.00,279.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1198,'IBK Lever (L/R) CD.100',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1199,'IBK Lever (L/R) CG.125',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1200,'IBK Lever Assembly Set CD.100',830.00,747.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1201,'IBK Lever Holder L/H CD.100',105.00,95.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1202,'IBK Lever Holder L/H CG.125',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1203,'IBK Lever Holder R/H CD.100',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1204,'IBK Magnet Key CD.70 CDi',9.00,8.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1205,'IBK Magnet Key YB.100',9.00,8.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1206,'IBK Magnet Key CG.125',9.00,8.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1207,'IBK Main Stand CD.70 O/M',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1208,'IBK Main Stand CD.70 N/M',590.00,531.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1209,'IBK Main Stand CG.125',720.00,648.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1210,'IBK Main Spring CD.70',50.00,45.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1211,'IBK Main Spring CG.125',55.00,50.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1212,'IBK Main Stand Patri (H)',28.00,25.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1213,'IBK Meter CD.70',580.00,522.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1214,'IBK Meter China FG (All Models)',680.00,612.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1215,'IBK Meter Body CD.70',175.00,158.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1216,'IBK Meter CG.125 O/M',940.00,846.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1217,'IBK Meter CG.125 N/M',940.00,846.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1218,'IBK Meter Body CG.125 O/M',305.00,275.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1219,'IBK Meter Body CG.125 N/M',305.00,275.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1220,'IBK Meter Machine CD.70',360.00,324.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1221,'IBK Meter Machine CG.125',360.00,324.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1222,'IBK Meter Plate CD.70',118.00,106.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1223,'IBK Meter Plate CG.125',138.00,124.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1224,'IBK Mid Guard Tail Front CD.70',43.00,39.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1225,'IBK Mid Guard Tail Front CG.125',43.00,39.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1226,'IBK Mid Guard Tail Rear CD.70',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1227,'IBK Mid Guard Tail Rear CG.125',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1228,'IBK Natural Switch CD.70 CDi',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1229,'IBK Natural Patti CD.70',28.00,25.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1230,'IBK Natural Patti CG.125',30.00,27.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1231,'IBK Oil Bolt CD.70 CDi',35.00,32.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1232,'IBK Oil Through Kit CD.70 CDi',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1233,'YFH Brake Shoe CD.70',247.00,222.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1234,'IBK Oil Gauge CD.70',30.00,27.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1235,'IBK Oil Gauge CG.125',38.00,34.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1236,'IBK Oil Pump Sprocket (Metal) CG.125',240.00,216.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1237,'IBK Oil Pump Rod with Bush CD.70',75.00,68.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1238,'IBK Oil Pump Jali CD.70',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1239,'IBK Oil Pump Jali CG.125',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1240,'IBK Petrol Pipe Roll',1375.00,1238.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1241,'IBK Plug Coil CD.70',340.00,306.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1242,'IBK Plug Coil JH.70',360.00,324.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1243,'IBK Push Rubber CD.70 CDi',15.00,14.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1244,'IBK Regulator 12V CD.70',210.00,189.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1245,'IBK Roller Got Kit 82-L CD.70',340.00,306.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1246,'IBK Roller Got Kit 84-L JH.70',360.00,324.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1247,'IBK Rocker Pin Washer +O-Ring CG.125',28.00,25.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1248,'IBK Rocker Bolt CD.70',19.00,17.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1249,'IBK Roller Rubber Set W/O Bush CD.70',64.00,58.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1250,'IBK Seat Frame CD.70 O/M',410.00,369.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1251,'IBK Seat Frame CD.70 N/M',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1252,'IBK Seat Frame JH.70',490.00,441.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:50','2025-07-15 09:58:50'),(1253,'IBK Seat Cawol CD.70 O/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1254,'IBK Seat Cawol CD.70 N/M',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1255,'IBK Seat Cover CD.70 N/M',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1256,'IBK Seat Cover CG.125 N/M',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1257,'IBK Seat Cover CD.100 N/M',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1258,'IBK Seat Cover DLX.125',430.00,387.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1259,'IBK Seat L-Bracket Patri CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1260,'IBK Rear Shock Spring CD.70',630.00,567.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1261,'IBK Rear Shock Spring CG.125',1020.00,918.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1262,'IBK Rear Shock Spring JH.70',1100.00,990.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1263,'IBK Shock Rod CD.70',1380.00,1242.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1264,'IBK Shock Rod CG.125',1380.00,1242.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1265,'IBK Shock Rod JH.70',1380.00,1242.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1266,'IBK Side Spring CD.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1267,'IBK Side Spring CG.125',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1268,'IBK Side Stand CG.125 N/M',205.00,185.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1269,'IBK Side Stand O/M CG.125',200.00,180.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1270,'IBK Side Stand DLX.125',245.00,221.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1271,'IBK Side Stand CD.70 O/M',200.00,180.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1272,'IBK Side Stand CD.70 N/M',205.00,185.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1273,'IBK Silencer Plate Black CD.70',160.00,144.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1274,'IBK Silencer Plate Black CG.125',190.00,171.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1275,'IBK Silencer Chrome Patri CD.70',118.00,106.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1276,'IBK Silencer Chrome Patri U CG.125',510.00,459.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1277,'IBK Silencer Chrome Patri DLX.125',510.00,459.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1278,'IBK Stand Pin CD.70',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1279,'IBK Stand Pin CG.125',120.00,108.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1280,'IBK Sprocket Panel CD.70',595.00,536.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1281,'IBK Sprocket Sleeve CD.70',98.00,88.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1282,'IBK Tappet Cover Chrome CD.70',44.00,40.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1283,'IBK Tappet Cover W/Ring CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1284,'IBK Tensioner Spring CD.70',18.00,16.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1285,'IBK Timing Chain 82L CD.70',178.00,160.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1286,'IBK Timing Chain 84L JH.70',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1287,'IBK Timing Cover Chrome CD.70',115.00,104.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1288,'IBK Valve Set OEM Quality CG.125',480.00,432.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1289,'IBK Valve Spring 4-Pcs Set CD.70',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1290,'IBK Valve Spring 4-Pcs Set CG.125',188.00,169.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1291,'IBK Valve Spring 4-Pcs Set JH.70',140.00,126.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1292,'IBK Washer Kit CD.70 CDi',58.00,52.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1293,'IBK Washer Kit CG.125',78.00,70.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1294,'IBK Rear Mud Flap CD.70',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1295,'IBK Front Mud Flap CD.70',43.00,39.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1296,'IBK Rear Mud Flap CG.125',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1297,'IBK Front Mud Flap CG.125',43.00,39.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1298,'IBK Mud Flap Set CD.70',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1299,'IBK Mud Flap Set CG.125',90.00,81.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1300,'IBK Clutch Seal 12-21-4 CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1301,'IBK Clutch Seal 12-22-5 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1302,'IBK Gear Seal 11-6-24-5 CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1303,'IBK Gear Seal 14-28-7 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1304,'IBK Kick Seal 13-7-24-5 CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1305,'IBK Kick Seal 16-28-7 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1306,'IBK Magnet Seal 22-35-7 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1307,'IBK RPM Seal 6-5-14-5-7 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1308,'IBK Shock Seal 25-35-9 CD.70',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1309,'IBK Shock Seal 27-37-10-5 JH.70',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1310,'IBK Shock Seal 27-39-10-5 CG.125',65.00,59.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1311,'IBK Shock Seal 30-40-10-5 CD.100',95.00,86.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1312,'IBK Magnet Seal 18-9-30-5 CD.70',40.00,36.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1313,'IBK Sprocket Seal 17-29-5 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1314,'IBK Sprocket Seal 20-34-5 CG.125',42.00,38.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1315,'IBK Valve Seal A JH.70',45.00,41.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1316,'IBK Valve Seal A CG.125',47.00,42.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1317,'IBK Valve Seal B CG.125',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1318,'IBK Valve Seal B JH.90',22.00,20.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1319,'DS Spark Plug A7TC CD.70 Box',1460.00,1314.00,'Complete Box = 10 Spark Plugs A7TC','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1320,'DS Spark Plug D8TC CG.125 Box',1550.00,1395.00,'Complete Box = 10 Spark Plugs D8TC','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1321,'NT Piston CD.70 STD',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1322,'NT Piston CD.70 0.50',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1323,'NT Piston CD.70 1.00',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:51','2025-07-15 09:58:51'),(1324,'NT Piston JH.70 STD',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1325,'NT Piston JH.70 0.50',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1326,'NT Piston JH.70 1.00',780.00,702.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1327,'NT Piston CG.125 O/M STD',1040.00,936.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1328,'NT Piston CG.125 O/M 0.50',1040.00,936.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1329,'NT Piston CG.125 O/M 1.00',1040.00,936.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1330,'NT Piston CG.125 N/M STD',1140.00,1026.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1331,'NT Piston CG.125 N/M 0.50',1140.00,1026.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52'),(1332,'NT Piston CG.125 N/M 1.00',1140.00,1026.00,'N/A','0.0',NULL,NULL,NULL,NULL,'active',NULL,3,'2025-07-15 09:58:52','2025-07-15 09:58:52');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_sales`
--

DROP TABLE IF EXISTS `inventory_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `sale_type` enum('retail','wholesale','distributor') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_sales_item_id_foreign` (`item_id`),
  KEY `inventory_sales_company_id_foreign` (`company_id`),
  KEY `inventory_sales_sale_id_foreign` (`sale_id`),
  CONSTRAINT `inventory_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_sales_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_sales_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_sales`
--

LOCK TABLES `inventory_sales` WRITE;
/*!40000 ALTER TABLE `inventory_sales` DISABLE KEYS */;
INSERT INTO `inventory_sales` VALUES (31,21,667,0,'distributor',2367.00,2367.00,3,'2025-07-17 03:25:43','2025-07-17 03:27:49'),(32,22,675,80,'retail',3270.00,327000.00,3,'2025-07-17 04:36:46','2025-07-17 04:37:24');
/*!40000 ALTER TABLE `inventory_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_27_192207_create_companies_table',1),(5,'2025_05_27_192431_add_company_id_status_role_to_users_table',1),(6,'2025_05_27_213225_create_categories_table',1),(7,'2025_05_27_213645_create_suppliers_table',1),(8,'2025_05_27_214529_create_inventory_table',1),(9,'2025_05_28_063801_create_purchases_table',1),(10,'2025_05_28_063856_create_purchase_items_table',1),(11,'2025_05_29_223800_create_customers_table',1),(12,'2025_06_02_223913_create_sales_table',1),(13,'2025_06_02_224026_create_inventory_sales_table',1),(14,'2025_06_02_230752_add_tax_columns_to_companies_table',1),(15,'2025_06_03_212130_add_customer_id_to_sales_table',1),(16,'2025_06_11_010502_add_sale_code_to_sales_table',1),(17,'2025_06_11_010613_add_sale_code_to_sales_table',1),(18,'2025_06_16_212717_create_external_purchases_table',1),(19,'2025_06_16_212844_create_external_sales_table',1),(20,'2025_06_17_211110_create_expenses_table',1),(21,'2025_07_08_201203_add_inactive_at_to_users_table',1),(22,'2025_07_09_000000_create_payments_table',1),(23,'2025_07_09_000001_create_employees_table',1),(24,'2025_07_09_000002_create_salary_payments_table',1),(25,'2025_07_09_154958_add_permissions_to_users_table',1),(26,'2025_07_09_164252_create_activity_logs_table',1),(27,'2025_07_09_184203_add_customer_name_to_sales_table',1),(28,'2025_07_09_184452_add_sale_type_to_sales_table',1),(29,'2025_07_09_185341_add_amount_received_and_change_return_to_sales_table',1),(30,'2025_07_09_190000_create_return_transactions_table',1),(31,'2025_07_09_193415_add_city_to_customers_table',1),(32,'2025_07_10_225130_create_distributors_table',1),(33,'2025_07_10_225150_create_shopkeepers_table',1),(34,'2025_07_11_002917_create_distributor_payments_table',1),(35,'2025_07_11_002921_create_distributor_products_table',1),(36,'2025_07_11_002927_create_shopkeeper_transactions_table',1),(37,'2025_07_11_010339_add_assignment_number_to_distributor_products_table',1),(38,'2025_07_11_012135_add_website_address_logo_to_companies_table',1),(39,'2025_07_11_065954_update_sale_type_column_in_sales_table',1),(40,'2025_07_11_070354_update_sale_type_column_in_inventory_sales_table',1),(41,'2025_07_12_125011_make_supplier_and_category_nullable_in_inventory_table',1),(42,'2025_07_12_191033_create_supplier_payments_table',1),(43,'2025_07_12_193552_add_country_to_suppliers_table',1),(44,'2025_07_12_195506_add_currency_fields_to_purchases_table',1),(45,'2025_07_12_200000_add_currency_fields_to_purchases_table',1),(46,'2025_07_14_000001_make_customer_id_nullable_in_external_sales_table',1),(47,'2025_07_14_000002_add_parent_sale_id_to_external_sales_and_purchases',1),(48,'2025_07_15_000223_remove_cascade_delete_from_distributor_payments_table',2),(49,'2025_07_15_000630_remove_cascade_delete_from_distributor_products_table',3),(50,'2025_07_15_000001_update_inventory_sales_drop_cascade_on_sale_id',4),(51,'2025_07_15_000002_update_purchase_items_drop_cascade_on_purchase_id',5),(52,'2025_07_15_000003_update_shopkeeper_transactions_drop_cascade_on_shopkeeper_id',5),(53,'2025_07_15_000004_update_supplier_payments_drop_cascade_on_supplier_id',5),(54,'2025_07_15_000001_add_tax_fields_to_companies_table',6),(55,'2025_07_16_220747_add_deleted_at_to_suppliers_table',7),(56,'2025_07_17_000001_add_deleted_at_to_customers_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `amount_due` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_customer_id_foreign` (`customer_id`),
  CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `inventory_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_inventory_id_foreign` (`inventory_id`),
  KEY `purchase_items_company_id_foreign` (`company_id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  CONSTRAINT `purchase_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
INSERT INTO `purchase_items` VALUES (1,1,667,10,100.00,3,'2025-07-15 23:34:46','2025-07-15 23:34:46'),(2,2,667,10,100.00,3,'2025-07-15 23:37:44','2025-07-15 23:37:44');
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate_to_pkr` decimal(16,8) DEFAULT NULL,
  `pkr_amount` decimal(12,2) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  KEY `purchases_company_id_foreign` (`company_id`),
  CONSTRAINT `purchases_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,1,100.00,3,'GBP',381.53866100,38153.87,'2025-07-16','2025-07-15 23:34:46','2025-07-15 23:34:46'),(2,2,100.00,3,'AED',77.50039000,7750.04,'2025-07-16','2025-07-15 23:37:44','2025-07-15 23:37:44');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_transactions`
--

DROP TABLE IF EXISTS `return_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `return_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processed_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_transactions_sale_id_foreign` (`sale_id`),
  KEY `return_transactions_item_id_foreign` (`item_id`),
  CONSTRAINT `return_transactions_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `return_transactions_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_transactions`
--

LOCK TABLES `return_transactions` WRITE;
/*!40000 ALTER TABLE `return_transactions` DISABLE KEYS */;
INSERT INTO `return_transactions` VALUES (15,21,667,1,2367.00,NULL,1,'2025-07-17 03:27:49','2025-07-17 03:27:49'),(16,22,675,20,3270.00,NULL,1,'2025-07-17 04:37:24','2025-07-17 04:37:24');
/*!40000 ALTER TABLE `return_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_payments`
--

DROP TABLE IF EXISTS `salary_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salary_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salary_payments_employee_id_foreign` (`employee_id`),
  CONSTRAINT `salary_payments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_payments`
--

LOCK TABLES `salary_payments` WRITE;
/*!40000 ALTER TABLE `salary_payments` DISABLE KEYS */;
INSERT INTO `salary_payments` VALUES (1,1,2000.00,'2025-07-17',NULL,'2025-07-17 01:54:22','2025-07-17 01:54:22');
/*!40000 ALTER TABLE `salary_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `company_id` bigint unsigned NOT NULL,
  `sale_type` enum('retail','wholesale','distributor') COLLATE utf8mb4_unicode_ci DEFAULT 'retail',
  `amount_received` decimal(12,2) DEFAULT NULL,
  `change_return` decimal(12,2) DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `distributor_id` bigint unsigned DEFAULT NULL,
  `shopkeeper_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_sale_code_unique` (`sale_code`),
  KEY `sales_company_id_foreign` (`company_id`),
  CONSTRAINT `sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (21,'I003-00001','Super Admin',2367.00,2390.67,1.00,23.67,'cash',0.00,3,'distributor',NULL,0.00,NULL,1,1,NULL,'2025-07-17 03:25:43','2025-07-17 03:25:43'),(22,'I003-00002','Super Admin',327000.00,330270.00,1.00,3270.00,'cash',0.00,3,'retail',330500.00,230.00,NULL,NULL,NULL,'shah','2025-07-17 04:36:46','2025-07-17 04:36:46');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('FYu5FdWyQBsDkJPK99r9isorvBL17CP0aTSsZu3w',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTXA4cXZmNWljQnZ5eFp5TENZM3cxSFhUUWVGc0RNQjBoWVo3eHlPMyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbWFuYWdlLWJhY2t1cCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1752751431);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopkeeper_transactions`
--

DROP TABLE IF EXISTS `shopkeeper_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopkeeper_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shopkeeper_id` bigint unsigned NOT NULL,
  `distributor_id` bigint unsigned NOT NULL,
  `inventory_id` bigint unsigned DEFAULT NULL,
  `type` enum('product_received','product_sold','product_returned','payment_made') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopkeeper_transactions_distributor_id_foreign` (`distributor_id`),
  KEY `shopkeeper_transactions_inventory_id_foreign` (`inventory_id`),
  KEY `shopkeeper_transactions_shopkeeper_id_foreign` (`shopkeeper_id`),
  CONSTRAINT `shopkeeper_transactions_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shopkeeper_transactions_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shopkeeper_transactions_shopkeeper_id_foreign` FOREIGN KEY (`shopkeeper_id`) REFERENCES `shopkeepers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopkeeper_transactions`
--

LOCK TABLES `shopkeeper_transactions` WRITE;
/*!40000 ALTER TABLE `shopkeeper_transactions` DISABLE KEYS */;
INSERT INTO `shopkeeper_transactions` VALUES (12,1,1,NULL,'payment_made',NULL,NULL,2000.00,200.00,'2025-07-17',NULL,'completed','2025-07-17 01:21:05','2025-07-17 01:21:05');
/*!40000 ALTER TABLE `shopkeeper_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopkeepers`
--

DROP TABLE IF EXISTS `shopkeepers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopkeepers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distributor_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remaining_amount` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopkeepers_distributor_id_foreign` (`distributor_id`),
  CONSTRAINT `shopkeepers_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopkeepers`
--

LOCK TABLES `shopkeepers` WRITE;
/*!40000 ALTER TABLE `shopkeepers` DISABLE KEYS */;
INSERT INTO `shopkeepers` VALUES (1,1,'ali','33',NULL,NULL,'2025-07-16 12:37:54','2025-07-16 12:37:54');
/*!40000 ALTER TABLE `shopkeepers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_payments`
--

DROP TABLE IF EXISTS `supplier_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exchange_rate_to_pkr` decimal(16,8) DEFAULT NULL,
  `pkr_amount` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_payments_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `supplier_payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_payments`
--

LOCK TABLES `supplier_payments` WRITE;
/*!40000 ALTER TABLE `supplier_payments` DISABLE KEYS */;
INSERT INTO `supplier_payments` VALUES (8,1,20.00,'2025-07-16',NULL,NULL,'GBP',300.20000100,6004.00,'2025-07-16 01:17:14','2025-07-16 01:17:14'),(10,2,50.00,'2025-07-16',NULL,NULL,'AED',50.00000000,2500.00,'2025-07-16 02:37:20','2025-07-16 02:37:20');
/*!40000 ALTER TABLE `supplier_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `company_id` bigint unsigned NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_company_id_foreign` (`company_id`),
  CONSTRAINT `suppliers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Muwahid','333',NULL,'22',NULL,NULL,3,'United Kingdom','2025-07-15 23:33:01','2025-07-17 04:40:48',NULL),(2,'ahmed','33','33','9',NULL,NULL,3,'UAE','2025-07-15 23:37:00','2025-07-17 04:40:21','2025-07-17 04:40:21'),(3,'ssss','222',NULL,'22',NULL,NULL,3,'Pakistan','2025-07-16 17:09:18','2025-07-17 01:01:32','2025-07-17 01:01:32');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `inactive_at` timestamp NULL DEFAULT NULL,
  `role` enum('superadmin','admin','manager','employee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `permissions` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@mail.com',NULL,'$2y$12$cdZDMSesvw8FXKwOxYhkTOZ.5mfij2dSTUKAQIavnCsI9END0obTm',NULL,'2025-07-14 17:04:25','2025-07-16 12:27:37',3,'active','2026-01-12 12:27:37','admin','[]'),(3,'ali','ali@mail.com',NULL,'$2y$12$G6v4pF.fplWcusZ7etkSY.7Fy6gF3JBE3L8qMPqdlf.qYeOdEGLia',NULL,'2025-07-16 13:32:57','2025-07-16 13:32:57',2,'active',NULL,'admin',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-17 16:25:40
