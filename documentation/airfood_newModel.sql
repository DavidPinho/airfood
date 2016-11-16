-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.25a


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema airfood
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ airfood;
USE airfood;

--
-- Table structure for table `airfood`.`action_history`
--

DROP TABLE IF EXISTS `action_history`;
CREATE TABLE `action_history` (
  `idAction` int(11) NOT NULL,
  `description` varchar(45) NOT NULL,
  `idUser` int(11) NOT NULL,
  `when` datetime NOT NULL,
  PRIMARY KEY (`idAction`),
  KEY `fk_action_history_user1_idx` (`idUser`),
  CONSTRAINT `fk_action_history_user1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`action_history`
--

/*!40000 ALTER TABLE `action_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_history` ENABLE KEYS */;


--
-- Table structure for table `airfood`.`category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `idCategory` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(120) NOT NULL,
  `images` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`category`
--

/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`idCategory`,`description`) VALUES 
 (38,'Bebidas Alcoolicas'),
 (39,'abjjffffjkk'),
 (40,'jjkkj'),
 (41,'PP'),
 (42,'abbbbhhhh'),
 (43,'j'),
 (44,'kkkkkkkkkkkk'),
 (45,'assssss'),
 (46,'a'),
 (47,'uuuu'),
 (48,'a'),
 (49,'a'),
 (50,'bbb'),
 (51,'bbb'),
 (52,'d'),
 (53,'uuu'),
 (54,'uuu'),
 (55,'a'),
 (56,'a'),
 (57,'uuuu'),
 (58,'dhuasdusahuiadsa'),
 (59,'a'),
 (60,'bbbbbb'),
 (61,'trtrt'),
 (62,'leklek'),
 (63,'ememe'),
 (64,'ss'),
 (65,'alala'),
 (66,'nhnh'),
 (67,'ssssssss'),
 (68,'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk'),
 (69,'uiuiui'),
 (70,'qwqwwww'),
 (71,'wwwwwwww'),
 (72,'ieieieiw'),
 (73,'teste'),
 (74,'ueue'),
 (75,'kssk'),
 (76,'0'),
 (77,'hhhg'),
 (78,'hhhgv'),
 (79,'arroz'),
 (80,'te'),
 (81,'Teste Atualizado');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


--
-- Table structure for table `airfood`.`item`
--

DROP TABLE IF EXISTS `item`;
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

--
-- Dumping data for table `airfood`.`item`
--

/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`idItem`,`name`,`description`,`price`,`qtd_storage`,`idCategory`,`icon`,`images`,`active`) VALUES 
 (17,'Testee','123',15,114,38,'teste.jpg','none',1),
 (18,'Novo 1277','Ab',12,11,38,'none','none',0),
 (19,'Teste 123','aaaaa',12,11,38,'none','none',0),
 (20,'Brinca','qwawaw',12,11,38,'none','none',0),
 (21,'Heron Idiota','sasuhshuaua',12,21,38,'5142a5ec53c0b.png','none',0),
 (22,'lll','dhshsdshuds',22,76,38,'5142a6a98dd08.png','none',1),
 (23,'sssss','ssss',9,89,40,'5142a6fc7b326.png','none',1),
 (24,'kir','rrrrr',112,221,39,'none','none',0),
 (25,'lek leki','2',12,0,40,'5142a9d8d0601.png','none',1),
 (26,'Heron eh gay','dsdsdss',12,86,40,'none','none',1),
 (27,'fddfd','sasdsds',2,88,40,'none','none',0),
 (28,'dhsjhdsjjs','djisdijis',111,110,39,'5142ae5543eb9.png','none',1),
 (29,'kiro','jss',12,21,38,'none','none',1),
 (30,'iiiiiiiiiii','s',9,8,39,'none','none',1),
 (31,'kjh','jjj',3,2,38,'none','none',0),
 (32,'uuuiiui','kk',12,11,39,'none','none',0),
 (33,'Ativo','jj',12,32,40,'none','none',1),
 (34,'Testi','dshds',33,32,40,'none','none',1);
INSERT INTO `item` (`idItem`,`name`,`description`,`price`,`qtd_storage`,`idCategory`,`icon`,`images`,`active`) VALUES 
 (35,'ssshhhh','s',8,6,38,'none','none',0),
 (36,'t2','w',9,7,38,'none','none',0),
 (37,'u','s',2,7,38,'none','none',0),
 (38,'7','7',7,6,39,'none','none',0),
 (39,'g','gg',6,5,38,'none','none',1),
 (40,'b','8',8,7,40,'none','none',0),
 (41,'8888','gg',777,7,38,'none','none',0),
 (42,'tetttt','gg',2,6,38,'none','none',0),
 (43,'dhshjsdh','89',89,88,38,'none','none',0),
 (44,'1234','ee',23,32,40,'none','none',0),
 (45,'David Pinho','1111',12,221,38,'none','none',1),
 (46,'Caio','8',8,7,38,'none','none',0);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;


