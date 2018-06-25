-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2018 at 10:46 AM
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
  `chemin` varchar(125) NOT NULL,
  `affiche` varchar(75) DEFAULT NULL,
  `titre` varchar(75) NOT NULL,
  `realisateur` varchar(30) DEFAULT NULL,
  `anneesortie` varchar(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`idfilm`, `chemin`, `affiche`, `titre`, `realisateur`, `anneesortie`) VALUES
(1, '../Films/Action/Leon.mp4', '../Films/affiche/Leon.jpg', 'Leon', 'Besson', '2000'),
(2, '../Films/Comedie/Asterix Et Obelix Mission Cleopatre.mp4', '../Films/affiche/Asterix Et Obelix Mission Cleopatre.jpg', 'Asterix Et Obelix Mission Cleopatre', NULL, NULL),
(3, '../Films/Comedie/La Folle Histoire de Max et Leon.mp4', '../Films/affiche/la folle histoire de max et leon.jpg', 'La Folle Histoire de Max et Leon', NULL, NULL),
(4, '../Films/Sciences_Fiction/King Kong.mp4', '../Films/affiche/king kong.jpg', 'King Kong', NULL, NULL),
(5, '../Films/Sciences_Fiction/Le village.mp4', '../Films/affiche/Le village.jpg', 'Le village', NULL, NULL),
(6, '../Films/Sciences_Fiction/Marvel/SpiderMan.mp4', '../Films/affiche/SpiderMan.jpg', 'SpiderMan', NULL, NULL),
(10, '../Films/Sciences_Fiction/Seigneur des anneaux/hobbit/The Hobbit 3 - Battle of the five armies.mp4', '../Films/affiche/The Hobbit 3 - Battle of the five armies.jpg', 'The Hobbit 3 - Battle of the five armies', NULL, NULL),
(11, '../Films/Comedie/OSS 117/OSS 117 - Rio ne repond plus.mp4', '../Films/affiche/OSS 117 - Rio ne repond plus.jpg', 'OSS 117 - Rio ne repond plus', NULL, NULL),
(12, '../Films/Comedie/OSS 117/OSS 117 Le Caire Nid d''Espions.mp4', '../Films/affiche/OSS 117 Le Caire Nid d''Espions.jpg', 'OSS 117 Le Caire Nid d''Espions', NULL, NULL),
(13, '../Films/Comedie/The Mask.mp4', '../Films/affiche/The Mask.jpg', 'The Mask', NULL, NULL),
(14, '../Films/Sciences_Fiction/Marvel/Captain America/Captain America - First Avenger.mp4', '../Films/affiche/Captain America - First Avenger.jpg', 'Captain America - First Avenger', NULL, NULL),
(15, '../Films/Sciences_Fiction/Marvel/Captain America/Captain America - Le soldat de l hiver.mp4', '../Films/affiche/Captain America - Le soldat de l hiver.jpg', 'Captain America - Le soldat de l hiver', NULL, NULL),
(16, '../Films/Sciences_Fiction/Marvel/Iron Man/Iron Man 2.mp4', '../Films/affiche/Iron Man 2.jpg', 'Iron Man 2', NULL, NULL),
(17, '../Films/Animes/myazaki/Le chateau ambulant.mp4', '../Films/affiche/Le chateau ambulant.jpg', 'Le chateau ambulant', NULL, NULL),
(18, '../Films/Animes/myazaki/Princesse Mononoke.mp4', '../Films/affiche/Princesse Mononoke.jpg', 'Princesse Mononoke', NULL, NULL),
(19, '../Films/Action/Fight Club.mp4', '../Films/affiche/Fight Club.jpg', 'Fight Club', NULL, NULL),
(20, '../Films/Action/Hannibal Lecter - Les Origines Du Mal.mp4', '../Films/affiche/Hannibal Lecter - Les Origines Du Mal.jpg', 'Hannibal Lecter - Les Origines Du Mal', NULL, NULL),
(21, '../Films/Animes/Walt disney/Lilo Et Stitch.mp4', '../Films/affiche/Lilo Et Stitch.jpg', 'Lilo Et Stitch', NULL, NULL),
(22, '../Films/Comedie/The Wolf Of Wall Street.mp4', '../Films/affiche/The Wolf Of Wall Street.jpg', 'The Wolf Of Wall Street', NULL, NULL),
(23, '../Films/Sciences_Fiction/Marvel/Thor.mp4', '../Films/affiche/Thor.jpg', 'Thor', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `historiqueFilms`
--

CREATE TABLE IF NOT EXISTS `historiqueFilms` (
`idhistorique` int(11) NOT NULL,
  `idfilm` int(11) NOT NULL,
  `idusr` smallint(6) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historiqueFilms`
--

INSERT INTO `historiqueFilms` (`idhistorique`, `idfilm`, `idusr`, `date`) VALUES
(51, 1, 5, '2018-06-15 11:53:19'),
(52, 1, 5, '2018-06-15 11:58:10'),
(53, 15, 5, '2018-06-15 12:38:57'),
(54, 15, 5, '2018-06-15 12:39:12'),
(55, 14, 5, '2018-06-15 12:39:19'),
(56, 14, 5, '2018-06-15 12:39:25'),
(57, 16, 5, '2018-06-15 12:39:33'),
(58, 16, 5, '2018-06-15 12:39:40'),
(59, 2, 5, '2018-06-15 12:40:11'),
(60, 2, 5, '2018-06-15 12:40:19'),
(61, 10, 5, '2018-06-15 12:43:43'),
(62, 10, 5, '2018-06-15 12:43:48'),
(63, 11, 5, '2018-06-15 12:46:59'),
(64, 12, 5, '2018-06-15 12:47:04'),
(84, 3, 5, '2018-06-15 13:35:21'),
(98, 3, 5, '2018-06-15 13:39:59'),
(99, 3, 5, '2018-06-15 13:40:10'),
(102, 19, 4, '2018-06-15 13:41:37'),
(103, 23, 4, '2018-06-15 13:41:42'),
(104, 20, 4, '2018-06-15 13:42:17'),
(105, 22, 4, '2018-06-15 13:42:43'),
(106, 21, 4, '2018-06-15 13:43:07'),
(107, 23, 4, '2018-06-15 13:43:20'),
(108, 23, 4, '2018-06-15 13:43:26'),
(109, 18, 4, '2018-06-15 13:43:59'),
(110, 21, 4, '2018-06-15 13:44:01'),
(111, 21, 4, '2018-06-15 13:44:06'),
(115, 3, 4, '2018-06-15 13:56:08'),
(116, 21, 4, '2018-06-15 14:01:43'),
(117, 1, 4, '2018-06-15 14:13:19'),
(118, 1, 4, '2018-06-15 14:13:20'),
(119, 2, 4, '2018-06-15 14:13:21'),
(120, 3, 4, '2018-06-15 14:26:43'),
(121, 11, 4, '2018-06-15 14:26:47'),
(123, 10, 4, '2018-06-15 14:38:03'),
(124, 21, 4, '2018-06-15 14:41:21'),
(133, 2, 5, '2018-06-15 22:30:10'),
(134, 23, 4, '2018-06-17 23:00:35'),
(135, 3, 4, '2018-06-18 20:54:07'),
(136, 21, 5, '2018-06-20 00:34:09'),
(137, 13, 5, '2018-06-23 10:15:03'),
(138, 23, 5, '2018-06-23 11:35:53'),
(139, 23, 5, '2018-06-23 11:37:05'),
(140, 23, 5, '2018-06-23 12:50:28'),
(141, 5, 5, '2018-06-24 11:41:53'),
(142, 5, 5, '2018-06-24 11:41:53'),
(143, 1, 5, '2018-06-24 12:02:48'),
(144, 1, 5, '2018-06-24 12:02:56'),
(145, 22, 5, '2018-06-24 12:09:42'),
(146, 10, 5, '2018-06-24 12:16:49'),
(147, 5, 7, '2018-06-24 13:15:26'),
(148, 5, 7, '2018-06-24 13:20:39'),
(149, 5, 7, '2018-06-24 13:20:39'),
(150, 6, 6, '2018-06-24 23:48:10'),
(151, 6, 6, '2018-06-24 23:48:15'),
(152, 1, 6, '2018-06-24 23:48:33'),
(153, 1, 6, '2018-06-24 23:48:39'),
(154, 1, 5, '2018-06-24 23:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `occurenceTags`
--

CREATE TABLE IF NOT EXISTS `occurenceTags` (
`idOccurence` int(11) NOT NULL,
  `idFilm` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `occurenceTags`
--

INSERT INTO `occurenceTags` (`idOccurence`, `idFilm`, `idTag`) VALUES
(2, 11, 3),
(3, 12, 3),
(4, 6, 1),
(5, 1, 27),
(6, 14, 1),
(7, 15, 1),
(8, 16, 1),
(9, 17, 28),
(10, 18, 28),
(11, 17, 29),
(12, 18, 29),
(13, 15, 30),
(14, 14, 30),
(15, 16, 31),
(16, 2, 32),
(17, 10, 12),
(18, 23, 1),
(19, 21, 29);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`idTag` int(11) NOT NULL,
  `nomTag` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`idTag`, `nomTag`) VALUES
(1, 'marvel'),
(2, 'disney'),
(3, 'oss'),
(4, 'action'),
(5, 'comedie'),
(6, 'star-wars'),
(7, 'science-fiction'),
(8, 'super-heros'),
(9, 'ww2'),
(10, 'ww1'),
(11, 'USA'),
(12, 'tolkien'),
(27, 'Besson'),
(28, 'ghibli'),
(29, 'anime'),
(30, 'captain-america'),
(31, 'iron-man'),
(32, 'asterix');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
`idusr` int(2) NOT NULL,
  `login` varchar(20) NOT NULL,
  `passwd` varchar(20) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `statut` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idusr`, `login`, `passwd`, `prenom`, `nom`, `statut`) VALUES
(4, 'root', 'toor', 'Martin', 'BORDE', 'admin'),
(5, 'martin', 'nitram', 'Martin', 'BORDE', 'user'),
(6, 'sara', '517xod87', 'Sara', 'CALAFURI', 'user'),
(7, 'christian', 'christian', '', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
 ADD PRIMARY KEY (`idfilm`);

--
-- Indexes for table `historiqueFilms`
--
ALTER TABLE `historiqueFilms`
 ADD PRIMARY KEY (`idhistorique`);

--
-- Indexes for table `occurenceTags`
--
ALTER TABLE `occurenceTags`
 ADD PRIMARY KEY (`idOccurence`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`idTag`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
 ADD PRIMARY KEY (`idusr`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
MODIFY `idfilm` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `historiqueFilms`
--
ALTER TABLE `historiqueFilms`
MODIFY `idhistorique` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `occurenceTags`
--
ALTER TABLE `occurenceTags`
MODIFY `idOccurence` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `idTag` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
MODIFY `idusr` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
