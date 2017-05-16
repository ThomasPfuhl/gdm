CREATE DATABASE  IF NOT EXISTS `projektmetadaten` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `projektmetadaten`;
-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: projektmetadaten
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `DATABASECHANGELOG`
--

DROP TABLE IF EXISTS `DATABASECHANGELOG`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DATABASECHANGELOG` (
  `ID` varchar(255) NOT NULL,
  `AUTHOR` varchar(255) NOT NULL,
  `FILENAME` varchar(255) NOT NULL,
  `DATEEXECUTED` datetime NOT NULL,
  `ORDEREXECUTED` int(11) NOT NULL,
  `EXECTYPE` varchar(10) NOT NULL,
  `MD5SUM` varchar(35) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `COMMENTS` varchar(255) DEFAULT NULL,
  `TAG` varchar(255) DEFAULT NULL,
  `LIQUIBASE` varchar(20) DEFAULT NULL,
  `CONTEXTS` varchar(255) DEFAULT NULL,
  `LABELS` varchar(255) DEFAULT NULL,
  `DEPLOYMENT_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DATABASECHANGELOG`
--

LOCK TABLES `DATABASECHANGELOG` WRITE;
/*!40000 ALTER TABLE `DATABASECHANGELOG` DISABLE KEYS */;
INSERT INTO `DATABASECHANGELOG` VALUES ('1','id','/home/pfuhl/NetBeansProjects/moehring/database/liquibase/changelogs/changelog-1.sql','2017-05-15 09:29:51',1,'EXECUTED','7:6e3937303dccec607645ad848c861b9f','sql','',NULL,'3.5.3',NULL,NULL,'4833391524'),('add fields to networks','thomas.pfuhl','/home/pfuhl/NetBeansProjects/moehring/database/liquibase/changelogs/changelog-2.xml','2017-05-15 09:29:51',2,'EXECUTED','7:2196227edd7820b989b52ed887c1eba7','addColumn tableName=networks','add properties',NULL,'3.5.3',NULL,NULL,'4833391524'),('remove fields from networks','thomas.pfuhl','/home/pfuhl/NetBeansProjects/moehring/database/liquibase/changelogs/changelog-3.xml','2017-05-15 09:29:51',3,'EXECUTED','7:8932ac9fe56c003697f62563c8d36f53','dropColumn tableName=networks','remove properties',NULL,'3.5.3',NULL,NULL,'4833391524'),('1','id','changelogs/changelog-1.sql','2017-05-15 09:29:51',4,'EXECUTED','7:6e3937303dccec607645ad848c861b9f','sql','',NULL,'3.5.3',NULL,NULL,'4833391524'),('add fields to networks','thomas.pfuhl','changelogs/changelog-2.xml','2017-05-15 09:29:51',5,'EXECUTED','7:2196227edd7820b989b52ed887c1eba7','addColumn tableName=networks','add properties',NULL,'3.5.3',NULL,NULL,'4833391524'),('remove fields from networks','thomas.pfuhl','changelogs/changelog-3.xml','2017-05-15 09:29:51',6,'EXECUTED','7:8932ac9fe56c003697f62563c8d36f53','dropColumn tableName=networks','remove properties',NULL,'3.5.3',NULL,NULL,'4833391524');
/*!40000 ALTER TABLE `DATABASECHANGELOG` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DATABASECHANGELOGLOCK`
--

DROP TABLE IF EXISTS `DATABASECHANGELOGLOCK`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DATABASECHANGELOGLOCK` (
  `ID` int(11) NOT NULL,
  `LOCKED` bit(1) NOT NULL,
  `LOCKGRANTED` datetime DEFAULT NULL,
  `LOCKEDBY` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DATABASECHANGELOGLOCK`
--

