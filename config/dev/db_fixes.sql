DROP TABLE IF EXISTS file_storage;
ALTER TABLE journal MODIFY message TEXT (100000);

CREATE TABLE file_storage (
  id int primary key auto_increment,
  article_id int not null,
  file_name varchar(100) not null,
  file_type varchar(10) not null,
  file_path varchar(200) not null,
  file_class varchar(50) not null,
  date_created date default(CURRENT_DATE),
  foreign key (article_id) references journal(id)
);

CREATE TABLE reminders (
  id int primary key auto_increment,
  task_name varchar(75) not null,
  deadline date not null,
  exec_time datetime not null,
  assignee varchar(50) not null
);