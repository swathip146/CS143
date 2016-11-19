CREATE TABLE Movie(id INT primary key,title VARCHAR(100),year INT,rating VARCHAR(10),company VARCHAR(50));
CREATE TABLE Actor(id INT primary key,last VARCHAR(20),first VARCHAR(20),sex VARCHAR(6),dob DATE NOT NULL,dod DATE);
CREATE TABLE Director(id INT primary key,last VARCHAR(20),first VARCHAR(20),dob DATE NOT NULL,dod DATE);
CREATE TABLE MovieGenre(mid INT primary key, genre VARCHAR(20));
CREATE TABLE MovieDirector(mid INT primary key,did INT);
CREATE TABLE MovieActor(mid INT primary key,aid INT,role VARCHAR(50));
CREATE TABLE Review(name VARCHAR(20) primary key,time TIMESTAMP,mid INT,rating INT,comment VARCHAR(500));
