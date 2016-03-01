-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2016 at 01:09 PM
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
-- Table structure for table `child_comment`
--

CREATE TABLE IF NOT EXISTS `child_comment` (
  `comment_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child_comment`
--

INSERT INTO `child_comment` (`comment_id`, `parent_id`) VALUES
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(18, 1),
(23, 1),
(24, 1),
(16, 2),
(19, 2),
(4, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(17, 3),
(11, 5),
(20, 6),
(22, 21),
(26, 25),
(33, 32),
(44, 35),
(45, 35),
(46, 35),
(47, 35),
(57, 35),
(58, 35),
(59, 35),
(60, 35),
(43, 39),
(48, 39),
(49, 39),
(55, 39),
(56, 39),
(50, 40);

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE IF NOT EXISTS `choice` (
  `choice_text` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `choice_status` smallint(6) NOT NULL DEFAULT '10',
  PRIMARY KEY (`choice_text`,`thread_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `choice`
--

INSERT INTO `choice` (`choice_text`, `thread_id`, `choice_status`) VALUES
('Aggree', 23, 10),
('Agree', 19, 10),
('Agree', 20, 10),
('Agree', 25, 10),
('Agree', 26, 10),
('Agree', 27, 10),
('Agree', 28, 10),
('Agree', 29, 10),
('Agree', 30, 10),
('Agree', 31, 10),
('Agree', 32, 10),
('Agree', 33, 10),
('Agree', 34, 10),
('Agree', 41, 10),
('Agree', 42, 10),
('Agree', 43, 10),
('Agree', 44, 10),
('Agree', 45, 10),
('Agree', 46, 10),
('Agree', 47, 10),
('Agree', 48, 10),
('Agree', 49, 10),
('Agree', 50, 10),
('Agree', 51, 10),
('Agree', 52, 10),
('Agree', 53, 10),
('Agree', 54, 10),
('Agree', 55, 10),
('Agree', 56, 10),
('Agree', 57, 10),
('Agree', 58, 10),
('Agree', 59, 10),
('Apple', 60, 10),
('Apple', 61, 10),
('Disagree', 19, 10),
('Disagree', 25, 10),
('Disagree', 26, 10),
('Disagree', 27, 10),
('Disagree', 28, 10),
('Disagree', 29, 10),
('Disagree', 30, 10),
('Disagree', 31, 10),
('Disagree', 32, 10),
('Disagree', 33, 10),
('Disagree', 34, 10),
('Disagree', 41, 10),
('Disagree', 42, 10),
('Disagree', 43, 10),
('Disagree', 44, 10),
('Disagree', 45, 10),
('Disagree', 46, 10),
('Disagree', 47, 10),
('Disagree', 48, 10),
('Disagree', 49, 10),
('Disagree', 50, 10),
('Disagree', 51, 10),
('Disagree', 52, 10),
('Disagree', 53, 10),
('Disagree', 54, 10),
('Disagree', 55, 10),
('Disagree', 56, 10),
('Disagree', 57, 10),
('Disagree', 58, 10),
('Disagree', 59, 10),
('Neutral', 19, 10),
('Neutral', 41, 10),
('Neutral', 42, 10),
('Neutral', 43, 10),
('Neutral', 44, 10),
('Neutral', 45, 10),
('Neutral', 46, 10),
('Neutral', 47, 10),
('Neutral', 48, 10),
('Neutral', 49, 10),
('Neutral', 50, 10),
('Neutral', 51, 10),
('Neutral', 52, 10),
('Neutral', 53, 10),
('Neutral', 54, 10),
('Neutral', 55, 10),
('Neutral', 56, 10),
('Neutral', 57, 10),
('Neutral', 58, 10),
('Neutral', 59, 10),
('Samsung', 60, 10),
('Samsung', 61, 10);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `comment_status` smallint(6) NOT NULL DEFAULT '10',
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `date_created`, `comment`, `updated_at`, `comment_status`) VALUES
(1, 1, '2016-02-09 23:34:30', 'I think he is stupid and incapable, we shall kick him out as a president', NULL, 10),
(2, 2, '2016-02-09 23:36:24', 'Yeah, he is incapable and a doll of megawati, kick him OUT!!', NULL, 10),
(3, 3, '2016-02-09 23:39:05', 'Shut the fuck up for those of you who disagree. You become president then understand how hard it is', NULL, 10),
(4, 1, '2016-02-11 01:49:38', 'Jokowi is an asshole', NULL, 10),
(5, 1, '2016-02-11 01:49:47', 'Jokowi is an asshole', NULL, 10),
(6, 1, '2016-02-11 01:51:33', 'Hi Everyone, does it really matter to comment about this?', NULL, 10),
(7, 2, '2016-02-11 15:06:01', 'Stop ignoring the fact that he is megawati''s doll', NULL, 10),
(8, 1, '2016-02-12 00:52:21', 'sasasa\r\n', NULL, 10),
(9, 1, '2016-02-12 00:55:54', 'sasasa\r\n', NULL, 10),
(10, 1, '2016-02-12 00:56:05', 'sasasa\r\n', NULL, 10),
(11, 1, '2016-02-12 00:56:37', 'sasasa\r\n', NULL, 10),
(12, 1, '2016-02-12 00:56:55', 'sasas\r\n', NULL, 10),
(13, 1, '2016-02-12 00:57:02', 'sasas\r\n', NULL, 10),
(14, 1, '2016-02-12 00:57:39', 'sasas\r\n\r\n', NULL, 10),
(15, 1, '2016-02-12 01:01:06', 'sasasasasa\r\n', NULL, 10),
(16, 1, '2016-02-12 01:01:29', 'sasasa\r\n', NULL, 10),
(17, 1, '2016-02-12 01:03:57', 'submit comment success la\r\n', NULL, 10),
(18, 1, '2016-02-12 01:04:37', 'kali ini sukses\r\n', NULL, 10),
(19, 1, '2016-02-12 01:08:13', 'hi everybody\r\n', NULL, 10),
(20, 1, '2016-02-12 01:08:55', 'halo body', NULL, 10),
(21, 1, '2016-02-12 01:49:11', 'I agree', NULL, 10),
(22, 1, '2016-02-12 20:06:05', 'halo', NULL, 10),
(23, 1, '2016-02-12 20:06:18', 'njing', NULL, 10),
(24, 1, '2016-02-12 20:06:46', 'hi', NULL, 10),
(25, 1, '2016-02-16 22:23:27', 'I disagreee, Apple probably is more expensive, but apple has better quality?', NULL, 10),
(26, 1, '2016-02-16 22:23:42', 'Well, what kind of quality you mean?', NULL, 10),
(27, 1, '2016-02-16 23:22:49', 'Well, I agree definitely', NULL, 10),
(28, 1, '2016-02-16 23:22:59', 'I disagree ', NULL, 10),
(29, 1, '2016-02-16 23:27:29', 'Well, I agree because bal3x', NULL, 10),
(30, 1, '2016-02-16 23:27:43', 'Well, I disagreee because bla3x', NULL, 10),
(31, 4, '2016-02-16 23:55:42', 'Apple is more responsive than Samsung, i have used apple for more than 3 years and i have no problem with that', NULL, 10),
(32, 5, '2016-02-16 23:57:36', 'It is matter of design and price. Apple has better design compared to Samsung. But Samsung iis much better in terms of price', NULL, 10),
(33, 1, '2016-02-17 00:00:38', 'It seems like you prefer Apple than Samsung', NULL, 10),
(34, 1, '2016-02-21 20:46:56', 'I agree', NULL, 10),
(35, 1, '2016-02-22 08:28:39', 'Sansung is the best', NULL, 10),
(36, 1, '2016-02-22 08:28:59', 'Apple is the best', NULL, 10),
(37, 1, '2016-02-22 12:06:47', 'I agree', NULL, 10),
(38, 1, '2016-02-22 12:07:02', 'I disagree', NULL, 10),
(39, 1, '2016-02-22 19:14:44', 'I agree', NULL, 10),
(40, 1, '2016-02-23 16:43:24', 'Hi, peter', NULL, 10),
(41, 1, '2016-02-23 16:43:24', 'Hi, peter', NULL, 10),
(42, 1, '2016-02-23 17:24:56', '<p><img src="/startup/frontend/web/photos/1/8485ae387a-1275483513322016734724381131740394o-1.jpg" style="line-height: 1.6em; color: rgb(51, 51, 51);"></p>', NULL, 10),
(43, 1, '2016-02-25 09:36:07', 'Hello', NULL, 10),
(44, 1, '2016-02-25 19:30:10', 'halo', NULL, 10),
(45, 1, '2016-02-25 19:30:10', 'halo', NULL, 10),
(46, 1, '2016-02-25 19:30:16', 'halo', NULL, 10),
(47, 1, '2016-02-25 19:30:16', 'halo', NULL, 10),
(48, 6, '2016-02-25 21:48:06', 'ini jg', NULL, 10),
(49, 1, '2016-02-26 11:06:43', 'hi', NULL, 10),
(50, 1, '2016-02-26 11:06:54', 'hi', NULL, 10),
(51, 6, '2016-02-26 20:49:52', '<p>i comment here</p>', NULL, 10),
(52, 6, '2016-02-26 20:50:26', '<p>i comment here</p>', NULL, 10),
(53, 6, '2016-02-26 20:52:13', '<p>i comment here</p>', NULL, 10),
(54, 6, '2016-02-26 20:52:37', '<p>i comment here</p>', NULL, 10),
(55, 6, '2016-02-26 21:35:45', 'halo', NULL, 10),
(56, 6, '2016-02-26 21:35:45', 'halo', NULL, 10),
(57, 6, '2016-02-26 21:36:27', 'halo', NULL, 10),
(58, 6, '2016-02-26 21:36:27', 'halo', NULL, 10),
(59, 6, '2016-02-26 21:37:49', 'halo', NULL, 10),
(60, 6, '2016-02-26 21:37:49', 'halo', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `comment_vote`
--

CREATE TABLE IF NOT EXISTS `comment_vote` (
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `vote` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`comment_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_vote`
--

INSERT INTO `comment_vote` (`user_id`, `comment_id`, `vote`, `date_created`) VALUES
(1, 1, -1, '2016-02-12 16:52:52'),
(1, 2, 1, '2016-02-12 18:28:08'),
(1, 3, -1, '2016-02-12 16:17:59'),
(1, 4, -1, '2016-02-12 19:57:16'),
(1, 5, -1, '2016-02-12 19:15:08'),
(1, 6, 1, '2016-02-12 19:46:27'),
(1, 8, 1, '2016-02-12 19:58:26'),
(1, 9, 1, '2016-02-12 19:57:55'),
(1, 11, -1, '2016-02-12 20:02:31'),
(1, 12, -1, '2016-02-12 20:00:28'),
(1, 13, 1, '2016-02-12 20:04:13'),
(1, 14, 1, '2016-02-12 20:04:16'),
(1, 15, 1, '2016-02-12 20:03:59'),
(1, 16, -1, '2016-02-12 20:01:59'),
(1, 18, 1, '2016-02-12 20:02:56'),
(1, 19, 1, '2016-02-12 20:01:23'),
(1, 20, 1, '2016-02-12 20:05:05'),
(1, 21, -1, '2016-02-12 20:05:55'),
(1, 22, 1, '2016-02-12 20:06:07'),
(1, 28, 1, '2016-02-17 18:17:14'),
(1, 29, -1, '2016-02-16 23:27:31'),
(1, 32, -1, '2016-02-17 00:00:44'),
(1, 34, 1, '2016-02-26 21:41:11'),
(1, 36, 1, '2016-02-22 08:29:05'),
(1, 39, 1, '2016-02-23 14:59:52'),
(1, 40, 1, '2016-02-25 21:12:35'),
(1, 41, -1, '2016-02-26 21:49:21'),
(2, 3, 1, '2016-02-12 16:17:59'),
(3, 3, -1, '2016-02-10 00:24:07'),
(4, 27, -1, '2016-02-16 23:55:56'),
(4, 31, 1, '2016-02-16 23:55:45'),
(5, 32, 1, '2016-02-16 23:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `follower_relation`
--

CREATE TABLE IF NOT EXISTS `follower_relation` (
  `follower_id` int(11) NOT NULL,
  `followee_id` int(11) NOT NULL,
  PRIMARY KEY (`follower_id`,`followee_id`),
  KEY `followee_id` (`followee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follower_relation`
--

INSERT INTO `follower_relation` (`follower_id`, `followee_id`) VALUES
(6, 1),
(1, 2),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1450193404),
('m130524_201442_init', 1450193545);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`description`,`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`user_id`, `description`, `date_created`) VALUES
(1, '<a data-pjax=0 href=''/startUp/profile/index?username=ROBERT123''>Robert Limanto</a> commented on your comment', '2016-02-26 13:37:49'),
(1, '<a data-pjax=0 href=''/startUp/profile/index?username=ROBERT123''>Robert Limanto</a> commented on your thread', '2016-02-26 12:49:52'),
(1, '<a data-pjax=0 href=''/startUp/profile/index?username=ROBERT123''>Robert Limanto</a> commented on your thread', '2016-02-26 12:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` char(255) NOT NULL,
  `tag_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`),
  KEY `tag_name` (`tag_name`),
  KEY `tag_name_2` (`tag_name`),
  KEY `tag_name_3` (`tag_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`, `tag_description`, `created_at`) VALUES
(1, 'Economy', '', '2016-03-01 12:06:56'),
(2, 'Politic', '', '2016-03-01 12:06:56'),
(3, 'Education', '', '2016-03-01 12:07:22'),
(4, 'Computer Science', '', '2016-03-01 12:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `anonymous` tinyint(1) DEFAULT '0',
  `thread_status` smallint(6) NOT NULL DEFAULT '10',
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'GENERAL',
  PRIMARY KEY (`thread_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `user_id`, `title`, `date_created`, `anonymous`, `thread_status`, `description`, `type`) VALUES
(19, 1, 'Does jokowi performance favourable to many indonesian?', '2016-02-06 21:43:13', 1, 10, 'He is not good, such a disappointment, he should choose me to be the ministry', 'GENERAL'),
(20, 1, 'sadsg;flkdsmnfdsm mdslmfd bnfmsl', '2016-02-06 21:43:33', 1, 10, '<p>dsl;samnkasdlmf dmlk;m vdmss</p>\r\n', 'GENERAL'),
(21, 1, 'sadsg;flkdsmnfdsm mdslmfd bnfmsl', '2016-02-06 21:44:11', 1, 10, '<p>dsl;samnkasdlmf dmlk;m vdmss</p>\r\n', 'GENERAL'),
(22, 1, 'sadsg;flkdsmnfdsm mdslmfd bnfmsl', '2016-02-06 21:44:28', 1, 10, '<p>dsl;samnkasdlmf dmlk;m vdmss</p>\r\n', 'GENERAL'),
(23, 1, 'e;jlwk', '2016-02-06 21:46:42', 1, 10, '<p>ladkdsakd</p>\r\n', 'GENERAL'),
(24, 1, 'e;jlwk', '2016-02-06 21:48:59', 1, 10, '<p>ladkdsakd</p>\r\n', 'GENERAL'),
(25, 1, 'Hello', '2016-02-06 21:56:35', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(26, 1, 'Hello', '2016-02-06 21:58:42', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(27, 1, 'Hello', '2016-02-06 21:59:14', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(28, 1, 'Hello', '2016-02-06 21:59:25', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(29, 1, 'Hello', '2016-02-06 22:05:43', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(30, 1, 'Hello', '2016-02-06 22:06:27', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(31, 1, 'Hello', '2016-02-06 22:06:35', 1, 10, '<p>Hello</p>\r\n', 'GENERAL'),
(32, 1, ';FESLSKdsnks;ladsfnlkda', '2016-02-06 22:07:19', 1, 10, '<p>sljfdlsjljfldjfds</p>\r\n', 'GENERAL'),
(33, 1, ';FESLSKdsnks;ladsfnlkda', '2016-02-06 22:08:17', 0, 10, '<p>sljfdlsjljfldjfds</p>\r\n', 'GENERAL'),
(34, 1, ';FESLSKdsnks;ladsfnlkda', '2016-02-06 22:08:50', 0, 10, '<p>sljfdlsjljfldjfds</p>\r\n', 'GENERAL'),
(36, 1, 'asdas;dj', '2016-02-06 22:12:03', 0, 10, '<p>dkaljd</p>\r\n', 'GENERAL'),
(37, 1, 'asd;flkaksd', '2016-02-06 22:15:18', 0, 10, '<p>s;fdlksf;dskf;sf;ls</p>\r\n', 'GENERAL'),
(38, 1, 'sfdjal;da;l', '2016-02-07 00:00:07', 1, 10, '<p>;ldsfk;dfkal;kl;ak;a</p>\r\n', 'GENERAL'),
(39, 1, 'adsdc;', '2016-02-07 00:01:50', 0, 10, '<p>alkjaklkd</p>\r\n', 'GENERAL'),
(40, 1, 'Is samsung better than apple?', '2016-02-16 01:22:06', 1, 10, 'sakjdajdlka', 'GENERAL'),
(41, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 22:22:40', 0, 10, 'Well, Samsung is much better than Apple especially for the cost and price', 'GENERAL'),
(42, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 23:14:10', 0, 10, 'Well, i think Samsung is better than apple because it has cheaper price and better quality', 'GENERAL'),
(43, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 23:15:29', 0, 10, 'Well, I think Samsung is better than  Apple because it has cheaper price and better quality', 'GENERAL'),
(44, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 23:20:15', 0, 10, 'Well, I think samsung is much better than apple because it has cheaper price and better quality', 'GENERAL'),
(45, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 23:22:31', 0, 10, 'Well, Samsung is much better than Apple because it has better qualities and cheaper price', 'GENERAL'),
(46, 1, 'Do you agree Samsung is better than Apple?', '2016-02-16 23:27:08', 0, 10, 'Well, I think Samsung is better than Apple because it has cheaper price and better qualities.', 'GENERAL'),
(47, 1, 'Is samsung better than apple?', '2016-02-20 18:28:51', 1, 10, 'Halo', 'GENERAL'),
(48, 1, 'Is yii2 better framework that yii1', '2016-02-20 18:33:22', 0, 10, 'Better Framework or not', 'GENERAL'),
(49, 1, 'Yii framework sucks', '2016-02-20 20:22:52', 0, 10, '<p><img src="/startup/frontend/web/photos/1/42c8938e4c-untitled.png"></p>', 'GENERAL'),
(50, 1, 'title', '2016-02-20 20:25:13', 0, 10, '<p><img src="/startup/frontend/web/photos/1/e259d9d7a8-serveroutlineclipart9282.jpg" style="line-height: 1.6em; color: rgb(51, 51, 51);"></p>', 'GENERAL'),
(51, 1, 'title', '2016-02-20 20:25:25', 0, 10, '<p><img src="/startup/frontend/web/photos/1/e259d9d7a8-serveroutlineclipart9282.jpg" style="line-height: 1.6em; color: rgb(51, 51, 51);"></p>', 'GENERAL'),
(52, 1, 'You dont chibai', '2016-02-20 20:28:54', 0, 10, '<p><img src="/startup/frontend/web/photos/1/0dfd8a39e2-childrenorphanchild220496.jpg"></p>', 'GENERAL'),
(53, 1, 'You dont chibai', '2016-02-20 20:29:20', 0, 10, '<p><img src="/startup/frontend/web/photos/1/0dfd8a39e2-childrenorphanchild220496.jpg"></p>', 'GENERAL'),
(54, 1, 'You dont chibai', '2016-02-20 20:29:29', 0, 10, '<p><img src="/startup/frontend/web/photos/1/0dfd8a39e2-childrenorphanchild220496.jpg"></p>', 'GENERAL'),
(55, 1, 'I dont like you', '2016-02-20 20:32:33', 0, 10, '<p><img src="/startup/frontend/web/photos/1/dace0df7d1-untitled.png"></p><p><img src="/startup/frontend/web/photos/1/517cd23ae4-stock-photo-18988909-obama-announces-details-of-75-billion-mortgage-relief-plan.jpg"></p>', 'GENERAL'),
(56, 1, 'sadakjdklajdsa', '2016-02-20 22:21:41', 0, 10, '<p><img src="/startup/frontend/web/photos/1/7b5ad0c52e-untitled.png"></p>', 'GENERAL'),
(57, 1, 'Lorem ipsumm', '2016-02-21 19:39:20', 0, 10, '<p><img src="/startup/frontend/web/photos/1/a0dabc6f2a-1275483513322016734724381131740394o-1.jpg"></p><p><strong>orem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'GENERAL'),
(58, 1, 'Lorem ipsumm', '2016-02-21 19:42:23', 0, 10, '<p><br></p><p><strong>orem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'GENERAL'),
(59, 1, 'Lorem ipsumm', '2016-02-21 19:42:33', 0, 10, '<p><br></p><p><strong>orem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'GENERAL'),
(60, 1, 'Do you agree Samsung is better than Apple?', '2016-02-22 08:28:15', 0, 10, '<p>I think samsung is better than apple</p>', 'GENERAL'),
(61, 1, 'Do you agree?', '2016-02-22 11:39:30', 0, 10, '<p>I do not agree at all.<br></p>', 'GENERAL');

-- --------------------------------------------------------

--
-- Table structure for table `thread_comment`
--

CREATE TABLE IF NOT EXISTS `thread_comment` (
  `comment_id` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL,
  `thread_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `choice_text` (`choice_text`,`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread_comment`
--

INSERT INTO `thread_comment` (`comment_id`, `choice_text`, `thread_id`) VALUES
(3, 'Agree', 19),
(21, 'Agree', 19),
(51, 'Agree', 19),
(52, 'Agree', 19),
(53, 'Agree', 19),
(54, 'Agree', 19),
(37, 'Agree', 30),
(27, 'Agree', 45),
(29, 'Agree', 46),
(34, 'Agree', 59),
(36, 'Apple', 60),
(1, 'Disagree', 19),
(2, 'Disagree', 19),
(5, 'Disagree', 19),
(38, 'Disagree', 30),
(25, 'Disagree', 41),
(28, 'Disagree', 45),
(31, 'Disagree', 45),
(30, 'Disagree', 46),
(6, 'Neutral', 19),
(32, 'Neutral', 45),
(35, 'Samsung', 60),
(39, 'Samsung', 61),
(40, 'Samsung', 61),
(41, 'Samsung', 61),
(42, 'Samsung', 61);

-- --------------------------------------------------------

--
-- Table structure for table `thread_rate`
--

CREATE TABLE IF NOT EXISTS `thread_rate` (
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`thread_id`),
  KEY `thread_id` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread_rate`
--

INSERT INTO `thread_rate` (`user_id`, `thread_id`, `rate`) VALUES
(1, 19, 1),
(1, 30, 4),
(1, 48, 3),
(1, 55, 4),
(1, 56, 5),
(1, 58, 3),
(1, 60, 5),
(1, 61, 2),
(2, 19, 5),
(6, 41, 3),
(6, 61, 4);

-- --------------------------------------------------------

--
-- Table structure for table `thread_tag`
--

CREATE TABLE IF NOT EXISTS `thread_tag` (
  `thread_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thread_vote`
--

CREATE TABLE IF NOT EXISTS `thread_vote` (
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`thread_id`,`choice_text`),
  KEY `thread_id` (`thread_id`,`choice_text`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread_vote`
--

INSERT INTO `thread_vote` (`user_id`, `thread_id`, `choice_text`) VALUES
(1, 19, 'Agree'),
(2, 19, 'Agree'),
(3, 19, 'Agree'),
(6, 19, 'Neutral'),
(1, 30, 'Disagree'),
(1, 41, 'Disagree'),
(6, 41, 'Disagree'),
(1, 45, 'Agree'),
(4, 45, 'Disagree'),
(5, 45, 'Disagree'),
(1, 46, 'Agree'),
(1, 59, 'Disagree'),
(1, 60, 'Samsung'),
(1, 61, 'Samsung'),
(6, 61, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `photo_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `yellow_card` int(11) NOT NULL DEFAULT '0',
  `validated` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notif_last_seen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reputation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `photo_unique_id` (`photo_path`(1)),
  KEY `fk_per_photo` (`photo_path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`photo_path`, `id`, `username`, `birthday`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `yellow_card`, `validated`, `first_name`, `last_name`, `occupation`, `notif_last_seen`, `reputation`) VALUES
('1/56caf6429c4ec_1_1.jpg', 1, 'rlimanto001', '2016-01-14', 'hxdMcarG-NrXTO_GvV289jlMwzQQ78Mq', '$2y$13$LmMqYhHVaWuL9cdd13Rs/e8RvR7/mF9kLZgkHutom2b6xzOt9.2Mm', NULL, 'rlimanto001@gmail.com', 10, 1450683459, 1456496982, 0, 0, 'Rob', 'Limanto', 'Propose Founder', '2016-01-25 20:55:58', -2),
('default.png', 2, 'r_limanto', '0000-00-00', 'GaZMm1AlMwoZh6ttY4p5pSJDf-9Ssrcw', '$2y$13$11.qZW.ybZY8YCyV6JfRge7qGE6vfgPUr/IcUx5qXGmWYedgBpWUO', NULL, 'r_limanto@hotmail.com', 10, 1450683586, 1450683586, 0, 0, 'Trebor', 'otnamil', NULL, '2016-01-25 20:55:58', 0),
('default.png', 3, 'wjesslyn001', '0000-00-00', 'B0SG8wBAyDaCPyNiXqqa6v2jTjXOE_bv', '$2y$13$hOfwfIsgKfL38BRj4sVCxeHSUsM./mu6sAoDGXPhEV4ANtZXJM8VC', NULL, 'wjesslyn001@e.ntu.edu.sg', 10, 1450683645, 1456496980, 0, 0, 'Winnie', 'Jesslyn', 'Propose Cofounder', '2016-01-25 20:55:58', 0),
('default.png', 4, 'vinsen123', '0000-00-00', 'nYODIeJvrukX_yBUhIVEOUdg-n-LIYiM', '$2y$13$CCQrHxAuG0HZ9vzcPGXsZOxqAdVKvITuoYRyAVYjAzGpNHw6ZqOYe', NULL, 'vinsenmuliadi@gmail.com', 10, 1455638015, 1455638015, 0, 0, 'Vinsen', 'Muliadi', NULL, '2016-02-16 23:53:35', 0),
('default.png', 5, 'peter123', '0000-00-00', 'MQSAXKefnRRpVhVfSovFB1vc2nL0qltg', '$2y$13$n5Bf8uo4sfPJfNBOLQ1z5OHzkINS9wo9vxSI4sxKraixpd1Yq3BZC', NULL, 'peter@gmail.com', 10, 1455638037, 1455638037, 0, 0, 'Peter', 'Ciang', NULL, '2016-02-16 23:53:57', 0),
('default.png', 6, 'ROBERT123', '0000-00-00', 'Hwet6Qx4oAXYryxbM1HBgerRJ-JaOZAR', '$2y$13$BvLO.1E4VsXpZWtqo/DfeeVYpkdc2Fkl2tvBSXrYtcPwOPSmZW7JW', NULL, 'rlimanto001@ntu.edu.sg', 10, 1456333122, 1456333122, 0, 0, 'Robert', 'Limanto', NULL, '2016-02-25 00:58:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `validation_code`
--

CREATE TABLE IF NOT EXISTS `validation_code` (
  `user_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `child_comment`
--
ALTER TABLE `child_comment`
  ADD CONSTRAINT `child_comment_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `thread_comment` (`comment_id`);

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_vote`
--
ALTER TABLE `comment_vote`
  ADD CONSTRAINT `comment_vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_vote_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`);

--
-- Constraints for table `follower_relation`
--
ALTER TABLE `follower_relation`
  ADD CONSTRAINT `follower_relation_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follower_relation_ibfk_2` FOREIGN KEY (`followee_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_comment`
--
ALTER TABLE `thread_comment`
  ADD CONSTRAINT `thread_comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`),
  ADD CONSTRAINT `thread_comment_ibfk_2` FOREIGN KEY (`choice_text`, `thread_id`) REFERENCES `choice` (`choice_text`, `thread_id`);

--
-- Constraints for table `thread_rate`
--
ALTER TABLE `thread_rate`
  ADD CONSTRAINT `thread_rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `thread_rate_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);

--
-- Constraints for table `thread_vote`
--
ALTER TABLE `thread_vote`
  ADD CONSTRAINT `thread_vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `thread_vote_ibfk_2` FOREIGN KEY (`thread_id`, `choice_text`) REFERENCES `choice` (`thread_id`, `choice_text`);

--
-- Constraints for table `validation_code`
--
ALTER TABLE `validation_code`
  ADD CONSTRAINT `validation_code_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
