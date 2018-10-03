CREATE TABLE `Users` (
	`User ID` int NOT NULL AUTO_INCREMENT,
	`User Name` varchar(256) NOT NULL,
	`Gender` varchar(256) NOT NULL,
	`Email` varchar(256) NOT NULL UNIQUE,
	`Password` varchar(256) NOT NULL,
	`Birth Date` DATE NOT NULL,
	`Role ID` int NOT NULL,
	`Blood Group ID` int NOT NULL,
	PRIMARY KEY (`User ID`)
);

CREATE TABLE `User Roles` (
	`Role ID` int NOT NULL AUTO_INCREMENT,
	`Role Name` varchar(256) NOT NULL,
	PRIMARY KEY (`Role ID`)
);

CREATE TABLE `Health Records` (
	`Record ID` int NOT NULL AUTO_INCREMENT,
	`User ID` int NOT NULL,
	`Symptoms` varchar(256) NOT NULL,
	`Not Symptoms` varchar(256),
	`Date` DATETIME NOT NULL DEFAULT NOW(),
	`Predicted Disease ID` int NOT NULL,
	`Cured` boolean NOT NULL DEFAULT false,
	PRIMARY KEY (`Record ID`)
);

CREATE TABLE `Diseases` (
	`Disease ID` int NOT NULL AUTO_INCREMENT,
	`Disease Name` varchar(256) NOT NULL,
	`Field ID` int NOT NULL,
	PRIMARY KEY (`Disease ID`)
);

CREATE TABLE `Doctors` (
	`Doctor ID` int NOT NULL AUTO_INCREMENT,
	`Doctor Name` varchar(256) NOT NULL,
	`Expertise` int NOT NULL,
	`Contact` varchar(256) NOT NULL,
	`Chamber Location` varchar(256) NOT NULL,
	PRIMARY KEY (`Doctor ID`)
);

CREATE TABLE `Fields` (
	`Field ID` int NOT NULL AUTO_INCREMENT,
	`Name` varchar(256) NOT NULL UNIQUE,
	PRIMARY KEY (`Field ID`)
);

CREATE TABLE `Treatments` (
	`Treatment ID` int NOT NULL AUTO_INCREMENT,
	`Treatment Name` varchar(256) NOT NULL,
	PRIMARY KEY (`Treatment ID`)
);

CREATE TABLE `Disease Treatments` (
	`Disease ID` int NOT NULL,
	`Treatment ID` int NOT NULL,
	PRIMARY KEY (`Disease ID`,`Treatment ID`)
);

CREATE TABLE `Blood Group` (
	`Blood Group ID` int NOT NULL AUTO_INCREMENT,
	`Name` varchar(256) NOT NULL,
	PRIMARY KEY (`Blood Group ID`)
);

CREATE TABLE `Diagnostic Reports` (
	`Report ID` int NOT NULL AUTO_INCREMENT,
	`Creation Time` DATE NOT NULL,
	`User ID` int NOT NULL,
	PRIMARY KEY (`Report ID`)
);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk0` FOREIGN KEY (`Role ID`) REFERENCES `User Roles`(`Role ID`);

ALTER TABLE `Users` ADD CONSTRAINT `Users_fk1` FOREIGN KEY (`Blood Group ID`) REFERENCES `Blood Group`(`Blood Group ID`);

ALTER TABLE `Health Records` ADD CONSTRAINT `Health Records_fk0` FOREIGN KEY (`User ID`) REFERENCES `Users`(`User ID`);

ALTER TABLE `Health Records` ADD CONSTRAINT `Health Records_fk1` FOREIGN KEY (`Predicted Disease ID`) REFERENCES `Diseases`(`Disease ID`);

ALTER TABLE `Diseases` ADD CONSTRAINT `Diseases_fk0` FOREIGN KEY (`Field ID`) REFERENCES `Fields`(`Field ID`);

ALTER TABLE `Doctors` ADD CONSTRAINT `Doctors_fk0` FOREIGN KEY (`Expertise`) REFERENCES `Fields`(`Field ID`);

ALTER TABLE `Disease Treatments` ADD CONSTRAINT `Disease Treatments_fk0` FOREIGN KEY (`Disease ID`) REFERENCES `Diseases`(`Disease ID`);

ALTER TABLE `Disease Treatments` ADD CONSTRAINT `Disease Treatments_fk1` FOREIGN KEY (`Treatment ID`) REFERENCES `Treatments`(`Treatment ID`);

ALTER TABLE `Diagnostic Reports` ADD CONSTRAINT `Diagnostic Reports_fk0` FOREIGN KEY (`User ID`) REFERENCES `Users`(`User ID`);

INSERT INTO `blood group` (`Blood Group ID`, `Name`) VALUES (NULL, 'A+'), (NULL, 'A-'), (NULL, 'B+'), (NULL, 'B-'), (NULL, 'AB+'), (NULL, 'AB-'), (NULL, 'O+'), (NULL, 'O-');

INSERT INTO `user roles` (`Role ID`, `Role Name`) VALUES (NULL, 'User'), (NULL, 'Admin');

INSERT INTO `users` (`User ID`, `User Name`, `Gender`, `Email`, `Password`, `Birth Date`, `Role ID`, `Blood Group ID`) VALUES (NULL, 'Ashiqur', 'Male', 'ash@man.com', '$2y$10$iLKgNIajd763CL4G1saLtewmFhjU69L0ipz7l1jt2QRz5N4wBpNxK', '2005-09-29', '2', '3');

INSERT INTO `users` (`User ID`, `User Name`, `Gender`, `Email`, `Password`, `Birth Date`, `Role ID`, `Blood Group ID`) VALUES (NULL, 'User', 'Male', 'user@man.com', '$2y$10$iLKgNIajd763CL4G1saLtewmFhjU69L0ipz7l1jt2QRz5N4wBpNxK', '2000-09-29', '1', '1');

INSERT INTO `fields` (`Field ID`, `Name`) VALUES (NULL, 'Medicine'), (NULL, 'Cardiologist'), (NULL, 'Gastroenterologist'), (NULL, 'Microbiologist');

/*
Change the field foreign keys accordingly
INSERT INTO `doctors` (`Doctor ID`, `Doctor Name`, `Expertise`, `Contact`, `Chamber Location`) VALUES (NULL, 'Professor Dr. Md. Ayub Ali Chowdhury', '1', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Dr. Sakina Anwar', '1', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Professor Dr. Md. Lutful Kabir', '1', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Dr. Hasna Fahmima Haque', '1', '+8801745742726', 'Labaid Specialized Hospital Dhanmondi'), (NULL, 'Prof. Dr. M. Touhidul Haque', '7', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Prof. Dr. S M. Siddiqur Rahman', '7', '+8801737509263', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Dr. Abu Salim', '7', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Dr. Bimal Chandra Shil', '2', '+8801745742726', 'Labaid Specialized Hospital Dhanmondi'), (NULL, 'Dr. K.M.Shahidul Islam', '2', '+8801745742726', 'Ibn Sina Diagnostic & Imaging Center Dhanmondi'), (NULL, 'Prof. Dr. Brig. Gen. (Retd) Md. Mokhlesur Rahman', '8', '+8801745742726', 'Labaid Specialized Hospital Dhanmondi');
INSERT INTO `diseases` (`Disease ID`, `Disease Name`, `Field ID`) VALUES (NULL, 'Typhoid', '1'), (NULL, 'Angina', '7');
*/