-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 28, 2018 at 06:46 AM
-- Server version: 5.6.40
-- PHP Version: 7.1.17

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tatapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `state` varchar(200) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `website` varchar(250) NOT NULL,
  `contact_person` varchar(250) NOT NULL,
  `office_number` varchar(20) NOT NULL,
  `cell_phone` varchar(20) NOT NULL,
  `email_address` varchar(250) NOT NULL,
  `membership_type` enum('trial','basic','pro','premium','deactive') NOT NULL,
  `status` enum('y','n') NOT NULL DEFAULT 'y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `name`, `address`, `city`, `state`, `zip_code`, `website`, `contact_person`, `office_number`, `cell_phone`, `email_address`, `membership_type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Smart Group', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '1160013', '3243', '23324', '338011133', '338011133', 'admin@tatapp.com', 'trial', 'y', '2018-05-15 23:43:02', '2018-05-29 02:02:39', NULL),
(2, 'TAT GROUP', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678', 'agency1@tatapp.com', 'trial', 'y', '2018-05-29 08:51:03', '2018-05-29 08:52:25', NULL),
(3, 'TCS GROUP', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '1160013', 'yahoo.com', 'subhendu das', '919432879516', '123456789123', 'agency2@tatapp.com', 'pro', 'y', '2018-05-29 09:00:31', '2018-05-30 08:53:45', NULL),
(4, 'account 1', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678a', 'account1@tatapp.com', 'basic', 'y', '2018-05-30 22:18:51', '2018-05-30 22:18:51', NULL),
(5, 'account2', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '9831211793', 'account2@tatapp.com', 'pro', 'y', '2018-05-31 05:03:55', '2018-05-31 05:03:55', NULL),
(6, 'IBM detective agency', 'IBM detective agency', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678', 'ibm@tatapp.com', 'trial', 'y', '2018-05-31 08:31:50', '2018-05-31 08:31:50', NULL),
(7, 'gourav account', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'debabrata sarkar', '9432879516', '12345678', 'gaurav@tatapp.com', 'trial', 'y', '2018-06-01 10:38:52', '2018-06-01 10:41:13', NULL),
(8, 'testnewaccount', 'l;kj', 'lkj', 'lkj', '32232', 'www.test.com', 'Johnny Lee', '9192745517', '9192745518', 'johnnylee27@gmail.com', 'basic', 'n', '2018-06-04 16:17:16', '2018-07-23 20:10:37', NULL),
(9, 'testaccount2', '401 22nd court south', 'Birmingham', 'Alabama', '35205', 'www.test.com', 'Johnny Lee', '9192745515', '8767866767', 'jlee@peaceatwork.org', 'pro', 'n', '2018-06-04 17:11:15', '2018-06-13 18:23:39', NULL),
(10, 'diksha srivastava', '401 22nd court sth', 'test', 'Alabama', '3333333', 'hello', 'Johnny Lee', '9192745515', '9192745515', 'test@tester.com', 'pro', 'y', '2018-06-04 18:03:40', '2018-06-13 18:44:20', NULL),
(11, 'JLtest', '401 22nd court south', 'Birmingham', 'Alabama', '35205', 'www.test.com', 'Johnny Lee', '9192745515', '9192745515', 'johnnylee27@gssmail.com', 'trial', 'n', '2018-06-12 18:57:58', '2018-06-13 18:20:29', NULL),
(12, 'testshortpassword', '401 22nd court south', 'Birmingham', 'Alabama', '35205', 'www.test.com', 'Johnny Lee', '9192745515', '9192745515', 'lee@gmail.com', 'basic', 'n', '2018-06-13 18:24:32', '2018-06-14 14:48:22', NULL),
(13, 'accenture', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678', 'accenture@tatapp.com', 'basic', 'y', '2018-06-14 14:30:36', '2018-06-14 14:30:36', NULL),
(14, 'sapient group', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678', 'sapient@tatapp.com', 'basic', 'y', '2018-06-15 05:23:21', '2018-06-15 05:23:21', NULL),
(15, 'GA1', 'GA1', 'GA1', 'GA1', '79009', 'yahoo.com', 'GA1', '9432879516', '9831211793', 'GA1@gmail.com', 'trial', 'y', '2018-07-12 05:08:37', '2018-07-14 11:53:07', NULL),
(16, 'GA2', 'GA2', 'GA2', 'GA2', '79009', 'https://github.com/atrakeur/laravel-forum', 'debabrata sarkar', '9432879516', '9831211793', 'GA2@gmail.com', 'pro', 'y', '2018-07-12 05:18:23', '2018-07-14 11:52:54', NULL),
(17, 'bankjp1', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', 'yahoo.com', 'subhendu das', '9432879516', '12345678', 'subhamca2003@gmail.com', 'trial', 'y', '2018-07-16 11:36:09', '2018-07-16 11:36:09', NULL),
(18, 'Demo', '401 22nd court south', 'Birmingham', 'Alabama', '35205', 'www.test.com', 'Johnny Lee', '9192745515', '9192745515', 'demo@peaceatwork.org', 'premium', 'y', '2018-07-23 20:13:01', '2018-07-23 20:13:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_sector`
--

CREATE TABLE `account_sector` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sector_name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `isActive` enum('y','n') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_sector`
--

INSERT INTO `account_sector` (`id`, `account_id`, `user_id`, `sector_name`, `description`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, 'Grievance', 'Grievance', 'y', '2018-05-29 09:35:49', '2018-05-29 09:35:49', NULL),
(2, 2, 2, 'Health', 'Health', 'y', '2018-05-29 09:36:16', '2018-05-29 09:36:16', NULL),
(3, 2, 2, 'History of violence', 'History of violence', 'y', '2018-05-29 09:36:36', '2018-05-29 09:36:36', NULL),
(4, 5, 11, 'Grievance', 'Grievance', 'y', '2018-05-31 06:43:39', '2018-05-31 06:43:39', NULL),
(5, 5, 11, 'Health', 'Health', 'y', '2018-05-31 06:43:50', '2018-05-31 06:43:50', NULL),
(6, 5, 11, 'History of violence', 'History of violence', 'y', '2018-05-31 06:44:03', '2018-05-31 06:44:03', NULL),
(7, 7, 16, 'Grievance', 'Grievance', 'y', '2018-06-01 10:46:08', '2018-06-01 10:46:08', NULL),
(8, 7, 16, 'Health', 'Health', 'y', '2018-06-01 10:46:19', '2018-06-01 10:46:19', NULL),
(9, 7, 16, 'History of violence', 'History of violence', 'y', '2018-06-01 10:46:40', '2018-06-01 10:46:40', NULL),
(10, 2, 2, 'Weapons', 'got one?', 'y', '2018-06-04 19:16:23', '2018-06-04 19:16:23', NULL),
(11, 2, 2, 'social media', 'kjh', 'y', '2018-06-04 19:44:50', '2018-06-04 19:44:50', NULL),
(12, 2, 2, 'medication', 'what meds do they take?', 'n', '2018-06-04 22:31:54', '2018-06-13 18:59:57', NULL),
(13, 9, 24, 'social media', 's', 'y', '2018-06-13 19:19:42', '2018-06-13 19:19:42', NULL),
(14, 9, 24, 'History', 'asdf', 'y', '2018-06-13 19:20:01', '2018-06-13 19:20:01', NULL),
(15, 9, 24, 'Status', 'sadf', 'y', '2018-06-13 19:20:14', '2018-06-13 19:20:14', NULL),
(16, 13, 41, 'Grievance', 'Grievance desc', 'y', '2018-06-14 00:00:00', NULL, NULL),
(17, 13, 41, 'Health', 'Health description', 'y', '2018-06-14 00:00:00', NULL, NULL),
(18, 13, 41, 'History of violence', 'History of violence description', 'y', '2018-06-14 00:00:00', NULL, NULL),
(19, 14, 43, 'Status', 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.', 'y', '2018-06-15 00:00:00', NULL, NULL),
(20, 14, 43, 'History', 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.', 'y', '2018-06-15 00:00:00', NULL, NULL),
(21, 14, 43, 'Threat', 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.', 'y', '2018-06-15 00:00:00', NULL, NULL),
(22, 15, 44, 'Status', 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(23, 15, 44, 'History', 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(24, 15, 44, 'Threat', 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(25, 16, 45, 'Status', 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(26, 16, 45, 'History', 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(27, 16, 45, 'Threat', 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.', 'y', '2018-07-12 00:00:00', NULL, NULL),
(28, 17, 49, 'Status', 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.', 'y', '2018-07-16 00:00:00', NULL, NULL),
(29, 17, 49, 'History', 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.', 'y', '2018-07-16 00:00:00', NULL, NULL),
(30, 17, 49, 'Threat', 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.', 'y', '2018-07-16 00:00:00', NULL, NULL),
(31, 18, 50, 'Status', 'The overall current well-being of subject that relates to their stability such as their employment, relationships and health.', 'y', '2018-07-23 00:00:00', NULL, NULL),
(32, 18, 50, 'History', 'Any incident or circumstances such as previous violent history, criminal record and any other concerning behaviors.', 'y', '2018-07-23 00:00:00', NULL, NULL),
(33, 18, 50, 'Threat', 'The nature of the initial report, documentation of written, verbal or online threats, weapons capability or access and any information on the direct danger posed.', 'y', '2018-07-23 00:00:00', NULL, NULL),
(34, 18, 50, 'Relationships', 'his personal connections', 'y', '2018-07-24 03:22:31', '2018-07-24 03:22:31', NULL),
(35, 18, 50, 'social media', 'findings on social media', 'y', '2018-08-16 18:41:59', '2018-08-16 18:41:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `case_list`
--

CREATE TABLE `case_list` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` enum('new','active','closed','archived') NOT NULL,
  `default_pic` varchar(250) NOT NULL,
  `summary_rank` int(11) NOT NULL,
  `urgency` int(11) NOT NULL,
  `case_owner_id` int(11) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `case_list`
--

INSERT INTO `case_list` (`id`, `account_id`, `user_id`, `title`, `description`, `status`, `default_pic`, `summary_rank`, `urgency`, `case_owner_id`, `sector_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, 'I have lost my mobile from office desk', 'lost one new byke from dehradun, in front of easyday, I think', 'active', 'case_report_363224_1531292789.jpeg', 6, 5, 6, 0, '2018-05-29 09:39:01', '2018-07-16 20:44:22', NULL),
(2, 2, 2, 'I have lost my money bag during travel in train', 'I have lost my money bag during travel in train. i hope someone turns it in.', 'new', '1529081861.jpg', 0, 2, 33, 0, '2018-05-31 06:43:10', '2018-06-15 16:57:41', NULL),
(3, 2, 2, 'Mental disorder due to fire from the office', 'Mental disorder due to fire from the office', 'active', '1527862068.JPG', 0, 2, 6, 0, '2018-05-31 15:13:40', '2018-06-14 15:20:18', NULL),
(4, 7, 16, 'lost my byke on saturday night', 'lost my byke on saturday night', 'new', '', 0, 1, 17, 0, '2018-06-01 10:45:05', '2018-06-01 10:45:05', NULL),
(5, 7, 17, 'created new case by tushar', 'created new case by tushar', 'active', '', 0, 3, 16, 0, '2018-06-01 10:53:06', '2018-06-01 10:53:06', NULL),
(6, 7, 17, 'test case created by tushar', 'test case created by tushar', 'active', '1527858851.JPG', 0, 1, 16, 0, '2018-06-01 13:14:11', '2018-06-01 13:14:11', NULL),
(7, 2, 2, 'case1', 'case1', 'new', '1528915658.png', 0, 1, 2, 0, '2018-06-04 18:27:45', '2018-08-03 20:00:59', NULL),
(8, 2, 2, 'testasdf', 'adding description from edit case window', 'closed', '1528920052.png', 0, 3, 2, 0, '2018-06-04 19:08:44', '2018-06-13 20:24:29', '2018-07-16 08:18:32'),
(9, 9, 24, 'test', 'd', 'active', '1528917412.jpg', 0, 2, 26, 0, '2018-06-13 19:16:52', '2018-06-13 19:16:52', NULL),
(10, 13, 41, 'test case posted under accenture account', 'test case posted under accenture account', 'active', '1529037022.jpg', 0, 2, 41, 0, '2018-06-15 04:30:22', '2018-06-15 04:30:22', NULL),
(11, 14, 43, 'case testtttttt', 'case testtttttt', 'new', '1529589291.jpeg', 0, 1, 43, 0, '2018-06-21 13:54:51', '2018-06-21 13:54:51', NULL),
(12, 15, 44, 'case created by GA1  and assign to ga1u1', 'case created by GA1  and assign to ga1u1', 'new', '630475_1531373990.jpeg', 0, 3, 46, 0, '2018-07-12 05:39:50', '2018-07-12 05:39:50', NULL),
(13, 15, 46, 'case created by ga1u1  and assign to ga1u2', 'case created by ga1u1  and assign to ga1u2', 'new', 'case_185196_1531375050.jpeg', 0, 2, 47, 0, '2018-07-12 05:54:00', '2018-07-12 06:03:12', NULL),
(14, 18, 50, 'Parkland Shooting', 'High School Shooting in Florida', 'active', 'case_60440_1532376945.jpg', 0, 4, 50, 0, '2018-07-23 20:14:29', '2018-07-23 20:16:02', NULL),
(15, 2, 2, 'case2', 'case2', 'new', 'case_143427_1534265801.jpeg', 0, 3, 5, 0, '2018-08-03 20:01:23', '2018-08-14 16:56:46', NULL),
(16, 2, 2, 'case3', 'case3', 'active', 'case_139580_1534265774.jpeg', 0, 3, 6, 0, '2018-08-03 20:01:46', '2018-08-14 16:56:19', NULL),
(17, 15, 46, 'test to check forum requirement', 'test to check forum requirement', 'new', '434766_1533385291.png', 0, 1, 46, 0, '2018-08-04 12:21:31', '2018-08-04 12:21:31', NULL),
(18, 18, 50, 'Andres Breivik', 'Norwegian camp shooter and gov building bomber', 'active', '673829_1534360529.webp', 0, 3, 50, 0, '2018-08-15 19:15:29', '2018-08-15 19:15:29', NULL),
(19, 18, 50, 'Jared Lee Loughner', 'political shooting', 'active', '52030_1534440753.jpg', 0, 3, 52, 0, '2018-08-16 17:32:33', '2018-08-16 17:32:33', NULL),
(20, 18, 50, 'testa', 'asd', 'new', 'case_867219_1535387769.PNG', 0, 3, 52, 0, '2018-08-16 21:51:54', '2018-08-27 16:36:25', '2018-08-16 09:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id_email` int(10) UNSIGNED NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `variable_name` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `variable` text NOT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id_email`, `created_date`, `variable_name`, `title`, `description`, `variable`, `subject`, `updated_at`, `created_at`) VALUES
(12, '2014-10-27 13:47:01', 'accountregistration', 'Your Account has been created.Please verify.', '<table cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px auto;border:1px solid black; font-family:arial; max-width: 960px;\"><tbody><tr><td style=\"background: #040404; color:#fff; border: 1px solid #dfdfdf; padding: 15px 20px;\"><img alt=\"digitalkheops\" src=\"http://computer-cloud-service.com/wp-content/uploads/2015/09/dummy-logo-300x140.png\" style=\"height:50px\" /></td></tr><tr><td style=\"padding: 15px 20px;\"><p style=\"font-size:16px;\">Dear {NAME},</p><p style=\"font-size:16px;\">Thank you for signing up at Digitalkheops, to activate your corresponding account,click <a href=\"{ACTIVATIONLINK}\">here</a</p></p><p>{SIGNATURE}</p></td></tr></tbody></table>', 'Dear {NAME}, Thank you for signing up at digitalkheops. \nUsername:{EMAIL}.<br>{SIGNATURE}\n\nplease click on link to verify your account.\n{ACTIVATIONLINK}\nThanks.', 'Your Account has been created', NULL, NULL),
(14, '2014-10-27 19:17:01', 'firstpaymentcompleted', 'Payment has been received successfully.', '<p>Salut {USER_NAME} ,<br />Nous avons bien re&ccedil;u votre d&eacute;p&ocirc;t et nous vous remercions<br />infiniment pour votre confiance.</p>\n<p>Vous trouverez ci-dessous une pi&egrave;ce jointe contenant une facture<br />de confirmation comme quoi vous avez bel et bien effectu&eacute;<br />votre d&eacute;p&ocirc;t.</p>\n<p>Votre num&eacute;ro de r&eacute;f&eacute;rence est le suivant : {TRANSACTION_ID}</p>\n<p><br />Merci et bonne journ&eacute;e.</p>', '<h2><span style=\"color: #4b67a1;\">Payment Invoice</span>&nbsp;</h2>\r\n<p>Hi {USER_NAME}</p>\r\n<p>We just wanted to drop you a quick note to let you know that we have received your recent payment .Your payment reference&nbsp;number is : {TRANSACTION_ID}</p>\r\n<p>Thank you very much. We really appreciate it.</p>\r\n<p>Thanks</p>\r\n<!--This is just a comment above the table...-->\r\n<p>&nbsp;</p>', 'Reçu de votre dépôt', NULL, NULL),
(15, '2014-10-27 19:17:01', 'refunded', 'You have asked for refund.', '<table cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px auto;border:1px solid black; font-family:arial; max-width: 960px;\"><tbody><tr><td style=\"background: #040404; color:#fff; border: 1px solid #dfdfdf; padding: 15px 20px;\"><img alt=\"digitalkheops\" src=\"{LOGO_IMAGE}\" style=\"height:50px\" /></td></tr><tr><td style=\"padding: 15px 20px;\"><p style=\"font-size:16px;\">Dear {NAME},</p><p style=\"font-size:16px;\">You have asked for refund. Amount will be credit in your account.</p></p><p>{SIGNATURE}</p></td></tr></tbody></table>', '<table cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 20px auto;border:1px solid black; font-family:arial; max-width: 960px;\"><tbody><tr><td style=\"background: #040404; color:#fff; border: 1px solid #dfdfdf; padding: 15px 20px;\"><img alt=\"digitalkheops\" src=\"{LOGO_IMAGE}\" style=\"height:50px\" /></td></tr><tr><td style=\"padding: 15px 20px;\"><p style=\"font-size:16px;\">Dear {NAME},</p><p style=\"font-size:16px;\">You have asked for refund. Amount will be credit in your account.</p></p><p>{SIGNATURE}</p></td></tr></tbody></table>', 'Your have asked for refund.', NULL, NULL),
(16, '2018-04-03 15:01:34', 'forgotpassword', 'Reset Password - Request from User ', 'Dear {NAME},\r\n\r\nWe received your request to Reset the Password.\r\n\r\nPlease use following link to reset your password,\r\nLink : {RESETCODE}\r\n\r\n{SIGNATURE}', '{NAME} - <span style=\"color:red\">Name of the user </span>\r\n{RESETCODE} - <span style=\"color:red\">Password reset code </span>\r\n{SIGNATURE} - <span style=\"color:red\">Signature of Email</span>', 'Password - Request from User', NULL, NULL),
(17, '2014-10-27 19:17:01', 'paymentcompleted', 'Payment has been received successfully.', '<p>&nbsp;</p>\n<p>Salut {USER_NAME} ,</p>\n<p><br />Nous avons bien re&ccedil;u votre paiement et nous vous remercions<br />infiniment pour votre confiance.</p>\n<p><br />Vous trouverez ci-dessous une pi&egrave;ce jointe contenant une facture<br />de confirmation comme quoi vous avez bel et bien effectu&eacute; votre paiement.</p>\n<p><br />Votre num&eacute;ro de r&eacute;f&eacute;rence est le suivant : {TRANSACTION_ID}<br />Merci et bonne journ&eacute;e.</p>', '<h2><span style=\"color: #4b67a1;\">Payment Invoice</span>&nbsp;</h2>\r\n<p>Hi {USER_NAME}</p>\r\n<p>We just wanted to drop you a quick note to let you know that we have received your recent payment .Your payment reference&nbsp;number is : {TRANSACTION_ID}</p>\r\n<p>Thank you very much. We really appreciate it.</p>\r\n<p>Thanks</p>\r\n<!--This is just a comment above the table...-->\r\n<p>&nbsp;</p>', 'Reçu de votre dépôt', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `factor_list`
--

CREATE TABLE `factor_list` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `source` varchar(250) NOT NULL,
  `occurance_date` date DEFAULT NULL,
  `target_chart_visibility` enum('y','n') NOT NULL DEFAULT 'n',
  `timeline_chart_visibility` enum('y','n') NOT NULL DEFAULT 'n',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `factor_list`
--

INSERT INTO `factor_list` (`id`, `account_id`, `user_id`, `sector_id`, `case_id`, `title`, `description`, `rank_id`, `source`, `occurance_date`, `target_chart_visibility`, `timeline_chart_visibility`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 2, 1, 1, 'lost mobile', 'lost mobile', 5, 'lost mobile', '2018-01-15', 'y', 'y', '2018-05-29 15:09:46', NULL, NULL),
(2, 2, 2, 2, 1, 'Bipolar Disorder', 'Bipolar Disorder', 1, 'Bipolar Disorder', '2017-12-04', 'y', 'y', '2018-05-29 15:10:14', NULL, NULL),
(3, 1, 1, 3, 1, 'arrest due to violence1', 'arrest due to violence', 9, 'arrest due to violence', '2018-03-13', 'y', 'y', '2018-05-29 15:11:10', NULL, NULL),
(4, 2, 5, 1, 1, 'grivence by general user', 'grivence by general user', 4, 'grivence by general user', '2017-09-04', 'y', 'y', '2018-05-29 15:14:52', NULL, NULL),
(5, 2, 2, 2, 3, 'bipolar disorder', 'bipolar disorder', 4, 'bipolar disorder', '2018-01-02', 'y', 'y', '2018-05-31 16:30:35', '2018-06-13 19:37:11', NULL),
(6, 7, 16, 7, 4, 'lost one new byke from dehradun, in front of easyday', 'lost one new byke from dehradun, in front of easyday', 1, 'lost one new byke from dehradun, in front of easyday', '2018-01-15', 'y', 'y', '2018-06-01 10:47:18', NULL, NULL),
(7, 1, 30, 8, 4, 'mental disorder', 'mental disorderwerwerwe', 8, 'mental disorder', '2018-04-09', 'y', 'y', '2018-06-01 10:47:45', NULL, NULL),
(8, 7, 16, 9, 4, 'jail', 'jail', 1, 'jail', '2018-01-31', 'y', 'y', '2018-06-01 10:48:23', NULL, NULL),
(9, 7, 16, 8, 4, 'bipolar disorder', 'bipolar disorder', 7, 'bipolar disorder', '2018-05-07', 'y', 'y', '2018-06-01 10:48:59', NULL, NULL),
(10, 7, 17, 8, 5, 'sizophenia', 'sizophenia', 4, 'sizophenia', '2018-06-04', 'y', 'y', '2018-06-01 10:53:49', NULL, NULL),
(11, 2, 6, 3, 1, 'test from user account', 'test from user account', 5, 'test from user account', '2018-05-07', 'y', 'y', '2018-06-01 13:40:15', NULL, NULL),
(12, 2, 2, 10, 8, 'test', 'sadf', 7, 'knife', '2014-04-22', 'y', 'y', '2018-06-04 19:17:17', NULL, '2018-07-16 08:18:32'),
(13, 2, 2, 2, 8, 'iolihkhkjh', 'jhgkjhg', 8, 'asdf', '2018-08-08', 'y', 'y', '2018-06-04 19:26:25', NULL, '2018-07-16 08:18:32'),
(14, 2, 2, 1, 8, 'klhl', 'kjkjh', 1, 'sdfasdf', '2012-02-03', 'y', 'y', '2018-06-04 19:34:35', NULL, '2018-07-16 08:18:32'),
(16, 2, 2, 2, 8, 'awe', 'trrty', 8, 'jb', '2017-02-03', 'y', 'y', '2018-06-04 19:42:50', NULL, '2018-07-16 08:18:32'),
(18, 2, 2, 2, 8, 'kj', ',jkh', 8, 'lk', '2018-08-09', 'y', 'y', '2018-06-04 19:55:52', NULL, '2018-07-16 08:18:32'),
(19, 2, 2, 2, 8, 'rrrrrrrr', 'asdf', 8, 'asdf', '2018-08-08', 'n', 'y', '2018-06-04 20:00:51', NULL, '2018-07-16 08:18:32'),
(20, 2, 2, 1, 1, 'newfactor', 'lkj', 4, 'asdf', '0000-00-00', 'y', 'y', '2018-06-04 20:10:58', NULL, NULL),
(22, 2, 2, 3, 8, 'asdf', 'asdf', 1, 'asdf', '2018-08-08', 'y', 'y', '2018-06-04 22:28:50', NULL, '2018-07-16 08:18:32'),
(23, 2, 2, 3, 8, 'asdfsad', 'asdfasdf', 4, 'asdfasdf', '2018-08-08', 'y', 'y', '2018-06-04 22:30:06', NULL, '2018-07-16 08:18:32'),
(25, 2, 2, 2, 4, 'testa', 'sdf', 8, 'sadf', '2017-02-08', 'y', 'y', '2018-06-13 19:11:45', NULL, NULL),
(26, 2, 2, 1, 4, 'test2', 'wyyt', 1, 'ty', '2018-02-02', 'y', 'y', '2018-06-13 19:13:16', NULL, NULL),
(28, 2, 2, 14, 3, 'test2', 'asdf', 3, 'asdf new edut', '2018-08-08', 'y', 'y', '2018-06-13 19:22:42', '2018-06-13 19:36:48', NULL),
(29, 2, 6, 13, 3, 'as', 'sdf', 7, 'asdf', '2017-09-09', 'y', 'n', '2018-06-13 19:23:08', NULL, NULL),
(31, 9, 24, 15, 3, 'rtryu', 'tyu', 9, '\'oj', '2017-08-08', 'y', 'n', '2018-06-13 19:30:13', NULL, NULL),
(32, 9, 24, 15, 3, 'fgh', 'fdh', 9, ';oj', '2012-08-09', 'y', 'n', '2018-06-13 19:34:16', NULL, NULL),
(33, 2, 6, 13, 3, 'lk', 'k,', 10, 'kjh', '2012-02-02', 'y', 'y', '2018-06-13 19:35:54', NULL, NULL),
(34, 2, 6, 2, 7, ';oij', 'lk;j', 4, 'asdf', '2222-06-06', 'y', 'y', '2018-07-03 19:53:49', NULL, NULL),
(35, 2, 6, 1, 7, 'wry', 'ety', 7, 'asdf', '2222-02-02', 'y', 'y', '2018-07-03 19:54:31', NULL, NULL),
(36, 2, 6, 3, 7, ';kih', 'jhtd', 8, 'wqer', '2222-02-22', 'y', 'y', '2018-07-03 19:56:24', NULL, NULL),
(37, 14, 43, 20, 11, 'suffer due to a byke accident', 'suffer due to a byke accident', 4, 'suffer due to a byke accident', '2012-11-05', 'y', 'y', '2018-07-04 04:15:33', NULL, NULL),
(38, 14, 43, 21, 11, 'sucide threat', 'sucide threat', 8, 'sucide threat', '2018-07-02', 'y', 'y', '2018-07-04 04:17:07', NULL, NULL),
(39, 14, 43, 19, 11, 'financial issue due to sudden loose the job', 'financial issue due to sudden loose the job', 9, 'financial issue due to sudden loose the job', '2018-07-01', 'y', 'y', '2018-07-04 04:22:05', NULL, NULL),
(40, 15, 44, 23, 12, 'FACTOR created by GA1', 'FACTOR created by GA1', 1, 'office colliges', '2018-07-17', 'y', 'y', '2018-07-12 05:42:05', NULL, NULL),
(41, 18, 50, 33, 14, 'Professional Shooter', 'He posted a comment saying that he wanted to be a professional school shooter', 2, 'posted comment', '2017-09-15', 'y', 'y', '2018-07-24 03:02:09', NULL, NULL),
(42, 18, 50, 32, 14, 'cutting', 'cut his arm on snapchap', 1, 'snapchat', '2016-09-14', 'y', 'y', '2018-07-24 03:05:44', NULL, NULL),
(43, 18, 50, 32, 14, 'multi police visits', 'over 7 years, police came to his house about 39 times', 4, 'police reports', '2017-02-02', 'y', 'n', '2018-07-24 03:17:58', NULL, NULL),
(44, 18, 50, 34, 14, 'lost friends', 'His friends stopped hanging with him when he got into fights at school.', 5, 'friends', '2016-04-03', 'y', 'y', '2018-07-24 03:24:09', NULL, NULL),
(45, 18, 50, 32, 14, 'saw dad die', 'saw father die when he was 5', 7, 'news', '2004-03-12', 'y', 'n', '2018-07-24 03:30:20', NULL, NULL),
(46, 18, 50, 31, 14, 'diagnosis', 'diagnosed with a string of disorders and conditions: depression, attention deficit hyperactivity disorder, emotional behavioral disability and autism, records from the state Department of Children and Families show. His mom told sheriff’s deputies he', 9, 'dr', '2017-03-03', 'y', 'n', '2018-07-24 03:42:32', NULL, NULL),
(47, 18, 50, 33, 14, 'citizen warning', 'someone called the sheriff’s office saying Cruz “could be a school shooter in the making.”', 6, 'citizen report', '2017-11-30', 'y', 'y', '2018-07-24 03:51:21', NULL, NULL),
(50, 2, 5, 10, 7, 'no time', 'no time', 9, 'sadf', '2222-03-05', 'y', 'y', '2018-08-03 20:08:19', NULL, NULL),
(51, 15, 46, 22, 17, 'cactixPhotoDrive', 'dasdad', 5, 'adadad', '2018-08-02', 'y', 'y', '2018-08-04 13:33:50', NULL, NULL),
(52, 2, 6, 1, 7, 'test', 'as', 7, 'sad', NULL, 'y', 'n', '2018-08-06 02:09:01', NULL, NULL),
(53, 2, 6, 2, 3, 'testa', 'sdfg', 3, 'dfgh', NULL, 'y', 'n', '2018-08-08 16:46:56', NULL, NULL),
(54, 2, 6, 3, 3, 'qwers', 'df', 4, 'sdfg', NULL, 'y', 'n', '2018-08-08 16:47:28', NULL, NULL),
(55, 2, 2, 1, 2, 'testaa', 'a', 3, 'sadf', '2018-08-08', 'y', 'y', '2018-08-08 17:08:06', NULL, NULL),
(56, 18, 50, 34, 14, 'Fight at school', 'attacked new bf of girl he liked', 7, 'school report', '2017-03-11', 'y', 'y', '2018-08-14 16:22:34', NULL, NULL),
(57, 1, 1, 31, 19, 'suspended from school', 'till he came back with dr note', 8, 'campus pd', '2018-08-08', 'y', 'y', '2018-08-16 18:19:44', NULL, NULL),
(58, 18, 50, 33, 19, 'bought gun', '9mm', 9, 'friends', '2018-08-04', 'y', 'y', '2018-08-16 18:34:00', NULL, NULL),
(59, 18, 53, 35, 20, 'gdr', 'dsfg', 5, 'dfgs', '2018-08-13', 'y', 'y', '2018-08-27 16:37:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `profile_pic` varchar(250) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `account_id`, `case_id`, `title`, `description`, `profile_pic`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 14, 11, 'smartdata', 'dfdf', '1529590885.jpeg', 43, '2018-06-21 14:21:25', '2018-06-21 16:09:50', NULL),
(2, 14, 11, 'test case posted under accenture account', 'okas', '1529593606.jpeg', 43, '2018-06-21 15:06:46', '2018-06-21 15:06:46', NULL),
(3, 14, 11, 'SD', 'sd', '1529597405.jpeg', 43, '2018-06-21 16:10:05', '2018-06-21 16:10:05', NULL),
(4, 2, 3, 'jkh', 'k.j', '1529974847.docx', 6, '2018-06-26 01:00:47', '2018-06-26 01:00:47', NULL),
(5, 2, 3, 'helen', 'deaf dog', '1529979447.jpg', 2, '2018-06-26 02:17:27', '2018-06-26 02:17:27', NULL),
(6, 14, 11, 'Target image', 'Target image', '1530624756.jpeg', 43, '2018-07-03 13:32:36', '2018-07-03 13:32:36', NULL),
(7, 2, 7, NULL, '', 'report_603608_1531228687.jpeg', 2, '2018-07-10 13:18:34', '2018-07-10 13:18:34', NULL),
(8, 2, 7, NULL, '', 'report_235209_1531228687.jpeg', 2, '2018-07-10 13:18:34', '2018-07-10 13:18:34', NULL),
(9, 2, 7, NULL, '', 'report_374630_1531228687.jpeg', 2, '2018-07-10 13:18:34', '2018-07-10 13:18:34', NULL),
(10, 2, 7, NULL, '', 'report_830690_1531228687.jpeg', 2, '2018-07-10 13:18:34', '2018-07-10 13:18:34', NULL),
(11, 2, 7, NULL, '', 'report_245588_1531228687.jpeg', 2, '2018-07-10 13:18:34', '2018-07-10 13:18:34', NULL),
(12, 2, 3, NULL, '', 'report_1531227284.jpeg', 2, '2018-07-10 17:41:11', '2018-07-10 17:41:11', NULL),
(13, 2, 3, NULL, '', 'report_1531227284.jpeg', 2, '2018-07-10 17:41:11', '2018-07-10 17:41:11', NULL),
(14, 2, 3, NULL, '', 'report_1531227284.jpeg', 2, '2018-07-10 17:41:11', '2018-07-10 17:41:11', NULL),
(15, 2, 1, NULL, '', 'report_293529_1531292789.jpeg', 2, '2018-07-11 07:06:52', '2018-07-11 07:06:52', NULL),
(16, 2, 1, NULL, '', 'report_612784_1531292789.jpeg', 2, '2018-07-11 07:06:52', '2018-07-11 07:06:52', NULL),
(17, 2, 1, NULL, '', 'report_524179_1531292789.jpeg', 2, '2018-07-11 07:06:52', '2018-07-11 07:06:52', NULL),
(18, 2, 1, NULL, '', 'report_363224_1531292789.jpeg', 2, '2018-07-11 07:06:52', '2018-07-11 07:06:52', NULL),
(19, 15, 13, 'health care', 'health care', '185196_1531375050.jpeg', 46, '2018-07-12 05:57:30', '2018-07-12 05:57:30', NULL),
(20, 2, 1, NULL, '', 'report_838333_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(21, 2, 1, NULL, '', 'report_478868_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(22, 2, 1, NULL, '', 'report_926874_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(23, 2, 1, NULL, '', 'report_55685_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(24, 2, 1, NULL, '', 'report_440658_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(25, 2, 1, NULL, '', 'report_150519_1531497492.jpeg', 1, '2018-07-13 15:58:29', '2018-07-13 15:58:29', NULL),
(28, 2, 16, 'bvbbv', 'bvvb', '139580_1534265774.jpeg', 2, '2018-08-14 16:56:14', '2018-08-14 16:56:14', NULL),
(29, 2, 15, 'vbvbv', 'vbv', '143427_1534265801.jpeg', 2, '2018-08-14 16:56:41', '2018-08-14 16:56:41', NULL),
(30, 18, 14, 'instagram post knives', 'crazy pic!', '836345_1534370275.jpeg', 50, '2018-08-15 21:57:55', '2018-08-15 21:57:55', NULL),
(31, 18, 14, 'manifesto', 'not real', '217271_1534370358.png', 50, '2018-08-15 21:59:18', '2018-08-15 21:59:18', NULL),
(32, 18, 14, 'school transcripts', 'including behavioral notes', '672175_1534370447.pdf', 50, '2018-08-15 22:00:47', '2018-08-15 22:00:47', NULL),
(33, 18, 20, 'dfg', 'sdfg', '867219_1535387769.PNG', 53, '2018-08-27 16:36:10', '2018-08-27 16:36:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`id`, `account_id`, `case_id`, `title`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'I have lost my mobile from office desk', 'lost one new byke from dehradun, in front of easyday, I think', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(2, 2, 2, 'I have lost my money bag during travel in train', 'I have lost my money bag during travel in train. i hope someone turns it in.', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(3, 2, 3, 'Mental disorder due to fire from the office', 'Mental disorder due to fire from the office', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(4, 7, 4, 'lost my byke on saturday night', 'lost my byke on saturday night', 16, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(5, 7, 5, 'created new case by tushar', 'created new case by tushar', 17, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(6, 7, 6, 'test case created by tushar', 'test case created by tushar', 17, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(7, 2, 7, 'case1', 'case1', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(8, 2, 8, 'testasdf', 'adding description from edit case window', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(9, 9, 9, 'test', 'd', 24, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(10, 13, 10, 'test case posted under accenture account', 'test case posted under accenture account', 41, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(11, 14, 11, 'case testtttttt', 'case testtttttt', 43, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(12, 15, 12, 'case created by GA1  and assign to ga1u1', 'case created by GA1  and assign to ga1u1', 44, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(13, 15, 13, 'case created by ga1u1  and assign to ga1u2', 'case created by ga1u1  and assign to ga1u2', 46, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(14, 18, 14, 'Parkland Shooting', 'High School Shooting in Florida', 50, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(15, 2, 15, 'case2', 'case2', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(16, 2, 16, 'case3', 'case3', 2, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(17, 15, 17, 'test to check forum requirement', 'test to check forum requirement', 46, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(18, 18, 18, 'Andres Breivik', 'Norwegian camp shooter and gov building bomber', 50, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(19, 18, 19, 'Jared Lee Loughner', 'political shooting', 50, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL),
(20, 18, 20, 'testa', 'asd', 50, '2018-08-28 05:19:02', '2018-08-28 05:19:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE `forum_post` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `replySubject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`id`, `thread_id`, `parent`, `children`, `replySubject`, `message`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 0, 'personal tragedies', '<p>he lost his mother recently and saw his dad die</p>', 50, '2018-08-14 15:39:19', '2018-08-14 15:39:19', NULL),
(2, 2, 0, 0, 'can he be committed involuntarily?', '<p>not in this state when it is not a family member or LE</p>', 50, '2018-08-16 18:17:14', '2018-08-16 18:17:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forum_threads`
--

CREATE TABLE `forum_threads` (
  `id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_threads`
--

INSERT INTO `forum_threads` (`id`, `forum_id`, `subject`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 14, 'personal tragedies', 50, '2018-08-14 15:39:19', '2018-08-14 15:39:19', NULL),
(2, 19, 'can he be committed involuntarily?', 50, '2018-08-16 18:17:14', '2018-08-16 18:17:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_options`
--

CREATE TABLE `general_options` (
  `options_id` int(10) UNSIGNED NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` text NOT NULL,
  `id_status` enum('1','2') NOT NULL,
  `updated_at` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_options`
--

INSERT INTO `general_options` (`options_id`, `option_name`, `option_value`, `id_status`, `updated_at`) VALUES
(1, 'site_title', 'Threat Assessment Tool', '1', '2017-11-15 09:25:02'),
(2, 'email', 'contact@tatapp.com', '1', '2017-11-15 09:25:02'),
(3, 'contactus_email', 'admin@tatapp.com', '1', '2017-11-15 09:25:02'),
(4, 'date_format', 'F j, Y', '1', NULL),
(5, 'time_format', 'H:i', '1', NULL),
(6, 'record_per_page', '8', '1', NULL),
(7, 'smtp_host', 'smtp.gmail.com', '1', NULL),
(8, 'smtp_port', '465', '1', NULL),
(9, 'smtp_email', 'projectmailer123@gmail.com', '1', NULL),
(10, 'smtp_password', 'temp@123', '1', NULL),
(11, 'copy_right', 'Copyright 2017 veloboerse, All Rights Reserved.', '1', NULL),
(12, 'contact_number', '2727626262', '1', '2017-11-15 09:25:02'),
(13, 'social_facebook', 'https://www.facebook.com/', '1', '2017-11-15 09:25:02'),
(14, 'social_twitter', 'https://twitter.com', '1', '2017-11-15 09:25:03'),
(15, 'social_googleplus', 'https://plus.google.com/', '1', '2017-11-15 09:25:02'),
(16, 'social_linkedin', 'https://www.linkedin.com/', '1', NULL),
(17, 'address', 'sdsdsdsd', '1', '2017-11-15 09:25:02'),
(19, 'email_signature', 'Thank You', '1', '2017-11-15 09:25:03'),
(20, 'social_linkedin', 'https://www.linkedin.com/', '1', NULL),
(21, 'iphone_link', 'https://www.appstore.com', '1', NULL),
(22, 'android_link', 'https://www.googleplay.com/1223345', '1', NULL),
(23, 'image_url', '', '1', NULL),
(24, 'social_instagram', 'https://www.instagram.com', '1', '2017-11-15 09:25:02'),
(25, 'social_youtube', 'https://www.youtube.com', '1', NULL),
(26, 'social_pinterest', 'https://in.pinterest.com/', '1', '2017-11-15 09:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2015_05_06_194030_create_youtube_access_tokens_table', 1),
(4, '2018_05_28_052237_create_roles_table', 1),
(5, '2018_05_28_052504_create_role_user_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `case_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(12) DEFAULT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `status` enum('new','active','hold','closed','archived') DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `isImport` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `account_id`, `case_id`, `title`, `details`, `name`, `phone_no`, `email_address`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `isImport`) VALUES
(1, 1, 1, 'I received threat from my', 'I received threat from my', '', '', '', 'new', 1, '2018-07-04 08:39:55', NULL, NULL, 'n'),
(2, NULL, NULL, 'Someone follow me each and every time', 'Someone follow me each and every time', '', '', '', 'new', 1, '2018-07-04 08:40:53', NULL, NULL, 'n'),
(3, 14, NULL, 'I have lost my mobile from office desk', 'I have lost my mobile from office desk', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:32:45', '2018-07-10 12:32:45', NULL, 'n'),
(4, 2, NULL, 'I have lost my mobile from office desk', 'I have lost my mobile from office desk', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:33:42', '2018-07-10 12:33:42', NULL, 'n'),
(5, 2, NULL, 'I have lost my mobile from office desk', 'I have lost my mobile from office desk', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:34:08', '2018-07-10 12:34:08', NULL, 'n'),
(6, 2, NULL, 'image duplicate issue', 'image duplicate issue', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:47:37', '2018-07-10 12:47:37', NULL, 'n'),
(7, 2, NULL, 'image duplicate issue ankit', 'image duplicate issue ankit', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:48:29', '2018-07-10 12:48:29', NULL, 'n'),
(8, 2, NULL, 'image duplicate issue sd', 'image duplicate issue sd', 'New York investigation house', '9831211793', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-10 12:51:32', '2018-07-10 12:51:32', NULL, 'n'),
(9, 2, 3, 'tat group image issue', 'tat group image issue', NULL, NULL, NULL, NULL, 0, '2018-07-10 12:54:44', '2018-07-10 17:41:11', NULL, 'y'),
(10, 2, NULL, 'ssssssssss', 'ssssssssss', NULL, NULL, NULL, NULL, 0, '2018-07-10 13:03:43', '2018-07-10 13:03:43', NULL, 'n'),
(11, 2, NULL, 'ssssssssss', 'ssssssssss', NULL, NULL, NULL, NULL, 0, '2018-07-10 13:17:49', '2018-07-10 13:17:49', NULL, 'n'),
(12, 2, 7, 'ok', 'ok', NULL, NULL, NULL, NULL, 0, '2018-07-10 13:18:07', '2018-07-10 13:18:34', NULL, 'y'),
(13, 2, NULL, 'I have lost my mobile from office desk tat', 'I have lost my mobile from office desk tat', NULL, NULL, NULL, NULL, 0, '2018-07-10 13:42:21', '2018-07-10 13:42:21', NULL, 'n'),
(14, 2, NULL, 'I am final testing the report module', 'I am final testing the report module', 'IBM logistic services', '9831211793', 'sapient@tatapp.com', NULL, 0, '2018-07-10 14:13:49', '2018-07-10 14:13:49', NULL, 'n'),
(15, 2, NULL, 'ok', 'ok', NULL, NULL, NULL, NULL, 0, '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL, 'n'),
(16, 1, NULL, 'smart people do allways smart work', 'smart people do allways smart work', 'smart people do allways smart work', '983121793', 'subhamca2003@gmail.com', NULL, 0, '2018-07-11 07:04:48', '2018-07-11 07:04:48', NULL, 'n'),
(17, 2, NULL, 'aaaa', 'aaaa', NULL, NULL, NULL, NULL, 0, '2018-07-11 07:05:05', '2018-07-19 00:08:46', '2018-07-19 12:08:46', 'n'),
(18, 2, 1, 'http://34.211.31.84:7011/home', 'http://34.211.31.84:7011/home', 'http://34.211.31.84:7011/home', NULL, NULL, NULL, 0, '2018-07-11 07:06:29', '2018-07-11 07:06:52', NULL, 'y'),
(19, 2, NULL, 'ssssssssssssss', 'ssssssssssssss', 'ssss', 'ssssssssss', 'testdefaultsector@tatapp.com', NULL, 0, '2018-07-13 12:59:03', '2018-07-16 20:39:36', '2018-07-16 08:39:36', 'n'),
(20, 2, 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'eee', 'aaaaaaaaa@aaa.aaaaaaaa', NULL, 0, '2018-07-13 15:58:12', '2018-07-13 15:58:44', '2018-07-13 03:58:44', 'y'),
(21, 2, NULL, 'test TAT form', 'lkj', 'asdf', 'asdf', 'asdf@asd.com', NULL, 0, '2018-07-17 15:08:18', '2018-07-31 10:52:30', NULL, 'y'),
(22, 15, NULL, 'test reprot gA1as', 'df', 'sadf', NULL, NULL, NULL, 0, '2018-07-17 15:09:57', '2018-07-17 15:09:57', NULL, 'n'),
(23, 16, NULL, 'kh', ';l', NULL, NULL, NULL, NULL, 0, '2018-07-23 20:03:29', '2018-07-23 20:03:29', NULL, 'n'),
(24, 18, NULL, 'fri report pdf', 'tat app extra', 'tushar', '5756756', 'tusharkanti@yopmail.com', NULL, 0, '2018-07-31 11:01:57', '2018-07-31 11:01:57', NULL, 'n'),
(25, 17, NULL, 'final testing on saturday', 'fgfg', NULL, NULL, NULL, NULL, 0, '2018-08-04 13:30:55', '2018-08-04 13:30:55', NULL, 'n'),
(26, 15, 13, 'zxxzxz', 'zxxz', NULL, NULL, NULL, NULL, 0, '2018-08-04 13:36:54', '2018-08-04 13:37:57', NULL, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `report_media`
--

CREATE TABLE `report_media` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_media`
--

INSERT INTO `report_media` (`id`, `report_id`, `title`, `file_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, NULL, '1531225965.jpeg', '2018-07-10 12:32:45', '2018-07-10 12:32:45', NULL),
(2, 3, NULL, '1531225965.jpeg', '2018-07-10 12:32:45', '2018-07-10 12:32:45', NULL),
(3, 3, NULL, '1531225965.jpeg', '2018-07-10 12:32:45', '2018-07-10 12:32:45', NULL),
(4, 3, NULL, '1531225965.jpeg', '2018-07-10 12:32:45', '2018-07-10 12:32:45', NULL),
(5, 4, NULL, '1531226022.jpeg', '2018-07-10 12:33:42', '2018-07-10 12:33:42', NULL),
(6, 4, NULL, '1531226022.jpeg', '2018-07-10 12:33:42', '2018-07-10 12:33:42', NULL),
(7, 4, NULL, '1531226022.jpeg', '2018-07-10 12:33:42', '2018-07-10 12:33:42', NULL),
(8, 5, NULL, '1531226048.jpeg', '2018-07-10 12:34:08', '2018-07-10 12:34:08', NULL),
(9, 5, NULL, '1531226048.jpeg', '2018-07-10 12:34:08', '2018-07-10 12:34:08', NULL),
(10, 5, NULL, '1531226048.jpeg', '2018-07-10 12:34:08', '2018-07-10 12:34:08', NULL),
(11, 6, NULL, '1531226857.jpeg', '2018-07-10 12:47:37', '2018-07-10 12:47:37', NULL),
(12, 6, NULL, '1531226857.jpeg', '2018-07-10 12:47:37', '2018-07-10 12:47:37', NULL),
(13, 7, NULL, '1531226909.jpeg', '2018-07-10 12:48:29', '2018-07-10 12:48:29', NULL),
(14, 7, NULL, '1531226909.jpeg', '2018-07-10 12:48:29', '2018-07-10 12:48:29', NULL),
(15, 8, NULL, '1531227092.jpeg', '2018-07-10 12:51:32', '2018-07-10 12:51:32', NULL),
(16, 8, NULL, '1531227092.jpeg', '2018-07-10 12:51:32', '2018-07-10 12:51:32', NULL),
(17, 8, NULL, '1531227092.jpeg', '2018-07-10 12:51:32', '2018-07-10 12:51:32', NULL),
(18, 9, NULL, '1531227284.jpeg', '2018-07-10 12:54:44', '2018-07-10 12:54:44', NULL),
(19, 9, NULL, '1531227284.jpeg', '2018-07-10 12:54:44', '2018-07-10 12:54:44', NULL),
(20, 9, NULL, '1531227284.jpeg', '2018-07-10 12:54:44', '2018-07-10 12:54:44', NULL),
(21, 10, NULL, '1531227823.jpeg', '2018-07-10 13:03:43', '2018-07-10 13:03:43', NULL),
(22, 10, NULL, '1531227823.jpeg', '2018-07-10 13:03:43', '2018-07-10 13:03:43', NULL),
(23, 11, NULL, '726854_1531228669.jpeg', '2018-07-10 13:17:49', '2018-07-10 13:17:49', NULL),
(24, 11, NULL, '739550_1531228669.jpeg', '2018-07-10 13:17:49', '2018-07-10 13:17:49', NULL),
(25, 12, NULL, '603608_1531228687.jpeg', '2018-07-10 13:18:07', '2018-07-10 13:18:07', NULL),
(26, 12, NULL, '235209_1531228687.jpeg', '2018-07-10 13:18:07', '2018-07-10 13:18:07', NULL),
(27, 12, NULL, '374630_1531228687.jpeg', '2018-07-10 13:18:07', '2018-07-10 13:18:07', NULL),
(28, 12, NULL, '830690_1531228687.jpeg', '2018-07-10 13:18:07', '2018-07-10 13:18:07', NULL),
(29, 12, NULL, '245588_1531228687.jpeg', '2018-07-10 13:18:07', '2018-07-10 13:18:07', NULL),
(30, 13, NULL, '84094_1531230141.jpeg', '2018-07-10 13:42:21', '2018-07-10 13:42:21', NULL),
(31, 13, NULL, '901980_1531230141.jpeg', '2018-07-10 13:42:21', '2018-07-10 13:42:21', NULL),
(32, 13, NULL, '962693_1531230141.jpeg', '2018-07-10 13:42:21', '2018-07-10 13:42:21', NULL),
(33, 13, NULL, '717838_1531230141.jpeg', '2018-07-10 13:42:21', '2018-07-10 13:42:21', NULL),
(34, 14, NULL, '983272_1531232029.jpeg', '2018-07-10 14:13:49', '2018-07-10 14:13:49', NULL),
(35, 14, NULL, '466780_1531232029.jpeg', '2018-07-10 14:13:49', '2018-07-10 14:13:49', NULL),
(36, 14, NULL, '742544_1531232029.jpeg', '2018-07-10 14:13:49', '2018-07-10 14:13:49', NULL),
(37, 15, NULL, '455730_1531232297.jpeg', '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL),
(38, 15, NULL, '272627_1531232297.jpeg', '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL),
(39, 15, NULL, '132671_1531232297.jpeg', '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL),
(40, 15, NULL, '241309_1531232297.jpeg', '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL),
(41, 15, NULL, '456938_1531232297.jpeg', '2018-07-10 14:18:17', '2018-07-10 14:18:17', NULL),
(42, 16, NULL, '184147_1531292688.jpeg', '2018-07-11 07:04:48', '2018-07-11 07:04:48', NULL),
(43, 16, NULL, '201405_1531292688.jpeg', '2018-07-11 07:04:48', '2018-07-11 07:04:48', NULL),
(44, 16, NULL, '763934_1531292688.jpeg', '2018-07-11 07:04:48', '2018-07-11 07:04:48', NULL),
(45, 18, NULL, '293529_1531292789.jpeg', '2018-07-11 07:06:29', '2018-07-11 07:06:29', NULL),
(46, 18, NULL, '612784_1531292789.jpeg', '2018-07-11 07:06:29', '2018-07-11 07:06:29', NULL),
(47, 18, NULL, '524179_1531292789.jpeg', '2018-07-11 07:06:29', '2018-07-11 07:06:29', NULL),
(48, 18, NULL, '363224_1531292789.jpeg', '2018-07-11 07:06:29', '2018-07-11 07:06:29', NULL),
(49, 20, NULL, '838333_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(50, 20, NULL, '478868_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(51, 20, NULL, '926874_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(52, 20, NULL, '55685_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(53, 20, NULL, '440658_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(54, 20, NULL, '150519_1531497492.jpeg', '2018-07-13 15:58:12', '2018-07-13 15:58:12', NULL),
(55, 24, NULL, '351306_1533034917.jpg', '2018-07-31 11:01:57', '2018-07-31 11:01:57', NULL),
(56, 25, NULL, '29949_1533389455.png', '2018-08-04 13:30:55', '2018-08-04 13:30:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contact_person` varchar(250) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `status` enum('y','n') DEFAULT 'y',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `account_id`, `name`, `website`, `contact_person`, `phone`, `email`, `notes`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'tcs investigation services', 'https://github.com/atrakeur/laravel-forum', 'subhendu das', '565656565', 'admin@tatapp.com', 'IBM packer and movers', 'y', 1, '2018-06-20 00:00:00', '2018-06-20 12:36:23', NULL),
(2, 2, 'John Lee', 'http://www.amazon.com', 'Johnny Lee', '9192745515', 'contact@epanicbutton.com', NULL, 'n', 6, '2018-06-21 00:00:00', '2018-06-21 04:17:57', NULL),
(3, 2, 'guard service', 'www.guards.com', 'asdf', '9192745515', 'sad@as.com', 'asdfasd', 'y', 2, '2018-06-28 00:00:00', '2018-06-28 16:59:43', NULL),
(4, 15, 'I am testing resources posted grom ga1 user', 'I am testing resources posted grom ga1 user', 'subhendu das', '565656565', 'subhendu@tatapp.com', 'cvcvc', 'y', 44, '2018-07-23 00:00:00', '2018-07-23 07:03:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', 'Global Admin', 'account,user', '2018-05-27 18:30:00', '2018-05-27 18:30:00'),
(2, 'agencySuperAdmin', 'Super Admin', 'user, case,task,factor,sector,subject,target,files,forum,reports,resources', '2018-05-27 18:30:00', '2018-05-27 18:30:00'),
(3, 'agencyAdmin', 'Admin', 'case,task,factor,sector,subject,target,files,forum,reports,resources', '2018-05-27 18:30:00', '2018-05-27 18:30:00'),
(4, 'agencyUser', 'User', 'task,factor,sector,subject,target,files,forum,reports,resources', '2018-05-27 18:30:00', '2018-05-27 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, '2018-05-29 14:21:04', NULL),
(3, 2, 3, '2018-05-29 14:30:31', NULL),
(4, 3, 4, '2018-05-29 14:33:57', NULL),
(5, 3, 5, '2018-05-29 15:08:10', NULL),
(6, 4, 6, '2018-05-29 15:25:38', NULL),
(7, 2, 7, '2018-05-31 03:48:51', NULL),
(8, 4, 8, '2018-05-31 10:19:33', NULL),
(9, 2, 9, '2018-05-31 10:33:55', NULL),
(10, 4, 10, '2018-05-31 10:36:54', NULL),
(11, 3, 11, '2018-05-31 11:56:55', NULL),
(12, 2, 12, '2018-05-31 14:01:51', NULL),
(13, 1, 13, '2018-05-31 14:08:41', NULL),
(14, 2, 14, '2018-05-31 14:10:01', NULL),
(15, 2, 14, '2018-05-31 14:12:54', NULL),
(16, 3, 15, '2018-05-31 15:17:45', NULL),
(17, 2, 16, '2018-06-01 10:38:52', NULL),
(18, 3, 17, '2018-06-01 10:42:48', NULL),
(19, 2, 18, '2018-06-04 16:17:16', NULL),
(20, 1, 19, '2018-06-04 16:22:07', NULL),
(21, 4, 20, '2018-06-04 16:31:23', NULL),
(22, 4, 21, '2018-06-04 16:37:35', NULL),
(23, 4, 19, '2018-06-04 16:47:16', NULL),
(24, 2, 22, '2018-06-04 17:01:15', NULL),
(25, 2, 23, '2018-06-04 17:11:15', NULL),
(26, 2, 23, '2018-06-04 17:19:58', NULL),
(27, 2, 24, '2018-06-04 17:22:30', NULL),
(28, 4, 25, '2018-06-04 17:25:44', NULL),
(29, 4, 26, '2018-06-04 17:26:27', NULL),
(30, 4, 27, '2018-06-04 17:27:18', NULL),
(31, 2, 28, '2018-06-04 18:03:40', NULL),
(32, 2, 28, '2018-06-04 18:04:51', NULL),
(33, 2, 29, '2018-06-04 18:14:59', NULL),
(34, 1, 30, '2018-06-04 21:23:43', NULL),
(35, 2, 14, '2018-06-04 21:26:45', NULL),
(36, 2, 31, '2018-06-12 18:57:58', NULL),
(37, 2, 32, '2018-06-13 18:24:32', NULL),
(38, 4, 33, '2018-06-13 18:33:37', NULL),
(39, 3, 34, '2018-06-13 18:34:31', NULL),
(40, 3, 35, '2018-06-13 18:35:36', NULL),
(41, 3, 36, '2018-06-13 18:38:43', NULL),
(42, 3, 37, '2018-06-13 18:40:58', NULL),
(43, 4, 38, '2018-06-13 19:45:39', NULL),
(44, 3, 39, '2018-06-13 19:46:25', NULL),
(45, 3, 40, '2018-06-13 20:41:44', NULL),
(46, 2, 41, '2018-06-14 14:30:36', NULL),
(47, 4, 42, '2018-06-14 14:51:31', NULL),
(48, 2, 43, '2018-06-15 05:23:21', NULL),
(49, 2, 44, '2018-07-12 05:08:37', NULL),
(50, 2, 45, '2018-07-12 05:18:23', NULL),
(51, 3, 46, '2018-07-12 05:21:26', NULL),
(52, 3, 47, '2018-07-12 05:44:00', NULL),
(53, 4, 48, '2018-07-12 07:32:01', NULL),
(54, 2, 49, '2018-07-16 11:36:09', NULL),
(55, 2, 50, '2018-07-23 20:13:01', NULL),
(56, 3, 51, '2018-07-31 02:24:05', NULL),
(57, 3, 52, '2018-08-15 19:16:21', NULL),
(58, 4, 53, '2018-08-15 19:17:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sector_list`
--

CREATE TABLE `sector_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_name` varchar(250) NOT NULL,
  `isActive` enum('y','n') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sector_list`
--

INSERT INTO `sector_list` (`id`, `sector_name`, `isActive`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Grievance', 'y', '2018-05-16 18:30:00', NULL, NULL),
(2, 'History of violence', 'y', NULL, NULL, NULL),
(3, 'Health', 'y', NULL, NULL, NULL),
(4, 'Status', 'y', NULL, NULL, NULL),
(5, 'Misc', 'y', NULL, NULL, NULL),
(6, 'Relations', 'y', NULL, NULL, NULL),
(7, 'Target', 'y', NULL, NULL, NULL),
(8, 'Threat', 'y', NULL, NULL, NULL),
(9, 'subhendu', 'y', NULL, NULL, NULL),
(10, 'dibyendu', 'y', NULL, NULL, NULL),
(11, 'cvcvcvcfgf', 'y', NULL, NULL, NULL),
(12, 'yyyyyyyyyyyyy', 'y', NULL, NULL, NULL),
(13, 'hhhhhhh', 'y', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `account_id`, `case_id`, `name`, `phone_number`, `cell_phone`, `address`, `state`, `city`, `zip_code`, `profile_pic`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'subhendu das', '9881212', '9432879516', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', '1529417152.jpg', 5, '2018-06-19 14:05:52', '2018-06-19 14:06:38', NULL),
(2, 2, 3, 'Johnny Lee', '9192745515', 'asdf', '401 22nd court south', 'Alabama', 'aew', '35205', '1529552003.jpeg', 2, '2018-06-21 03:33:23', '2018-06-21 03:35:37', NULL),
(3, 2, 8, 'Johnny Lee', '9192745515', '9192745515', '401 22nd court south', 'Alabama', 'Birmingham', '35205', '1529593247.jpg', 6, '2018-06-21 15:00:47', '2018-06-21 15:00:47', NULL),
(4, 14, 11, 'test subject', NULL, NULL, NULL, NULL, NULL, NULL, 'subject_1529590885.jpeg', 43, '2018-07-03 13:27:35', '2018-07-03 13:27:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `account_id`, `case_id`, `name`, `phone_number`, `cell_phone`, `address`, `state`, `city`, `zip_code`, `profile_pic`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'tushar kanti', '9831211793', '9432879516', 'Yamada Bldg. 2F, 5-18-11 Nishi-Nippori, Arakawa-ku, Tokyo 116-0013Tel: 03-3801-1122 Fax: 03-3801-1133', 'Tokyo', 'Tokyo', '79009', '1529417316.jpeg', 5, '2018-06-19 14:08:36', '2018-06-19 14:08:36', NULL),
(2, 14, 11, 'Target image', '6666666666666', '66666666666', NULL, NULL, NULL, NULL, 'target_1530624756.jpeg', 43, '2018-07-03 13:38:45', '2018-07-03 13:38:45', NULL),
(3, 2, 7, 'asdf', '333333333', '555555555555', NULL, NULL, NULL, NULL, 'target_report_235209_1531228687.jpeg', 5, '2018-07-16 20:45:56', '2018-07-16 20:45:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `task_assigned` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('new','assigned','in_progress','delayed','closed') NOT NULL DEFAULT 'new',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `account_id`, `case_id`, `title`, `description`, `task_assigned`, `due_date`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'trump task 3', 'fgfgf', 6, '2018-04-02', 'in_progress', 2, '2018-06-13 14:21:30', NULL, NULL),
(2, 1, 1, 'trumptask 2', 'sdsd', 1, '2018-06-11', 'assigned', 1, '2018-06-13 14:30:21', NULL, NULL),
(3, 1, 1, 'graytask2', 'need to be police verification before', 4, '2018-06-12', 'assigned', 1, '2018-06-19 14:10:27', NULL, NULL),
(4, 2, 3, 'look for table', 'anywhere', 5, '2033-08-23', 'closed', 5, '2018-06-21 03:51:42', NULL, NULL),
(5, 1, 3, 'gray task1', 'at the coffee shop', 4, '2222-04-04', 'assigned', 1, '2018-06-26 02:15:45', NULL, NULL),
(6, 2, 8, 'task from test', 'lkj', 2, '9999-08-08', 'delayed', 2, '2018-06-26 02:22:56', NULL, '2018-07-16 08:18:32'),
(7, 2, 3, 'task testa', 'sdf', 2, '2019-09-09', 'delayed', 6, '2018-06-28 16:16:04', NULL, NULL),
(8, 2, 3, 'new task', 'mnb', 6, '1111-01-01', 'new', 2, '2018-06-28 16:32:47', NULL, NULL),
(9, 2, 2, 'task4trump', 'ljk', 6, '9999-09-09', 'delayed', 6, '2018-06-28 16:38:23', NULL, NULL),
(10, 2, 1, 'taskjohn2', 'asdf', 2, '2222-04-04', 'in_progress', 2, '2018-06-28 16:53:24', NULL, NULL),
(11, 2, 2, 'delayed task for john', 'alskdjf', 2, '3333-03-03', 'delayed', 2, '2018-06-28 16:58:50', NULL, NULL),
(12, 14, 11, 'passport verification and police verification need to be completed', 'passport verification and police verification need to be completed', 43, '2018-07-16', 'assigned', 43, '2018-07-04 04:20:01', NULL, NULL),
(13, 2, 3, 'test delayed task', 'l;kj', 2, '2222-02-02', 'closed', 2, '2018-07-11 17:44:38', NULL, NULL),
(14, 15, 12, 'TASK created by GA1  and assign to ga1u1', 'TASK created by GA1  and assign to ga1u1', 46, '2018-07-24', 'new', 44, '2018-07-12 05:40:48', NULL, NULL),
(15, 15, 13, 'task created by ga1u2', 'task created by ga1u2', 47, '2018-07-03', 'new', 46, '2018-07-12 05:55:25', NULL, NULL),
(16, 15, 12, 'task placed by ga1u3', 'task placed by ga1u3', 44, '2018-07-25', 'assigned', 48, '2018-07-12 07:36:47', NULL, NULL),
(17, 15, 13, 'task placed by ga1u3', 'task placed by ga1u3', 46, '2018-07-25', 'delayed', 46, '2018-07-12 07:37:21', NULL, NULL),
(18, 15, 12, 'task 1', 'task 1', 47, '2018-07-25', 'assigned', 44, '2018-07-12 08:21:57', NULL, NULL),
(19, 15, 12, 'task created by user ga1u3 and assign to Admin GA1', 'task created by user ga1u3 and assign to Admin ga1', 44, '2018-07-24', 'delayed', 48, '2018-07-12 12:30:38', NULL, NULL),
(20, 15, 12, 'task created by user ga1u3 and assign to Admin ga1u1', 'task created by user ga1u3 and assign to Admin ga1u1', 46, '2018-08-16', 'in_progress', 48, '2018-07-12 12:32:23', NULL, NULL),
(21, 15, 12, 'in progress test', 'in progress test', 47, '2018-07-25', 'in_progress', 48, '2018-07-12 12:53:23', NULL, NULL),
(22, 15, 12, 'ghghh', 'ghgh', 47, '2018-07-25', 'in_progress', 48, '2018-07-12 12:54:26', NULL, NULL),
(23, 15, 13, 'Tas created by ga1u3@gmail.com and assigned to ga1u1', 'Tas created by ga1u3@gmail.com and assigned to ga1u1', 46, '2018-07-23', 'delayed', 48, '2018-07-14 11:59:39', NULL, NULL),
(24, 15, 13, 'saturday urgent test assign ga1u1', 'saturday urgent test', 46, '2018-07-24', 'delayed', 46, '2018-07-14 12:22:11', NULL, NULL),
(25, 18, 14, 'Do a Background Check', 'check civil records too', 50, '2018-08-29', 'new', 50, '2018-08-14 14:16:24', NULL, NULL),
(26, 18, 14, 'talk to Psych', 'who did the assessment on him', 50, '2018-08-23', 'assigned', 50, '2018-08-14 14:18:05', NULL, NULL),
(27, 18, 19, 'talk to his parents', 'to see what they think', 52, '2018-09-09', 'in_progress', 50, '2018-08-16 18:46:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `cell_phone` varchar(250) NOT NULL,
  `status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1-Enabled 2-Disabled 3-Deleted',
  `email_verify` enum('0','1') NOT NULL COMMENT '0 for not verified, 1 for verified',
  `remember_token` varchar(100) DEFAULT NULL,
  `password_reset_code` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `cell_phone`, `status`, `email_verify`, `remember_token`, `password_reset_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'admin@tatapp.com', '$2y$10$J2pq2osNFX0seWYM7R.1KOTQ.d3czN7KRW4768CHoRLOax3DEyUMC', 'admin', 'admin', '', '', '1', '0', NULL, NULL, '2018-03-05 07:30:00', '2018-03-06 19:06:55', NULL),
(2, 2, 'agency1@tatapp.com', '$2y$10$2/ERe0/PHrssNPt6atZE7O/xjMTyzquzwJn6NDv4dXveoF3i16VFO', 'John', 'Gray', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-05-29 08:51:04', '2018-05-29 08:51:04', NULL),
(3, 3, 'agency2@tatapp.com', '$2y$10$yTLYi2QGbTAoVxssl0LmY.9LzVZdA0V4p1/F0yrRb1UHYY1YvbEVO', 'agency 2', '', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-05-29 09:00:31', '2018-05-29 09:00:31', NULL),
(4, 1, 'sauser1@gmail.com', '$2y$10$ocdiZvMiGPc/7.vrwc7FUu8P/mOinarzk93hlyLSqWstajhY5/5LW', 'sa user 1', 'sa', '', '', '1', '0', NULL, NULL, '2018-05-29 09:03:57', '2018-05-29 09:03:57', NULL),
(5, 2, 'agencyadmin1@tatapp.com', '$2y$10$xrEszrP4jHeOfAGyzf1diO1d/GwfYljYMsFXR.x9sd5AUCTDPdHqW', 'Richard', 'Gray', '', '', '1', '0', NULL, NULL, '2018-05-29 09:38:09', '2018-05-29 09:38:09', NULL),
(6, 2, 'agency1user1@tatapp.com', '$2y$10$M9URJ4z.B.S3Qtqw/KZbJeuxF79n/mDcRBQ2omzH0NOdkGGy7ilDC', 'Donald', 'Trump', '', '', '1', '0', NULL, NULL, '2018-05-29 09:55:38', '2018-05-29 09:55:38', NULL),
(7, 4, 'account1@tatapp.com', '$2y$10$uuUAOZBmShFkPnIB6i4MteviX0DrRMVRhPw3RxMrvmjr.oHGUVjou', 'account 1', '', '9432879516', '12345678a', '1', '0', NULL, NULL, '2018-05-30 22:18:51', '2018-05-30 22:18:51', NULL),
(8, 3, 'agency2agencyuser1@tatapp.com', '$2y$10$29e8OTCvZeEJoNGXylOSu.DrffJ50K95DuFEc9a6b0qxVOqmEfZEG', 'agency 2', 'agency user 1', '', '', '3', '0', NULL, NULL, '2018-05-31 04:49:33', '2018-05-31 08:29:56', NULL),
(9, 5, 'account2@tatapp.com', '$2y$10$ws6e2Hwn1FvglgXTn1eIJOu0b7qK.VCmlcBbPolTZ4h495ke2mEfO', 'account2', '', '9432879516', '9831211793', '1', '0', NULL, NULL, '2018-05-31 05:03:55', '2018-05-31 05:03:55', NULL),
(10, 5, 'account2agencyuser1@gmail.com', '$2y$10$DHoVl.KGCyXDXTaHWAF62.T6SKgFFuwbJKQp30QYQjfjYBCRiOJu2', 'account 2', 'agency user', '', '', '3', '0', NULL, NULL, '2018-05-31 05:06:54', '2018-05-31 08:24:20', NULL),
(11, 5, 'account2user2@gmail.com', '$2y$10$eiKK18aAdT6oNrKpdU88lOKH0Qiq2NYd.nHSCeu2UYlefg1S2T2.6', 'subhendu', 'das', '', '', '1', '0', NULL, NULL, '2018-05-31 06:26:55', '2018-05-31 06:26:55', NULL),
(12, 6, 'ibm@tatapp.com', '$2y$10$tWNBx3aIKngnk0rFjalBSO9VLxrbxjUXhWEguQi8ykOPFYWpm1qYa', 'IBM detective agency', '', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-05-31 08:31:51', '2018-05-31 08:31:51', NULL),
(13, 6, 'ibmusa@tatapp.com', '$2y$10$8z9L4eY00ILvJ0V58SqmiOt.JBxqQOnisCMZY/S6b0GJ7ZU6Tglpi', 'ibm kolkata', 'head office', '', '', '1', '0', NULL, NULL, '2018-05-31 08:38:41', '2018-05-31 08:38:41', NULL),
(14, 6, 'asa@ibm.com', '$2y$10$DuzqBFjurg8vao.DrE/9FOjKKXKgArqZzJXgbqU1HFjoNp3g8.7Ka', 'ibm branch 1', 'office', '', '', '1', '0', NULL, NULL, '2018-05-31 08:40:01', '2018-06-04 21:26:45', NULL),
(15, 2, 'john@tatapp.com', '$2y$10$w3zB3E1qbq4LqVKl5hIcFussz38y4vN7eRWedZv7Coj0ny16e0flW', 'john', 'gray', '', '', '3', '0', NULL, NULL, '2018-05-31 15:17:45', '2018-05-31 15:35:03', NULL),
(16, 7, 'gaurav@tatapp.com', '$2y$10$LK1mMn7mjJxb8MVfQN0ZWOqClmW/Lj94opfpz.UJaHJwXe8eiNC9G', 'gourav account', '', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-06-01 10:38:52', '2018-06-01 10:40:02', NULL),
(17, 7, 'tushar@tatapp.com', '$2y$10$PMBIqhuTzsHlh.SrQD5Gp.RXZngidVvv.9MT2YJncil7ExUipLtnG', 'tushar', 'kant', '', '', '1', '0', NULL, NULL, '2018-06-01 10:42:48', '2018-06-01 10:42:48', NULL),
(18, 8, 'johnnylee27@gmail.com', '$2y$10$ZrD9t3TZr3r9GMpeWFK.uugNGcnxb74YE9ZKDT2gzZ/DcEbCXCfSS', 'testnewaccount', '', '9192745515', '9192745515', '1', '0', NULL, '69536e6cd621c52aed62c098bf0e9b7f', '2018-06-04 16:17:16', '2018-06-04 17:09:22', NULL),
(19, 8, 'asd@lc.om', '$2y$10$6MSBIJ6G4bvalm3qvE5.N.h2h1Wi3R82a/h1kWPABSHN1czzjEPES', 'testnewuserfornewaccount', 'sadf', '', '', '3', '0', NULL, NULL, '2018-06-04 16:22:07', '2018-06-04 16:59:37', NULL),
(20, 8, 'johnnsadylee27@gmail.com', '$2y$10$fpl8MdyOL2HUXDFGPdwlA.HhXHZKRMwg/u/ZLg3y6EGOOIWnns4AS', 'standard user', 'testnewaccount', '', '', '1', '0', NULL, NULL, '2018-06-04 16:31:23', '2018-06-04 16:31:23', NULL),
(21, 2, 'test@test.cpom', '$2y$10$LGDkVDNllCAum7GxLEE6ROnt5HMH0sWN2P68YmCkwaeIrEK0zW.Re', 'tat group', 'agencyuser1', '', '', '3', '0', NULL, NULL, '2018-06-04 16:37:35', '2018-06-04 16:54:44', NULL),
(22, 0, 'test@tejhhjest.cpom', '$2y$10$wdi3A/OA/7U5IWpkzGNb1eUnXNHmy4007jeFZIVXdwv3zkbPcHnB2', 'agencysuperadmin', 'testnewaccount', '', '', '1', '0', NULL, NULL, '2018-06-04 17:01:15', '2018-06-04 17:01:15', NULL),
(23, 9, 'jlee@peaceatwork.org', '$2y$10$brgCUUJrgoX49fn3f7WYt.6GB6yXqzXidp677.6BwZShQc4x76b7q', 'testaccount2', 'super', '9192745515', '8767866767', '3', '0', NULL, NULL, '2018-06-04 17:11:15', '2018-06-04 17:21:33', NULL),
(24, 9, 'asdd@lc.om', '$2y$10$W2UG8up9qrTINTx/Sc3NbuMQA3rh4vKlgQlf8zSt63yIQstUsGiWu', 'newaccounttest2', 'super', '', '', '1', '0', NULL, NULL, '2018-06-04 17:22:30', '2018-06-13 20:40:07', NULL),
(25, 9, 'aswdd@lc.om', '$2y$10$YTBpKF19yAk.5j4..Cr3BuW3SpNdhCkt0x4/zIIRtClpJlR7VKe.C', 'newaccounttest2', 'standard user1', '', '', '1', '0', NULL, NULL, '2018-06-04 17:25:44', '2018-06-04 17:25:44', NULL),
(26, 9, 'asdd@l1c.om', '$2y$10$I/3.a9O/NX2Pz5P1xQEIru738I4aM.m4Hl9WfaGpWS4jqkBy54coi', 'newaccounttest2', 'stadard2', '', '', '1', '0', NULL, NULL, '2018-06-04 17:26:27', '2018-06-04 17:26:27', NULL),
(27, 9, 'asddd@lc.om', '$2y$10$DBykM8AWkocE5F841aLnfuQo8aBR2aXe9.7IezOcMbcoBKY65LA.O', 'newaccounttest2', 'standard3', '', '', '1', '0', NULL, NULL, '2018-06-04 17:27:18', '2018-06-04 17:27:18', NULL),
(28, 10, 'test@tester.com', '$2y$10$3n/RBgIOOLsmUgM7Ph/nAuwMPv2GggqPTFDyHDAIaZ9aHCrSUZdf2', 'testaccount3', 'account3superadmin', '9192745515', '9192745515', '3', '0', NULL, NULL, '2018-06-04 18:03:40', '2018-06-04 18:14:15', NULL),
(29, 10, 'asdddd@lc.om', '$2y$10$BqzayM3o2xGQpH/kzilnTeVOXuNI9ClqzsinLptSgluq34Zxv/LF6', 'account3', 'superadmin', '', '', '1', '0', NULL, NULL, '2018-06-04 18:14:59', '2018-06-04 18:14:59', NULL),
(30, 1, 'addmin@tatapp.com', '$2y$10$SFqJt4StHxM0qvONtaTC5uhikrkTLYN7.OEI5tdaL9CEcMf3Z3rce', 'newsuperadmin', 'test', '', '', '1', '0', NULL, NULL, '2018-06-04 21:23:43', '2018-06-04 21:23:43', NULL),
(31, 11, 'johnnylee27@gssmail.com', '$2y$10$euOKrbPnJETBmS8RH8yAi.fdiQRs9qiGNcN7SVVWnv5ibb9ZfODZq', 'JLtest', '', '9192745515', '9192745515', '1', '0', NULL, NULL, '2018-06-12 18:57:58', '2018-06-12 18:57:58', NULL),
(32, 12, 'lee@gmail.com', '$2y$10$Il7w0A4VvqG7CTiGPp7I4.OrtoRX.lqUr2ZNtw8ttLlY9XGjMLzqm', 'testshortpassword', '', '9192745515', '9192745515', '1', '0', NULL, NULL, '2018-06-13 18:24:32', '2018-06-13 18:24:32', NULL),
(33, 2, 'sad@as.com', '$2y$10$ZvaFl8wDIgkPBbRU.Kk.veZ.d4M0IOtiuTLDRU8hBqgwFo2B34M0G', 'testnewuser', 'asdf', '', '', '3', '0', NULL, NULL, '2018-06-13 18:33:37', '2018-07-31 02:21:04', NULL),
(34, 2, 'kl@a.com', '$2y$10$YAcNhS7n03LL2S7DKHGle.S1Zjnd5NrpcCP0uATj0zlAxezb59QX.', 'addnewuser', 'asdf', '', '', '3', '0', NULL, NULL, '2018-06-13 18:34:31', '2018-08-01 06:33:03', NULL),
(35, 2, 'dsdf@ad.com', '$2y$10$ppy0XRd5WYh31M6Qanx2UOo5GfewCS.x61pGmHQ4KVjY8VWkE3qsG', 'er', 'rd', '', '', '3', '0', NULL, NULL, '2018-06-13 18:35:36', '2018-06-13 20:12:32', NULL),
(36, 4, 'asdf@xae.om', '$2y$10$P2wODFXWaAL5oBLrANPnBux5TWwPnVTOvP1T7tiUftrYbzzm3snX2', 'fq', 'asdf', '', '', '1', '0', NULL, NULL, '2018-06-13 18:38:43', '2018-06-13 18:38:43', NULL),
(37, 12, 'asdf@xade.om', '$2y$10$XhAy5hx4A9hOlZkubcsZge5MK9epkM.XDgUhbio2x8YLHVYPDQC4K', 'testsecond', 'useless', '', '', '1', '0', NULL, NULL, '2018-06-13 18:40:58', '2018-06-13 18:42:23', NULL),
(38, 9, 'asdf@asd.com', '$2y$10$BR6CKxqhTDP86aQQYCsxpeEihlo6rfI8AAtU87ZihDfOrtYsZHehu', 'dfg', 'adsf', '', '', '1', '0', NULL, NULL, '2018-06-13 19:45:39', '2018-06-13 19:45:39', NULL),
(39, 9, 'fgh@lc.om', '$2y$10$U0EH8pA5RLG1JUFQImRPLO9ypPbDGvaLKuCH/dEJJVU/4wteA.x0K', 'dsg', 'sdfg', '', '', '3', '0', NULL, NULL, '2018-06-13 19:46:25', '2018-06-13 20:11:56', NULL),
(40, 9, 'g@asld.com', '$2y$10$Vo1prcOw4aNdDRRL6dcCz.W2nAny5wTF/HyrDvsjPOxFd4bCL.U0C', 'ghjgh', 'dfhjfd', '', '', '1', '0', NULL, NULL, '2018-06-13 20:41:44', '2018-06-13 20:41:44', NULL),
(41, 13, 'accenture@tatapp.com', '$2y$10$4B.lF2jr28c5rNuzdj495.IsNU2lyCFvRB8f4rR3fnq.CxYCY7U6G', 'accenture', '', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-06-14 14:30:36', '2018-06-14 14:30:36', NULL),
(42, 13, 'sad@addds.com', '$2y$10$DMwa.SUb3XoqIFZoahOsUe7jOrLMZjoDPU54wBUQZpUd/t0Rg0ZYW', 'newaccounttest', 'asdf', '', '', '1', '0', NULL, NULL, '2018-06-14 14:51:31', '2018-06-14 14:51:31', NULL),
(43, 14, 'sapient@tatapp.com', '$2y$10$RlzUEStrNeZrDjmzS1pJ5OnAFLJEi3xczzYNRUG8fMAUIc42aNhe.', 'sapient group', '', '9432879516', '12345678', '1', '0', NULL, NULL, '2018-06-15 05:23:21', '2018-06-15 05:23:21', NULL),
(44, 15, 'ga1@gmail.com', '$2y$10$3wwKw6ML6G.rqWgH/cOFZugwIwgwa93fk3U5ytTpv/SfmRMpm3Aia', 'ga1', 'sdf', '9432879516', '9831211793', '1', '0', NULL, NULL, '2018-07-12 05:08:37', '2018-07-23 04:38:19', NULL),
(45, 16, 'ga2@gmail.com', '$2y$10$Ri6E7dcc2HRQ3Rt/W0NwNenezF2jdF3hXpH/hmHhGQOWEHfGVFk7m', 'GA2', '', '9432879516', '9831211793', '1', '0', NULL, NULL, '2018-07-12 05:18:23', '2018-07-12 05:18:23', NULL),
(46, 15, 'ga1u1@gmail.com', '$2y$10$ZsdZ/bRbYKHpa9QhyRMVWOc0EoRX.GVg51U2u16yydQW8mzjzur3O', 'ga1u1', 'ga1u1', '', '', '1', '0', NULL, NULL, '2018-07-12 05:21:26', '2018-07-12 05:21:26', NULL),
(47, 15, 'ga1u2@gmail.com', '$2y$10$alHMluXGHubqqIEg99FWKeZ.jUoHa2qodUGMO4cxM4uJxme2xG9UC', 'ga1u2', 'ga1u2', '', '', '1', '0', NULL, NULL, '2018-07-12 05:44:00', '2018-07-12 05:44:00', NULL),
(48, 15, 'ga1u3@gmail.com', '$2y$10$g.s7ot93lwDduD.1Kca42u3nfS3qO5bHyv4n/.umwFTIVQd1dyTdy', 'ga1u3', '-user', '', '', '1', '0', NULL, NULL, '2018-07-12 07:32:01', '2018-07-12 07:32:01', NULL),
(49, 17, 'subhamca2003@gmail.com', '$2y$10$7jG8oRuIoa5F7ZSmofdKzugjybxNxSh2awhLFs7OEBGJ5AKM9GotS', 'bankjp1', '', '9432879516', '12345678', '1', '0', NULL, 'e0ffe33c0d886b9441e31efe402b9767', '2018-07-16 11:36:09', '2018-07-16 11:38:07', NULL),
(50, 18, 'demo@peaceatwork.org', '$2y$10$KL.lLwPpaGHtQYMGk6DAUOdjZNJud99MOGSHQuo5dkp1XI/.qM0WG', 'Demo', '', '9192745515', '9192745515', '1', '0', NULL, NULL, '2018-07-23 20:13:01', '2018-07-23 20:13:01', NULL),
(51, 2, 'nuadmin@sss.com', '$2y$10$v1ISgvr3VIuJ.5GvxxaOkuF8fcMwgNAajAqEnkJAd7PXCFiS7lgZ2', 'nuadmin', 'asd', '', '', '1', '0', NULL, NULL, '2018-07-31 02:24:05', '2018-07-31 02:24:05', NULL),
(52, 18, 'demod@peaceatwork.org', '$2y$10$ZqSVu6hRa.UdhVKRYWWI1up7m.ZiKJQ1RzK8G.Xq.zEXI9v7VspKG', 'admin', 'demo', '', '', '1', '0', NULL, NULL, '2018-08-15 19:16:21', '2018-08-15 19:16:21', NULL),
(53, 18, 'asjdd@lc.om', '$2y$10$bow9LEls0ygpMjpVRliVoOiI/5qzxM7ediTW0q9oh8VU9PbcbfadC', 'user', 'demo', '', '', '1', '0', NULL, NULL, '2018-08-15 19:17:07', '2018-08-15 19:17:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `account_sector`
--
ALTER TABLE `account_sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_list`
--
ALTER TABLE `case_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id_email`);

--
-- Indexes for table `factor_list`
--
ALTER TABLE `factor_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `general_options`
--
ALTER TABLE `general_options`
  ADD PRIMARY KEY (`options_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `report_media`
--
ALTER TABLE `report_media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `sector_list`
--
ALTER TABLE `sector_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `account_sector`
--
ALTER TABLE `account_sector`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `case_list`
--
ALTER TABLE `case_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id_email` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `factor_list`
--
ALTER TABLE `factor_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_options`
--
ALTER TABLE `general_options`
  MODIFY `options_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `report_media`
--
ALTER TABLE `report_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `sector_list`
--
ALTER TABLE `sector_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
