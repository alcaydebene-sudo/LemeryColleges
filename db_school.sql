-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 03:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `student_id`, `action`, `created_at`) VALUES
(100, '2022-15467', 'New application has been submitted with valid documents.', '2025-11-28 07:56:19'),
(101, '2022-15467', 'New application has been submitted with valid documents.', '2025-11-28 08:21:20'),
(102, '2022-15467', 'Updated application documents.', '2025-11-28 08:35:04'),
(103, '2022-15467', 'New application has been submitted with valid documents.', '2025-11-28 08:38:38'),
(104, '2022-15467', 'Updated missing documents.', '2025-12-04 06:41:50'),
(105, '2022-15467', 'Updated missing documents.', '2025-12-04 06:58:49'),
(106, '2022-15467', 'Updated missing documents.', '2025-12-04 07:07:56'),
(107, '2022-15467', 'Updated missing documents.', '2025-12-04 07:16:09'),
(108, '2022-15467', 'Updated missing documents.', '2025-12-04 07:29:48'),
(109, '2022-15467', 'Updated missing documents.', '2025-12-04 07:35:53'),
(110, '2022-15467', 'Updated missing documents.', '2025-12-04 08:21:31'),
(111, '2022-15467', 'New application form submitted.', '2025-12-04 08:33:56'),
(112, '2022-15467', 'Updated missing documents.', '2025-12-04 08:34:34'),
(113, '2022-14161', 'New application form submitted.', '2025-12-04 09:11:33'),
(114, '2022-14161', 'Updated missing documents.', '2025-12-04 09:25:24'),
(115, '2022-14161', 'Updated missing documents.', '2025-12-04 09:47:38'),
(116, '2022-14161', 'Updated missing documents.', '2025-12-04 09:49:44'),
(117, '2022-14161', 'Profile picture updated', '2025-12-04 15:04:29'),
(118, '2022-14161', 'Profile picture updated', '2025-12-04 15:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$LJbRs6ytdR8AoPzyp9ctSuCwDYR1pyCx562/YAsMh9ASXSkUmqYcy', '2025-09-14 21:01:44'),
(2, 'admin1', 'admin1@gmail.com', '$2y$10$AQTzdfgebGooDcaoHpV56.TV/0TLt8IdrqwHY154qKbnVLOGTNUrG', '2025-11-28 06:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_logs`
--

INSERT INTO `admin_activity_logs` (`id`, `admin_id`, `action`, `created_at`) VALUES
(177, 2, 'Sent notification to Student Jerowski Catena (2022-15467). Status updated to \'Under Review\' (requirements not fully met).', '2025-12-05 23:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `admin_sms_logs`
--

CREATE TABLE `admin_sms_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_sms_logs`
--

INSERT INTO `admin_sms_logs` (`id`, `admin_id`, `student_id`, `message`, `created_at`) VALUES
(10, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: Birth Certificate. Please upload them as soon as possible. Thank you!', '2025-12-04 06:41:23'),
(11, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 06:57:14'),
(12, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 06:58:24'),
(13, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents.', '2025-12-04 07:01:56'),
(14, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:02:03'),
(15, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents.', '2025-12-04 07:02:42'),
(16, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Birth Certificate should also be brought physically.', '2025-12-04 07:08:13'),
(17, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:08:22'),
(18, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Birth Certificate should also be brought physically.', '2025-12-04 07:15:41'),
(19, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:16:18'),
(20, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:16:27'),
(21, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:19:23'),
(22, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F137 should also be brought physically.', '2025-12-04 07:19:24'),
(23, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Birth Certificate should also be brought physically.', '2025-12-04 07:19:26'),
(24, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:24:21'),
(25, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:28:04'),
(26, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:29:56'),
(27, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:30:02'),
(28, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: F138 HS. Please upload them as soon as possible. Thank you!', '2025-12-04 07:35:38'),
(29, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:36:04'),
(30, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:36:08'),
(31, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:36:49'),
(32, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:38:43'),
(33, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: F138 HS. Please upload them as soon as possible. Thank you!', '2025-12-04 07:39:09'),
(34, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 07:39:20'),
(35, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:39:24'),
(36, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:52:56'),
(37, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 07:54:40'),
(38, 2, '2022-15467', 'Hello Jerowski Catena! Your application is your application form is not approved and must be updated. Please address these issues as soon as possible. Thank you!', '2025-12-04 07:54:48'),
(39, 2, '2022-15467', 'Hello Jerowski Catena! Your application is your application form is not approved and must be updated. Please address these issues as soon as possible. Thank you!', '2025-12-04 07:56:23'),
(40, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 08:00:52'),
(41, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 08:02:00'),
(42, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 08:02:11'),
(43, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 08:06:48'),
(44, 2, '2022-15467', 'Hello Jerowski Catena! Your application is your application form is not approved and must be updated. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:09:57'),
(45, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:10:32'),
(46, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:19:45'),
(47, 2, '2022-15467', 'Hello Jerowski Catena! Your application documents have been reviewed. Thank you!', '2025-12-04 08:20:20'),
(48, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: Good Moral. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:21:10'),
(49, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Good Moral should also be brought physically.', '2025-12-04 08:21:43'),
(50, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:21:46'),
(51, 2, '2022-15467', 'Good day! Your submitted document and your grades have been reviewed and approved. Please proceed to submit the physical copies of the required documents to the Registrar\'s Office for final processing. Thank you!', '2025-12-04 08:24:36'),
(52, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:26:31'),
(53, 2, '2022-15467', 'Good day! Your submitted document and your grades have been reviewed and approved. Please proceed to submit the physical copies of the required documents to the Registrar\'s Office for final processing. Thank you!', '2025-12-04 08:26:58'),
(54, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: F137. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:27:12'),
(55, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: F137. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:27:38'),
(56, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F137 should also be brought physically.', '2025-12-04 08:27:49'),
(57, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:27:52'),
(58, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Birth Certificate should also be brought physically.', '2025-12-04 08:30:36'),
(59, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 08:34:06'),
(60, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Birth Certificate should also be brought physically.', '2025-12-04 08:34:11'),
(61, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. Good Moral should also be brought physically.', '2025-12-04 08:34:13'),
(62, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. SHS Diploma should also be brought physically.', '2025-12-04 08:34:13'),
(63, 2, '2022-15467', 'Hello Jerowski Catena! Your application is missing the following documents: F137. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:34:17'),
(64, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F138 HS should also be brought physically.', '2025-12-04 08:34:48'),
(65, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F137 should also be brought physically.', '2025-12-04 08:34:49'),
(66, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:34:53'),
(67, 2, '2022-15467', 'Please submit the physical copy of the uploaded documents. F137 should also be brought physically.', '2025-12-04 08:40:14'),
(68, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:44:01'),
(69, 2, '2022-15467', 'Good day! Your submitted document and your grades have been reviewed and approved. Please proceed to submit the physical copies of the required documents to the Registrar\'s Office for final processing. Thank you!', '2025-12-04 08:44:23'),
(70, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:44:55'),
(71, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 08:47:33'),
(72, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:22:54'),
(73, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is missing the following documents: F138 HS, F137, Birth Certificate, Good Moral, SHS Diploma. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:23:04'),
(74, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is missing the following documents: SHS Diploma. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:23:55'),
(75, 2, '2022-14161', 'Good day! Your submitted document and your grades have been reviewed and approved. Please proceed to submit the physical copies of the required documents to the Registrar\'s Office for final processing. Thank you!', '2025-12-04 09:36:21'),
(76, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is missing the following documents: F138 HS. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:45:54'),
(77, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:47:49'),
(78, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is missing the following documents: F138 HS. Also, grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:49:26'),
(79, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 09:49:53'),
(80, 2, '2022-14161', 'Hello Jeanlyn Cuerdo! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 12:18:56'),
(81, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-04 15:03:30'),
(82, 2, '2022-15467', 'Good day! Your submitted document and your grades have been reviewed and approved. Please proceed to submit the physical copies of the required documents to the Registrar\'s Office for final processing. Thank you!', '2025-12-04 15:12:43'),
(83, 2, '2022-15467', 'Hello Jerowski Catena! Your application is grade entry is not completed. Please address these issues as soon as possible. Thank you!', '2025-12-05 15:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology', 'A program that focuses on the use of computers and computer software to plan, install, customize, operate, manage, administer and maintain information technology infrastructure.', 'active', '2025-12-05 15:10:18', '2025-12-05 15:10:18'),
(2, 'BSCS', 'Bachelor of Science in Computer Science', 'A program that focuses on the theoretical foundations of information and computation, and of practical techniques for their implementation and application in computer systems.', 'active', '2025-12-05 15:10:18', '2025-12-05 15:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year_level` varchar(100) DEFAULT NULL,
  `course_number` varchar(50) DEFAULT NULL,
  `descriptive_title` varchar(255) DEFAULT NULL,
  `final` varchar(10) DEFAULT NULL,
  `re_ex` varchar(10) DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `semester` varchar(100) DEFAULT NULL,
  `school_year` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `full_name`, `course`, `year_level`, `course_number`, `descriptive_title`, `final`, `re_ex`, `units`, `semester`, `school_year`, `updated_at`, `created_at`) VALUES
(407, '2323', 'Julie Zummer Carable', 'BSCS', '4th Year', 'GE 106', 'The Contemporary World', 'Failed', '', 3, '', '', '2025-11-19 14:21:04', '2025-11-19 14:21:04'),
(408, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 101', 'Understanding the Self', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(409, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 102', 'Readings in Philosophy History', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(410, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 103', 'Mathematics in the Modern World', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(411, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 101', 'Introduction to Programming', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(412, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 102', 'Fundamentals of Programming', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(413, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'PE 1', 'Physical Fitness & Wellness', '1.00', '', 2, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(414, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'NSTP 1', 'Fund of Physical Fitness Program', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(415, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 104', 'Purposive Communication', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(416, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 105', 'Art Appreciation', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(417, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 106', 'The Contemporary World', '2.00', '', 3, '', '', '2025-12-04 05:06:54', '2025-11-28 08:18:07'),
(418, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 121', 'Intermediate Programming', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(419, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'PE 2', 'Fund of Rhythm and Dances', '2.00', '', 3, '', '', '2025-12-04 05:13:51', '2025-11-28 08:18:07'),
(420, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'NSTP 2', 'National Service Training Program', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(421, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 107', 'Social Science and Philosophy', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(422, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 108', 'Art and Humanities', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(423, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 124', 'Social and Professional Issues', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(424, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 109', 'Living in IT Era', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(425, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 110', 'Ethics', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(426, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 201', 'Data Structures and Algorithms', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(427, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 213', 'Database System', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(428, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 214', 'Application Dedvelopment and Emerging Technologies', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(429, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 215', 'Programming Language', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(430, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'PE 3', 'Spec in Team Sports', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(431, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 111', 'Rizal', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(432, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 112', 'Mathematics, Science & Society', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(433, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 205', 'Operating Systems', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(434, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 206', 'Database Systems', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(435, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 207', 'Software Engineering 1', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(436, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 208', 'Web Application Development', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(437, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 113', 'Filipino for Special Purposes', '2.00', '', 3, '', '', '2025-12-04 05:14:09', '2025-11-28 08:18:07'),
(438, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 114', 'Philippine History & Culture', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(439, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 301', 'Computer Networks', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(440, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 302', 'Information Security', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(441, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 303', 'Theory of Computation', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(442, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 304', 'Mobile Application Development', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(443, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'RES 1', 'Capstone Project 1', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(444, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 115', 'Filipino as a Second Language', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(445, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 116', 'Philippine Literature', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(446, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 305', 'Software Engineering 2', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(447, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 306', 'Artificial Intelligence & ML', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(448, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 307', 'Cloud Computing', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(449, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 308', 'Big Data Analytics', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(450, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'RES 2', 'Capstone Project 2', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(451, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 117', 'Creative Writing', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(452, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'GE 118', 'World Literature', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(453, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 401', 'Distributed Systems', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(454, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 402', 'Cybersecurity', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(455, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS ELEC 1', 'CS Elective 1', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(456, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS 403', 'Emerging Technologies', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(457, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'CS ELEC 2', 'CS Elective 2', '1.00', '', 3, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(458, '2022-15467', 'Jerowski Catena', 'BSCS', '4th Year', 'Practicum', 'On-the-Job Training', '1.00', '', 6, '', '', '2025-11-28 08:18:07', '2025-11-28 08:18:07'),
(459, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 101', 'Understanding the Self', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(460, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 102', 'Readings in Phil. History', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(461, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 103', 'Mathematics in the Modern World', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(462, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 106', 'The Contemporary World', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(463, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 100', 'System Technology and Society', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(464, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 101', 'Introduction to Computing', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(465, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 102', 'Fundamentals of Programming', '2.00', '', 2, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(466, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'PE 1', 'Fund of Physical Fitness & Gym', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(467, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'NSTP 1', 'Nat\'l Service Training Program', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(468, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 104', 'Purposive Communication', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(469, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 105', 'Art Appreciation', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(470, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 107', 'Arts & Humanities', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(471, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 112', 'Social Science & Philosophy', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(472, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 103', 'Intermediate Programming', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(473, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'PE 2', 'Fund of Rhythm & Dances', '2.00', '', 2, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(474, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'NSTP 2', 'Nat\'l Service Training Program1', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(475, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 108', 'Science, Technology and Society', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(476, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 109', 'Ethics', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(477, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 104', 'Social Issues and Professional Practice', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(478, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 105', 'Data Structures and Algorithms', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(479, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 106', 'Information Management', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(480, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 107', 'Application Development & Emerging Technologies', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(481, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'PE 3', 'Spec. in Team Sports/Game', '2.00', '', 2, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(482, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 110', 'Rizal', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(483, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 111', 'Mathematics, Science & Society', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(484, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 108', 'Fundamentals of Database Systems', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(485, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 109', 'Integrative Programming Technologies 1', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(486, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 110', 'Data Communication & Networking', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(487, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC1', 'Object Oriented Programming', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(488, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'PE 4', 'Spec. in Recreational Activities', '2.00', '', 2, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(489, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 111', 'Discrete Mathematics', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(490, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 112', 'Information Assurance & Security I', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(491, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 113', 'Introduction to Human Computer Interaction', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(492, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 2', 'Integrative Programming Tech 2', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(493, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'RES 1', 'Capstone Project and Research 1', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(494, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 113', 'Filipino para sa Natatanging Gamit', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(495, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 114', 'Phil. History and Culture', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(496, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 114', 'Systems Integration and Architecture 1', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(497, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 3', 'Intro to Microcontroller', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(498, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 4', 'Human Computer Interaction 2', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(499, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 5', 'Platform Technologies', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(500, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'RES 2', 'Capstone Project and Research 2', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(501, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 115', 'Filipino Bilang Ikalawang Wika', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(502, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 116', 'Philippine Literature', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(503, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 115', 'System Administration and Maintenance', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(504, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 116', 'Networking 2', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(505, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 117', 'Quantitative Methods (incl. Modeling and Simulation)', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(506, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 118', 'Information Assurance & Security 2', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(507, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 6', 'IT Elective 6', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(508, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 117', 'Malikhaing Pagsulat', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(509, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 118', 'World Literature', '2.00', '', 3, '1st Year - 1st Semester', '', '2025-12-04 09:31:50', '2025-12-04 09:31:50'),
(510, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 101', 'Understanding the Self', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(511, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 102', 'Readings in Phil. History', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(512, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 103', 'Mathematics in the Modern World', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(513, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 106', 'The Contemporary World', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(514, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'IT 100', 'System Technology and Society', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(515, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'IT 101', 'Introduction to Computing', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(516, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'IT 102', 'Fundamentals of Programming', '2.00', '', 2, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(517, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'PE 1', 'Fund of Physical Fitness & Gym', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(518, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'NSTP 1', 'Nat\'l Service Training Program', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(519, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 104', 'Purposive Communication', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(520, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 105', 'Art Appreciation', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(521, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 107', 'Arts & Humanities', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(522, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'GE 112', 'Social Science & Philosophy', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(523, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'IT 103', 'Intermediate Programming', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(524, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'PE 2', 'Fund of Rhythm & Dances', '5.00', '', 2, '2nd Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(525, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '1st Year', 'NSTP 2', 'Nat\'l Service Training Program1', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(526, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'GE 108', 'Science, Technology and Society', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(527, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'GE 109', 'Ethics', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(528, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 104', 'Social Issues and Professional Practice', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(529, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 105', 'Data Structures and Algorithms', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(530, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 106', 'Information Management', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(531, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 107', 'Application Development & Emerging Technologies', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(532, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'PE 3', 'Spec. in Team Sports/Game', '2.00', '', 2, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(534, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'GE 110', 'Rizal', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(535, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'GE 111', 'Mathematics, Science & Society', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(536, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 108', 'Fundamentals of Database Systems', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(537, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 109', 'Integrative Programming Technologies 1', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(538, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT 110', 'Data Communication & Networking', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(539, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'IT ELEC1', 'Object Oriented Programming', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(540, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'PE 4', 'Spec. in Recreational Activities', '2.00', '', 2, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(541, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT 111', 'Discrete Mathematics', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(542, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT 112', 'Information Assurance & Security I', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(543, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT 113', 'Introduction to Human Computer Interaction', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(544, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT ELEC 2', 'Integrative Programming Tech 2', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(545, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'RES 1', 'Capstone Project and Research 1', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(546, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'GE 113', 'Filipino para sa Natatanging Gamit', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(547, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'GE 114', 'Phil. History and Culture', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:57:32', '2025-12-04 12:28:48'),
(548, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT 114', 'Systems Integration and Architecture 1', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(549, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT ELEC 3', 'Intro to Microcontroller', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(550, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT ELEC 4', 'Human Computer Interaction 2', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(551, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'IT ELEC 5', 'Platform Technologies', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(552, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'RES 2', 'Capstone Project and Research 2', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(553, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'GE 115', 'Filipino Bilang Ikalawang Wika', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(554, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '3rd Year', 'GE 116', 'Philippine Literature', '2.00', '', 3, '2nd Semester', '', '2025-12-04 12:28:48', '2025-12-04 12:28:48'),
(555, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 115', 'System Administration and Maintenance', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(556, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 116', 'Networking 2', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(557, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 117', 'Quantitative Methods (incl. Modeling and Simulation)', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(558, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT 118', 'Information Assurance & Security 2', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(559, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'IT ELEC 6', 'IT Elective 6', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(560, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 117', 'Malikhaing Pagsulat', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(561, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '4th Year', 'GE 118', 'World Literature', '2.00', '', 3, '1st Semester', '', '2025-12-04 12:43:34', '2025-12-04 12:28:48'),
(562, '2022-14161', 'Jeanlyn Cuerdo', 'BSIT', '2nd Year', 'PE 2', 'Fund of Rhythm & Dances', '1.00', '', 2, '1st Semester', '', '2025-12-04 13:32:18', '2025-12-04 13:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `home_address` varchar(255) NOT NULL,
  `elementary` varchar(255) NOT NULL,
  `senior_high_school` varchar(255) NOT NULL,
  `course` varchar(100) NOT NULL,
  `section` varchar(50) DEFAULT NULL,
  `year` varchar(20) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `cor_file` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'for approval'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `email`, `phone`, `home_address`, `elementary`, `senior_high_school`, `course`, `section`, `year`, `profile_image`, `cor_file`, `password`, `created_at`, `updated_at`, `status`) VALUES
(22, '2323', 'Julie Zummer Carable', 'benedictalcayde9@gmail.com', '87654', '', '', '', 'BSCS', 'D', '4th Year', '1763561999_dog-cat-hero.jpg', NULL, '$2y$10$pdsE3BqnXs0N76cq4dllaO9nPmNW2WxKXEFfI5JjojS.lGnzSK/OO', '2025-11-19 14:19:59', '2025-11-19 14:20:14', 'approved'),
(24, '2022-15467', 'Jerowski Catena', 'Jerowski@gmail.com', '09927428058', '', '', '', 'BSCS', 'B', '4th Year', '1764313222_BINI AIAH.jpg', '1764313222_cor_BINI AIAH.jpg', '$2y$10$glhM1rqKe2/l4zWf59U92espzapJRgD/hpQRKmvGxNTBRqGuwrxey', '2025-11-28 07:00:22', '2025-11-28 07:04:20', 'approved'),
(25, '2022-14161', 'Jeanlyn Cuerdo', 'cuerdojeanlyn6@gmail.com', '09383918221', '', '', '', 'BSIT', 'C', '4th Year', '6931a311c0834_BINI AIAH.jpg', '1764838818_cor_BINI AIAH.jpg', '$2y$10$XxaMvBGH/ms0jzzcAnttX.V1nEHXSP4UJWWQ3Dw1mRRBMpuNsJ3DK', '2025-12-04 09:00:18', '2025-12-04 15:04:49', 'approved'),
(29, '2022-13931', 'allyssa shane illao', 'shane@illao', '09078966684', '', '', '', 'BSCS', 'N/A', '4th Year', NULL, '1764859723_cor_BINI AIAH.jpg', '$2y$10$5VBDIPIKsWahUL.0TlLo3OOVsHFnLuUrsVSdwuu41mTSvZU.1da2a', '2025-12-04 14:48:43', '2025-12-04 14:49:09', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `student_documents`
--

CREATE TABLE `student_documents` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `application_form` varchar(255) NOT NULL,
  `valid_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`valid_documents`)),
  `status` enum('Under Review','Approved','Rejected') DEFAULT 'Under Review',
  `admin_checklist_status` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_documents`
--

INSERT INTO `student_documents` (`id`, `student_id`, `application_form`, `valid_documents`, `status`, `admin_checklist_status`, `uploaded_at`) VALUES
(36, '2022-15467', 'uploads/1764837236_app_Jerowski Catena_Graduation_Application.pdf', '{\"F137\":\"uploads\\/1764837274_f137_BINI AIAH.jpg\"}', 'Under Review', '{\"F138 HS\":true,\"F137\":true,\"Birth Certificate\":true,\"Good Moral\":true,\"SHS Diploma\":true,\"2x2 Picture\":true}', '2025-12-04 08:34:34'),
(37, '2022-14161', 'uploads/1764839493_app_Jeanlyn Cuerdo_Graduation_Application.pdf', '{\"SHS Diploma\":\"uploads\\/1764840324_shs_diploma_BINI AIAH.jpg\",\"F138 HS\":\"uploads\\/1764841784_f138_hs_Picture3.gif\"}', 'Under Review', '{\"F138 HS\":true,\"F137\":true,\"Birth Certificate\":true,\"Good Moral\":true,\"SHS Diploma\":true,\"2x2 Picture\":true}', '2025-12-04 09:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `student_sms_logs`
--

CREATE TABLE `student_sms_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_sms_logs`
--
ALTER TABLE `admin_sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_smslogs_admin` (`admin_id`),
  ADD KEY `fk_admin_smslogs_student` (`student_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student` (`student_id`);

--
-- Indexes for table `student_sms_logs`
--
ALTER TABLE `student_sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `admin_sms_logs`
--
ALTER TABLE `admin_sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=563;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `student_documents`
--
ALTER TABLE `student_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `student_sms_logs`
--
ALTER TABLE `student_sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD CONSTRAINT `admin_activity_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_sms_logs`
--
ALTER TABLE `admin_sms_logs`
  ADD CONSTRAINT `fk_admin_smslogs_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_admin_smslogs_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_sms_logs`
--
ALTER TABLE `student_sms_logs`
  ADD CONSTRAINT `student_sms_logs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
