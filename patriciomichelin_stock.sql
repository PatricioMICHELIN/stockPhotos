-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: db.3wa.io
-- Generation Time: Jun 29, 2022 at 05:33 AM
-- Server version: 5.7.33-0ubuntu0.18.04.1-log
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patriciomichelin_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `admin_pseudo` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `admin_password` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Admin table';

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_pseudo`, `admin_email`, `admin_password`) VALUES
(1, 'pato', 'admin@admin.com', '$2y$10$GZVITjRASmxLN8YFhSYy/uKJrtdgIGjO0yko8G6dlSdbbx1jeiBLm'),
(9, 'patoAdmin', 'admin@pato.com', '$2y$10$xXxpScT7Zs1iGfYFimM1xuR42Gkti6luEhQ8gAo2ogB1ddmhPI5g2'),
(10, 'argon71', 'argon71@hotmail.fr', '$2y$10$myH2B6UHBkfid5sadIVUw.yhVWSrk4es0gJu0RHXXNG.2lRpmM5gW');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(255) UNSIGNED NOT NULL,
  `client_id` int(255) NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `author_surname` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `author_phone` int(255) NOT NULL,
  `author_web` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `author_ig` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `client_id`, `author_name`, `author_surname`, `author_email`, `author_phone`, `author_web`, `author_ig`) VALUES
(63, 38, 'yyyyasmine', 'bbbbbouchra', 'live35@gmail.com', 123, 'www.yb.com', '12'),
(64, 38, 'bouchra', 'bouchra', 'ff2@gmail.com', 222, 'www.yb.com', '12'),
(73, 44, 'pete', 'sampras', 'pete@sampras.com', 123, 'www.pete.com', '@sampras'),
(74, 44, 'andre', 'agassi ', 'andre@agassi.com', 123, 'www.andre.com', '@andre'),
(75, 42, 'stefan', 'edberg', 'stefan@edberg.com', 123, 'www.stefan.com', '@stefan '),
(76, 41, 'patrick', 'rafter', 'patrick@rafter.com', 123, 'www.patrick.com', '@patrick  '),
(77, 40, 'roger', 'federer', 'roger@federer.com', 123, 'www.roger.com', '@roger'),
(78, 42, 'rafa', 'nadal', 'rafa@nadal.com', 123, 'www.rafa.com', '@rafa');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(255) NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `client_surname` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `client_email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `client_password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `client_phone` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_surname`, `client_email`, `client_password`, `client_phone`) VALUES
(38, 'leyla', 'leyla', 'leyla@gmail.com', '$2y$10$lyKL.gkG/omBPBpdgPO5IecCQW8bjh7NzCfayBOiVC4hA0mDBqvGi', '123'),
(40, 'THREE', 'clientTHREE', 'client3@pato.com', '$2y$10$jthxd8fu8Gbk/hpMKriJR.ovfhhHZnr.3lRV.CslyVJeQI9lSRmWu', '123'),
(41, 'FOUR', 'clientFOUR', 'client4@pato.com', '$2y$10$roIsgX7IrkHC2zv/Kp7gmutkNEly/JTB4w/3t6HOa/U.ZF/PGRfgO', '123'),
(42, 'TWO', 'clientTWO', 'client2@pato.com', '$2y$10$AX147xApDrlwbCVR3DMZSeDz/T5W61as6K6EIt85MBqjZa2v3B0OG', '123'),
(44, 'ONE', 'clientONE', 'client1@pato.com', '$2y$10$0EX30MvaPyxUOsKtuSxtjeqfK/55ANqXW2xj/DXVGflkGEi8lZEqG', '123'),
(45, 'leyla', 'leyla', 'chakour@gmail.com', '$2y$10$oIv381etIZaTdr3PTPIfO.si9HhnFRinDllDOtnFJDruSGFnHTMWG', '123');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(255) NOT NULL,
  `client_id` int(255) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `image_caption` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `image_date` date NOT NULL,
  `image_hashtag` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `image_author` int(32) UNSIGNED NOT NULL,
  `image_use` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `client_id`, `image_name`, `image_caption`, `image_date`, `image_hashtag`, `image_author`, `image_use`) VALUES
(178, 44, '62b183d72d5999.88481333.png', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-15', 'image_hashtag1', 73, 'news'),
(180, 44, '62b18409777839.87229309.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-22', 'image_hashtag6', 73, 'news'),
(181, 44, '62b18447d54b57.91052661.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-05', 'image_hashtag4', 74, 'news'),
(182, 44, '62b1845a204025.72216321.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-05', 'image_hashtag3', 74, 'sport'),
(183, 42, '62b18858ca5912.36133691.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-08', 'image_hashtag3', 75, 'news'),
(184, 42, '62b188763e1af7.78856115.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-24', 'image_hashtag6', 75, 'corporatif'),
(185, 44, '62b188c345be47.36734931.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-16', 'image_hashtag5', 74, 'news'),
(186, 44, '62b188e9bca4b6.42043749.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-09', 'image_hashtag3', 73, 'news'),
(187, 41, '62b18934d55219.21672481.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e ADMIN', '2022-06-16', 'image_hashtag2', 76, 'advertisement'),
(188, 41, '62b189607f3c32.02453404.png', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-23', 'image_hashtag3', 76, 'sport'),
(189, 41, '62b1897b019ba8.61881959.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-30', 'image_hashtag4', 76, 'news'),
(190, 40, '62b189e6656c49.56671276.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-08', 'image_hashtag6', 77, 'news'),
(193, 40, '62b18a1a21e664.76528483.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-08', 'image_hashtag1', 77, 'news'),
(194, 42, '62b18ab62842d1.83017632.png', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-03', 'image_hashtag2', 78, 'advertisement'),
(195, 42, '62b18ace6ddcf6.24570812.jpg', 'e and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into \r\nelectronic typesetting, remaining e', '2022-06-17', 'image_hashtag5', 78, 'news');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`),
  ADD KEY `EraseAuthor` (`client_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `EraseImage` (`client_id`),
  ADD KEY `image_author` (`image_author`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `EraseAuthor` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `EraseAuteurImage` FOREIGN KEY (`image_author`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EraseImage` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
