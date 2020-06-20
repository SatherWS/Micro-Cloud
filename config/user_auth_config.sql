create table users (
    id int primary key auto_increment,
    usr varchar(75) not null,
    pwd varchar(75) not null,
    date_created datetime default current_timestamp
);

-- Will need to add foreign keys to the following tables
-- journal
-- todolist
-- file paths (not created yet)