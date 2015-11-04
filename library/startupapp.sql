-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2015 at 05:35 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `startupapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `childcomment`
--

CREATE TABLE IF NOT EXISTS `childcomment` (
  `parent_comment_id` int(11) NOT NULL,
  `child_comment_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_comment_id`,`child_comment_id`),
  KEY `child_comment_id` (`child_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `email` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`email`, `date_created`, `comment_id`, `comment`, `thread_id`) VALUES
('r_limanto@hotmail.com', '0000-00-00 00:00:00', 1, 'Kenapa ya?', 1);

-- --------------------------------------------------------

--
-- Table structure for table `debate`
--

CREATE TABLE IF NOT EXISTS `debate` (
  `number_of_no` int(11) NOT NULL DEFAULT '0',
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debate`
--

INSERT INTO `debate` (`number_of_no`, `thread_id`) VALUES
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `debate_user`
--

CREATE TABLE IF NOT EXISTS `debate_user` (
  `thread_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `yes_no` tinyint(1) NOT NULL,
  PRIMARY KEY (`thread_id`,`email`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debate_user`
--

INSERT INTO `debate_user` (`thread_id`, `email`, `yes_no`) VALUES
(1, 'r_limanto@hotmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `forgot_code`
--

CREATE TABLE IF NOT EXISTS `forgot_code` (
  `email` varchar(255) NOT NULL,
  `temporary_password` varchar(255) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `petition`
--

CREATE TABLE IF NOT EXISTS `petition` (
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `petition_user`
--

CREATE TABLE IF NOT EXISTS `petition_user` (
  `thread_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`thread_id`,`email`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `polling`
--

CREATE TABLE IF NOT EXISTS `polling` (
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `polling_choices`
--

CREATE TABLE IF NOT EXISTS `polling_choices` (
  `choice_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`choice_id`,`thread_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `name` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`name`, `thread_id`, `photo`, `date_created`, `user_email`) VALUES
('Why indonesia has 17600 islands', 1, NULL, '2015-10-29 00:00:00', 'r_limanto@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `total_dislike` int(11) NOT NULL DEFAULT '0',
  `total_like` int(11) NOT NULL DEFAULT '0',
  `yellow_card` tinyint(1) NOT NULL DEFAULT '0',
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `first_name`, `last_name`, `password`, `birthday`, `total_dislike`, `total_like`, `yellow_card`, `validated`, `username`) VALUES
('benedita.tan@gmail.com', 'Benedita', 'Tanabi', '81dc9bdb52d04dc20036dbd8313ed055', '1995-11-14', 0, 0, 0, 0, 'benedita95'),
('r_limanto@hotmail.com', 'Robert', 'Limanto', 'e155e1bb4a9c38e3baf90637ab7865df', '1995-04-13', 0, 0, 0, 1, 'robert589');

-- --------------------------------------------------------

--
-- Table structure for table `validation_code`
--

CREATE TABLE IF NOT EXISTS `validation_code` (
  `useremail` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`useremail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validation_code`
--

INSERT INTO `validation_code` (`useremail`, `code`) VALUES
('r_limanto@hotmail.com', '9050834091dd7e3d728544c018df0a7e');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forgot_code`
--
ALTER TABLE `forgot_code`
  ADD CONSTRAINT `forgot_code_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `validation_code`
--
ALTER TABLE `validation_code`
  ADD CONSTRAINT `validation_code_ibfk_1` FOREIGN KEY (`useremail`) REFERENCES `user` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
