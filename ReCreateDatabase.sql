DROP DATABASE dan;
COMMIT;

CREATE DATABASE dan;
USE dan;

CREATE TABLE USER_ROLES(
    ID INT NOT NULL AUTO_INCREMENT, 
    UserType VARCHAR(20) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO USER_ROLES (UserType) VALUES ('Admin');
INSERT INTO USER_ROLES (UserType) VALUES ('Customer');

CREATE TABLE COUNTRIES(
    COUNTRY_ID INT NOT NULL AUTO_INCREMENT, 
    COUNTRY_NAME VARCHAR(25) NOT NULL, 
    PRIMARY KEY(COUNTRY_ID)
);

INSERT INTO COUNTRIES (COUNTRY_NAME) VALUES ('Romania');
INSERT INTO COUNTRIES (COUNTRY_NAME) VALUES ('USA');
INSERT INTO COUNTRIES (COUNTRY_NAME) VALUES ('Luxembourg');
INSERT INTO COUNTRIES (COUNTRY_NAME) VALUES ('Afganistan');


CREATE TABLE PPL (
    PERSON_ID INT NOT NULL AUTO_INCREMENT, 
    First_Name VARCHAR(25) NOT NULL, 
    Second_Name VARCHAR(25) NOT NULL,
    Age INT,
    UserName VARCHAR(25) NOT NULL UNIQUE,
    Password VARCHAR(150) NOT NULL,
    Nationality INT NOT NULL,
    User_role INT NOT NULL,
    PRIMARY KEY (PERSON_ID),
    FOREIGN KEY (Nationality) REFERENCES COUNTRIES(COUNTRY_ID),
    FOREIGN KEY (User_role) REFERENCES USER_ROLES(ID)
);


CREATE TABLE Products (
    ID INT NOT NULL AUTO_INCREMENT, 
    Name VARCHAR(50) NOT NULL,  
    Description VARCHAR(500),
    Price INT NOT NULL,
    Picture VARCHAR(50),
    PRIMARY KEY (ID)
    );

COMMIT;