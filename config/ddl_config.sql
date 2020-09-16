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
DROP TABLE sub_tasks;
DROP TABLE todo_list;
DROP TABLE journal;
DROP TABLE members;
DROP TABLE invites;
--DROP TABLE ratings;
DROP TABLE teams;
DROP TABLE users;

CREATE TABLE users (
  id int primary key auto_increment,
  email varchar(75) not null unique,
  username varchar(75) not null,
  pswd varchar(300) not null,
  date_created datetime default current_timestamp
);

CREATE TABLE teams (
  id int primary key auto_increment,
  team_name varchar(50) not null unique,
  rating int default 0, 
  admin varchar(75) not null,
  date_created datetime default current_timestamp,
  foreign key(admin) references users(email)
);

/*
CREATE TABLE ratings (
  id int primary key auto_increment,
  remote_ip varchar(95) not null,
  team_name varchar(50) not null,
  date_submitted datetime default current_timestamp,
  foreign key(team_name) references teams(team_name)
);
*/

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
  sender varchar(75),
  receiver varchar(75) not null,
  team_name varchar(50) not null,
  status varchar(20) default 'pending' not null,
  date_created datetime default current_timestamp,
  foreign key(receiver) references users(email),
  foreign key(team_name) references teams(team_name)
);

-- has 1 warning when created
CREATE TABLE journal (
  id int(11) primary key auto_increment,
  subject varchar(45) NOT NULL,
  message varchar(10000) NOT NULL,
  category varchar(45) NOT NULL,
  creator varchar(50) NOT NULL,
  is_public varchar(20) default "not_public" not null,
  date_created datetime DEFAULT CURRENT_TIMESTAMP,
  team_name varchar(50),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

-- NOT IMPLEMENTED, but would be cool
-- has 2 warnings when created
CREATE TABLE comments (
  id int(11) primary key auto_increment,
  comment varchar(150) not null,
  user_email varchar(75) not null,
  journal_id int(11),
  foreign key(journal_id) references journal(id),
  foreign key(user_email) references users(email)
);

CREATE TABLE todo_list (
	id int primary key auto_increment,
	title varchar(75) NOT NULL,
  description varchar(250),
  status varchar(30) DEFAULT "Not Started",
	deadline date NOT NULL,
  task_repeat varchar(10) NULL,
	importance varchar(10) NOT NULL,
  assignee varchar(50) default "None",
  creator varchar(50) NOT NULL,
  team_name varchar(50),
	date_created date DEFAULT (CURRENT_DATE),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

CREATE TABLE sub_tasks (
	id int primary key auto_increment,
	title varchar(75) NOT NULL,
  description varchar(250),
  status varchar(30) DEFAULT "Not Started",
	deadline date NOT NULL,
	importance varchar(10) NOT NULL,
  assignee varchar(50) default "None",
  creator varchar(50) NOT NULL,
  team_name varchar(50),
	date_created date DEFAULT (CURRENT_DATE),
  foreign key (creator) references users(email),
  foreign key (team_name) references teams(team_name)
);

