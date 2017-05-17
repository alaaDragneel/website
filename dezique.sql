-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2016 at 08:58 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dezique`
--
CREATE DATABASE IF NOT EXISTS `dezique` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dezique`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `Name`, `Email`, `Username`, `Password`) VALUES
(1, 'alaa', 'alaa@alaa.com', 'alaa dragneel', '4c1b52409cf6be3896cf163fa17b32e4da293f2e');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Img` varchar(255) NOT NULL,
  `Time` time NOT NULL,
  `Date` date NOT NULL,
  `Service_ID` int(11) NOT NULL,
  `admin_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`ID`, `Title`, `Content`, `Img`, `Time`, `Date`, `Service_ID`, `admin_ID`) VALUES
(1, 'PHP-DEVLOPMENT', 'this-artical-Talk-about-the-Tricks-in-the-PHP', '12319610_416698835190509_351284972_n.jpg', '17:27:43', '2016-09-01', 3, 1),
(2, 'this-artical-will-show-some-advice-to-make-Good-SEO', 'this-artical-will-show-some-advice-to-make-Good-SEO', '1454849_1044796528877014_3199855136812393557_n.jpg', '17:28:48', '2016-09-01', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `comment_time` time NOT NULL,
  `comment_date` date NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `email`, `comment`, `status`, `comment_time`, `comment_date`, `article_id`) VALUES
(7, 'aaa@xx.com', 'test comment no.1', 1, '07:44:00', '2016-09-01', 2),
(9, 'aaa@alaa.com', 'test comment after update tiwce', 0, '19:43:58', '2016-09-01', 2),
(10, 'alaa_dragneel@yahoo.com', 'i love this artical', 1, '20:28:53', '2016-09-01', 2),
(11, 'alaa@alaa.com', 'this is the best artical i see it', 1, '20:52:11', '2016-09-01', 2),
(12, 'mohamedzayed709@yahoo.com', 'best artical', 1, '20:53:50', '2016-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Img` varchar(255) NOT NULL,
  `Company_Name` varchar(255) NOT NULL,
  `Customer_Comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fqa`
--

CREATE TABLE `fqa` (
  `ID` int(11) NOT NULL,
  `Question` varchar(500) NOT NULL,
  `Answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hosting`
--

CREATE TABLE `hosting` (
  `ID` int(11) NOT NULL,
  `Duration` year(4) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Capacity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `our_team`
--

CREATE TABLE `our_team` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Jop_Title` varchar(255) NOT NULL,
  `Scoap` varchar(255) NOT NULL,
  `Img` varchar(500) NOT NULL,
  `Facebook` varchar(500) NOT NULL,
  `gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `our_team`
--

INSERT INTO `our_team` (`ID`, `Name`, `Jop_Title`, `Scoap`, `Img`, `Facebook`, `gender`) VALUES
(8, 'alaa Dragneel', 'PHP DEVELOPER', 'Alaa is Good More than Zayed', '7d8c3e2c659bf7b9c7edffdced7fdc561459069695_full[1].jpg', 'https://www.facebook.com', 1),
(9, 'zayed', 'Senoir PHP DEVELOPER', 'Alaa Is Better Than Zaed', '12241747_414375758756150_2611962092478941331_n.jpg', 'https://www.youtube.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `portofolio`
--

CREATE TABLE `portofolio` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `subName` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Img` varchar(255) NOT NULL,
  `Details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `portofolio`
--

INSERT INTO `portofolio` (`ID`, `Name`, `subName`, `Description`, `Img`, `Details`) VALUES
(1, 'Learn-It''s-Free', 'Courses-Web-Site', 'this-is-our-First-Advanced-project', 'project1.jpg', 'you-can-order-online-courses,-you-can-order-offline-courses,must-be-has-mail-on-this-web-site,'),
(2, 'the-Hope-Hospital', 'hospital-web-site', 'the-hospital-web-site-was-a-useful-web-to-test', 'project2.jpg', 'you-can-order-An-appointment-with-the-doctors'),
(3, 'the-Pay-To-You-shop', 'ecommerce-web-site', 'the-latest-project-for-us-is-this-amazing-web-site', 'project3.jpg', 'enter-it-and-you-will-see');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Img` varchar(255) NOT NULL,
  `Describtion` text NOT NULL,
  `Date` date NOT NULL,
  `admin_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ID`, `Name`, `Img`, `Describtion`, `Date`, `admin_ID`) VALUES
(3, 'Development', '12208742_412032918990434_4854936609497079880_n.jpg', 'we Develop the web Application by the best dynamic way', '2016-09-01', 1),
(4, 'Desgin', 'HTML.jpg', 'we design by thew best practies', '2016-09-01', 1),
(5, 'Mobile Application', '22940_anime_scenery.jpg', 'we can develop the mobile application on all the palteform', '2016-09-01', 1),
(6, 'SEO', 'slide-3.jpg', 'We Can Optimize all the SEO For you And You Will Love It', '2016-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `whatwedo`
--

CREATE TABLE `whatwedo` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `whatwedo`
--

INSERT INTO `whatwedo` (`ID`, `Name`, `Description`, `Icon`) VALUES
(1, ' Quality Cooding', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?\r\n\r\n', '<i class="fa fa-fw fa-check"></i>'),
(2, 'Hosting & Offers', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?\r\n\r\n', '<i class="fa fa-fw fa-gift"></i>'),
(3, ' Easy to Use', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, optio corporis quae nulla aspernatur in alias at numquam rerum ea excepturi expedita tenetur assumenda voluptatibus eveniet incidunt dicta nostrum quod?\r\n\r\n', '<i class="fa fa-fw fa-compass"></i>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `admin_ID` (`admin_ID`),
  ADD KEY `Service_ID` (`Service_ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `item_comment` (`article_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fqa`
--
ALTER TABLE `fqa`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `hosting`
--
ALTER TABLE `hosting`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `our_team`
--
ALTER TABLE `our_team`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `admin_ID` (`admin_ID`);

--
-- Indexes for table `whatwedo`
--
ALTER TABLE `whatwedo`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fqa`
--
ALTER TABLE `fqa`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hosting`
--
ALTER TABLE `hosting`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `our_team`
--
ALTER TABLE `our_team`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `portofolio`
--
ALTER TABLE `portofolio`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `whatwedo`
--
ALTER TABLE `whatwedo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `Admin_ID_Relation` FOREIGN KEY (`admin_ID`) REFERENCES `admins` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Service_ID_Relation` FOREIGN KEY (`Service_ID`) REFERENCES `services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `admin_ID` FOREIGN KEY (`admin_ID`) REFERENCES `admins` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
