-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 26, 2018 at 03:29 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `ID` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `PASSWORD` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `NAME` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AVATAR_LINK` varchar(100) COLLATE ucs2_vietnamese_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `hobby` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_vietnamese_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `PASSWORD`, `NAME`, `AVATAR_LINK`, `email`, `address`, `hobby`) VALUES
('admin', '1', 'admin', './img/avatar/default-avatar.jpg', 'longvophuongnguyen@gmail.com', NULL, NULL),
('d', 'd', 'd', './img/avatar/default-avatar.jpg', 'pblong@gmail.com', NULL, NULL),
('guest', 'guest', 'guest', './img/avatar/default-avatar.jpg', 'pblong@gmail.com', NULL, NULL),
('Long', 'Long', 'Phạm Bá Long', './img/avatar/Avartar-hot-girl-lanh-lung.jpg', 'pblong@gmail.com', 'HCM', 'Game'),
('thanh', 'thanh', 'thanh', './img/avatar/default-avatar.jpg', 'pblong@gmail.com', NULL, NULL),
('yuuyenne', 'yuuyenne', 'Nguyễn Chảnh Chó', './img/avatar/default-avatar.jpg', 'nnpu@gmail.com', 'HCM', 'Tán dzai');

-- --------------------------------------------------------

--
-- Table structure for table `commentpost`
--

DROP TABLE IF EXISTS `commentpost`;
CREATE TABLE IF NOT EXISTS `commentpost` (
  `ID_POST` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `COMMENTATOR` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `CONTENT` varchar(500) COLLATE ucs2_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likedpost`
--

DROP TABLE IF EXISTS `likedpost`;
CREATE TABLE IF NOT EXISTS `likedpost` (
  `ID_POST` varchar(255) COLLATE ucs2_vietnamese_ci NOT NULL,
  `CLICKER` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_vietnamese_ci;

--
-- Dumping data for table `likedpost`
--

INSERT INTO `likedpost` (`ID_POST`, `CLICKER`) VALUES
('6a613c7b7c66118e5bb788be5a7697', 'yuuyenne'),
('6f0693f6d30cabe1b08fbd7af64a65', 'yuuyenne'),
('6f0693f6d30cabe1b08fbd7af64a65', 'long'),
('eaf068e4385b42eadd7f570083dd65', 'long');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `ID` varchar(255) COLLATE ucs2_vietnamese_ci NOT NULL,
  `CONTENT` varchar(2000) COLLATE ucs2_vietnamese_ci NOT NULL,
  `MODE` varchar(20) COLLATE ucs2_vietnamese_ci NOT NULL,
  `DATE` datetime NOT NULL,
  `ID_OWNER` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `IMAGE` varchar(2000) COLLATE ucs2_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_vietnamese_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`ID`, `CONTENT`, `MODE`, `DATE`, `ID_OWNER`, `IMAGE`) VALUES
('6a613c7b7c66118e5bb788be5a7697', 'Bài viết này ở chế độ công khai !', 'public', '2018-12-21 19:02:46', 'yuuyenne', 'no'),
('eaf068e4385b42eadd7f570083dd65', 'Bài viết này ở chế độ bạn bè !', 'friend', '2018-12-21 19:03:09', 'yuuyenne', 'no'),
('6f0693f6d30cabe1b08fbd7af64a65', 'Bài viết này có thêm hình ! ', 'public', '2018-12-21 19:08:22', 'yuuyenne', './img/postImg/test.jpg'),
('579582d1cdde5cce3ac20199fad7c9', 'admin test !! alo alo :V :V :))', 'private', '2018-12-21 19:09:30', 'admin', 'no'),
('37d6819f4512b05a11c21819f3ac54', 'bài viết này ở chế độ riêng tư !', 'private', '2018-12-21 19:11:50', 'yuuyenne', 'no'),
('1bd97a970160526ad7e72fdb842ccbaf', '', 'public', '2018-12-23 13:27:54', 'd', 'no'),
('c3fa1e2c9665723aa93cd40b1b27aea8', 'VO THANH LONG', 'public', '2018-12-23 13:28:23', 'd', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

DROP TABLE IF EXISTS `relationship`;
CREATE TABLE IF NOT EXISTS `relationship` (
  `ID1` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL,
  `ID2` varchar(30) COLLATE ucs2_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_vietnamese_ci;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`ID1`, `ID2`) VALUES
('long', 'admin'),
('long', 'guest'),
('long', 'thanh'),
('thanh', 'long'),
('long', 'yuuyenne'),
('Admin', 'yuuyenne'),
('yuuyenne', 'd'),
('yuuyenne', 'Long'),
('yuuyenne', 'thanh'),
('yuuyenne', 'Admin'),
('Admin', 'Long');

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

DROP TABLE IF EXISTS `reset_passwords`;
CREATE TABLE IF NOT EXISTS `reset_passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `used` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
