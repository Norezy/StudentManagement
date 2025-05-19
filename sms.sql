-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 01:09 PM
-- Server version: 8.0.42
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'BSIT', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', '2025-05-04 11:00:45', '2025-05-16 11:34:05'),
(5, 'BSCE', 'BACHELORS OF SCIENCE IN CIVIL ENGINEERING', '2025-05-04 14:35:22', '2025-05-16 11:34:08'),
(6, 'BSABE', 'BACHELOR OF SCIENCE IN AGRICULTURAL AND BIOSYSTEMS ENGINEERING', '2025-05-14 07:36:11', NULL),
(7, 'BSCS', 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', '2025-05-16 12:01:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `instructor_id` int NOT NULL,
  `grade` decimal(3,2) DEFAULT NULL,
  `remarks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `instructor_id`, `grade`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 7, 1, 32, NULL, 'incomplete', '2025-05-10 14:45:34', '2025-05-16 09:52:31'),
(5, 8, 1, 32, 1.00, 'passed', '2025-05-11 16:24:05', NULL),
(6, 2, 11, 32, 5.00, 'failed', '2025-05-12 06:01:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `course_id` int NOT NULL,
  `year_level` tinyint NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `gender`, `birthdate`, `course_id`, `year_level`, `status`, `created_at`, `updated_at`) VALUES
(1, '23-1234', 'Norberto Loreto Ortiz', 'male', '2004-10-12', 1, 3, 'active', '2025-05-06 13:57:32', '2025-05-14 15:38:03'),
(2, '23-2628', 'Brixter Libutan', 'male', '2025-05-06', 1, 3, 'active', '2025-05-06 13:58:12', '2025-05-14 07:25:57'),
(5, '99-9090', 'Mike Dela Cruz', 'male', '2025-05-07', 5, 3, 'active', '2025-05-07 09:42:05', '2025-05-07 09:46:21'),
(6, '21-12213', 'Juan Dela Cruz', 'male', '2025-05-07', 5, 3, 'inactive', '2025-05-07 09:42:37', '2025-05-16 13:15:14'),
(7, '26-2004', 'Jhoanna Robles', 'female', '2004-01-26', 5, 3, 'active', '2025-05-07 10:44:17', '2025-05-16 13:15:34'),
(8, '27-2002', 'Maloi Recalde', 'female', '2002-05-27', 5, 3, 'active', '2025-05-07 10:48:22', '2025-05-14 05:00:08'),
(12, '23-123456', 'Wilmar Agoy', 'male', '2025-05-18', 1, 2, 'active', '2025-05-18 06:42:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int NOT NULL,
  `code` varchar(20) NOT NULL,
  `catalog_no` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `day` varchar(10) NOT NULL,
  `time` varchar(20) NOT NULL,
  `room` varchar(20) NOT NULL,
  `course_id` int NOT NULL,
  `semester` tinyint NOT NULL,
  `year_level` tinyint NOT NULL,
  `instructor_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `catalog_no`, `name`, `day`, `time`, `room`, `course_id`, `semester`, `year_level`, `instructor_id`, `created_at`, `updated_at`) VALUES
(1, '20250504135830', 'INTECH 2201', 'WEB APPLICATIONS DEVELOPMENT', 'T/TH', '10:00-13:00', '204', 5, 1, 3, 32, '2025-05-04 11:58:30', '2025-05-16 13:16:41'),
(4, '20250505023702', 'INTECH 2201', 'WEB APPLICATIONS DEVELOPMENT', 'T/TH', '10:00-12:00', '205', 5, 1, 3, 28, '2025-05-05 00:37:25', '2025-05-16 13:16:43'),
(11, '20250507161757', 'COMSCI 2200', 'ADVANCE DATABASE MANAGEMENT', 'T/TH', '10:00-12:00', '202', 5, 2, 3, 32, '2025-05-07 14:18:59', '2025-05-16 13:16:45'),
(12, '20250516132816', 'COMSCI 2200', 'ADVANCE DATABASE MANAGEMENT', 'T/F', '10:00-12:00', '204', 1, 1, 3, 37, '2025-05-16 11:28:37', '2025-05-16 16:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `subject_enrollments`
--

CREATE TABLE `subject_enrollments` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject_enrollments`
--

INSERT INTO `subject_enrollments` (`id`, `student_id`, `subject_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 7, 1, 'enrolled', '2025-05-07 10:44:50', '2025-05-16 13:20:31'),
(17, 2, 11, 'enrolled', '2025-05-07 14:19:08', NULL),
(20, 8, 1, 'enrolled', '2025-05-11 16:21:47', NULL),
(24, 5, 11, 'enrolled', '2025-05-14 06:11:24', NULL),
(25, 6, 1, 'enrolled', '2025-05-14 14:51:51', NULL),
(32, 5, 1, 'enrolled', '2025-05-16 11:58:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Norberto Loreto Ortiz', 'superadmin@gmail.com', '$2y$10$X3lSuueG5GDFCnfgo9XnmOEkdc/SAoyDmDz6tm1AlTxLLPBeTdZwC', 'super-admin', 'active', 'avatar_1.jpg', '2025-04-28 14:58:53', '2025-05-17 13:42:50'),
(20, 'John Carlo Cabardo', 'johncarlo.cabardos@gmail.com', '$2y$10$5O/F79rkpvzY19vNqdL0neW4Y85mnh/eOAJiyaK0jzDyMzOM/38Lq', 'instructor', 'active', NULL, '2025-04-28 13:25:47', '2025-05-14 15:49:06'),
(21, 'Admin One', 'admin1@gmail.com', '$2y$10$rEzO4elecHwhK7M4ScYeOu6bl/4umta.EE6jFW3A7LZgjJQRyi.QO', 'admin', 'active', 'avatar_21.png', '2025-04-28 13:25:59', '2025-05-16 13:11:58'),
(28, 'Prof One', 'prof1@gmail.com', '$2y$10$Utca2I3Bam41NixseQ8ui.X4n2HN8Nk5qUEC7bYJwtAL4x/inWg6u', 'instructor', 'active', NULL, '2025-05-01 08:23:29', '2025-05-14 15:48:57'),
(32, 'Brixter Libutan', 'BrixLib@gmail.com', '$2y$10$gCSF4QNuf5gRsNbzvdb5Sexb5QfpKN.dEB1hpNW7K0QaiD4a/GcRW', 'instructor', 'active', 'avatar_32.jpg', '2025-05-03 04:53:51', '2025-05-16 13:25:55'),
(37, 'Renz Buiza', 'RenzBuiza@gmail.com', '$2y$10$gZEMbeKNVEd/6jR1Mtg5SeW6gHBBu35M3X9XqONfewgDLJllDRGdu', 'instructor', 'active', NULL, '2025-05-14 04:53:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `subject_enrollments`
--
ALTER TABLE `subject_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_enrollments_ibfk_1` (`student_id`),
  ADD KEY `subject_enrollments_ibfk_2` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subject_enrollments`
--
ALTER TABLE `subject_enrollments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `subject_enrollments`
--
ALTER TABLE `subject_enrollments`
  ADD CONSTRAINT `subject_enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_enrollments_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
