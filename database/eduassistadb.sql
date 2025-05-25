-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 02:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduassistadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminrule`
--

CREATE TABLE `adminrule` (
  `UserID` int(11) NOT NULL,
  `AdminRuleID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminrule`
--

INSERT INTO `adminrule` (`UserID`, `AdminRuleID`) VALUES
(27, '51c'),
(66, '37a'),
(74, '37a'),
(97, '37a');

-- --------------------------------------------------------

--
-- Table structure for table `auditlogs`
--

CREATE TABLE `auditlogs` (
  `LogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Action` varchar(255) NOT NULL,
  `ActionDetails` text DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auditlogs`
--

INSERT INTO `auditlogs` (`LogID`, `UserID`, `Action`, `ActionDetails`, `Timestamp`) VALUES
(1, 74, 'Login', 'Successful Login', '2025-03-08 01:57:17'),
(10, 27, 'Login', 'Successful Login', '2025-03-08 04:33:43'),
(12, 74, 'Login', 'Successful Login', '2025-03-08 15:20:15'),
(13, 27, 'Login', 'Successful Login', '2025-03-08 22:30:16'),
(14, 66, 'Login', 'Successful Login', '2025-03-08 22:43:55'),
(17, 95, 'Login', 'Successful Login', '2025-03-09 04:31:53'),
(18, 74, 'Login', 'Successful Login', '2025-03-10 10:53:07'),
(19, 50, 'Login', 'Successful Login', '2025-03-10 10:54:43'),
(22, 51, 'Login', 'Successful Login', '2025-03-11 03:27:11'),
(24, 50, 'Login', 'Successful Login', '2025-03-11 04:14:08'),
(25, 50, 'Login', 'Successful Login', '2025-03-11 04:15:26'),
(26, 51, 'Login', 'Successful Login', '2025-03-11 04:15:57'),
(28, 51, 'Login', 'Successful Login', '2025-03-11 04:18:57'),
(31, 50, 'Login', 'Successful Login', '2025-03-11 12:59:09'),
(32, 51, 'Login', 'Successful Login', '2025-03-11 13:00:07'),
(34, 50, 'Login', 'Successful Login', '2025-03-16 03:44:30'),
(36, 99, 'Login', 'Successful Login', '2025-03-16 03:49:06'),
(37, 64, 'Login', 'Successful Login', '2025-03-16 03:51:16'),
(39, 64, 'Login', 'Successful Login', '2025-03-16 04:16:23'),
(40, 100, 'Login', 'Successful Login', '2025-03-16 04:51:21'),
(41, 27, 'Login', 'Successful Login', '2025-03-16 06:00:26'),
(42, 50, 'Login', 'Successful Login', '2025-03-16 06:32:59'),
(43, 50, 'Login', 'Successful Login', '2025-03-16 06:37:30'),
(44, 97, 'Login', 'Successful Login', '2025-03-16 06:37:39'),
(45, 97, 'Login', 'Successful Login', '2025-03-16 06:37:41'),
(46, 97, 'Login', 'Successful Login', '2025-03-16 06:37:41'),
(47, 97, 'Login', 'Successful Login', '2025-03-16 06:37:42'),
(48, 50, 'Login', 'Successful Login', '2025-03-16 06:40:27'),
(49, 50, 'Login', 'Successful Login', '2025-03-16 06:40:30'),
(50, 97, 'Login', 'Successful Login', '2025-03-16 06:44:50'),
(51, 50, 'Login', 'Successful Login', '2025-03-16 06:47:48'),
(52, 97, 'Login', 'Successful Login', '2025-03-16 06:52:06'),
(53, 50, 'Login', 'Successful Login', '2025-03-16 06:52:54'),
(54, 50, 'Login', 'Successful Login', '2025-03-16 06:53:02'),
(55, 50, 'Login', 'Successful Login', '2025-03-16 06:53:11'),
(56, 50, 'Login', 'Successful Login', '2025-03-16 07:05:56'),
(57, 50, 'Login', 'Successful Login', '2025-03-16 07:08:24'),
(58, 50, 'Login', 'Successful Login', '2025-03-16 07:11:08'),
(59, 50, 'Login', 'Successful Login', '2025-03-16 07:12:41'),
(60, 50, 'Login', 'Successful Login', '2025-03-16 07:14:36'),
(61, 50, 'Login', 'Successful Login', '2025-03-16 07:32:33'),
(62, 50, 'Login', 'Successful Login', '2025-03-16 07:34:20'),
(63, 50, 'Login', 'Successful Login', '2025-03-16 07:34:34'),
(64, 50, 'Login', 'Successful Login', '2025-03-16 07:35:04'),
(65, 50, 'Login', 'Successful Login', '2025-03-16 07:36:00'),
(66, 50, 'Login', 'Successful Login', '2025-03-16 07:36:55'),
(67, 50, 'Login', 'Successful Login', '2025-03-16 07:37:26'),
(68, 50, 'Login', 'Successful Login', '2025-03-16 07:37:29'),
(69, 50, 'Login', 'Successful Login', '2025-03-16 07:38:28'),
(70, 50, 'Login', 'Successful Login', '2025-03-16 07:38:55'),
(71, 50, 'Login', 'Successful Login', '2025-03-16 07:42:45'),
(72, 50, 'Login', 'Successful Login', '2025-03-16 07:47:41'),
(73, 50, 'Login', 'Successful Login', '2025-03-16 07:47:56'),
(74, 50, 'Login', 'Successful Login', '2025-03-16 07:58:59'),
(75, 50, 'Login', 'Successful Login', '2025-03-16 08:05:15'),
(76, 50, 'Login', 'Successful Login', '2025-03-16 08:07:00'),
(77, 50, 'Login', 'Successful Login', '2025-03-16 08:09:11'),
(78, 50, 'Login', 'Successful Login', '2025-03-16 08:10:13'),
(79, 50, 'Login', 'Successful Login', '2025-03-16 08:10:32'),
(80, 50, 'Login', 'Successful Login', '2025-03-16 08:11:54'),
(81, 50, 'Login', 'Successful Login', '2025-03-16 08:12:13'),
(82, 50, 'Login', 'Successful Login', '2025-03-16 08:12:33'),
(83, 50, 'Login', 'Successful Login', '2025-03-16 08:15:46'),
(84, 50, 'Login', 'Successful Login', '2025-03-16 08:16:10'),
(85, 50, 'Login', 'Successful Login', '2025-03-16 08:17:08'),
(86, 50, 'Login', 'Successful Login', '2025-03-16 08:17:21'),
(87, 50, 'Login', 'Successful Login', '2025-03-16 08:21:18'),
(88, 50, 'Login', 'Successful Login', '2025-03-16 08:21:37'),
(89, 50, 'Login', 'Successful Login', '2025-03-16 08:21:41'),
(90, 50, 'Login', 'Successful Login', '2025-03-16 08:21:43'),
(91, 50, 'Login', 'Successful Login', '2025-03-16 08:22:06'),
(92, 50, 'Login', 'Successful Login', '2025-03-16 08:22:32'),
(93, 50, 'Login', 'Successful Login', '2025-03-16 08:23:41'),
(94, 50, 'Login', 'Successful Login', '2025-03-16 08:23:50'),
(95, 50, 'Login', 'Successful Login', '2025-03-16 08:23:54'),
(96, 50, 'Login', 'Successful Login', '2025-03-16 08:23:58'),
(97, 50, 'Login', 'Successful Login', '2025-03-16 08:24:15'),
(98, 50, 'Login', 'Successful Login', '2025-03-16 08:24:19'),
(99, 97, 'Login', 'Successful Login', '2025-03-16 08:41:23'),
(100, 51, 'Login', 'Successful Login', '2025-03-16 09:37:26'),
(101, 97, 'Login', 'Successful Login', '2025-03-16 09:39:07'),
(102, 51, 'Login', 'Successful Login', '2025-03-16 09:41:09'),
(103, 64, 'Login', 'Successful Login', '2025-03-16 09:41:42'),
(104, 99, 'Login', 'Successful Login', '2025-03-16 09:43:36'),
(105, 97, 'Login', 'Successful Login', '2025-03-16 09:44:13'),
(106, 64, 'Login', 'Successful Login', '2025-03-16 09:45:03'),
(107, 97, 'Login', 'Successful Login', '2025-03-16 09:46:43'),
(108, 50, 'Login', 'Successful Login', '2025-03-16 09:55:26'),
(109, 50, 'Login', 'Successful Login', '2025-03-16 09:55:49'),
(110, 97, 'Login', 'Successful Login', '2025-03-16 09:55:59'),
(111, 64, 'Login', 'Successful Login', '2025-03-16 10:31:06'),
(112, 97, 'Login', 'Successful Login', '2025-03-16 11:04:04'),
(113, 64, 'Login', 'Successful Login', '2025-03-18 09:45:23'),
(114, 64, 'Login', 'Successful Login', '2025-05-11 11:38:59'),
(115, 50, 'Login', 'Successful Login', '2025-05-11 11:40:12'),
(116, 50, 'Login', 'Successful Login', '2025-05-11 11:52:10'),
(117, 64, 'Login', 'Successful Login', '2025-05-11 11:52:30'),
(118, 64, 'Logout', 'Successful Logout', '2025-05-11 11:53:09'),
(119, 97, 'Login', 'Successful Login', '2025-05-11 11:53:44'),
(120, 97, 'Logout', 'Successful Logout', '2025-05-11 11:55:10'),
(121, 97, 'Logout', 'Successful Logout', '2025-05-11 11:55:10'),
(122, 97, 'Login', 'Successful Login', '2025-05-11 11:55:20'),
(123, 97, 'Logout', 'Successful Logout', '2025-05-11 12:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `user_id` int(11) NOT NULL,
  `balance` decimal(65,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`user_id`, `balance`) VALUES
(50, 9913.01),
(51, 293.03),
(64, 94.00),
(89, 38.00),
(90, 800.00),
(94, 4450.00),
(95, 8.00),
(96, 800.00),
(97, 32.00),
(98, 30.00),
(99, 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `BlogID` int(11) NOT NULL,
  `BlogTitle` varchar(255) NOT NULL,
  `BlogContent` text NOT NULL,
  `AuthorID` int(11) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `attarchement` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`BlogID`, `BlogTitle`, `BlogContent`, `AuthorID`, `CreatedAt`, `date`, `attarchement`) VALUES
(10, 'EduAssista', '<p data-start=\"289\" data-end=\"829\"><strong data-start=\"289\" data-end=\"302\">Abstract:</strong><br data-start=\"302\" data-end=\"305\">\r\nEduAssista is a cutting-edge digital platform designed to transform educational management and administration. By integrating state-of-the-art technologies—ranging from robust dashboards and intuitive interfaces to AI-driven insights—EduAssista addresses the challenges of modern academic environments while enhancing productivity and user engagement. This blog post explores the academic rationale behind EduAssista, outlines its innovative features, and highlights its potential to revolutionize the educational landscape.</p>\r\n<h2 data-start=\"831\" data-end=\"846\">Introduction</h2>\r\n<p data-start=\"848\" data-end=\"1321\">The rapid evolution of technology has spurred transformative changes across industries, with education standing at the forefront of this revolution. Traditional administrative practices often struggle to keep pace with the dynamic demands of modern academia. Recognizing these challenges, EduAssista has emerged as a comprehensive solution that leverages digital tools to streamline administrative processes, enhance user experience, and foster data-driven decision-making.</p>\r\n<h2 data-start=\"1323\" data-end=\"1353\">Rationale Behind EduAssista</h2>\r\n<p data-start=\"1355\" data-end=\"1697\">In today’s fast-paced educational environment, institutions require solutions that not only manage administrative tasks but also provide actionable insights into operational efficiency. EduAssista was developed based on extensive research into the challenges faced by administrators, educators, and students alike. Key considerations include:</p>\r\n<ul data-start=\"1699\" data-end=\"2158\">\r\n<li data-start=\"1699\" data-end=\"1853\"><strong data-start=\"1701\" data-end=\"1732\">Streamlined Administration:</strong> Automating routine tasks such as scheduling, resource allocation, and user management to reduce administrative overhead.</li>\r\n<li data-start=\"1854\" data-end=\"2011\"><strong data-start=\"1856\" data-end=\"1885\">Enhanced User Engagement:</strong> Implementing intuitive, user-friendly interfaces that empower administrators and educators to manage their roles effectively.</li>\r\n<li data-start=\"2012\" data-end=\"2158\"><strong data-start=\"2014\" data-end=\"2046\">Data-Driven Decision Making:</strong> Integrating analytics and AI to provide real-time insights into institutional performance and student outcomes.</li>\r\n</ul>\r\n<h2 data-start=\"2160\" data-end=\"2196\">Innovative Features of EduAssista</h2>\r\n<p data-start=\"2198\" data-end=\"2300\">EduAssista offers a range of features designed to meet the specific needs of educational institutions:</p>\r\n<h3 data-start=\"2302\" data-end=\"2334\">1. Comprehensive Dashboard</h3>\r\n<p data-start=\"2335\" data-end=\"2554\">The platform includes a dynamic dashboard that provides a real-time overview of key metrics. Administrators can monitor system performance, manage user roles, and access reports that facilitate informed decision-making.</p>\r\n<h3 data-start=\"2556\" data-end=\"2605\">2. Rich Text Editing and Content Management</h3>\r\n<p data-start=\"2606\" data-end=\"2855\">Drawing inspiration from advanced word-processing tools, EduAssista integrates a robust rich text editor. This feature enables educators to create, format, and publish content seamlessly, ensuring that academic materials meet high-quality standards.</p>\r\n<h3 data-start=\"2857\" data-end=\"2885\">3. AI-Driven Analytics</h3>\r\n<p data-start=\"2886\" data-end=\"3141\">By harnessing the power of artificial intelligence, EduAssista offers predictive analytics and automated recommendations. These capabilities help administrators anticipate trends, optimize resource distribution, and enhance overall operational efficiency.</p>\r\n<h3 data-start=\"3143\" data-end=\"3184\">4. Secure and Scalable Architecture</h3>\r\n<p data-start=\"3185\" data-end=\"3422\">Built on industry-standard technologies, EduAssista emphasizes data security and scalability. The platform employs modern encryption protocols and follows best practices to protect sensitive information while accommodating future growth.</p>\r\n<h2 data-start=\"3424\" data-end=\"3458\">Academic and Practical Benefits</h2>\r\n<p data-start=\"3460\" data-end=\"3576\">EduAssista not only addresses immediate administrative challenges but also contributes to broader academic goals by:</p>\r\n<ul data-start=\"3578\" data-end=\"3989\">\r\n<li data-start=\"3578\" data-end=\"3676\"><strong data-start=\"3580\" data-end=\"3619\">Improving Institutional Efficiency:</strong> Automating time-consuming processes and reducing errors.</li>\r\n<li data-start=\"3677\" data-end=\"3835\"><strong data-start=\"3679\" data-end=\"3712\">Supporting Academic Research:</strong> Providing data analytics tools that enable educators to analyze trends and assess the impact of educational interventions.</li>\r\n<li data-start=\"3836\" data-end=\"3989\"><strong data-start=\"3838\" data-end=\"3868\">Enhancing User Experience:</strong> Offering a seamless and intuitive interface that encourages adoption and continuous engagement among staff and students.</li>\r\n</ul>\r\n<h2 data-start=\"3991\" data-end=\"4004\">Conclusion</h2>\r\n<p data-start=\"4006\" data-end=\"4431\">EduAssista represents a significant step forward in the evolution of educational management. Its innovative approach—combining advanced digital tools with AI-driven insights—positions it as an indispensable asset for modern academic institutions. By addressing both administrative challenges and broader educational needs, EduAssista empowers institutions to deliver quality education in a rapidly changing digital landscape.</p>\r\n<p data-start=\"4433\" data-end=\"4635\">For educators, administrators, and decision-makers looking to embrace the future of education, EduAssista offers a compelling solution that promises efficiency, transparency, and continuous improvement.</p>\r\n<p data-start=\"4637\" data-end=\"4772\"><strong data-start=\"4637\" data-end=\"4656\">Call to Action:</strong><br data-start=\"4656\" data-end=\"4659\">\r\nDiscover how EduAssista can transform your institution by requesting a demo or contacting our support team today.</p>', 97, '2025-03-08 15:53:12', '2025-03-08 18:53:12', ''),
(14, 'EduAssistaa', '<h1 data-start=\"219\" data-end=\"287\" style=\"background-color: transparent;\">Empowering Education with Innovative Digital Solutions</h1>\r\n<p data-start=\"289\" data-end=\"829\"><strong data-start=\"289\" data-end=\"302\">Abstract:</strong><br data-start=\"302\" data-end=\"305\">\r\nEduAssista is a cutting-edge digital platform designed to transform educational management and administration. By integrating state-of-the-art technologies—ranging from robust dashboards and intuitive interfaces to AI-driven insights—EduAssista addresses the challenges of modern academic environments while enhancing productivity and user engagement. This blog post explores the academic rationale behind EduAssista, outlines its innovative features, and highlights its potential to revolutionize the educational landscape.</p>\r\n<h2 data-start=\"831\" data-end=\"846\">Introduction</h2>\r\n<p data-start=\"848\" data-end=\"1321\">The rapid evolution of technology has spurred transformative changes across industries, with education standing at the forefront of this revolution. Traditional administrative practices often struggle to keep pace with the dynamic demands of modern academia. Recognizing these challenges, EduAssista has emerged as a comprehensive solution that leverages digital tools to streamline administrative processes, enhance user experience, and foster data-driven decision-making.</p>\r\n<h2 data-start=\"1323\" data-end=\"1353\">Rationale Behind EduAssista</h2>\r\n<p data-start=\"1355\" data-end=\"1697\">In today’s fast-paced educational environment, institutions require solutions that not only manage administrative tasks but also provide actionable insights into operational efficiency. EduAssista was developed based on extensive research into the challenges faced by administrators, educators, and students alike. Key considerations include:</p>\r\n<ul data-start=\"1699\" data-end=\"2158\">\r\n<li data-start=\"1699\" data-end=\"1853\"><strong data-start=\"1701\" data-end=\"1732\">Streamlined Administration:</strong> Automating routine tasks such as scheduling, resource allocation, and user management to reduce administrative overhead.</li>\r\n<li data-start=\"1854\" data-end=\"2011\"><strong data-start=\"1856\" data-end=\"1885\">Enhanced User Engagement:</strong> Implementing intuitive, user-friendly interfaces that empower administrators and educators to manage their roles effectively.</li>\r\n<li data-start=\"2012\" data-end=\"2158\"><strong data-start=\"2014\" data-end=\"2046\">Data-Driven Decision Making:</strong> Integrating analytics and AI to provide real-time insights into institutional performance and student outcomes.</li>\r\n</ul>\r\n<h2 data-start=\"2160\" data-end=\"2196\">Innovative Features of EduAssista</h2>\r\n<p data-start=\"2198\" data-end=\"2300\">EduAssista offers a range of features designed to meet the specific needs of educational institutions:</p>\r\n<h3 data-start=\"2302\" data-end=\"2334\">1. Comprehensive Dashboard</h3>\r\n<p data-start=\"2335\" data-end=\"2554\">The platform includes a dynamic dashboard that provides a real-time overview of key metrics. Administrators can monitor system performance, manage user roles, and access reports that facilitate informed decision-making.</p>\r\n<h3 data-start=\"2556\" data-end=\"2605\">2. Rich Text Editing and Content Management</h3>\r\n<p data-start=\"2606\" data-end=\"2855\">Drawing inspiration from advanced word-processing tools, EduAssista integrates a robust rich text editor. This feature enables educators to create, format, and publish content seamlessly, ensuring that academic materials meet high-quality standards.</p>\r\n<h3 data-start=\"2857\" data-end=\"2885\">3. AI-Driven Analytics</h3>\r\n<p data-start=\"2886\" data-end=\"3141\">By harnessing the power of artificial intelligence, EduAssista offers predictive analytics and automated recommendations. These capabilities help administrators anticipate trends, optimize resource distribution, and enhance overall operational efficiency.</p>\r\n<h3 data-start=\"3143\" data-end=\"3184\">4. Secure and Scalable Architecture</h3>\r\n<p data-start=\"3185\" data-end=\"3422\">Built on industry-standard technologies, EduAssista emphasizes data security and scalability. The platform employs modern encryption protocols and follows best practices to protect sensitive information while accommodating future growth.</p>\r\n<h2 data-start=\"3424\" data-end=\"3458\">Academic and Practical Benefits</h2>\r\n<p data-start=\"3460\" data-end=\"3576\">EduAssista not only addresses immediate administrative challenges but also contributes to broader academic goals by:</p>\r\n<ul data-start=\"3578\" data-end=\"3989\">\r\n<li data-start=\"3578\" data-end=\"3676\"><strong data-start=\"3580\" data-end=\"3619\">Improving Institutional Efficiency:</strong> Automating time-consuming processes and reducing errors.</li>\r\n<li data-start=\"3677\" data-end=\"3835\"><strong data-start=\"3679\" data-end=\"3712\">Supporting Academic Research:</strong> Providing data analytics tools that enable educators to analyze trends and assess the impact of educational interventions.</li>\r\n<li data-start=\"3836\" data-end=\"3989\"><strong data-start=\"3838\" data-end=\"3868\">Enhancing User Experience:</strong> Offering a seamless and intuitive interface that encourages adoption and continuous engagement among staff and students.</li>\r\n</ul>\r\n<h2 data-start=\"3991\" data-end=\"4004\">Conclusion</h2>\r\n<p data-start=\"4006\" data-end=\"4431\">EduAssista represents a significant step forward in the evolution of educational management. Its innovative approach—combining advanced digital tools with AI-driven insights—positions it as an indispensable asset for modern academic institutions. By addressing both administrative challenges and broader educational needs, EduAssista empowers institutions to deliver quality education in a rapidly changing digital landscape.</p>\r\n<p data-start=\"4433\" data-end=\"4635\">For educators, administrators, and decision-makers looking to embrace the future of education, EduAssista offers a compelling solution that promises efficiency, transparency, and continuous improvement.</p>\r\n<p data-start=\"4637\" data-end=\"4772\"><strong data-start=\"4637\" data-end=\"4656\">Call to Action:</strong><br data-start=\"4656\" data-end=\"4659\">\r\nDiscover how EduAssista can transform your institution by requesting a demo or contacting our support team today.</p>', 97, '2025-03-08 16:02:13', '2025-03-08 19:02:13', ''),
(15, '<div style=\"text-align: left;\" bis_skin_checked=\"1\">Attain a Grade A</div>', '<h3 data-start=\"0\" data-end=\"55\">How EduAssista Can Help Learners Attain a Grade A</h3>\r\n<p data-start=\"57\" data-end=\"412\">Education is evolving, and with the right tools, every learner can reach their full potential. <strong data-start=\"152\" data-end=\"166\">EduAssista</strong> is designed to be the ultimate academic companion, helping students excel in their studies and achieve <strong data-start=\"270\" data-end=\"281\">Grade A</strong> results. Whether you\'re struggling with assignments, need tutoring support, or want instant answers, EduAssista has you covered.</p>\r\n<h4 data-start=\"414\" data-end=\"457\"><strong data-start=\"419\" data-end=\"455\">1. AI-Powered Instant Assistance</strong></h4>\r\n<p data-start=\"458\" data-end=\"712\">Students often face challenges in understanding concepts or completing assignments on time. <strong data-start=\"550\" data-end=\"603\">EduAssista’s AI-driven WhatsApp auto-reply system</strong> provides <strong data-start=\"613\" data-end=\"676\">instant explanations, study resources, and guided solutions</strong> to ensure students stay on track.</p>\r\n<h4 data-start=\"714\" data-end=\"751\"><strong data-start=\"719\" data-end=\"749\">2. Expert Tutoring Support</strong></h4>\r\n<p data-start=\"752\" data-end=\"996\">EduAssista connects learners with <strong data-start=\"786\" data-end=\"806\">qualified tutors</strong> who provide personalized assistance. Tutors help break down complex topics, ensuring students grasp key concepts and develop <strong data-start=\"932\" data-end=\"960\">critical thinking skills</strong> essential for excelling in exams.</p>\r\n<h4 data-start=\"998\" data-end=\"1041\"><strong data-start=\"1003\" data-end=\"1039\">3. Structured Learning Dashboard</strong></h4>\r\n<p data-start=\"1042\" data-end=\"1102\">With our well-organized <strong data-start=\"1066\" data-end=\"1085\">tutor dashboard</strong>, students can:</p>\r\n<ul data-start=\"1103\" data-end=\"1293\">\r\n<li data-start=\"1103\" data-end=\"1172\">Access step-by-step <strong data-start=\"1125\" data-end=\"1149\">guides and tutorials</strong> on various subjects.</li>\r\n<li data-start=\"1173\" data-end=\"1207\">Track their academic progress.</li>\r\n<li data-start=\"1208\" data-end=\"1293\">Improve their performance through <strong data-start=\"1244\" data-end=\"1266\">practice questions</strong> and feedback mechanisms.</li>\r\n</ul>\r\n<h4 data-start=\"1295\" data-end=\"1355\"><strong data-start=\"1300\" data-end=\"1353\">4. Effective Study and Time Management Strategies</strong></h4>\r\n<p data-start=\"1356\" data-end=\"1603\">EduAssista encourages learners to adopt effective study techniques, including:<br data-start=\"1434\" data-end=\"1437\">\r\n✅ <strong data-start=\"1439\" data-end=\"1456\">Active recall</strong> for better memory retention.<br data-start=\"1485\" data-end=\"1488\">\r\n✅ <strong data-start=\"1490\" data-end=\"1514\">Time management tips</strong> for efficient studying.<br data-start=\"1538\" data-end=\"1541\">\r\n✅ <strong data-start=\"1543\" data-end=\"1571\">Personalized study plans</strong> tailored to individual needs.</p>\r\n<h4 data-start=\"1605\" data-end=\"1649\"><strong data-start=\"1610\" data-end=\"1647\">5. Motivation and Academic Growth</strong></h4>\r\n<p data-start=\"1650\" data-end=\"1862\">Beyond just providing answers, EduAssista fosters <strong data-start=\"1700\" data-end=\"1724\">independent learning</strong>. Students develop confidence in tackling academic challenges, leading to better performance and ultimately securing <strong data-start=\"1841\" data-end=\"1852\">Grade A</strong> scores.</p>\r\n<h3 data-start=\"1864\" data-end=\"1896\"><strong data-start=\"1868\" data-end=\"1894\">Why Choose EduAssista?</strong></h3>\r\n<p data-start=\"1897\" data-end=\"2135\">🔹 <strong data-start=\"1900\" data-end=\"1921\">Fast and reliable</strong> academic assistance.<br data-start=\"1942\" data-end=\"1945\">\r\n🔹 <strong data-start=\"1948\" data-end=\"1980\">Interactive learning support</strong> through AI and expert tutors.<br data-start=\"2010\" data-end=\"2013\">\r\n🔹 <strong data-start=\"2016\" data-end=\"2042\">Improved comprehension</strong> with step-by-step guidance.<br data-start=\"2070\" data-end=\"2073\">\r\n🔹 <strong data-start=\"2076\" data-end=\"2103\">User-friendly interface</strong> for easy access to resources.</p>\r\n<p data-start=\"2137\" data-end=\"2235\">With <strong data-start=\"2142\" data-end=\"2156\">EduAssista</strong>, achieving academic excellence is no longer a challenge—it’s a reality! 🚀📚</p>', 74, '2025-03-08 23:39:18', '2025-03-09 02:39:18', ''),
(19, 'Fees Statement', '', 97, '2025-03-09 00:50:39', '2025-03-09 03:50:39', 'Fees Statement.pdf'),
(20, 'book 2', '', 97, '2025-03-09 00:53:33', '2025-03-09 03:53:33', 'Fees Statement1.pdf,2023 KCSE.pdf'),
(22, '<b>OBJECTIVES</b>', '', 97, '2025-03-09 01:23:43', '2025-03-09 04:23:43', 'objective_1.pdf,objective_3.pdf'),
(23, '<font color=\"#ff0000\"><b>HELLO</b></font>', 'HOW ARE YOU', 74, '2025-03-09 02:18:50', '2025-03-09 05:18:50', ''),
(24, 'Women\'s Right to Abortion. Final document', '', 97, '2025-03-09 03:08:16', '2025-03-09 06:08:16', 'Women\'s Right to Abortion. Final document.pdf'),
(25, '<b><font color=\"#0000ff\">The Power of Mercy, Kindness, Compassion, and Goodness in Education</font></b>', '<p data-start=\"79\" data-end=\"478\">In the world of learning, <strong data-start=\"105\" data-end=\"150\">mercy, kindness, compassion, and goodness</strong> are just as important as knowledge itself. Education is not just about answering questions or solving problems—it’s about <strong data-start=\"273\" data-end=\"321\">understanding, patience, and genuine support</strong>. At <strong data-start=\"326\" data-end=\"340\">EduAssista</strong>, these values are at the heart of our mission to help students succeed with academic support that is both <strong data-start=\"447\" data-end=\"475\">efficient and empathetic</strong>.</p>\r\n<h3 data-start=\"480\" data-end=\"529\"><strong data-start=\"484\" data-end=\"527\">Mercy: Understanding Student Challenges</strong></h3>\r\n<p data-start=\"530\" data-end=\"830\">Every learner faces struggles—difficult subjects, tight deadlines, and moments of self-doubt. <strong data-start=\"624\" data-end=\"646\">Mercy in education</strong> means giving students the chance to grow without fear of judgment. It means <strong data-start=\"723\" data-end=\"827\">offering second chances, guiding them through mistakes, and recognizing their effort over perfection</strong>.</p>\r\n<p data-start=\"832\" data-end=\"868\"><strong data-start=\"832\" data-end=\"866\">How EduAssista embodies mercy:</strong></p>\r\n<ul data-start=\"869\" data-end=\"1088\">\r\n<li data-start=\"869\" data-end=\"942\">Allowing students to ask questions freely, without fear of criticism.</li>\r\n<li data-start=\"943\" data-end=\"1032\">Encouraging tutors to provide <strong data-start=\"975\" data-end=\"991\">constructive</strong> feedback instead of harsh corrections.</li>\r\n<li data-start=\"1033\" data-end=\"1088\">Offering <strong data-start=\"1044\" data-end=\"1064\">multiple chances</strong> to learn and improve.</li>\r\n</ul>\r\n<h3 data-start=\"1090\" data-end=\"1140\"><strong data-start=\"1094\" data-end=\"1138\">Kindness: A Simple Act, A Big Difference</strong></h3>\r\n<p data-start=\"1141\" data-end=\"1370\">Kindness in education creates a <strong data-start=\"1173\" data-end=\"1214\">safe and welcoming space for learning</strong>. A few words of encouragement, a tutor’s willingness to explain a concept twice, or a supportive message can transform a struggling student’s confidence.</p>\r\n<p data-start=\"1372\" data-end=\"1411\"><strong data-start=\"1372\" data-end=\"1409\">How EduAssista promotes kindness:</strong></p>\r\n<ul data-start=\"1412\" data-end=\"1640\">\r\n<li data-start=\"1412\" data-end=\"1509\">Ensuring responses from tutors and the AI assistant are <strong data-start=\"1470\" data-end=\"1506\">helpful, patient, and respectful</strong>.</li>\r\n<li data-start=\"1510\" data-end=\"1580\">Encouraging <strong data-start=\"1524\" data-end=\"1549\">positive interactions</strong> between students and tutors.</li>\r\n<li data-start=\"1581\" data-end=\"1640\">Making academic support <strong data-start=\"1607\" data-end=\"1637\">accessible and stress-free</strong>.</li>\r\n</ul>\r\n<h3 data-start=\"1642\" data-end=\"1686\"><strong data-start=\"1646\" data-end=\"1684\">Compassion: More Than Just Answers</strong></h3>\r\n<p data-start=\"1687\" data-end=\"1948\">Education is not just about <strong data-start=\"1715\" data-end=\"1740\">providing information</strong>—it’s about <strong data-start=\"1752\" data-end=\"1789\">understanding the learner’s needs</strong>. Compassionate tutoring goes beyond giving solutions; it involves <strong data-start=\"1856\" data-end=\"1945\">listening to students, identifying their struggles, and offering personalized support</strong>.</p>\r\n<p data-start=\"1950\" data-end=\"1988\"><strong data-start=\"1950\" data-end=\"1986\">How EduAssista shows compassion:</strong></p>\r\n<ul data-start=\"1989\" data-end=\"2207\">\r\n<li data-start=\"1989\" data-end=\"2069\">Tutors <strong data-start=\"1998\" data-end=\"2011\">take time</strong> to explain concepts based on a student’s learning pace.</li>\r\n<li data-start=\"2070\" data-end=\"2142\">AI-powered responses are designed to be <strong data-start=\"2112\" data-end=\"2139\">supportive, not robotic</strong>.</li>\r\n<li data-start=\"2143\" data-end=\"2207\">Encouraging students to <strong data-start=\"2169\" data-end=\"2204\">ask for help without hesitation</strong>.</li>\r\n</ul>\r\n<h3 data-start=\"2209\" data-end=\"2250\"><strong data-start=\"2213\" data-end=\"2248\">Goodness: Integrity in Learning</strong></h3>\r\n<p data-start=\"2251\" data-end=\"2463\">Goodness in education means ensuring that learning is <strong data-start=\"2305\" data-end=\"2340\">honest, ethical, and beneficial</strong>. It’s about providing <strong data-start=\"2363\" data-end=\"2392\">accurate, well-researched</strong> guidance and <strong data-start=\"2406\" data-end=\"2438\">promoting academic integrity</strong> rather than shortcuts.</p>\r\n<p data-start=\"2465\" data-end=\"2503\"><strong data-start=\"2465\" data-end=\"2501\">How EduAssista upholds goodness:</strong></p>\r\n<ul data-start=\"2504\" data-end=\"2750\">\r\n<li data-start=\"2504\" data-end=\"2581\">Providing <strong data-start=\"2516\" data-end=\"2527\">quality</strong> academic assistance without encouraging plagiarism.</li>\r\n<li data-start=\"2582\" data-end=\"2680\">Ensuring that tutoring services <strong data-start=\"2616\" data-end=\"2644\">truly help students grow</strong>, rather than just giving answers.</li>\r\n<li data-start=\"2681\" data-end=\"2750\">Promoting a <strong data-start=\"2695\" data-end=\"2747\">learning environment based on honesty and effort</strong>.</li>\r\n</ul>\r\n<h3 data-start=\"2752\" data-end=\"2799\"><strong data-start=\"2756\" data-end=\"2797\">Building a Better Learning Experience</strong></h3>\r\n<p data-start=\"2800\" data-end=\"3122\">At <strong data-start=\"2803\" data-end=\"2817\">EduAssista</strong>, we believe that education should be more than just information—it should be <strong data-start=\"2895\" data-end=\"2946\">a journey of growth, support, and encouragement</strong>. By integrating <strong data-start=\"2963\" data-end=\"3008\">mercy, kindness, compassion, and goodness</strong> into our platform, we aim to create an academic space where students feel <strong data-start=\"3083\" data-end=\"3119\">supported, valued, and empowered</strong>.</p>\r\n<p data-start=\"3124\" data-end=\"3229\">Because at the end of the day, <strong data-start=\"3155\" data-end=\"3223\">knowledge grows best in an environment of care and understanding</strong>. 💙</p>', 97, '2025-03-11 02:16:14', '2025-03-11 05:16:14', '');

-- --------------------------------------------------------

--
-- Table structure for table `clarification`
--

CREATE TABLE `clarification` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `instructions` text NOT NULL,
  `deadline` datetime NOT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` text DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `status` enum('pending','in_progress','completed','canceled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer_files` text DEFAULT NULL,
  `answer_comments` text DEFAULT NULL,
  `explanation_files` text DEFAULT NULL,
  `explanation_comments` text DEFAULT NULL,
  `clarification` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `UserID` int(11) DEFAULT NULL,
  `EducationalLevel` varchar(100) DEFAULT NULL,
  `PreferredSubject` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`UserID`, `EducationalLevel`, `PreferredSubject`, `created_at`, `updated_at`) VALUES
