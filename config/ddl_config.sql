-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2020 at 12:59 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

--
-- Database on inspiron machine: note_web
-- Database on main machine: lhapps
-- Database should be called grooper or something
--

--CREATE DATABASE if not exists note_web;
--USE note_web;
--DROP TABLE IF EXISTS journal;
DROP TABLE IF EXISTS todo_list;

create table teams (
  id int primary key auto_increment,
  team_name varchar(50) not null unique,
  admin varchar(75) not null,
  date_created datetime default current_timestamp,
  -- NEW: 7/28/2020
  foreign key(admin) references users(email)
);

create table users (
  id int primary key auto_increment,
  email varchar(75) not null unique,
  username varchar(75) not null,
  pswd varchar(300) not null,
  team varchar(50),
  date_created datetime default current_timestamp,
  foreign key (team) references teams(team_name)
);

-- Will need to add user foreign keys to the following tables
-- journal
-- todo_list
-- file paths/shortcodes? (not created yet)

CREATE TABLE journal (
  id int(11) primary key auto_increment,
  subject varchar(45) NOT NULL,
  message varchar(10000) NOT NULL,
  category varchar(45) NOT NULL,
  creator varchar(50) NOT NULL,
  is_private varchar(20) default "Public" not null,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  team_name varchar(50),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

-- NEW TABLE `comments`, ref journal 08/22/2020

CREATE TABLE comments (
  id int(11) primary key not null,
  comment varchar not null,
  user_email varchar not null,
  journal_id int(11) not null,
  foreign key(journal_id) references journal(id),
  foreign key(user_email) references users(email)
)

--
-- Table structure for table todo_list
--

CREATE TABLE todo_list (
	id int primary key auto_increment NOT NULL,
	title varchar(45) NOT NULL,
  description varchar(100),
  status varchar(30) DEFAULT "Not Started",
	deadline date NOT NULL,
  time_due time NOT NULL,
  task_repeat varchar(10) NULL,
	importance varchar(10) NOT NULL,
  assignee varchar(50),
  creator varchar(50) NOT NULL,
  team_name varchar(50),
	date_created datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (assignee) references users(email),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

/* 
*   The tables below are for the bonus applications and 
*   may not be included in the live website. 
*/

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
  `vote` varchar(10) not null,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (topic_id) references polls(id)
);


CREATE TABLE `chatroom` (
  `id` int(11) NOT NULL primary key auto_increment,
  `subject` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `creator` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_created` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL primary key auto_increment,
  `name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `room_id` int(11) NOT NULL,
  `msg` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `time_submitted` datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (room_id) references chatroom(id)
);

create table ratings (
  id int primary key auto_increment not null,
  rating int(11),
  user_email varchar(75) not null unique,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (user_email) references users(email)
);
