-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2017 at 01:20 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `x-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `user_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  `time_created` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `description`, `visible`, `time_created`) VALUES
(156, 17, 'Here are some Photos', 1, '2017-01-13 12:04'),
(157, 17, 'Other posts', 1, '2017-01-13 12:11'),
(158, 18, 'Photos of admin', 1, '2017-01-13 12:39'),
(159, 18, 'This post is supposed to be not public', 0, '2017-01-13 12:56'),
(160, 18, 'Post with photos', 1, '2017-01-13 12:59'),
(161, 18, 'Post with photos', 1, '2017-01-13 13:00'),
(162, 17, 'My new post', 1, '2017-01-13 13:03');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `post_id` int(22) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` text NOT NULL,
  `time_created` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `post_id`, `user_id`, `file_name`, `time_created`) VALUES
(50, 156, 17, '1bhyzfvygaw-oscar-nilsson.jpg', '2017-01-13 '),
(51, 156, 17, 'in8.jpg', '2017-01-13 '),
(52, 156, 17, 'in7.jpg', '2017-01-13 '),
(53, 156, 17, 'pcnp2e-og1q-cristian-newman.jpg', '2017-01-13 '),
(54, 157, 17, '_th3ycjpcce-alternate-skate.jpg', '2017-01-13 '),
(55, 157, 17, '20151115_123536.jpg', '2017-01-13 '),
(56, 157, 17, '20160207_101101.jpg', '2017-01-13 '),
(57, 158, 18, '20151115_155643 - Copy.jpg', '2017-01-13 '),
(58, 158, 18, '20151115_123536.jpg', '2017-01-13 '),
(59, 158, 18, '20151115_155656 - Copy.jpg', '2017-01-13 '),
(60, 158, 18, '_th3ycjpcce-alternate-skate - Copy.jpg', '2017-01-13 '),
(61, 158, 18, 'self-motivation.jpg', '2017-01-13 '),
(62, 159, 18, '20160221_151246.jpg', '2017-01-13 '),
(63, 159, 18, 'in1.jpg', '2017-01-13 '),
(64, 159, 18, '20160221_151255.jpg', '2017-01-13 '),
(65, 161, 18, 'pcnp2e-og1q-cristian-newman.jpg', '2017-01-13 '),
(66, 161, 18, 'in8.jpg', '2017-01-13 '),
(67, 161, 18, '20160221_151235.jpg', '2017-01-13 '),
(68, 161, 18, '20160207_101105.jpg', '2017-01-13 '),
(69, 161, 18, '20151115_155656.jpg', '2017-01-13 '),
(70, 161, 18, '_th3ycjpcce-alternate-skate.jpg', '2017-01-13 '),
(71, 162, 17, '20160221_152009.jpg', '2017-01-13 '),
(72, 162, 17, '20160221_151255.jpg', '2017-01-13 '),
(73, 162, 17, '20160221_151235.jpg', '2017-01-13 '),
(74, 162, 17, '20160207_124638.jpg', '2017-01-13 '),
(75, 162, 17, '20160221_151246.jpg', '2017-01-13 '),
(76, 162, 17, '20160221_151243.jpg', '2017-01-13 '),
(77, 162, 17, '20151115_155656.jpg', '2017-01-13 '),
(78, 162, 17, '20151115_155643.jpg', '2017-01-13 '),
(79, 162, 17, '20151115_123536.jpg', '2017-01-13 '),
(80, 162, 17, 'pcnp2e-og1q-cristian-newman.jpg', '2017-01-13 '),
(81, 162, 17, 'in8.jpg', '2017-01-13 '),
(82, 162, 17, 'images.jpg', '2017-01-13 '),
(83, 157, 17, 'images.jpg', '2017-01-13 '),
(84, 161, 18, 'images.jpg', '2017-01-13 '),
(85, 159, 18, 'images.jpg', '2017-01-13 ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `register_verify` varchar(60) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`, `register_verify`, `is_admin`) VALUES
(17, 'endrit', 'endrit_gjeta@yahoo.com', '$2y$10$gDoImnqvMV3/ozigy8pMwuI79r9ml5nNldc2Zah9l6LWdy8Hbowm.', 1, '$2y$10$7/d./ErDzOrMrVtLvLkS0.L7D0TOu9SMhNUvvPTO2Q6sZNGYPRRga', 0),
(18, 'admin', 'ag.iliria@gmail.com', '$2y$10$IX0lrSuwAeswkOL.paIgK.aiD3AIAjozt8Op1PnUgzoY80iiibKwq', 1, '$2y$10$miK8iscmu4JC0es4SPXcye.MCQ4EjuuCf55OgQ2mIu1wuVmo6PxgS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