LOCK TABLES `DATABASECHANGELOGLOCK` WRITE;
/*!40000 ALTER TABLE `DATABASECHANGELOGLOCK` DISABLE KEYS */;
INSERT INTO `DATABASECHANGELOGLOCK` VALUES (1,'\0',NULL,NULL);
/*!40000 ALTER TABLE `DATABASECHANGELOGLOCK` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the agents table',
  `orcid` varchar(100) DEFAULT NULL COMMENT 'ORCID of the person',
  `title` varchar(100) DEFAULT NULL COMMENT 'Academic degree of the person',
  `givenName` varchar(100) DEFAULT NULL COMMENT 'Given name of the person',
  `familyName` varchar(100) DEFAULT NULL COMMENT 'Family name of the person',
  `institutionID` bigint(20) unsigned DEFAULT NULL COMMENT 'Foreign key to the institutions table as affiliation of the agent	FK',
  `role` varchar(500) DEFAULT NULL COMMENT 'Role or Position of the person',
  `email` varchar(100) DEFAULT NULL COMMENT 'Email address of the person',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Telephone number of the person including country code',
  `fax` varchar(100) DEFAULT NULL COMMENT 'Fax number of the person including country code',
  `website` varchar(500) DEFAULT NULL COMMENT 'URL of the personal website of the person	URL',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of agents. This can be natural persons or bodies / committees.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the institutions table',
  `name` varchar(500) DEFAULT NULL COMMENT 'Name of the institution',
  `abbrev` varchar(100) DEFAULT NULL COMMENT 'Abbreviation of the institution',
  `address` text COMMENT 'Address of the institution',
  `countryISO2` varchar(100) DEFAULT NULL COMMENT 'Country ISO 2-letter-code of the institution',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of institutions. This can be institutes s.str., organizations or bodies / committees';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutions`
--

LOCK TABLES `institutions` WRITE;
/*!40000 ALTER TABLE `institutions` DISABLE KEYS */;
/*!40000 ALTER TABLE `institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_id_edited` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_name_unique` (`name`),
  UNIQUE KEY `languages_lang_code_unique` (`lang_code`),
  KEY `languages_user_id_foreign` (`user_id`),
  KEY `languages_user_id_edited_foreign` (`user_id_edited`),
  CONSTRAINT `languages_user_id_edited_foreign` FOREIGN KEY (`user_id_edited`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `languages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,NULL,'English','gb',NULL,NULL,'2017-04-27 07:52:45','2017-04-27 07:52:45',NULL),(2,NULL,'Српски','rs',NULL,NULL,'2017-04-27 07:52:45','2017-04-27 07:52:45',NULL),(3,NULL,'Bosanski','ba',NULL,NULL,'2017-04-27 07:52:45','2017-04-27 07:52:45',NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2014_10_18_195027_create_languages_table',1),('2014_10_18_225005_create_article_categories_table',1),('2014_10_18_225505_create_articles_table',1),('2014_10_18_225928_create_photo_albums_table',1),('2014_10_18_231619_create_photos_table',1),('2015_12_28_000600_add_author_to_photos_table',1),('2017_03_27_081515_add_geo_to_photos_table',1),('2017_03_28_064102_create_ajax_image_table',1),('2017_03_28_092426_add_language_to_users_table',1),('2017_03_30_120252_create_keywords_table',1),('2017_03_30_123300_add_weight_to_photos_table',1),('2017_04_27_094421_create_projects_table',1),('2017_05_02_132016_create_projects_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `networkPartners`
--

DROP TABLE IF EXISTS `networkPartners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `networkPartners` (
  `projectID` bigint(20) unsigned DEFAULT NULL COMMENT 'foreign key to the projects table	FK',
  `proposalID` bigint(20) unsigned DEFAULT NULL COMMENT 'foreign key to the proposals table	FK',
  `institutionID` bigint(20) unsigned DEFAULT '1' COMMENT 'foreign key to the institutions table as indication of the partner institution	FK',
  `networkTypeID` bigint(20) unsigned DEFAULT '1' COMMENT 'foreign key to the networksType table	FK'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT=' Table of network partners.	A look-up table for many-to-many relations between partners';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `networkPartners`
--

LOCK TABLES `networkPartners` WRITE;
/*!40000 ALTER TABLE `networkPartners` DISABLE KEYS */;
/*!40000 ALTER TABLE `networkPartners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `networks`
--

DROP TABLE IF EXISTS `networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `networks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the networks table',
  `type` varchar(500) DEFAULT NULL COMMENT 'Category or type of the Network. Has controlled vocabulary	(consortium|association|other)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of networks. As the network partners table this is a look-up reference';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `networks`
--

LOCK TABLES `networks` WRITE;
/*!40000 ALTER TABLE `networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Title of the project',
  `description` text COLLATE utf8_unicode_ci COMMENT 'Abstract of the project',
  `startDate` date NOT NULL COMMENT 'Date of project start',
  `endDate` date NOT NULL COMMENT 'Date of project start',
  `remarks` text COLLATE utf8_unicode_ci COMMENT 'Remarks related to the project',
  `officialProjectID` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The project''s identifier or reference that is assigned by official instances (e.g. the funding agency,  GEPRIS ID, other funding ID)',
  `sapID` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Foreign key to the SAP systemFK. No joins possible, but manual reference to SAP',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_officialprojectid_unique` (`officialProjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proposals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primarykey of the proposals table',
  `projectID` bigint(20) unsigned DEFAULT '1' COMMENT 'foreign key to the projects table FK',
  `fundingAgencyID` bigint(20) unsigned DEFAULT NULL COMMENT 'foreign key to the agencies table as funding agency	FK',
  `submissonDate` date DEFAULT NULL COMMENT 'Date of submission',
  `acceptionDate` date DEFAULT NULL COMMENT 'Date of proposal acception',
  `rejectionDate` date DEFAULT NULL COMMENT 'Date of proposal rejection',
  `principalInvestigatorID` bigint(20) unsigned DEFAULT NULL COMMENT 'foreign key to the agents table	FK',
  `status` varchar(100) DEFAULT NULL COMMENT 'Status of the proposal: submitted, accepted, rejected	controlled vocabulary (submitted|accepted|rejected)',
  `call` varchar(500) DEFAULT NULL COMMENT 'reference to the call for proposals',
  `proposedFunding` float DEFAULT NULL COMMENT 'Proposed amount of money',
  `grantedFunding` float DEFAULT NULL COMMENT 'Amount of money that has been granted',
  `proposedFundingCurrency` varchar(3) DEFAULT NULL COMMENT 'Currency of the proposed amount of money, expressed in	3letter-ISO-Standard',
  `startDate` date DEFAULT NULL COMMENT 'Date of proposed project start',
  `endDate` date DEFAULT NULL COMMENT 'Date of proposed project end',
  `remarks` text COMMENT 'Remarks related to the proposal',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of proposals, regardless of the status of proposal or derived project';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposals`
--

LOCK TABLES `proposals` WRITE;
/*!40000 ALTER TABLE `proposals` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `language` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin_user','admin@admin.com','$2y$10$qSmjozeYXVQPwQd82z98suZjswRDWY.lyREsmfqkVKOtstQuJMj6u','0691b4cdaa750505377fb26059bd0220',1,1,'R3hXeG2iFLqXZEF4GDhyWZU4pRFmOdBn8uQKU1PNNXGIWqgHhlo8yCdSRnGW','2017-04-27 07:52:45','2017-05-05 06:41:31',NULL,0),(2,'Test User','test_user','user@user.com','$2y$10$ED.dqz7dz/jrAx72cCNjCugBacsGmOnef1QHoZkxgZfX0MsLgwGwe','6876acf77baa53958aac9c422ecdf92f',1,0,NULL,'2017-04-27 07:52:45','2017-04-27 07:52:45',NULL,0),(10,'Thomas Pfuhl','thomas.pfuhl','thomas.pfuhl@mfn-berlin.de','$2y$10$rxE9SVp5JyKUfBLpV9xcmeaGth4zF6a1dAXcv0UX7QRLqdL7VimF6','XQGKDuZywXokzPIUuhcpCjCIGcZtfKUK',1,0,'xzExHYvmNKHS4BJttmEKPna5fYZbv0gLiOvDPZ9ChJZZGt4pJbZwABkP5mvU','2017-05-03 18:16:16','2017-05-12 11:29:35',NULL,0),(11,'Falko Glöckler','falko.gloeckler','falko.gloeckler@mfn-berlin.de','$2y$10$Js77yOfK3tuVoajVo7dkZOyK715inUmczUez5uxGv2RZAaFhnPtPu','f69A8DEVJF1vc9aNfSRfvTzQqWMh6drh',1,0,NULL,'2017-05-04 06:24:46','2017-05-04 06:24:46',NULL,0);
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

-- Dump completed on 2017-05-15  9:32:23
