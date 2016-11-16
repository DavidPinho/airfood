CREATE DATABASE  IF NOT EXISTS `airfood` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `airfood`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: localhost    Database: airfood
-- ------------------------------------------------------
-- Server version	5.1.58

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
-- Table structure for table `action_history`
--

DROP TABLE IF EXISTS `action_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_history` (
  `idAction` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `idUser` int(11) NOT NULL,
  `when` datetime NOT NULL,
  PRIMARY KEY (`idAction`),
  KEY `fk_action_history_user1_idx` (`idUser`),
  CONSTRAINT `fk_action_history_user1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_history`
--

LOCK TABLES `action_history` WRITE;
/*!40000 ALTER TABLE `action_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(120) NOT NULL,
  PRIMARY KEY (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (38,'Bebidas Alcoolicas'),(39,'abjjffffjkk'),(40,'jjkkj'),(41,'PP'),(42,'abbbbhhhh'),(43,'j'),(44,'kkkkkkkkkkkk'),(45,'assssss'),(46,'a'),(47,'uuuu'),(48,'a'),(49,'a'),(50,'bbb'),(51,'bbb'),(52,'d'),(53,'uuu'),(54,'uuu'),(55,'a'),(56,'a'),(57,'uuuu'),(58,'dhuasdusahuiadsa'),(59,'a'),(60,'bbbbbb'),(61,'trtrt'),(62,'leklek'),(63,'ememe'),(64,'ss'),(65,'alala'),(66,'nhnh'),(67,'ssssssss'),(68,'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk'),(69,'uiuiui'),(70,'qwqwwww'),(71,'wwwwwwww'),(72,'ieieieiw'),(73,'teste'),(74,'ueue'),(75,'kssk'),(76,'0'),(77,'hhhg'),(78,'hhhgv'),(79,'arroz'),(80,'te'),(81,'Teste Atualizado');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `idItem` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `qtd_storage` float NOT NULL,
  `idCategory` int(11) NOT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `images` text,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`idItem`),
  KEY `fk_item_category_idx` (`idCategory`),
  CONSTRAINT `fk_item_category` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (17,'Testee','123',15,123,38,'teste.jpg','none',1),(18,'Novo 1277','Ab',12,12,38,'none','none',0),(19,'Teste 123','aaaaa',12,12,38,'none','none',0),(20,'Brinca','qwawaw',12,12,38,'none','none',0),(21,'Heron Idiota','sasuhshuaua',12,22,38,'5142a5ec53c0b.png','none',0),(22,'lll','dhshsdshuds',22,77,38,'5142a6a98dd08.png','none',1),(23,'sssss','ssss',9,90,40,'5142a6fc7b326.png','none',1),(24,'kir','rrrrr',112,222,39,'none','none',0),(25,'lek leki','2',12,2,40,'5142a9d8d0601.png','none',1),(26,'Heron eh gay','dsdsdss',12,87,40,'none','none',1),(27,'fddfd','sasdsds',2,89,40,'none','none',0),(28,'dhsjhdsjjs','djisdijis',111,111,39,'5142ae5543eb9.png','none',1),(29,'kiro','jss',12,22,38,'none','none',1),(30,'iiiiiiiiiii','s',9,9,39,'none','none',1),(31,'kjh','jjj',3,3,38,'none','none',0),(32,'uuuiiui','kk',12,12,39,'none','none',0),(33,'Ativo','jj',12,33,40,'none','none',1),(34,'Testi','dshds',33,33,40,'none','none',1),(35,'ssshhhh','s',8,7,38,'none','none',0),(36,'t2','w',9,8,38,'none','none',0),(37,'u','s',2,8,38,'none','none',0),(38,'7','7',7,7,39,'none','none',0),(39,'g','gg',6,6,38,'none','none',1),(40,'b','8',8,8,40,'none','none',0),(41,'8888','gg',777,8,38,'none','none',0),(42,'tetttt','gg',2,7,38,'none','none',0),(43,'dhshjsdh','89',89,89,38,'none','none',0),(44,'1234','ee',23,33,40,'none','none',0),(45,'David Pinho','1111',12,222,38,'none','none',1),(46,'Caio','8',8,8,38,'none','none',0);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `idOrder` int(11) NOT NULL AUTO_INCREMENT,
  `idItem` int(11) NOT NULL,
  `order_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `comments` text,
  `idToken` varchar(100) NOT NULL,
  PRIMARY KEY (`idOrder`),
  KEY `fk_order_has_item_item1_idx` (`idItem`),
  KEY `fk_order_item_token1_idx` (`idToken`),
  CONSTRAINT `fk_order_has_item_item1` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_item_token1` FOREIGN KEY (`idToken`) REFERENCES `token` (`idToken`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (1,17,'2013-02-06 20:49:41',0,'','AABCD5'),(2,17,'2013-02-06 20:54:14',0,'','AABCD5'),(3,17,'2013-02-06 20:56:41',0,'','AABCD5'),(4,17,'2013-02-06 22:40:05',1,'','AABCD5'),(5,17,'2013-02-06 22:41:05',1,'','AABCD5'),(6,17,'2013-02-07 00:09:55',1,'','AABCD5'),(7,17,'2013-02-07 00:10:46',1,'','AABCD5'),(8,17,'2013-02-07 00:12:59',1,'','AABCD5'),(9,17,'2013-02-07 00:13:44',1,'','AABCD5'),(10,17,'2013-02-07 00:22:10',1,'','AABCD5'),(11,17,'2013-02-07 00:22:50',1,'','AABCD5'),(12,17,'2013-02-07 00:23:32',1,'','AABCD5'),(13,17,'2013-02-07 00:24:45',1,'','AABCD5'),(14,17,'2013-02-07 00:28:27',1,'','AABCD5'),(15,17,'2013-02-07 19:34:04',1,'','AABCD5'),(16,17,'2013-02-07 19:34:26',1,'','AABCD5'),(17,18,'2013-02-07 19:36:32',1,'','AABCD5'),(18,17,'2013-02-07 19:37:56',1,'Teste','AABCD5'),(19,18,'2013-02-08 00:23:21',1,'Teste no pesquisar','AABCD5'),(20,17,'2013-02-12 12:22:25',1,'','BBCCD4'),(21,20,'2013-02-12 12:23:28',1,'','BBCCD4'),(22,20,'2013-02-12 12:23:28',1,'','BBCCD4'),(23,20,'2013-02-12 12:23:28',1,'','BBCCD4');
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `idToken` varchar(100) NOT NULL,
  `table` varchar(45) NOT NULL,
  `available` tinyint(1) NOT NULL,
  PRIMARY KEY (`idToken`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES ('657TIB','12',0),('AABCD5','12',1),('BBCCD4','14',1),('DH4OCD','2039',1),('GR413P','20',1),('OR2X33','12',1),('UBSH0A','21',1),('XSGJAS','12',1),('XUU48J','22',1);
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_digest`
--

DROP TABLE IF EXISTS `token_digest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token_digest` (
  `token` varchar(6) NOT NULL,
  `hash` varchar(45) NOT NULL,
  `last_order` datetime DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_digest`
--

LOCK TABLES `token_digest` WRITE;
/*!40000 ALTER TABLE `token_digest` DISABLE KEYS */;
INSERT INTO `token_digest` VALUES ('BBCCD4','mAuME96qzLtL1aWbiTO5',NULL);
/*!40000 ALTER TABLE `token_digest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Davidd','David','santoamaro','pinho08@yahoo.com.br',1),(2,'aq','qqqqqq','santoamaro','a',0),(3,'sss','sssssssss','123456','ssssss',0),(5,'admin','admin','123456','admin',1),(6,'aaaa','aaaa','abcdef','aaaa',0),(7,'jucaa','uuuu','abcdef','uuu',0),(8,'Heron eh gay','uuuuu','123456','wwu',0),(9,'lekle','jjjjj','qwerty','jj',0),(10,'q','qqqq','qqqqqq','q',0),(11,'p','pppp','pppppp','p',0),(12,'Herooon','oooo','123456','oo',0),(13,'iu','uiuiuiui','uiuiui','uuiuiui',1),(14,'oo','ooooo','oooooo','ooo',1),(15,'jdskjdsjdk','djskjdksjdj','123456','jdskjskj',0),(16,'dhjshdsjjshs','89898989','898989','89898989',1),(17,'7878','7878878','787878','787878',0),(18,'uiu','uiui','uiuiui','ui',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-14 14:01:48
