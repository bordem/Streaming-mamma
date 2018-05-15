-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2018 at 10:19 AM
-- Server version: 5.5.59-0+deb8u1
-- PHP Version: 5.6.33-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pi`
--

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE IF NOT EXISTS `films` (
`idfilm` int(6) NOT NULL,
  `chemin` varchar(50) NOT NULL,
  `affiche` varchar(50) DEFAULT NULL,
  `titre` varchar(50) NOT NULL,
  `realisateur` varchar(30) DEFAULT NULL,
  `anneesortie` varchar(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`idfilm`, `chemin`, `affiche`, `titre`, `realisateur`, `anneesortie`) VALUES
(1, 'film/superheros', 'deadpool.jpg', 'Deadpool', 'Thanos', '2012'),
(2, 'film/', 'megaman.jpg', 'Megaman', 'Micheal Bay', '1971'),
(3, 'animation/gibli', 'totoro.jpg', 'Mon voisin Totoro', 'gibli', '2005'),
(4, '../images/BigBuckBunny_320x180.mp4', NULL, 'Big Buck Bunny', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
 ADD PRIMARY KEY (`idfilm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
MODIFY `idfilm` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
