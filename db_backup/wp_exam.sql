-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2016 at 02:32 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wp_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` text NOT NULL,
  `correct` int(2) NOT NULL DEFAULT '0',
  `banned` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question`, `answer`, `correct`, `banned`) VALUES
(32, 16, 'hello world', 1, 0),
(31, 15, 'Answer 666666', 0, 1),
(30, 15, 'Answer 55555555', 0, 0),
(29, 15, 'Answer 4444444444', 0, 0),
(28, 15, 'Answer 33333333333', 0, 0),
(27, 15, 'Answer 22222222222', 1, 0),
(26, 15, 'Answer 1111111111', 1, 0),
(24, 13, '1', 1, 0),
(23, 12, 'Answer 444444444444', 0, 0),
(22, 12, 'Answer 33333333333333', 0, 0),
(21, 12, 'Answer 222222222222222', 1, 0),
(20, 12, 'Answer 1111111111111', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(10, 'Category 3', 'Demo resource category'),
(8, 'Category 2', 'Demo resource category'),
(9, 'Category 1', 'Demo resource category');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'Albania'),
(2, 0, 'Algeria'),
(3, 0, 'American Samoa'),
(4, 0, 'Andorra'),
(5, 0, 'Angola'),
(6, 0, 'Anguilla'),
(7, 0, 'Antigua'),
(8, 0, 'Antilles'),
(9, 0, 'Argentina'),
(10, 0, 'Armenia'),
(11, 0, 'Aruba'),
(12, 0, 'Australia'),
(13, 0, 'Austria'),
(14, 0, 'Azerbaijan'),
(15, 0, 'Azores'),
(16, 0, 'Bahamas'),
(17, 0, 'Bahrain'),
(18, 0, 'Bangladesh'),
(19, 0, 'Barbados'),
(20, 0, 'Barbuda'),
(21, 0, 'Belgium'),
(22, 0, 'Belize'),
(23, 0, 'Belorus'),
(24, 0, 'Benin'),
(25, 0, 'Bermuda'),
(26, 0, 'Bhutan'),
(27, 0, 'Bolivia'),
(28, 0, 'Bonaire'),
(29, 0, 'Bosnia &amp; Hercegovina'),
(30, 0, 'Botswana'),
(31, 0, 'Br. Virgin Islands'),
(32, 0, 'Brazil'),
(33, 0, 'Brunei'),
(34, 0, 'Bulgaria'),
(35, 0, 'Burkina Faso'),
(36, 0, 'Burundi'),
(37, 0, 'Caicos Island'),
(38, 0, 'Cameroon'),
(39, 0, 'Canada'),
(40, 0, 'Canary Islands'),
(41, 0, 'Cape Verde'),
(42, 0, 'Cayman Islands'),
(43, 0, 'Central African Republic'),
(44, 0, 'Chad'),
(45, 0, 'Channel Islands'),
(46, 0, 'Chile'),
(47, 0, 'China'),
(48, 0, 'Colombia'),
(50, 0, 'Congo'),
(51, 0, 'Cook Islands'),
(52, 0, 'Cooper Island'),
(53, 0, 'Costa Rica'),
(54, 0, 'Cote D&#39;Ivoire'),
(55, 0, 'Croatia'),
(56, 0, 'Curacao'),
(57, 0, 'Cyprus'),
(58, 0, 'Czech Republic'),
(59, 0, 'Denmark'),
(60, 0, 'Djibouti'),
(61, 0, 'Dominica'),
(62, 0, 'Dominican Republic'),
(63, 0, 'Ecuador'),
(64, 0, 'Egypt'),
(65, 0, 'El Salvador'),
(66, 0, 'England'),
(67, 0, 'Equatorial Guinea'),
(68, 0, 'Estonia'),
(69, 0, 'Ethiopia'),
(70, 0, 'Fiji'),
(71, 0, 'Finland'),
(72, 0, 'France'),
(73, 0, 'French Guiana'),
(74, 0, 'French Polynesia'),
(75, 0, 'Futuna Island'),
(76, 0, 'Gabon'),
(77, 0, 'Gambia'),
(78, 0, 'Georgia'),
(79, 0, 'Germany'),
(80, 0, 'Ghana'),
(81, 0, 'Gibraltar'),
(82, 0, 'Greece'),
(83, 0, 'Grenada'),
(84, 0, 'Grenland'),
(85, 0, 'Guadeloupe'),
(86, 0, 'Guam'),
(87, 0, 'Guatemala'),
(88, 0, 'Guinea'),
(89, 0, 'Guinea-Bissau'),
(90, 0, 'Guyana'),
(91, 0, 'Haiti'),
(92, 0, 'Holland'),
(93, 0, 'Honduras'),
(94, 0, 'Hong Kong'),
(95, 0, 'Hungary'),
(96, 0, 'Iceland'),
(97, 0, 'India'),
(98, 0, 'Indonesia'),
(99, 0, 'Iran'),
(100, 0, 'Iraq'),
(101, 0, 'Ireland, Northern'),
(102, 0, 'Ireland, Republic of'),
(103, 0, 'Isle of Man'),
(104, 0, 'Israel'),
(105, 0, 'Italy'),
(106, 0, 'Ivory Coast'),
(107, 0, 'Jamaica'),
(108, 0, 'Japan'),
(109, 0, 'Jordan'),
(110, 0, 'Jost Van Dyke Island'),
(111, 0, 'Kampuchea'),
(112, 0, 'Kazakhstan'),
(113, 0, 'Kenya'),
(114, 0, 'Kiribati'),
(115, 0, 'Korea'),
(116, 0, 'Korea, South'),
(117, 0, 'Kosrae'),
(118, 0, 'Kuwait'),
(119, 0, 'Kyrgyzstan'),
(120, 0, 'Laos'),
(121, 0, 'Latvia'),
(122, 0, 'Lebanon'),
(123, 0, 'Lesotho'),
(124, 0, 'Liberia'),
(125, 0, 'Liechtenstein'),
(126, 0, 'Lithuania'),
(127, 0, 'Luxembourg'),
(128, 0, 'Macau'),
(129, 0, 'Macedonia'),
(130, 0, 'Madagascar'),
(131, 0, 'Madeira Islands'),
(132, 0, 'Malagasy'),
(133, 0, 'Malawi'),
(134, 0, 'Malaysia'),
(135, 0, 'Maldives'),
(136, 0, 'Mali'),
(137, 0, 'Malta'),
(138, 0, 'Marshall Islands'),
(139, 0, 'Martinique'),
(140, 0, 'Mauritania'),
(141, 0, 'Mauritius'),
(142, 0, 'Mexico'),
(143, 0, 'Micronesia'),
(144, 0, 'Moldova'),
(145, 0, 'Monaco'),
(146, 0, 'Mongolia'),
(147, 0, 'Montenegro'),
(148, 0, 'Montserrat'),
(149, 0, 'Morocco'),
(150, 0, 'Mozambique'),
(151, 0, 'Myanmar'),
(152, 0, 'Namibia'),
(153, 0, 'Nauru'),
(154, 0, 'Nepal'),
(155, 0, 'Netherlands'),
(156, 0, 'Nevis'),
(157, 0, 'Nevis (St. Kitts)'),
(158, 0, 'New Caledonia'),
(159, 0, 'New Zealand'),
(160, 0, 'Nicaragua'),
(161, 0, 'Niger'),
(162, 0, 'Nigeria'),
(163, 0, 'Niue'),
(164, 0, 'Norfolk Island'),
(165, 0, 'Norman Island'),
(166, 0, 'Northern Mariana Island'),
(167, 0, 'Norway'),
(168, 0, 'Oman'),
(169, 0, 'Pakistan'),
(170, 0, 'Palau'),
(171, 0, 'Panama'),
(172, 0, 'Papua New Guinea'),
(173, 0, 'Paraguay'),
(174, 0, 'Peru'),
(175, 0, 'Philippines'),
(176, 0, 'Poland'),
(177, 0, 'Ponape'),
(178, 0, 'Portugal'),
(179, 0, 'Qatar'),
(180, 0, 'Reunion'),
(181, 0, 'Romania'),
(182, 0, 'Rota'),
(183, 0, 'Russia'),
(184, 0, 'Rwanda'),
(185, 0, 'Saba'),
(186, 0, 'Saipan'),
(187, 0, 'San Marino'),
(188, 0, 'Sao Tome'),
(189, 0, 'Saudi Arabia'),
(190, 0, 'Scotland'),
(191, 0, 'Senegal'),
(192, 0, 'Serbia'),
(193, 0, 'Seychelles'),
(194, 0, 'Sierra Leone'),
(195, 0, 'Singapore'),
(196, 0, 'Slovakia'),
(197, 0, 'Slovenia'),
(198, 0, 'Solomon Islands'),
(199, 0, 'Somalia'),
(200, 0, 'South Africa'),
(201, 0, 'Spain'),
(202, 0, 'Sri Lanka'),
(203, 0, 'St. Barthelemy'),
(204, 0, 'St. Christopher'),
(205, 0, 'St. Croix'),
(206, 0, 'St. Eustatius'),
(207, 0, 'St. John'),
(208, 0, 'St. Kitts'),
(209, 0, 'St. Lucia'),
(210, 0, 'St. Maarten'),
(211, 0, 'St. Martin'),
(212, 0, 'St. Thomas'),
(213, 0, 'St. Vincent'),
(214, 0, 'Sudan'),
(215, 0, 'Suriname'),
(216, 0, 'Swaziland'),
(217, 0, 'Sweden'),
(218, 0, 'Switzerland'),
(219, 0, 'Syria'),
(220, 0, 'Tahiti'),
(221, 0, 'Taiwan'),
(222, 0, 'Tajikistan'),
(223, 0, 'Tanzania'),
(224, 0, 'Thailand'),
(225, 0, 'Tinian'),
(226, 0, 'Togo'),
(227, 0, 'Tonaga'),
(228, 0, 'Tonga'),
(229, 0, 'Tortola'),
(230, 0, 'Trinidad and Tobago'),
(231, 0, 'Truk'),
(232, 0, 'Tunisia'),
(233, 0, 'Turkey'),
(234, 0, 'Turkmenistan'),
(235, 0, 'Turks and Caicos Island'),
(236, 0, 'Tuvalu'),
(237, 0, 'U.S. Virgin Islands'),
(238, 0, 'Uganda'),
(239, 0, 'Ukraine'),
(240, 0, 'Union Island'),
(241, 0, 'United Arab Emirates'),
(242, 0, 'United Kingdom'),
(243, 0, 'Uruguay'),
(244, 0, 'United States'),
(245, 0, 'Uzbekistan'),
(246, 0, 'Vanuatu'),
(247, 0, 'Vatican City'),
(248, 0, 'Venezuela'),
(249, 0, 'Vietnam'),
(250, 0, 'Virgin Islands (British)'),
(251, 0, 'Virgin Islands (U.S.)'),
(252, 0, 'Wake Island'),
(253, 0, 'Wales'),
(254, 0, 'Wallis Island'),
(255, 0, 'Western Samoa'),
(256, 0, 'Yap'),
(257, 0, 'Yemen, Republic of'),
(258, 0, 'Zaire'),
(259, 0, 'Zambia'),
(260, 0, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL,
  `title` varchar(120) DEFAULT NULL,
  `fsize` tinyint(1) NOT NULL DEFAULT '55',
  `section` varchar(3) DEFAULT NULL,
  `sorting` int(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(11) NOT NULL,
  `user` varchar(11) NOT NULL,
  `course` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `banned` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `user`, `course`, `date`, `banned`) VALUES
(1, '3', '3', '2014-11-23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `course` int(5) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `syllabus` text NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `course`, `title`, `syllabus`, `duration`) VALUES
(1, 4, 'Demo Exam 1', 'Demo Exam 1', 60),
(2, 2, 'Demo Exam 2', 'Demo Exam 2', 56),
(3, 3, 'Demo Exam 3', 'Demo Exam 3', 5);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `title` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `content` text NOT NULL,
  `order` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `content`, `order`) VALUES
(2, 'What is Exam Board?', 'Exam Board is a online academy for taking tests and getting certificate for passed courses.', 5),
(3, 'What can get from this site?', 'You can get lot&#039;s of courses and exams which is essential career development.', 3),
(4, 'How much I have to pay?', 'There are different course programs with different enrollment fees. You can get enrolled to anyone.', 2),
(5, 'Is there any free courses?', 'There are different free courses. You can take theme for free and get certified.', 0),
(6, 'How i get certified?', 'Take some tests. Now you can see your exam records in desired page and download a pdf certificate from there.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(200) NOT NULL,
  `displayname` varchar(200) NOT NULL,
  `dir` varchar(200) NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  `extra_txt` varchar(200) NOT NULL,
  `extra_txt2` varchar(200) NOT NULL,
  `extra_txt3` varchar(200) DEFAULT NULL,
  `extra` varchar(200) NOT NULL,
  `extra2` varchar(200) NOT NULL,
  `extra3` varchar(200) DEFAULT NULL,
  `info` text,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `info`, `active`) VALUES
(1, 'paypal', 'PayPal', 'paypal', 0, 'Paypal Email Address', 'Currency Code', 'Not in Use', '', '', '', '&lt;p&gt;&lt;a href=&quot;http://www.paypal.com/&quot; title=&quot;PayPal&quot; rel=&quot;nofollow&quot; target=&quot;_blank&quot;&gt;Click here to setup an account with Paypal&lt;/a&gt; &lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Gateway Name&lt;/strong&gt; - Enter the name of the payment provider here.&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Active&lt;/strong&gt; - Select Yes to make this payment provider active. &lt;br/&gt;\r\n			If this box is not checked, the payment provider will not show up in the payment provider list during checkout.&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Set Live Mode&lt;/strong&gt; - If you would like to test the payment provider settings, please select No. &lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Paypal email address&lt;/strong&gt; - Enter your PayPal Business email address here. &lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Currency Code&lt;/strong&gt; - Enter your currency code here. Valid choices are: &lt;/p&gt;\r\n				&lt;ul&gt;\r\n					&lt;li&gt; USD (U.S. Dollar)&lt;/li&gt;\r\n					&lt;li&gt; EUR (Euro) &lt;/li&gt;\r\n					&lt;li&gt; GBP (Pound Sterling) &lt;/li&gt;\r\n					&lt;li&gt; CAD (Canadian Dollar) &lt;/li&gt;\r\n					&lt;li&gt; JPY (Yen). &lt;/li&gt;\r\n					&lt;li&gt; If omitted, all monetary fields will use default system setting Currency Code. &lt;/li&gt;\r\n				&lt;/ul&gt;\r\n			&lt;p&gt;&lt;strong&gt;Not in Use&lt;/strong&gt; - This field it&#039;s not in use. Leave it empty. &lt;/p&gt;\r\n	        &lt;p&gt;&lt;strong&gt;IPN Url&lt;/strong&gt; - If using recurring payment method, you need to set up and activate the IPN Url in your account: &lt;/p&gt;', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `duedate` date NOT NULL,
  `amount_total` decimal(13,2) NOT NULL DEFAULT '0.00',
  `amount_paid` decimal(13,2) NOT NULL DEFAULT '0.00',
  `method` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tax` decimal(13,2) NOT NULL DEFAULT '0.00',
  `notes` text,
  `comment` varchar(200) DEFAULT NULL,
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `onhold` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `title`, `project_id`, `client_id`, `created`, `duedate`, `amount_total`, `amount_paid`, `method`, `tax`, `notes`, `comment`, `recurring`, `onhold`, `status`) VALUES
(1, 'New Invoice', 1, 3, '2012-06-07', '2011-11-12', '259.90', '259.90', 'Offline', '29.90', 'Qui in adhuc assueverit neglegentur, eu eam vidit maiestatis abhorreant. Ut vim porro mediocritatem, affert liberavisse instructior at sit, sea paulo tollit intellegam in. Usu in latine deterruisset, sed no viderer propriae accusamus. Eum molestiae complectitur ad. Viderer numquam te sed, no prima scribentur duo.', 'His illum inciderint te, velit constituto cu mea, cu sit tacimates accusata salutandi.', 0, 0, 'Paid'),
(2, 'Pending Invoice', 3, 3, '2011-12-04', '2011-12-02', '203.40', '123.40', 'Offline', '23.40', '', '', 0, 1, 'Unpaid'),
(3, 'Testing 345', 7, 3, '2012-01-29', '2012-06-23', '150.00', '0.00', 'PayPal', '0.00', NULL, NULL, 1, 0, 'Unpaid'),
(4, 'Testing 123', 2, 3, '2012-07-01', '2012-08-01', '25.00', '0.00', 'Offline', '0.00', NULL, NULL, 0, 0, 'Unpaid'),
(5, 'New Invoice II', 3, 4, '2012-06-08', '2012-06-23', '78.69', '0.00', 'PayPal', '0.00', NULL, NULL, 0, 0, 'Unpaid'),
(6, 'Web Development', 3, 3, '2013-02-23', '2013-06-25', '10.89', '0.00', 'Offline', '0.00', 'You can enter here your company &lt;strong&gt;policy&lt;/strong&gt; or any other info\nSome other info', 'This comment is NEVER displayed to client or included in the final Quote. It&#039;s for internal purpose only.', 0, 0, 'Unpaid'),
(7, 'Music @ FewPress.com', 8, 3, '2014-11-05', '2014-12-05', '67.00', '0.00', 'PayPal', '0.00', 'You can enter here your company policy or any other info', '', 0, 0, 'Unpaid'),
(8, 'Demo Invoice', 2, 3, '2014-11-18', '2014-12-18', '55.00', '0.00', 'PayPal', '0.00', 'You can ensfbdter here your company policy or any other info', 'dfgf', 0, 0, 'Unpaid'),
(9, 'Course Enrolment to Logo Design', 2, 3, '2014-11-19', '2014-11-19', '5.00', '0.00', 'MoneyBookers', '0.00', 'You can enter here your company policy or any other infdghdghdhbdthfgtho', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(10, 'Course Enrolment to Logo Design', 2, 10, '2014-11-19', '2014-11-19', '5.00', '0.00', 'MoneyBookers', '0.00', 'sdafsdfds', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(11, 'Course Enrolment to Logo Design', 2, 10, '2014-11-19', '2014-11-19', '5.00', '0.00', 'AuthorizeNet', '0.00', 'uigiukggihgui', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(12, 'Course Enrolment to Logo Design', 2, 10, '2014-11-19', '2014-11-19', '5.00', '0.00', 'AuthorizeNet', '0.00', 'ergtdfgdfgfd', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(13, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'AuthorizeNet', '0.00', 'You can enter here your company policy or any other jgkjb', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(14, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'MoneyBookers', '0.00', 'fuyhjbjhjnkhhnjjjhb', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(15, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'MoneyBookers', '0.00', 'jgujgbjgj', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(16, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'MoneyBookers', '0.00', 'kldfhgvidfh', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(17, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'AuthorizeNet', '0.00', 'You can enter here your company policy or any other h', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid'),
(18, 'Course Enrolment to Logo Design', 2, 3, '2014-11-23', '2014-11-23', '5.00', '0.00', 'AuthorizeNet', '0.00', 'You can enter here your company policy or any other infogduigweu', 'This transaction was for course fee of Logo Design', 0, 0, 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_data`
--

CREATE TABLE `invoice_data` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(13,2) NOT NULL DEFAULT '0.00',
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `days` int(2) NOT NULL DEFAULT '0',
  `period` varchar(1) NOT NULL DEFAULT 'D',
  `tax` decimal(13,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_data`
--

INSERT INTO `invoice_data` (`id`, `project_id`, `invoice_id`, `title`, `description`, `amount`, `recurring`, `days`, `period`, `tax`) VALUES
(1, 1, 1, 'New Entry III', 'Some dscription 1', '120.00', 0, 0, 'D', '15.60'),
(2, 1, 1, 'New Entry II', 'Some dscription II', '110.00', 0, 0, 'D', '14.30'),
(3, 2, 2, 'New Entry I', 'Basic Troubleshooting', '180.00', 0, 0, 'D', '23.40'),
(6, 7, 3, 'Recurring Payment', 'PayPal Recurring payment.', '150.00', 1, 10, 'W', '0.00'),
(8, 3, 6, 'Initial Entry', 'It tamen decimalo tempolongo vic. AÃ…Â­ sori speco alikaÃ…Â­ze ts, kvanta', '10.89', 0, 0, 'D', '0.00'),
(9, 0, 7, 'rgdfdf', 'ghngfhfg', '67.00', 0, 0, 'Y', '0.00'),
(10, 0, 8, 'dbvdfbdf', 'rthbfd', '55.00', 0, 0, 'Y', '0.00'),
(11, 0, 9, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(12, 0, 10, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(13, 0, 11, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(14, 0, 12, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(15, 0, 13, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(16, 0, 14, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(17, 0, 15, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(18, 0, 16, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(19, 0, 17, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00'),
(20, 0, 18, 'Course Fee', 'Course Fee: Logo Design', '5.00', 0, 0, '&', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `method` varchar(20) NOT NULL,
  `amount` decimal(13,2) NOT NULL DEFAULT '0.00',
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `created` date NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_payments`
--

INSERT INTO `invoice_payments` (`id`, `invoice_id`, `project_id`, `method`, `amount`, `recurring`, `created`, `description`) VALUES
(2, 2, 3, 'Offline', '80.00', 0, '2013-07-05', 'Payment added by admin'),
(3, 2, 3, 'Offline', '25.00', 0, '2013-01-03', 'Payment added by admin');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `user` varchar(60) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(6) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pp` varchar(40) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `txn_id`, `form_id`, `user`, `email`, `price`, `currency`, `created`, `pp`, `ip`, `status`) VALUES
(1, 'ORP098r5', 1, 'John Doe', 'user@gmail.com', '700.00', 'CAD', '2013-07-14 20:29:06', 'PayPal', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `id` int(11) NOT NULL,
  `title` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fees` float NOT NULL,
  `description` text NOT NULL,
  `recurring` int(11) NOT NULL,
  `period` varchar(11) NOT NULL,
  `days` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`id`, `title`, `fees`, `description`, `recurring`, `period`, `days`) VALUES
(3, 'Demo Course Name', 0, 'Demo Course Name', 0, '', 0),
(4, 'Demo Course Name 2', 15, 'Demo Course Name 2', 0, '', 0),
(6, 'Demo Course Name 3', 44.5, 'Demo Course Name 3', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam` int(11) NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `marks` int(11) NOT NULL,
  `banned` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam`, `type`, `description`, `marks`, `banned`) VALUES
(12, 3, '2', 'This is a MCQ Question (Single Answer) dsfsdfsd', 5, 0),
(15, 3, '3', 'This is MCQ (Multi Answer) fdsss', 10, 0),
(16, 3, '4', 'This is a writing question ihdfilsdbflsil', 10, 0),
(13, 3, '1', 'This is True / False Question 1sefsfsdfsd &amp;nbsp; sadsafdddddd', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `category` int(5) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `category`, `title`, `content`) VALUES
(1, 8, 'How Secure Is My Password?', 'It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known.&lt;/span&gt;&lt;/font&gt;&lt;/p&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;font color=&quot;#383838&quot; face=&quot;Open Sans, Helvetica, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 15px; line-height: 24px;&quot;&gt;&amp;nbsp;Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot.It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot.&lt;/span&gt;&lt;/font&gt;&lt;/p&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;font color=&quot;#383838&quot; face=&quot;Open Sans, Helvetica, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 15px; line-height: 24px;&quot;&gt;&lt;b&gt;It has been said that astronomy is a humbling and character-building experience.&amp;nbsp;&lt;/b&gt;&lt;/span&gt;&lt;/font&gt;&lt;/p&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;font color=&quot;#383838&quot; face=&quot;Open Sans, Helvetica, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 15px; line-height: 24px;&quot;&gt;There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot.&lt;/span&gt;&lt;/font&gt;&lt;/p&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;font color=&quot;#383838&quot; face=&quot;Open Sans, Helvetica, Arial, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 15px; line-height: 24px;&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot.&lt;/span&gt;'),
(2, 8, 'Recommended Plugins', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;'),
(5, 9, 'What Technologies Are Used?', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(4, 9, 'Chaning The KnowHow Header', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;'),
(6, 8, 'Customizing The Theme Colors', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(7, 9, 'Recommended Plugins', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(8, 10, 'Modifying The Background Image', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(9, 8, 'Chaning The KnowHow Header', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;');
INSERT INTO `resources` (`id`, `category`, `title`, `content`) VALUES
(10, 8, 'How Do I Contact Legals?', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It&#039;s has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human c&#039;sonceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(11, 10, 'Where Are Your Offices Located', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(12, 8, 'Who Owns The Copyright On Uplo', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(13, 9, 'Our Content Policy', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;'),
(14, 10, 'How Do I File A DMCA?', '&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;It has been said that astronomy is a humbling and character-building experience. There is perhaps no better demonstration of the folly of human conceits than this distant image of our tiny world. To me, it underscores our responsibility to deal more kindly with one another, and to preserve and cherish the pale blue dot, the only home weâ€™ve ever known. The Earth is a very small stage in a vast cosmic arena. Think of the rivers of blood spilled by all those generals and emperors so that, in glory and triumph, they could become the momentary masters of a fraction of a dot. Think of the endless cruelties visited by the inhabitants of one corner of this pixel on the scarcely distinguishable inhabitants of some other corner, how frequent their misunderstandings, how eager they are to kill one another, how fervent their hatreds.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Earth&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;Look again at that dot. Thatâ€™s here. Thatâ€™s home. Thatâ€™s us. On it everyone you love, everyone you know, everyone you ever heard of,&lt;strong style=&quot;box-sizing: border-box;&quot;&gt;&amp;nbsp;every human being&lt;/strong&gt;&amp;nbsp;who ever was, lived out their lives. The aggregate of our joy and suffering, thousands of confident religions, ideologies, and economic doctrines, every hunter and forager, every hero and coward, every creator and destroyer of civilization, every king and peasant, every young couple in love, every mother and father, hopeful child, inventor and explorer, every teacher of morals, every corrupt politician, every â€œsuperstar,â€ every â€œsupreme leader,â€ every saint and sinner in the history of our species lived thereâ€“on a mote of dust suspended in a sunbeam.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Houston&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;that may have seemed like a very long final phase. The autotargeting was taking us right into a â€¦ crater, with a large number of big boulders and rocks â€¦ and it required â€¦ flying manually over the rock field to find a reasonably good area.&lt;/p&gt;&lt;ul style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;A good rule for rocket experimenters to follow is this: always assume that it will explode.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Letâ€™s light this fire one more time, Mike, and witness this great nation at its best.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The view of the Earth from the Moon fascinated meâ€”a small disk, 240,000 miles away. It was hard to think that that little thing held so many problems, so many frustrations. Raging nationalistic interests, famines, wars, pestilence donâ€™t show from that distance.&lt;/p&gt;&lt;h3 style=&quot;box-sizing: border-box; font-size: 24px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 30px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;Flight Control&lt;/h3&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;From this day forward, Flight Control will be known by two words: â€˜Toughâ€™ and â€˜Competent.â€™ Tough means we are forever accountable for what we do or what we fail to do. We will never again compromise our responsibilities. Every time we walk into Mission Control we will know what we stand for. Competent means we will never take anything for granted. We will never be found short in our knowledge and in our skills. Mission Control will be perfect. When you leave this meeting today you will go to your office and the first thing you will do there is to write â€˜Tough and Competentâ€™ on your blackboards. It will never be erased. Each day when you enter the room these words will remind you of the price paid by Grissom, White, and Chaffee. These words are the price of admission to the ranks of Mission Control.&lt;/p&gt;&lt;ol style=&quot;box-sizing: border-box; margin: 0px 0px 24px 48px; padding: 0px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;Itâ€™s just mind-blowingly awesome. I apologize, and I wish I was more articulate, but itâ€™s hard to be articulate when your mindâ€™s blownâ€”but in a very good way.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/li&gt;&lt;li style=&quot;box-sizing: border-box; padding-left: 6px; margin-bottom: 12px;&quot;&gt;The surface is fine and powdery. I can kick it up loosely with my toe.&lt;/li&gt;&lt;/ol&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;The vehicle explodes, literally explodes, off the pad. The simulator shakes you a little bit, but the actual liftoff shakes your entire body and soul.&lt;/p&gt;&lt;h2 style=&quot;box-sizing: border-box; font-size: 26px; margin: 36px 0px 24px; color: rgb(26, 26, 26); line-height: 32px; font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);&quot;&gt;The Future&lt;/h2&gt;&lt;p style=&quot;box-sizing: border-box; margin: 0px 0px 24px; color: rgb(56, 56, 56); font-family: &#039;Open Sans&#039;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; background-color: rgb(255, 255, 255);&quot;&gt;I am a stranger. I come in peace. Take me to your leader and there will be a massive reward for you in eternity.&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user` varchar(11) NOT NULL,
  `exam` varchar(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  `fullmarks` float(5,2) NOT NULL,
  `duration` float(5,2) NOT NULL,
  `marks` float(5,2) NOT NULL,
  `score` int(11) NOT NULL,
  `remarks` int(2) NOT NULL,
  `date` date NOT NULL,
  `banned` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user`, `exam`, `token`, `fullmarks`, `duration`, `marks`, `score`, `remarks`, `date`, `banned`) VALUES
(2, '3', '3', 'etyiueryufyerui', 30.00, 5.00, 30.00, 100, 1, '2014-12-01', 0),
(3, '3', '2', 'etyiueryufyerui', 30.00, 5.00, 30.00, 100, 1, '2014-12-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `company` varchar(75) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `site_url` varchar(75) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `site_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `city` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `zip` varchar(16) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `logo` varchar(60) NOT NULL,
  `short_date` varchar(20) NOT NULL,
  `long_date` varchar(20) NOT NULL,
  `dtz` varchar(200) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `weekstart` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(30) DEFAULT NULL,
  `enable_reg` tinyint(1) NOT NULL DEFAULT '1',
  `enable_tax` tinyint(1) NOT NULL DEFAULT '0',
  `tax_name` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tax_rate` varchar(8) NOT NULL DEFAULT '0',
  `tax_number` varchar(100) DEFAULT NULL,
  `enable_offline` tinyint(1) NOT NULL DEFAULT '1',
  `offline_info` text,
  `invoice_note` text,
  `invoice_number` varchar(40) DEFAULT NULL,
  `quote_number` varchar(40) DEFAULT NULL,
  `enable_uploads` tinyint(1) NOT NULL DEFAULT '1',
  `file_types` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `file_max` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `perpage` varchar(3) NOT NULL DEFAULT '10',
  `sbackup` varchar(50) DEFAULT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `cur_symbol` varchar(6) DEFAULT NULL,
  `tsep` varchar(1) NOT NULL DEFAULT ',',
  `dsep` varchar(1) NOT NULL DEFAULT '.',
  `pp_email` varchar(50) DEFAULT NULL,
  `pp_pass` varchar(30) DEFAULT NULL,
  `pp_api` varchar(100) DEFAULT NULL,
  `pp_mode` tinyint(1) NOT NULL DEFAULT '0',
  `invdays` tinyint(1) NOT NULL DEFAULT '7',
  `mailer` enum('PHP','SMTP','SMAIL') NOT NULL DEFAULT 'PHP',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `smtp_port` smallint(3) DEFAULT NULL,
  `sendmail` varchar(60) DEFAULT NULL,
  `is_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `crmv` varchar(5) DEFAULT NULL,
  `passing_score` int(2) NOT NULL,
  `google_analytics` text NOT NULL,
  `social_gplus` varchar(75) NOT NULL,
  `social_twitter` varchar(75) NOT NULL,
  `social_facebook` varchar(75) NOT NULL,
  `social_pinterest` varchar(75) NOT NULL,
  `social_linkedin` varchar(75) NOT NULL,
  `social_rss` varchar(75) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`company`, `site_url`, `site_email`, `address`, `city`, `state`, `zip`, `phone`, `fax`, `logo`, `short_date`, `long_date`, `dtz`, `lang`, `weekstart`, `theme`, `enable_reg`, `enable_tax`, `tax_name`, `tax_rate`, `tax_number`, `enable_offline`, `offline_info`, `invoice_note`, `invoice_number`, `quote_number`, `enable_uploads`, `file_types`, `file_max`, `perpage`, `sbackup`, `currency`, `cur_symbol`, `tsep`, `dsep`, `pp_email`, `pp_pass`, `pp_api`, `pp_mode`, `invdays`, `mailer`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `sendmail`, `is_ssl`, `crmv`, `passing_score`, `google_analytics`, `social_gplus`, `social_twitter`, `social_facebook`, `social_pinterest`, `social_linkedin`, `social_rss`) VALUES
('Mock Exam', 'http://localhost/exam', 'sreeraj.mnair@gmail.com', '123 Main St.', 'Toronto', 'Ontario', 'M2J 1K5', '555-555-5555', '444-444-4444', 'logo.png', '%b %d %Y', '%d %B %Y %H:%M', 'America/Toronto', 'en', 1, 'master', 1, 1, 'HST', '0.13', '123456789-WOJO-321', 1, 'Instructions for offline payments\r\nSuch as bank info, address etc...', 'You can enter here your company policy or any other info', 'RTB-ST5', 'QUO-1010', 1, 'gif,png,jpg,jpeg,pdf,zip,rar', '10485760', '10', '03-Jan-2015_00-57-16.sql', 'CAD', '$', ',', '.', '', '', '', 0, 10, 'PHP', '', '', '', 25, '/usr/sbin/sendmail -t -i', 0, '3.0.0', 60, 'dfsvjfdsj', 'defcsd', 'dsfsd', 'dsf', 'dsfs', 'sdf', 'dsfsd');

-- --------------------------------------------------------

--
-- Table structure for table `tanswers`
--

CREATE TABLE `tanswers` (
  `id` int(11) NOT NULL,
  `tquestion` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `correct` text NOT NULL,
  `marked` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tquestions`
--

CREATE TABLE `tquestions` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(20) NOT NULL,
  `qid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `exam` int(11) NOT NULL,
  `description` text NOT NULL,
  `marks` float(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE `tracker` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `time` time NOT NULL,
  `ip` text NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `query_string` text NOT NULL,
  `http_referer` text NOT NULL,
  `http_user_agent` text NOT NULL,
  `isbot` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracker`
--

INSERT INTO `tracker` (`id`, `created`, `time`, `ip`, `country`, `city`, `query_string`, `http_referer`, `http_user_agent`, `isbot`) VALUES
(1, '2014-12-04', '08:12:43', '::1', '', '', '', 'http://localhost/eb/admin/login.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36', 0),
(561, '2016-05-18', '02:33:44', '::1', '', '', 'undefined', 'undefined', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(562, '2016-05-18', '02:44:02', '::1', '', '', 'undefined', 'http://localhost/exam/', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(563, '2016-05-18', '04:51:39', '::1', '', '', 'undefined', 'undefined', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(564, '2016-05-18', '04:51:43', '::1', '', '', 'undefined', 'http://localhost/exam/account.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(565, '2016-05-18', '04:51:43', '::1', '', '', 'undefined', 'http://localhost/exam/account.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(566, '2016-05-18', '04:54:07', '::1', '', '', 'undefined', 'http://localhost/exam/index.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(567, '2016-05-18', '04:58:53', '::1', '', '', 'undefined', 'http://localhost/exam/register.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(568, '2016-05-18', '04:59:54', '::1', '', '', 'undefined', 'http://localhost/exam/index.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(569, '2016-05-18', '05:01:13', '::1', '', '', 'undefined', 'http://localhost/exam/account.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(570, '2016-05-18', '05:01:17', '::1', '', '', 'action=category&amp;sort=8', 'http://localhost/exam/resources.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(571, '2016-05-18', '05:01:23', '::1', '', '', 'undefined', 'http://localhost/exam/resources.php?action=category&amp;sort=8', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(572, '2016-05-18', '05:01:34', '::1', '', '', 'action=details&amp;id=14', 'http://localhost/exam/resources.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(573, '2016-05-18', '05:02:29', '::1', '', '', 'undefined', 'http://localhost/exam/resources.php?action=details&amp;id=14', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(574, '2016-05-18', '05:02:34', '::1', '', '', 'undefined', 'http://localhost/exam/account.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(575, '2016-05-18', '05:02:37', '::1', '', '', 'undefined', 'http://localhost/exam/account.php', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(576, '2016-05-18', '05:55:11', '::1', '', '', 'undefined', 'undefined', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(577, '2016-05-18', '05:57:18', '::1', '', '', 'undefined', 'undefined', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0),
(578, '2016-05-18', '06:13:30', '::1', '', '', 'undefined', 'undefined', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pp_email` varchar(50) DEFAULT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `company` varbinary(150) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country` int(3) NOT NULL DEFAULT '0',
  `currency` varchar(10) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `vat` varchar(60) DEFAULT NULL,
  `avatar` varchar(60) DEFAULT NULL,
  `userlevel` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `notes` text,
  `custom_fields` text,
  `credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  `lastip` varchar(16) DEFAULT '0',
  `active` enum('y','n','t','b') NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `pp_email`, `fname`, `lname`, `company`, `address`, `city`, `state`, `zip`, `country`, `currency`, `phone`, `vat`, `avatar`, `userlevel`, `created`, `notes`, `custom_fields`, `credit`, `lastlogin`, `lastip`, `active`) VALUES
(3, 'demo', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'rzaman@bitset.org', NULL, 'R Zaman', 'Rokon', 0x426974536574204c696d69746564, 'Ta-186, South Badda', 'Dhaka', 'Dhaka', 'DHK 1212', 18, '', '555-555-5555', '12345678', NULL, 1, '2011-05-02 18:10:14', 'ulla aliquam pulvinar congue. Morbi quis nisl orci, vel sollicitudin erat. In hac habitasse platea dictumst. Vestibulum congue blandit odio, a pulvinar massa porttitor in. In hac habitasse platea dictumst.', '::::', '35.00', '2016-05-18 14:29:54', '::1', 'y'),
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'support@bitset.org', '', 'Super', 'Admin', NULL, '', '', '', '', 0, NULL, '', NULL, 'AVT_1A5B04-366C04-277646-983028-EB5C50-DD498C.png', 9, '2014-08-26 20:21:08', '', NULL, '0.00', '2016-05-18 12:05:45', '::1', 'y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `countries` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_data`
--
ALTER TABLE `invoice_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanswers`
--
ALTER TABLE `tanswers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tquestions`
--
ALTER TABLE `tquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracker`
--
ALTER TABLE `tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;
--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `invoice_data`
--
ALTER TABLE `invoice_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tanswers`
--
ALTER TABLE `tanswers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;
--
-- AUTO_INCREMENT for table `tquestions`
--
ALTER TABLE `tquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=579;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
