CREATE DATABASE  IF NOT EXISTS `gourmet_destination` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gourmet_destination`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: gourmet_guide
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `booking_status`
--

DROP TABLE IF EXISTS `booking_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_status` (
  `id` tinyint unsigned NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_status`
--

LOCK TABLES `booking_status` WRITE;
/*!40000 ALTER TABLE `booking_status` DISABLE KEYS */;
INSERT INTO `booking_status` VALUES (0,'Planning'),(1,'Unused'),(2,'Unused'),(3,'Confirmed'),(4,'Reviewed');
/*!40000 ALTER TABLE `booking_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int unsigned NOT NULL,
  `experience_id` int unsigned NOT NULL,
  `status_id` tinyint unsigned NOT NULL DEFAULT '0',
  `participants` tinyint unsigned NOT NULL DEFAULT '1',
  `booking_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bookings_fk_user_id` (`user_id`),
  KEY `bookings_fk_experience_id` (`experience_id`),
  KEY `bookings_fk_status_id` (`status_id`),
  CONSTRAINT `bookings_fk_experience_id` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookings_fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `booking_status` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE,
  CONSTRAINT `bookings_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES ('0','Hidden'),('CAN','Canada'),('USA','United States of America');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experience_reviews`
--

DROP TABLE IF EXISTS `experience_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experience_reviews` (
  `experience_id` int unsigned NOT NULL,
  `review_id` int unsigned NOT NULL,
  PRIMARY KEY (`experience_id`,`review_id`),
  KEY `experience_reviews_review_id` (`review_id`),
  CONSTRAINT `experience_reviews_fk_experience_id` FOREIGN KEY (`experience_id`) REFERENCES `experiences` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `experience_reviews_review_id` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experience_reviews`
--

LOCK TABLES `experience_reviews` WRITE;
/*!40000 ALTER TABLE `experience_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `experience_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiences` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `host_id` int unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `min_participants` tinyint unsigned NOT NULL DEFAULT '1',
  `max_participants` tinyint unsigned NOT NULL DEFAULT '12',
  `bookable_days` int unsigned NOT NULL DEFAULT '0',
  `bookings_open_start` time NOT NULL DEFAULT '00:00:00',
  `bookings_open_end` time NOT NULL DEFAULT '23:30:00',
  `duration` tinyint unsigned NOT NULL DEFAULT '1',
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `pricing_method_id` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuisine_tag_id` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `experiences_fk_host_id` (`host_id`),
  KEY `experiences_relation_fk_pricing_method_id` (`pricing_method_id`),
  CONSTRAINT `experiences_fk_host_id` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `experiences_relation_fk_pricing_method_id` FOREIGN KEY (`pricing_method_id`) REFERENCES `pricing_methods` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `host_reviews`
--

DROP TABLE IF EXISTS `host_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `host_reviews` (
  `user_id` int unsigned NOT NULL,
  `review_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`review_id`),
  KEY `host_reviews_fk_review_id` (`review_id`),
  CONSTRAINT `host_reviews_fk_review_id` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `host_reviews_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `host_reviews`
--

LOCK TABLES `host_reviews` WRITE;
/*!40000 ALTER TABLE `host_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `host_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricing_methods`
--

DROP TABLE IF EXISTS `pricing_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pricing_methods` (
  `id` tinyint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing_methods`
--

LOCK TABLES `pricing_methods` WRITE;
/*!40000 ALTER TABLE `pricing_methods` DISABLE KEYS */;
INSERT INTO `pricing_methods` VALUES (0,'Per Person','/person'),(1,'Fixed','');
/*!40000 ALTER TABLE `pricing_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reviews_fk_user_id` (`user_id`),
  CONSTRAINT `reviews_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` tinyint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (0,'Admin'),(1,'Tourist'),(2,'Host');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subdivisions`
--

DROP TABLE IF EXISTS `subdivisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subdivisions` (
  `id` varchar(2) NOT NULL,
  `country_id` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`country_id`),
  KEY `subdivision_fk_country_id` (`country_id`),
  CONSTRAINT `subdivision_fk_country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subdivisions`
--

LOCK TABLES `subdivisions` WRITE;
/*!40000 ALTER TABLE `subdivisions` DISABLE KEYS */;
INSERT INTO `subdivisions` VALUES ('0','0','Hidden'),('0','CAN','Hidden'),('0','USA','Hidden'),('AB','CAN','Alberta'),('AK','USA','Alaska'),('AL','USA','Alabama'),('AR','USA','Arkansas'),('AZ','USA','Arizona'),('BC','CAN','British Columbia'),('CA','USA','California'),('CO','USA','Colorado'),('CT','USA','Connecticut'),('DC','USA','District Of Columbia'),('DE','USA','Delaware'),('FL','USA','Florida'),('GA','USA','Georgia'),('HI','USA','Hawaii'),('IA','USA','Iowa'),('ID','USA','Idaho'),('IL','USA','Illinois'),('IN','USA','Indiana'),('KS','USA','Kansas'),('KY','USA','Kentucky'),('LA','USA','Louisiana'),('MA','USA','Massachusetts'),('MB','CAN','Manitoba'),('MD','USA','Maryland'),('ME','USA','Maine'),('MI','USA','Michigan'),('MN','USA','Minnesota'),('MO','USA','Missouri'),('MS','USA','Mississippi'),('MT','USA','Montana'),('NB','CAN','New Brunswick'),('NC','USA','North Carolina'),('ND','USA','North Dakota'),('NE','USA','Nebraska'),('NH','USA','New Hampshire'),('NJ','USA','New Jersey'),('NL','CAN','Newfoundland and Labrador'),('NM','USA','New Mexico'),('NS','CAN','Nova Scotia'),('NT','CAN','Northwest Territories'),('NU','CAN','Nunavut'),('NV','USA','Nevada'),('NY','USA','New York'),('OH','USA','Ohio'),('OK','USA','Oklahoma'),('ON','CAN','Ontario'),('OR','USA','Oregon'),('PA','USA','Pennsylvania'),('PE','CAN','Prince Edward Island'),('QC','CAN','Quebec'),('RI','USA','Rhode Island'),('SC','USA','South Carolina'),('SD','USA','South Dakota'),('SK','CAN','Saskatchewan'),('TN','USA','Tennessee'),('TX','USA','Texas'),('UT','USA','Utah'),('VA','USA','Virginia'),('VT','USA','Vermont'),('WA','USA','Washington'),('WI','USA','Wisconsin'),('WV','USA','West Virginia'),('WY','USA','Wyoming'),('YT','CAN','Yukon');
/*!40000 ALTER TABLE `subdivisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_types`
--

DROP TABLE IF EXISTS `tag_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_types` (
  `id` tinyint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_types`
--

LOCK TABLES `tag_types` WRITE;
/*!40000 ALTER TABLE `tag_types` DISABLE KEYS */;
INSERT INTO `tag_types` VALUES (0,'Host Type'),(1,'Cuisine');
/*!40000 ALTER TABLE `tag_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_id` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tags_fk_tag_type_id` (`type_id`),
  CONSTRAINT `tags_fk_tag_type_id` FOREIGN KEY (`type_id`) REFERENCES `tag_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'American',1),(2,'Chinese',1),(3,'Italian',1),(4,'French',1),(5,'Japanese',1),(6,'Korean',1),(7,'Indian',1),(8,'Thai',1),(9,'Mexican',1),(10,'Vietnamese',1),(11,'Greek',1),(12,'Local Guide',0),(13,'Home Chef',0);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int unsigned NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Other',
  `stripe_checkout_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_fk_user_id` (`user_id`),
  CONSTRAINT `transactions_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tags`
--

DROP TABLE IF EXISTS `user_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tags` (
  `user_id` int unsigned NOT NULL,
  `tag_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`tag_id`),
  KEY `user_tags_fk_tag_id` (`tag_id`),
  CONSTRAINT `user_tags_fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_tags_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tags`
--

LOCK TABLES `user_tags` WRITE;
/*!40000 ALTER TABLE `user_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role_id` tinyint unsigned NOT NULL DEFAULT '1',
  `country_id` varchar(3) NOT NULL DEFAULT '0',
  `subdivision_id` varchar(2) NOT NULL DEFAULT '0',
  `bio` text,
  `signup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stripe_customer_id` varchar(255) NOT NULL,
  `stripe_subscription_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ind_email` (`email`),
  KEY `users_fk_country_id` (`country_id`),
  KEY `users_fk_subdivision_id` (`subdivision_id`),
  KEY `users_fk_role_id` (`role_id`),
  CONSTRAINT `users_fk_country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `users_fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET DEFAULT ON UPDATE CASCADE,
  CONSTRAINT `users_fk_subdivision_id` FOREIGN KEY (`subdivision_id`) REFERENCES `subdivisions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-04-02 21:34:16
