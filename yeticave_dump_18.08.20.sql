-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnueabihf (armv7l)
--
-- Host: localhost    Database: YetiCave
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-0+deb9u1

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
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `symbol_code` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `symbol_code` (`symbol_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
INSERT INTO `Categories` VALUES (1,'Доски и лыжи','boards'),(2,'Крепления','attachment'),(3,'Ботинки','boots'),(4,'Одежда','clothing'),(5,'Инструменты','tools'),(6,'Разное','others');
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lots`
--

DROP TABLE IF EXISTS `Lots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `winner_id` int(10) unsigned DEFAULT NULL,
  `name` char(255) NOT NULL,
  `detail` text NOT NULL,
  `cost_start` decimal(12,2) NOT NULL,
  `step_cost` decimal(12,2) NOT NULL,
  `photo` char(255) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `date_finished` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `winner_id` (`winner_id`),
  KEY `name_idx` (`name`(191)),
  FULLTEXT KEY `lots_search` (`name`,`detail`),
  CONSTRAINT `Lots_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  CONSTRAINT `Lots_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`id`),
  CONSTRAINT `Lots_ibfk_3` FOREIGN KEY (`winner_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lots`
--

LOCK TABLES `Lots` WRITE;
/*!40000 ALTER TABLE `Lots` DISABLE KEYS */;
INSERT INTO `Lots` VALUES (1,1,1,2,'2014 Rossignol District Snowboard','JJSSSWEE',10999.00,10.00,'uploads/lot-1.jpg','2020-04-06 16:48:40','2020-04-01 00:00:00'),(2,2,1,NULL,'DC Ply Mens 2016/2017 Snowboard0','EDFIN',159999.00,20.00,'uploads/lot-2.jpg','2020-04-06 16:48:40','2020-10-20 00:00:00'),(3,3,2,NULL,'Крепления Union Contact Pro 2015 года размер L/XL','UEUWUQS',8000.00,10.00,'uploads/lot-3.jpg','2020-04-06 16:48:40','2020-04-30 00:00:00'),(4,1,3,NULL,'Ботинки для сноуборда DC Mutiny Charocal','uuusssxx',10999.00,30.00,'uploads/lot-4.jpg','2020-04-06 16:48:40','2020-08-20 00:00:00'),(5,3,4,NULL,'Куртка для сноуборда DC Mutiny Charocal','eewwssw',7500.00,30.00,'uploads/lot-5.jpg','2020-04-06 16:48:40','2020-09-21 00:00:00'),(6,2,6,NULL,'Маска Oakley Canopy','update info',5400.00,5.00,'uploads/lot-6.jpg','2020-04-06 16:48:40','2020-07-20 00:00:00'),(45,1,1,7,'Горные лыжи','Крутые горные лыжи',30000.00,1000.00,'uploads/s1200.jpg','2020-04-28 00:00:00','2020-04-30 00:00:00'),(46,1,1,NULL,'Горные лыжи','yutt',100.00,11.00,'uploads/','2020-05-11 00:00:00','2020-05-20 00:00:00'),(47,7,1,7,'Сноуборд','Крутой сноуборд',50000.00,2000.00,'uploads/roxy.jpg','2020-05-14 00:00:00','2020-05-31 00:00:00'),(48,7,4,NULL,'Шлем горнолыжный','шлем',10000.00,500.00,'../uploads/1025260791.jpg','2020-06-03 00:00:00','2020-06-30 00:00:00'),(49,8,4,7,'Ботинки','Ботинки',50000.00,1000.00,'/uploads/a8e8197f632d11e3804de83935202582_e0809c5b8d3a4d129fff4d46b2e2ee6b.jpg','2020-06-03 00:00:00','2020-06-30 00:00:00'),(50,7,1,7,'Ski mounting','Super ski',10000.00,200.00,'/uploads/gornie.jpg','2020-07-22 00:00:00','2020-07-31 00:00:00');
/*!40000 ALTER TABLE `Lots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rates`
--

DROP TABLE IF EXISTS `Rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `lot_id` int(10) unsigned NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lot_id` (`lot_id`),
  CONSTRAINT `Rates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  CONSTRAINT `Rates_ibfk_2` FOREIGN KEY (`lot_id`) REFERENCES `Lots` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rates`
--

LOCK TABLES `Rates` WRITE;
/*!40000 ALTER TABLE `Rates` DISABLE KEYS */;
INSERT INTO `Rates` VALUES (1,2,1,11000.00,'2020-04-06 16:48:40'),(2,3,2,170000.00,'2020-04-06 16:48:40'),(3,2,1,12000.00,'2020-04-06 16:48:40'),(5,7,49,1200.00,'2020-07-17 00:00:00'),(6,7,49,1300.00,'2020-07-17 00:00:00'),(7,7,45,31000.00,'2020-07-17 00:00:00'),(8,7,45,32000.00,'2020-07-17 00:00:00'),(9,7,47,53000.00,'2020-07-17 00:00:00'),(10,7,47,54000.00,'2020-07-17 00:00:00'),(11,7,50,10200.00,'2020-07-22 00:00:00'),(12,7,50,10200.00,'2020-07-22 00:00:00'),(13,7,50,10400.00,'2020-07-22 00:00:00');
/*!40000 ALTER TABLE `Rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `email` char(50) NOT NULL,
  `password` char(100) NOT NULL,
  `contact` char(255) NOT NULL,
  `date_registration` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `password_idx` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Ivan','ivan@mail.ru','123','112233','2020-04-06 16:48:40'),(2,'Anna','anna@yandex.ru','4455','68jkjk','2020-04-06 16:48:40'),(3,'Elena','elena@gmail.ru','8877','kjlos','2020-04-06 16:48:40'),(4,'Any','any@yandex.ru','123','kjklj;l','0000-00-00 00:00:00'),(5,'Deny','Deny@yooh.com','123','kjl;kl;asd','2020-05-03 00:00:00'),(6,'Fred','fred@foo.com','123','kj;lj;zjkxjc','2020-05-03 00:00:00'),(7,'Mery','mery@mail.ru','$2y$10$qZwn2lVmSixNvlUXTUG.y.wGtvRo9KTY73A41NxCk3wJtoQybGwEC','kjkljklzjkclx','2020-05-03 00:00:00'),(8,'Den','den@email.com','$2y$10$3SBiC8/FxajL3RbAC66v8u43elF3n1uw3MhNprWlSt8lNS6ORVHG.','kljklj;','2020-05-05 00:00:00');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-18 20:56:52
