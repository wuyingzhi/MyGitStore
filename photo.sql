-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2015 at 08:20 AM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `photo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin_login`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`name`) VALUES
('Djibouti'),
('Dominica'),
('Dominican Republic'),
('East Timor'),
('Ecuador'),
('Egypt'),
('El Salvador'),
('Equatorial Guinea'),
('Eritrea'),
('Estonia'),
('Ethiopia'),
('Falkland Islands (Malvinas)'),
('Faroe Islands'),
('Fiji'),
('Finland'),
('France'),
('France Metropolitan'),
('French Guiana'),
('French Polynesia'),
('French Southern Territories'),
('Gabon'),
('Gambia'),
('Georgia'),
('Germany'),
('Ghana'),
('Gibraltar'),
('Greece'),
('Greenland'),
('Grenada'),
('Guadeloupe'),
('Guam'),
('Guatemala'),
('Guinea'),
('Guinea-Bissau'),
('Guyana'),
('Haiti'),
('Heard McDonald Islands'),
('Honduras'),
('Hong Kong'),
('Hungary'),
('Iceland'),
('India'),
('Indonesia'),
('Iraq'),
('Ireland'),
('Islamic Republic of Iran'),
('Isle of Man'),
('Israel'),
('Italy'),
('Jamaica'),
('Japan'),
('Jordan'),
('Kazakhstan'),
('Kenya'),
('Kiribati'),
('Korea Democratic People''s Republic of'),
('Korea, Republic of'),
('Kuwait'),
('Kyrgyzstan'),
('Lao People''s Democratic Republic'),
('Latvia'),
('Lebanon'),
('Lesotho'),
('Liberia'),
('Libya'),
('Liechtenstein'),
('Lithuania'),
('Luxembourg'),
('Macau'),
('Macedonia, Republic of'),
('Madagascar'),
('Malawi'),
('Malaysia'),
('Maldives'),
('Mali'),
('Malta'),
('Marshall Islands'),
('Martinique'),
('Mauritania'),
('Mauritius'),
('Mayotte'),
('Mexico'),
('Micronesia'),
('Moldova'),
('Monaco'),
('Mongolia'),
('Monserrat'),
('Morocco'),
('Mozambique'),
('Myanmar'),
('Namibia'),
('Nauru'),
('Nepal'),
('Netherlands'),
('Netherlands Antilles'),
('New Caledonia'),
('New Zealand'),
('Nicaragua'),
('Niger'),
('Nigeria'),
('Niue'),
('Norfolk Island'),
('Northern Mariana Islands'),
('Norway'),
('Oman'),
('Pakistan'),
('Palau'),
('Panama'),
('Papua New Guinea'),
('Paraguay'),
('Peru'),
('Philippines'),
('Pitcairn'),
('Poland'),
('Portugal'),
('Puerto Rico'),
('Qatar'),
('Reunion'),
('Romania'),
('Russian Federation'),
('Rwanda'),
('Saint Lucia'),
('Saipan'),
('Samoa'),
('San Marino'),
('Sao Tome Principe'),
('Saudi Arabia'),
('Senegal'),
('Seychelles'),
('Sierra Leone'),
('Singapore'),
('Slovakia'),
('Slovenia'),
('Solomon Islands'),
('Somalia'),
('South Africa'),
('Spain'),
('Sri Lanka'),
('St. Helena'),
('St. Kitts and Nevis'),
('St. Pierre Miquelon'),
('St. Vincent the Grenadines'),
('Sudan'),
('Suriname'),
('Svalbard Jan Mayen Islands'),
('Swaziland'),
('Sweden'),
('Switzerland'),
('Syrian Arab Republic'),
('Taiwan'),
('Tajikistan'),
('Tanzania, United Republic of'),
('Thailand'),
('Togo'),
('Tokelau'),
('Tonga'),
('TrinidadTobago'),
('Tunisia'),
('Turkey'),
('Turkmenistan'),
('Turks Caicos Islands'),
('Tuvalu'),
('Uganda'),
('Ukraine'),
('United Arab Emirates'),
('United Kingdom (Great Britain)'),
('United States'),
('United States Minor Outlying Islands'),
('United States Virgin Islands'),
('Uruguay'),
('Uzbekistan'),
('Vanuatu'),
('Vatican City State (Holy See)'),
('Venezuela'),
('Viet Nam'),
('Wallis Futuna Islands'),
('Western Sahara'),
('Yemen'),
('Yugoslavia'),
('Zaire'),
('Zambia'),
('Zimbabwe'),
('Other');

