/* DATABASE */
create database if not exists login_php charset utf8mb4 collate utf8mb4_unicode_ci;
use login_php;

/* TABLES */
create table if not exists users (
	id int unsigned primary key auto_increment,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    email varchar(255) unique not null,
    password varchar(255) not null,
    password_forget varchar(255) null,
    facebook_id varchar(30) null,
    google_id varchar(30) null,
    photo varchar(300) null,
    created_at timestamp null,
    updated_at timestamp null
);