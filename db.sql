/*
Milestone 3
 
Written By: 
Logan McCamon
Alan Waidmann
Mikey Hermann

*/

/*

*/
CREATE TABLE IF NOT EXISTS FamilyFlower(
Flower_Id int(2) NOT NULL AUTO_INCREMENT,
Name varchar(32),
PRIMARY KEY (Flower_Id),
UNIQUE KEY `FamilyFlower` (`Name`));

/* */
INSERT INTO FamilyFlower(Name)
VALUES
('Red Carnation'),
('Red Rose'),
('Yellow Rose'),
('Yellow Carnation'),
('White Rose'),
('White Carnation');

CREATE TABLE IF NOT EXISTS Status(
Status_Id int(2) NOT NULL AUTO_INCREMENT,
Name varchar(24) NOT NULL,
ServiceContract float NOT NULL,
PRIMARY KEY(Status_Id),
UNIQUE KEY `Status` (`Status_Id`,`Name`));

INSERT INTO Status(Name, ServiceContract)
VALUES
('Active',25),
('Associate',12.5);

CREATE TABLE IF NOT EXISTS `Member` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(14),
  `schoolyear` int(1) NOT NULL,
  `gradsem` varchar(6) NOT NULL,
  `gradyear` int(4) NOT NULL,
  `pledgesem` varchar(6) NOT NULL,
  `pledgeyear` int(4) NOT NULL,
  `Flower_Id` int(2) NOT NULL, 
  `bigbro` varchar(100) NOT NULL DEFAULT '', 
  `littlebro` varchar(100),
  `Status_Id` int(2) NOT NULL DEFAULT '0',
  `position` int(2) NOT NULL DEFAULT '0',
  `birthday` date,
  `active_sem` text NOT NULL,
  `risk_management` date NOT NULL,
  `hide_info` varchar(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  FOREIGN KEY (Flower_Id) REFERENCES FamilyFlower(Flower_Id),
  FOREIGN KEY (Status_Id) REFERENCES Status(Status_Id)
);

INSERT INTO Member (firstname, lastname, username, password, email, schoolyear, gradsem, gradyear, pledgesem, pledgeyear,
                    Flower_Id, Status_Id, active_sem, risk_management)
VALUES  ('Logan','McCamon','admin','admin','admin@x.com',3,'Spring',2014,'Spring',2011,2,1,'Spring 2013','0000-00-00'),
        ('Oliver','McCamon','admin1','admin','admin@x2.com',2,'Fall',2015,'Spring',2010,1,1,'Spring 2013','0000-00-00'),
        ('Gregg','McCamon','admin2','admin','mgh@x3.com',3,'Spring',2014,'Fall',2011,3,1,'Spring 2013','0000-00-00'),
        ('Mike','Smith','adm4','admin','mike@x.com',3,'Spring',2014,'Spring',2011,4,1,'Spring 2013','0000-00-00'),
        ('Jeff','Smith','admin5','admin','admin@x2.com',1,'Spring',2016,'Spring',2010,2,1,'Spring 2013','0000-00-00'),
        ('Bob','McCamon','admin6','admin','sure@x3.com',1,'Fall',2014,'Fall',2011,5,1,'Fall 2012','0000-00-00'),
        ('Jose','Smith','admin7','admin','rapid@x.com',1,'Spring',2014,'Spring',2011,2,1,'Spring 2013','0000-00-00'),
        ('John','McCamon','admin8','admin','john@x2.com',4,'Spring',2013,'Spring',2010,1,1,'Spring 2013','0000-00-00'),
        ('Hank','Smith','adm32','admin','admin21@x3.com',2,'Spring',2015,'Fall',2011,3,1,'Spring 2013','0000-00-00'),
        ('Hal','McCamon','ad332','admin','hal@x.com',3,'Spring',2014,'Spring',2011,1,1,'Spring 2013','0000-00-00');

/*

*/
CREATE TABLE IF NOT EXISTS Address(
M_Id int(6),
homeaddress varchar(30),
citystatezip varchar(30), 
localaddress varchar(30),
FOREIGN KEY (M_Id) REFERENCES Member(id));

