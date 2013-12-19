CREATE DATABASE  IF NOT EXISTS `asterisk` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `asterisk`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 10.107.0.7    Database: asterisk
-- ------------------------------------------------------
-- Server version	5.1.72-2

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
-- Table structure for table `sip`
--

DROP TABLE IF EXISTS `sip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '',
  `host` varchar(31) NOT NULL DEFAULT '',
  `nat` varchar(5) NOT NULL DEFAULT 'no',
  `type` enum('user','peer','friend') NOT NULL DEFAULT 'friend',
  `accountcode` varchar(20) DEFAULT NULL,
  `amaflags` varchar(13) DEFAULT NULL,
  `call-limit` smallint(5) unsigned DEFAULT NULL,
  `callgroup` varchar(10) DEFAULT NULL,
  `callerid` varchar(80) DEFAULT NULL,
  `cancallforward` char(3) DEFAULT 'yes',
  `canreinvite` char(3) DEFAULT 'yes',
  `context` varchar(80) DEFAULT NULL,
  `defaultip` varchar(15) DEFAULT NULL,
  `dtmfmode` varchar(7) DEFAULT NULL,
  `fromuser` varchar(80) DEFAULT NULL,
  `fromdomain` varchar(80) DEFAULT NULL,
  `insecure` varchar(4) DEFAULT NULL,
  `language` char(2) DEFAULT NULL,
  `mailbox` varchar(50) DEFAULT NULL,
  `md5secret` varchar(80) DEFAULT NULL,
  `deny` varchar(95) DEFAULT NULL,
  `permit` varchar(95) DEFAULT NULL,
  `mask` varchar(95) DEFAULT NULL,
  `musiconhold` varchar(100) DEFAULT NULL,
  `pickupgroup` varchar(10) DEFAULT NULL,
  `qualify` char(3) DEFAULT NULL,
  `regexten` varchar(80) DEFAULT NULL,
  `restrictcid` char(3) DEFAULT NULL,
  `rtptimeout` char(3) DEFAULT NULL,
  `rtpholdtimeout` char(3) DEFAULT NULL,
  `secret` varchar(80) DEFAULT NULL,
  `setvar` varchar(100) DEFAULT NULL,
  `disallow` varchar(100) DEFAULT 'all',
  `allow` varchar(100) DEFAULT 'g729;ilbc;gsm;ulaw;alaw',
  `fullcontact` varchar(80) NOT NULL DEFAULT '',
  `ipaddr` varchar(15) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `regserver` varchar(100) DEFAULT NULL,
  `regseconds` int(11) NOT NULL DEFAULT '0',
  `lastms` int(11) NOT NULL DEFAULT '0',
  `defaultuser` varchar(80) NOT NULL DEFAULT '',
  `subscribecontext` varchar(80) DEFAULT NULL,
  `callbackextension` varchar(80) DEFAULT NULL,
  `useragent` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `name_2` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sip`
--

LOCK TABLES `sip` WRITE;
/*!40000 ALTER TABLE `sip` DISABLE KEYS */;
INSERT INTO `sip` VALUES
(1,'1000','dynamic','force','friend',NULL,NULL,NULL,NULL,NULL,'yes','yes','default',NULL,NULL,'1000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes',NULL,NULL,NULL,NULL,'123123',NULL,'all','g729,alaw,ulaw',NULL,NULL,NULL,'',NULL,NULL,'1000',NULL,NULL,NULL),
(2,'2000','dynamic','force','friend',NULL,NULL,NULL,NULL,NULL,'yes','yes','default',NULL,NULL,'2000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes',NULL,NULL,NULL,NULL,'123123',NULL,'all','g729;alaw;ulaw',NULL,NULL,NULL,'',NULL,NULL,'2000',NULL,NULL,NULL);
/*!40000 ALTER TABLE `sip` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-09 10:51:42
