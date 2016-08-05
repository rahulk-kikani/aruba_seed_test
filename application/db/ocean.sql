-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2016 at 02:03 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ocean`
--

-- --------------------------------------------------------

--
-- Table structure for table `boat`
--

CREATE TABLE IF NOT EXISTS `boat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `color` enum('BLUE','NAVY_BLUE','GREEN','RED','PURPLE','WHITE','BLACK','YELLOW') NOT NULL DEFAULT 'BLUE',
  `last_student_change` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `boat`
--

INSERT INTO `boat` (`id`, `name`, `price`, `color`, `last_student_change`) VALUES
(1, 'The Black Pearl', 100000, 'BLUE', NULL),
(2, 'Aquaholic', 1000000, 'RED', NULL),
(4, 'Yamaha 242 Limited S', 120000, 'GREEN', NULL),
(5, 'Formula 290', 100000000, 'NAVY_BLUE', NULL),
(3, 'The Santa Maria', 20000, 'PURPLE', NULL),
(8, 'Testing Boat', 1000, 'GREEN', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boat_has_book`
--

CREATE TABLE IF NOT EXISTS `boat_has_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_boat` int(11) DEFAULT NULL,
  `id_book` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `boat_has_book`
--

INSERT INTO `boat_has_book` (`id`, `id_boat`, `id_book`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(4, 4, 1),
(5, 4, 2),
(6, 4, 3),
(7, 4, 4),
(8, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `boat_has_skipair`
--

CREATE TABLE IF NOT EXISTS `boat_has_skipair` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_boat` int(11) DEFAULT NULL,
  `id_student_skipair1` int(11) DEFAULT NULL,
  `id_student_skipair2` int(11) DEFAULT NULL,
  `id_student_skipair3` int(11) DEFAULT NULL,
  `id_student_skipair4` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `boat_has_skipair`
--

INSERT INTO `boat_has_skipair` (`id`, `id_boat`, `id_student_skipair1`, `id_student_skipair2`, `id_student_skipair3`, `id_student_skipair4`) VALUES
(1, 1, 1, 2, NULL, NULL),
(2, 5, 4, 5, 6, 7),
(3, 4, 9, NULL, NULL, NULL),
(4, 2, 3, NULL, NULL, NULL),
(5, 3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boat_has_student`
--

CREATE TABLE IF NOT EXISTS `boat_has_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_boat` int(11) DEFAULT NULL,
  `id_student` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `boat_has_student`
--

INSERT INTO `boat_has_student` (`id`, `id_boat`, `id_student`) VALUES
(22, 1, 2),
(3, 1, 11),
(4, 1, 12),
(16, 3, 13),
(6, 2, 17),
(7, 2, 14),
(8, 2, 16),
(9, 5, 4),
(10, 5, 5),
(11, 5, 6),
(12, 5, 7),
(13, 5, 15),
(14, 4, 9),
(15, 4, 18),
(17, 2, 3),
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url_on_amazon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `url_on_amazon`) VALUES
(1, 'How to Win Friends and Influence People', 'https://www.amazon.ca/How-Win-Friends-Influence-People/dp/0671027034'),
(2, 'Think and Grow Rich', 'https://www.amazon.ca/Think-Grow-Rich-Napoleon-Hill/dp/149617545X/'),
(3, 'The Magic Of Thinking Big', 'https://www.amazon.ca/Magic-Thinking-Big-David-Schwartz/dp/0671646788/'),
(4, 'The Compound Effect', 'https://www.amazon.ca/Compound-Effect-Darren-Hardy/dp/159315724X/');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(70) DEFAULT NULL,
  `last_name` varchar(70) DEFAULT NULL,
  `has_skipair` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `has_skipair`) VALUES
(1, 'Test 1', 'Ski', 1),
(2, 'Test 2', 'Ski', 1),
(4, 'Test 4', 'Ski', 1),
(5, 'Test 5', 'Ski', 1),
(6, 'Test 6', 'Ski', 1),
(7, 'Test 7', 'Ski', 1),
(9, 'Test 9', 'Ski', 1),
(3, 'Test 3', 'Ski', 1),
(10, 'Test 10', 'Ski', 1),
(8, 'Test 8', 'Ski', 1),
(11, 'Test 11', 'NS', 0),
(12, 'Test 12', 'NS', 0),
(13, 'Test 13', 'NS', 0),
(14, 'Test 14', 'NS', 0),
(15, 'Test 15', 'NS', 0),
(16, 'Test 16', 'NS', 0),
(17, 'Test 17', 'NS', 0),
(18, 'Test 18', 'NS', 0),
(19, 'Test 19', 'NS', 0),
(20, 'Test 20', 'NS', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
