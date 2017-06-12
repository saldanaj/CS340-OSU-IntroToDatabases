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
	FOREIGN KEY (house_castle) REFERENCES ancestral_castles(id) ON UPDATE SET NULL ON DELETE SET NULL 
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
	FOREIGN KEY (castle_born) REFERENCES ancestral_castles(id) ON UPDATE SET NULL ON DELETE SET NULL, 
	FOREIGN KEY (house_affiliation) REFERENCES houses(id) ON UPDATE SET NULL ON DELETE SET NULL, 
	UNIQUE KEY (first_name, last_name)
)ENGINE=InnoDB; 


-- Create the character_title table that will contain the following 
-- properties/attributes: 
-- char_id: int which is a foreign key reference to the characters id 
-- title_id: int which is a foreign key reference to the title's id 

CREATE TABLE character_title(
	char_id INT, 
	title_id INT, 
	FOREIGN KEY (char_id) REFERENCES characters(id) ON UPDATE SET NULL ON DELETE SET NULL, 
	FOREIGN KEY (title_id) REFERENCES titles(id) ON UPDATE SET NULL ON DELETE SET NULL
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
	FOREIGN KEY (char_id) REFERENCES characters(id) ON UPDATE SET NULL ON DELETE SET NULL, 
	FOREIGN KEY (father_id) REFERENCES characters(id) ON UPDATE SET NULL ON DELETE SET NULL, 
	FOREIGN KEY (mother_id) REFERENCES characters(id) ON UPDATE SET NULL ON DELETE SET NULL
)ENGINE=InnoDB; 


-- INSERTION SECTION 

-- this is the insertion stmt for the ancestral_castles table: 

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






































