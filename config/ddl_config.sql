-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2020 at 12:59 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

--
-- Database: lhapps
--
CREATE DATABASE if not exists lhapps;
USE lhapps;
DROP TABLE journal;
DROP TABLE todo_list;
-- --------------------------------------------------------

--
-- Table structure for table day_logger
--

CREATE TABLE journal (
  id int(11) primary key auto_increment,
  subject varchar(45) NOT NULL,
  message varchar(300) NOT NULL,
  rating int(11) NOT NULL,
  date_created datetime DEFAULT CURRENT_TIMESTAMP
);

--
-- Table structure for table todo_list
--

CREATE TABLE todo_list (
	id int primary key auto_increment not null,
	description varchar(45) not null,
	start_date datetime,
	deadline date NOT NULL,
	importance varchar(10) NOT NULL,
	date_created datetime DEFAULT CURRENT_TIMESTAMP
);

--
-- Table structure for table `topics`
--

CREATE TABLE `polls` (
  `id` int(11) primary key auto_increment,
  `admin` varchar(30) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
);

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) primary key auto_increment not null,
  `topic_id` int(11) not null,
  `username` varchar(20) not null,
  `vote` text not null,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (topic_id) references polls(id)
);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

CREATE TABLE `chatroom` (
  `id` int(11) NOT NULL primary key auto_increment,
  `subject` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `creator` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL primary key auto_increment,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `room_id` int(11) NOT NULL,
  `msg` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `time_submitted` datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (room_id) references chatroom(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

