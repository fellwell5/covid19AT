-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: corona
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `dead`
--

DROP TABLE IF EXISTS `dead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dead` (
  `timestamp` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `k` int(11) NOT NULL,
  `n` int(11) NOT NULL,
  `o` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `st` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `v` int(11) NOT NULL,
  `w` int(11) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dead`
--

LOCK TABLES `dead` WRITE;
/*!40000 ALTER TABLE `dead` DISABLE KEYS */;
INSERT INTO `dead` VALUES (1584082800,0,0,0,0,0,0,0,0,1),(1584194400,0,0,0,0,0,0,0,0,1),(1584280800,0,0,0,0,0,0,0,0,1),(1584342000,0,0,0,0,0,0,0,0,1),(1584367200,0,0,0,0,0,0,0,0,3),(1584428400,0,0,0,0,0,1,0,0,2),(1584453600,0,0,0,0,0,1,0,0,2),(1584514800,0,0,0,0,0,1,0,0,2);
/*!40000 ALTER TABLE `dead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infected`
--

DROP TABLE IF EXISTS `infected`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infected` (
  `timestamp` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `k` int(11) NOT NULL,
  `n` int(11) NOT NULL,
  `o` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `st` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `v` int(11) NOT NULL,
  `w` int(11) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infected`
--

LOCK TABLES `infected` WRITE;
/*!40000 ALTER TABLE `infected` DISABLE KEYS */;
INSERT INTO `infected` VALUES (1584108000,7,0,63,84,23,52,167,22,82),(1584194400,10,0,82,116,30,71,206,34,101),(1584280800,10,0,111,159,39,111,254,48,122),(1584342000,10,0,150,196,54,111,254,55,122),(1584367200,10,18,152,202,58,139,254,55,128),(1584428400,11,18,165,231,66,145,275,91,130),(1584453600,11,27,216,248,66,171,328,99,166),(1584514800,13,29,237,285,80,188,352,107,180);
/*!40000 ALTER TABLE `infected` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recovered`
--

DROP TABLE IF EXISTS `recovered`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recovered` (
  `timestamp` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `k` int(11) NOT NULL,
  `n` int(11) NOT NULL,
  `o` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `st` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `v` int(11) NOT NULL,
  `w` int(11) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recovered`
--

LOCK TABLES `recovered` WRITE;
/*!40000 ALTER TABLE `recovered` DISABLE KEYS */;
INSERT INTO `recovered` VALUES (1584082800,0,0,1,0,0,0,2,0,3),(1584194400,0,0,1,0,0,0,2,0,3),(1584280800,0,0,1,0,0,0,2,0,3),(1584342000,0,0,1,0,0,0,2,0,3),(1584367200,0,0,1,0,0,0,2,0,3),(1584428400,0,0,1,0,0,0,2,0,5),(1584453600,0,0,2,0,0,0,2,0,5),(1584514800,0,0,2,0,0,0,2,0,5);
/*!40000 ALTER TABLE `recovered` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `total`
--

DROP TABLE IF EXISTS `total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `total` (
  `timestamp` int(11) NOT NULL,
  `tested_persons` int(11) NOT NULL,
  `infected` int(11) NOT NULL,
  `recovered` int(11) NOT NULL,
  `dead` int(11) NOT NULL,
  `currently_sick` int(11) NOT NULL,
  PRIMARY KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `total`
--

LOCK TABLES `total` WRITE;
/*!40000 ALTER TABLE `total` DISABLE KEYS */;
INSERT INTO `total` VALUES (1584108000,6582,504,6,1,497),(1584194400,7467,655,6,1,648),(1584280800,8167,860,6,1,853),(1584342000,8490,959,6,1,952),(1584367200,8490,1016,6,3,1007),(1584428400,10278,1132,8,3,1121),(1584453600,10278,1332,9,3,1320),(1584514800,11977,1471,9,3,1459);
/*!40000 ALTER TABLE `total` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-18 14:00:02
