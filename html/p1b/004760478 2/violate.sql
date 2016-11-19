-- Constraint: set Movie id to primary key
-- A movie with id=220 already exists
INSERT INTO Movie VALUES (220,'Gone With The Wind',1939,'PG-13','Metro-Goldwyn-Mayer');
-- ERROR 1062 (23000): Duplicate entry '220' for key 1


--Constraint: NOT NULL for Title of Movie
INSERT INTO Movie VALUES (1,NULL,2016,'PG-13','Yippee Inc');


--Constraint: check that the year is NOT NULL
--CHECKS ARE NOT TESTED, but year -150 is not within 1000-9999
INSERT INTO Movie VALUES (1,'Hello New Year',NULL,'PG-13','Yay Inc');


--Constraint: set Actor id to primary key
--An actor with id=10 already exists
INSERT INTO Actor VALUES (10,'Last_Name','First_Name','Male',1981-12-05,2001-01-05);
--ERROR 1062 (23000): Duplicate entry '10' for key 1


--Constraint: set Director id to primary key
--A director with id=895 already exists
INSERT INTO Director VALUES (895,'Last_Name','First_Name',1981-12-05,2001-01-05);
--ERROR 1062 (23000): Duplicate entry '895' for key 1


--Constraint: Reference MovieGenre mid to the foreign key id in Movie
--There is no id=10 in Movie
INSERT INTO MovieGenre VALUES (10,'Romance');
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))


--Constraint: Reference MovieDirector mid to the foreign key id in Movie
--There is no id=10 in Movie
INSERT INTO MovieDirector VALUES (10,16);
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))


--Constraint: Reference MovieDirector did to the foreign key id in Director
--There is no id=15 in Director
INSERT INTO MovieDirector VALUES (9,15);
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))


--Constraint: Reference MovieActor mid to the foreign key id in Movie
--There is no id=1 in Movie
INSERT INTO MovieActor VALUES (1,11,'Captain');
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))


--Constraint: Reference MovieActor aid to the foreign key id in Actor
--There is no id=9 in Actor
INSERT INTO MovieActor VALUES (2,9,'Doorman');
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))


--Constraint: Reference Review mid to the foreign key id in Movie
--There is no id=1 in Movie
INSERT INTO Review VALUES ('Name_of_Movie','10-17-2016 01:00:30',1,3,'It was Great!');
--ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143/Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))


--Constraint: check that the rating is between 0 and 10
--Checks aren't tested but the rating has to be within 0 and 10
INSERT INTO Review VALUES ('Name_of_Movie','10-17-2016 01:00:30',1,-3,'It was Great!');
