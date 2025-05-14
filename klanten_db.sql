-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 14 mei 2025 om 10:44
-- Serverversie: 8.0.41
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klanten_db`
--

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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

DROP TABLE IF EXISTS `gebruikers`;
CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `username`, `email`, `password`, `role_id`, `created_at`) VALUES
(5, 'Jan Simons', 'Jan.Simons@Student.GildeOpleidingen.nl', '$2y$10$gBWwZG7VTOxxtnVFRoaTtOBM.howf44V0XQbV98dDlygtMXvKQYTi', 1, '2025-05-11 12:20:57');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

DROP TABLE IF EXISTS `klanten`;
CREATE TABLE IF NOT EXISTS `klanten` (
  `naam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(50) DEFAULT NULL,
  `bedrijf` varchar(100) NOT NULL,
  `functie` varchar(100) NOT NULL,
  `telefoon` varchar(20) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bericht` text NOT NULL,
  `datum` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerkers`
--

DROP TABLE IF EXISTS `medewerkers`;
CREATE TABLE IF NOT EXISTS `medewerkers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(20) DEFAULT NULL,
  `geboortedatum` date DEFAULT NULL,
  `functie` varchar(100) DEFAULT NULL,
  `werkmail` varchar(150) DEFAULT NULL,
  `kantoorruimte` varchar(50) DEFAULT NULL,
  `datum_ingediend` datetime DEFAULT CURRENT_TIMESTAMP,
  `gebruikers_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gebruikers_id` (`gebruikers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Medewerker'),
(2, 'Afdelingshoofd');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gebruiker_id` int NOT NULL,
  `aantal_uren` decimal(5,2) NOT NULL,
  `projectnaam` varchar(100) NOT NULL,
  `omschrijving` text NOT NULL,
  `datum` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_gebruiker` (`gebruiker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`id`, `gebruiker_id`, `aantal_uren`, `projectnaam`, `omschrijving`, `datum`) VALUES
(3, 5, 3.00, 'd', 'd', '2025-05-11 15:36:45'),
(4, 5, 32.00, '32', '32', '2025-05-12 09:00:24'),
(5, 5, 4.00, '4', '4', '2025-05-12 09:32:08'),
(6, 5, 3.00, 'f', 'f', '2025-05-12 10:26:44');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Beperkingen voor tabel `medewerkers`
--
ALTER TABLE `medewerkers`
  ADD CONSTRAINT `medewerkers_ibfk_1` FOREIGN KEY (`gebruikers_id`) REFERENCES `gebruikers` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `werkzaamheden`
--
ALTER TABLE `werkzaamheden`
  ADD CONSTRAINT `fk_gebruiker` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
