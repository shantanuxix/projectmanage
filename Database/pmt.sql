-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 08:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message_content` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_content`, `timestamp`) VALUES
(1, 1, 2, 'Hello Anshu', '2023-07-09 14:05:26'),
(2, 2, 1, 'Hello Sir', '2023-07-09 14:05:37'),
(3, 1, 2, 'Anshu, did you completed the task that is have given you yesterday?', '2023-07-09 14:06:14'),
(4, 2, 1, 'I will complete that task before 5pm', '2023-07-09 14:06:44'),
(5, 1, 2, 'Okay', '2023-07-09 14:06:58'),
(6, 2, 3, 'Did you completed the task ?', '2023-07-09 14:07:36'),
(7, 2, 3, 'If you don\'t have than complete it before 10 pm', '2023-07-09 14:08:19'),
(8, 1, 3, 'If there will be any issue in the task ask me', '2023-07-09 14:09:14'),
(9, 1, 3, 'Okay', '2023-07-09 14:09:17'),
(10, 1, 4, 'I have completed the task', '2023-07-09 14:09:51'),
(11, 2, 4, 'How its going', '2023-07-09 14:10:09'),
(12, 2, 4, '?', '2023-07-09 14:10:13'),
(13, 3, 1, 'Okay, Sir', '2023-07-09 14:11:13'),
(14, 3, 2, 'Okay sir I will complete the task before 10pm', '2023-07-09 14:11:35'),
(15, 3, 4, 'If you have completed the task share the files', '2023-07-09 14:13:00'),
(20, 2, 1, 'Hello', '2023-07-09 15:11:19'),
(21, 1, 2, 'Hii', '2023-07-09 15:11:27'),
(22, 2, 1, 'did you completed your all tasks', '2023-07-09 15:11:42'),
(23, 1, 2, 'yes sir', '2023-07-09 15:11:48'),
(28, 2, 1, 'today i will assign you some task that you have to complete before 15', '2023-07-09 17:17:23'),
(29, 1, 2, 'ok sir', '2023-07-09 17:17:29'),
(30, 1, 2, 'i will complete the project on time', '2023-07-09 17:17:39'),
(31, 2, 1, 'okay', '2023-07-09 17:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `progress` decimal(7,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `title`, `description`, `created_by`, `progress`) VALUES
(5, 'Redesign and Optimization', 'Redesign and Optimization project', 1, 60.00),
(6, 'E-commerce Integration', 'E-commerce Integration Website', 1, 75.00),
(7, 'General Task', 'General Task Website ', 2, 36.67),
(8, 'Content Update and SEO', 'Content Update and SEO website', 1, 20.00),
(9, 'Content Update and SEO', 'Content Update and SEOContent Update and SEOContent Update and SEO', 1, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `progress` decimal(7,2) DEFAULT 0.00,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `title`, `description`, `deadline`, `assigned_by`, `assigned_to`, `progress`, `project_id`) VALUES
(1, 'Conduct website audit to identify areas of improvement', 'Audit, Optimization of the conduct website audit to identify the areas of imporvements', '2023-07-26', 1, 2, 100.00, 5),
(2, 'Develop wireframes and design mockups', 'Design and develop Wireframes and mockups', '2023-07-26', 1, 3, 80.00, 5),
(3, 'Implement responsive design for mobile devices', 'Implement responsive design for mobile devices', '2023-07-23', 1, 2, 0.00, 5),
(4, 'Checkout and Product listing', 'Develop product listing and checkout system', '2023-07-18', 1, 2, 100.00, 6),
(5, 'Research ', 'Research and select suitable e-commerce platform', '2023-07-19', 1, 3, 50.00, 6),
(6, 'Payment Gateway', 'Implement payment gateway integration', '2023-07-26', 1, 2, 75.00, 6),
(7, 'Backup', 'Backup website files and database', '2023-07-20', 2, 1, 60.00, 7),
(8, 'Security', 'Regularly monitor website security and update plugins/themes', '2023-07-24', 2, 3, 0.00, 7),
(9, 'Analytics and Performance', 'Track website analytics and generate performance reports', '2023-07-26', 2, 1, 50.00, 7),
(10, 'Keyword Research and its Identification', 'Perform keyword research and identify target keywords', '2023-07-26', 1, 2, 40.00, 8),
(11, 'Update Content', 'Update website content based on target keywords', '2023-07-28', 1, 3, 0.00, 8),
(12, 'Task1', 'Content Update and SEO', '2023-07-18', 1, 2, 50.00, 9),
(13, 'Task2', 'Content Update and SEO', '2023-07-15', 1, 3, 0.00, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profileImg` varchar(200) DEFAULT './images/defaultImage.png',
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profileImg`, `date`) VALUES
(1, 'Nilay', 'nilay@gmail.com', '$2y$10$qLqoXObT9ynlLlwh6flK8eJ0U418lW3g2Kj1oOpJEKRYBqKQTHuGm', './images/defaultImage.png', '2023-07-08 12:02:41'),
(2, 'Anshu', 'anshu@gmail.com', '$2y$10$tFMHjsOY059s5bKt/gwvOeb/6k379/damiXMjXZAMftn1suSuChBy', './images/defaultImage.png', '2023-07-08 12:31:49'),
(3, 'Karan', 'karan@gmail.com', '$2y$10$tBfpnlbhAnU.tWEIDlcotePSK.smsC/pPIA8lLg8MAPU/oTHsaJhq', './images/defaultImage.png', '2023-07-08 23:38:50'),
(4, 'Rohan', 'rohan@gmail.com', '$2y$10$.eVA7xVlW/P1Era/CIYd5O7EGwr6xwAHA4I9XhVOwEqF/JdFlHDFe', './images/defaultImage.png', '2023-07-08 23:39:54'),
(5, 'shantanuranjan8', 'shantanuranjan8@gmail.com', '$2y$10$Bqx33p3sZ09qoIq3kDlCG.bYgeq.CsjBHXYJFff798oXm6Ud7QND6', './images/defaultImage.png', '2023-07-10 23:26:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `assigned_by` (`assigned_by`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
