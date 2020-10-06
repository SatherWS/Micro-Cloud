-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: swoop
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_name` (`cat_name`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment` varchar(150) NOT NULL,
  `user_email` varchar(75) NOT NULL,
  `journal_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`journal_id`),
  KEY `user_email` (`user_email`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journal` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invites`
--

DROP TABLE IF EXISTS `invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(75) DEFAULT NULL,
  `receiver` varchar(75) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `users` (`email`),
  CONSTRAINT `invites_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invites`
--

LOCK TABLES `invites` WRITE;
/*!40000 ALTER TABLE `invites` DISABLE KEYS */;
/*!40000 ALTER TABLE `invites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(45) NOT NULL,
  `message` varchar(10000) NOT NULL,
  `creator` varchar(50) NOT NULL,
  `is_public` varchar(20) NOT NULL DEFAULT 'not_public',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `team_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `journal_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`email`),
  CONSTRAINT `journal_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal`
--

LOCK TABLES `journal` WRITE;
/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
INSERT INTO `journal` VALUES (1,'Best Show','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/177bweUmfnw\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>','asdf@asdf','not_public','2020-08-31 19:53:30',NULL),(2,'Troy and Abed in the Morning','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/177bweUmfnw\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>','asdf@asdf','not_public','2020-08-31 19:54:10','TV Shows'),(3,'Purpose of this website','I guess once this project is completed it will look decent on my resume. If I can build a half decent project management system, I\'ll defiantly be able to use one. I really don\'t want to work on projects only because they look good on my resume. I kind of hate how this site is called a project management application, but I do not know what else to name it as.\r\n\r\nI like my current job, working in tech is defiantly better than food service or shitty big box stores (Costco, Best Buy, so on). \r\n\r\nAs a junior sysadmin I pretty much spend my day solving really minor technical problems. Shit not printing, can\'t log into whatever upgrading/updating computers and software. I still want to be a developer then maybe get into devops since its kind of similar to IT. I mainly I just want to work places where people are nice. Fuck I had some shitty jobs.','asdf@asdf','not_public','2020-08-31 20:46:16','Swoop.Team'),(4,'List of interview questions','- Select joined data from two different tables without repeating data','asdf@asdf','not_public','2020-09-02 23:13:54','SQL Squire'),(5,'Reddit Embed Test','<blockquote class=\"reddit-card\" data-card-created=\"1599153212\"><a href=\"https://www.reddit.com/r/funnyvideos/comments/iltzq5/very/\">Very</a> from <a href=\"http://www.reddit.com/r/funnyvideos\">r/funnyvideos</a></blockquote>\r\n<script async src=\"//embed.redditmedia.com/widgets/platform.js\" charset=\"UTF-8\"></script>','asdf@asdf','not_public','2020-09-03 13:14:18','TV Shows'),(6,'Incentive for Embed Station','So people would have to think to copy and paste the embed link to a video they really enjoy. Their only incentive to do so is to receive meaningless likes.','asdf@asdf','not_public','2020-09-03 18:00:33','TV Shows'),(7,'Not sure if I\'ll pursue this','Because I suck at SQL and everything really','asdf@asdf','not_public','2020-09-03 18:05:32','SQL Squire'),(8,'Fuck Namecheap','Yeah name cheap fucking blows, I hate their authentication system. Why can\'t they just use Google\'s API? Whatever I am also using shit ass hostgator.com (which sucks). I should just suggest Digital Ocean instead. \r\n\r\nI really tried to log in IDK what happened now I\'m logged out for 24 hrs. Oh well.','asdf@asdf','not_public','2020-09-04 01:33:04','Skern Edits'),(9,'Constant Logical Errors','I am constantly making logical errors in this project and I feel down right stupid.  WTF is my problem I need to stop being shitty at this.','asdf@asdf','not_public','2020-09-06 14:51:51','Swoop.Team'),(10,'Yooo my audio video cutter suckss','It should be dumb easy to set a start clip time on a piece of audio. The default should be the end of the file and there should be an easy to see button. Lol actually I\'m just stupid. There are many times I think I have a really good idea for an application but, in reality I simply suck at using the existing software that is out there.\r\n\r\nWell isn\'t that the truth.','asdf@asdf','not_public','2020-09-09 01:16:18','TV Shows'),(12,'Audio clipper not quite right','So the video and audio converter and clipper does not quite work how I want. It exports a clipped copy instead of clipping the original, which is slightly annoying. I should probably learn how to use ffmpeg better in order to solve this issue.','school@stockton.edu','not_public','2020-09-09 23:19:07','Personal Tasks'),(13,'Not sure if post categories are necessary','It may be a way to promote interdisciplinary collaboration between projects.','school@stockton.edu','not_public','2020-09-11 11:29:08','Personal Tasks'),(14,'Selector CLI Using Keyboard Package','pip install keyboard\r\n\r\n<b>Practical Usage</b>\r\nUse for RGB light project.','school@stockton.edu','not_public','2020-09-15 20:29:08','Personal Tasks'),(16,'1959 Alaskan Statehood','Ebay Watch Link\r\n','school@stockton.edu','not_public','2020-09-17 19:22:10','Personal Tasks'),(20,'Stats notes','Boolean math rules from discrete math and several other classes I\'ve taken. \r\n\r\n<img src=\'https://d2vlcm61l7u1fs.cloudfront.net/media%2Fa57%2Fa57a210c-46a6-4c6d-a98f-17fae80c59ad%2FphpdUzmYm.png\'>\r\n\r\n','school@stockton.edu','not_public','2020-09-21 00:31:05','Stockton Homework'),(22,'I hope it\'s you','[VERSE 1]\r\nWhen my whole day is through, if there\'s someone left for me. I hope it\'s you. If your life breaks in two, I\'ll find the pieces and buy the glue.\r\n\r\n[VERSE 2]\r\nWith our time and everything we did makes me smile because it happened. If I was your rock, you\'d be my sea just don\'t erode, erode me.\r\n\r\n[PRE CHORUS]\r\nEventually there will be only memories and I\'ll take all I can get. I just hope I never forget.\r\n\r\n[CHORUS]\r\nSo I hope it\'s you. I hope it\'s you at the end of our rendezvous. ','school@stockton.edu','not_public','2020-09-28 17:26:01','Personal Tasks'),(23,'I need to move the categories','WTF was I thinking putting categories in with posts. Projects/teams should belong to a category I guess idk really who cares. I need to sleep.','school@stockton.edu','not_public','2020-10-02 03:00:59','Personal Tasks'),(24,'Cool Blues Piano  Tutorial','<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/CjJwxtahGtw\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>','school@stockton.edu','not_public','2020-10-04 18:42:48','Personal Tasks');
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(75) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  `join_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `members_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`),
  CONSTRAINT `members_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'asdf@asdf','TV Shows','2020-08-31 19:53:47'),(2,'asdf@asdf','Swoop.Team','2020-08-31 20:35:09'),(3,'asdf@asdf','SyllaSource','2020-09-01 15:39:07'),(4,'asdf@asdf','Skern Edits','2020-09-01 23:51:05'),(5,'asdf@asdf','SQL Squire','2020-09-02 23:12:58'),(8,'school@stockton.edu','Stockton Homework','2020-09-09 13:43:13'),(9,'school@stockton.edu','Personal Tasks','2020-09-09 21:57:41'),(11,'school@stockton.edu','ARA','2020-09-26 17:35:34');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_tasks`
--

DROP TABLE IF EXISTS `sub_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `descript` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Not Started',
  `deadline` date NOT NULL,
  `task_repeat` varchar(10) DEFAULT NULL,
  `importance` varchar(10) NOT NULL,
  `assignee` varchar(50) DEFAULT NULL,
  `creator` varchar(50) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `task_id` int NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `sub_tasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `todo_list` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_tasks`
--

LOCK TABLES `sub_tasks` WRITE;
/*!40000 ALTER TABLE `sub_tasks` DISABLE KEYS */;
INSERT INTO `sub_tasks` VALUES (2,'Include assignee selector','Right now you can only select none as an assignee','Not Started','2020-09-07',NULL,'High','','asdf@asdf',NULL,9,'2020-09-06 14:20:17'),(3,'Add delete sub task feature','Also delete all sub tasks when main task is deleted.','Not Started','2020-09-10',NULL,'Medium','','asdf@asdf',NULL,9,'2020-09-06 14:27:15'),(15,'Buy a good book','Make sure its the right dimensions','Not Started','2020-09-28',NULL,'Medium','school@stockton.edu','school@stockton.edu',NULL,20,'2020-09-14 09:22:35'),(18,'Attempt Problem 3','Do during Wei\'s class','Not Started','2020-09-25',NULL,'High','school@stockton.edu','school@stockton.edu',NULL,19,'2020-09-21 23:25:07');
/*!40000 ALTER TABLE `sub_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(50) NOT NULL,
  `admin` varchar(75) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `rating` int DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_name` (`team_name`),
  KEY `admin` (`admin`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `users` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'TV Shows','asdf@asdf','2020-08-31 19:53:47',10,NULL),(2,'Swoop.Team','asdf@asdf','2020-08-31 20:35:09',-2,NULL),(3,'SyllaSource','asdf@asdf','2020-09-01 15:39:07',-1,NULL),(4,'Skern Edits','asdf@asdf','2020-09-01 23:51:05',-1,NULL),(5,'SQL Squire','asdf@asdf','2020-09-02 23:12:58',-1,NULL),(8,'Stockton Homework','school@stockton.edu','2020-09-09 13:43:13',-2,NULL),(9,'Personal Tasks','school@stockton.edu','2020-09-09 21:57:41',-1,NULL),(11,'ARA','school@stockton.edu','2020-09-26 17:35:34',0,NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo_list`
--

DROP TABLE IF EXISTS `todo_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `todo_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(75) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Not Started',
  `deadline` date NOT NULL,
  `task_repeat` varchar(10) DEFAULT NULL,
  `importance` varchar(10) NOT NULL,
  `assignee` varchar(50) DEFAULT 'None',
  `creator` varchar(50) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `date_created` date DEFAULT (curdate()),
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `todo_list_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`email`),
  CONSTRAINT `todo_list_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

LOCK TABLES `todo_list` WRITE;
/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
INSERT INTO `todo_list` VALUES (1,'Implement Sub Tasks','Side note allow more chars in this field.','COMPLETED','2020-09-01',NULL,'Medium','asdf@asdf','asdf@asdf','Swoop.Team','2020-08-31'),(2,'Fix Table Labels','','COMPLETED','2020-09-01',NULL,'High','asdf@asdf','asdf@asdf','Swoop.Team','2020-08-31'),(3,'Change code highlighting','','COMPLETED','2020-09-02',NULL,'Medium','asdf@asdf','asdf@asdf','SyllaSource','2020-09-01'),(4,'Deploy to firebase','You will need to modify deploy.sh only upload output dir','COMPLETED','2020-09-02',NULL,'High','asdf@asdf','asdf@asdf','SyllaSource','2020-09-01'),(5,'Change redirect on project select','Keep user on the same page','COMPLETED','2020-09-02',NULL,'High','asdf@asdf','asdf@asdf','Swoop.Team','2020-09-01'),(6,'Plan yt embed project','Basically the site allows users to post embeded urls for videos.','IN PROGRESS','2020-09-06',NULL,'Low','','asdf@asdf','TV Shows','2020-09-01'),(7,'Send email to Steve','Send Hostgator creds, link to new firebase site with mobirise editor.','IN PROGRESS','2020-09-03',NULL,'High','asdf@asdf','asdf@asdf','Skern Edits','2020-09-01'),(9,'Work on sub task feature','Allow sub task editing\r\n\r\nChange assignee and creator repeats.','COMPLETED','2020-09-05',NULL,'Medium','asdf@asdf','asdf@asdf','Swoop.Team','2020-09-02'),(10,'Link Github, Reddit, Twitter(possibly)','Do not use your real name for these accounts','Not Started','2020-09-10',NULL,'Low','asdf@asdf','asdf@asdf','SyllaSource','2020-09-03'),(14,'Fix subtask bug in README','annoyingly repeats the main task if two subtasks exist','COMPLETED','2020-09-04',NULL,'High','asdf@asdf','asdf@asdf','Swoop.Team','2020-09-03'),(18,'Stats HW 1','Due at 8:30am','COMPLETED','2020-09-14',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-09'),(19,'DSA Problem Set 1','Due at midnight','COMPLETED','2020-09-25',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-09'),(20,'Buy USB Docking Station','It would really make life a little easier, plus can use external monitor.','COMPLETED','2020-09-10',NULL,'Medium','school@stockton.edu','school@stockton.edu','Personal Tasks','2020-09-09'),(22,'Hide sidebar when screen is at 50%','This task is for this website','IN PROGRESS','2020-09-23',NULL,'Low','school@stockton.edu','school@stockton.edu','Personal Tasks','2020-09-10'),(23,'Lab1 Data Science','Almost done','COMPLETED','2020-09-24',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-17'),(24,'Stats HW2','Due at 8:30am','COMPLETED','2020-09-21',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-17'),(28,'Stats HW 3','It would be cool to insert link here.','COMPLETED','2020-09-30',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-23'),(29,'Access VSTS','Keep getting a forbidden error ','IN PROGRESS','2020-10-02',NULL,'Medium','school@stockton.edu','school@stockton.edu','ARA','2020-09-26'),(30,'Update Gold Image Spreadsheet','This task is pretty important','COMPLETED','2020-09-28',NULL,'High','school@stockton.edu','school@stockton.edu','ARA','2020-09-26'),(31,'Biology Lab 1 Take Home Questions','Due at 11:59pm','COMPLETED','2020-09-28',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-27'),(32,'DSA Programming 1','Due at 11:59pm','COMPLETED','2020-10-02',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-27'),(33,'Submit travel and expense reports','Needs to be done by the end of the month but, is recommended to complete as soon as possible.','Not Started','2020-09-28',NULL,'High','school@stockton.edu','school@stockton.edu','ARA','2020-09-30'),(34,'Data Mining HW 1','Due at 11:59pm','Not Started','2020-10-08',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-29'),(35,'Make sure Harold has equipment','','Not Started','2020-09-30',NULL,'High','school@stockton.edu','school@stockton.edu','ARA','2020-09-29'),(36,'DSA Problem Set 2','Due at 11:59pm','COMPLETED','2020-10-05',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-29'),(37,'<b>DSA Exam 1 Reminder</b>','Can be taken on the 21st or 22nd, there is a strict 3 hour time limit.','IN PROGRESS','2020-10-21',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-09-29'),(39,'Restore computer end table','Need to buy paint stripper/thinner. Then sand/varnish.','IN PROGRESS','2020-10-16',NULL,'Medium','school@stockton.edu','school@stockton.edu','Personal Tasks','2020-10-02'),(40,'Stats HW 4','Due at 8:30am','Not Started','2020-10-09',NULL,'Medium','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-10-02'),(41,'<b>Stats Mid-Term Exam Reminder</b>','Will be worth 30% of final grade','IN PROGRESS','2020-10-30',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-10-04'),(42,'DSA Programming 2','Due at 11:59pm','Not Started','2020-10-19',NULL,'Medium','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-10-04'),(43,'Fucking dumb ass bio thing','due nowwww =¤ (▀̿̿ĺ̯̿̿▀̿ ̿)','COMPLETED','2020-10-05',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-10-05'),(44,'Data Mining Quiz','Be sure to create a study sheet','Not Started','2020-10-08',NULL,'High','school@stockton.edu','school@stockton.edu','Stockton Homework','2020-10-06');
/*!40000 ALTER TABLE `todo_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(75) NOT NULL,
  `username` varchar(75) NOT NULL,
  `pswd` varchar(300) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'asdf@asdf','asdf','$2y$10$v45vNr8EZP68cYARQVne5.TG.l3vEqiO7MRLk7DCWF5SgkpBCoVEK','2020-08-31 19:47:53'),(2,'school@stockton.edu','csather','$2y$10$qbBkOrkeq6SLZ5bOLIaJBein.qcTpc5IYpW3Nhqp63mGvew3LQ7jG','2020-09-09 13:36:48');
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

-- Dump completed on 2020-10-06 10:07:53
