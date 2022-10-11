-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Okt 2022 um 01:18
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `batato`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chapters`
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
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `config`
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
(17, 'logs', '0'),
(18, 'defaultlevel', '100'),
(19, 'guestlevel', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `permission` text NOT NULL,
  `modify` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `owner` int(11) NOT NULL,
  `redirect` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `can_login` tinyint(1) NOT NULL,
  `can_add_title` tinyint(1) NOT NULL,
  `can_add_group` tinyint(1) NOT NULL,
  `can_add_chapter` tinyint(1) NOT NULL,
  `can_edit_title` tinyint(1) NOT NULL,
  `can_edit_group` tinyint(1) NOT NULL,
  `can_edit_chapter` tinyint(1) NOT NULL,
  `can_modify_chapters` tinyint(1) NOT NULL,
  `can_edit_users` tinyint(1) NOT NULL,
  `publisher` tinyint(1) NOT NULL,
  `mod` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `levels`
--

INSERT INTO `levels` (`id`, `level`, `name`, `can_login`, `can_add_title`, `can_add_group`, `can_add_chapter`, `can_edit_title`, `can_edit_group`, `can_edit_chapter`, `can_modify_chapters`, `can_edit_users`, `publisher`, `mod`, `admin`, `banned`, `timestamp`) VALUES
(1, 1, 'Guest', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-10-12 00:39:01'),
(2, 100, 'User', 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, '2022-10-12 00:39:20'),
(3, 200, 'Uploader', 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, '2022-10-12 00:39:36'),
(4, 500, 'Moderator', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, '2022-10-12 00:39:49'),
(5, 999, 'Administrator', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, '2022-10-12 00:40:09'),
(6, 5, 'Banned', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2022-10-12 00:40:19');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logs`
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
-- Tabellenstruktur für Tabelle `permissions_edit`
--

CREATE TABLE `permissions_edit` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions_modify`
--

CREATE TABLE `permissions_modify` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions_upload`
--

CREATE TABLE `permissions_upload` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `creator_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `resources`
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
-- Tabellenstruktur für Tabelle `sessions`
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
-- Tabellenstruktur für Tabelle `titles`
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
-- Tabellenstruktur für Tabelle `user`
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
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `permissions_edit`
--
ALTER TABLE `permissions_edit`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `permissions_modify`
--
ALTER TABLE `permissions_modify`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `permissions_upload`
--
ALTER TABLE `permissions_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT für Tabelle `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `permissions_edit`
--
ALTER TABLE `permissions_edit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `permissions_modify`
--
ALTER TABLE `permissions_modify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `permissions_upload`
--
ALTER TABLE `permissions_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
