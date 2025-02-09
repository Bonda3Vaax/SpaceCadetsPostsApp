-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2024 at 02:47 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rocketpost_extended`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` tinytext,
  `subject` varchar(100) DEFAULT NULL,
  `imagename` varchar(255) DEFAULT NULL,
  `comment` text,
  `imagepath` text,
  `reference` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `subject`, `imagename`, `comment`, `imagepath`, `reference`) VALUES
(3, 'Stars', 'Astronomy', '16_66c92e4d360c39.84669591.jpg', 'Awesome!!', './public/uploads/posts/16_66c92e4d360c39.84669591.jpg', 'Nasa'),
(4, 'More stars!', 'Astronomy', '16_66c948984a3e7.jpg', 'Lovely', './public/uploads/posts/16_66c948984a3e7.jpg', NULL),
(5, '11 Apostoles', 'Geology', '16_66c9491032016.jpg', '10 left unfortunately..', './public/uploads/posts/16_66c9491032016.jpg', NULL),
(6, 'Comet', 'Physics', '16_66c9486ca34399.89377677.jpg', 'Awesome!!', './public/uploads/posts/16_66c9486ca34399.89377677.jpg', 'Unsplash free'),
(7, 'Seaweeds', 'Biology', '16_66c948d1242ba1.19441225.jpg', 'A lot of..', './public/uploads/posts/16_66c948d1242ba1.19441225.jpg', 'Internet'),
(8, 'Cape T', 'Chemistry', '16_66c948fe85e4b3.84308745.jpg', 'Homework to do..', './public/uploads/posts/16_66c948fe85e4b3.84308745.jpg', 'Australia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `uidUsers` tinytext,
  `emailUsers` tinytext,
  `pwdUsers` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `uidUsers`, `emailUsers`, `pwdUsers`) VALUES
(16, 'A', 'a@mail.com', '$2y$10$OFDrRjIQ15CUwHtYBYT7X.JFaB3gZkKNCZbtTREvAcHfs0zWWnr36'),
(17, 'B', 'b@mail.com', '$2y$10$4C09tKOzAEkyTX/OsGHXaehB4JwG.Gius3WMXKtnQTglt0resolz6'),
(18, 'c', 'c@mail.com', '$2y$10$5bakqoTBnIsvzqBl8f1OJejFXZUGg7tN4NopVIuAT/IrmfPnn7lri'),
(19, 'd', 'd@mail.com', '$2y$10$OvCoB.abbYyEPThd3OA8cezWo8/WYPxReUrcMf7uLq7LMim0jPPQu'),
(20, 'e', 'e@mail.com', '$2y$10$6mV88pfz.UDEBUqVjcReZOE/Lml4pWJU9ppEff3ulXYt4bY7s..T6'),
(21, 'f', 'f@mail.com', '$2y$10$9E1/aZfBkqT3AjTbpc4Ayult9LqYV5Svrd2aiJNg/Yd5UtWr5y2LO'),
(22, 's', 's@mail.com', '$2y$10$Z.3ZNpvGSgWx/ADwZGH45uYuG.P0V2NE8d.MBr0iU2.la/FpbdLFu'),
(23, 'w', 'w@mail.com', '$2y$10$OtP/BgtvMB6J6qhFDYkHHujhEje0ojYfu9.TAs6RrtqpIrVhHvGF.'),
(24, 'z', 'z@mail.com', '$2y$10$Gxba4WO/2AmJh0AeUBW0L.mqBJwID19ZDloZwCr0sJ75RFqprpF.m'),
(25, 'q', 'q@mail.com', '$2y$10$KqspHVapIXkl8CDdYknDruxw53vNNg598ZZvCnJV1eFBkqc7nt6Ke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
