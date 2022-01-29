-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2021 at 11:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se-ed`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `Author_ID` int(15) NOT NULL,
  `Author_Name` varchar(50) NOT NULL,
  `Author_LastName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`Author_ID`, `Author_Name`, `Author_LastName`) VALUES
(7, 'Ray', 'Bradbury'),
(8, 'H. G.', 'Wells'),
(9, 'G. R. R. Martin', ''),
(10, 'นิ้วกลม', ''),
(11, 'นิ้วนาง', ''),
(12, 'George', 'Orwell');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Book_ISBN` varchar(15) NOT NULL,
  `Book_Name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `Book_Weight` double DEFAULT 0,
  `Book_Price` double DEFAULT 0,
  `Book_Quantity` int(10) DEFAULT 0,
  `Book_SaleQuantity` int(10) DEFAULT 0,
  `Book_PublishNumber` int(10) NOT NULL DEFAULT 1,
  `Book_PublishYear` int(5) NOT NULL,
  `Publisher_ID` int(15) NOT NULL,
  `Book_Barcode` varchar(13) NOT NULL,
  `Catagory_ID` int(15) NOT NULL,
  `Author_ID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Book_ISBN`, `Book_Name`, `image`, `Book_Weight`, `Book_Price`, `Book_Quantity`, `Book_SaleQuantity`, `Book_PublishNumber`, `Book_PublishYear`, `Publisher_ID`, `Book_Barcode`, `Catagory_ID`, `Author_ID`) VALUES
('1234567890', 'Darkness at noon', 'darkess_at_noon.jpg', 20.05, 100.5, 30, 0, 1, 2500, 9, '', 25, 10),
('9780743247221', 'Fahrenhein 451', 'Fahrenheit_451_1st_ed_cover.jpg', 451, 451, 10, 7, 70, 2540, 9, '', 27, 7),
('9786164341869', '1984', '9786164341869.jpg', 19.84, 200.75, 20, 2, 5, 2563, 11, '', 25, 12),
('9786167196084', 'The Time Machine', '9786167196084.jpg', 123, 199.5, 20, 2, 2, 2500, 11, '', 28, 8);

-- --------------------------------------------------------

--
-- Table structure for table `book_order`
--

