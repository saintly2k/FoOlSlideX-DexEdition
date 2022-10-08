-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2022 at 11:17 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `batato`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `chapter` decimal(10,0) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_path` text NOT NULL,
  `awaiting_approval` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'url', 'http://localhost/FoOlSlideX-DexEdition/'),
(2, 'title', 'BATA.TO'),
(3, 'description', 'Read Manga Online'),
(4, 'cookie', 'bata'),
(5, 'captcha_enabled', '0'),
(6, 'captcha_key', NULL),
(7, 'captcha_secret', NULL),
(8, 'cache_enabled', '0'),
(9, 'default_theme', 'de_light'),
(10, 'default_language', 'en'),
(11, 'tailwind_type', 'cdn'),
(12, 'tailwind_url', NULL),
(13, 'home_display_titles', '16'),
(14, 'home_display_chapters', '36'),
(15, 'site_started', '2022'),
(16, 'display_credits', '1'),
(17, 'logs', '1');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `before` text NOT NULL,
  `after` text NOT NULL,
  `ip` text NOT NULL,
  `browser` text NOT NULL,
  `browser_info` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions_edit`
--

CREATE TABLE `permissions_edit` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions_modify`
--

CREATE TABLE `permissions_modify` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions_upload`
--

CREATE TABLE `permissions_upload` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `token` text NOT NULL,
  `browser` text NOT NULL,
  `browser_details` text NOT NULL,
  `ip` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` int(11) NOT NULL,
  `cover` varchar(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alt_names` varchar(500) DEFAULT NULL,
  `authors` varchar(100) DEFAULT NULL,
  `artists` varchar(100) DEFAULT NULL,
  `genre` text NOT NULL,
  `original_language` varchar(20) NOT NULL,
  `original_work` int(1) DEFAULT NULL,
  `upload_status` int(1) DEFAULT NULL,
  `release_year` int(4) DEFAULT NULL,
  `complete_year` int(4) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 100,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `avatar` varchar(4) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `gender` int(11) NOT NULL,
  `biography` text DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banned_reason` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_edit`
--
ALTER TABLE `permissions_edit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_modify`
--
ALTER TABLE `permissions_modify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_upload`
--
ALTER TABLE `permissions_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions_edit`
--
ALTER TABLE `permissions_edit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions_modify`
--
ALTER TABLE `permissions_modify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions_upload`
--
ALTER TABLE `permissions_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
