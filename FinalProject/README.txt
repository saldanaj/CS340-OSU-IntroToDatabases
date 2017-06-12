Need to turn in 2 files 

1. A PDF that contains all diagrams and written info 
2. A .zip file that contains all of the source code for the project

The queries (including the CREATE TABLE statements) should be in one section of the PDF 

In the comment area, include a link to the hosted, functioning website (in this case it's my web.engr page)


Important information: 

Database should have at least 4 entities and at least 4 relationships, one of which must be a MANY TO 
MANY relationship 

We need to able to the do the following w/ the data: 

1. Add entries to every table individually 

2. Every table should be used in at least one select query.  For the select queries, it is fine to 
display the content of the table

3. WEbsite needs to also ahve the ability to search using text or filter using a dynamically populated 
list of properties to filter on 

4. You also need to include one delete and one update function in the website 

5. If should be possible to add and remove things from at least one MANY TO MANY relationship and it 
should be possible to add things to all relationships


Things to include: 

1. Outline (5%): 

Introduce the topic to the grader.  In my case it's a database of the world of Game of Thrones, or
as the books are called "A World of Ice and Fire"

2. Database Outline (5%): 

Describe in detail the entities, properties, and relationships of the project.  The 
ENTITY-RELATIONSHIP diagram and Schema will be graded based on if they match your description of how 
the entities and relationships work.  (BE AS THOROUGH AS POSSIBLE)

3. ER Diagram (10%): 

An ER Diagram that matches the database outline.  

4. Schema (10%): 

Schema should follow the database outline exactly.  

5. Data definition Queries (15%): 

Queries used to generate the database.  (These are not the queries to add/remove/change/view data on 
the website).  These are the queries to create tables and foreign keys.  Foreign keys should exists 
and be correct.  All data types should be appropriate. 

6. Data Manipulation Queries (25%): 

Queries the website uses to let your users interact with data.  They will be the things that the data 
in your forms are being submitted to.  Anything that is a variable that you expect the user to fill in 
should be enclosed in square braces.  

	Ex: SELECT salary FROM employee WHERE salary > [salary input]

They only want to see SQL here, DO NOT INCLUDE ANY PHP OR JAVASCRIPT used to process the data.  

7. Website Functionality

It should be possible to add data to every table and view data from every table. (DO NOT HAVE 
A SINGLE QUERY THAT JOINS ALL TABLES TOGETHER)

When dealing w/ relationships, you should allow the user to select things to relate to each other via 
drop down menus or some other user interface element where the user picks from existing items to add 
them to a relationship.  

When picking items you should display the name that makes the most sense to the user.  This more than 
likely will not be the primary key, since the primary key is usually a number. 

It should be possible to both ADD and REMOVE things from relationships.  

8. Style (10%): 

Website should be easy to navigate, tabular data should be displayed in tables and form elements 
should be reasonably grouped.  The write-up should be well formatted with queries hat are easy to read and commented if they are complex.  

























/* THIS WAS GOOD DATA DEFINITION CODE BUT MADE SOME MINOR CHANGES */


-- Student: Joaquin Saldana (saldanaj@oregonstate.edu)

-- Drop the tables if they exists.  The order in which the tables will be created 
-- is  in ascending order with the table with less foreign keys to the table 
-- w/ the most foreign keys

DROP TABLE IF EXISTS `family`;
DROP TABLE IF EXISTS `character_title`; 
DROP TABLE IF EXISTS `characters`;
DROP TABLE IF EXISTS `houses`;
DROP TABLE IF EXISTS `titles`;
DROP TABLE IF EXISTS `ancestral_castles`;


-- Create the ancestral_castles table that will contain the following 
-- properties/attributes: 
-- id: auto incrementing int which is the primary key  
-- castle_name: varchar, max length 255, cannot be null 
-- location: varchar, max length 255, cannot be null

CREATE TABLE ancestral_castles(
	id INT AUTO_INCREMENT NOT NULL, 
	castle_name VARCHAR(255) NOT NULL, 
	location VARCHAR(255) NOT NULL,
	PRIMARY KEY (id), 
	UNIQUE (castle_name)
)ENGINE=InnoDB; 


-- Create the houses table that will contain the following 
-- properties/attributes: 
-- id: auto incrementing int which is the primary key  
-- house_name: varchar, max length 255, cannot be null 
-- ancestral_weapon: varchar, max length 255
-- house_castle: a int which is a foreign key reference to the acentral_castle table

CREATE TABLE houses(
	id INT AUTO_INCREMENT NOT NULL, 
	house_name VARCHAR(255) NOT NULL, 
	ancestral_weapon VARCHAR(255), 
	house_castle INT, 
	UNIQUE(house_name), 
	PRIMARY KEY (id), 
	FOREIGN KEY (house_castle) REFERENCES ancestral_castles(id) ON UPDATE CASCADE ON DELETE CASCADE 
)ENGINE=InnoDB; 

-- Create the titles table that will contain the following 
-- properties/attributes: 
-- id: auto incrementing int which is the primary key  
-- title_name: varchar, max length 255, cannot be null 

CREATE TABLE titles(
	id INT AUTO_INCREMENT NOT NULL, 
	title_name VARCHAR(255) NOT NULL, 
	PRIMARY KEY(id), 
	UNIQUE(title_name)
)ENGINE=InnoDB; 


-- Create the characters table that will contain the following 
-- properties/attributes: 
-- id: auto incrementing int which is the primary key  
-- first_name: varchar, max length 255, cannot be null 
-- last_name: varchar, max length 255, cannot be null 
-- castle_born: int which is a foreign key reference to the ancestral_castles table 
-- house_affiliation: int which is a foreign key reference to the houses table 

CREATE TABLE characters(
	id INT AUTO_INCREMENT NOT NULL, 
	first_name VARCHAR(255) NOT NULL, 
	last_name VARCHAR(255) NOT NULL, 
	castle_born INT, 
	house_affiliation INT, 
	PRIMARY KEY(id), 
	FOREIGN KEY (castle_born) REFERENCES ancestral_castles(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (house_affiliation) REFERENCES houses(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	UNIQUE KEY (first_name, last_name)
)ENGINE=InnoDB; 


-- Create the character_title table that will contain the following 
-- properties/attributes: 
-- char_id: int which is a foreign key reference to the characters id 
-- title_id: int which is a foreign key reference to the title's id 

CREATE TABLE character_title(
	char_id INT, 
	title_id INT, 
	FOREIGN KEY (char_id) REFERENCES characters(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (title_id) REFERENCES titles(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB; 

-- Create the family table that will contain the following 
-- properties/attributes: 
-- chard_id: int which is a foreign key reference to the characters id 
-- father_id: int which is a foreign key reference to the characters id which is the father 
-- mother_id: int which is a foreign key reference to the characters id which is the mother

CREATE TABLE family(
	char_id INT, 
	father_id INT, 
	mother_id INT, 
	FOREIGN KEY (char_id) REFERENCES characters(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (father_id) REFERENCES characters(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (mother_id) REFERENCES characters(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB; 


-- INSERTION SECTION 

INSERT INTO ancestral_castles (castle_name, location) VALUES ("Casterly Rock", "Westerlands"), 
	("Winterfell", "North Westeros"), 
	("Kings Landing", "Crownloands Westeros"),
	("Dragonstone", "Island of Dragonstone"),
	("Riverrun", "Riverlands Westeros"), 
	("Castle Black", "The Wall"), 
	("Pyke", "Iron Islands"), 
	("Sunspear", "Dorne Westeros"), 
	("Dreadfort", "North Westeros"),
	("Storms End", "Stormlands"); 


-- this is the insertion statement for the houses table: 

INSERT INTO houses (house_name, ancestral_weapon, house_castle) VALUES ("House Lannister", "Brightroar", (SELECT id FROM ancestral_castles WHERE castle_name = 
"Casterly Rock")),
	("House Targaryen", "Dark Sister", (SELECT id FROM ancestral_castles WHERE castle_name = "Kings Landing")), 
	("House Stark", "Ice", (SELECT id FROM ancestral_castles WHERE castle_name = "Winterfell")), 
	("House Baratheon", NULL, (SELECT id FROM ancestral_castles WHERE castle_name = "Dragonstone")),
	("Nights Watch", NULL, (SELECT id FROM ancestral_castles WHERE castle_name = "Castle Black")),
	("House Greyjoy", NULL, (SELECT id FROM ancestral_castles WHERE castle_name = "Pyke")); 


-- this is the insertion statement for the titles table: 

INSERT INTO titles (title_name) VALUES ("Lord of the Iron Islands"), 
	("Lord of Winterfell"), 
	("Prince of Winterfell"), 
	("Protector of the Realm"),
	("Lady of Casterly Rock"),  
	("Warden of the West"), 
	("Warden of the North"), 
	("Hand of the King"), 
	("Warden of the South"), 
	("Lord of Highgarden"), 
	("Acting Hand of the King"), 
	("Lord of Casterly Rock"), 
	("King of Westeros"), 
	("Lord of Dragonstone"), 
	("The King of Dragonstone"), 
	("Queen of the Seven Kingdoms"), 
	("Khaleesi"), 
	("Princess of Dragonstone"), 
	("Lord of the Crossing"),
	("The Mad King"); 


-- this is the insertion statement for the characters table: 

INSERT INTO characters(first_name, last_name, castle_born, house_affiliation) VALUES
	("Eddard", "Stark", (SELECT id FROM ancestral_castles WHERE castle_name = "Winterfell"), (SELECT id FROM houses WHERE house_name = "House Stark")), 
	("Cersei", "Lannister", (SELECT id FROM ancestral_castles WHERE castle_name = "Casterly Rock"), (SELECT id FROM houses WHERE house_name = "House Lannister")),  
	("Tywin", "Lannister", NULL, (SELECT id FROM houses WHERE house_name = "House Lannister")), 
	("Daenerys", "Targaryen", (SELECT id FROM ancestral_castles WHERE castle_name = "Dragonstone"), (SELECT id FROM houses WHERE house_name = "House Targaryen")), 
	("Joanna", "Lannister", (SELECT id FROM ancestral_castles WHERE castle_name = "Casterly Rock"), (SELECT id FROM houses WHERE house_name = "House Targaryen")), 
	("Catelyn", "Stark", (SELECT id FROM ancestral_castles WHERE castle_name = "Riverrun"), (SELECT id FROM houses WHERE house_name = "House Stark")), 
	("Arya", "Stark", (SELECT id FROM ancestral_castles WHERE castle_name = "Winterfell"), (SELECT id FROM houses WHERE house_name = "House Stark")), 
	("Stannis", "Baratheon", (SELECT id FROM ancestral_castles WHERE castle_name = "Storms End"), (SELECT id FROM houses WHERE house_name = "House Baratheon")), 
	("Aerys II", "Targaryen", (SELECT id FROM ancestral_castles WHERE castle_name = "Kings Landing"), (SELECT id FROM houses WHERE house_name = "House Targaryen")), 
	("Rhaella", "Targaryen", (SELECT id FROM ancestral_castles WHERE castle_name = "Kings Landing"), (SELECT id FROM houses WHERE house_name = "House Targaryen")), 
	("Jon", "Snow", NULL, (SELECT id FROM houses WHERE house_name = "Nights Watch")); 

-- this is the insertion statements for the character_title table:

INSERT INTO character_title(char_id, title_id) VALUES 
	((SELECT id FROM characters WHERE first_name = "Eddard" AND last_name = "Stark"), (SELECT id FROM titles WHERE title_name = "Lord of Winterfell")), 
	((SELECT id FROM characters WHERE first_name = "Eddard" AND last_name = "Stark"), (SELECT id FROM titles WHERE title_name = "Hand of the King")),
	((SELECT id FROM characters WHERE first_name = "Eddard" AND last_name = "Stark"), (SELECT id FROM titles WHERE title_name = "Warden of the North")),
	((SELECT id FROM characters WHERE first_name = "Tywin" AND last_name = "Lannister"), (SELECT id FROM titles WHERE title_name = "Hand of the King")),
	((SELECT id FROM characters WHERE first_name = "Tywin" AND last_name = "Lannister"), (SELECT id FROM titles WHERE title_name = "Lord of Casterly Rock")),
	((SELECT id FROM characters WHERE first_name = "Daenerys" AND last_name = "Targaryen"), (SELECT id FROM titles WHERE title_name = "Khaleesi")),
	((SELECT id FROM characters WHERE first_name = "Daenerys" AND last_name = "Targaryen"), (SELECT id FROM titles WHERE title_name = "Queen of the Seven Kingdoms")),
	((SELECT id FROM characters WHERE first_name = "Aerys II" AND last_name = "Targaryen"), (SELECT id FROM titles WHERE title_name = "The Mad King")),
	((SELECT id FROM characters WHERE first_name = "Aerys II" AND last_name = "Targaryen"), (SELECT id FROM titles WHERE title_name = "King of Westeros")),
	((SELECT id FROM characters WHERE first_name = "Aerys II" AND last_name = "Targaryen"), (SELECT id FROM titles WHERE title_name = "Protector of the Realm")),
	((SELECT id FROM characters WHERE first_name = "Eddard" AND last_name = "Stark"), (SELECT id FROM titles WHERE title_name = "Protector of the Realm")); 


-- this is the insertion statements for the family table: 
INSERT INTO family (char_id, father_id, mother_id) VALUES 
	((SELECT id FROM characters WHERE first_name = "Arya" AND last_name = "Stark"), (SELECT id FROM characters WHERE first_name = "Eddard" AND last_name = "Stark"), (SELECT id FROM characters WHERE first_name = "Catelyn" AND last_name = "Stark")), 
	((SELECT id FROM characters WHERE first_name = "Daenerys" AND last_name = "Targaryen"), (SELECT id FROM characters WHERE first_name = "Aerys II" AND last_name = "Targaryen"), (SELECT id FROM characters WHERE first_name = "Rhaella" AND last_name = "Targaryen")),
	((SELECT id FROM characters WHERE first_name = "Cersei" AND last_name = "Lannister"), (SELECT id FROM characters WHERE first_name = "Tywin" AND last_name = "Lannister"), (SELECT id FROM characters WHERE first_name = "Joanna" AND last_name = "Lannister")); 
