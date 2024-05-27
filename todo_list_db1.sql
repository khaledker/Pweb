-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 06:26 PM
-- Server version: 8.0.36
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_list_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `user_id`) VALUES
(2, 'general', 1),
(3, 'general', 2),
(4, 'general', 3),
(5, 'Writing', 1),
(6, 'Reading', 1),
(7, 'Study', 2),
(8, 'Chill', 2),
(9, 'Games', 2),
(10, 'Study', 3),
(12, 'Hobbies', 1),
(13, 'country to visit', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `task_description` varchar(255) NOT NULL,
  `state` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `description`, `task_description`, `state`, `created_at`, `completed_at`, `user_id`, `category_id`) VALUES
(1, 'Have a dad', 'give me back my dad', 'pending', '2024-05-27 15:46:07', '2024-05-27 15:46:07', 1, 2),
(2, 'Find a dad', 'tell my dad to bring the milk', 'pending', '2024-05-27 15:48:07', '2024-05-27 15:48:07', 2, 3),
(3, 'To get 20 f tp pweb', 'Lazem njibo 20 because we did a great work', 'pending', '2024-05-27 15:48:57', '2024-05-27 15:48:57', 2, 7),
(5, 'Crying over Lando s first win in Miami', 'Still crying over Lando s first win in Miami so glade I saw this on live, 05/05/2024 forever in my heart &lt;3', 'pending', '2024-05-27 15:58:14', '2024-05-27 15:58:14', 2, 8),
(6, 'Beat the 5th pantheon in hollow knight', 'Absolute Radiance is so hard ', 'completed', '2024-05-27 15:59:49', '2024-05-27 16:00:01', 2, 9),
(7, 'Buy Dark souls 2', 'I have to buy this game the only souls that still didnt play', 'pending', '2024-05-27 16:01:32', '2024-05-27 16:01:32', 2, 9),
(8, 'Re play The last of us 2', 'It was such a good game I have to re play it ', 'pending', '2024-05-27 16:02:07', '2024-05-27 16:02:07', 2, 9),
(9, 'slides for pfe', 'splides should be smooth and without overwriting', 'pending', '2024-05-27 16:03:03', '2024-05-27 16:03:03', 2, 7),
(10, 'Celebrate Charles win in Monaco', 'It nice to see him win his home race but the race was boring ', 'completed', '2024-05-27 16:04:31', '2024-05-27 16:04:35', 2, 8),
(11, 'To get 20 f tp pweb', 'We did a great job I think we deserve the 20', 'pending', '2024-05-27 16:06:35', '2024-05-27 16:06:35', 3, 10),
(12, 'cheering for lando', 'cheering for lando till I die and join my dad', 'pending', '2024-05-27 16:08:40', '2024-05-27 16:08:40', 1, 12),
(13, 'Hoping for Oscar s first win this year ', 'I hope he&#039;ll win his first win this season I think he can the season is still long ', 'pending', '2024-05-27 16:13:17', '2024-05-27 16:13:17', 2, 8),
(14, 'Praying for a title batter in the last lap of Abu Dhabi', 'we can still have great battles', 'pending', '2024-05-27 16:14:29', '2024-05-27 16:14:29', 2, 8),
(16, 'Go outside after  La soutenance', 'I can not wait', 'pending', '2024-05-27 16:16:00', '2024-05-27 16:16:00', 2, 8),
(17, 'Warch F1', 'The next race is in Canada', 'pending', '2024-05-27 16:17:19', '2024-05-27 16:17:19', 2, 8),
(18, 'Warch F1', 'The next race is in Canada', 'pending', '2024-05-27 16:18:11', '2024-05-27 16:18:11', 2, 8),
(19, 'hangout with friends', 'I love spanding time with my friends', 'pending', '2024-05-27 16:20:21', '2024-05-27 16:20:21', 3, 4),
(21, 'Canada', 'You should consider visiting Canada for its breathtaking natural landscapes, vibrant cities, diverse culture, and friendly locals', 'pending', '2024-05-27 16:23:10', '2024-05-27 16:23:10', 3, 13),
(22, 'Italy', 'Experience the rich history, art, and architecture of cities like Rome, Florence, and Venice. Indulge in delicious cuisine, explore charming countryside villages', 'pending', '2024-05-27 16:24:22', '2024-05-27 16:24:22', 3, 13),
(23, 'Japan', 'Immerse yourself in a blend of ancient tradition and modern innovation. Explore bustling cities like Tokyo and Kyoto, discover serene temples and gardens, and indulge in world-renowned cuisine, from sushi to ramen.', 'pending', '2024-05-27 16:25:18', '2024-05-27 16:25:18', 3, 13),
(24, 'Finish l memoire', 'I have to finish l memoire', 'completed', '2024-05-27 16:25:48', '2024-05-27 16:25:50', 3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Naila ', '$2y$10$XNHZ9zbkIgY9Sh1ZeslJf.WEzXI/aZwqfIjixeP50xZPbAnnF0Nuq', '2024-05-27 15:39:41'),
(2, 'Sonia_', '$2y$10$jKc0FpgqTHby/Bi/NgHNl.sM/Wz02r6e83sKVCHnflQT8.Fqsy6Ry', '2024-05-27 15:40:34'),
(3, 'Khaled', '$2y$10$wH27Ggmp.exaHmfAbe28r.Ihh.zBV0./3RmZDAdvU9myjJDnrgy2y', '2024-05-27 15:40:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
