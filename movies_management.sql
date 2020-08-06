-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2020 at 06:38 PM
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
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int NOT NULL,
  `liked_post_id` int NOT NULL,
  `liked_by` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'username',
  `liked_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int NOT NULL,
  `movie_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `movie_image` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'movie_image(Poster)',
  `released_date` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `add_by` int NOT NULL DEFAULT '2',
  `download_links` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'link-1,link-2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `movie_name`, `description`, `movie_image`, `released_date`, `add_by`, `download_links`) VALUES
(1, 'Avatar', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '1.jpeg', '2009-12-18', 4, 'link-1,link-2'),
(2, 'Guardians of the Galaxy', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '2.jpeg', '2014-08-08', 27, 'link-1,link-2'),
(3, 'Ant Man', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '3.jpeg', '2015-07-14', 4, 'link-1,link-2'),
(4, 'Kabir singh', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '4.jpeg', '2019-07-21', 27, 'link-1,link-2'),
(6, 'Black Widow', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '6.jpeg', '2020-11-06\r\n', 27, 'link-1,link-2'),
(9, 'Ant Man 2', 'Suspense thrillers, as the name suggest, kept the suspense till the very end. It is hard to really know who the good guy is, or the bad guy will be. ', '3.jpeg', '2015-07-14', 27, 'link-1,link-2');

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
(4, 'Mitesh Ladva', 'mitesh@freshbits.in', 'mitesh_ladva_2', '1234'),
(27, 'Mitesh Ladva', 'miteshladva.dgrs@gmail.com', 'mitesh_ladva 3', '15963');

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
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