-- --------------------------------------------------------

--
-- Table structure for table `groupmenurights`
--

CREATE TABLE IF NOT EXISTS `groupmenurights` (
  `groupid` int(5) NOT NULL DEFAULT '0',
  `menuid` int(5) NOT NULL DEFAULT '0',
  `position` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `groupmenurights`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(5) NOT NULL DEFAULT '0',
  `name` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `status` enum('Yes','No') CHARACTER SET latin1 NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `groupsubmenurights`
--

CREATE TABLE IF NOT EXISTS `groupsubmenurights` (
  `groupid` int(5) NOT NULL DEFAULT '0',
  `menuid` int(5) NOT NULL DEFAULT '0',
  `submenuid` int(5) NOT NULL DEFAULT '0',
  `position` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `groupsubmenurights`
--


-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `price` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `image` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `status` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=100076 ;

--
-- Dumping data for table `items`
--


-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `link` varchar(60) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `menus`
--


-- --------------------------------------------------------

--
-- Table structure for table `picures`
--

CREATE TABLE IF NOT EXISTS `picures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` varchar(225) NOT NULL,
  `url` text NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `picures`
--

INSERT INTO `picures` (`id`, `photo_id`, `name`, `date`, `url`, `memo`) VALUES
(47, 49, 'image3', '02-09-15', 'images.jpg', 'image3'),
(50, 49, 'image', '02-09-15', 'images.jpg', 'image'),
(52, 50, 'picture2', '02-09-15', 'IMG_4019.JPG', 'picture2'),
(53, 50, 'picture3', '02-09-15', 'images (1).jpg', 'picture');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(100) NOT NULL AUTO_INCREMENT,
  `post_title` text NOT NULL,
  `post_date` varchar(55) NOT NULL,
  `post_author` text NOT NULL,
  `post_image` text NOT NULL,
  `post_keywords` text NOT NULL,
  `post_content` text NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_date`, `post_author`, `post_image`, `post_keywords`, `post_content`) VALUES
(43, 'man1', '02-09-15', '', 'download.jpg', '', 'i am expert developer'),
(44, 'man2', '02-09-15', '', 't44h.jpg', '', 'i am man2'),
(45, 'man3', '02-09-15', '', 'th (2).jpg', '', 'i am man3'),
(46, 'man4', '02-09-15', '', 'th (3).jpg', '', 'i am man4'),
(48, 'man6', '02-09-15', '', 'th (11).jpg', '', 'i am man6'),
(50, 'picture1', '02-09-15', '', 'IMG_4019.JPG', '', 'picture1');

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE IF NOT EXISTS `submenus` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `menuid` int(5) NOT NULL DEFAULT '0',
  `name` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `link` varchar(60) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=56 ;

--
-- Dumping data for table `submenus`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `groupid` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `loginid` varchar(75) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `firstname` varchar(75) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `lastname` varchar(75) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `pwd` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `emailpass` varchar(20) CHARACTER SET latin1 NOT NULL,
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('Yes','No') CHARACTER SET latin1 NOT NULL DEFAULT 'Yes',
  `master` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`userid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=100005 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `groupid`, `loginid`, `firstname`, `lastname`, `pwd`, `email`, `emailpass`, `lastlogin`, `status`, `master`) VALUES
(100000, '', 'alanbolsh', 'alan', 'bolsh', 'password', 'alanbolsh@hotmail.com', '', '2015-02-08 23:10:19', 'Yes', 'No');
