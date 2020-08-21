-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Database: swoop_team
-- Generation Time: Apr 05, 2020 at 12:59 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11
DROP TABLE comments;
DROP TABLE todo_list;
DROP TABLE journal;
DROP TABLE members;
DROP TABLE invites;
DROP TABLE users;
DROP TABLE team;

CREATE TABLE teams (
  id int primary key auto_increment,
  team_name varchar(50) not null unique,
  admin varchar(75) not null,
  date_created datetime default current_timestamp,
  foreign key(admin) references users(email)
);

CREATE TABLE users (
  id int primary key auto_increment,
  email varchar(75) not null unique,
  username varchar(75) not null,
  pswd varchar(300) not null,
  date_created datetime default current_timestamp
);

CREATE TABLE members (
  id int primary key auto_increment,
  email varchar(75) not null,
  team_name varchar(50) not null,
  join_date datetime default current_timestamp,
  foreign key(email) references users(email),
  foreign key(team_name) references teams(team_name)
);

CREATE TABLE invites (
  id int primary key auto_increment,
  sender varchar(75) not null,
  receiver varchar(75) not null,
  team_name varchar(50) not null,
  status varchar(20) default 'pending' not null,
  date_created datetime default current_timestamp,
  foreign key(sender) references users(email),
  foreign key(receiver) references users(email),
  foreign key(team_name) references teams(team_name)
);


CREATE TABLE journal (
  id int(11) primary key auto_increment,
  subject varchar(45) NOT NULL,
  message varchar(10000) NOT NULL,
  category varchar(45) NOT NULL,
  creator varchar(50) NOT NULL,
  is_private varchar(20) default "private" not null,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  team_name varchar(50),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

-- NOT IMPLEMENTED, but would be cool
CREATE TABLE comments (
  id int(11) primary key auto_increment,
  comment varchar(150) not null,
  user_email varchar(75) not null,
  journal_id int(11),
  foreign key(journal_id) references journal(id),
  foreign key(user_email) references users(email)
);

--
-- Table structure for table todo_list
--

CREATE TABLE todo_list (
	id int primary key auto_increment,
	title varchar(60) NOT NULL,
  description varchar(100),
  status varchar(30) DEFAULT "Not Started",
	deadline date NOT NULL,
  task_repeat varchar(10) NULL,
	importance varchar(10) NOT NULL,
  assignee varchar(50),
  creator varchar(50) NOT NULL,
  team_name varchar(50),
	date_created datetime DEFAULT CURRENT_TIMESTAMP,
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