(21, 'primRY', 'ENGLISH', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(22, 'sec', 'science', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(23, 'sec', 'non', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(25, 'chem', 'chem', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(50, 'un', 'chem', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(67, 'bachelors', 'maths, chem', '2025-01-20 20:27:40', '2025-01-20 20:27:40'),
(68, 'secondary', 'maths, chem', '2025-01-20 20:29:59', '2025-01-20 20:29:59'),
(69, 'secondary', 'maths, chem', '2025-01-20 20:41:43', '2025-01-20 20:41:43'),
(70, 'secondary, university', 'maths, chem, eng, kiswahili', '2025-01-20 20:43:52', '2025-03-16 08:51:58'),
(71, 'julilii133ncccn3@gmail.com', 'julilii133ncccn3@gmail.com', '2025-01-20 20:44:38', '2025-01-20 20:44:38'),
(72, 'secondary', 'maths, chem', '2025-01-20 20:46:37', '2025-01-20 20:46:37'),
(73, 'julilii133nfffvvvvvn3@gmail.com', 'julilii133nfffvvvvvn3@gmail.com', '2025-01-20 20:47:14', '2025-01-20 20:47:14'),
(90, 'primary', 'chem', '2025-02-22 04:09:55', '2025-02-22 04:09:55'),
(91, 'University', 'physics', '2025-03-04 03:05:34', '2025-03-04 03:05:34'),
(92, 'University', 'physics', '2025-03-04 03:11:22', '2025-03-04 03:11:22'),
(93, 'University', 'physics', '2025-03-04 03:17:56', '2025-03-04 03:17:56'),
(94, 'University', 'maths', '2025-03-04 03:28:15', '2025-03-04 03:28:15'),
(96, 'university', 'maths', '2025-03-06 03:28:54', '2025-03-06 03:28:54'),
(99, 'primary', 'maths', '2025-03-16 03:48:55', '2025-03-16 03:48:55'),
(100, 'secondary', 'maths', '2025-03-16 04:51:08', '2025-03-16 04:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `BlogID` int(11) NOT NULL,
  `BlogTitle` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CommentMessage` text NOT NULL,
  `ReplyMessage` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `BlogID`, `BlogTitle`, `UserID`, `CommentMessage`, `ReplyMessage`, `CreatedAt`) VALUES
(2, 23, '<font color=\"#ff0000\"><b>HELLO</b></font>', 97, 'hello to you bro', 'how are you', '2025-03-09 03:31:19'),
(3, 23, '<font color=\"#ff0000\"><b>HELLO</b></font>', 97, 'heello', '', '2025-03-09 03:33:13'),
(7, 20, 'book 2', 74, 'good work', '', '2025-03-09 04:27:04'),
(8, 22, '<b>OBJECTIVES</b>', 95, 'how are you', '', '2025-03-09 04:46:53'),
(9, 19, 'Fees Statement', 95, 'how are you', '', '2025-03-09 04:47:41'),
(10, 23, '<font color=\"#ff0000\"><b>HELLO</b></font>', 95, 'hey', '', '2025-03-09 04:50:15'),
(12, 10, 'EduAssista', 95, 'hey', '', '2025-03-09 05:16:33'),
(47, 20, 'book 2', 97, 'gt', NULL, '2025-03-16 04:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `ReplyID` int(11) NOT NULL,
  `ParentCommentID` int(11) NOT NULL,
  `BlogID_replied` int(11) NOT NULL,
  `BlogTitle_replied` varchar(255) NOT NULL,
  `UserID_replied` int(11) NOT NULL,
  `ReplyMessage` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_replies`
--

INSERT INTO `comment_replies` (`ReplyID`, `ParentCommentID`, `BlogID_replied`, `BlogTitle_replied`, `UserID_replied`, `ReplyMessage`, `CreatedAt`) VALUES
(21, 7, 20, 'book 2', 97, 'gt', '2025-03-16 04:11:24'),
(22, 7, 20, 'book 2', 64, 'wow', '2025-03-16 04:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `completed`
--

CREATE TABLE `completed` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` enum('donework','paid','clarification','completed') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer_files` text DEFAULT NULL,
  `answer_comments` text DEFAULT NULL,
  `explanation_files` text DEFAULT NULL,
  `explanation_comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`order_id`, `client_id`, `tutor_id`, `subject`, `name`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`, `answer_files`, `answer_comments`, `explanation_files`, `explanation_comments`) VALUES
(175, 50, 64, 'vvvv', 'vvvvvvvv', 'vvvvvvvvv', 'vvvvvvvvvv Additional Details: gggggg', '2025-04-05 05:26:00', 'Fees Statement1.pdf', 'uploads/doc_67c9071b3c0770.91643320.pdf,uploads/ABDULRAHMAN SAATY CV1.pdf,uploads/Fees Statement1.pdf', NULL, '0', 150.00, 3, 'completed', '2025-03-06 06:15:41', '2025-03-06 06:16:09', '[\"doneorders\\/Rubric Assessment - Sp25 ECED 1300-80 Guiding Children\'s Behavior - Minneapolis Community and Technical College1234.pdf\"]', 'mfffffffffffffffffffffffffffffffffffffffffffff<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n    <title>Clarification Orders</title>\n    <link rel=\"stylesheet\" href=\"style4.css\">\n    <style>\n        /* General container and table styles */\n        \n        body {\n            font-family: Arial, sans-serif;\n            background-color: #f9f9f9;\n            margin: 0;\n            padding: 20px;\n        }\n        \n        .container {\n            max-width: 1200px;\n            margin: 0 auto;\n            background-color: #fff;\n            padding: 20px;\n            border-radius: 8px;\n            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);\n        }\n        \n        h2 {\n            text-align: center;\n            margin-bottom: 20px;\n        }\n        \n        table {\n            width: 100%;\n            border-collapse: collapse;\n            margin-bottom: 20px;\n        }\n        \n        table,\n        th,\n        td {\n            border: 1px solid #ddd;\n            padding: 12px;\n            text-align: left;\n        }\n        \n        th {\n            background-color: #4CAF50;\n            color: white;\n        }\n        \n        .order-name a {\n            color: #007bff;\n            text-decoration: none;\n        }\n        \n        .order-name a:hover {\n            text-decoration: underline;\n        }\n        /* Modal popup for action selection */\n        \n        .modal {\n            display: none;\n            position: fixed;\n            z-index: 3000;\n            left: 0;\n            top: 0;\n            width: 100%;\n            height: 100%;\n            background-color: rgba(0, 0, 0, 0.5);\n        }\n        \n        .modal-content {\n            background-color: #fff;\n            margin: 10% auto;\n            padding: 20px;\n            border-radius: 8px;\n            width: 50%;\n            text-align: center;\n            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);\n        }\n        /* Clarification modal: big box (half screen) */\n        \n        #clarifyModal .modal-content {\n            width: 50%;\n            height: 50vh;\n            overflow-y: auto;\n        }\n        \n        .modal-buttons button {\n            padding: 10px 20px;\n            margin: 10px;\n            font-size: 16px;\n            border: none;\n            border-radius: 4px;\n            cursor: pointer;\n        }\n        \n        .btn-redo {\n            background-color: #27ae60;\n            color: #fff;\n        }\n        \n        .btn-clarify {\n            background-color: #f39c12;\n            color: #fff;\n        }\n        /* Clarification form styles */\n        \n        .clarify-form {\n            margin-top: 20px;\n            text-align: left;\n        }\n        \n        .clarify-form label {\n            display: block;\n            font-weight: bold;\n            margin-bottom: 5px;\n        }\n        \n        .clarify-form textarea {\n            width: 100%;\n            height: 40vh;\n            padding: 10px;\n            margin-bottom: 10px;\n            border: 1px solid #ddd;\n            border-radius: 4px;\n            resize: vertical;\n        }\n        \n        .btn-submit {\n            background-color: #007bff;\n            color: #fff;\n            border: none;\n            padding: 10px 20px;\n            font-size: 16px;\n            border-radius: 4px;\n            cursor: pointer;\n        }\n        /* Initially hide working sections */\n        \n        #answerSection,\n        #explanationSection {\n            display: none;\n            margin-top: 10px;\n        }\n        \n        /* --- New CSS for a modern workplace and baton (buttons) --- */\n        \n        .workplace-container {\n            max-width: 1200px;\n            margin: 0 auto;\n            background: #ffffff;\n            box-shadow: 0 4px 12px rgba(0,0,0,0.1);\n            border-radius: 8px;\n            padding: 20px;\n            font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;\n        }\n        \n        /* Global button styling */\n        .btn {\n            display: inline-block;\n            padding: 12px 24px;\n            font-size: 16px;\n            font-weight: bold;\n            color: #fff;\n            background-color: #007BFF;\n            border: none;\n            border-radius: 6px;\n            text-align: center;\n            text-decoration: none;\n            cursor: pointer;\n            transition: background-color 0.3s ease, transform 0.2s ease;\n        }\n        \n        .btn:hover {\n            background-color: #0056b3;\n            transform: scale(1.05);\n        }\n        \n        .btn:active {\n            background-color: #004494;\n            transform: scale(0.98);\n        }\n        \n        /* Specific button classes overriding the global style */\n        .btn-accept {\n            background-color: #28a745;\n        }\n        \n        .btn-accept:hover {\n            background-color: #218838;\n        }\n        \n        .btn-clarify {\n            background-color: #ffc107;\n            color: #212529;\n        }\n        \n        .btn-clarify:hover {\n            background-color: #e0a800;\n        }\n        \n        .btn-rease {\n            background-color: #17a2b8;\n        }\n        \n        .btn-rease:hover {\n            background-color: #138496;\n        }\n        \n        .btn-tutor {\n            background-color: #6f42c1;\n        }\n        \n        .btn-tutor:hover {\n            background-color: #593196;\n        }\n        \n        .btn-cancel {\n            background-color: #dc3545;\n        }\n        \n        .btn-cancel:hover {\n            background-color: #c82333;\n        }\n    </style>\n    <script>\n        // Utility: get URL parameter by name.\n        function getParameterByName(name) {\n            const url = window.location.href;\n            name = name.replace(/[\\[\\]]/g, \'\\\\$&\');\n            const regex = new RegExp(\'[?&]\' + name + \'(=([^&#]*)|&|#|$)\'),\n                results = regex.exec(url);\n            if (!results) return null;\n            if (!results[2]) return \'\';\n            return decodeURIComponent(results[2].replace(/\\+/g, \' \'));\n        }\n        let clarificationOrders = []; // Global array for clarification orders.\n        let selectedOrder = null; // Currently selected order.\n\n        document.addEventListener(\"DOMContentLoaded\", function() {\n            fetchClarificationOrders();\n\n            document.getElementById(\"closeModalBtn\").addEventListener(\"click\", closeActionModal);\n            document.getElementById(\"redoBtn\").addEventListener(\"click\", doRedo);\n            document.getElementById(\"clarifyBtn\").addEventListener(\"click\", showClarifyForm);\n            document.getElementById(\"submitClarificationBtn\").addEventListener(\"click\", submitClarification);\n            document.getElementById(\"cancelClarificationBtn\").addEventListener(\"click\", closeClarifyModal);\n\n            // Show/hide clarification textareas based on radio selection.\n            document.querySelectorAll(\'input[name=\"clarifyOption\"]\').forEach(radio => {\n                radio.addEventListener(\"change\", function() {\n                    let val = this.value;\n                    document.getElementById(\"answerSection\").style.display = (val === \"answer\" || val === \"both\") ? \"block\" : \"none\";\n                    document.getElementById(\"explanationSection\").style.display = (val === \"explanation\" || val === \"both\") ? \"block\" : \"none\";\n                    checkClarificationFields(); // re-check to enable/disable submit.\n                });\n            });\n\n            // Monitor textareas for enabling/disabling the submit button.\n            document.getElementById(\"answerClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"explanationClarification\").addEventListener(\"input\", checkClarificationFields);\n        });\n\n        // Helper function to count words in a string.\n        function countWords(str) {\n            return str.trim().split(/\\s+/).filter(word => word.length > 0).length;\n        }\n\n        // Enable submit button only when required fields are non-empty.\n        function checkClarificationFields() {\n            const option = document.querySelector(\'input[name=\"clarifyOption\"]:checked\');\n            const submitBtn = document.getElementById(\"submitClarificationBtn\");\n            if (!option) {\n                submitBtn.disabled = true;\n                return;\n            }\n            if (option.value === \"answer\") {\n                submitBtn.disabled = (document.getElementById(\"answerClarification\").value.trim() === \"\");\n            } else if (option.value === \"explanation\") {\n                submitBtn.disabled = (document.getElementById(\"explanationClarification\").value.trim() === \"\");\n            } else if (option.value === \"both\") {\n                submitBtn.disabled = (document.getElementById(\"answerClarification\").value.trim() === \"\" ||\n                    document.getElementById(\"explanationClarification\").value.trim() === \"\");\n            }\n        }\n\n        // Fetch orders from clarification.php.\n        function fetchClarificationOrders() {\n            fetch(\'clarification.php\')\n                .then(response => response.json())\n                .then(data => {\n                    clarificationOrders = data;\n                    displayClarificationTable(data);\n                })\n                .catch(error => {\n                    console.error(\"Error fetching clarification orders:\", error);\n                    document.getElementById(\"clarificationContainer\").innerHTML = \"<p>Error loading orders.</p>\";\n                });\n        }\n\n        // Display orders in a table.\n        function displayClarificationTable(orders) {\n            let html = \"<table><thead><tr>\" +\n                \"<th>Order ID</th>\" +\n                \"<th>Client ID</th>\" +\n                \"<th>Subject</th>\" +\n                \"<th>Name</th>\" +\n                \"<th>Deadline</th>\" +\n                \"<th>Clarification</th>\" +\n                \"</tr></thead><tbody>\";\n            orders.forEach(order => {\n                let nameLink = \"<span class=\'order-name\'><a href=\'#\' onclick=\'openActionModal(\" + order.order_id + \"); return false;\'>\" + order.name + \"</a></span>\";\n                html += \"<tr>\" +\n                    \"<td>\" + order.order_id + \"</td>\" +\n                    \"<td>\" + order.client_id + \"</td>\" +\n                    \"<td>\" + order.subject + \"</td>\" +\n                    \"<td>\" + nameLink + \"</td>\" +\n                    \"<td>\" + order.deadline + \"</td>\" +\n                    \"<td>\" + order.clarification + \"</td>\" +\n                    \"</tr>\";\n            });\n            html += \"</tbody></table>\";\n            document.getElementById(\"clarificationContainer\").innerHTML = html;\n        }\n\n        // Open action modal when an order is clicked.\n        function openActionModal(orderId) {\n            selectedOrder = clarificationOrders.find(o => o.order_id == orderId);\n            if (!selectedOrder) return;\n            document.getElementById(\"actionModal\").style.display = \"block\";\n        }\n\n        function closeActionModal() {\n            document.getElementById(\"actionModal\").style.display = \"none\";\n        }\n\n        // \"Do It Again\" action.\n        function doRedo() {\n            if (!selectedOrder) return;\n            fetch(\'clarification.php\', {\n                    method: \'POST\',\n                    headers: {\n                        \'Content-Type\': \'application/json\'\n                    },\n                    body: JSON.stringify({\n                        action: \"redo\",\n                        order_id: selectedOrder.order_id\n                    })\n                })\n                .then(response => response.json())\n                .then(data => {\n                    if (data.success) {\n                        // Redirect to the working page.\n                        window.location.href = \"openclarification.html?order_id=\" + selectedOrder.order_id;\n                    } else {\n                        alert(\"Error: \" + data.error);\n                    }\n                })\n                .catch(error => {\n                    console.error(\"Error in redo action:\", error);\n                    alert(\"An error occurred during the Do It Again process.\");\n                });\n        }\n\n        // \"Clarify Here\" action.\n        function showClarifyForm() {\n            closeActionModal();\n            // Clear the existing page content and create a full-page clarification form.\n            document.body.innerHTML = \"\";\n            const container = document.createElement(\"div\");\n            container.className = \"workplace-container\";\n            container.innerHTML = `\n                <h2>Clarification Form</h2>\n                <p>Please select what you want to clarify:</p>\n                <div>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"answer\"> Answer Only</label>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"explanation\"> Explanation Only</label>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"both\"> Both</label>\n                </div>\n                <div id=\"clarifyForm\">\n                    <div id=\"answerSection\" style=\"display:none; margin-top:10px;\">\n                        <label>Answer Clarification:</label>\n                        <textarea id=\"answerClarification\" placeholder=\"Enter your answer clarification...\" style=\"width:100%; height:60vh;\"></textarea>\n                    </div>\n                    <div id=\"explanationSection\" style=\"display:none; margin-top:10px;\">\n                        <label>Explanation Clarification:</label>\n                        <textarea id=\"explanationClarification\" placeholder=\"Enter your explanation clarification...\" style=\"width:100%; height:60vh;\"></textarea>\n                    </div>\n                </div>\n                <button id=\"submitClarificationBtn\" class=\"btn\" style=\"margin-top:20px;\" disabled>Submit Clarification</button>\n            `;\n            document.body.appendChild(container);\n            // Add event listeners for the new clarification form.\n            document.querySelectorAll(\'input[name=\"clarifyOption\"]\').forEach(radio => {\n                radio.addEventListener(\"change\", function() {\n                    let val = this.value;\n                    document.getElementById(\"answerSection\").style.display = (val === \"answer\" || val === \"both\") ? \"block\" : \"none\";\n                    document.getElementById(\"explanationSection\").style.display = (val === \"explanation\" || val === \"both\") ? \"block\" : \"none\";\n                    checkClarificationFields();\n                });\n            });\n            document.getElementById(\"answerClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"explanationClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"submitClarificationBtn\").addEventListener(\"click\", submitClarification);\n        }\n\n        function closeClarifyModal() {\n            // In full-screen mode, simply clear the page content.\n            document.body.innerHTML = \"\";\n        }\n\n        // Submit clarification: update clarification via clarificiation.php.\n        function submitClarification() {\n            const option = document.querySelector(\'input[name=\"clarifyOption\"]:checked\');\n            if (!option) {\n                alert(\"Please select an option for clarification.\");\n                return;\n            }\n            // Validate that the entered text has at least 100 words.\n            if (option.value === \"answer\" || option.value === \"both\") {\n                const answerText = document.getElementById(\"answerClarification\").value.trim();\n                if (countWords(answerText) < 100) {\n                    alert(\"Please enter at least 100 words for answer clarification.\");\n                    return;\n                }\n            }\n            if (option.value === \"explanation\" || option.value === \"both\") {\n                const explanationText = document.getElementById(\"explanationClarification\").value.trim();\n                if (countWords(explanationText) < 100) {\n                    alert(\"Please enter at least 100 words for explanation clarification.\");\n                    return;\n                }\n            }\n            let clarifyData = {\n                order_id: selectedOrder.order_id,\n                action: \"clarify\",\n                answerClarification: \"\",\n                explanationClarification: \"\"\n            };\n            if (option.value === \"answer\" || option.value === \"both\") {\n                clarifyData.answerClarification = document.getElementById(\"answerClarification\").value.trim();\n            }\n            if (option.value === \"explanation\" || option.value === \"both\") {\n                clarifyData.explanationClarification = document.getElementById(\"explanationClarification\").value.trim();\n            }\n            fetch(\'clarification.php\', {\n                    method: \'POST\',\n                    headers: {\n                        \'Content-Type\': \'application/json\'\n                    },\n                    body: JSON.stringify(clarifyData)\n                })\n                .then(response => response.json())\n                .then(data => {\n                    if (data.success) {\n                        // Show thank you message for clarifying.\n                        document.body.innerHTML = \"<h2 style=\'text-align:center; margin-top:40vh;\'>Thank you for clarifying!</h2>\";\n                        setTimeout(function() {\n                            window.location.href = \"tutor_index.html\";\n                        }, 3000);\n                    } else {\n                        alert(\"Error: \" + data.error);\n                    }\n                })\n                .catch(error => {\n                    console.error(\"Error submitting clarification:\", error);\n                    alert(\"An error occurred while submitting clarification.\");\n                });\n        }\n    </script>\n</head>\n\n<body>\n    <h2>Clarification Orders</h2>\n    <div class=\"container\" id=\"clarificationContainer\">\n        <!-- Clarification table will be rendered here -->\n    </div>\n    <!-- Modal for choosing action on order -->\n    <div id=\"actionModal\" class=\"modal\">\n        <div class=\"modal-content\">\n            <p>Do you want to do the full order again or clarify it here?</p>\n            <div class=\"modal-buttons\">\n                <button id=\"redoBtn\" class=\"btn btn-redo\">Do It Again</button>\n                <button id=\"clarifyBtn\" class=\"btn btn-clarify\">Clarify Here</button>\n            </div>\n            <button id=\"closeModalBtn\" class=\"btn\" style=\"margin-top:10px;\">Close</button>\n        </div>\n    </div>\n</body>\n\n</html>', '[\"doneorders\\/chapter 212345678910.pdf\"]', 'n<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n    <title>Clarification Orders</title>\n    <link rel=\"stylesheet\" href=\"style4.css\">\n    <style>\n        /* General container and table styles */\n        \n        body {\n            font-family: Arial, sans-serif;\n            background-color: #f9f9f9;\n            margin: 0;\n            padding: 20px;\n        }\n        \n        .container {\n            max-width: 1200px;\n            margin: 0 auto;\n            background-color: #fff;\n            padding: 20px;\n            border-radius: 8px;\n            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);\n        }\n        \n        h2 {\n            text-align: center;\n            margin-bottom: 20px;\n        }\n        \n        table {\n            width: 100%;\n            border-collapse: collapse;\n            margin-bottom: 20px;\n        }\n        \n        table,\n        th,\n        td {\n            border: 1px solid #ddd;\n            padding: 12px;\n            text-align: left;\n        }\n        \n        th {\n            background-color: #4CAF50;\n            color: white;\n        }\n        \n        .order-name a {\n            color: #007bff;\n            text-decoration: none;\n        }\n        \n        .order-name a:hover {\n            text-decoration: underline;\n        }\n        /* Modal popup for action selection */\n        \n        .modal {\n            display: none;\n            position: fixed;\n            z-index: 3000;\n            left: 0;\n            top: 0;\n            width: 100%;\n            height: 100%;\n            background-color: rgba(0, 0, 0, 0.5);\n        }\n        \n        .modal-content {\n            background-color: #fff;\n            margin: 10% auto;\n            padding: 20px;\n            border-radius: 8px;\n            width: 50%;\n            text-align: center;\n            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);\n        }\n        /* Clarification modal: big box (half screen) */\n        \n        #clarifyModal .modal-content {\n            width: 50%;\n            height: 50vh;\n            overflow-y: auto;\n        }\n        \n        .modal-buttons button {\n            padding: 10px 20px;\n            margin: 10px;\n            font-size: 16px;\n            border: none;\n            border-radius: 4px;\n            cursor: pointer;\n        }\n        \n        .btn-redo {\n            background-color: #27ae60;\n            color: #fff;\n        }\n        \n        .btn-clarify {\n            background-color: #f39c12;\n            color: #fff;\n        }\n        /* Clarification form styles */\n        \n        .clarify-form {\n            margin-top: 20px;\n            text-align: left;\n        }\n        \n        .clarify-form label {\n            display: block;\n            font-weight: bold;\n            margin-bottom: 5px;\n        }\n        \n        .clarify-form textarea {\n            width: 100%;\n            height: 40vh;\n            padding: 10px;\n            margin-bottom: 10px;\n            border: 1px solid #ddd;\n            border-radius: 4px;\n            resize: vertical;\n        }\n        \n        .btn-submit {\n            background-color: #007bff;\n            color: #fff;\n            border: none;\n            padding: 10px 20px;\n            font-size: 16px;\n            border-radius: 4px;\n            cursor: pointer;\n        }\n        /* Initially hide working sections */\n        \n        #answerSection,\n        #explanationSection {\n            display: none;\n            margin-top: 10px;\n        }\n        \n        /* --- New CSS for a modern workplace and baton (buttons) --- */\n        \n        .workplace-container {\n            max-width: 1200px;\n            margin: 0 auto;\n            background: #ffffff;\n            box-shadow: 0 4px 12px rgba(0,0,0,0.1);\n            border-radius: 8px;\n            padding: 20px;\n            font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;\n        }\n        \n        /* Global button styling */\n        .btn {\n            display: inline-block;\n            padding: 12px 24px;\n            font-size: 16px;\n            font-weight: bold;\n            color: #fff;\n            background-color: #007BFF;\n            border: none;\n            border-radius: 6px;\n            text-align: center;\n            text-decoration: none;\n            cursor: pointer;\n            transition: background-color 0.3s ease, transform 0.2s ease;\n        }\n        \n        .btn:hover {\n            background-color: #0056b3;\n            transform: scale(1.05);\n        }\n        \n        .btn:active {\n            background-color: #004494;\n            transform: scale(0.98);\n        }\n        \n        /* Specific button classes overriding the global style */\n        .btn-accept {\n            background-color: #28a745;\n        }\n        \n        .btn-accept:hover {\n            background-color: #218838;\n        }\n        \n        .btn-clarify {\n            background-color: #ffc107;\n            color: #212529;\n        }\n        \n        .btn-clarify:hover {\n            background-color: #e0a800;\n        }\n        \n        .btn-rease {\n            background-color: #17a2b8;\n        }\n        \n        .btn-rease:hover {\n            background-color: #138496;\n        }\n        \n        .btn-tutor {\n            background-color: #6f42c1;\n        }\n        \n        .btn-tutor:hover {\n            background-color: #593196;\n        }\n        \n        .btn-cancel {\n            background-color: #dc3545;\n        }\n        \n        .btn-cancel:hover {\n            background-color: #c82333;\n        }\n    </style>\n    <script>\n        // Utility: get URL parameter by name.\n        function getParameterByName(name) {\n            const url = window.location.href;\n            name = name.replace(/[\\[\\]]/g, \'\\\\$&\');\n            const regex = new RegExp(\'[?&]\' + name + \'(=([^&#]*)|&|#|$)\'),\n                results = regex.exec(url);\n            if (!results) return null;\n            if (!results[2]) return \'\';\n            return decodeURIComponent(results[2].replace(/\\+/g, \' \'));\n        }\n        let clarificationOrders = []; // Global array for clarification orders.\n        let selectedOrder = null; // Currently selected order.\n\n        document.addEventListener(\"DOMContentLoaded\", function() {\n            fetchClarificationOrders();\n\n            document.getElementById(\"closeModalBtn\").addEventListener(\"click\", closeActionModal);\n            document.getElementById(\"redoBtn\").addEventListener(\"click\", doRedo);\n            document.getElementById(\"clarifyBtn\").addEventListener(\"click\", showClarifyForm);\n            document.getElementById(\"submitClarificationBtn\").addEventListener(\"click\", submitClarification);\n            document.getElementById(\"cancelClarificationBtn\").addEventListener(\"click\", closeClarifyModal);\n\n            // Show/hide clarification textareas based on radio selection.\n            document.querySelectorAll(\'input[name=\"clarifyOption\"]\').forEach(radio => {\n                radio.addEventListener(\"change\", function() {\n                    let val = this.value;\n                    document.getElementById(\"answerSection\").style.display = (val === \"answer\" || val === \"both\") ? \"block\" : \"none\";\n                    document.getElementById(\"explanationSection\").style.display = (val === \"explanation\" || val === \"both\") ? \"block\" : \"none\";\n                    checkClarificationFields(); // re-check to enable/disable submit.\n                });\n            });\n\n            // Monitor textareas for enabling/disabling the submit button.\n            document.getElementById(\"answerClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"explanationClarification\").addEventListener(\"input\", checkClarificationFields);\n        });\n\n        // Helper function to count words in a string.\n        function countWords(str) {\n            return str.trim().split(/\\s+/).filter(word => word.length > 0).length;\n        }\n\n        // Enable submit button only when required fields are non-empty.\n        function checkClarificationFields() {\n            const option = document.querySelector(\'input[name=\"clarifyOption\"]:checked\');\n            const submitBtn = document.getElementById(\"submitClarificationBtn\");\n            if (!option) {\n                submitBtn.disabled = true;\n                return;\n            }\n            if (option.value === \"answer\") {\n                submitBtn.disabled = (document.getElementById(\"answerClarification\").value.trim() === \"\");\n            } else if (option.value === \"explanation\") {\n                submitBtn.disabled = (document.getElementById(\"explanationClarification\").value.trim() === \"\");\n            } else if (option.value === \"both\") {\n                submitBtn.disabled = (document.getElementById(\"answerClarification\").value.trim() === \"\" ||\n                    document.getElementById(\"explanationClarification\").value.trim() === \"\");\n            }\n        }\n\n        // Fetch orders from clarification.php.\n        function fetchClarificationOrders() {\n            fetch(\'clarification.php\')\n                .then(response => response.json())\n                .then(data => {\n                    clarificationOrders = data;\n                    displayClarificationTable(data);\n                })\n                .catch(error => {\n                    console.error(\"Error fetching clarification orders:\", error);\n                    document.getElementById(\"clarificationContainer\").innerHTML = \"<p>Error loading orders.</p>\";\n                });\n        }\n\n        // Display orders in a table.\n        function displayClarificationTable(orders) {\n            let html = \"<table><thead><tr>\" +\n                \"<th>Order ID</th>\" +\n                \"<th>Client ID</th>\" +\n                \"<th>Subject</th>\" +\n                \"<th>Name</th>\" +\n                \"<th>Deadline</th>\" +\n                \"<th>Clarification</th>\" +\n                \"</tr></thead><tbody>\";\n            orders.forEach(order => {\n                let nameLink = \"<span class=\'order-name\'><a href=\'#\' onclick=\'openActionModal(\" + order.order_id + \"); return false;\'>\" + order.name + \"</a></span>\";\n                html += \"<tr>\" +\n                    \"<td>\" + order.order_id + \"</td>\" +\n                    \"<td>\" + order.client_id + \"</td>\" +\n                    \"<td>\" + order.subject + \"</td>\" +\n                    \"<td>\" + nameLink + \"</td>\" +\n                    \"<td>\" + order.deadline + \"</td>\" +\n                    \"<td>\" + order.clarification + \"</td>\" +\n                    \"</tr>\";\n            });\n            html += \"</tbody></table>\";\n            document.getElementById(\"clarificationContainer\").innerHTML = html;\n        }\n\n        // Open action modal when an order is clicked.\n        function openActionModal(orderId) {\n            selectedOrder = clarificationOrders.find(o => o.order_id == orderId);\n            if (!selectedOrder) return;\n            document.getElementById(\"actionModal\").style.display = \"block\";\n        }\n\n        function closeActionModal() {\n            document.getElementById(\"actionModal\").style.display = \"none\";\n        }\n\n        // \"Do It Again\" action.\n        function doRedo() {\n            if (!selectedOrder) return;\n            fetch(\'clarification.php\', {\n                    method: \'POST\',\n                    headers: {\n                        \'Content-Type\': \'application/json\'\n                    },\n                    body: JSON.stringify({\n                        action: \"redo\",\n                        order_id: selectedOrder.order_id\n                    })\n                })\n                .then(response => response.json())\n                .then(data => {\n                    if (data.success) {\n                        // Redirect to the working page.\n                        window.location.href = \"openclarification.html?order_id=\" + selectedOrder.order_id;\n                    } else {\n                        alert(\"Error: \" + data.error);\n                    }\n                })\n                .catch(error => {\n                    console.error(\"Error in redo action:\", error);\n                    alert(\"An error occurred during the Do It Again process.\");\n                });\n        }\n\n        // \"Clarify Here\" action.\n        function showClarifyForm() {\n            closeActionModal();\n            // Clear the existing page content and create a full-page clarification form.\n            document.body.innerHTML = \"\";\n            const container = document.createElement(\"div\");\n            container.className = \"workplace-container\";\n            container.innerHTML = `\n                <h2>Clarification Form</h2>\n                <p>Please select what you want to clarify:</p>\n                <div>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"answer\"> Answer Only</label>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"explanation\"> Explanation Only</label>\n                    <label><input type=\"radio\" name=\"clarifyOption\" value=\"both\"> Both</label>\n                </div>\n                <div id=\"clarifyForm\">\n                    <div id=\"answerSection\" style=\"display:none; margin-top:10px;\">\n                        <label>Answer Clarification:</label>\n                        <textarea id=\"answerClarification\" placeholder=\"Enter your answer clarification...\" style=\"width:100%; height:60vh;\"></textarea>\n                    </div>\n                    <div id=\"explanationSection\" style=\"display:none; margin-top:10px;\">\n                        <label>Explanation Clarification:</label>\n                        <textarea id=\"explanationClarification\" placeholder=\"Enter your explanation clarification...\" style=\"width:100%; height:60vh;\"></textarea>\n                    </div>\n                </div>\n                <button id=\"submitClarificationBtn\" class=\"btn\" style=\"margin-top:20px;\" disabled>Submit Clarification</button>\n            `;\n            document.body.appendChild(container);\n            // Add event listeners for the new clarification form.\n            document.querySelectorAll(\'input[name=\"clarifyOption\"]\').forEach(radio => {\n                radio.addEventListener(\"change\", function() {\n                    let val = this.value;\n                    document.getElementById(\"answerSection\").style.display = (val === \"answer\" || val === \"both\") ? \"block\" : \"none\";\n                    document.getElementById(\"explanationSection\").style.display = (val === \"explanation\" || val === \"both\") ? \"block\" : \"none\";\n                    checkClarificationFields();\n                });\n            });\n            document.getElementById(\"answerClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"explanationClarification\").addEventListener(\"input\", checkClarificationFields);\n            document.getElementById(\"submitClarificationBtn\").addEventListener(\"click\", submitClarification);\n        }\n\n        function closeClarifyModal() {\n            // In full-screen mode, simply clear the page content.\n            document.body.innerHTML = \"\";\n        }\n\n        // Submit clarification: update clarification via clarificiation.php.\n        function submitClarification() {\n            const option = document.querySelector(\'input[name=\"clarifyOption\"]:checked\');\n            if (!option) {\n                alert(\"Please select an option for clarification.\");\n                return;\n            }\n            // Validate that the entered text has at least 100 words.\n            if (option.value === \"answer\" || option.value === \"both\") {\n                const answerText = document.getElementById(\"answerClarification\").value.trim();\n                if (countWords(answerText) < 100) {\n                    alert(\"Please enter at least 100 words for answer clarification.\");\n                    return;\n                }\n            }\n            if (option.value === \"explanation\" || option.value === \"both\") {\n                const explanationText = document.getElementById(\"explanationClarification\").value.trim();\n                if (countWords(explanationText) < 100) {\n                    alert(\"Please enter at least 100 words for explanation clarification.\");\n                    return;\n                }\n            }\n            let clarifyData = {\n                order_id: selectedOrder.order_id,\n                action: \"clarify\",\n                answerClarification: \"\",\n                explanationClarification: \"\"\n            };\n            if (option.value === \"answer\" || option.value === \"both\") {\n                clarifyData.answerClarification = document.getElementById(\"answerClarification\").value.trim();\n            }\n            if (option.value === \"explanation\" || option.value === \"both\") {\n                clarifyData.explanationClarification = document.getElementById(\"explanationClarification\").value.trim();\n            }\n            fetch(\'clarification.php\', {\n                    method: \'POST\',\n                    headers: {\n                        \'Content-Type\': \'application/json\'\n                    },\n                    body: JSON.stringify(clarifyData)\n                })\n                .then(response => response.json())\n                .then(data => {\n                    if (data.success) {\n                        // Show thank you message for clarifying.\n                        document.body.innerHTML = \"<h2 style=\'text-align:center; margin-top:40vh;\'>Thank you for clarifying!</h2>\";\n                        setTimeout(function() {\n                            window.location.href = \"tutor_index.html\";\n                        }, 3000);\n                    } else {\n                        alert(\"Error: \" + data.error);\n                    }\n                })\n                .catch(error => {\n                    console.error(\"Error submitting clarification:\", error);\n                    alert(\"An error occurred while submitting clarification.\");\n                });\n        }\n    </script>\n</head>\n\n<body>\n    <h2>Clarification Orders</h2>\n    <div class=\"container\" id=\"clarificationContainer\">\n        <!-- Clarification table will be rendered here -->\n    </div>\n    <!-- Modal for choosing action on order -->\n    <div id=\"actionModal\" class=\"modal\">\n        <div class=\"modal-content\">\n            <p>Do you want to do the full order again or clarify it here?</p>\n            <div class=\"modal-buttons\">\n                <button id=\"redoBtn\" class=\"btn btn-redo\">Do It Again</button>\n                <button id=\"clarifyBtn\" class=\"btn btn-clarify\">Clarify Here</button>\n            </div>\n            <button id=\"closeModalBtn\" class=\"btn\" style=\"margin-top:10px;\">Close</button>\n        </div>\n    </div>\n</body>\n\n</html>'),
(174, 50, 64, 'ddd', 'ddddddddd', 'ddddddddddddd', 'dddddddddddd Additional Details: hhhh', '2025-03-28 04:55:00', 'objective_31.pdf', 'uploads/doc_67c9004bb067d3.38044874.pdf,uploads/doc_67c9004bb0af93.36018468.pdf,uploads/emilio2.docx,uploads/Yes12.docx,uploads/objective_31.pdf', NULL, NULL, 150.00, 3, 'completed', '2025-03-06 06:18:01', '2025-03-06 06:19:18', '[\"doneorders\\/Rubric Assessment - Sp25 ECED 1300-80 Guiding Children\'s Behavior - Minneapolis Community and Technical College12345.pdf\"]', NULL, '[\"doneorders\\/Essential Questions Chapter 1.docx\"]', NULL),
(176, 50, 64, 'ssssssss', 'sssssssss', 'ssssssssssss', 'sssssssssssss', '2025-03-12 06:20:00', NULL, NULL, NULL, NULL, 250.00, 5, 'completed', '2025-03-06 06:20:42', '2025-03-06 06:21:06', '[\"doneorders\\/Essential Questions Chapter 5.docx\"]', NULL, '[\"doneorders\\/Permissive Discipline.docx\"]', NULL),
(9, 96, 97, 'maths', 'english', 'english', 'english', '2025-03-14 07:20:00', 'doc_67c8e4ee25b5e1.96404896.pdf', 'doc_67c8e4ee25b5e1.96404896.pdf', NULL, NULL, 200.00, 4, 'completed', '2025-03-06 07:21:45', '2025-03-06 07:22:04', '[\"doneorders\\/Ch 5 EQ Miller .docx\"]', NULL, '[\"doneorders\\/Ch 3 - Authoritative Style Worksheet (1) (1) (36) (1).docx\"]', NULL),
(177, 96, 0, 'maths', 'maths', 'maths', 'maths Additional Details: more inf', '2025-03-13 07:18:00', 'emergency_estimates_updated1.xlsx', 'uploads/doc_67c92131c6bb47.79047181.pdf,uploads/emergency_estimates_updated1.xlsx', NULL, NULL, 80.00, 2, 'completed', '2025-03-06 07:19:52', '2025-03-16 15:08:52', '[\"doneorders\\/QUIZ RESULTS.jpg\"]', '', '[\"doneorders\\/Early Childhood Experiences in Language Arts_ Early -- Jeanne M_ Machado -- 10, 2012-01-01 -- Wadsworth Cengage Learning -- 9780840028488 -- ee1035a9e74e8f15252e895ac1ecf599 -- Anna\\u2019s Archive.pdf\"]', ''),
(178, 96, 97, 'maths', 'maths', 'maths', 'log Additional Details: do these work again', '2025-03-27 07:44:00', 'doc_67c2456bebfdd8.378104041.docx', 'uploads/doc_67c92781b16124.41984298.pdf,uploads/doc_67c2456bebfdd8.378104041.docx', NULL, NULL, 160.00, 4, 'completed', '2025-03-06 07:45:32', '2025-03-06 07:45:47', '[\"doneorders\\/Neubauer_ACCJS_13e_PPT_Ch062 (1).pptx\"]', NULL, '[\"doneorders\\/emergency estimates (1).xlsx\"]', NULL),
(10, 96, 98, 'maths', 'maths', 'eng', 'eng Additional Details: do the work a fresh', '2025-03-20 07:56:00', 'MRS JY  (ANSWERS)1.pdf', 'objective_1.pdf,uploads/MRS JY  (ANSWERS)1.pdf', NULL, NULL, 100.00, 2, 'completed', '2025-03-06 07:57:14', '2025-03-06 07:57:50', '[\"doneorders\\/emergency_estimates_with_reasons.xlsx\"]', NULL, '[\"doneorders\\/emergency estimates.xlsx\"]', NULL),
(179, 96, 98, 'maths', 'english', 'maths', 'maths', '2025-03-13 07:52:00', 'doc_67c92a1a2c09c0.33364635.pdf', 'uploads/doc_67c92a1a288490.53971987.pdf,uploads/doc_67c92a1a2c09c0.33364635.pdf', NULL, NULL, 160.00, 4, 'completed', '2025-03-06 07:58:49', '2025-03-06 07:59:02', '[\"doneorders\\/Ch 3 - Authoritative Style Worksheet (1) (1) (30).docx\"]', NULL, '[\"doneorders\\/doc_67c8e4ee25b5e1.964048961.pdf\"]', NULL),
(181, 96, 98, 'fff', 'ffff', 'sssssr', 'maths', '2025-03-20 08:00:00', 'doc_67c92c0c73ac23.38149845.pdf', 'uploads/doc_67c92c0c73ac23.38149845.pdf', NULL, NULL, 150.00, 5, 'completed', '2025-03-06 08:02:19', '2025-03-06 08:03:44', '[\"doneorders\\/Reflective_Journals.docx\"]', NULL, '[\"doneorders\\/To solve this problem using an integer linear programming model (2) (1).docx\"]', NULL),
(183, 50, 51, 'maths ', 'vvvvv', 'vvvvvvv', 'vvvvvvv', '2025-03-27 07:16:00', 'doc_67cfb92db41d28.04558949.pdf', 'uploads/doc_67cfb92db41d28.04558949.pdf', NULL, NULL, 200.00, 4, 'completed', '2025-03-16 12:38:17', '2025-03-16 12:38:37', '[\"doneorders\\/Neubauer_ACCJS_13e_PPT_Ch08.pdf\"]', NULL, '[\"doneorders\\/clear_acb_3e_ch131.pdf\"]', NULL),
(184, 99, 64, 'document_name', 'poiuy', 'nnnnnnn', 'mmmmmmm', '2025-03-27 06:52:00', NULL, NULL, NULL, NULL, 100.00, 2, 'completed', '2025-03-16 12:46:02', '2025-03-16 12:46:14', '[\"doneorders\\/Bans, Walls, Raids, Sanctuary_ Understanding U_S_ -- A_ Naomi Paik -- University of California Press, Oakland, California, 2020 -- Oakland, -- 9780520305113 -- e1eb158cac55ce9dfc85cbb14f58c004 -- Anna\\u2019s Archiv (1).pdf\"]', NULL, '[\"doneorders\\/Neubauer_ACCJS_13e_PPT_Ch0812.pdf\"]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `UserID` int(11) NOT NULL,
  `FeedbackID` int(11) NOT NULL,
  `FeedbackMessage` text NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`UserID`, `FeedbackID`, `FeedbackMessage`, `order_id`) VALUES
(50, 1, 'Balance updated by -8000. Reason: N/A', 0),
(50, 2, 'Balance updated by 10000. Reason: balance', 0),
(64, 3, 'Balance updated by -3100. Reason: N/A', 0),
(50, 4, 'Balance updated by -2. Reason: a', 0),
(50, 5, 'Balance updated by -15. Reason: 1the order not finished', 183),
(51, 6, 'Balance updated by 0.03. Reason: Penalty', 0);

-- --------------------------------------------------------

--
-- Table structure for table `guestreply`
--

CREATE TABLE `guestreply` (
  `ReplyID` int(11) NOT NULL,
  `ParentCommentID` int(11) NOT NULL,
  `BlogID_replied` int(11) NOT NULL,
  `BlogTitle_replied` varchar(255) NOT NULL,
  `ReplyMessage` text NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gustcomment`
--

CREATE TABLE `gustcomment` (
  `CommentID` int(11) NOT NULL,
  `BlogID` int(11) NOT NULL,
  `BlogTitle` varchar(255) NOT NULL,
  `CommentMessage` text NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) DEFAULT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gustcomment`
--

INSERT INTO `gustcomment` (`CommentID`, `BlogID`, `BlogTitle`, `CommentMessage`, `FirstName`, `MiddleName`, `LastName`, `Email`, `Timestamp`) VALUES
(24, 24, 'Women\'s Right to Abortion. Final document', 'hello', 'jj', 'jj', 'julius', 'jj@gmail.com', '2025-03-11 02:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `MessageText` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reply` text DEFAULT NULL,
  `Reply_ID` int(11) DEFAULT NULL,
  `status` enum('client','tutor','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `document_upload_link` varchar(500) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `document_name` varchar(255) DEFAULT NULL,
  `status` enum('read','unread','beingread','waiting','undone') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`order_id`, `client_id`, `tutor_id`, `subject`, `name`, `description`, `instructions`, `deadline`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `created_at`, `updated_at`, `document_name`, `status`) VALUES
(9, 96, 97, 'maths', 'english', 'english', 'english', '2025-03-14 07:20:00', 'doc_67c8e4ee25b5e1.96404896.pdf', '', '', 200.00, 4, '2025-03-06 04:21:46', '2025-03-06 04:22:01', 'doc_67c8e4ee25b5e1.96404896.pdf', 'read'),
(10, 96, 98, 'maths', 'maths', 'eng', 'eng', '2025-03-13 07:54:00', 'objective_1.pdf', '', '', 100.00, 2, '2025-03-06 04:55:25', '2025-03-06 04:57:24', 'objective_1.pdf', 'read'),
(174, 50, 64, 'ddd', 'ddddddddd', 'ddddddddddddd', 'dddddddddddd Additional Details: hhhh', '2025-03-28 04:55:00', 'uploads/doc_67c9004bb067d3.38044874.pdf,uploads/doc_67c9004bb0af93.36018468.pdf,uploads/emilio2.docx,uploads/Yes12.docx,uploads/objective_31.pdf', '', '', 150.00, 3, '2025-03-06 02:33:38', '2025-03-06 03:18:46', 'objective_31.pdf', 'read'),
(175, 50, 64, 'vvvv', 'vvvvvvvv', 'vvvvvvvvv', 'vvvvvvvvvv', '2025-03-13 05:23:00', 'uploads/doc_67c9071b3c0770.91643320.pdf', '', '', 150.00, 3, '2025-03-06 02:26:14', '2025-03-06 02:36:39', 'doc_67c9071b3c0770.91643320.pdf', 'read'),
(176, 50, 64, 'ssssssss', 'sssssssss', 'ssssssssssss', 'sssssssssssss', '2025-03-12 06:20:00', '', '', '', 250.00, 5, '2025-03-06 03:20:42', '2025-03-06 03:21:04', '', 'read'),
(177, 96, 97, 'maths', 'maths', 'maths', 'maths', '2025-03-14 07:14:00', 'uploads/doc_67c92131c6bb47.79047181.pdf', '', '', 80.00, 2, '2025-03-06 04:16:02', '2025-03-06 04:20:02', 'doc_67c92131c6bb47.79047181.pdf', 'read'),
(178, 96, 97, 'maths', 'maths', 'maths', 'log', '2025-03-12 07:41:00', 'uploads/doc_67c92781b16124.41984298.pdf', '', '', 160.00, 4, '2025-03-06 04:42:07', '2025-03-06 04:45:37', 'doc_67c92781b16124.41984298.pdf', 'read'),
(179, 96, 98, 'maths', 'english', 'maths', 'maths', '2025-03-13 07:52:00', 'uploads/doc_67c92a1a288490.53971987.pdf,uploads/doc_67c92a1a2c09c0.33364635.pdf', '', '', 160.00, 4, '2025-03-06 04:53:33', '2025-03-06 04:58:54', 'doc_67c92a1a2c09c0.33364635.pdf', 'read'),
(180, 96, 98, 'maths', 'fffff', 'fffffffff', 'fffffffff', '2025-03-13 07:59:00', '', '', '', 200.00, 4, '2025-03-06 05:03:20', '2025-03-06 12:51:47', '', 'read'),
(181, 96, 98, 'fff', 'ffff', 'sssssr', 'maths', '2025-03-20 08:00:00', 'uploads/doc_67c92c0c73ac23.38149845.pdf', '', '', 150.00, 5, '2025-03-06 05:02:20', '2025-03-06 05:03:41', 'doc_67c92c0c73ac23.38149845.pdf', 'read'),
(183, 50, 51, 'maths ', 'vvvvv', 'vvvvvvv', 'vvvvvvv', '2025-03-27 07:16:00', 'uploads/doc_67cfb92db41d28.04558949.pdf', '', '', 200.00, 4, '2025-03-11 04:17:31', '2025-03-16 09:38:30', 'doc_67cfb92db41d28.04558949.pdf', 'read'),
(184, 99, 64, 'document_name', 'poiuy', 'nnnnnnn', 'mmmmmmm', '2025-03-27 06:52:00', '', '', '', 100.00, 2, '2025-03-16 09:42:03', '2025-03-16 09:46:11', '', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `document_name` varchar(255) NOT NULL,
  `status` enum('beingdone','skipped','beingread','waiting','undone') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `writer_type` varchar(50) DEFAULT NULL,
  `price_per_page` decimal(5,2) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` enum('undone','progress','revision','request','clarification','unpaid','paid','completed') NOT NULL DEFAULT 'undone',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`writer_type`, `price_per_page`, `client_id`, `order_id`, `subject`, `name`, `tutor_id`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`) VALUES
('Professional Writer', 50.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
('Midler Writer', 40.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
('Normal Writer', 30.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` enum('donework','revision','clarification') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer_files` text DEFAULT NULL,
  `answer_comments` text DEFAULT NULL,
  `explanation_files` text DEFAULT NULL,
  `explanation_comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `order_id`, `client_id`, `tutor_id`, `subject`, `name`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`, `answer_files`, `answer_comments`, `explanation_files`, `explanation_comments`) VALUES
(1, 66, 51, 51, 'maths', 'c', 'c', 'c', '2025-02-28 21:53:00', '43yj6e.jpeg', 'uploads/43yj6e.jpeg', '', '', 200.00, 4, 'donework', '2025-02-20 22:32:12', '2025-02-20 22:32:12', '[\"doneorders\\/IMG_9537.jpeg\"]', '', '[\"doneorders\\/EDU 321 Section 3 Reflection (1).docx\"]', ''),
(2, 68, 51, 51, 'f', 'f', 'd', 'd', '2025-02-28 22:52:00', 'c9fb3020-3a11-4bd1-b05f-f8298c6d353e.PNG', 'uploads/c9fb3020-3a11-4bd1-b05f-f8298c6d353e.PNG', '', '', 200.00, 4, 'donework', '2025-02-20 22:55:53', '2025-02-20 22:55:53', '[\"doneorders\\/Ch 3 EQ Miller.docx\",\"doneorders\\/10.4324_9780429030260_previewpdf (1).pdf\"]', '', '[\"doneorders\\/Screenshot 2025-02-18 192944.png\",\"doneorders\\/My Personal Profile.jpg\"]', ''),
(3, 67, 51, 64, 'maths', 'poiuy', 'v', 'v', '2025-02-22 22:51:00', '', '', '', '', 250.00, 5, 'donework', '2025-02-20 23:03:39', '2025-02-20 23:03:39', '[]', '', '[]', ''),
(4, 72, 51, 51, 'i', 'i', 'i', 'i', '2025-03-07 23:50:00', '', '', '', '', 350.00, 7, 'donework', '2025-02-20 23:51:40', '2025-02-20 23:51:40', '[\"doneorders\\/EDU 321 Section 3 Reflection.docx\"]', '', '[\"doneorders\\/Project_3_MBA_670_Discussion_Topics_1___2.docx.pdf\"]', ''),
(5, 73, 51, 51, 'r', 'r', 'r', 'r', '2025-02-27 00:02:00', '', '', '', '', 250.00, 5, 'donework', '2025-02-21 00:03:06', '2025-02-21 00:03:06', '[\"doneorders\\/Project_3_MBA_670_Discussion_Topics_1___2.docx.pdf\"]', '', '[\"doneorders\\/Preschool Expression of Feelings ECED 1640 Activity Card.docx\"]', ''),
(6, 74, 51, 64, 'f', 'v', 'v', 'v', '2025-02-28 00:03:00', '', '', '', '', 250.00, 5, 'donework', '2025-02-21 00:06:05', '2025-02-21 00:06:05', '[\"doneorders\\/Discussion 2.docx\"]', '', '[\"doneorders\\/Permissive Discipline.docx\"]', ''),
(7, 77, 51, 64, 'f', 'f', 'f', 'f', '2025-02-27 00:26:00', '', '', '', '', 200.00, 4, 'donework', '2025-02-21 00:43:50', '2025-02-21 00:43:50', '[\"doneorders\\/Discussion 2.docx\"]', '', '[\"doneorders\\/Discussion 2.docx\"]', ''),
(17, 91, 74, 51, 'maths', 'maths', 'teh', 'hwwwwww', '2025-03-08 05:47:00', '', '', '', '', 250.00, 5, 'donework', '2025-02-22 00:16:11', '2025-02-22 00:16:11', '[\"doneorders\\/Rubric Assessment - Sp25 ECED 1300-80 Guiding Children\'s Behavior - Minneapolis Community and Technical College.pdf\"]', '', '[\"doneorders\\/chapter 2.pdf\"]', ''),
(26, 102, 51, 51, 'jur6ttt', 'jydddgn', 'jsrydkm', 'mdtgytddd', '2025-02-28 00:17:00', '10.4324_9780429030260_previewpdf (1).pdf', 'uploads/10.4324_9780429030260_previewpdf (1).pdf', '', '', 200.00, 4, 'donework', '2025-02-24 00:02:40', '2025-02-24 00:02:40', '[\"doneorders\\/activity card no ecips (1).docx\",\"doneorders\\/en-ECED 1640 Chapter 6.txt\"]', '', '[\"doneorders\\/ms3t08.jpeg\"]', ''),
(42, 109, 90, 89, 'ddddddmdm', 'kutektmu', 'temuuuutm ', 'muetmym', '2025-02-28 07:10:00', '', '', '', '', 300.00, 6, 'donework', '2025-02-27 10:10:58', '2025-02-27 10:10:58', '[\"doneorders\\/Essential Questions Chapter 11.docx\",\"doneorders\\/Essential Questions Chapter 112.docx\"]', '', '[\"doneorders\\/Essential Questions Chapter 21.docx\",\"doneorders\\/Essential Questions Chapter 1123.docx\"]', '');

-- --------------------------------------------------------

--
-- Table structure for table `progressa`
--

CREATE TABLE `progressa` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer_files` text DEFAULT NULL,
  `answer_comments` text DEFAULT NULL,
  `explanation_files` text DEFAULT NULL,
  `explanation_comments` text DEFAULT NULL,
  `clarification` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `QuestionText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `user_id` int(11) NOT NULL,
  `rating_status` enum('helpful','unhelpful') NOT NULL,
  `reason` text DEFAULT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`user_id`, `rating_status`, `reason`, `order_id`) VALUES
(20, 'helpful', NULL, 0),
(89, 'helpful', 'non', 93),
(89, 'helpful', 'non', 93),
(51, 'unhelpful', 'explanation', 100),
(51, 'helpful', 'non', 94),
(51, 'helpful', 'non', 112),
(51, 'helpful', 'non', 111),
(51, 'helpful', 'work', 113),
(51, 'helpful', 'non', 101),
(51, 'helpful', 'non', 116),
(51, 'helpful', 'non', 122),
(51, 'helpful', 'non', 124),
(51, 'helpful', 'non', 126),
(51, 'helpful', 'good work', 143),
(51, 'helpful', 'non', 120),
(51, 'helpful', 'non', 121),
(51, 'helpful', 'non', 123),
(89, 'helpful', 'non', 141),
(89, 'helpful', 'non', 142),
(89, 'helpful', 'non', 95),
(51, 'helpful', 'non', 118),
(51, 'helpful', 'non', 136),
(51, 'helpful', 'non', 152),
(64, 'helpful', 'non', 154),
(64, 'helpful', 'non', 156),
(64, 'helpful', 'non', 157),
(64, 'helpful', 'non', 158),
(64, 'helpful', 'non', 159),
(64, 'helpful', 'non', 161),
(95, 'helpful', 'good work', 166),
(89, 'helpful', 'non', 92),
(89, 'helpful', 'non', 145),
(64, 'helpful', 'non', 175),
(64, 'helpful', 'non', 174),
(64, 'helpful', 'non', 176),
(97, 'helpful', 'non', 9),
(97, 'unhelpful', 'no title', 177),
(97, 'helpful', 'non', 178),
(98, 'helpful', 'non', 10),
(98, 'unhelpful', 'bad work', 179),
(98, 'helpful', 'non', 181),
(51, 'helpful', 'non', 183),
(64, 'helpful', 'non', 184);

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `ReferralID` int(11) NOT NULL,
  `ReferrerUserID` int(11) DEFAULT NULL,
  `ReferredUserID` int(11) DEFAULT NULL,
  `ReferralCode` varchar(100) DEFAULT NULL,
  `ReferredAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ReportID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ReportType` varchar(100) NOT NULL,
  `ReportData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ReportData`)),
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `document_upload_link` varchar(500) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `document_name` varchar(255) DEFAULT NULL,
  `status` enum('beingdone','skipped','beingread','waiting','undone') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `ResponseID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `ResponseText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restrict`
--

CREATE TABLE `restrict` (
  `RestrictID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RestrictDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `RewardID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `RewardType` varchar(100) DEFAULT NULL,
  `RewardValue` decimal(10,2) DEFAULT NULL,
  `GrantedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`) VALUES
(1, 'client'),
(2, 'tutor'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

CREATE TABLE `samples` (
  `SampleID` int(11) NOT NULL,
  `SampleName` varchar(255) NOT NULL,
  `SampleDescription` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skipping`
--

CREATE TABLE `skipping` (
  `skip_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `skip_responses` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skipping`
--

INSERT INTO `skipping` (`skip_id`, `order_id`, `client_id`, `tutor_id`, `subject`, `name`, `description`, `instructions`, `deadline`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`, `skip_responses`) VALUES
(11, 8, 50, NULL, 'kuku', 'omena', 'cow', 'goat', '2025-01-27 17:28:00', 'https://localhost/uploads/1737297027_678d0c83554c6_What is Wellness1.pptx', NULL, NULL, 160.00, 4, 'undone', '2025-01-19 17:30:27', '2025-01-19 17:30:27', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(12, 8, 50, NULL, 'kuku', 'omena', 'cow', 'goat', '2025-01-27 17:28:00', 'https://localhost/uploads/1737297027_678d0c83554c6_What is Wellness1.pptx', NULL, NULL, 160.00, 4, '', '2025-01-19 17:30:27', '2025-02-10 15:05:17', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(13, 9, 50, NULL, 'maths ', 'omena', 'nh', ',kjkh', '2025-01-01 17:30:00', 'https://localhost/uploads/1737297066_678d0caaec752_6EED226D-5694-4170-8BDD-7836C6FF5981.png', NULL, NULL, 280.00, 7, 'undone', '2025-01-19 17:31:06', '2025-01-19 17:31:06', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(14, 9, 50, NULL, 'maths ', 'omena', 'nh', ',kjkh', '2025-01-01 17:30:00', 'https://localhost/uploads/1737297066_678d0caaec752_6EED226D-5694-4170-8BDD-7836C6FF5981.png', NULL, NULL, 280.00, 7, '', '2025-01-19 17:31:06', '2025-02-10 15:11:40', '{\"q1\":[\"Wrong subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(15, 10, 50, NULL, 'maths ', 'll', 'hh', 'uyt', '2025-01-28 17:35:00', NULL, NULL, NULL, 180.00, 6, 'undone', '2025-01-19 17:36:07', '2025-01-19 17:36:07', '{\"q1\":[\"Wrong subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(16, 11, 50, NULL, 'ju', 'ytr', 'oituy', 'ukyt', '2025-01-31 17:39:00', NULL, NULL, NULL, 450.00, 9, 'undone', '2025-01-19 17:39:48', '2025-01-19 17:39:48', '{\"q1\":[],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[\"I haven\'t learned this topic yet\"],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(17, 12, 50, NULL, 'hy', 'ki', 'jhg', 'kjh', '2025-01-30 17:43:00', 'https://localhost/uploads/1737297829_678d0fa50cfde_nxlzjgq.png', NULL, NULL, 5000.00, 100, 'undone', '2025-01-19 17:43:49', '2025-01-19 17:43:49', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(18, 13, 50, NULL, 'hy', 'ki', 'jhg', 'kjh', '2025-01-30 17:43:00', 'https://localhost/uploads/1737297887_678d0fdfa895d_nxlzjgq.png', NULL, NULL, 0.00, 100, 'undone', '2025-01-19 17:44:47', '2025-01-19 17:44:47', '{\"q1\":[\"Other\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(19, 13, 50, NULL, 'hy', 'ki', 'jhg', 'kjh', '2025-01-30 17:43:00', 'https://localhost/uploads/1737297887_678d0fdfa895d_nxlzjgq.png', NULL, NULL, 0.00, 100, 'undone', '2025-01-19 17:44:47', '2025-01-19 17:44:47', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(20, 8, 50, NULL, 'kuku', 'omena', 'cow', 'goat', '2025-01-27 17:28:00', 'https://localhost/uploads/1737297027_678d0c83554c6_What is Wellness1.pptx', NULL, NULL, 160.00, 4, '', '2025-01-19 17:30:27', '2025-02-10 15:05:17', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(21, 14, 50, NULL, 'hy', 'ki', 'jhg', 'kjh', '2025-01-30 17:43:00', 'https://localhost/uploads/1737297989_678d1045c3e0f_nxlzjgq.png', NULL, NULL, 0.00, 100, 'undone', '2025-01-19 17:46:29', '2025-01-19 17:46:29', '{\"q1\":[\"Lack of instructions\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(22, 15, 50, NULL, 'hy', 'ki', 'jhg', 'kjh', '2025-01-30 17:43:00', 'https://localhost/uploads/1737298125_678d10cd2b240_nxlzjgq.png', NULL, NULL, 0.00, 100, 'undone', '2025-01-19 17:48:45', '2025-01-19 17:48:45', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(23, 16, 50, NULL, 'maths ', 'kiuyt', 'iuy', 'kuy', '2025-01-23 17:49:00', NULL, NULL, NULL, 200.00, 5, 'undone', '2025-01-19 17:49:24', '2025-01-19 17:49:24', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(24, 16, 50, NULL, 'maths ', 'kiuyt', 'iuy', 'kuy', '2025-01-23 17:49:00', NULL, NULL, NULL, 200.00, 5, 'undone', '2025-01-19 17:49:24', '2025-01-19 17:49:24', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(25, 17, 50, NULL, 'maths ', 'kiuyt', 'iuy', 'kuy', '2025-01-23 17:49:00', NULL, NULL, NULL, 150.00, 5, 'undone', '2025-01-19 17:51:20', '2025-01-19 17:51:20', '{\"q1\":[\"Other\"],\"q1_other\":\"add\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(26, 18, 50, NULL, 'maths ', 'kiuyt', 'iuy', 'kuy', '2025-01-23 17:49:00', NULL, NULL, NULL, 180.00, 6, 'undone', '2025-01-19 17:51:42', '2025-01-19 17:51:42', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(27, 19, 50, NULL, 'maths ', 'kiuyt', 'iuy', 'kuy', '2025-01-23 17:49:00', NULL, NULL, NULL, 210.00, 7, 'undone', '2025-01-19 17:53:22', '2025-01-19 17:53:22', '{\"q1\":[],\"q1_other\":\"\",\"q2\":[\"History\"],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(28, 20, 67, NULL, 'JULIUS', 'SAMUEL', 'essay', 'free AI', '2025-01-22 03:55:00', 'https://localhost/uploads/1737421009_678ef0d1b0205_cv.pdf', NULL, NULL, 160.00, 4, 'undone', '2025-01-21 03:56:49', '2025-01-21 03:56:49', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[\"Example similar to the question\"],\"q5_other\":\"\",\"q6\":\"\"}'),
(29, 21, 67, NULL, 'hhhj', 'hhhjdfffffg', 'hhhj', 'hhhj', '2025-01-28 04:14:00', 'uploads/cv.pdf', NULL, NULL, 160.00, 4, 'undone', '2025-01-21 04:18:47', '2025-01-21 04:18:47', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(30, 22, 67, NULL, 'jhgt', 'jhgt', 'jhgt', 'jhgt', '2025-01-23 04:22:00', NULL, NULL, NULL, 320.00, 8, 'undone', '2025-01-21 04:22:40', '2025-01-21 04:22:40', '{\"q1\":[],\"q1_other\":\"\",\"q2\":[\"Science\"],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(31, 23, 67, NULL, 'lkjhytg', 'lkjhytg', 'lkjhytg', 'lkjhytg', '2025-01-29 04:26:00', 'uploads/Picture1.pdf', NULL, NULL, 100.00, 2, 'undone', '2025-01-21 04:27:01', '2025-01-21 04:27:01', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(32, 24, 67, NULL, 'koki', 'koki', 'koki', 'koki', '2025-01-22 04:29:00', 'uploads/Last Professional behaviours and valuing people.pdf', NULL, NULL, 100.00, 2, 'undone', '2025-01-21 04:29:54', '2025-01-21 04:29:54', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(33, 25, 67, NULL, 'lkjhgf', 'lkjhgf', 'lkjhgf', 'lkjhgf', '2025-01-29 04:34:00', 'uploads/Abdulrahman_Saaty_CV.pdf', NULL, NULL, 150.00, 3, 'undone', '2025-01-21 04:35:19', '2025-01-21 04:35:19', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(34, 26, 67, NULL, 'hh', 'aaaaaaaak', 'jht', 'uiguig', '2025-01-24 04:37:00', 'uploads/Thesis Example.pdf', NULL, NULL, 400.00, 8, 'undone', '2025-01-21 04:41:23', '2025-01-21 04:41:23', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(35, 26, 67, NULL, 'hh', 'aaaaaaaak', 'jht', 'uiguig', '2025-01-24 04:37:00', 'uploads/Thesis Example.pdf', NULL, NULL, 400.00, 8, 'undone', '2025-01-21 04:41:23', '2025-01-21 04:41:23', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(36, 27, 50, NULL, 'document_name', 'document_name', '<?php\\r\\nerror_reporting(E_ALL);\\r\\nini_set(\\\'display_errors\\\', 1);\\r\\n\\r\\nheader(\\\'Content-Type: application/json\\\');\\r\\n\\r\\n// Database configuration\\r\\n$servername = \\\"localhost\\\";\\r\\n$username = \\\"root\\\";\\r\\n$password = \\\"\\\";\\r\\n$dbname = \\\"EduAssistaDB\\\";\\r\\n\\r\\ntry {\\r\\n    // Database connection\\r\\n    $conn = new mysqli($servername, $username, $password, $dbname);\\r\\n    if ($conn->connect_error) {\\r\\n        throw new Exception(\\\"Connection failed: \\\" . $conn->connect_error);\\r\\n    }\\r\\n\\r\\n    // Collect data from the form\\r\\n    $subject = isset($_POST[\\\'subject\\\']) ? $conn->real_escape_string($_POST[\\\'subject\\\']) : null;\\r\\n    $orderName = isset($_POST[\\\'order_name\\\']) ? $conn->real_escape_string($_POST[\\\'order_name\\\']) : null;  // Changed field name to \\\'name\\\'\\r\\n    $orderDescription = isset($_POST[\\\'order_description\\\']) ? $conn->real_escape_string($_POST[\\\'order_description\\\']) : null;\\r\\n    $orderInstructions = isset($_POST[\\\'upload_instructions\\\']) ? $conn->real_escape_string($_POST[\\\'upload_instructions\\\']) : null;\\r\\n    $orderDeadline = isset($_POST[\\\'order_deadline\\\']) ? $conn->real_escape_string($_POST[\\\'order_deadline\\\']) : null;\\r\\n    $clientID = isset($_POST[\\\'client_id\\\']) ? $conn->real_escape_string($_POST[\\\'client_id\\\']) : null;\\r\\n    $numberOfPages = isset($_POST[\\\'number_of_pages\\\']) ? (int)$_POST[\\\'number_of_pages\\\'] : null;\\r\\n    $totalPrice = isset($_POST[\\\'total_price\\\']) ? (float)$_POST[\\\'total_price\\\'] : 0.0;\\r\\n\\r\\n    if (empty($subject) || empty($orderName) || empty($orderDescription) || empty($orderDeadline) || empty($clientID)) {\\r\\n        throw new Exception(\\\"Some required fields are missing.\\\");\\r\\n    }\\r\\n\\r\\n    // Check if the order deadline is at least 1 hour from the current time\\r\\n    $currentDateTime = new DateTime();\\r\\n    $deadlineDateTime = new DateTime($orderDeadline);\\r\\n    $interval = $currentDateTime->diff($deadlineDateTime);\\r\\n\\r\\n    if ($interval->h < 1 && $interval->d == 0) {\\r\\n        throw new Exception(\\\"Order deadline must be at least 1 hour from the current time.\\\");\\r\\n    }\\r\\n\\r\\n    $documentName = null;\\r\\n    $documentUploadLink = null;\\r\\n\\r\\n    if (isset($_FILES[\\\'order_document\\\']) && $_FILES[\\\'order_document\\\'][\\\'error\\\'] === UPLOAD_ERR_OK) {\\r\\n        // File upload logic\\r\\n        $uploadDir = \\\'uploads/\\\';  // Ensure this is a relative path, accessible via URL\\r\\n        $documentName = basename($_FILES[\\\'order_document\\\'][\\\'name\\\']);\\r\\n        $uploadFile = $uploadDir . $documentName;\\r\\n\\r\\n        // Make sure the directory exists and is writable\\r\\n        if (!is_dir($uploadDir)) {\\r\\n            mkdir($uploadDir, 0777, true);  // Create directory if it doesn\\\'t exist\\r\\n        }\\r\\n\\r\\n        if (move_uploaded_file($_FILES[\\\'order_document\\\'][\\\'tmp_name\\\'], $uploadFile)) {\\r\\n            $documentUploadLink = $uploadDir . $documentName; // Relative file path to store\\r\\n        } else {\\r\\n            throw new Exception(\\\"Error uploading the file.\\\");\\r\\n        }\\r\\n    }\\r\\n\\r\\n    // Prepare and execute insert query\\r\\n    $stmt = $conn->prepare(\\\"INSERT INTO orders (client_id, subject, name, description, instructions, deadline, number_of_pages, price, name, document_upload_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\\\");\\r\\n    $stmt->bind_param(\\\"issssssdis\\\", $clientID, $subject, $orderName, $orderDescription, $orderInstructions, $orderDeadline, $numberOfPages, $totalPrice, $documentName, $documentUploadLink);\\r\\n\\r\\n    if ($stmt->execute()) {\\r\\n        echo json_encode([\\\'success\\\' => true, \\\'message\\\' => \\\'Order placed successfully\\\']);\\r\\n    } else {\\r\\n        throw new Exception(\\\"Error placing the order.\\\");\\r\\n    }\\r\\n\\r\\n    $stmt->close();\\r\\n    $conn->close();\\r\\n} catch (Exception $e) {\\r\\n    echo json_encode([\\\'success\\\' => false, \\\'message\\\' => $e->getMessage()]);\\r\\n}\\r\\n?>\\r\\n', '<?php\\r\\nerror_reporting(E_ALL);\\r\\nini_set(\\\'display_errors\\\', 1);\\r\\n\\r\\nheader(\\\'Content-Type: application/json\\\');\\r\\n\\r\\n// Database configuration\\r\\n$servername = \\\"localhost\\\";\\r\\n$username = \\\"root\\\";\\r\\n$password = \\\"\\\";\\r\\n$dbname = \\\"EduAssistaDB\\\";\\r\\n\\r\\ntry {\\r\\n    // Database connection\\r\\n    $conn = new mysqli($servername, $username, $password, $dbname);\\r\\n    if ($conn->connect_error) {\\r\\n        throw new Exception(\\\"Connection failed: \\\" . $conn->connect_error);\\r\\n    }\\r\\n\\r\\n    // Collect data from the form\\r\\n    $subject = isset($_POST[\\\'subject\\\']) ? $conn->real_escape_string($_POST[\\\'subject\\\']) : null;\\r\\n    $orderName = isset($_POST[\\\'order_name\\\']) ? $conn->real_escape_string($_POST[\\\'order_name\\\']) : null;  // Changed field name to \\\'name\\\'\\r\\n    $orderDescription = isset($_POST[\\\'order_description\\\']) ? $conn->real_escape_string($_POST[\\\'order_description\\\']) : null;\\r\\n    $orderInstructions = isset($_POST[\\\'upload_instructions\\\']) ? $conn->real_escape_string($_POST[\\\'upload_instructions\\\']) : null;\\r\\n    $orderDeadline = isset($_POST[\\\'order_deadline\\\']) ? $conn->real_escape_string($_POST[\\\'order_deadline\\\']) : null;\\r\\n    $clientID = isset($_POST[\\\'client_id\\\']) ? $conn->real_escape_string($_POST[\\\'client_id\\\']) : null;\\r\\n    $numberOfPages = isset($_POST[\\\'number_of_pages\\\']) ? (int)$_POST[\\\'number_of_pages\\\'] : null;\\r\\n    $totalPrice = isset($_POST[\\\'total_price\\\']) ? (float)$_POST[\\\'total_price\\\'] : 0.0;\\r\\n\\r\\n    if (empty($subject) || empty($orderName) || empty($orderDescription) || empty($orderDeadline) || empty($clientID)) {\\r\\n        throw new Exception(\\\"Some required fields are missing.\\\");\\r\\n    }\\r\\n\\r\\n    // Check if the order deadline is at least 1 hour from the current time\\r\\n    $currentDateTime = new DateTime();\\r\\n    $deadlineDateTime = new DateTime($orderDeadline);\\r\\n    $interval = $currentDateTime->diff($deadlineDateTime);\\r\\n\\r\\n    if ($interval->h < 1 && $interval->d == 0) {\\r\\n        throw new Exception(\\\"Order deadline must be at least 1 hour from the current time.\\\");\\r\\n    }\\r\\n\\r\\n    $documentName = null;\\r\\n    $documentUploadLink = null;\\r\\n\\r\\n    if (isset($_FILES[\\\'order_document\\\']) && $_FILES[\\\'order_document\\\'][\\\'error\\\'] === UPLOAD_ERR_OK) {\\r\\n        // File upload logic\\r\\n        $uploadDir = \\\'uploads/\\\';  // Ensure this is a relative path, accessible via URL\\r\\n        $documentName = basename($_FILES[\\\'order_document\\\'][\\\'name\\\']);\\r\\n        $uploadFile = $uploadDir . $documentName;\\r\\n\\r\\n        // Make sure the directory exists and is writable\\r\\n        if (!is_dir($uploadDir)) {\\r\\n            mkdir($uploadDir, 0777, true);  // Create directory if it doesn\\\'t exist\\r\\n        }\\r\\n\\r\\n        if (move_uploaded_file($_FILES[\\\'order_document\\\'][\\\'tmp_name\\\'], $uploadFile)) {\\r\\n            $documentUploadLink = $uploadDir . $documentName; // Relative file path to store\\r\\n        } else {\\r\\n            throw new Exception(\\\"Error uploading the file.\\\");\\r\\n        }\\r\\n    }\\r\\n\\r\\n    // Prepare and execute insert query\\r\\n    $stmt = $conn->prepare(\\\"INSERT INTO orders (client_id, subject, name, description, instructions, deadline, number_of_pages, price, name, document_upload_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)\\\");\\r\\n    $stmt->bind_param(\\\"issssssdis\\\", $clientID, $subject, $orderName, $orderDescription, $orderInstructions, $orderDeadline, $numberOfPages, $totalPrice, $documentName, $documentUploadLink);\\r\\n\\r\\n    if ($stmt->execute()) {\\r\\n        echo json_encode([\\\'success\\\' => true, \\\'message\\\' => \\\'Order placed successfully\\\']);\\r\\n    } else {\\r\\n        throw new Exception(\\\"Error placing the order.\\\");\\r\\n    }\\r\\n\\r\\n    $stmt->close();\\r\\n    $conn->close();\\r\\n} catch (Exception $e) {\\r\\n    echo json_encode([\\\'success\\\' => false, \\\'message\\\' => $e->getMessage()]);\\r\\n}\\r\\n?>\\r\\n', '2025-02-28 22:24:00', 'uploads/7.png', NULL, NULL, 250.00, 5, 'undone', '2025-02-10 16:31:28', '2025-02-10 16:31:28', '{\"q1\":[],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[\"Example similar to the question\"],\"q5_other\":\"\",\"q6\":\"\"}'),
(37, 28, 50, NULL, 'document_name', 'document_name', 'caro', 'mueni', '2025-02-28 22:24:00', 'uploads/7.png', NULL, NULL, 450.00, 9, 'undone', '2025-02-10 16:40:35', '2025-02-10 16:40:35', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(38, 29, 50, NULL, 'maths ', 'aaaaaaaak', 'jhkj', 'oiuy', '2025-02-19 05:17:00', 'uploads/1.png', NULL, NULL, 400.00, 8, 'undone', '2025-02-11 02:14:55', '2025-02-11 02:14:55', '{\"q1\":[\"Wrong subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(39, 30, 50, NULL, 'hjn', 'kujyhtgf', 'dfghjk', 'dfgnm,', '2025-02-20 02:29:00', '', NULL, NULL, 300.00, 6, 'undone', '2025-02-11 02:29:30', '2025-02-11 02:29:30', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(40, 31, 50, NULL, 'maths ', 'aaaaaaaak', 'esdryj', 'jdjdj', '2025-02-28 02:31:00', '', NULL, NULL, 250.00, 5, 'undone', '2025-02-11 02:31:58', '2025-02-11 02:31:58', '{\"q1\":[\"Unwanted subject\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(41, 32, 50, NULL, 'coding', 'poiuy', 'wedfg', 'errrrrr', '2025-02-22 02:34:00', '', NULL, NULL, 450.00, 9, 'undone', '2025-02-11 02:34:46', '2025-02-11 02:34:46', '{\"q1\":[\"Question difficulty\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(42, 33, 50, NULL, 'document_name', 'ektttttttttttt', 'keetkkkkkkk', 'ektukkkk ', '2025-02-28 02:35:00', 'uploads/America Playground Safety Report Card.pdf', NULL, NULL, 180.00, 6, 'undone', '2025-02-11 02:35:37', '2025-02-11 02:35:37', '{\"q1\":[],\"q1_other\":\"\",\"q2\":[\"Literature\"],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}'),
(43, 34, 50, NULL, 'science', 'A recommendations section that takes into account the ideas presented in analysis, and provides a few ideas of actions that should be taken to improve the organizational communications at the subject organization. An excellent job will go further than a s', 'Chapter 12: The Physical Environment\\r\\nBody\\r\\nThe physical environment is very important for infants and toddlers because it affects their safety, health, and learning. A good environment helps children grow, explore, and develop in a safe and comfortable space. This chapter talks about how to create a safe, healthy, and developmentally appropriate place for young children.\\r\\n\\r\\nA safe environment (Page 262) means that children are protected from harm. Caregivers must remove anything that could hurt a child, such as sharp objects, small items they can swallow, and unsafe furniture. A safety checklist (Page 262) helps to make sure everything is child-friendly. For example, electrical outlets should be covered, floors should be clean and dry to prevent slipping, and heavy furniture should not fall over.\\r\\n\\r\\nA healthful environment (Page 264) means keeping the area clean to prevent sickness. Germs can spread quickly among young children, so it is important to wash hands often, clean toys and surfaces, and make sure the air is fresh. A health checklist (Page 264) includes washing hands before and after meals, cleaning diaper-changing areas, and keeping sick children away from others.\\r\\n\\r\\nNutrition (Page 265) is also an important part of a good environment. Babies need to be fed breast milk or formula, while toddlers start eating soft, healthy foods. Feeding infants (Page 265) should be done in a quiet, comfortable place, and caregivers should hold the baby while feeding. Feeding toddlers (Page 266) involves giving them different types of foods to help them grow strong. Meals should be served at regular times, and children should be encouraged to feed themselves.\\r\\n\\r\\nThe learning environment (Page 268) includes how the space is arranged to help children explore, play, and learn. The layout (Page 273) should have separate areas for eating, sleeping, diapering, and playing. The eating area (Page 273) should be clean and quiet so children can focus on their meals. The sleeping area (Page 273) must be comfortable, with cribs for infants and small beds for toddlers. The diapering (Page 274) and toileting (Page 274) areas should be clean and easy to use.\\r\\n\\r\\nA developmentally appropriate environment (Page 274) means that the space should match the child’s age and abilities. Appropriate environments for infants (Page 275) include soft surfaces, safe toys, and a quiet space for sleeping. Appropriate environments for toddlers (Page 275) should have more space to walk, climb, and explore. Family child care and mixed-age groups (Page 275) require planning so that younger and older children can play safely together.\\r\\n\\r\\nChildren need a fun and engaging play environment (Page 277). Toys and materials for inside (Page 280) include soft toys, books, and puzzles. Toys and materials for outside (Page 281) include swings, sandboxes, and slides. The quality of the environment (Page 281) is very important, and caregivers must check if the space is safe and interesting for children.\\r\\n\\r\\nThe environment should have a balance between soft and hard materials (Page 282). It should also allow for intrusion and seclusion (Page 282), meaning children can sometimes play alone or with others. Spaces should encourage mobility (Page 283), allowing children to move freely. There should be a balance between open and closed spaces (Page 283) and between simple and complex activities (Page 283).\\r\\n\\r\\nOther important factors include scale (Page 284), which means that furniture and toys should be the right size for children, aesthetics (Page 284), meaning the space should look nice and inviting, and acoustics (Page 284), meaning that noise levels should not be too loud. The environment should also be ordered (Page 285) so that children know where to find things.\\r\\n\\r\\nCaregivers must follow appropriate practices (Page 286) to create a good physical environment for children.\\r\\n\\r\\nConclusion\\r\\nThe physical environment is very important in infant and toddler care. A good environment keeps children safe, healthy, and happy. It also helps them learn and grow. Caregivers must check safety, cleanliness, and learning spaces regularly to make sure children are comfortable. By providing safe furniture, healthy food, clean spaces, and fun play areas, caregivers create the best environment for young children.', 'Chapter 13: The Social Environment\\r\\nBody\\r\\nThe social environment is important because it helps children feel loved, safe, and connected to others. Infants and toddlers learn about themselves and the world through relationships with caregivers, family, and other children. This chapter talks about identity formation, attachment, self-image, cultural identity, gender identity, and self-concept.\\r\\n\\r\\nIdentity formation (Page 294) is the process of children learning who they are. Babies start to recognize themselves and the people around them. They begin to understand their own feelings and how they are different from others. Attachment (Page 296) is very important for emotional growth. When caregivers respond to a baby\\\'s needs with love and care, the baby feels safe. A strong bond helps children trust others and feel secure.\\r\\n\\r\\nSelf-image (Page 297) is how children see themselves. If they receive love and encouragement, they feel good about themselves. If they are ignored or treated badly, they may develop low self-esteem. Cultural identity (Page 297) is when children learn about their family\\\'s culture, language, and traditions. It is important for caregivers to respect and celebrate different cultures so children feel proud of who they are.\\r\\n\\r\\nGender identity (Page 301) is when children understand whether they are a boy or a girl. This happens at a young age as they watch how adults and other children behave. Caregivers should allow children to explore and express themselves without forcing gender roles. Self-concept and discipline (Page 303) shape how children behave and feel about themselves. If discipline is fair and respectful, children learn self-control and responsibility. If discipline is harsh, it can harm their self-esteem.\\r\\n\\r\\nA good social environment also means that caregivers must model self-esteem by taking care of themselves (Page 307). Children learn by watching adults. If caregivers show confidence and respect for themselves, children will do the same. Appropriate practice (Page 309) means treating each child with kindness and understanding.\\r\\n\\r\\nConclusion\\r\\nThe social environment plays a big role in helping children feel safe, loved, and confident. When children have strong relationships, they develop trust, self-esteem, and social skills. Caregivers must support identity formation, attachment, and self-concept by showing love, respect, and patience. A good social environment helps children feel happy and ready to learn.', '2025-02-19 05:05:00', 'uploads/America Playground Safety Report Card.pdf', NULL, NULL, 250.00, 5, 'undone', '2025-02-11 05:06:18', '2025-02-11 05:06:18', '{\"q1\":[\"Lack of instructions\"],\"q1_other\":\"\",\"q2\":[],\"q2_other\":\"\",\"q3\":[],\"q3_other\":\"\",\"q4\":[],\"q4_other\":\"\",\"q5\":[],\"q5_other\":\"\",\"q6\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `subjectid`
--

CREATE TABLE `subjectid` (
  `SubjectID` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `ExpertiseArea` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `ExpertiseArea`, `Subject`, `UpdatedAt`) VALUES
(1, 'Nursery / Preschool', 'Colors and Shapes', '2025-02-10 02:43:05'),
(2, 'Nursery / Preschool', 'Counting', '2025-02-10 02:43:05'),
(3, 'Nursery / Preschool', 'Storytelling', '2025-02-10 02:43:05'),
(4, 'Nursery / Preschool', 'Nursery Rhymes', '2025-02-10 02:43:05'),
(5, 'Nursery / Preschool', 'Fine Motor Skills', '2025-02-10 02:43:05'),
(6, 'Nursery / Preschool', 'Social Skills', '2025-02-10 02:43:05'),
(7, 'Nursery / Preschool', 'Alphabet Recognition', '2025-02-10 02:43:05'),
(8, 'Nursery / Preschool', 'Sensory Play', '2025-02-10 02:43:05'),
(9, 'Nursery / Preschool', 'Music and Movement', '2025-02-10 02:43:05'),
(10, 'Nursery / Preschool', 'Basic Hygiene', '2025-02-10 02:43:05'),
(11, 'Nursery / Preschool', 'Early Science Exploration', '2025-02-10 02:43:05'),
(12, 'Nursery / Preschool', 'Basic Geography', '2025-02-10 02:43:05'),
(13, 'Nursery / Preschool', 'Animal Recognition', '2025-02-10 02:43:05'),
(14, 'Nursery / Preschool', 'Emotional Learning', '2025-02-10 02:43:05'),
(15, 'Nursery / Preschool', 'Simple Crafts', '2025-02-10 02:43:05'),
(16, 'Nursery / Preschool', 'Nature Study', '2025-02-10 02:43:05'),
(17, 'Nursery / Preschool', 'Sorting and Matching', '2025-02-10 02:43:05'),
(18, 'Nursery / Preschool', 'Simple Puzzles', '2025-02-10 02:43:05'),
(19, 'Nursery / Preschool', 'Free Play', '2025-02-10 02:43:05'),
(20, 'Nursery / Preschool', 'Listening Skills', '2025-02-10 02:43:05'),
(21, 'Kindergarten', 'Phonics', '2025-02-10 02:43:05'),
(22, 'Kindergarten', 'Number Recognition', '2025-02-10 02:43:05'),
(23, 'Kindergarten', 'Simple Addition and Subtraction', '2025-02-10 02:43:05'),
(24, 'Kindergarten', 'Basic Reading', '2025-02-10 02:43:05'),
(25, 'Kindergarten', 'Handwriting', '2025-02-10 02:43:05'),
(26, 'Kindergarten', 'Social Behavior', '2025-02-10 02:43:05'),
(27, 'Kindergarten', 'Art and Crafts', '2025-02-10 02:43:05'),
(28, 'Kindergarten', 'Introduction to Music', '2025-02-10 02:43:05'),
(29, 'Kindergarten', 'Storytelling', '2025-02-10 02:43:05'),
(30, 'Kindergarten', 'Role Play', '2025-02-10 02:43:05'),
(31, 'Kindergarten', 'Seasons and Weather', '2025-02-10 02:43:05'),
(32, 'Kindergarten', 'Days of the Week', '2025-02-10 02:43:05'),
(33, 'Kindergarten', 'Basic Environmental Science', '2025-02-10 02:43:05'),
(34, 'Kindergarten', 'Basic Health Education', '2025-02-10 02:43:05'),
(35, 'Kindergarten', 'Introduction to Computers', '2025-02-10 02:43:05'),
(36, 'Kindergarten', 'Physical Education', '2025-02-10 02:43:05'),
(37, 'Kindergarten', 'Shapes and Patterns', '2025-02-10 02:43:05'),
(38, 'Kindergarten', 'Family and Community', '2025-02-10 02:43:05'),
(39, 'Kindergarten', 'Basic Moral Education', '2025-02-10 02:43:05'),
(40, 'Primary / Elementary School', 'Mathematics', '2025-02-10 02:43:05'),
(41, 'Primary / Elementary School', 'English', '2025-02-10 02:43:05'),
(42, 'Primary / Elementary School', 'Science', '2025-02-10 02:43:05'),
(43, 'Primary / Elementary School', 'Social Studies', '2025-02-10 02:43:05'),
(44, 'Primary / Elementary School', 'Reading and Writing', '2025-02-10 02:43:05'),
(45, 'Primary / Elementary School', 'Handwriting', '2025-02-10 02:43:05'),
(46, 'Primary / Elementary School', 'Spelling', '2025-02-10 02:43:05'),
(47, 'Primary / Elementary School', 'Basic Geography', '2025-02-10 02:43:05'),
(48, 'Primary / Elementary School', 'Basic History', '2025-02-10 02:43:05'),
(49, 'Primary / Elementary School', 'Environmental Science', '2025-02-10 02:43:05'),
(50, 'Primary / Elementary School', 'Introduction to Coding', '2025-02-10 02:43:05'),
(51, 'Primary / Elementary School', 'Arts and Crafts', '2025-02-10 02:43:05'),
(52, 'Primary / Elementary School', 'Physical Education', '2025-02-10 02:43:05'),
(53, 'Primary / Elementary School', 'Health and Hygiene', '2025-02-10 02:43:05'),
(54, 'Primary / Elementary School', 'Story Writing', '2025-02-10 02:43:05'),
(55, 'Primary / Elementary School', 'Music', '2025-02-10 02:43:05'),
(56, 'Primary / Elementary School', 'Drama', '2025-02-10 02:43:05'),
(57, 'Primary / Elementary School', 'Introduction to Foreign Languages', '2025-02-10 02:43:05'),
(58, 'Primary / Elementary School', 'Moral Education', '2025-02-10 02:43:05'),
(59, 'Primary / Elementary School', 'Life Skills', '2025-02-10 02:43:05'),
(60, 'Doctoral Degree (PhD & Professional Doctorates)', 'Theoretical Computer Science', '2025-02-10 02:43:05'),
(61, 'Doctoral Degree (PhD & Professional Doctorates)', 'Artificial Intelligence Research', '2025-02-10 02:43:05'),
(62, 'Doctoral Degree (PhD & Professional Doctorates)', 'Cybersecurity Research', '2025-02-10 02:43:05'),
(63, 'Doctoral Degree (PhD & Professional Doctorates)', 'Business Strategy', '2025-02-10 02:43:05'),
(64, 'Doctoral Degree (PhD & Professional Doctorates)', 'Organizational Leadership', '2025-02-10 02:43:05'),
(65, 'Doctoral Degree (PhD & Professional Doctorates)', 'Corporate Governance', '2025-02-10 02:43:05'),
(66, 'Doctoral Degree (PhD & Professional Doctorates)', 'Financial Risk Management', '2025-02-10 02:43:05'),
(67, 'Doctoral Degree (PhD & Professional Doctorates)', 'International Law Theory', '2025-02-10 02:43:05'),
(68, 'Doctoral Degree (PhD & Professional Doctorates)', 'Public Administration Research', '2025-02-10 02:43:05'),
(69, 'Doctoral Degree (PhD & Professional Doctorates)', 'Economic Policy Analysis', '2025-02-10 02:43:05'),
(70, 'Middle School / Junior High', 'Algebra', '2025-02-10 02:45:47'),
(71, 'Middle School / Junior High', 'Geometry', '2025-02-10 02:45:47'),
(72, 'Middle School / Junior High', 'Earth Science', '2025-02-10 02:45:47'),
(73, 'Middle School / Junior High', 'Biology', '2025-02-10 02:45:47'),
(74, 'Middle School / Junior High', 'Physics', '2025-02-10 02:45:47'),
(75, 'Middle School / Junior High', 'Chemistry', '2025-02-10 02:45:47'),
(76, 'Middle School / Junior High', 'History', '2025-02-10 02:45:47'),
(77, 'Middle School / Junior High', 'Geography', '2025-02-10 02:45:47'),
(78, 'Middle School / Junior High', 'Civics and Government', '2025-02-10 02:45:47'),
(79, 'Middle School / Junior High', 'Creative Writing', '2025-02-10 02:45:47'),
(80, 'Middle School / Junior High', 'Foreign Language (French, Spanish, etc.)', '2025-02-10 02:45:47'),
(81, 'Middle School / Junior High', 'Physical Education', '2025-02-10 02:45:47'),
(82, 'Middle School / Junior High', 'Art', '2025-02-10 02:45:47'),
(83, 'Middle School / Junior High', 'Music', '2025-02-10 02:45:47'),
(84, 'Middle School / Junior High', 'Computer Science', '2025-02-10 02:45:47'),
(85, 'Middle School / Junior High', 'Health and Nutrition', '2025-02-10 02:45:47'),
(86, 'Middle School / Junior High', 'Life Skills', '2025-02-10 02:45:47'),
(87, 'Middle School / Junior High', 'Public Speaking', '2025-02-10 02:45:47'),
(88, 'Middle School / Junior High', 'Social Studies', '2025-02-10 02:45:47'),
(89, 'High School', 'Advanced Algebra', '2025-02-10 02:45:47'),
(90, 'High School', 'Trigonometry', '2025-02-10 02:45:47'),
(91, 'High School', 'Calculus', '2025-02-10 02:45:47'),
(92, 'High School', 'Statistics', '2025-02-10 02:45:47'),
(93, 'High School', 'Physics', '2025-02-10 02:45:47'),
(94, 'High School', 'Advanced Chemistry', '2025-02-10 02:45:47'),
(95, 'High School', 'Biology', '2025-02-10 02:45:47'),
(96, 'High School', 'Environmental Science', '2025-02-10 02:45:47'),
(97, 'High School', 'U.S. History', '2025-02-10 02:45:47'),
(98, 'High School', 'World History', '2025-02-10 02:45:47'),
(99, 'High School', 'Geography', '2025-02-10 02:45:47'),
(100, 'High School', 'Political Science', '2025-02-10 02:45:47'),
(101, 'High School', 'Psychology', '2025-02-10 02:45:47'),
(102, 'High School', 'Sociology', '2025-02-10 02:45:47'),
(103, 'High School', 'English Literature', '2025-02-10 02:45:47'),
(104, 'High School', 'Composition and Rhetoric', '2025-02-10 02:45:47'),
(105, 'High School', 'Journalism', '2025-02-10 02:45:47'),
(106, 'High School', 'Creative Writing', '2025-02-10 02:45:47'),
(107, 'High School', 'Foreign Languages', '2025-02-10 02:45:47'),
(108, 'High School', 'Computer Programming', '2025-02-10 02:45:47'),
(109, 'High School', 'Graphic Design', '2025-02-10 02:45:47'),
(110, 'High School', 'Business Studies', '2025-02-10 02:45:47'),
(111, 'High School', 'Entrepreneurship', '2025-02-10 02:45:47'),
(112, 'High School', 'Accounting', '2025-02-10 02:45:47'),
(113, 'High School', 'Economics', '2025-02-10 02:45:47'),
(114, 'High School', 'Music Theory', '2025-02-10 02:45:47'),
(115, 'High School', 'Performing Arts', '2025-02-10 02:45:47'),
(116, 'High School', 'Film Studies', '2025-02-10 02:45:47'),
(117, 'High School', 'Automotive Technology', '2025-02-10 02:45:47'),
(118, 'High School', 'Culinary Arts', '2025-02-10 02:45:47'),
(119, 'High School', 'Agricultural Science', '2025-02-10 02:45:47'),
(120, 'High School', 'Health Sciences', '2025-02-10 02:45:47'),
(121, 'High School', 'Physical Education', '2025-02-10 02:45:47'),
(122, 'High School', 'Ethics and Philosophy', '2025-02-10 02:45:47'),
(123, 'Vocational Training', 'Automotive Repair', '2025-02-10 02:45:47'),
(124, 'Vocational Training', 'Plumbing', '2025-02-10 02:45:47'),
(125, 'Vocational Training', 'Electrical Engineering', '2025-02-10 02:45:47'),
(126, 'Vocational Training', 'Carpentry', '2025-02-10 02:45:47'),
(127, 'Vocational Training', 'Masonry', '2025-02-10 02:45:47'),
(128, 'Vocational Training', 'Culinary Arts', '2025-02-10 02:45:47'),
(129, 'Vocational Training', 'Hotel Management', '2025-02-10 02:45:47'),
(130, 'Vocational Training', 'Welding', '2025-02-10 02:45:47'),
(131, 'Vocational Training', 'HVAC Systems', '2025-02-10 02:45:47'),
(132, 'Vocational Training', 'Fashion Design', '2025-02-10 02:45:47'),
(133, 'Vocational Training', 'Hairdressing and Cosmetology', '2025-02-10 02:45:47'),
(134, 'Vocational Training', 'Photography', '2025-02-10 02:45:47'),
(135, 'Vocational Training', 'Graphic Design', '2025-02-10 02:45:47'),
(136, 'Vocational Training', 'IT Support', '2025-02-10 02:45:47'),
(137, 'Vocational Training', 'Cybersecurity Fundamentals', '2025-02-10 02:45:47'),
(138, 'Vocational Training', 'Digital Marketing', '2025-02-10 02:45:47'),
(139, 'Vocational Training', 'Customer Service Training', '2025-02-10 02:45:47'),
(140, 'Vocational Training', 'Healthcare Assistance', '2025-02-10 02:45:47'),
(141, 'Vocational Training', 'Early Childhood Education', '2025-02-10 02:45:47'),
(142, 'Undergraduate Degree', 'Engineering', '2025-02-10 02:45:47'),
(143, 'Undergraduate Degree', 'Computer Science', '2025-02-10 02:45:47'),
(144, 'Undergraduate Degree', 'Medicine', '2025-02-10 02:45:47'),
(145, 'Undergraduate Degree', 'Business Administration', '2025-02-10 02:45:47'),
(146, 'Undergraduate Degree', 'Marketing', '2025-02-10 02:45:47'),
(147, 'Undergraduate Degree', 'Finance', '2025-02-10 02:45:47'),
(148, 'Undergraduate Degree', 'Accounting', '2025-02-10 02:45:47'),
(149, 'Undergraduate Degree', 'Economics', '2025-02-10 02:45:47'),
(150, 'Undergraduate Degree', 'Political Science', '2025-02-10 02:45:47'),
(151, 'Undergraduate Degree', 'Law', '2025-02-10 02:45:47'),
(152, 'Undergraduate Degree', 'Sociology', '2025-02-10 02:45:47'),
(153, 'Undergraduate Degree', 'Psychology', '2025-02-10 02:45:47'),
(154, 'Undergraduate Degree', 'Biochemistry', '2025-02-10 02:45:47'),
(155, 'Undergraduate Degree', 'Physics', '2025-02-10 02:45:47'),
(156, 'Undergraduate Degree', 'Mathematics', '2025-02-10 02:45:47'),
(157, 'Undergraduate Degree', 'Statistics', '2025-02-10 02:45:47'),
(158, 'Undergraduate Degree', 'Philosophy', '2025-02-10 02:45:47'),
(159, 'Undergraduate Degree', 'Theology', '2025-02-10 02:45:47'),
(160, 'Undergraduate Degree', 'History', '2025-02-10 02:45:47'),
(161, 'Undergraduate Degree', 'Geography', '2025-02-10 02:45:47'),
(162, 'Undergraduate Degree', 'Architecture', '2025-02-10 02:45:47'),
(163, 'Undergraduate Degree', 'Environmental Science', '2025-02-10 02:45:47'),
(164, 'Undergraduate Degree', 'Linguistics', '2025-02-10 02:45:47'),
(165, 'Undergraduate Degree', 'International Relations', '2025-02-10 02:45:47'),
(166, 'Undergraduate Degree', 'Public Administration', '2025-02-10 02:45:47'),
(167, 'Undergraduate Degree', 'Education', '2025-02-10 02:45:47'),
(168, 'Undergraduate Degree', 'Journalism', '2025-02-10 02:45:47'),
(169, 'Undergraduate Degree', 'Performing Arts', '2025-02-10 02:45:47'),
(170, 'Undergraduate Degree', 'Graphic Design', '2025-02-10 02:45:47'),
(171, 'Undergraduate Degree', 'Anthropology', '2025-02-10 02:45:47'),
(172, 'Master’s Degree', 'Data Science', '2025-02-10 02:45:47'),
(173, 'Master’s Degree', 'Artificial Intelligence', '2025-02-10 02:45:47'),
(174, 'Master’s Degree', 'Cybersecurity', '2025-02-10 02:45:47'),
(175, 'Master’s Degree', 'Healthcare Management', '2025-02-10 02:45:47'),
(176, 'Master’s Degree', 'Public Health', '2025-02-10 02:45:47'),
(177, 'Master’s Degree', 'Business Administration (MBA)', '2025-02-10 02:45:47'),
(178, 'Master’s Degree', 'Finance and Investment', '2025-02-10 02:45:47'),
(179, 'Master’s Degree', 'Marketing Strategy', '2025-02-10 02:45:47'),
(180, 'Master’s Degree', 'Supply Chain Management', '2025-02-10 02:45:47'),
(181, 'Master’s Degree', 'Human Resources', '2025-02-10 02:45:47'),
(182, 'Master’s Degree', 'Political Science', '2025-02-10 02:45:47'),
(183, 'Master’s Degree', 'Public Policy', '2025-02-10 02:45:47'),
(184, 'Master’s Degree', 'International Relations', '2025-02-10 02:45:47'),
(185, 'Master’s Degree', 'Environmental Policy', '2025-02-10 02:45:47'),
(186, 'Master’s Degree', 'Law and Governance', '2025-02-10 02:45:47'),
(187, 'Master’s Degree', 'Social Work', '2025-02-10 02:45:47'),
(188, 'Master’s Degree', 'Education Leadership', '2025-02-10 02:45:47'),
(189, 'Master’s Degree', 'Curriculum and Instruction', '2025-02-10 02:45:47'),
(190, 'Master’s Degree', 'Creative Writing', '2025-02-10 02:45:47'),
(191, 'Master’s Degree', 'Philosophy and Ethics', '2025-02-10 02:45:47'),
(192, 'Master’s Degree', 'Sociology', '2025-02-10 02:45:47'),
(193, 'Master’s Degree', 'Advanced Mathematics', '2025-02-10 02:45:47'),
(194, 'Master’s Degree', 'Physics', '2025-02-10 02:45:47'),
(195, 'Master’s Degree', 'Chemical Engineering', '2025-02-10 02:45:47'),
(196, 'Master’s Degree', 'Civil Engineering', '2025-02-10 02:45:47'),
(197, 'Master’s Degree', 'Electrical Engineering', '2025-02-10 02:45:47'),
(198, 'Master’s Degree', 'Mechanical Engineering', '2025-02-10 02:45:47'),
(199, 'Doctoral Degree (PhD & Professional Doctorates)', 'Theoretical Computer Science', '2025-02-10 02:45:47'),
(200, 'Doctoral Degree (PhD & Professional Doctorates)', 'Artificial Intelligence Research', '2025-02-10 02:45:47'),
(201, 'Doctoral Degree (PhD & Professional Doctorates)', 'Cybersecurity Research', '2025-02-10 02:45:47'),
(202, 'Doctoral Degree (PhD & Professional Doctorates)', 'Business Strategy', '2025-02-10 02:45:47'),
(203, 'Doctoral Degree (PhD & Professional Doctorates)', 'Organizational Leadership', '2025-02-10 02:45:47'),
(204, 'Doctoral Degree (PhD & Professional Doctorates)', 'Corporate Governance', '2025-02-10 02:45:47'),
(205, 'Doctoral Degree (PhD & Professional Doctorates)', 'Financial Risk Management', '2025-02-10 02:45:47'),
(206, 'Doctoral Degree (PhD & Professional Doctorates)', 'International Law Theory', '2025-02-10 02:45:47'),
(207, 'Doctoral Degree (PhD & Professional Doctorates)', 'Public Administration Research', '2025-02-10 02:45:47'),
(208, 'Doctoral Degree (PhD & Professional Doctorates)', 'Economic Policy Analysis', '2025-02-10 02:45:47'),
(209, 'Doctoral Degree (PhD & Professional Doctorates)', 'Medical Research', '2025-02-10 02:45:47'),
(210, 'Doctoral Degree (PhD & Professional Doctorates)', 'Neuroscience', '2025-02-10 02:45:47'),
(211, 'Doctoral Degree (PhD & Professional Doctorates)', 'Pharmaceutical Sciences', '2025-02-10 02:45:47'),
(212, 'Doctoral Degree (PhD & Professional Doctorates)', 'Educational Theory', '2025-02-10 02:45:47'),
(213, 'Doctoral Degree (PhD & Professional Doctorates)', 'Environmental Science', '2025-02-10 02:45:47'),
(214, 'Doctoral Degree (PhD & Professional Doctorates)', 'Linguistics and Language Studies', '2025-02-10 02:45:47'),
(215, 'Doctoral Degree (PhD & Professional Doctorates)', 'Religious Studies', '2025-02-10 02:45:47'),
(216, 'Doctoral Degree (PhD & Professional Doctorates)', 'Mathematical Modeling', '2025-02-10 02:45:47'),
(217, 'Doctoral Degree (PhD & Professional Doctorates)', 'Quantum Physics', '2025-02-10 02:45:47'),
(218, 'Doctoral Degree (PhD & Professional Doctorates)', 'Artificial Neural Networks', '2025-02-10 02:45:47'),
(219, '', '', '2025-02-10 04:31:47'),
(220, '', '', '2025-02-10 09:34:21'),
(221, '', '', '2025-02-10 09:34:22'),
(222, '', '', '2025-02-10 09:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `supportreview`
--

CREATE TABLE `supportreview` (
  `progress_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(500) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `answer_files` text DEFAULT NULL,
  `answer_comments` text DEFAULT NULL,
  `explanation_files` text DEFAULT NULL,
  `explanation_comments` text DEFAULT NULL,
  `issues_identified` text DEFAULT NULL,
  `additional_details` text DEFAULT NULL,
  `preferred_resolution` text DEFAULT NULL,
  `supporting_files` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supportreview`
--

INSERT INTO `supportreview` (`progress_id`, `order_id`, `client_id`, `tutor_id`, `subject`, `name`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`, `answer_files`, `answer_comments`, `explanation_files`, `explanation_comments`, `issues_identified`, `additional_details`, `preferred_resolution`, `supporting_files`) VALUES
(28, 119, 50, 51, 'srjyht', 'dktmujy', 's,dtumkfjh', 'd,utmjh', '2025-03-08 00:18:00', '', '', '', '', 250.00, 5, 'donework', '2025-02-23 21:19:00', '2025-02-23 21:19:00', '[\"doneorders\\/Let9.docx\"]', '', '[\"doneorders\\/Preschool Expression of Feelings ECED 1640 Activity Card (3).docx\"]', '', 'Work contains significant errors', 'c', 'Revision by the same tutor', 'form_67bd3f80a26be_Activity Card- SAMPLE - Copy (1).docx, form_67bd3f80a26be_CH 3 - Authoritarian Style Worksheet (3).docx'),
(87, 129, 50, 51, 'd', 'd', 'd', 'd', '2025-02-28 08:58:00', 'Screenshot 2025-02-18 192944.png', 'uploads/Essential Questions Chapter 3.docx,uploads/Screenshot 2025-02-18 192944.png', '', '', 150.00, 3, 'donework', '2025-03-01 23:04:29', '2025-03-01 23:04:29', '[\"doneorders\\/Rubric Assessment - Sp25 ECED 1300-80 Guiding Children\'s Behavior - Minneapolis Community and Technical College12345678910111213.pdf\"]', '', '[\"doneorders\\/Rubric Assessment - Sp25 ECED 1300-80 Guiding Children\'s Behavior - Minneapolis Community and Technical College1234567891011121314.pdf\"]', '', 'Low-quality or irrelevant content', 'nnnnn', 'Assign a different tutor', 'form_67c5de1469388_Ch 3 - Authoritative Style Worksheet (1) (1) (25).docx, form_67c5de1469388_Ch 3 - Authoritative Style Worksheet (1) (1) (10).docx'),
(90, 131, 50, 51, 'ccc', 'ccc', 'ccc', 'cccc Additional Details: nnnnnn', '2025-03-27 02:43:00', '\'s Courts and the Criminal Justice System -- Neubauer, David W_, author; Fradella, Henry F_, author -- Twelfth edition, Student edition, -- 9781305261051 -', 'uploads/Ch 3 - Authoritative Style Worksheet (1) (1).docx,uploads/observation-checklist5.pdf,America\\\'s Courts and the Criminal Justice System -- Neubauer, David W_, author; Fradella, Henry F_, author -- Twelfth edition, Student edition, -- 9781305261051 ', '', '', 250.00, 5, 'donework', '2025-03-01 23:58:03', '2025-03-01 23:58:03', '[\"doneorders\\/Discussion 2123.docx\"]', '', '[\"doneorders\\/Essential Questions Chapter 21234567.docx\"]', '', 'Poor explanation or lack of clarity', 'mmmmmmmm', 'Revision by the same tutor', 'form_67c5de3450d27_clear_acb_3e_ch10 - Tagged.pdf'),
(107, 125, 50, 89, 'hr', 'herd', 'jr6', 'jdt Additional Details: ggggggggg', '2025-03-07 10:13:00', '', '', '', '', 250.00, 5, 'donework', '2025-03-03 22:29:33', '2025-03-03 22:29:33', '[\"doneorders\\/To solve this problem using an integer linear programming model123.docx\",\"doneorders\\/Part 1212.docx\",\"doneorders\\/objective_31234.pdf\"]', '', '[\"doneorders\\/objective_21234.pdf\",\"doneorders\\/Summative Assessment on Marketing.pptx\",\"doneorders\\/objective_212345.pdf\"]', '', 'Deadline was missed', 'None', 'Revision by the same tutor', 'None'),
(110, 149, 50, 89, 'xxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxx', '2025-03-06 16:31:00', '', '', '', '', 150.00, 3, 'donework', '2025-03-03 22:34:23', '2025-03-03 22:34:23', '[\"doneorders\\/objective_3123456.pdf\"]', '', '[\"doneorders\\/2023 KCSE#.pdf\"]', '', 'Low-quality or irrelevant content', 'None', 'Revision by the same tutor', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `tutoraccount`
--

CREATE TABLE `tutoraccount` (
  `Tutor_id` int(11) NOT NULL,
  `tutorrating` decimal(3,2) DEFAULT NULL,
  `tutorpendingmoney` decimal(10,2) DEFAULT NULL,
  `tutoravailablemoney` decimal(10,2) DEFAULT NULL,
  `tutorrevision` int(11) DEFAULT NULL,
  `tutorrequest` text DEFAULT NULL,
  `tutorclarification` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutoraccount`
--

INSERT INTO `tutoraccount` (`Tutor_id`, `tutorrating`, `tutorpendingmoney`, `tutoravailablemoney`, `tutorrevision`, `tutorrequest`, `tutorclarification`) VALUES
(26, 9.99, 0.00, 0.00, 0, '0', '0'),
(27, 9.99, 0.00, 0.00, 0, '0', '0'),
(28, 9.99, 0.00, 0.00, 0, '0', '0'),
(29, 9.99, 0.00, 0.00, 0, '0', '0'),
(30, 9.99, 0.00, 0.00, 0, '0', '0'),
(31, 9.99, 0.00, 0.00, 0, '0', '0'),
(32, 9.99, 0.00, 0.00, 0, '0', '0'),
(33, 9.99, 0.00, 0.00, 0, '0', '0'),
(34, 9.99, 0.00, 0.00, 0, '0', '0'),
(35, 9.99, 0.00, 0.00, 0, '0', '0'),
(36, 9.99, 0.00, 0.00, 0, '0', '0'),
(37, 9.99, 0.00, 0.00, 0, '0', '0'),
(38, 9.99, 0.00, 0.00, 0, '0', '0'),
(39, 9.99, 0.00, 0.00, 0, '0', '0'),
(40, 9.99, 0.00, 0.00, 0, '0', '0'),
(41, 9.99, 0.00, 0.00, 0, '0', '0'),
(42, 9.99, 0.00, 0.00, 0, '0', '0'),
(43, 9.99, 0.00, 0.00, 0, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tutorid`
--

CREATE TABLE `tutorid` (
  `tutor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorid`
--

INSERT INTO `tutorid` (`tutor_id`, `user_id`) VALUES
(26, 65),
(27, 75),
(28, 76),
(29, 77),
(30, 78),
(31, 79),
(32, 80),
(33, 81),
(34, 82),
(35, 83),
(36, 84),
(37, 86),
(38, 87),
(39, 88),
(40, 89),
(41, 95),
(42, 97),
(43, 98);

-- --------------------------------------------------------

--
-- Table structure for table `tutoring`
--

CREATE TABLE `tutoring` (
  `tutor_id` int(11) NOT NULL,
  `subjects` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutoring`
--

INSERT INTO `tutoring` (`tutor_id`, `subjects`) VALUES
(19, 'English'),
(20, 'Biology'),
(21, '8'),
(22, 'Neuroscience'),
(23, 'Biology'),
(24, 'Biology'),
(24, 'Physics'),
(24, 'World History'),
(25, 'Arithmetic'),
(25, 'English'),
(25, 'Environmental Studies');

-- --------------------------------------------------------

--
-- Table structure for table `tutorrequest`
--

CREATE TABLE `tutorrequest` (
  `tutorrequest_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `document_names` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorrequest`
--

INSERT INTO `tutorrequest` (`tutorrequest_id`, `tutor_id`, `subject`, `message`, `document_names`, `created_at`, `client_id`, `deadline`) VALUES
(1, 51, 'maths', 'irndflk', 'Essential Questions Chapter 357.docx,KeepingKidsSafe_tcm1053-317025 (1)48.pdf', '2025-02-24 00:53:19', NULL, NULL),
(2, 51, 'maths', 'good', '', '2025-02-24 00:54:25', NULL, NULL),
(3, 51, 'maths', 'good work', 'Activity Card- SAMPLE - Copy (1)57.docx,10.4324_9780429030260_previewpdf20.pdf', '2025-02-24 01:01:05', NULL, NULL),
(4, 51, 'maths', 'do my work', 'Activity Card- SAMPLE - Copy (1)12.docx', '2025-02-24 01:35:31', NULL, NULL),
(5, 51, 'maths', 'ff', 'Let9 (1)78.docx', '2025-02-24 01:44:06', 50, NULL),
(6, 51, 'maths', 'bb', 'Essential Questions Chapter 376.docx', '2025-02-24 02:10:07', 50, '2025-03-06 04:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `TutorID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ExpertiseArea` varchar(100) DEFAULT NULL,
  `Availability` varchar(255) DEFAULT NULL,
  `Rating` decimal(2,1) DEFAULT 0.0,
  `SubjectName` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` enum('undone','progress','revision','request','clarification','unpaid','paid','completed') NOT NULL DEFAULT 'undone',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`TutorID`, `UserID`, `ExpertiseArea`, `Availability`, `Rating`, `SubjectName`, `client_id`, `order_id`, `subject`, `name`, `tutor_id`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`) VALUES
(8, 45, 'University', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(9, 46, 'University', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(10, 47, 'Kindergarten', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(11, 48, 'Secondary', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(12, 51, 'Nursery', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(13, 52, 'University', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(14, 53, 'PhD', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(15, 54, 'PhD', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(16, 55, 'PhD', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(17, 56, 'PhD', '7', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(18, 57, 'PhD', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(19, 58, 'Primary', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(20, 59, 'Secondary', '14', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(21, 60, 'Secondary', '14', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(22, 61, 'Masters', '7', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(23, 62, 'Secondary', '5', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(24, 63, 'Secondary', '14', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(25, 64, 'Primary', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(26, 65, 'Masters', '9', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:22', '2025-01-20 07:54:22'),
(27, 75, 'Master?s Degree', '9', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:13:43', '2025-02-10 04:13:43'),
(28, 76, 'Junior High', '9', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:17:59', '2025-02-10 04:17:59'),
(30, 78, 'Primary', '9', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:26:31', '2025-02-10 04:26:31'),
(31, 79, 'High School', '9', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:28:22', '2025-02-10 04:28:22'),
(32, 80, 'Nursery', '7', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:31:47', '2025-02-10 04:31:47'),
(38, 87, 'Junior High', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:17', '2025-02-10 07:22:17'),
(40, 89, 'Middle School', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:57', '2025-02-21 02:41:57'),
(41, 95, 'Undergraduate Degree', '24', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-04 03:33:54', '2025-03-04 03:33:54'),
(42, 97, 'Elementary School', '12', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 03:56:34', '2025-03-06 03:56:34'),
(43, 98, 'High School', '15', 0.0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:05', '2025-03-06 04:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_subjects`
--

CREATE TABLE `tutor_subjects` (
  `TutorSubjectID` int(11) NOT NULL,
  `TutorID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Level` varchar(50) NOT NULL,
  `SubjectName` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_upload_link` varchar(255) DEFAULT NULL,
  `completed_work_name` varchar(255) DEFAULT NULL,
  `completed_work_link` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `status` enum('undone','progress','revision','request','clarification','unpaid','paid','completed') NOT NULL DEFAULT 'undone',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_subjects`
--

INSERT INTO `tutor_subjects` (`TutorSubjectID`, `TutorID`, `SubjectID`, `Level`, `SubjectName`, `client_id`, `order_id`, `subject`, `name`, `tutor_id`, `description`, `instructions`, `deadline`, `document_name`, `document_upload_link`, `completed_work_name`, `completed_work_link`, `price`, `number_of_pages`, `status`, `created_at`, `updated_at`) VALUES
(14, 11, 8, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(15, 11, 9, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(16, 11, 10, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(17, 12, 3, 'Nursery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(18, 13, 13, 'University', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(19, 14, 19, 'PhD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(20, 15, 19, 'PhD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(21, 16, 19, 'PhD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(22, 17, 19, 'PhD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(23, 18, 19, 'PhD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(24, 19, 6, 'Primary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(25, 20, 8, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(26, 20, 9, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(27, 20, 10, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(28, 21, 8, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(29, 21, 9, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(30, 22, 14, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(31, 22, 15, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(32, 22, 16, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(33, 23, 8, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(34, 23, 9, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(35, 23, 10, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(36, 24, 8, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(37, 24, 9, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(38, 24, 10, 'Secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(39, 25, 5, 'Primary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(40, 25, 6, 'Primary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(41, 25, 7, 'Primary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(42, 26, 14, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(43, 26, 15, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(44, 26, 16, 'Masters', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-01-20 07:54:23', '2025-01-20 07:54:23'),
(45, 32, 219, 'Nursery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 04:31:48', '2025-02-10 04:31:48'),
(56, 38, 70, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:18', '2025-02-10 07:22:18'),
(57, 38, 71, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:18', '2025-02-10 07:22:18'),
(58, 38, 74, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:18', '2025-02-10 07:22:18'),
(59, 38, 76, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:18', '2025-02-10 07:22:18'),
(60, 38, 77, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:18', '2025-02-10 07:22:18'),
(61, 38, 78, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:19', '2025-02-10 07:22:19'),
(62, 38, 55, 'Junior High', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-10 07:22:19', '2025-02-10 07:22:19'),
(84, 40, 70, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:57', '2025-02-21 02:41:57'),
(85, 40, 72, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(86, 40, 73, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(87, 40, 75, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(88, 40, 76, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(89, 40, 77, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(90, 40, 78, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(91, 40, 55, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(92, 40, 59, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(93, 40, 87, 'Middle School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-02-21 02:41:58', '2025-02-21 02:41:58'),
(94, 41, 102, 'Undergraduate Degree', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-04 03:33:54', '2025-03-04 03:33:54'),
(95, 41, 154, 'Undergraduate Degree', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-04 03:33:54', '2025-03-04 03:33:54'),
(96, 41, 92, 'Undergraduate Degree', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-04 03:33:54', '2025-03-04 03:33:54'),
(97, 42, 50, 'Elementary School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 03:56:34', '2025-03-06 03:56:34'),
(98, 42, 51, 'Elementary School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 03:56:34', '2025-03-06 03:56:34'),
(99, 42, 36, 'Elementary School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 03:56:35', '2025-03-06 03:56:35'),
(100, 42, 54, 'Elementary School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 03:56:35', '2025-03-06 03:56:35'),
(101, 43, 94, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:05', '2025-03-06 04:49:05'),
(102, 43, 73, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:05', '2025-03-06 04:49:05'),
(103, 43, 49, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:06', '2025-03-06 04:49:06'),
(104, 43, 97, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:06', '2025-03-06 04:49:06'),
(105, 43, 98, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:06', '2025-03-06 04:49:06'),
(106, 43, 77, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:06', '2025-03-06 04:49:06'),
(107, 43, 100, 'High School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'undone', '2025-03-06 04:49:06', '2025-03-06 04:49:06');

-- --------------------------------------------------------

--
-- Table structure for table `userpreferences`
--

CREATE TABLE `userpreferences` (
  `PreferenceID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PreferenceKey` varchar(100) NOT NULL,
  `PreferenceValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) DEFAULT NULL,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('insession','out of session') NOT NULL DEFAULT 'out of session'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `RoleID`, `UserName`, `Email`, `PasswordHash`, `CreatedAt`, `UpdatedAt`, `status`) VALUES
(20, 1, 'jmsak', 'jms32@gmail.com', '$2y$10$T9aUGaPhzvPaaiRGGw8Wt.YHAcYcgpZjkSNNSJIbxMEGIVaroJsIO', '2024-09-14 05:14:18', '2024-10-26 08:18:41', 'out of session'),
(24, 1, 'jmsak1', 'jmsak1@gmail.com', '$2y$10$GFjkQgtzcCGp5.0CsO4CEu2E7slX1XvMwxjiLaJAoVeP3K.Q.BRAe', '2024-10-14 15:43:20', '2024-10-14 15:43:20', 'out of session'),
(26, 2, '123@gmail.com', '123@gmail.com', '$2y$10$.XhM2wdot1ve9YlBuVWnmep636H59AbWZ7LHgsZUhjgx5TyfnIQNa', '2024-10-26 09:49:52', '2024-10-26 09:49:52', 'out of session'),
(27, 3, '12@gmail.com', '12@gmail.com', '$2y$10$jrxZPLV67kBtOAQJ8LJwcOtlxwHzVGo3bIFnPm9lQ5mIvEPgH.kdm', '2024-10-26 10:13:50', '2024-10-26 10:13:50', 'out of session'),
(34, 1, '12345@gmail.com', '12345@gmail.com', '$2y$10$C.oMD6AkLRSzZxpt0oPo7eRoiYdsU48OD5jKsPgX/Y0ZY3i1er81e', '2024-10-26 15:07:02', '2024-10-26 15:07:02', 'out of session'),
(35, 1, 'jjjk', 'jjk@gmail.com', '$2y$10$iVRcnWyx3yVRTXPs9W4HD.xjGafc/FuYwUvQ5MDRaYgWE9ZqxvYnC', '2024-10-29 20:43:16', '2024-10-29 20:43:16', 'out of session'),
(36, 2, 'jmsa', 'jmsa@gmail.com', '$2y$10$tRtxrsSColTRQV9oPR7MRe9WqZedxN.pfh3SU9qmsUzf/Jw250dCS', '2024-10-29 20:50:22', '2024-10-29 20:50:22', 'out of session'),
(37, 3, 'jmsaki', 'jmsaki@gmail.com', '$2y$10$Ihh9U0G289Hv2ehqPCEoCu8YhrzWwvzTbYBIYq0ccCO199QL80qFe', '2024-10-29 20:51:42', '2024-10-29 20:51:42', 'out of session'),
(38, 1, 'julius', 'mj123@gmail.com', '$2y$10$IlQBT/ZmIGKdk9qhum/je.E1uWxcxMN9qDYWGdvOQWIIMqujWIpkm', '2024-10-29 21:55:21', '2024-10-29 21:55:21', 'out of session'),
(39, 2, 'samuel', 'jm123@gmail.com', '$2y$10$/xzuh8KkZIY537XxJU6QS.qSuIpwF4WWygaZLUAPCKo9NTo5bBNiG', '2024-10-29 22:03:56', '2024-10-29 22:03:56', 'out of session'),
(40, 3, 'musyoki', 'musyoki123@gmail.com', '$2y$10$DrBJbPdKo8uGbxtmKXlMNOsQjYpI/8.4BRvwBk3ym3VIkbECF.GI.', '2024-10-29 22:06:27', '2024-10-29 22:12:13', 'out of session'),
(45, 2, 'sasa123', 'sasa123@gmail.com', '$2y$10$E7QaCW21HU09/uYhLLvwi.LmX8uqWBuPzwZfWaksblOvoFe2.rk4O', '2024-11-01 15:29:13', '2024-11-01 15:29:13', 'out of session'),
(46, 2, 'sasa1234', 'sasa1234@gmail.com', '$2y$10$h69f6GVjU21a8rDZkTdAJeWSvUtPTtu4JyNEUvhSc2kdhHGLV6wdm', '2024-11-01 15:29:53', '2024-11-01 15:29:53', 'out of session'),
(47, 2, 'sasa12345', 'sasa12345@gmail.com', '$2y$10$1iLEgSyIWkddqLPTKm5hxOFSUeMTtELokmgizDDiitIyyD3606k7G', '2024-11-01 15:42:49', '2024-11-01 15:42:49', 'out of session'),
(48, 2, 'sasa123456', 'sasa123456@gmail.com', '$2y$10$kOW1.xgTU5x5UMJ9c9oOwu5uW8WQzSWRyCeW.fAaIsp8iN3zsmi9W', '2024-11-01 16:08:43', '2024-11-01 16:08:43', 'out of session'),
(49, 1, 'ab', 'ab@gmail.com', '$2y$10$Y0nh.7FRFE0cEyzWzXk7su0wL0dluDJGTgRYKcG6azXg7VYTzkM7O', '2024-12-11 10:26:21', '2024-12-11 10:26:21', 'out of session'),
(50, 1, 'client', 'client@gmail.com', '$2y$10$aZMABDE3jPdd.TER2MOBXe.i3BdV29B0i9h63yDcXeDAl92IlcnAy', '2024-12-11 10:29:00', '2025-03-16 06:20:38', 'insession'),
(51, 2, 'tutor', 'tutor@gmail.com', '$2y$10$ECNyuEUNp/xHCpmmNGE38unAC0EHgp3oBEHzIQnmWxTuC5N7hZhL6', '2024-12-11 10:30:45', '2025-03-16 09:37:26', 'insession'),
(52, 2, 'fvb', 'fvb@gmail.com', '$2y$10$as3D.VR3/37zYCfJYTAUN.PqjQne9bsKN8OpWWs42XfhrR3wlbtQK', '2024-12-11 10:36:51', '2024-12-11 10:36:51', 'out of session'),
(53, 2, 'fvbc', 'fvbc@gmail.com', '$2y$10$TkkfUeeB2/Yn3L91vceZd.XgTp3BAauEqG68AkjIMwCPH6oRwg/fu', '2024-12-11 10:43:22', '2024-12-11 10:43:22', 'out of session'),
(54, 2, 'fvbcv', 'fvbcv@gmail.com', '$2y$10$N3eXMjCyCe56/UQyXzMVmevKr25gL9Wsonjo2D.dfz1Gc8WvpzEEC', '2024-12-11 10:45:26', '2024-12-11 10:45:26', 'out of session'),
(55, 2, 'fvbcvv', 'fvbcvv@gmail.com', '$2y$10$sMhjTB7vsNbPq5XYkNuliubHbFWlRgIHSldoO/4DH0R6Ig.51prvS', '2024-12-11 10:47:39', '2024-12-11 10:47:39', 'out of session'),
(56, 1, 'nn', 'nn@gmail.com', '$2y$10$7zaD4D09EMH0osMnxOawoOrciMWO7zggO2YdjN1DQLVikAx3M5RVa', '2024-12-11 10:48:58', '2025-03-07 19:24:25', 'out of session'),
(57, 2, 'fvbcvvn', 'fvbcvvn@gmail.com', '$2y$10$ipq1f9jJHyHUBEAPp2b1veVh4emMvJ4DjklhK7iEwVC5blXA9mgFS', '2024-12-11 10:50:13', '2024-12-11 10:50:13', 'out of session'),
(58, 2, 'tutor1', 'tutor1@gmail.com', '$2y$10$mAHUerBSJXsCouMedj6vqOOW.o/Ey8lx7VQd65p8ixe5EBQngtLxq', '2024-12-11 14:41:27', '2024-12-11 14:41:27', 'out of session'),
(59, 2, 'tutor2@gmail.com', 'tutor2@gmail.com', '$2y$10$yyOCohKjGmfNB81j5nH8iuO9/7wT2/4KmlvDd2BqUo1CXrb0BK4y6', '2024-12-11 14:43:05', '2024-12-11 14:43:05', 'out of session'),
(60, 2, 'tutor3@gmail.com', 'tutor3@gmail.com', '$2y$10$FQzHrTgJ15zFlCuW7WG4/uXgeQjddx/KwXhauQnlu6ZSqM46upwi.', '2024-12-11 14:50:10', '2024-12-11 14:50:10', 'out of session'),
(61, 2, '11', '11@gmail.com', '$2y$10$dFxjSzICifQB912CvhuIJ.XO7p3e4mT0BEu5vQFmn7BrkNC2KXbie', '2024-12-11 15:05:42', '2024-12-11 15:05:42', 'out of session'),
(62, 2, '111@gmail.com', '111@gmail.com', '$2y$10$Xqzihk.ZFy1QJ74YW87Gf.9unEgpBQRISgCPsdzSHFTa6B9YOBBGi', '2024-12-11 15:08:34', '2024-12-11 15:08:34', 'out of session'),
(63, 2, 'tutor4@gmail.com', 'tutor4@gmail.com', '$2y$10$Ba3rLKigzy7Chd9hJMXLUujtKSD0Q28GBRF0F/oNqu.JzgbaFKOr.', '2024-12-11 15:15:02', '2024-12-11 15:15:02', 'out of session'),
(64, 2, 'tutor5@gmail.com', 'tutor5@gmail.com', '$2y$10$iEqVgItLHV2GBBM7wO1czeJxG7kGZDXjQHX3xSJSfCdzDeAF70fH2', '2024-12-11 15:15:48', '2025-05-11 11:53:09', 'out of session'),
(65, 2, 'tutor6@gmail.com', 'tutor6@gmail.com', '$2y$10$usUAmTPgMVifh3PyCfF4V.cKr4GIfWDrJSMntpY9kc3L6ciQIl2Je', '2024-12-11 22:18:47', '2024-12-11 22:18:47', 'out of session'),
(66, 3, 'admn', 'admn@gmail.com', '$2y$10$oq7Z6HVy0tKj.tq.csvjpuFhIrmEYhgJNjqak1/iq1Oxp9xPp5S.y', '2024-12-22 11:45:07', '2024-12-22 11:45:07', 'out of session'),
(67, 1, 'julilii', 'julilii@gmail.com', '$2y$10$CVn1zIYgbP8juy7Y4W264ea1K99HYLGnyN2ViLqA01xqc7AmDEfaO', '2025-01-20 20:27:40', '2025-01-20 20:27:40', 'out of session'),
(68, 1, 'jose', 'julilii13@gmail.com', '$2y$10$0kOJ9BlL1d9zuedNbz60VuhjZf.C0k/4zUYAK0ooYBQKVFQR9BxsO', '2025-01-20 20:29:59', '2025-01-20 20:29:59', 'out of session'),
(69, 1, 'jose123', 'julilii1333@gmail.com', '$2y$10$MX/cfMCOspBA/J0pZrcP.eesvlsuarVtKaPXt5pyIySv1qTBwsHXm', '2025-01-20 20:41:42', '2025-01-20 20:41:42', 'out of session'),
(70, 1, 'jose123hhh', 'julilii133nn3@gmail.com', '$2y$10$pkdTw0uHYllqQGAQh9iGMuZhoFEAqMFFVcTJOFunvaiHBn9Qf40xy', '2025-01-20 20:43:52', '2025-01-20 20:43:52', 'out of session'),
(71, 1, 'julilii133ncccn3@gmail.com', 'julilii133ncccn3@gmail.com', '$2y$10$WlKTWlyXUlWHZkT1p7RC7.NcRdqV0U04lLSz3mupeqARj37JYWsVK', '2025-01-20 20:44:38', '2025-01-20 20:44:38', 'out of session'),
(72, 1, 'jose123vvhhh', 'julilii133nvvvvvn3@gmail.com', '$2y$10$SG0y/HWRv/pI/VRNztAHVe9euCoBq6G8D0kmN.8eH96liGZA81Omy', '2025-01-20 20:46:37', '2025-01-20 20:46:37', 'out of session'),
(73, 1, 'jose123wer', 'julilii133nfffvvvvvn3@gmail.com', '$2y$10$Tyxh5XG6FFj1Hq7rldtuGu71iJ6UtAewjquY/0XigGxAjpV0sA882', '2025-01-20 20:47:13', '2025-01-20 20:47:13', 'out of session'),
(74, 3, 'julius', 'admin@gmail.com', '$2y$10$zpSftJhMYBsf0S7u1s7OW.vz8emTRZ3qbYrEiSD9hFisDeCXHIS2u', '2025-02-09 20:20:53', '2025-02-09 20:20:53', 'out of session'),
(75, 2, 'juliuskkm', 'tutor567@gmail.com', '$2y$10$6CRYwKHY36JD7sWCNYGuFOyBKQ27k1vkRAHU508WWjIGoBP3KSGcq', '2025-02-10 04:13:43', '2025-02-10 04:13:43', 'out of session'),
(76, 2, 'juliusmmkkm', 'tutor5jj67@gmail.com', '$2y$10$zQ2Iu2Ao56Mnp5O2D4Ls4uU5E0C9M.Ik7QmBHb1DwsKFph6AJjtrW', '2025-02-10 04:17:59', '2025-02-10 04:17:59', 'out of session'),
(78, 2, 'tutor5nnn@gmail.com', 'tutor5nnn@gmail.com', '$2y$10$Z6GBnaT4/amY0Tlc0zwQUe/pQJ2pfJkrCQBYEaSiXJVhudSVB/g9m', '2025-02-10 04:26:31', '2025-02-10 04:26:31', 'out of session'),
(79, 2, 'tutor5nnnn@gmail.com', 'tutor5nnnn@gmail.com', '$2y$10$FIWQBsTXsBOQXTNLCJ1kJeW6VI3EHRZOn36E5oF1TXMhJJa8kktAG', '2025-02-10 04:28:22', '2025-02-10 04:28:22', 'out of session'),
(80, 2, 'tutor5nmnnnn@gmail.com', 'tutor5nmnnnn@gmail.com', '$2y$10$Sk1bmY/codOq1Av1F/bnWeuOb6SLyqtOwnRQBnNTDzADvUNyRPc56', '2025-02-10 04:31:46', '2025-02-10 04:31:46', 'out of session'),
(87, 1, 'juliusmsa', 'tutor0@gmail.com', '$2y$10$vFSkZKEYZLo9yiZCWJIVN.kI9W6lyMlI05jhM5coALjivu.1g7IDa', '2025-02-10 07:22:17', '2025-03-07 19:31:30', 'out of session'),
(89, 2, 'tutor00@gmail.com', 'tutor00@gmail.com', '$2y$10$dw0EnjEEKp41utKrT0EKW.kbbzzRuqHlwgK/8ooRkALFbSFRoRVqq', '2025-02-21 02:41:57', '2025-02-21 02:41:57', 'out of session'),
(90, 1, 'fredinah', 'client00@gmail.com', '$2y$10$a0Y4GL.gEppnIdmlRz6KzutlRNhDnJmIesU3gKMbieTR6H/pTm1BK', '2025-02-22 04:09:55', '2025-02-22 04:09:55', 'out of session'),
(91, 1, 'julius33', 'julius33@gmail.com', '$2y$10$acehgZYExgwqAtSt7CzNKerCzvfDMGlBv0GrIQDD1kZTRK.HGR6YS', '2025-03-04 03:05:34', '2025-03-04 03:05:34', 'out of session'),
(92, 1, 'julius333', 'julius333@gmail.com', '$2y$10$i5DGGp01bfRlH/ulUZuaSelhJdSP9edd1..0b9RQzhVSscuMFs.rm', '2025-03-04 03:11:22', '2025-03-04 03:11:22', 'out of session'),
(93, 2, 'julius3334', 'julius3334@gmail.com', '$2y$10$zWFpE5O.OYg0gLg55czcZe8ob13RioZ0AhJ3dat2zO.ufdz368jX2', '2025-03-04 03:17:54', '2025-03-07 19:21:01', 'out of session'),
(94, 2, 'julius111', 'julius111@gmail.com', '$2y$10$vZjK165l8uxG4KVrtuYbRO875gDqzTsaCQDumFJYt33VyGaPhtC/q', '2025-03-04 03:28:14', '2025-03-08 01:46:02', 'out of session'),
(95, 2, 'tutor001', 'tutor001@gmail.com', '$2y$10$wSLfliGwfJxkrgPaoJ74vepXo9m91CIWkuddIYcBzBk7O34.Yac7m', '2025-03-04 03:33:53', '2025-03-04 03:33:53', 'out of session'),
(96, 1, 'juli001', 'juli001@gmail.com', '$2y$10$kwMHs/pPj8tyBaDeBIeF.uNI0Leb2XD7HfZ12V00BdTYHwDNTpGHa', '2025-03-06 03:28:54', '2025-03-06 03:28:54', 'out of session'),
(97, 3, 'juli002', 'juli002@gmail.com', '$2y$10$bpvVqFQ4/3guaF/FD5TlXeWCzX7yaS8ffcG783GFitHlGhZOnbJE.', '2025-03-06 03:56:34', '2025-05-11 12:26:26', 'out of session'),
(98, 2, 'juli003', 'juli003@gmail.com', '$2y$10$xgX67SD4jKIlR2nzf5175uuWgLeWzm7VPUiiC4feWOH/nmAf5HDEW', '2025-03-06 04:49:03', '2025-03-06 04:49:03', 'out of session'),
(99, 1, 'klm', 'klm@gmail.com', '$2y$10$MhTQYkpZQCfHfhywQ/xXmevo8lf5HI09zuCs4Iq2J.eGTKIGalLoS', '2025-03-16 03:48:55', '2025-03-16 09:43:36', 'insession'),
(100, 1, 'tutor5t', 'tutor5t@gmail.com', '$2y$10$182MT2BK5OhMIpIeHv9o9.cqW1ayhZgJT87sgfm/E9xjTfP3nlnHC', '2025-03-16 04:51:08', '2025-03-16 04:51:08', 'out of session');

-- --------------------------------------------------------

--
-- Table structure for table `usersession`
--

CREATE TABLE `usersession` (
  `UserID` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usersession`
--

INSERT INTO `usersession` (`UserID`) VALUES
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
(NULL),
('50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminrule`
--
ALTER TABLE `adminrule`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `auditlogs`
--
ALTER TABLE `auditlogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`BlogID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Indexes for table `clarification`
--
ALTER TABLE `clarification`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`ReplyID`),
  ADD KEY `UserID_replied` (`UserID_replied`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`);

--
-- Indexes for table `guestreply`
--
ALTER TABLE `guestreply`
  ADD PRIMARY KEY (`ReplyID`);

--
-- Indexes for table `gustcomment`
--
ALTER TABLE `gustcomment`
  ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `document_upload_link` (`document_upload_link`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`ReferralID`),
  ADD UNIQUE KEY `ReferralCode` (`ReferralCode`),
  ADD KEY `ReferrerUserID` (`ReferrerUserID`),
  ADD KEY `ReferredUserID` (`ReferredUserID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `document_upload_link` (`document_upload_link`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`ResponseID`),
  ADD KEY `QuestionID` (`QuestionID`);

--
-- Indexes for table `restrict`
--
ALTER TABLE `restrict`
  ADD PRIMARY KEY (`RestrictID`),
  ADD KEY `fk_restrict_user` (`UserID`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`RewardID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`SampleID`);

--
-- Indexes for table `skipping`
--
ALTER TABLE `skipping`
  ADD PRIMARY KEY (`skip_id`);

--
-- Indexes for table `subjectid`
--
ALTER TABLE `subjectid`
  ADD PRIMARY KEY (`SubjectID`),
  ADD UNIQUE KEY `SubjectName` (`SubjectName`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `supportreview`
--
ALTER TABLE `supportreview`
  ADD PRIMARY KEY (`progress_id`);

--
-- Indexes for table `tutoraccount`
--
ALTER TABLE `tutoraccount`
  ADD PRIMARY KEY (`Tutor_id`);

--
-- Indexes for table `tutorid`
--
ALTER TABLE `tutorid`
  ADD PRIMARY KEY (`tutor_id`);

--
-- Indexes for table `tutoring`
--
ALTER TABLE `tutoring`
  ADD PRIMARY KEY (`tutor_id`,`subjects`);

--
-- Indexes for table `tutorrequest`
--
ALTER TABLE `tutorrequest`
  ADD PRIMARY KEY (`tutorrequest_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`TutorID`),
  ADD KEY `tutors_ibfk_1` (`UserID`);

--
-- Indexes for table `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  ADD PRIMARY KEY (`TutorSubjectID`),
  ADD KEY `TutorID` (`TutorID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `userpreferences`
--
ALTER TABLE `userpreferences`
  ADD PRIMARY KEY (`PreferenceID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `RoleID` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auditlogs`
--
ALTER TABLE `auditlogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `BlogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `ReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guestreply`
--
ALTER TABLE `guestreply`
  MODIFY `ReplyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `gustcomment`
--
ALTER TABLE `gustcomment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `ReferralID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `ResponseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restrict`
--
ALTER TABLE `restrict`
  MODIFY `RestrictID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `RewardID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `samples`
--
ALTER TABLE `samples`
  MODIFY `SampleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skipping`
--
ALTER TABLE `skipping`
  MODIFY `skip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `subjectid`
--
ALTER TABLE `subjectid`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `tutoraccount`
--
ALTER TABLE `tutoraccount`
  MODIFY `Tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tutorid`
--
ALTER TABLE `tutorid`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tutorrequest`
--
ALTER TABLE `tutorrequest`
  MODIFY `tutorrequest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `TutorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  MODIFY `TutorSubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `userpreferences`
--
ALTER TABLE `userpreferences`
  MODIFY `PreferenceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminrule`
--
ALTER TABLE `adminrule`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `auditlogs`
--
ALTER TABLE `auditlogs`
  ADD CONSTRAINT `auditlogs_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `comment_replies_ibfk_1` FOREIGN KEY (`UserID_replied`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_ibfk_1` FOREIGN KEY (`ReferrerUserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `referrals_ibfk_2` FOREIGN KEY (`ReferredUserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`);

--
-- Constraints for table `restrict`
--
ALTER TABLE `restrict`
  ADD CONSTRAINT `fk_restrict_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
