-- this is testing the schema from assignment 3 

DROP TABLE IF EXISTS `Model`; 
DROP TABLE IF EXISTS `Make`; 
DROP TABLE IF EXISTS `Color`; 
DROP TABLE IF EXISTS `Incentive`;
DROP TABLE IF EXISTS `Vehicle`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `Vehicle_Incentive`; 

-- Model table 
CREATE TABLE Model(
model_id INT AUTO_INCREMENT NOT NULL, 
model_name VARCHAR(255) NOT NULL, 
first_production_year VARCHAR(255) NOT NULL, 
PRIMARY KEY(model_id)
)ENGINE=InnoDB;    


-- Make  table 
CREATE TABLE Make(
make_id INT AUTO_INCREMENT NOT NULL, 
make_name VARCHAR(255) NOT NULL, 
country VARCHAR(255) NOT NULL, 
PRIMARY KEY(make_id)
)ENGINE=InnoDB;    

-- Color table 
CREATE TABLE Color(
color_id INT AUTO_INCREMENT NOT NULL, 
name VARCHAR(255) NOT NULL, 
code VARCHAR(255) NOT NULL, 
PRIMARY KEY(color_id)
)ENGINE=InnoDB;  

-- Incentive table 
CREATE TABLE Incentive(
incentive_id INT AUTO_INCREMENT NOT NULL, 
type VARCHAR(255) NOT NULL, 
amount VARCHAR(255) NOT NULL, 
conditions VARCHAR(255) NOT NULL, 
PRIMARY KEY(incentive_id)
)ENGINE=InnoDB; 


-- Vehicle table 
CREATE TABLE Vehicle(
vehicle_id INT AUTO_INCREMENT NOT NULL,
fk_make_id INT, 
fk_model_id INT, 
year VARCHAR(255) NOT NULL, 
PRIMARY KEY (vehicle_id),
FOREIGN KEY (fk_make_id) REFERENCES Make(make_id), 
FOREIGN KEY (fk_model_id) REFERENCES Model(model_id) 
)ENGINE=InnoDB; 


-- Inventory table 
CREATE TABLE Inventory(
inventory_id INT AUTO_INCREMENT NOT NULL,
fk_vehicle_id INT, 
fk_color_id INT, 
price VARCHAR(255) NOT NULL, 
PRIMARY KEY (inventory_id),
FOREIGN KEY (fk_vehicle_id) REFERENCES Vehicle(vehicle_id), 
FOREIGN KEY (fk_color_id) REFERENCES Color(color_id) 
)ENGINE=InnoDB; 


-- Vehicle_Incentive table 
CREATE TABLE Vehicle_Incentive(
fk_vehicle_id INT, 
fk_incentive_id INT, 
PRIMARY KEY (fk_vehicle_id, fk_incentive_id), 
valid_till VARCHAR(255) NOT NULL, 
FOREIGN KEY (fk_vehicle_id) REFERENCES Vehicle(vehicle_id), 
FOREIGN KEY (fk_incentive_id) REFERENCES Incentive(incentive_id)
)ENGINE=InnoDB; 