INSERT INTO Address (M_Id, homeaddress, citystatezip)
VALUES (001, '1706 Kittyhawk Dr', 'Columbia, MO, 65201'),
       (002, '1704 Kittyhawk Dr', 'Springfield, MO, 65202'),
       (003, '2706 Hwy 61', 'Columbia, MO, 65203'),
       (004, '3706 Kittyhawk Dr', 'Columbia, MO, 65204'),
       (005, '4706 Kittyhawk Dr', 'Columbia, MO, 65205'),
       (006, '5703 Kittyhawk Dr', 'Columbia, MO, 65206'),
       (007, '6706 Kittyhawk Dr', 'Columbia, MO, 65207'),
       (008, '7706 Kittyhawk Dr', 'Columbia, MO, 65208'),
       (009, '8704 Kittyhawk Dr', 'Columbia, MO, 65209'),
       (010, '9706 Kittyhawk Dr', 'Coolsville, MO, 63670');


/*

*/

CREATE TABLE IF NOT EXISTS EventType(
T_Id int(6) NOT NULL AUTO_INCREMENT,
Name varchar(64) NOT NULL,
PRIMARY KEY (T_Id));

INSERT INTO EventType(Name)
VALUES ('Community'), ('Chapter'), ('Country'), ('Campus'), ('Brotherhood');

/*
An event is all shifts on a given day
*/
CREATE TABLE IF NOT EXISTS Event(
E_Id int(6) NOT NULL AUTO_INCREMENT,
Name varchar(64) NOT NULL,
startDate datetime,
endDate datetime,
Description varchar(320),
Type int(6) NOT NULL,
Location varchar(50) NOT NULL,
publicNotes varchar(320),
privateNotes varchar(320),
Recurring char(1),
Fundraising char(1),
PRIMARY KEY (E_Id),
UNIQUE KEY `event` (`E_Id`,`startDate`),
FOREIGN KEY (Type) REFERENCES EventType(T_Id));
/*
INSERT INTO Event(Name, DOW, Description, Type, Location, publicNotes, privateNotes)
VALUES ('Ray Miller','Mon','Tutor kids',1,'CD','meet 15 minutes prior','none'),
       ('Ray Miller','Wed','Tutor kids',1,'CD','meet 15 minutes prior','none'),
       ('Ray Miller','Thu','Tutor kids',1,'CD','meet 15 minutes prior','none'),
       ('Ray Miller','Fri','Tutor kids',1,'CD','meet 15 minutes prior','none');
*/

/*

*/
CREATE TABLE IF NOT EXISTS Shift(
S_Id int(6) NOT NULL AUTO_INCREMENT,
E_Id int(6),
startTime time,
endTime time,
Max int(3),
PRIMARY KEY(`S_Id`),
FOREIGN KEY (E_Id) REFERENCES Event(E_Id));
/*
INSERT INTO Shift (E_Id, startTime, endTime, Max)
VALUES (1, '16:00:00', '17:00:00', 5),
       (1, '17:00:00', '18:00:00', 5),
       (2, '16:00:00', '17:00:00', 3),
       (3, '16:00:00', '17:00:00', 5),
       (4, '16:00:00', '17:00:00', 5),
       (4, '17:00:00', '18:00:00', 9);
*/
CREATE TABLE IF NOT EXISTS Leader(
M_Id int(6),
S_Id int(6),
UNIQUE KEY `leader` (`M_Id`,`S_Id`),
FOREIGN KEY (M_Id) REFERENCES Member(id),
FOREIGN KEY (S_Id) REFERENCES Shift(S_Id));

CREATE TABLE IF NOT EXISTS EventStatus(
ES_Id int(3) NOT NULL AUTO_INCREMENT,
Name varchar(32),
PRIMARY KEY (ES_Id));

