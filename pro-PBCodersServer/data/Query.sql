-- DROP the database if it exists
DROP DATABASE IF EXISTS Employee;

-- CREATE THE DATABASE
CREATE DATABASE Employee;

-- SHOW DATABASES;
SHOW DATABASES;

-- Use the database
USE Employee;

-- Create the User Table
CREATE TABLE User (
	userId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	firstName VARCHAR(50) NOT NULL,
	lastName VARCHAR(50) NOT NULL,
	userName VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(50) NOT NULL ,
	phone VARCHAR(12) DEFAULT NULL,
	gender VARCHAR(50),
	age INT(11) DEFAULT NULL,
	userType VARCHAR(50) NOT NULL,
	password varchar(250) NOT NULL
	
)ENGINE=InnoDB;


-- Create the LogHours Table
create table Hours (
	hoursId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
	hoursWorked INT NOT NULL,
    userId INT NOT NULL,
    CONSTRAINT FKHoursUser FOREIGN KEY (userId) REFERENCES User(userId)
	ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;

-- Create the Items Table
create table Item (
	itemId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	text VARCHAR(12) UNIQUE NOT NULL,
	amount DECIMAL(13,2) NOT NULL
)ENGINE=InnoDB;



create table Sale (
	saleId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
	text VARCHAR(50) NOT NULL,
	amount DECIMAL(13,2) NOT NULL,
    userId INT NOT NULL,
    CONSTRAINT FKSaleUser FOREIGN KEY (userId) REFERENCES User(userId)
	ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;


INSERT INTO User VALUES (1,'Colver','Prydden','cprydden0','cprydden0@dedecms.com','585-686-1406','Male',49,'Admin','$2y$10$JHV0Y0yfYhTA2rTA//1CweCZWwfkGEHxK/TnT8VIJIwjDTlGkCCDi'),
(2,'Mollie','Stuttard','mstuttard1','mstuttard1@taobao.com','251-305-9376','Female',39,'Employee','$2y$10$NcCTPaKoYLWDqE17Ufnlsui0OH8D6jT4P9.n5B6Thcl/AD7pcICnS'),
(3,'Hetti','Orritt','horritt2','horritt2@netvibes.com','223-257-6637','Female',45,'Employee','$2y$10$KGCumBzgbriICSTRaHJNTOQqqAzWvEvxOls6UuG.Q9blN2cdL16Am'),
(4,'Piggy','Chadwell','pchadwell3','pchadwell3@weibo.com','246-899-8894','Male',10,'Employee','$2y$10$E.W0gCZb78jqFamiWPy.re4znaEZFXcZnLeYDr7NU7n4PrE/7fYLi');

INSERT INTO Hours VALUES (1,'2020-04-01', 8, 1),
(2,'2020-04-01', 8,2),
(3,'2020-04-01', 8,3),
(4,'2020-04-01', 8,4),
(5,'2020-04-02', 10,1),
(6,'2020-04-02', 8,2),
(7,'2020-04-02', 6,3),
(8,'2020-04-02', 8,4),
(9,'2020-04-03', 8,1),
(10,'2020-04-04', 4,2),
(11,'2020-04-05', 8,3),
(12,'2020-04-06', 9,4);



INSERT INTO Item VALUES (1,'Laptop', 800),
(2,'TV', 1000),
(3,'Keyboard', 30),
(4,'Mouse', 20);

INSERT INTO Sale VALUES (1,'2020-04-01','Laptop', 800,1),
(2,'2020-04-01','Mouse', 50,2),
(3,'2020-04-01','TV', 900,3),
(4,'2020-04-01','Laptop', 900,4),
(5,'2020-04-01','TV', 1000,1),
(6,'2020-04-01','Mouse', 50,1),
(7,'2020-04-01','Keyboard', 40,3),
(8,'2020-04-01','Laptop', 900,4);




