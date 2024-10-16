-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 06:19 AM
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
-- Database: `kanban_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `task_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 1, 1, 'Please complete this task by Friday', '2024-10-14 14:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('backlog','todo','in_progress','done') DEFAULT 'backlog',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `img`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Create project plan', 'Develop a project plan for the new app', NULL, 2, 'todo', '2024-10-14 14:13:33', '2024-10-16 03:12:15'),
(2, 'test', 'test descr', NULL, 14, 'backlog', '2024-10-15 02:22:02', '2024-10-16 04:09:29'),
(3, 'test', 'test descr', '', 14, 'in_progress', '2024-10-15 02:24:21', '2024-10-16 04:09:54'),
(4, 'test', 'test descr', '', 14, 'done', '2024-10-15 02:24:44', '2024-10-16 03:01:05'),
(5, 'test', 'test descr', '', 14, 'todo', '2024-10-15 02:25:24', '2024-10-16 04:09:27'),
(6, 'test', 'test descr', NULL, 14, 'backlog', '2024-10-15 02:26:04', '2024-10-16 03:12:11'),
(7, 'test', 'test descr', '', 14, 'todo', '2024-10-15 02:26:28', '2024-10-15 02:26:28'),
(8, 'test', 'test descr', '', 14, 'backlog', '2024-10-15 02:28:07', '2024-10-16 03:01:17'),
(9, 'test', 'test descr', 'Screenshot 2024-09-26 163410.png', 14, 'done', '2024-10-15 02:28:14', '2024-10-16 03:27:14'),
(10, 'test', 'test descr', 'Screenshot 2024-09-26 163410.png', 14, 'todo', '2024-10-15 02:29:10', '2024-10-16 04:09:49'),
(11, 'test', 'test descr', 'Screenshot 2024-09-26 163410.png', 14, 'backlog', '2024-10-15 02:29:12', '2024-10-16 03:01:30'),
(12, 'test', 'test descr', 'Screenshot 2024-09-26 163410.png', 14, 'todo', '2024-10-15 02:30:08', '2024-10-15 02:30:08'),
(13, 'Backlog', 'asdads', 'Screenshot 2024-09-26 163410.png', 2, 'todo', '2024-10-15 03:06:04', '2024-10-16 03:01:01'),
(14, 'dasda', 'sadasda', 'Screenshot 2024-09-26 065926.png', 2, 'backlog', '2024-10-15 03:06:19', '2024-10-15 03:06:19'),
(15, 'dsadas', 'asdadas', 'Screenshot 2024-09-26 161223.png', 14, 'done', '2024-10-15 03:13:16', '2024-10-16 03:01:09'),
(16, 'dksadkamsdkasd', 'dkasmdamda', 'Screenshot 2024-09-26 065926.png', 14, 'done', '2024-10-15 09:46:24', '2024-10-16 04:09:55'),
(17, 'INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES (NULL, \'hello\', \'test@gmail.com\', \'123\', \'admin\', \'active\', current_timestamp());', 'INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES (NULL, \'helloSQL\', \'test@gmail.com\', \'123\', \'admin\', \'active\', current_timestamp());', 'Screenshot 2024-09-26 065926.png', 14, 'in_progress', '2024-10-15 11:33:53', '2024-10-16 03:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin User', 'admin@example.com', 'hashedpassword123', 'admin', 'active', '2024-10-14 14:13:33'),
(2, 'John Doe', 'john@example.com', 'hashedpassword456', 'user', 'active', '2024-10-14 14:13:33'),
(3, 'Salimbay', 'admin@gmail.com', '$2y$10$VoOZqWH33jIru6Ztsi6Fm.UG8sVeJS1UWdUf2eS0.hhcIq6pcdhnC', 'admin', 'active', '2024-10-14 14:38:20'),
(14, 'Salimbay', 'new@gmail.com', '$2y$10$a.zSA2Ak8QwJ80eR9pHK8OhKvxq8FCvAbFyCnbP6jcgfB5ZHTS2uS', 'user', 'active', '2024-10-15 01:40:17'),
(15, '123', 'admin123@gmail.com', '$2y$10$GcLvJnXEyYwvTjMBpty8lec/qMLoYS0XqyzFJN3ec5gvuiiWUjKfK', 'user', 'inactive', '2024-10-15 10:06:49'),
(16, 'hello', 'test@gmail.com', '123', 'admin', 'active', '2024-10-15 11:33:16'),
(17, 'INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES (NULL', 'DMAJSNDA@GMAIL.COM', '$2y$10$PGzZHSemA4dqLLgzH.yK3.2PO6.eQHOvoFF3E6HCFufRJ3UWUPAbm', 'user', 'inactive', '2024-10-15 11:34:54'),
(18, 'asda', 'adada@gmail.com', '$2y$10$pmKgo2zBuwRLWtoS8JOhPOPkuKaAm0LowmlDVoxYWQQ7eMQ/QoE1G', 'user', 'inactive', '2024-10-15 11:48:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
