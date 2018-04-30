-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2018 at 11:55 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `site_martin`
--

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `idfilm` int(6) NOT NULL,
  `chemin` varchar(100) NOT NULL,
  `affiche` varchar(50) DEFAULT NULL,
  `titre` varchar(50) NOT NULL,
  `realisateur` varchar(30) DEFAULT NULL,
  `anneesortie` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`idfilm`, `chemin`, `affiche`, `titre`, `realisateur`, `anneesortie`) VALUES
(1, 'film/superheros', 'deadpool.jpg', 'Deadpool', 'Thanos', '2012'),
(2, 'film/', 'megaman.jpg', 'Megaman', 'Micheal Bay', '1971'),
(3, 'animation/gibli', 'totoro.jpeg', 'Mon voisin Totoro', 'gibli', '2005'),
(4, '../images/BigBuckBunny_320x180.mp4', NULL, 'Big Buck Bunny', NULL, NULL),
(5, '../images/MitchiriNekoMarch.webm', NULL, 'Michiri Neko March', 'youtube', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idusr` int(2) NOT NULL,
  `login` varchar(20) NOT NULL,
  `passwd` varchar(20) NOT NULL,
  `statut` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idusr`, `login`, `passwd`, `statut`) VALUES
(3, 'nico-lait', 'tailocin', 'user'),
(4, 'root', 'toor', 'admin'),
(5, 'martin', 'nitram', 'user'),
(6, 'sara', '517xod87', 'user'),
(8, 'ambretagne', 'chouchen', 'user'),
(9, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`idfilm`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idusr`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `idfilm` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idusr` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
