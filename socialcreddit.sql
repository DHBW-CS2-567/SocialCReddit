-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Apr 2025 um 16:30
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `socialcreddit`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kommentare`
--

CREATE TABLE `kommentare` (
  `ID` int(11) NOT NULL,
  `PostID` bigint(20) NOT NULL,
  `Name` text NOT NULL,
  `Likes` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `kommentare`
--

INSERT INTO `kommentare` (`ID`, `PostID`, `Name`, `Likes`, `UserID`) VALUES
(1, 2, 'Seh ich genau so!!', 0, 2),
(2, 2, 'Seh ich genau so!!', 0, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `ID` bigint(20) NOT NULL,
  `TopicID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Likes` int(11) NOT NULL,
  `Pinned` tinyint(1) NOT NULL,
  `UserID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`ID`, `TopicID`, `Name`, `Likes`, `Pinned`, `UserID`) VALUES
(1, 8, '#Willkommen im Forum der CCP.\r\nSchreibt rein worauf ihr bock habt aber bleibt im topic.\r\nMeinungsfreiheit wird hier *sehr* wertgeschätzt.', 0, 1, 3),
(2, 9, '#Miau', 0, 0, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic`
--

CREATE TABLE `topic` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `topic`
--

INSERT INTO `topic` (`ID`, `Name`) VALUES
(1, 'Essen'),
(2, 'Videospiele'),
(3, 'Fischen'),
(4, 'Security'),
(5, 'Random'),
(6, 'Politik'),
(7, 'Programmieren'),
(8, 'Announcements'),
(9, 'Katzen'),
(10, 'Lustige Bilder');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` text NOT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp(),
  `SocialCredit` int(11) NOT NULL DEFAULT 0,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  `email` text DEFAULT NULL, 
  `passwordhash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`ID`, `username`, `DateCreated`, `SocialCredit`, `isadmin`, `email`, `passwordhash`) VALUES
(1, 'figgi', '2025-04-30', 0, 0, 'hans-jürgen@jurgen.de', ''),
(2, 'Gertruhde', '2025-04-30', 0, 0, 'gertruhde@vivopro.de', ''),
(3, 'admin', '2025-04-30', 0, 1, 'admin@admin.admin', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `kommentare`
--
ALTER TABLE `kommentare`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Post` (`PostID`),
  ADD KEY `UserPost` (`UserID`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Topic` (`TopicID`),
  ADD KEY `User` (`UserID`);

--
-- Indizes für die Tabelle `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `kommentare`
--
ALTER TABLE `kommentare`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `topic`
--
ALTER TABLE `topic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `kommentare`
--
ALTER TABLE `kommentare`
  ADD CONSTRAINT `Post` FOREIGN KEY (`PostID`) REFERENCES `posts` (`ID`),
  ADD CONSTRAINT `UserPost` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `Topic` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`ID`),
  ADD CONSTRAINT `User` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
