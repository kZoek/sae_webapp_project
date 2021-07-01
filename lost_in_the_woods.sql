-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 29. Apr 2021 um 19:36
-- Server-Version: 5.7.24
-- PHP-Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `lost_in_the_woods`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blog_entries`
--

CREATE TABLE `blog_entries` (
  `id` int(11) NOT NULL,
  `entry_title` varchar(255) NOT NULL,
  `entry_content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `blog_entries`
--

INSERT INTO `blog_entries` (`id`, `entry_title`, `entry_content`, `post_date`) VALUES
(2, 'news from today', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae qui eius, at itaque numquam, voluptatum excepturi et eligendi aperiam culpa fuga voluptas reprehenderit quam optio in, iste illo quaerat dolor! Obcaecati praesentium molestiae repellendus ab.\r\nLorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae qui eius, at itaque numquam, voluptatum excepturi et eligendi aperiam culpa fuga voluptas reprehenderit quam optio in, iste illo quaerat dolor! Obcaecati praesentium molestiae repellendus ab.', '2021-01-14 12:10:15');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contents`
--

CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `site_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `contents`
--

INSERT INTO `contents` (`id`, `title`, `content`, `site_category`) VALUES
(1, 'What is Lost in the Woods', 'eelectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea! Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'home'),
(2, 'about the game', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'about'),
(3, 'Our goals', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'about'),
(4, 'Goal of the game', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'tutorial'),
(5, 'basic movements', 'The player can move with W A S D or the arrow keys.  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'tutorial'),
(6, 'environment', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'tutorial'),
(7, 'icons and displays', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'tutorial'),
(8, 'what changes with profiles', 'If you register, the game will save all your scores. On your profile you can check you best score.  Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quaerat delectus ipsa rem, provident adipisci quia ab. Eos amet nulla illo alias non accusantium porro? Adipisci voluptates, sint numquam facere itaque, dolore nostrum reiciendis tempore atque beatae eveniet reprehenderit quas, odit repellat ipsa voluptate natus tempora voluptatem magnam iure ea!', 'tutorial');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_category` varchar(255) NOT NULL DEFAULT 'user',
  `score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `user_category`, `score`) VALUES
(7, 'Dino', 'Damian', 'Vago', 'd.vago@hotmail.com', '$2y$10$xnL1uGTXIXe0o5lsMDETb.rgP7FnG0rySJbDfdxaYLMuMcskzEI1u', 'user', 0),
(8, 'admin', 'Ladyyy', 'Bug', 'lady.bug@banana.ch', '$2y$10$uWCFYhBCjDVzqglZZ1NXOuN6J8SSBBeMF8YXDz2hkJiZ80OeJv3Kq', 'admin', 6),
(9, 'vincent.sperdin', 'Vincent', 'Sperdin', 'vincent.sperdin@gmail.com', '$2y$10$kVbmFKt/xRL3BoW6cM6e3OOUENAZMo9RnSn5IxX6cJFd./hQ0NRwa', 'user', 0),
(13, 'amandana', 'amanda', 'clarke', 'am.calrke@yahoo.com', '$2y$10$7LSEdvOrW3O3wD0WOPB4BOO4BPS5pylpVQLPO2roIrNijwEvvA50i', 'user', 0),
(14, 'cake', 'bana', 'banana', 'ban@ban.ch', 'banban', 'user', 0),
(15, 'darciemon', 'monic', 'darcie', 'mon@mon.com', '$2y$10$ogLnjbAkh6mmJ5cpLsKoM.rwU3T7oiaL8acD6VB9FTb/OZ2def81i', 'user', 0),
(16, 'moongi', 'zoe', 'kovacs', 'k.zoe95@hotmail.com', '$2y$10$bBBv4jvCix/CiWiW8BGCpuvsXrYQZQjrc3BRncx2yBpAnt2ygIPwu', 'user', 5),
(17, 'magdi', 'Magda', 'lena', 'magdalena@mag.cam', '$2y$10$.CpoR68j92LaFW9TSpEriuH1IB3tZC8hJ4rXzkIsX.ekXLkSOwEoy', 'user', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `blog_entries`
--
ALTER TABLE `blog_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `blog_entries`
--
ALTER TABLE `blog_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
