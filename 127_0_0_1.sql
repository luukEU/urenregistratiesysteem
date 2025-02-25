-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 25 feb 2025 om 12:23
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bedrijf`
--
CREATE DATABASE IF NOT EXISTS `bedrijf` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `bedrijf`;
--
-- Database: `klanten_db`
--
CREATE DATABASE IF NOT EXISTS `klanten_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `klanten_db`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `aanvragen`
--

DROP TABLE IF EXISTS `aanvragen`;
CREATE TABLE IF NOT EXISTS `aanvragen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `klantnaam` varchar(100) NOT NULL,
  `titel` varchar(150) NOT NULL,
  `omschrijving` text NOT NULL,
  `aanvraagdatum` date NOT NULL,
  `kennis` varchar(255) NOT NULL,
  `aanmaakdatum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `aanvragen`
--

INSERT INTO `aanvragen` (`id`, `klantnaam`, `titel`, `omschrijving`, `aanvraagdatum`, `kennis`, `aanmaakdatum`) VALUES
(7, 'luuk theelen', 'console kabel', 'kabel voor de console ', '2025-02-19', 'geen', '2025-02-18 08:54:54'),
(6, 'luuk theelen', 'HDMI kabel', 'kabel aangevraagd', '2025-02-06', 'geen', '2025-02-18 08:53:37');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

DROP TABLE IF EXISTS `klanten`;
CREATE TABLE IF NOT EXISTS `klanten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(50) DEFAULT NULL,
  `bedrijf` varchar(100) NOT NULL,
  `functie` varchar(100) NOT NULL,
  `telefoon` varchar(20) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bericht` text NOT NULL,
  `datum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id`, `naam`, `tussenvoegsel`, `bedrijf`, `functie`, `telefoon`, `adres`, `email`, `bericht`, `datum`) VALUES
(10, 'test', '', 'test', 'test', '+31 588930867893', 'test', 'luuktheelen225@gmail.com', 'dadfadf', '2025-02-17 12:14:45'),
(9, 'michiel', '', 'gilde', 'stoorzender', '5832735278519', 'duitsland', 'michiel225@gmail.com', 'beste icters zijn lui', '2025-02-12 13:00:45'),
(8, 'luuk', '', 'citaverde', 'testing', '+31 588930867893', '6000fv', 'gagsdgafdsgdf@gmail.com', 'test', '2025-02-12 10:12:36'),
(7, 'luuk', 'ddadsa', 'dsada', 'dada', 'dadas', 'asdas', 'dada@gmail', 'ffsdfs', '2025-02-11 10:43:20'),
(6, 'luuk', 'sFDSFSD', 'funtis', 'testing', '+31 588930867893', 'fsfadsafsa', 'fjngjkeng@gmal', 'fdededffaa', '2025-02-10 11:42:23'),
(11, 'Raymond Van Hillegom', 'van', 'RayIT', 'Owner', '0645860168', 'sdfjodefjoiwj', 'rmarx@rayit.com', 'Ik wil', '2025-02-24 11:56:09');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerkers`
--

DROP TABLE IF EXISTS `medewerkers`;
CREATE TABLE IF NOT EXISTS `medewerkers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(50) DEFAULT NULL,
  `geboortedatum` date NOT NULL,
  `functie` varchar(100) NOT NULL,
  `werkmail` varchar(100) NOT NULL,
  `kantoorruimte` varchar(50) NOT NULL,
  `datum_ingediend` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `werkmail` (`werkmail`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `medewerkers`
--

INSERT INTO `medewerkers` (`id`, `naam`, `tussenvoegsel`, `geboortedatum`, `functie`, `werkmail`, `kantoorruimte`, `datum_ingediend`) VALUES
(9, 'Sem Kaimer', '', '2008-02-12', 'SD', 'sem.kaimer@student.gildeopleidingen.nl', 'B109', '2025-02-18 08:22:40'),
(8, 'Kyano Wolters', '', '2007-02-16', 'ITSD', 'kyano.wolters@student.gildeopleidingen.nl', 'B109', '2025-02-18 08:17:22'),
(7, 'Luuk Theelen ', '', '2006-04-18', 'SD', 'luuk.theelen@student.gildeopleidingen.nl', 'B109', '2025-02-18 08:16:20'),
(10, 'Milan Buijel', '', '2007-04-30', 'ITSD', 'milan.buijel@student.gildeopleidingen.nl', 'B109', '2025-02-18 08:39:49'),
(11, 'stan wit', 'de', '2008-05-16', 'ITSD', 'stan.de.wit@student.gildeopleidingen.nl', 'B109', '2025-02-18 08:44:24');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `tussenvoegsel` varchar(50) DEFAULT NULL,
  `aantal_uren` int NOT NULL,
  `projectnaam` varchar(255) NOT NULL,
  `omschrijving` text NOT NULL,
  `datum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`id`, `naam`, `tussenvoegsel`, `aantal_uren`, `projectnaam`, `omschrijving`, `datum`) VALUES
(1, 'test', '', 4, 'ffsafs', 'dsasda', '2025-02-10 10:28:31'),
(2, 'dsda', '', 5, 'fsaa', 'ccas', '2025-02-17 12:23:24');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