--
-- Table structure for table `airfood`.`order_item`
--

DROP TABLE IF EXISTS `order_item`;
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
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`order_item`
--

/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (1,17,'2013-02-06 20:49:41',0,'','AABCD5'),
 (2,17,'2013-02-06 20:54:14',0,'','AABCD5'),
 (3,17,'2013-02-06 20:56:41',0,'','AABCD5'),
 (4,17,'2013-02-06 22:40:05',1,'','AABCD5'),
 (5,17,'2013-02-06 22:41:05',1,'','AABCD5'),
 (6,17,'2013-02-07 00:09:55',1,'','AABCD5'),
 (7,17,'2013-02-07 00:10:46',1,'','AABCD5'),
 (8,17,'2013-02-07 00:12:59',1,'','AABCD5'),
 (9,17,'2013-02-07 00:13:44',1,'','AABCD5'),
 (10,17,'2013-02-07 00:22:10',1,'','AABCD5'),
 (11,17,'2013-02-07 00:22:50',1,'','AABCD5'),
 (12,17,'2013-02-07 00:23:32',1,'','AABCD5'),
 (13,17,'2013-02-07 00:24:45',1,'','AABCD5'),
 (14,17,'2013-02-07 00:28:27',1,'','AABCD5'),
 (15,17,'2013-02-07 19:34:04',1,'','AABCD5'),
 (16,17,'2013-02-07 19:34:26',1,'','AABCD5'),
 (17,18,'2013-02-07 19:36:32',1,'','AABCD5'),
 (18,17,'2013-02-07 19:37:56',1,'Teste','AABCD5'),
 (19,18,'2013-02-08 00:23:21',1,'Teste no pesquisar','AABCD5'),
 (20,17,'2013-02-12 12:22:25',1,'','BBCCD4'),
 (21,20,'2013-02-12 12:23:28',1,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (22,20,'2013-02-12 12:23:28',1,'','BBCCD4'),
 (23,20,'2013-02-12 12:23:28',1,'','BBCCD4'),
 (24,17,'2013-06-14 04:10:55',0,'','BBCCD4'),
 (25,17,'2013-06-14 04:11:36',0,'','BBCCD4'),
 (26,17,'2013-06-14 04:11:38',0,'','BBCCD4'),
 (27,17,'2013-06-14 04:11:39',0,'','BBCCD4'),
 (28,17,'2013-06-14 04:11:40',0,'','BBCCD4'),
 (29,17,'2013-06-14 04:11:41',0,'','BBCCD4'),
 (30,17,'2013-06-14 04:11:42',0,'','BBCCD4'),
 (31,17,'2013-06-14 04:11:43',0,'','BBCCD4'),
 (32,17,'2013-06-14 04:11:44',0,'','BBCCD4'),
 (33,17,'2013-06-14 04:11:45',0,'','BBCCD4'),
 (34,17,'2013-06-14 04:11:46',0,'','BBCCD4'),
 (35,17,'2013-06-14 04:11:47',0,'','BBCCD4'),
 (36,17,'2013-06-14 04:11:48',0,'','BBCCD4'),
 (37,17,'2013-06-14 04:11:51',0,'','BBCCD4'),
 (38,17,'2013-06-14 04:11:52',0,'','BBCCD4'),
 (39,17,'2013-06-14 04:11:53',0,'','BBCCD4'),
 (40,17,'2013-06-14 04:11:54',0,'','BBCCD4'),
 (41,17,'2013-06-14 04:11:55',0,'','BBCCD4'),
 (42,17,'2013-06-14 04:11:56',0,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (43,17,'2013-06-14 04:11:57',0,'','BBCCD4'),
 (44,17,'2013-06-14 04:11:58',0,'','BBCCD4'),
 (45,17,'2013-06-14 04:11:59',0,'','BBCCD4'),
 (46,17,'2013-06-14 04:12:00',0,'','BBCCD4'),
 (47,17,'2013-06-14 04:12:01',0,'','BBCCD4'),
 (48,17,'2013-06-14 04:12:02',0,'','BBCCD4'),
 (49,17,'2013-06-14 04:12:55',0,'','BBCCD4'),
 (50,17,'2013-06-14 04:12:56',0,'','BBCCD4'),
 (51,17,'2013-06-14 04:12:57',0,'','BBCCD4'),
 (52,17,'2013-06-14 04:12:58',0,'','BBCCD4'),
 (53,17,'2013-06-14 04:12:59',0,'','BBCCD4'),
 (54,17,'2013-06-14 04:13:01',0,'','BBCCD4'),
 (55,17,'2013-06-14 04:13:02',0,'','BBCCD4'),
 (56,17,'2013-06-14 04:13:03',0,'','BBCCD4'),
 (57,17,'2013-06-14 04:13:04',0,'','BBCCD4'),
 (58,17,'2013-06-14 04:13:05',0,'','BBCCD4'),
 (59,17,'2013-06-14 04:13:06',0,'','BBCCD4'),
 (60,17,'2013-06-14 04:13:07',0,'','BBCCD4'),
 (61,17,'2013-06-14 04:13:08',0,'','BBCCD4'),
 (62,17,'2013-06-14 04:13:09',0,'','BBCCD4'),
 (63,17,'2013-06-14 04:13:10',0,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (64,17,'2013-06-14 04:13:11',0,'','BBCCD4'),
 (65,17,'2013-06-14 04:13:12',0,'','BBCCD4'),
 (66,17,'2013-06-14 04:13:13',0,'','BBCCD4'),
 (67,17,'2013-06-14 04:13:14',0,'','BBCCD4'),
 (68,17,'2013-06-14 04:13:16',0,'','BBCCD4'),
 (69,17,'2013-06-14 04:13:17',0,'','BBCCD4'),
 (70,17,'2013-06-14 04:13:18',0,'','BBCCD4'),
 (71,17,'2013-06-14 04:13:19',0,'','BBCCD4'),
 (72,17,'2013-06-14 04:13:20',0,'','BBCCD4'),
 (73,17,'2013-06-14 04:13:21',0,'','BBCCD4'),
 (74,17,'2013-06-14 04:13:22',0,'','BBCCD4'),
 (75,17,'2013-06-14 04:13:25',0,'','BBCCD4'),
 (76,17,'2013-06-14 04:13:26',0,'','BBCCD4'),
 (77,17,'2013-06-14 04:13:27',0,'','BBCCD4'),
 (78,17,'2013-06-14 04:13:28',0,'','BBCCD4'),
 (79,17,'2013-06-14 04:13:30',0,'','BBCCD4'),
 (80,17,'2013-06-14 04:13:31',0,'','BBCCD4'),
 (81,17,'2013-06-14 04:13:32',0,'','BBCCD4'),
 (82,17,'2013-06-14 04:13:33',0,'','BBCCD4'),
 (83,17,'2013-06-14 04:13:34',0,'','BBCCD4'),
 (84,17,'2013-06-14 04:13:35',0,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (85,17,'2013-06-14 04:13:36',0,'','BBCCD4'),
 (86,17,'2013-06-14 04:13:37',0,'','BBCCD4'),
 (87,17,'2013-06-14 04:13:38',0,'','BBCCD4'),
 (88,17,'2013-06-14 04:13:39',0,'','BBCCD4'),
 (89,17,'2013-06-14 04:13:40',0,'','BBCCD4'),
 (90,17,'2013-06-14 04:13:41',0,'','BBCCD4'),
 (91,17,'2013-06-14 04:13:43',0,'','BBCCD4'),
 (92,17,'2013-06-14 04:13:44',0,'','BBCCD4'),
 (93,17,'2013-06-14 04:13:45',0,'','BBCCD4'),
 (94,17,'2013-06-14 04:13:46',0,'','BBCCD4'),
 (95,17,'2013-06-14 04:13:47',0,'','BBCCD4'),
 (96,17,'2013-06-14 04:13:48',0,'','BBCCD4'),
 (97,17,'2013-06-14 04:13:50',0,'','BBCCD4'),
 (98,17,'2013-06-14 04:13:51',0,'','BBCCD4'),
 (99,17,'2013-06-14 04:13:52',0,'','BBCCD4'),
 (100,17,'2013-06-14 04:13:53',0,'','BBCCD4'),
 (101,17,'2013-06-14 04:13:54',0,'','BBCCD4'),
 (102,17,'2013-06-14 04:13:55',0,'','BBCCD4'),
 (103,17,'2013-06-14 04:13:57',0,'','BBCCD4'),
 (104,17,'2013-06-14 04:13:58',0,'','BBCCD4'),
 (105,17,'2013-06-14 04:13:59',0,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (106,17,'2013-06-14 04:14:00',0,'','BBCCD4'),
 (107,17,'2013-06-14 04:14:01',0,'','BBCCD4'),
 (108,17,'2013-06-14 04:14:02',0,'','BBCCD4'),
 (109,17,'2013-06-14 04:14:29',0,'','BBCCD4'),
 (110,17,'2013-06-14 04:15:00',0,'','BBCCD4'),
 (111,17,'2013-06-14 04:15:01',0,'','BBCCD4'),
 (112,17,'2013-06-14 04:15:02',0,'','BBCCD4'),
 (113,17,'2013-06-14 04:15:03',0,'','BBCCD4'),
 (114,17,'2013-06-14 04:15:04',0,'','BBCCD4'),
 (115,17,'2013-06-14 04:15:06',0,'','BBCCD4'),
 (116,17,'2013-06-14 04:15:07',0,'','BBCCD4'),
 (117,17,'2013-06-14 04:15:08',0,'','BBCCD4'),
 (118,17,'2013-06-14 04:15:09',0,'','BBCCD4'),
 (119,17,'2013-06-14 04:15:10',0,'','BBCCD4'),
 (121,17,'2013-06-14 00:53:40',1,NULL,'657TIB'),
 (122,17,'2013-06-14 00:59:09',1,NULL,'657TIB'),
 (123,17,'2013-06-14 00:59:30',1,NULL,'657TIB'),
 (124,17,'2013-06-14 06:02:19',0,'','AABCD5'),
 (125,17,'2013-06-14 06:02:20',0,'','AABCD5'),
 (126,17,'2013-06-14 06:02:21',0,'','AABCD5'),
 (127,25,'2013-06-14 07:42:01',0,'','BBCCD4');
INSERT INTO `order_item` (`idOrder`,`idItem`,`order_time`,`status`,`comments`,`idToken`) VALUES 
 (128,17,'2013-06-14 07:45:46',0,'','BBCCD4'),
 (129,17,'2013-06-14 08:05:55',0,'','BBCCD4'),
 (130,17,'2013-06-14 08:05:57',0,'','BBCCD4');
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;

--
-- Gatilhos `order_item`
--
DROP TRIGGER IF EXISTS `trg_DecreaseQtdItem`;
DELIMITER //
CREATE TRIGGER `trg_DecreaseQtdItem` AFTER INSERT ON `order_item`
 FOR EACH ROW begin
   update item set qtd_storage = qtd_storage - 1 where idItem = new.idItem;
end
//
DELIMITER ;

-- --------------------------------------------------------


--
-- Table structure for table `airfood`.`token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `idToken` varchar(100) NOT NULL,
  `table` varchar(45) NOT NULL,
  `available` tinyint(1) NOT NULL,
  PRIMARY KEY (`idToken`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`token`
--

/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` (`idToken`,`table`,`available`) VALUES 
 ('657TIB','12',0),
 ('AABCD5','12',1),
 ('BBCCD4','14',1),
 ('DH4OCD','2039',1),
 ('GR413P','20',1),
 ('OR2X33','12',1),
 ('UBSH0A','21',1),
 ('XSGJAS','12',1),
 ('XUU48J','22',1);
/*!40000 ALTER TABLE `token` ENABLE KEYS */;


--
-- Table structure for table `airfood`.`token_digest`
--

DROP TABLE IF EXISTS `token_digest`;
CREATE TABLE `token_digest` (
  `token` varchar(6) NOT NULL,
  `hash` varchar(45) NOT NULL,
  `last_order` datetime DEFAULT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`token_digest`
--

/*!40000 ALTER TABLE `token_digest` DISABLE KEYS */;
INSERT INTO `token_digest` (`token`,`hash`,`last_order`) VALUES 
 ('BBCCD4','mAuME96qzLtL1aWbiTO5',NULL);
/*!40000 ALTER TABLE `token_digest` ENABLE KEYS */;


--
-- Table structure for table `airfood`.`user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airfood`.`user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`idUser`,`name`,`username`,`password`,`email`,`admin`) VALUES 
 (1,'Davidd','David','santoamaro','pinho08@yahoo.com.br',1),
 (2,'aq','qqqqqq','santoamaro','a',0),
 (3,'sss','sssssssss','123456','ssssss',0),
 (5,'admin','admin','123456','admin',1),
 (6,'aaaa','aaaa','abcdef','aaaa',0),
 (7,'jucaa','uuuu','abcdef','uuu',0),
 (8,'Heron eh gay','uuuuu','123456','wwu',0),
 (9,'lekle','jjjjj','qwerty','jj',0),
 (10,'q','qqqq','qqqqqq','q',0),
 (11,'p','pppp','pppppp','p',0),
 (12,'Herooon','oooo','123456','oo',0),
 (13,'iu','uiuiuiui','uiuiui','uuiuiui',1),
 (14,'oo','ooooo','oooooo','ooo',1),
 (15,'jdskjdsjdk','djskjdksjdj','123456','jdskjskj',0),
 (16,'dhjshdsjjshs','89898989','898989','89898989',1),
 (17,'7878','7878878','787878','787878',0),
 (18,'uiu','uiui','uiuiui','ui',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
