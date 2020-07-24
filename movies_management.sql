-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 21, 2020 at 09:39 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int NOT NULL,
  `movie_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `movie_image` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'movie_image(Poster)',
  `released_date` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `movie_name`, `movie_image`, `released_date`) VALUES
(1, 'Avatar', '1.jpeg', '2009-12-18'),
(2, 'Guardians of the Galaxy', '2.jpeg', '2014-08-08'),
(3, 'Ant Man', '3.jpeg', '2015-07-14'),
(4, 'Kabir singh', '4.jpeg', '2019-07-21'),
(5, 'captain marvel', '5.jpeg', '2019-05-08'),
(6, 'Black Widow', '6.jpeg', '2020-11-06\r\n'),
(8, 'Avatar 2', '1.jpeg', '2009-12-18'),
(9, 'Ant Man 2', '3.jpeg', '2015-07-14'),
(10, 'captain marvel 2', '5.jpeg', '2019-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `username`, `password`) VALUES
(1, 'Mitesh Ladva', 'miteshladva.dgrs@gmail.com', 'mitesh_ladva', '12345'),
(4, 'Mitesh Ladva', 'mitesh@freshbits.in', 'mitesh_ladva_2', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD UNIQUE KEY `post_id` (`post_id`),
  ADD UNIQUE KEY `movie_name` (`movie_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