INSERT INTO EventStatus (Name) 
VALUES('Active'),('Canceled');
/*

*/
CREATE TABLE IF NOT EXISTS Occurrence(
O_Id int(6) NOT NULL AUTO_INCREMENT,
S_Id int(6),
startTime	datetime NOT NULL,
endTime	datetime NOT NULL,
Max int(3),
eventStatus_Id int(3) NOT NULL DEFAULT '1',
PRIMARY KEY(`O_Id`),
FOREIGN KEY (S_Id) REFERENCES Shift(S_Id),
FOREIGN KEY (eventStatus_Id) REFERENCES EventStatus(ES_Id));
/*
INSERT INTO Occurrence (E_Id, startTime, endTime, Max)
VALUES (1, '2013-04-03 16:10:00', '2013-04-03 17:00:00', 5),
       (1, '2013-04-03 17:00:00', '2013-04-03 18:00:00', 5),
       (2, '2013-04-03 16:00:00', '2013-04-03 17:00:00', 3),
       (3, '2013-04-03 16:00:00', '2013-04-03 17:00:00', 5),
       (4, '2013-04-03 16:00:00', '2013-04-03 16:40:00', 5),
       (4, '2013-04-03 16:40:00', '2013-04-03 18:00:00', 10);
*/
CREATE TABLE IF NOT EXISTS NextWeek(
P_Id int(6) NOT NULL AUTO_INCREMENT,
S_Id int(6),
startTime datetime NOT NULL,
endTime datetime NOT NULL,
Max int(3),
eventStatus_Id int(3) NOT NULL DEFAULT '1',
PRIMARY KEY (`P_Id`),
UNIQUE KEY (S_Id),
FOREIGN KEY (S_Id) REFERENCES Shift(S_Id),
FOREIGN KEY (eventStatus_Id) REFERENCES EventStatus(ES_Id));
/*
INSERT INTO NextWeek (E_Id, startTime, endTime, Max)
VALUES (1, '2013-04-03 16:10:00', '2013-04-03 17:00:00', 5),
       (1, '2013-04-03 17:00:00', '2013-04-03 18:00:00', 5),
       (2, '2013-04-03 16:00:00', '2013-04-03 17:00:00', 3),
       (3, '2013-04-03 16:00:00', '2013-04-03 17:00:00', 5),
       (4, '2013-04-03 16:00:00', '2013-04-03 16:40:00', 5),
       (4, '2013-04-03 16:40:00', '2013-04-03 18:00:00', 10);
*/
CREATE TABLE IF NOT EXISTS Processed(
Proccessed_Id   int(1) NOT NULL AUTO_INCREMENT,
Name    varchar(24) NOT NULL,
PRIMARY KEY (Proccessed_Id));

INSERT INTO Processed (Name)
VALUES ('Not Yet Processed');

CREATE TABLE IF NOT EXISTS `recorded_hours` (
  `index` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(4) NOT NULL,
  `date` date NOT NULL,
  `semester` text NOT NULL,
  `description` varchar(100) NOT NULL DEFAULT '',
  `hours` float NOT NULL DEFAULT '0',
  `servicetype` varchar(10) NOT NULL DEFAULT '',
  `fundraising` varchar(10) NOT NULL,
  `event` varchar(22) NOT NULL,
  `O_Id`  int(6),
  UNIQUE KEY `index` (`index`),
  UNIQUE KEY `user_id` (`user_id`,`description`,`date`),
  FOREIGN KEY (O_Id) REFERENCES Occurrence(O_Id)); 


/*

*/
CREATE TABLE IF NOT EXISTS Volunteer(
O_Id 		int(6),
M_Id  		int(6),
Processed 	int(1),
FOREIGN KEY (M_Id) REFERENCES Member(id),
FOREIGN KEY (O_Id) REFERENCES Occurrence(O_Id),
FOREIGN KEY (Processed) REFERENCES Processed(Proccessed_Id));
/*
INSERT INTO Volunteer(O_Id,M_Id,Processed)
VALUES (1,1,1),(3,2,1),(1,2,1),(1,3,1),(4,1,1);

*/
CREATE TABLE IF NOT EXISTS SchoolYear(
SchoolYear 	int(1) NOT NULL AUTO_INCREMENT,
Name		varchar(32),
PRIMARY KEY (SchoolYear),
UNIQUE KEY `SchoolYear` (`Name`));

INSERT INTO SchoolYear(Name)
VALUES
('Freshmen'),
('Sophomore'),
('Junior'),
('Senior'),
('Over-Achievers');

CREATE TABLE IF NOT EXISTS Major(
Major_Id    int(3) NOT NULL AUTO_INCREMENT,
Name    varchar(32),
PRIMARY KEY (Major_Id),
UNIQUE KEY `Major` (`Name`));


CREATE TABLE IF NOT EXISTS MajorRoster(
M_Id		int(6),
Major_Id		int(3),
UNIQUE KEY `MajorRoster` (`M_Id`,`Major_Id`),
FOREIGN KEY (Major_Id) REFERENCES Major(Major_Id));


CREATE TABLE IF NOT EXISTS Minor(
Minor_Id    int(3) NOT NULL AUTO_INCREMENT,
Name    varchar(32),
PRIMARY KEY (Minor_Id),
UNIQUE KEY `Minor` (`Name`));


CREATE TABLE IF NOT EXISTS MinorRoster(
M_Id		int(6),
Minor_Id		int(3),
UNIQUE KEY `MinorRoster` (`M_Id`,`Minor_Id`),
FOREIGN KEY (Minor_Id) REFERENCES Minor(Minor_Id));
