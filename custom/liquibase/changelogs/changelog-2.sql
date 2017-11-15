-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: kitty
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

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
-- Dumping data for table `DATABASECHANGELOG`
--

LOCK TABLES `DATABASECHANGELOG` WRITE;
/*!40000 ALTER TABLE `DATABASECHANGELOG` DISABLE KEYS */;
INSERT INTO `DATABASECHANGELOG` VALUES ('1','id','/home/pfuhl/NetBeansProjects/gdm/database/liquibase/changelogs/changelog-1.sql','2017-11-08 14:33:32',1,'EXECUTED','7:4f86da9a98768b732b6b76cf9632337b','sql','',NULL,'3.5.3',NULL,NULL,'0148011624'),('2author:thomas.pfuhl','id','/home/pfuhl/NetBeansProjects/gdm/database/liquibase/changelogs/changelog-2.sql','2017-11-08 14:33:32',2,'EXECUTED','7:331ce17f66e30deb11e85789641e727e','sql','',NULL,'3.5.3',NULL,NULL,'0148011624');
/*!40000 ALTER TABLE `DATABASECHANGELOG` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `DATABASECHANGELOGLOCK`
--

LOCK TABLES `DATABASECHANGELOGLOCK` WRITE;
/*!40000 ALTER TABLE `DATABASECHANGELOGLOCK` DISABLE KEYS */;
INSERT INTO `DATABASECHANGELOGLOCK` VALUES (1,'\0',NULL,NULL);
/*!40000 ALTER TABLE `DATABASECHANGELOGLOCK` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `communities`
--

LOCK TABLES `communities` WRITE;
/*!40000 ALTER TABLE `communities` DISABLE KEYS */;
INSERT INTO `communities` VALUES (1,'kitty One','coffee and tea amateurs of Kitty One');
/*!40000 ALTER TABLE `communities` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
INSERT INTO `deposits` VALUES (1,8,1,'2017-11-15 16:36:34'),(2,5,2,'2017-11-08 13:33:32'),(3,1,2,'2017-11-08 13:33:32');
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `gdm_aggregations`
--

LOCK TABLES `gdm_aggregations` WRITE;
/*!40000 ALTER TABLE `gdm_aggregations` DISABLE KEYS */;
INSERT INTO `gdm_aggregations` VALUES (1,'deposits','member_id','amount','SUM'),(2,'products','title','number','SUM');
/*!40000 ALTER TABLE `gdm_aggregations` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'en','English');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'alice@example.org','Alice','A.','1234',1),(2,'bob@example.org','Bob','B.','5678',1);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_03_28_092426_create_languages_table',1),('2017_11_13_173300_create_aggregations_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'coffee','pack',1,'2017-11-15 16:40:57'),(2,'filter','pack',1,'2017-11-15 16:40:57'),(3,'milk','litre',2,'2017-11-15 16:40:57'),(4,'coffee','pack',1,'2017-11-15 16:40:57');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','zeus','zeus@example.org','$2y$10$jxCrS6xpCkHZbCsLO3lTTuvushwE0bJb96jp7z7/TrU65.9TQuIBa','5c900744eab260996111e3b3d5979013',1,1,'en','NTXqfIVLXtVo2fTCLqvhXK4OSoDUbR34qWE2ZTBUWmsmPeRH0g5PaXdiHdqx','2017-10-17 09:03:32','2017-11-06 15:45:37',NULL),(2,'Default Admin','admin','admin@example.org','$2y$10$L5edhQkit77Ltg0eDmr2aekEcS1qUThpCQzI4q8qadcx79rm0WRhe','aad59a040fc48587fb9f75c10fb95ebc',1,1,'en',NULL,'2017-10-17 09:03:32','2017-10-17 09:03:32',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
