-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2016 at 02:31 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `mock_admin_users`
--

CREATE TABLE `mock_admin_users` (
  `uid` int(11) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_no` varchar(1000) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '1',
  `su` int(11) NOT NULL DEFAULT '0',
  `subscription_expired` int(11) NOT NULL DEFAULT '0',
  `verify_code` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_admin_users`
--

INSERT INTO `mock_admin_users` (`uid`, `password`, `email`, `first_name`, `last_name`, `contact_no`, `gid`, `su`, `subscription_expired`, `verify_code`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 'Admin', 'Admin', '1234567890', 1, 1, 1776290400, 0),
(5, '202cb962ac59075b964b07152d234b70', 'user@example.com', 'User', 'User', '1234567890', 1, 0, 1776882600, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_answers`
--

CREATE TABLE `mock_answers` (
  `aid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `q_option` text NOT NULL,
  `uid` int(11) NOT NULL,
  `score_u` float NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_answers`
--

INSERT INTO `mock_answers` (`aid`, `qid`, `q_option`, `uid`, `score_u`, `rid`) VALUES
(20, 1, '57', 1, 1, 1),
(21, 3, '52', 1, 0.5, 1),
(22, 3, '54', 1, 0.5, 1),
(23, 6, 'Keyboard___CPU', 1, 0.25, 1),
(24, 6, 'Red___Green', 1, 0.25, 1),
(25, 6, 'Good Morning___Good Night', 1, 0.25, 1),
(26, 6, 'Honda___BMW', 1, 0.25, 1),
(27, 7, 'blue', 1, 1, 1),
(53, 7, 'red', 1, 0, 2),
(54, 8, 'India is the great country', 1, 0, 2),
(55, 6, 'Honda___BMW', 1, 0.25, 2),
(56, 6, 'Good Morning___Good Night', 1, 0.25, 2),
(57, 6, 'Keyboard___CPU', 1, 0.25, 2),
(58, 6, 'Red___Green', 1, 0.25, 2),
(59, 1, '57', 1, 1, 2),
(60, 3, '53', 1, 0, 2),
(61, 3, '55', 1, 0, 2),
(130, 1, '57', 1, 1, 3),
(131, 3, '52', 1, 0.5, 3),
(132, 3, '54', 1, 0.5, 3),
(136, 18, '94', 1, 1, 4),
(137, 17, '90', 1, 1, 4),
(141, 17, '90', 5, 1, 5),
(142, 18, '96', 5, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `mock_category`
--

CREATE TABLE `mock_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_category`
--

INSERT INTO `mock_category` (`cid`, `category_name`) VALUES
(1, 'General knowledge'),
(2, 'Math'),
(3, 'India');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam`
--

CREATE TABLE `mock_exam` (
  `quid` int(11) NOT NULL,
  `exam_name` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `gids` text NOT NULL,
  `qids` text NOT NULL,
  `noq` int(11) NOT NULL,
  `correct_score` float NOT NULL,
  `incorrect_score` float NOT NULL,
  `ip_address` text NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '10',
  `maximum_attempts` int(11) NOT NULL DEFAULT '1',
  `pass_percentage` float NOT NULL DEFAULT '50',
  `view_answer` int(11) NOT NULL DEFAULT '1',
  `camera_req` int(11) NOT NULL DEFAULT '1',
  `question_selection` int(11) NOT NULL DEFAULT '1',
  `gen_certificate` int(11) NOT NULL DEFAULT '0',
  `certificate_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_exam`
--

INSERT INTO `mock_exam` (`quid`, `exam_name`, `description`, `start_date`, `end_date`, `gids`, `qids`, `noq`, `correct_score`, `incorrect_score`, `ip_address`, `duration`, `maximum_attempts`, `pass_percentage`, `view_answer`, `camera_req`, `question_selection`, `gen_certificate`, `certificate_text`) VALUES
(1, 'Sample Quiz', 'Sample Quiz Sample Quiz', 1460344840, 1491880840, '3,1', '1,3,6,7', 4, 1, 0, '', 10, 10, 50, 1, 1, 0, 0, NULL),
(2, 'Sample Quiz 2', '<p>Sample Quiz 2</p>', 1457687593, 1491898393, '4,3,1', '', 5, 1, 0, '', 100, 10, 50, 1, 0, 1, 1, 'ID: #{result_id}<br>\r\n \r\n<br><br>\r\n<center>\r\n<font style=''font-size:32px;''>Certificate</font><br><br><br>\r\n<h4>This is certified that {first_name}  {last_name} has attempted the quiz ''{quiz_name}'' and obtained {percentage_obtained}% marks.<br>\r\nHis/her result status is {status}<br>\r\n</h4>\r\n\r\n</center>\r\n<br><br><br><br><br><br> \r\n{qr_code}<br>\r\nDate: {generated_date}'),
(4, 'PSC', '<p>Public service commission</p>', 1463304407, 1494840407, '4,1', '', 2, 1, -1, '', 10, 10, 50, 1, 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mock_group`
--

CREATE TABLE `mock_group` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(1000) NOT NULL,
  `price` float NOT NULL,
  `valid_for_days` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_group`
--

INSERT INTO `mock_group` (`gid`, `group_name`, `price`, `valid_for_days`) VALUES
(1, 'Free', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_level`
--

CREATE TABLE `mock_level` (
  `lid` int(11) NOT NULL,
  `level_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_level`
--

INSERT INTO `mock_level` (`lid`, `level_name`) VALUES
(1, 'Easy'),
(2, 'Difficult'),
(4, 'Very Difficult');

-- --------------------------------------------------------

--
-- Table structure for table `mock_news`
--

CREATE TABLE `mock_news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_news`
--

INSERT INTO `mock_news` (`news_id`, `title`, `content`, `created_at`) VALUES
(1, 'test  news', '<p>news description</p>', '0000-00-00 00:00:00'),
(2, 'test news 2', '<p>test description 2</p>', '2016-05-16 10:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `mock_options`
--

CREATE TABLE `mock_options` (
  `oid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `q_option` text NOT NULL,
  `q_option_match` varchar(1000) DEFAULT NULL,
  `score` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_options`
--

INSERT INTO `mock_options` (`oid`, `qid`, `q_option`, `q_option_match`, `score`) VALUES
(90, 17, '<p>option1</p>', NULL, 1),
(91, 17, '<p>option2</p>', NULL, 0),
(92, 17, '<p>option3</p>', NULL, 0),
(93, 17, '<p>option4</p>', NULL, 0),
(94, 18, '<p>option1</p>', NULL, 1),
(95, 18, '<p>option2</p>', NULL, 0),
(96, 18, '<p>option3</p>', NULL, 0),
(97, 18, '<p>option4</p>', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_payment`
--

CREATE TABLE `mock_payment` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `amount` float NOT NULL,
  `paid_date` int(11) NOT NULL,
  `payment_gateway` varchar(100) NOT NULL DEFAULT 'Paypal',
  `payment_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `transaction_id` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mock_qbank`
--

CREATE TABLE `mock_qbank` (
  `qid` int(11) NOT NULL,
  `question_type` varchar(100) NOT NULL DEFAULT 'Multiple Choice Single Answer',
  `question` text NOT NULL,
  `description` text NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `no_time_served` int(11) NOT NULL DEFAULT '0',
  `no_time_corrected` int(11) NOT NULL DEFAULT '0',
  `no_time_incorrected` int(11) NOT NULL DEFAULT '0',
  `no_time_unattempted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_qbank`
--

INSERT INTO `mock_qbank` (`qid`, `question_type`, `question`, `description`, `cid`, `lid`, `no_time_served`, `no_time_corrected`, `no_time_incorrected`, `no_time_unattempted`) VALUES
(17, 'Multiple Choice Single Answer', '<p>question 1?</p>', '', 1, 1, 2, 2, 0, 0),
(18, 'Multiple Choice Single Answer', '<p>question2</p>', '', 1, 1, 2, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_qcl`
--

CREATE TABLE `mock_qcl` (
  `qcl_id` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `noq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_qcl`
--

INSERT INTO `mock_qcl` (`qcl_id`, `quid`, `cid`, `lid`, `noq`) VALUES
(68, 2, 1, 1, 3),
(69, 2, 3, 1, 1),
(70, 2, 2, 1, 1),
(71, 4, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mock_result`
--

CREATE TABLE `mock_result` (
  `rid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `result_status` varchar(100) NOT NULL DEFAULT 'Open',
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `categories` text NOT NULL,
  `category_range` text NOT NULL,
  `r_qids` text NOT NULL,
  `individual_time` text NOT NULL,
  `total_time` int(11) NOT NULL DEFAULT '0',
  `score_obtained` float NOT NULL DEFAULT '0',
  `percentage_obtained` float NOT NULL DEFAULT '0',
  `attempted_ip` varchar(100) NOT NULL,
  `score_individual` text NOT NULL,
  `photo` varchar(100) NOT NULL,
  `manual_valuation` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_result`
--

INSERT INTO `mock_result` (`rid`, `quid`, `uid`, `result_status`, `start_time`, `end_time`, `categories`, `category_range`, `r_qids`, `individual_time`, `total_time`, `score_obtained`, `percentage_obtained`, `attempted_ip`, `score_individual`, `photo`, `manual_valuation`) VALUES
(1, 1, 1, 'Pass', 1461499745, 1461499785, 'India,Math,General knowledge', '4,4,4', '1,3,6,7', '0,20,12,0', 32, 4, 100, '::1', '1,1,1,1', '1461499745.jpg', 0),
(2, 2, 1, 'Pending', 1461499790, 1461499836, 'General knowledge,India,Math', '3,1,1', '7,8,6,1,3', '0,23,10,3,8', 44, 2, 40, '::1', '2,3,1,1,2', '', 1),
(3, 1, 1, 'Pass', 1461500254, 1461500804, 'India,Math,General knowledge', '4,4,4', '1,3,6,7', '103,213,138,38', 492, 2, 50, '::1', '1,1,0,0', '1461500254.jpg', 0),
(4, 4, 1, 'Pass', 1463304567, 1463304604, 'General knowledge', '2', '18,17', '0,30', 30, 2, 100, '::1', '1,1', '', 0),
(5, 4, 5, 'Fail', 1463304967, 1463304982, 'General knowledge', '2', '17,18', '0,11', 11, 0, 0, '::1', '1,2', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_users`
--

CREATE TABLE `mock_users` (
  `uid` int(11) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_no` varchar(1000) NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '1',
  `su` int(11) NOT NULL DEFAULT '0',
  `subscription_expired` int(11) NOT NULL DEFAULT '0',
  `verify_code` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_users`
--

INSERT INTO `mock_users` (`uid`, `password`, `email`, `first_name`, `last_name`, `contact_no`, `gid`, `su`, `subscription_expired`, `verify_code`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 'Admin', 'Admin', '1234567890', 1, 1, 1776290400, 0),
(5, '202cb962ac59075b964b07152d234b70', 'user@example.com', 'User', 'User', '1234567890', 1, 0, 1776882600, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mock_admin_users`
--
ALTER TABLE `mock_admin_users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `mock_answers`
--
ALTER TABLE `mock_answers`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `mock_category`
--
ALTER TABLE `mock_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `mock_exam`
--
ALTER TABLE `mock_exam`
  ADD PRIMARY KEY (`quid`);

--
-- Indexes for table `mock_group`
--
ALTER TABLE `mock_group`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `mock_level`
--
ALTER TABLE `mock_level`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `mock_news`
--
ALTER TABLE `mock_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `mock_options`
--
ALTER TABLE `mock_options`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `mock_payment`
--
ALTER TABLE `mock_payment`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `mock_qbank`
--
ALTER TABLE `mock_qbank`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `mock_qcl`
--
ALTER TABLE `mock_qcl`
  ADD PRIMARY KEY (`qcl_id`);

--
-- Indexes for table `mock_result`
--
ALTER TABLE `mock_result`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `mock_users`
--
ALTER TABLE `mock_users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mock_admin_users`
--
ALTER TABLE `mock_admin_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mock_answers`
--
ALTER TABLE `mock_answers`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `mock_category`
--
ALTER TABLE `mock_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mock_exam`
--
ALTER TABLE `mock_exam`
  MODIFY `quid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mock_group`
--
ALTER TABLE `mock_group`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mock_level`
--
ALTER TABLE `mock_level`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mock_news`
--
ALTER TABLE `mock_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mock_options`
--
ALTER TABLE `mock_options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `mock_payment`
--
ALTER TABLE `mock_payment`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mock_qbank`
--
ALTER TABLE `mock_qbank`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `mock_qcl`
--
ALTER TABLE `mock_qcl`
  MODIFY `qcl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `mock_result`
--
ALTER TABLE `mock_result`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mock_users`
--
ALTER TABLE `mock_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
