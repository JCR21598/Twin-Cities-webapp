
USE twin_cities;

-- -----------------------------------------------------
-- Table `City`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `City`;
CREATE TABLE IF NOT EXISTS `City` (
  `City_ID` INT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Country` VARCHAR(45) NULL,
  `Geo_location_long` VARCHAR(45) NULL,
  `Geo_location_lat` VARCHAR(45) NULL,
  `WOEID` INT NULL,
  `Postcode` VARCHAR(45) NULL,
  `Time_zone` VARCHAR(45) NULL,
  `Population_size` INT NULL,
  `Population_density` INT NULL,
  `Currency` VARCHAR(45) NULL,
  PRIMARY KEY (`City_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Place_of_interest`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Place_of_interest`;
CREATE TABLE IF NOT EXISTS `Place_of_interest` (
  `Place_of_interest_ID` INT NOT NULL,
  `PName` VARCHAR(45) NULL,
  `Type` VARCHAR(45) NULL,
  `City` VARCHAR(45) NULL,
  `PCountry` VARCHAR(45) NULL,
  `Geo_location_longP` VARCHAR(45) NULL,
  `Geo_location_latP` VARCHAR(45) NULL,
  `City_WOEID` INT NULL,
  `PostcodeP` VARCHAR(45) NULL,
  `Capacity` INT NULL,
  `Year_of_construction` INT NULL,
  `City_City_ID` INT NOT NULL,
  `Description` LONG VARCHAR NULL,
  `wiki_link` LONG VARCHAR NULL,
  `sentiment_score` VARCHAR(45) NULL,
  `icon_name` VARCHAR(45) NULL,
  PRIMARY KEY (`Place_of_interest_ID`, `City_City_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Photo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Photo`;
CREATE TABLE IF NOT EXISTS `Photo` (
  `Photo_ID` INT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Place_of_interest` VARCHAR(45) NULL,
  `Image_filepath` VARCHAR(45) NULL,
  `Place_of_interest_Place_of_interest_ID` INT NOT NULL,
  `Place_of_interest_City_City_ID` INT NOT NULL,
  PRIMARY KEY (`Photo_ID`, `Place_of_interest_Place_of_interest_ID`, `Place_of_interest_City_City_ID`))
ENGINE = InnoDB;

INSERT INTO `City` (`City_ID`, `Name`, `Country`, `Geo_location_long`, `Geo_location_lat`, `WOEID`, `Postcode`, `Time_zone`, `Population_size`, `Population_density`, `Currency`)
			VALUES (1, 'Exeter', 'England', '-3.5339', '50.7184', 19792, 'EX', 'GMT/BST', 128900, 2700, 'Pound Sterling'),
				   (2, 'Rennes', 'France', '-1.6778', '48.1173', 619163, '35000/35200/35700', 'CET/CEST', 215366, 4300, 'Euro');
				   
INSERT INTO `Place_of_interest` (`Place_of_interest_ID`, `PName`, `Type`, `City`, `PCountry`, `Geo_location_longP`, `Geo_location_latP`, `City_WOEID`, `PostcodeP`, `Capacity`, `Year_of_construction`, `City_City_ID`,`Description`,`wiki_link`,`sentiment_score`, `icon_name`)

						 VALUES (1, 'Exeter Cathedral', 'Cathedral', 'Exeter', 'England', '-3.5299', '50.7225', 19792, 'EX1 1HS', 1000, 1400, 1,'Exeter Cathedral, properly known as the Cathedral Church of Saint Peter in Exeter, is an Anglican cathedral, and the seat of the Bishop of Exeter, in the city of Exeter, Devon, in South West England. The present building was complete by about 1400, and has several notable features, including an early set of misericords, an astronomical clock and the longest uninterrupted vaulted ceiling in England', 'https://en.wikipedia.org/wiki/Exeter_Cathedral', '0', 'cathedral.png'),
                         
								(2, 'Bury Meadow Park', 'Park', 'Exeter','England', '-3.5360', '50.7284', 19792, 'EX4 4HH', NULL, 1850, 1,'Situated between the Unviersity of Exeters Streatham campus and the city centre, Bury Meadow was opened to the public in 1846. The park has a playground with a wooden activity trail and open parkland.','https://www.visitexeter.com/things-to-do/bury-meadow-p187653', '0', 'park.png'),
                                
								(3, 'Harrys Restaurant', 'Restaurant', 'Exeter', 'England', '-3.5264', '50.7281', 19792, 'EX4 6AP', NULL, 1993, 1,'Harrys Restaurant sits within an iconic gothic style building that dates back to 1883. Originally designed by architect Robert Medley Fulford, and brick built more than a century ago, the building was constructed for an English architect and sculptor by the name of Harry Hems.','https://www.harrysrestaurants.co.uk/history','0', 'restaurant.png'),
                                
								(4, 'The Hole In The Wall', 'Bar', 'Exeter', 'England', '-3.5291', '50.7255', 19792, 'EX4 3PX', NULL, 1964, 1,'Hole in the Wall is a stunning multi bar venue in the heart of Exeter City Centre. We are a popular destination with students and those who love to eat drink, socialise and of course watch the sport!','http://www.hitwexeter.co.uk/','0', 'bar.png'),
                                
								(5, 'Tea On The Green', 'Restaurant', 'Exeter', 'England', '-3.5299', '50.7233', 19792, 'EX1 1EZ', NULL, 2009, 1,'Set in the heart of Exeter on the Cathedral Green, since opening in 2009, Tea on the Green brings together influences from great cuisines around the world using locally sourced produce.' ,'https://www.teaonthegreen.com/', '0', 'restaurant.png'),
                                
								(6, 'Royal Albert Memorial Museum', 'Museum', 'Exeter', 'England', '-3.5322', '50.7250', 19792, 'EX4 3RX', NULL, 1868, 1,'an exquisite jewel box of a building; a Venetian casket. One of the most appealing treasures in Britain.', 'https://www.rammuseum.org.uk/', '0', 'museum.png'),
                                
								(7, 'Rennes Cathedral', 'Cathedral', 'Rennes', 'France', '-1.6839', '48.1116', 619163, '35000', NULL, 1845, 2,'Rennes Cathedral (French: Cathedrale Saint-Pierre de Rennes) is a Roman Catholic church located in the town of Rennes, France. It has been a monument historique since 1906','https://en.wikipedia.org/wiki/Rennes_Cathedral' , '0', 'cathedral.png'),
                                
								(8, 'Parc du Thabor', 'Park', 'Rennes', 'France', '-1.6695', '48.1144', 619163, '35000', NULL, NULL, 2, 'Enjoy strolling around one of Frances most beautiful parks. As you explore the wonders of the Thabor gardens, youll be drawn to the romantic, elegant atmosphere. ', 'https://www.tourisme-rennes.com/en/organize-my-trip/what-to-do-in-rennes/parc-du-thabor', '0', 'park.png'),
                                
								(9, 'Museum of Fine Arts of Rennes', 'Museum', 'Rennes', 'France', '-1.6750', '48.1096', 619163, '35000', NULL, 1794, 2, 'The Museum of Fine Arts of Rennes is a municipal museum of fine arts in the French city of Rennes, the capital of Brittany. Its collections range from ancient Egypt antiquities to the Modern art period and make the museum one of the most important in France outside Paris, notably for its paintings and drawings holdings.','https://en.wikipedia.org/wiki/Museum_of_Fine_Arts_of_Rennes' , '0', 'museum.png'),
                                
								(10, 'Roazhon Park', 'Stadium', 'Rennes', 'France', '-1.7129', '48.1075', 619163, '35000', 29778, 1912, 2,'The Roazhon Park, until 2015 named Stade de la Route de Lorient, is a football stadium in Rennes, Brittany, France. Roazhon is the Breton name of Rennes.' , 'https://en.wikipedia.org/wiki/Roazhon_Park', '0', 'stadium.png'),
                                
								(11, 'Le Grill', 'Restaurant', 'Rennes', 'France', '-1.6828', '48.1085', 619163, '35000', NULL, NULL, 2, 'Situe en plein cur de Rennes, entre la Place de Bretagne et les Halles centrales, notre restaurant Le Grill vous accueille 7 jours sur 7, midi et soir. Notre cuisine traditionnelle francaise se veut genereuse et inventive : elle consacre les plaisirs de la cuisson au grill et revisite l esprit bistrot avec creativite.', 'http://www.legrill.fr/', '0', 'restaurant.png'),
                                
								(12, 'Speakeasy Bar', 'Bar', 'Rennes', 'France', '-1.6723', '48.1055', 619163, '35000', NULL, NULL, 2, 'Ouvert le jeudi, le vendredi et le samedi de 19h a 1h', 'https://www.lespeakeasybar.com/', '0', 'bar.png');
								
INSERT INTO `Photo` (`Photo_ID`, `Name`, `Place_of_interest`, `Image_filepath`, `Place_of_interest_Place_of_interest_ID`, `Place_of_interest_City_City_ID`)
			 VALUES (1, 'Exeter Cathedral', 'Exeter Cathedral', 'photos/1.jpg', 1, 1),
					(2, 'Bury Meadow Park', 'Bury Meadow Park', 'photos/2.jpg', 2, 1),
					(3, 'Harry\'s Restaurant', 'Harry\'s Restaurant', 'photos/3.jpg', 3, 1),
					(4, 'The Hole In The Wall', 'The Hole In The Wall', 'photos/4.jpg', 4, 1),
					(5, 'Tea On The Green', 'Tea On The Green', 'photos/5.jpg', 5, 1),
					(6, 'Royal Albert Memorial Museum', 'Royal Albert Memorial Museum', 'photos/6.jpg', 6, 1),
					(7, 'Rennes Cathedral', 'Rennes Cathedral', 'photos/7.jpg', 7, 2),		
					(8, 'Parc du Thabor', 'Parc du Thabor', 'photos/8.jpg', 8, 2),
					(9, 'Museum of Fine Arts of Rennes', 'Museum of Fine Arts of Rennes', 'photos/9.jpg', 9, 2),
					(10, 'Roazhon Park', 'Roazhon Park', 'photos/10.jpg', 10, 2),
					(11, 'Le Grill', 'Le Grill', 'photos/11.jpg', 11, 2),
					(12, 'Speakeasy Bar', 'Speakeasy Bar', 'photos/12.jpg', 12, 2);

COMMIT;										
