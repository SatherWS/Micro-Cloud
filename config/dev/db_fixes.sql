ALTER TABLE journal MODIFY message TEXT (100000);

CREATE TABLE file_storage (
  id int primary key auto_increment,
  article_id int not null,
  file_name varchar(100) not null,
  file_type varchar(10) not null,
  file_path varchar(200) not null,
  date_created date default(CURRENT_DATE),
  foreign key (article_id) references journal(id)
);
