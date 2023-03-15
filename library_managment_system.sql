-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2023 at 12:49 PM
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
-- Database: `library_managment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `Borrowing_ID` int(11) NOT NULL,
  `Borrowing_Date` date NOT NULL,
  `Borrowing_Expire_Date` date NOT NULL,
  `Borrowing_Return_Date` date NOT NULL,
  `Nickname` varchar(150) NOT NULL,
  `Reservation_ID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`Borrowing_ID`, `Borrowing_Date`, `Borrowing_Expire_Date`, `Borrowing_Return_Date`, `Nickname`, `Reservation_ID`, `Status`) VALUES
(8, '2023-03-14', '2023-03-29', '2023-03-14', 'jalil_jalil', 36, 'returned'),
(9, '2023-03-14', '2023-03-29', '2023-03-14', 'jalil_jalil', 38, 'returned'),
(10, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 39, 'returned'),
(11, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 40, 'returned'),
(12, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 41, 'returned'),
(13, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 42, 'returned'),
(14, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 43, 'returned'),
(15, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 44, 'returned'),
(16, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 45, 'returned'),
(17, '2023-02-21', '2023-03-08', '2023-03-14', 'jalil_jalil', 46, 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Nickname` varchar(150) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `CIN` varchar(50) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Penalty_Count` int(11) NOT NULL,
  `Birth_Date` date NOT NULL,
  `Creation_Date` date NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Account_Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Nickname`, `First_Name`, `Last_Name`, `Password`, `Address`, `Email`, `Phone`, `CIN`, `Occupation`, `Penalty_Count`, `Birth_Date`, `Creation_Date`, `Admin`, `Account_Status`) VALUES
('amine_lamchatab', 'amine', 'lamchatab', '$2y$10$cM4r6xywo69r/gUiR6cSk.Zp3vxFMmH0vMvvHQU8sepI34GmTwmU6', 'Tanger hlan 91000', 'amine.lamchatab@gmail.com', '0613245143', 'GH564132', 'Student', 0, '1999-01-01', '2023-03-12', 0, 'active'),
('hamid_achoua', 'hamid', 'achoua', '$2y$10$ecCGz4cGezNvj0ex/59bwunrJ2ijMlY8ymesw8Q4q5REKsPAdT2Mq', 'Tnager ahlan rue de rabat ', 'hamid.achoua@gmail.com', '0675452341', 'HG99121', 'Student', 0, '1999-01-01', '2023-03-09', 0, 'active'),
('hamid_hamid', 'hamid', 'hamid', '$2y$10$8.i6UpGOVcIeWHdo.0BS3eelrLrp35m.euhRHVQx0S2WCklXQa/Ze', 'Tnager ahlan boukhalef', 'hamid.hamid@gmail.com', '0675432512', 'KL1231231', 'Civil Servant', 0, '1990-03-04', '2023-03-11', 0, 'active'),
('jalil_betroji', 'jalil', 'betroji', '$2y$10$KP1aaKqbkxtavjmeZA4YOeMKuALTDx.6.qpyAv.skx2xn..ccCDie', '91000 tanger ahlan', 'jalil.betroji@gmail.com', '0651782276', 'GM220997', 'Student', 0, '2023-01-01', '2023-03-08', 1, 'active'),
('jalil_betrojii', 'jalil', 'betrojii', '$2y$10$SPlPCWQXUZKUWy8A5eQnK.SgOKkcyWehqxY1CS60yzzbT948bdPGO', 'Tanger rue de rabat ', 'jalil.betrojii@gmail.com', '0651782276', 'KL431231', 'select account type', 0, '2000-02-21', '2023-03-11', 0, 'active'),
('jalil_jalil', 'jalil', 'jalil', '$2y$10$m4dgp2JYYKRV3C7D4Oss5udU1L4vUkuZDd1rnN9hMpGSletVd6t1W', 'Tnager ahlan rue de rabat ', 'jalil.jalil@gmail.com', '0654524542', 'MM98974', 'student', 0, '1998-01-06', '2023-03-11', 0, 'active'),
('outhman_moumo', 'outhman', 'moumo', '$2y$10$c/.BvlZghQprT9wZRapSq.cmlJf1320MRbHgDJOkiukb8KrCoZB02', 'Tanger rue de rabat ', 'outhman.moumou@gmail.com', '0654545432', 'FRE3421324', 'Employee', 0, '1999-01-12', '2023-03-11', 0, 'active'),
('outhman_moumou', 'outhman', 'moumou', '$2y$10$zGd7UWfs7MFoCvMbdURZj.qpGZHA7wZKvgLDi10xIQpM1hH0RlDJy', 'Tanger rue de rabat ', 'outhman.moumou@gmail.com', '0654372653', 'HJ253162', 'Student', 0, '1999-09-03', '2023-03-10', 0, 'active'),
('rachid_rachid', 'rachid', 'rachid', '$2y$10$pcw1Kz/7AUgFKotVonBDLeUFvqx2AZhIYFz2lJuFXDNVoE25u7hz.', '91000 tanger ahlan', 'rachid.rachid@gmail.com', '0651423425', 'UYI354271', 'Student', 0, '1998-01-13', '2023-03-11', 0, 'active'),
('soufian_elkebdani', 'soufian', 'elkebdani', '$2y$10$OrtZtJrNIpfyXlpk26j0MexhINYzoX64pIySmu64QSReq2DU3l8LS', 'Tnager ahlan boukhalef', 'soufian.elkebdani@gmail.com', '0564234132', 'JU9Y26673', 'Student', 0, '1997-02-01', '2023-03-06', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `Collection_ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Author_Name` varchar(100) NOT NULL,
  `Cover_Image` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Edition_Date` date NOT NULL,
  `Number_Of_Pages` int(11) NOT NULL,
  `Buy_Date` date NOT NULL,
  `Status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`Collection_ID`, `Type_ID`, `Title`, `Author_Name`, `Cover_Image`, `State`, `Edition_Date`, `Number_Of_Pages`, `Buy_Date`, `Status`) VALUES
(1, 1, 'Rich Dad Poor Dad', 'Robert T.KIYOZAKI', 'bond king.webp', 'new', '1997-03-04', 342, '2023-03-08', 'available'),
(2, 2, 'breadcrumbs', 'Anne Ursu', 'breadcrumbs.jpg', 'new', '2019-09-03', 121, '2023-03-15', 'available'),
(3, 1, 'ChildOfTheKindred', 'M.T Magee', 'ChildOfTheKindred.jpg', 'new', '2017-09-10', 311, '2023-03-06', 'available'),
(4, 5, 'Wired', 'Bob Woodward', 'wired.jpg', 'new', '1993-03-10', 321, '2023-03-13', 'available'),
(5, 5, '1984', 'George Orwell', '1984.jpg', 'new', '1984-03-07', 122, '2023-03-15', 'available'),
(6, 1, 'grave Secret', 'Alice James', 'graveSecret.jpg', 'new', '2010-02-02', 133, '2023-03-07', 'available'),
(7, 1, 'Harry Potter', 'J.K Rowling', 'HarryPotter.jpg', 'new', '2007-03-06', 253, '2023-03-21', 'available'),
(22, 1, 'Read People Like a Book', 'Patrick King', '64109778c1aca.jpg', 'New', '2020-11-07', 621, '2023-03-08', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `Reservation_ID` int(11) NOT NULL,
  `Reservation_Date` date NOT NULL,
  `Reservation_Expiration_Date` date NOT NULL,
  `Collection_ID` int(11) NOT NULL,
  `Reservation_Status` varchar(20) NOT NULL,
  `Nickname` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Reservation_ID`, `Reservation_Date`, `Reservation_Expiration_Date`, `Collection_ID`, `Reservation_Status`, `Nickname`) VALUES
(36, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(38, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(39, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(40, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(41, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(42, '2023-03-14', '2023-03-15', 5, 'returned', 'jalil_jalil'),
(43, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(44, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(45, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil'),
(46, '2023-03-14', '2023-03-15', 22, 'returned', 'jalil_jalil');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `Type_ID` int(11) NOT NULL,
  `Type_Name` varchar(50) NOT NULL
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
  MODIFY `Borrowing_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `Collection_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`Nickname`) REFERENCES `client` (`Nickname`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`Reservation_ID`) REFERENCES `reservation` (`Reservation_ID`);

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
