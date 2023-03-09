-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2023 at 03:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_mnagment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `Borrowing_ID` int(11) NOT NULL,
  `Borrowing_Date` date DEFAULT NULL,
  `Borrowing_Return_Date` date DEFAULT NULL,
  `Nickname` varchar(150) NOT NULL,
  `Collection_ID` int(11) NOT NULL,
  `Reservation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`Borrowing_ID`, `Borrowing_Date`, `Borrowing_Return_Date`, `Nickname`, `Collection_ID`, `Reservation_ID`) VALUES
(1, '2023-03-09', '2023-03-24', 'jalil_betroji', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Nickname` varchar(150) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `CIN` varchar(50) DEFAULT NULL,
  `Occupation` varchar(50) DEFAULT NULL,
  `Penalty_Count` int(11) DEFAULT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Creation_Date` date DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Nickname`, `First_Name`, `Last_Name`, `Password`, `Address`, `Email`, `Phone`, `CIN`, `Occupation`, `Penalty_Count`, `Birth_Date`, `Creation_Date`, `Admin`) VALUES
('amine_lamchatab', 'amine', 'lamchatab', '$2y$10$cM4r6xywo69r/gUiR6cSk.Zp3vxFMmH0vMvvHQU8sepI34GmTwmU6', 'Tanger hlan 91000', 'amine.lamchatab@gmail.com', '0613245143', 'GH564132', 'Student', 0, '1999-01-01', NULL, 0),
('hamid_achoua', 'hamid', 'achoua', '$2y$10$ecCGz4cGezNvj0ex/59bwunrJ2ijMlY8ymesw8Q4q5REKsPAdT2Mq', 'Tnager ahlan rue de rabat ', 'hamid.achoua@gmail.com', '0675452341', 'HG99121', 'Student', 0, '1999-01-01', NULL, 0),
('jalil_betroji', 'jalil', 'betroji', '$2y$10$KP1aaKqbkxtavjmeZA4YOeMKuALTDx.6.qpyAv.skx2xn..ccCDie', '91000 tanger ahlan', 'jalil.betroji@gmail.com', '0651782276', 'GM220997', 'Student', 0, '2023-01-01', NULL, 0),
('outhman_moumou', 'outhman', 'moumou', '$2y$10$zGd7UWfs7MFoCvMbdURZj.qpGZHA7wZKvgLDi10xIQpM1hH0RlDJy', 'Tanger rue de rabat ', 'outhman.moumou@gmail.com', '0654372653', 'HJ253162', 'Student', 0, '1999-09-03', NULL, 0),
('soufian_elkebdani', 'soufian', 'elkebdani', '$2y$10$OrtZtJrNIpfyXlpk26j0MexhINYzoX64pIySmu64QSReq2DU3l8LS', 'Tnager ahlan boukhalef', 'soufian.elkebdani@gmail.com', '0564234132', 'JU9Y26673', 'Student', 0, '1997-02-01', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `Collection_ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Author_Name` varchar(100) DEFAULT NULL,
  `Cover_Image` varchar(100) DEFAULT NULL,
  `State` varchar(100) DEFAULT NULL,
  `Edition_Date` date DEFAULT NULL,
  `Buy_Date` date DEFAULT NULL,
  `Status` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`Collection_ID`, `Type_ID`, `Title`, `Author_Name`, `Cover_Image`, `State`, `Edition_Date`, `Buy_Date`, `Status`) VALUES
(1, 1, 'Rich Dad Poor Dad', 'Robert T.KIYOZAKI', 'bond king.webp', 'New', '1997-03-04', '2023-03-08', 'reserved'),
(2, 2, 'breadcrumbs', 'Anne Ursu', 'breadcrumbs.jpg', 'New', '2019-09-03', '2023-03-15', 'available'),
(3, 1, 'ChildOfTheKindred', 'M.T Magee', 'ChildOfTheKindred.jpg', 'new', '2017-09-10', '2023-03-06', 'available'),
(4, 5, 'Wired', 'Bob Woodward', 'wired.jpg', 'new', '1993-03-10', '2023-03-13', 'available'),
(5, 5, '1984', 'George Orwell', '1984.jpg', 'new', '1984-03-07', '2023-03-15', 'Available'),
(6, 1, 'grave Secret', 'Alice James', 'graveSecret.jpg', 'New', '2010-02-02', '2023-03-07', 'Available'),
(7, 1, 'breadcrumbs', 'J.K Rowling', 'HarryPotter.jpg', 'new', '2007-03-06', '2023-03-21', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `Reservation_ID` int(11) NOT NULL,
  `Reservation_Date` date DEFAULT NULL,
  `Reservation_Expiration_Date` date DEFAULT NULL,
  `Collection_ID` int(11) NOT NULL,
  `Nickname` varchar(150) NOT NULL,
  `Reservation_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Reservation_ID`, `Reservation_Date`, `Reservation_Expiration_Date`, `Collection_ID`, `Nickname`, `Reservation_Status`) VALUES
(2, '2023-03-09', '2023-03-10', 1, 'jalil_betroji', 'reserved');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `Type_ID` int(11) NOT NULL,
  `Type_Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`Type_ID`, `Type_Name`) VALUES
(1, 'Book'),
(2, 'CD'),
(4, 'DVD'),
(5, 'research dissertation'),
(6, 'magazine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`Borrowing_ID`),
  ADD UNIQUE KEY `Reservation_ID` (`Reservation_ID`),
  ADD KEY `Collection_ID` (`Collection_ID`),
  ADD KEY `Nickname` (`Nickname`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Nickname`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`Collection_ID`),
  ADD KEY `Type_ID` (`Type_ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD KEY `Collection_ID` (`Collection_ID`),
  ADD KEY `Nickname` (`Nickname`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`Type_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `Borrowing_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `Collection_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`Collection_ID`) REFERENCES `collection` (`Collection_ID`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`Nickname`) REFERENCES `client` (`Nickname`),
  ADD CONSTRAINT `borrowings_ibfk_3` FOREIGN KEY (`Reservation_ID`) REFERENCES `reservation` (`Reservation_ID`);

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `types` (`Type_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Collection_ID`) REFERENCES `collection` (`Collection_ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Nickname`) REFERENCES `client` (`Nickname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