CREATE TABLE `book_order` (
  `Cus_id` int(15) NOT NULL,
  `Order_Num` int(15) NOT NULL,
  `Order_Time` datetime NOT NULL DEFAULT current_timestamp(),
  `DeliveryStatus` int(2) NOT NULL,
  `Order_Status` int(2) NOT NULL,
  `PayMethod` int(2) NOT NULL,
  `Order_Address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_order`
--

INSERT INTO `book_order` (`Cus_id`, `Order_Num`, `Order_Time`, `DeliveryStatus`, `Order_Status`, `PayMethod`, `Order_Address`) VALUES
(1, 42, '2021-10-18 23:37:35', 2, 1, 2, 'ดาวอังคาร'),
(1, 58, '2021-10-19 10:37:44', 2, 1, 2, ''),
(1, 59, '2021-10-19 10:59:40', 0, 1, 2, ''),
(5, 39, '2021-10-18 07:38:56', 0, 0, 0, ''),
(8, 64, '2021-10-23 23:31:53', 0, 1, 1, 'ดาวโลก'),
(9, 65, '2021-10-24 16:24:37', 0, 1, 1, 'บ้านทรายทอง');

-- --------------------------------------------------------

--
-- Table structure for table `book_order_detail`
--

CREATE TABLE `book_order_detail` (
  `Order_Num` int(15) NOT NULL,
  `Book_ISBN` varchar(15) NOT NULL,
  `Quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_order_detail`
--

INSERT INTO `book_order_detail` (`Order_Num`, `Book_ISBN`, `Quantity`) VALUES
(39, '9780743247221', 3),
(42, '9780743247221', 1),
(58, '9780743247221', 1),
(58, '9786164341869', 1),
(59, '9780743247221', 1),
(64, '9786167196084', 2),
(65, '9780743247221', 2),
(65, '9786164341869', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `Catagory_ID` int(15) NOT NULL,
  `Catagory_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`Catagory_ID`, `Catagory_Name`) VALUES
(27, 'Dystopia'),
(21, 'Fantasy'),
(23, 'Horror'),
(25, 'Novel'),
(28, 'Sci-fi'),
(30, 'text');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Cus_id` int(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL,
  `Cus_Name` varchar(100) NOT NULL,
  `Cus_LName` varchar(100) NOT NULL,
  `Cus_sex` varchar(100) NOT NULL,
  `Cus_BDate` date NOT NULL,
  `Cus_PhoneNum` varchar(100) NOT NULL,
  `Cus_mobile` varchar(30) NOT NULL,
  `Cus_Point` int(6) NOT NULL DEFAULT 0,
  `Cus_RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Cus_Address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Cus_id`, `email`, `password`, `Cus_Name`, `Cus_LName`, `Cus_sex`, `Cus_BDate`, `Cus_PhoneNum`, `Cus_mobile`, `Cus_Point`, `Cus_RegDate`, `Cus_Address`) VALUES
(1, 'Kittichan@gmail.com', 'kittichan', 'กิตติฌาน', 'ศิริโสภณา', 'ชาย', '2021-10-01', '0123456789', '0123456789', 0, '2021-10-16 04:02:05', 'ดวงจันทร์'),
(5, 'Siriwutlnwzaa007@gmail.com', '123456789', 'สิริวุฒ', 'ล่องสกุล', 'ชาย', '2021-07-16', '0987654321', '0987654321', 0, '2021-10-16 04:02:48', NULL),
(6, 'admin@se-ed.com', 'adminseed', 'Siri', 'Poop', '', '0000-00-00', '', '', 0, '2021-10-19 05:12:57', NULL),
(7, 'qwerty@email.com', '1234567890', 'game', 'sompong', 'ชาย', '2021-10-08', '0123456789', '0123456789', 1601, '2021-10-19 08:54:48', 'ดาวนาเม็ก'),
(8, 'zxcvbnm@email.com', 'zxcvbnm', 'qqqqqq', 'qqqqqq', 'ชาย', '2021-10-02', '0123456789', '0123456789', 32, '2021-10-23 15:48:17', 'ดาวโลก'),
(9, 'Siri@gmail.com', 'oooooooooo', 'sira', 'wannabe', 'ชาย', '2021-03-05', '01234567890', '01234567890', 88, '2021-10-24 09:05:22', 'บ้านทรายทอง');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `Publisher_ID` int(15) NOT NULL,
  `Publisher_Name` varchar(100) NOT NULL,
  `Publisher_Address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`Publisher_ID`, `Publisher_Name`, `Publisher_Address`) VALUES
(9, 'demo', NULL),
(10, 'R. Talsorian', NULL),
(11, 'อาราซากะ คอร์ป', 'เอาไงวัยรุ่น');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`Author_ID`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_ISBN`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `Fk_Catagory` (`Catagory_ID`),
  ADD KEY `Fk_Publisher` (`Publisher_ID`),
  ADD KEY `Fk_Author` (`Author_ID`);

--
-- Indexes for table `book_order`
--
ALTER TABLE `book_order`
  ADD PRIMARY KEY (`Cus_id`,`Order_Num`),
  ADD KEY `Order_Num` (`Order_Num`);

--
-- Indexes for table `book_order_detail`
--
ALTER TABLE `book_order_detail`
  ADD PRIMARY KEY (`Order_Num`,`Book_ISBN`),
  ADD KEY `Book_ISBN` (`Book_ISBN`);

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`Catagory_ID`),
  ADD UNIQUE KEY `Catagory_ID` (`Catagory_ID`),
  ADD UNIQUE KEY `Catagory_Name` (`Catagory_Name`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Cus_id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`Publisher_ID`),
  ADD UNIQUE KEY `Publisher_Name` (`Publisher_Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `Author_ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `book_order`
--
ALTER TABLE `book_order`
  MODIFY `Order_Num` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `Catagory_ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Cus_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `Publisher_ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`Publisher_ID`) REFERENCES `publisher` (`Publisher_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`Catagory_ID`) REFERENCES `catagory` (`Catagory_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`Author_ID`) REFERENCES `author` (`Author_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_order`
--
ALTER TABLE `book_order`
  ADD CONSTRAINT `book_order_ibfk_1` FOREIGN KEY (`Cus_id`) REFERENCES `member` (`Cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_order_detail`
--
ALTER TABLE `book_order_detail`
  ADD CONSTRAINT `book_order_detail_ibfk_1` FOREIGN KEY (`Order_Num`) REFERENCES `book_order` (`Order_Num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_order_detail_ibfk_2` FOREIGN KEY (`Book_ISBN`) REFERENCES `book` (`Book_ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
