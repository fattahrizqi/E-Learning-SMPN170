-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 02:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_e-learning_smpn170`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_class`
--

CREATE TABLE `t_class` (
  `id` int(11) NOT NULL,
  `grade` char(2) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `code` varchar(7) NOT NULL,
  `teacher` int(11) NOT NULL,
  `pict` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_class_attachment`
--

CREATE TABLE `t_class_attachment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `dirname` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_class_member`
--

CREATE TABLE `t_class_member` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_class_post`
--

CREATE TABLE `t_class_post` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `categories` varchar(50) NOT NULL DEFAULT 'default',
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(24) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'siswa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@admin.com', '$argon2id$v=19$m=65536,t=4,p=1$bGlmZkl0dGNzajlDLm1tdg$UR3b7gnWuKggzKlGp7BTLNOFDvEC6vLQqjSn9FtvnhU', 'admin', '2023-05-10 12:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_assignment`
--

CREATE TABLE `t_user_assignment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `dirname` varchar(255) DEFAULT NULL,
  `mark` int(11) NOT NULL,
  `teacher_note` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_user_detail`
--

CREATE TABLE `t_user_detail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `no_induk` varchar(20) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL,
  `religion` varchar(30) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birth_place` varchar(50) NOT NULL,
  `birth` date DEFAULT NULL,
  `profpic` varchar(255) NOT NULL DEFAULT 'akun-default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_class`
--
ALTER TABLE `t_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_class_ibfk_1` (`teacher`);

--
-- Indexes for table `t_class_attachment`
--
ALTER TABLE `t_class_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_class_attachment_ibfk_1` (`post_id`);

--
-- Indexes for table `t_class_member`
--
ALTER TABLE `t_class_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_class_member_ibfk_1` (`class_id`),
  ADD KEY `t_class_member_ibfk_2` (`user_id`);

--
-- Indexes for table `t_class_post`
--
ALTER TABLE `t_class_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_class_post_ibfk_1` (`class_id`),
  ADD KEY `t_class_post_ibfk_2` (`author`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_assignment`
--
ALTER TABLE `t_user_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_user_detail`
--
ALTER TABLE `t_user_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_class`
--
ALTER TABLE `t_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_class_attachment`
--
ALTER TABLE `t_class_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_class_member`
--
ALTER TABLE `t_class_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_class_post`
--
ALTER TABLE `t_class_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_user_assignment`
--
ALTER TABLE `t_user_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_user_detail`
--
ALTER TABLE `t_user_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_class`
--
ALTER TABLE `t_class`
  ADD CONSTRAINT `t_class_ibfk_1` FOREIGN KEY (`teacher`) REFERENCES `t_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_class_attachment`
--
ALTER TABLE `t_class_attachment`
  ADD CONSTRAINT `t_class_attachment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `t_class_post` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_class_member`
--
ALTER TABLE `t_class_member`
  ADD CONSTRAINT `t_class_member_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `t_class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_class_member_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `t_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_class_post`
--
ALTER TABLE `t_class_post`
  ADD CONSTRAINT `t_class_post_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `t_class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_class_post_ibfk_2` FOREIGN KEY (`author`) REFERENCES `t_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_user_assignment`
--
ALTER TABLE `t_user_assignment`
  ADD CONSTRAINT `t_user_assignment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `t_class_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `t_user_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `t_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `t_user_detail`
--
ALTER TABLE `t_user_detail`
  ADD CONSTRAINT `t_user_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
