-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for debian-linux-gnueabihf (armv7l)
--
-- Host: localhost    Database: YetiCave
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-0+deb9u1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Categories`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categories` (
  `id` int(10) unsigned NOT NULL,
  `name` char(50) DEFAULT NULL,
  `symbol_code` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `symbol_code` (`symbol_code`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` VALUES (1,'Доски и лыжи','boards');
INSERT INTO `Categories` VALUES (2,'Крепления','attachment');
INSERT INTO `Categories` VALUES (3,'Ботинки','boots');
INSERT INTO `Categories` VALUES (4,'Одежда','clothing');
INSERT INTO `Categories` VALUES (5,'Инструменты','tools');
INSERT INTO `Categories` VALUES (6,'Разное','others');

--
-- Table structure for table `Lots`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lots` (
  `id` int(10) unsigned NOT NULL,
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lots`
--

INSERT INTO `Lots` VALUES (1,1,1,NULL,'2014 Rossignol District Snowboard','JJSSSWEE',10999.00,10.00,'uploads/lot-1.jpg','2020-04-06 16:48:40','2020-04-01 00:00:00');
INSERT INTO `Lots` VALUES (2,2,1,NULL,'DC Ply Mens 2016/2017 Snowboard0','EDFIN',159999.00,20.00,'uploads/lot-2.jpg','2020-04-06 16:48:40','2020-10-20 00:00:00');
INSERT INTO `Lots` VALUES (3,3,2,NULL,'Крепления Union Contact Pro 2015 года размер L/XL','UEUWUQS',8000.00,10.00,'uploads/lot-3.jpg','2020-04-06 16:48:40','2020-04-30 00:00:00');
INSERT INTO `Lots` VALUES (4,1,3,NULL,'Ботинки для сноуборда DC Mutiny Charocal','uuusssxx',10999.00,30.00,'uploads/lot-4.jpg','2020-04-06 16:48:40','2020-08-20 00:00:00');
INSERT INTO `Lots` VALUES (5,3,4,NULL,'Куртка для сноуборда DC Mutiny Charocal','eewwssw',7500.00,30.00,'uploads/lot-5.jpg','2020-04-06 16:48:40','2020-09-21 00:00:00');
INSERT INTO `Lots` VALUES (6,2,6,NULL,'Маска Oakley Canopy','update info',5400.00,5.00,'uploads/lot-6.jpg','2020-04-06 16:48:40','2020-07-20 00:00:00');
INSERT INTO `Lots` VALUES (45,1,1,NULL,'Горные лыжи','Крутые горные лыжи',30000.00,1000.00,'uploads/s1200.jpg','2020-04-28 00:00:00','2020-04-30 00:00:00');
INSERT INTO `Lots` VALUES (46,1,1,NULL,'Горные лыжи','yutt',100.00,11.00,'uploads/','2020-05-11 00:00:00','2020-05-20 00:00:00');
INSERT INTO `Lots` VALUES (47,7,1,NULL,'Сноуборд','Крутой сноуборд',50000.00,2000.00,'uploads/roxy.jpg','2020-05-14 00:00:00','2020-05-31 00:00:00');

--
-- Table structure for table `Rates`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rates` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `lot_id` int(10) unsigned NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lot_id` (`lot_id`),
  CONSTRAINT `Rates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  CONSTRAINT `Rates_ibfk_2` FOREIGN KEY (`lot_id`) REFERENCES `Lots` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rates`
--

INSERT INTO `Rates` VALUES (1,2,1,11000.00,'2020-04-06 16:48:40');
INSERT INTO `Rates` VALUES (2,3,2,170000.00,'2020-04-06 16:48:40');
INSERT INTO `Rates` VALUES (3,2,1,12000.00,'2020-04-06 16:48:40');

--
-- Table structure for table `Users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(10) unsigned NOT NULL,
  `name` char(50) NOT NULL,
  `email` char(50) NOT NULL,
  `password` char(100) NOT NULL,
  `contact` char(255) NOT NULL,
  `date_registration` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `password_idx` (`password`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` VALUES (1,'Ivan','ivan@mail.ru','123','112233','2020-04-06 16:48:40');
INSERT INTO `Users` VALUES (2,'Anna','anna@yandex.ru','4455','68jkjk','2020-04-06 16:48:40');
INSERT INTO `Users` VALUES (3,'Elena','elena@gmail.ru','8877','kjlos','2020-04-06 16:48:40');
INSERT INTO `Users` VALUES (4,'Any','any@yandex.ru','123','kjklj;l','0000-00-00 00:00:00');
INSERT INTO `Users` VALUES (5,'Deny','Deny@yooh.com','123','kjl;kl;asd','2020-05-03 00:00:00');
INSERT INTO `Users` VALUES (6,'Fred','fred@foo.com','123','kj;lj;zjkxjc','2020-05-03 00:00:00');
INSERT INTO `Users` VALUES (7,'Mery','mery@mail.ru','$2y$10$qZwn2lVmSixNvlUXTUG.y.wGtvRo9KTY73A41NxCk3wJtoQybGwEC','kjkljklzjkclx','2020-05-03 00:00:00');
INSERT INTO `Users` VALUES (8,'Den','den@email.com','$2y$10$3SBiC8/FxajL3RbAC66v8u43elF3n1uw3MhNprWlSt8lNS6ORVHG.','kljklj;','2020-05-05 00:00:00');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-29 21:45:40
