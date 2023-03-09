CREATE TABLE Client(
   Nickname VARCHAR(150),
   First_Name VARCHAR(50),
   Last_Name VARCHAR(50),
   Password VARCHAR(150),
   Address VARCHAR(100),
   Email VARCHAR(100),
   Phone VARCHAR(100),
   CIN VARCHAR(50),
   Occupation VARCHAR(50),
   Penalty_Count INT,
   Birth_Date DATE,
   Creation_Date DATE,
   Admin BOOLEAN,
   PRIMARY KEY(Nickname)
);

CREATE TABLE Types(
   Type_ID INT AUTO_INCREMENT,
   Type_Name VARCHAR(50),
   PRIMARY KEY(Type_ID)
);

CREATE TABLE Collection(
   Collection_ID INT AUTO_INCREMENT,
   Type_ID INT NOT NULL,
   Title VARCHAR(50),
   Author_Name VARCHAR(100),
   Cover_Image VARCHAR(100),
   State VARCHAR(100),
   Edition_Date DATE,
   Buy_Date DATE,
   Status VARCHAR(150),
   PRIMARY KEY(Collection_ID),
   FOREIGN KEY(Type_ID) REFERENCES Types(Type_ID)
);

CREATE TABLE Reservation(
   Reservation_ID INT AUTO_INCREMENT,
   Reservation_Date DATE,
   Reservation_Expiration_Date DATE,
   Collection_ID INT NOT NULL,
   Nickname VARCHAR(150) NOT NULL,
   PRIMARY KEY(Reservation_ID),
   FOREIGN KEY(Collection_ID) REFERENCES Collection(Collection_ID),
   FOREIGN KEY(Nickname) REFERENCES Client(Nickname)
);

CREATE TABLE Borrowings(
   Borrowing_ID INT AUTO_INCREMENT,
   Borrowing_Date DATE,
   Borrowing_Return_Date DATE,
   Nickname VARCHAR(150) NOT NULL,
   Collection_ID INT NOT NULL,
   Reservation_ID INT NOT NULL,
   PRIMARY KEY(Borrowing_ID),
   UNIQUE(Reservation_ID),
   FOREIGN KEY(Collection_ID) REFERENCES Collection(Collection_ID),
   FOREIGN KEY(Nickname) REFERENCES Client(Nickname),
   FOREIGN KEY(Reservation_ID) REFERENCES Reservation(Reservation_ID)
);