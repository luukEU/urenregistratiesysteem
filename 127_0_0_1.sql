-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 11 feb 2025 om 09:00
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `aanvragen`
--

INSERT INTO `aanvragen` (`id`, `klantnaam`, `titel`, `omschrijving`, `aanvraagdatum`, `kennis`, `aanmaakdatum`) VALUES
(1, 'fwbhjfsf', 'vliegtuig', 'gsdggfdgfd', '2025-02-12', 'gdfgfdgfd', '2025-02-10 10:57:25');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`id`, `naam`, `tussenvoegsel`, `bedrijf`, `functie`, `telefoon`, `adres`, `email`, `bericht`, `datum`) VALUES
(6, 'luuk', 'sFDSFSD', 'funtis', 'testing', '+31 588930867893', 'fsfadsafsa', 'fjngjkeng@gmal', 'fdededffaa', '2025-02-10 11:42:23');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `medewerkers`
--

INSERT INTO `medewerkers` (`id`, `naam`, `tussenvoegsel`, `geboortedatum`, `functie`, `werkmail`, `kantoorruimte`, `datum_ingediend`) VALUES
(1, 'luuk', 'sFDSFSD', '2025-01-31', 'testing', 'ffsgdasgSD@GMAIL.COM', 'DSgsGS', '2025-02-10 10:54:23'),
(2, 'luuk', '', '2025-02-20', 'testing', 'ffsgdasgdfdggSD@GMAIL.COM', 'DSgsGS', '2025-02-10 10:57:11');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`id`, `naam`, `tussenvoegsel`, `aantal_uren`, `projectnaam`, `omschrijving`, `datum`) VALUES
(1, 'test', '', 4, 'ffsafs', 'dsasda', '2025-02-10 10:28:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
