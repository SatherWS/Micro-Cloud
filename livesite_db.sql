-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: swoop_team
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
-- Table structure for table `invites`
--

DROP TABLE IF EXISTS `invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(75) NOT NULL,
  `receiver` varchar(75) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`email`),
  CONSTRAINT `invites_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `users` (`email`),
  CONSTRAINT `invites_ibfk_3` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invites`
--

LOCK TABLES `invites` WRITE;
/*!40000 ALTER TABLE `invites` DISABLE KEYS */;
INSERT INTO `invites` VALUES (1,'test@test.com','sather4509@gmail.com','Test Team 1','pending','2020-08-16 22:53:23'),(3,'test@test.com','Rusty.sather@gmail.com','Test Team 1','pending','2020-08-23 02:06:24');
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
  `category` varchar(45) NOT NULL,
  `creator` varchar(50) NOT NULL,
  `is_private` varchar(20) NOT NULL DEFAULT 'private',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `team_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creator` (`creator`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `journal_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`email`),
  CONSTRAINT `journal_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal`
--

LOCK TABLES `journal` WRITE;
/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
INSERT INTO `journal` VALUES (3,'Purpose','To be frank I really think I might be an idiot. This website will never make me money. Could be too soon to tell, I think version 2.2 will be better. After 2.2 I may start working on SQL Squire (sqlsquire.com). Its a mailing list that sends you SQL problems and solutions to help people learn database technologies.\r\n\r\nSeams like a pretty good idea and easier to monetize, I don\'t think I should use PHP again, because the language is in decline in the job market. I am thinking of using Javascript, Java or C#.','Personal','test@test.com','private','2020-08-18 06:06:06','Test team 1'),(4,'Something','something else','T-mobile ','rusty.sather@gmail.com','private','2020-08-23 02:09:42','Rusty'),(5,'Life can be torture ','Not sure why I bother with these dumb projects. No one is ever going to use a website this dumb. There is so much work to do I still can’t figure out the stupid invite options.\r\n\r\nWhen a user joins a team an invite is sent to the admin. Members of a team are able to invite whoever. I need to separate the invites sent to the admin from the ones sent by standard users.\r\n\r\nMaybe only allow admins to accept or deny users. ','Personal','test@test.com','private','2020-08-24 20:11:47','Test Team 1'),(6,'Sylla Source soon launching','The blog is launching soon I am going to try to release it over the weekend. It may screw up my life but, I need a creative outlet.','Personal','test@test.com','private','2020-08-27 05:44:37','Test Team 1'),(7,'Ideas for Today','So today I worked on setting up Docker for version 2 of this website. I am not sure if version 2 is correct maybe I should call is version 1.2 instead. It is worth noting the database is not backwards compatible, which is why I named it version 2.0 originally.\r\n\r\nAlso I believe creating a IOT Kombucha monitor would be a good idea, first you need to really try some Kombucha. Fucking hell.','Personal','test@test.com','private','2020-08-28 02:43:26','Test Team 1'),(8,'Making Music','<a href=‘https://youtu.be/1uvbvRLtAZQ’>Good musician with cool tools</a>','Projects','test@test.com','private','2020-08-29 23:29:44','Test Team 1'),(9,'Reddit audio measurements','How to determine the true quality of an audio file\r\n\r\nHere is a guide that will enable you to determine the true quality of an audio file. Many times you may receive an audio file which boasts being a 320 or a lossless but just doesn’t sound right - this will show you how to know for sure if it\'s a legitimate file or not.\r\n\r\n&nbsp;\r\n\r\n____\r\n#### **Using Spek to view the files spectrogram** ##\r\n[Spek](http://spek.cc/) is a simple, compact program that is used to display a visual spectrogram of an audio file. Simply drag and drop the file from your computer’s file browser into the program and it will generate a [frequency graph](http://i.imgur.com/942bNbm.png) of the audio file, indicating which parts of the audio codec’s frequency range are being used, and at which time.\r\n\r\nIf you want to determine the true audio quality in a digital file, you must first understand **‘sample rate.’** To put it simply, the sample rate refers to the number of times a slice of sound is captured per second, meaning a higher sample rate translates to higher fidelity file. Another separate factor of which audio fidelity is measured by is **bitrate**, simply explained as the number of bits which are being processed in a signal over a specified period of time. The standard unit for bitrate is kilobytes per second, or \'kbps\'.\r\n\r\n___\r\n\r\n#### **Lossless & Lossy files** ##\r\n\r\nMost common types of digital audio available currently use some form of audio compression to lower the overall size of the audio file while conserving most of the information. There are 2 divided types of audio format:\r\n\r\n\r\n#####~  \'Lossless\' & Uncompressed files ~\r\n\r\nThese audio files have no digital compression, therefore they often have a large file size [~30mb-100mb on average]. Lossless files have a frequency range that will peak at 22kHz or higher, and are typically encoded at bitrates of above 1000kbps. \r\n\r\nLossless file types include: .wav .aiff .flac .au .alac .ogg (etc)\r\n\r\n\r\n#####~ \'Lossy\' (AKA compressed) audio files ~\r\nThis type of audio format is of a smaller size when compared to uncompressed audio [~6mb-15mb on average]. Lossy files have a frequency range that peaks at 24kHz or lower and are encoded at different rates depending on the format/quality, however the maximum bitrate for lossy files is typically capped at 320kbps. There are two types of bitrate when it comes to lossy encoding - CBR and VBR. Rather eponymous, they stand for constant bitrate and variable bitrate.\r\n\r\nLossy file types include: .mp3 .acc .m4a (etc)\r\n\r\n___\r\n\r\n#### **Reading a spectrogram via frequency shelving** ##\r\n\r\n\r\nThe first and most critical thing you should look for in the spectrogram is the \'frequency shelving.’ This is simply just the maximum frequency that the spectrogram cuts off at, hence it being referred to as the frequency \'shelf\' of the file. When a visual spectrogram of an audio stream has a high range of frequencies, this indicates better audio fidelity. When analysing these peaks, you should notice that there will be a consistent peak frequency that has an obvious cutoff point at a certain rating.\r\n\r\nBelow is an example of a lossless file that has been transcoded down to specific lossy bitrates in order to clearly present the shelving limits in relation to the quality:\r\n\r\n**1141kbps - [[22kHz+]](http://i.imgur.com/vps3eOm.jpg)** (lossless encoding)\r\n\r\n**320kbps - [[24-20kHz]](http://i.imgur.com/Zx4MhNL.jpg)** (standard MP3) \r\n\r\n**256kbps - [[22-19kHz]](http://i.imgur.com/J0QEjeM.png)**\r\n\r\n**192kbps - [[19kHz]](http://i.imgur.com/uqLZOw8.jpg)**\r\n\r\n**128kbps - [[16kHz]](http://i.imgur.com/nDGVOCp.png)** (standard internet audio stream)\r\n\r\n**64kbps - [[11kHz]](http://i.imgur.com/LV3QQQq.png)**\r\n\r\nThe range of these shelving limits are a rough guide and may differ slightly depending on the codec & encoding method. Any file that peaks around 19-20kHz or higher is generally considered to be a \'high-quality file\', however 256/320\'s usually indicate a higher quality “original” studio export of a track.\r\n\r\n___\r\n\r\n#### **Spotting Fakes** ##\r\n\r\nSadly, many people try to deceive others by re-encoding low quality files in a different format in order to trick the person into thinking it\'s a real studio file.\r\n\r\nThere are a few methods to faking an audio file, but here are the most common ones to look for:\r\n\r\n\r\n#####1) Transcoding \r\n\r\nPeople will often try and trick people into thinking a low quality 128kbps file is a real 320 by re-encoding the 128 at a higher bitrate. This does not improve the quality of the file. This is easy to spot as the frequency shelf will cut off at a low range (15kHz area) and will usually have nothing except occasionally trailing lines above that shelf. [Here is an example of a transcode](http://i.imgur.com/buhpygu.png).\r\n\r\nYou might also run into a 128 that appears to have some purple, transient frequencies above the shelf. This is another easy indicator of a transcoded file. [Here is an example of those purple strings](http://i.imgur.com/LTOw0Zx.png).\r\n\r\nLossless transcodes are easily identifiable by the fact that they will peak at a lower shelf than 22kHz - no properly encoded studio lossless file will go below this. Occasionally, 320 mp3 or 256 acc will be re-encoded at a higher bitrate and look very close to a proper lossless file, but again they will almost always shelf before 22kHz, and be audibly distinguishable from a legitimate copy.\r\n\r\n\r\n#####2) Track edits\r\n\r\nIt\'s common for people to create edits of songs using multiple set rips and/or live rips combined together to form a full track. This is usually easily spotted as the frequency shelf will be constantly shifting up and down between the different quality audio. Track edits also have an unusual looking colour palette compared to a regular studio export and may even have incorrect channel (left and right) balances, switch to mono instead of stereo or have massive gain differences. [Here is an example of a file sliced together from multiple rips](http://i.imgur.com/hp6eEGZ.png). The fluctuations in shelving and/or colour usually gives it right away.\r\n\r\n#####3) Extending the frequency shelf\r\n\r\nMany people attempt to extend the frequency shelf of a low quality file in order to re-encode it in a higher bitrate & have it appear that all of the audio range is being used when in reality, it isn\'t. Usually this will be obvious, as you will be able to clearly see an extended shelf that overlaps with the original one. [Here is an example of an extended frequency shelf](http://i.imgur.com/8Efm2U0.png). You can can clearly make out the shelf at around 16kHz - everything else above it is just interpolated from the low quality file.\r\n\r\nThis is done in a variety of ways, but most people achieve this effect by using a harmonic exciter of some sort (available in most professional DAW’s); by adding noise to the track; or by layering an interpolated frequency pattern over the low quality track. Finally, you can also achieve this by actually producing and layering new sounds/drums over the low quality file.\r\n\r\nSome extended shelves are easy to spot, while others aren\'t. For example, [this fake version of the Jack U Febreeze Demo](http://i.imgur.com/L0Vr4AE.png) is encoded in lossless format and looks somewhat convincing, however upon loading the file up in a DAW and phase inverting it, it becomes fairly evident that all of the higher frequencies are simply pitch boosted versions of the frequencies below.\r\n\r\n___\r\n','Projects','test@test.com','private','2020-09-06 22:52:33','Test Team 1'),(10,'Pi Sound Modep','Look into this rpi mod ','Projects','test@test.com','private','2020-09-07 05:27:51','Test Team 1'),(11,'Dummy','Big stupid idiot waste of life why can\'t you stop being so fucking stupid. \r\n\r\nRe: Understanding how to connect an LED Strip to Raspberry PI 3\r\n\r\nIdeally you\'d use a separate power supply for the strip.\r\n\r\nConnect 0V/Ground (white wire) from the strip to a ground pin on the Pi and the Ground or 0V output of the power supply.\r\n\r\nConnect 5V (red wire) from the strip to the 5V output of the power supply.\r\n\r\nConnect the Data (green wire) from the strip to the GPIO pin on the Pi that you are using to control the strip. I usually use Pin 12 (GPIO 18) with the PWM driver.','Personal','test@test.com','private','2020-09-19 23:44:11','Test Team 1'),(12,'WTF is Wrong with Me?','Feeling down, I keep thinking about Sofia despite the fact we have been split up <b>twice as long as we\'ve been together.</b> I wish I could move on with or without her. I sent her this dumb meme \r\n\r\n<img width=\'500\' style=\'text-align:center\' src=\'https://external-preview.redd.it/0n9ULiYeEpl7M3aQxjH_r4gK8Emb9_vz45M19ACO5Js.jpg?auto=webp&s=c42532d391c6ff15beb284443a17fa2ccabcf85f\'> \r\n\r\nShe didn\'t respond or like it IDK why I fucking sent it to her in the first place. She defiantly thinks I am a loser and she\'s right. Here I am sitting in my office like an idiot because I cannot focus on the simplest little tasks.','Personal','test@test.com','private','2020-10-05 16:53:52','Test Team 1'),(13,'1st Sylla Source Video','I want to do an introduction video about who I am, what I\'ve done etc. I would start with who I was in high school a kid voted most likely not to succeed then moving on to get an associate degree in business and a bachelor\'s degree in computer science. Now I work in the tech field doing programming and system administration. \r\n\r\n1. Under achieving high school student who went on to work in a crappy restaurant.\r\n\r\n2. ','YouTube Videos','test@test.com','private','2020-10-05 19:51:05','Test Team 1'),(14,'Songs to download','<b>List of songs to rip off YouTube</b>\r\nOne of these days I\'ll buy these songs, just not yet.','Music','test@test.com','private','2020-10-14 17:24:35','Test Team 1');
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;
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
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_name` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Test Team 1','2020-08-14 16:42:30'),(4,'Niles','2020-08-15 00:57:11'),(6,'Rusty','2020-08-23 00:35:48'),(7,'Gyasz','2020-09-18 22:07:39');
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
  `title` varchar(45) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Not Started',
  `deadline` date NOT NULL,
  `task_repeat` varchar(10) DEFAULT NULL,
  `importance` varchar(10) NOT NULL,
  `assignee` varchar(50) DEFAULT NULL,
  `creator` varchar(50) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `assignee` (`assignee`),
  KEY `creator` (`creator`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `todo_list_ibfk_1` FOREIGN KEY (`assignee`) REFERENCES `users` (`email`),
  CONSTRAINT `todo_list_ibfk_2` FOREIGN KEY (`creator`) REFERENCES `users` (`email`),
  CONSTRAINT `todo_list_ibfk_3` FOREIGN KEY (`team_name`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

LOCK TABLES `todo_list` WRITE;
/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
INSERT INTO `todo_list` VALUES (4,'test 2','asdf','DISTRACTED','2020-08-21',NULL,'none','sather4509@gmail.com','sather4509@gmail.com','Niles','2020-08-15 01:31:50'),(5,'Add more options to post form','Add an insert button that can add...\r\n1. embeded urls\r\n2. pictures from urls\r\n3. possibly videos','IN PROGRESS','2020-08-22',NULL,'none','test@test.com','test@test.com','Test Team 1','2020-08-15 20:12:33'),(6,'Improve the security of this app','Check for xxs and sql injection. Also keep in mind access restrictions.','DISTRACTED','2020-08-22',NULL,'none','test@test.com','test@test.com','Test Team 1','2020-08-15 20:14:34'),(7,'Add a calendar or some other analytics','And/or add line graph of completed task counts.','Not Started','2020-08-22',NULL,'none','test@test.com','test@test.com','Test Team 1','2020-08-15 20:15:31'),(10,'Feature: Add sub-tasks','','COMPLETED','2020-08-31',NULL,'none','test@test.com','test@test.com','Test Team 1','2020-08-15 21:30:43'),(11,'Mobile responsive issues ','-Mobile responsive table labels\r\n-Task and journal options\r\n','COMPLETED','2020-08-20',NULL,'none','test@test.com','test@test.com','Test Team 1','2020-08-17 00:19:50'),(13,'drink booze','','COMPLETED','2020-08-23',NULL,'none','rusty.sather@gmail.com','rusty.sather@gmail.com','Rusty','2020-08-23 02:10:37'),(14,'sdfgsdfg','','Not Started','2020-09-27',NULL,'High','kyodaina@gmail.com','kyodaina@gmail.com','Gyasz','2020-09-18 22:08:37');
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
  `team` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `team` (`team`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`team`) REFERENCES `teams` (`team_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'test@test.com','someuser','$2y$10$NvZTbHoDRbGoEqk6RGCISuPQtr563lS1DOJ1mjb7qedxGLr4KXXkK','Test Team 1','2020-08-14 16:42:30'),(7,'sather4509@gmail.com','Brained Jackal','$2y$10$Yhzx7Qr2GUrsDt1UlDpYy.jQbC0jQDnSOVRCF8va2NGo8CefZ1Cri','Niles','2020-08-15 01:08:36'),(11,'rusty.sather@gmail.com','rsather','$2y$10$m2rcstDx2/rJIOTVV/qhVubD.k61ff3qjMxLVVd.kgPf1qpt6I8Qq','Rusty','2020-08-23 00:35:48'),(12,'kyodaina@gmail.com','kyodaina','$2y$10$Q.2Ksf3G.n.v6HXRJj3AouaI2L6gISAKnYFnqtk..FPabrgUJ8mY2','Gyasz','2020-09-18 22:07:40');
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

-- Dump completed on 2020-11-06 19:23:37
