-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: test_forum
-- ------------------------------------------------------
-- Server version	5.6.19-1~exp1ubuntu2

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `qid` int(12) unsigned NOT NULL DEFAULT '0',
  `uid` int(12) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `answered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rank` mediumint(6) DEFAULT '0',
  PRIMARY KEY (`qid`,`uid`,`answered`),
  KEY `uid` (`uid`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`) ON DELETE CASCADE,
  CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,3,'<p>C pointer are variables that can hold address.</p>\r\n\r\n<p>Pointers are used to hold address of other variables.</p>\r\n\r\n<p>By using pointer we can manipulate value in addresses directly which is dangerous but if used cleverly can be powerfull.</p>\r\n','2014-12-07 16:08:12',3),(1,4,'<p>Pointers can hold addresses. You can also do pointer arithmetic like adding or subtracting values from pointers. But this arithmetic will follow the type of variable the pointer is pointing to, means if it points to character then it will add with 1 if you increment it. But if it points to a float then it will add 4 if you try to increment it. By doing this kind of arithmetic you can actually do some cool stuff. For example you can use pointer to point to an array, then you can use pointer arithmetic to access the array indices which is considered fast compared to normal array indexing. You can do it like this ....</p>\r\n\r\n<div style=\"background:#eee;border:1px solid #ccc;padding:5px 10px;\">arr[4] = 30;</div>\r\n\r\n<p>&nbsp;you can write it with pointer arithmetic like this</p>\r\n\r\n<div style=\"background:#eee;border:1px solid #ccc;padding:5px 10px;\">*(arr+4) = 30;</div>\r\n','2014-12-08 14:17:20',6);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers_voted`
--

DROP TABLE IF EXISTS `answers_voted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers_voted` (
  `qid` int(12) unsigned NOT NULL DEFAULT '0',
  `uid` int(12) unsigned NOT NULL DEFAULT '0',
  `answered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vote_usr_id` int(12) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`,`uid`,`answered`,`vote_usr_id`),
  KEY `uid` (`uid`),
  KEY `vote_usr_id` (`vote_usr_id`),
  CONSTRAINT `answers_voted_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`) ON DELETE CASCADE,
  CONSTRAINT `answers_voted_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `answers_voted_ibfk_3` FOREIGN KEY (`vote_usr_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers_voted`
--

LOCK TABLES `answers_voted` WRITE;
/*!40000 ALTER TABLE `answers_voted` DISABLE KEYS */;
INSERT INTO `answers_voted` VALUES (1,3,'2014-12-07 16:08:12',8),(1,3,'2014-12-07 16:08:12',9),(1,4,'2014-12-08 14:17:20',3),(1,4,'2014-12-08 14:17:20',8),(1,4,'2014-12-08 14:17:20',9);
/*!40000 ALTER TABLE `answers_voted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `qid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `content` text,
  `uid` int(12) unsigned DEFAULT NULL,
  `asked` datetime DEFAULT NULL,
  `rank` mediumint(6) DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `uid` (`uid`),
  FULLTEXT KEY `title` (`title`,`content`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'C pointers','<p>I am new to programming languages.</p>\r\n\r\n<p>I want to ask about pointer in C languages.</p>\r\n\r\n<p>What are they and why are they used?</p>',3,'2014-12-07 14:37:54',7),(2,'Tell me about jQuery','<p>I am new in the field of web developing. I know about javascript. But recently heard about jQuery. I heard thar it is like javascript.</p>\r\n\r\n<p>Can any of you help me to understand what is it?</p>\r\n\r\n<p>And ALSO tell me how to use it.</p>\r\n\r\n<p>thanks in advanced...</p>\r\n',3,'2015-04-26 15:04:50',1),(3,'Testing for a long title which will probably be a long line and it will show how title\'s will be laid out in the front page','<p>Also trying to test how this answer part will be laid out if it is a long line. This will also show how things will be in the front page. I hope everything will be OK.</p>\r\n',3,'2015-04-29 11:20:45',1),(4,'Testing for question ask updation','<p>Previous question asking attempt was successful but the number of questions asked didn&#39;t updated.</p>\r\n',8,'2015-04-29 11:32:12',0),(5,'testing asking','<p>testing for q_asked</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:37:40',0),(6,'testing asking 2','<p>testing for q_asked 2</p>\r\n',8,'2015-04-29 11:38:31',0),(7,'testing asking 3','<p>testing asking 3</p>\r\n',8,'2015-04-29 11:43:58',0),(8,'testing asking 3','<p>testing asking 3</p>\r\n',8,'2015-04-29 11:44:55',0),(9,'testing asking 3','<p>testing asking 3</p>\r\n',8,'2015-04-29 11:49:47',0),(10,'testing asking 3','<p>testing asking 3</p>\r\n',8,'2015-04-29 11:51:21',0),(11,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:52:07',0),(12,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:53:54',0),(13,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:55:53',0),(14,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:56:39',0),(15,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:57:00',0),(16,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:57:27',0),(17,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 11:58:50',0),(18,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 12:00:20',0),(19,'testing asking 4','<p>testing asking 4</p>\r\n\r\n<p>&nbsp;</p>\r\n',8,'2015-04-29 12:01:39',0),(21,'xss atack','<p>&lt;script&gt;alert(&quot;hello&quot;);&lt;/script&gt;</p>\r\n',8,'2015-05-16 14:39:16',1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_voted`
--

DROP TABLE IF EXISTS `questions_voted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_voted` (
  `uid` int(12) unsigned NOT NULL DEFAULT '0',
  `qid` int(12) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`qid`),
  KEY `qid` (`qid`),
  CONSTRAINT `questions_voted_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `questions_voted_ibfk_2` FOREIGN KEY (`qid`) REFERENCES `questions` (`qid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_voted`
--

LOCK TABLES `questions_voted` WRITE;
/*!40000 ALTER TABLE `questions_voted` DISABLE KEYS */;
INSERT INTO `questions_voted` VALUES (8,1),(8,2),(8,3),(3,21);
/*!40000 ALTER TABLE `questions_voted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `joined` date NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `q_asked` int(10) unsigned NOT NULL DEFAULT '0',
  `q_answered` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'mushiar','mushiarkhan@gmail.com','$2y$10$OGEyYmZkMjhhODcxYzA1ZehRfbNQDq6RPcdbA3bKE.UXikpIY8oUu','2014-12-06',1,1,1,1),(4,'bob','mushiarkhan93@gmail.com','$2y$10$Y2Y0YjMwYjBkNWE5ODg5Nuwm183Pil3gjPSUT/3OLuoB.gE5L0pNC','2014-12-08',0,0,0,0),(7,'babai','mushiarkhan@hotmail.com','$2y$10$ZTcyMDZkZDIyYjYyN2ZiMu9.p6brciAQWWMHlBD3UoAdYRKkav2s.','2015-04-21',0,0,0,0),(8,'test_user','mushi@gmail.com','$2y$10$NzU4NmI1ODhkYjVkYTk2MukPO1UR7s7ODkIKcY5.9U.fBLqiuZtc.','2015-04-21',1,0,11,3),(9,'armaan','armaan@gmail.com','$2y$10$NTZlNmQ5YTcyOWZmYWQ1MeDoiqC2Udh7erymGJEVh.03swYzjrIXG','2015-05-15',0,0,0,0),(10,'bob\'); --','mushik@gmail.com','$2y$10$NjQxYTgwMzNhM2RlMDEyM.cII2zc1t6GGjAOdb0YEF/CEf0y6yBfK','2015-05-18',0,0,0,0);
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

-- Dump completed on 2015-06-04 17:30:43
