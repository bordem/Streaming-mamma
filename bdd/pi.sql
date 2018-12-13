-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 13 Décembre 2018 à 20:37
-- Version du serveur :  5.7.23-0ubuntu0.18.04.1
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pi`
--

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `idfilm` int(6) NOT NULL,
  `chemin` varchar(125) NOT NULL,
  `affiche` varchar(75) DEFAULT NULL,
  `titre` varchar(75) NOT NULL,
  `realisateur` varchar(30) DEFAULT NULL,
  `anneesortie` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `films`
--

INSERT INTO `films` (`idfilm`, `chemin`, `affiche`, `titre`, `realisateur`, `anneesortie`) VALUES
(82, '../Films/Action/Iron man.ogv', '../Films/affiche/Iron man.jpg', 'Iron man', NULL, NULL),
(83, '../Films/BigBuckBunny.mp4', '../Films/affiche/BigBuckBunny.jpg', 'BigBuckBunny', NULL, NULL),
(84, '../Films/disque.mp4', '../Films/affiche/disque.jpg', 'disque', NULL, NULL),
(85, '../Films/output.ogv', '../Films/affiche/output.jpg', 'output', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `historiqueFilms`
--

CREATE TABLE `historiqueFilms` (
  `idhistorique` int(11) NOT NULL,
  `idfilm` int(11) NOT NULL,
  `idusr` smallint(6) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `historiqueFilms`
--

INSERT INTO `historiqueFilms` (`idhistorique`, `idfilm`, `idusr`, `date`) VALUES
(147, 5, 7, '2018-06-24 13:15:26'),
(148, 5, 7, '2018-06-24 13:20:39'),
(149, 5, 7, '2018-06-24 13:20:39'),
(150, 6, 6, '2018-06-24 23:48:10'),
(151, 6, 6, '2018-06-24 23:48:15'),
(152, 1, 6, '2018-06-24 23:48:33'),
(153, 1, 6, '2018-06-24 23:48:39'),
(386, 11, 4, '2018-09-17 15:49:07'),
(387, 6, 4, '2018-09-17 15:50:52'),
(388, 3, 4, '2018-09-17 15:53:37'),
(389, 26, 4, '2018-09-17 15:53:57'),
(390, 25, 4, '2018-09-17 15:54:39'),
(391, 24, 4, '2018-09-17 15:55:06'),
(407, 1, 5, '2018-12-06 00:00:30'),
(408, 6, 5, '2018-12-06 00:00:40'),
(409, 24, 5, '2018-12-06 00:01:04'),
(410, 27, 4, '2018-12-09 01:51:05'),
(411, 27, 4, '2018-12-09 01:51:30'),
(412, 28, 4, '2018-12-09 01:57:34'),
(413, 31, 4, '2018-12-09 02:35:35'),
(414, 77, 4, '2018-12-09 13:32:39'),
(415, 80, 4, '2018-12-09 14:19:48'),
(416, 80, 4, '2018-12-09 14:19:56'),
(417, 80, 4, '2018-12-09 14:26:59'),
(418, 77, 4, '2018-12-09 14:33:47'),
(419, 80, 4, '2018-12-09 14:46:57'),
(420, 78, 4, '2018-12-09 14:47:14'),
(421, 80, 4, '2018-12-09 14:47:43'),
(422, 80, 4, '2018-12-09 14:57:41'),
(423, 79, 5, '2018-12-09 16:19:21'),
(424, 79, 5, '2018-12-09 16:19:50'),
(425, 79, 5, '2018-12-09 18:45:40'),
(426, 79, 4, '2018-12-09 18:45:55'),
(427, 79, 4, '2018-12-09 18:46:20'),
(428, 80, 4, '2018-12-09 18:47:13'),
(429, 77, 5, '2018-12-09 18:57:16'),
(430, 77, 4, '2018-12-09 18:57:29'),
(431, 77, 4, '2018-12-09 18:57:41'),
(432, 80, 5, '2018-12-09 22:31:14'),
(433, 80, 4, '2018-12-09 22:32:24'),
(434, 81, 4, '2018-12-09 22:34:27'),
(435, 79, 4, '2018-12-09 22:34:45'),
(436, 82, 4, '2018-12-09 22:36:20'),
(437, 82, 5, '2018-12-12 00:23:36'),
(438, 83, 5, '2018-12-13 19:28:11');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `idNote` int(11) NOT NULL,
  `idFilm` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `occurenceTags`
--

CREATE TABLE `occurenceTags` (
  `idOccurence` int(11) NOT NULL,
  `idFilm` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `occurenceTags`
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
(19, 21, 29),
(20, 1, 4),
(21, 3, 5),
(22, 80, 4);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `idTag` int(11) NOT NULL,
  `nomTag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tags`
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
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idusr` int(2) NOT NULL,
  `login` varchar(20) NOT NULL,
  `passwd` varchar(75) NOT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `statut` varchar(10) NOT NULL DEFAULT 'user',
  `imagePath` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idusr`, `login`, `passwd`, `prenom`, `nom`, `statut`, `imagePath`) VALUES
(4, 'root', '*9CFBBC772F3F6C106020035386DA5BBBF1249A11', '', '', 'admin', ''),
(5, 'martin', '*055872A86A14E1368C812ACF51011419D0D2D70F', 'martin', 'BORDE', 'user', '1.jpg'),
(6, 'sara', '*05643D3B94B8EBF172C01E96A70FB0EE8B452AD4', 'Sara', 'CALAFURI', 'user', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`idfilm`);

--
-- Index pour la table `historiqueFilms`
--
ALTER TABLE `historiqueFilms`
  ADD PRIMARY KEY (`idhistorique`);

--
-- Index pour la table `occurenceTags`
--
ALTER TABLE `occurenceTags`
  ADD PRIMARY KEY (`idOccurence`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`idTag`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idusr`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `idfilm` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT pour la table `historiqueFilms`
--
ALTER TABLE `historiqueFilms`
  MODIFY `idhistorique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;
--
-- AUTO_INCREMENT pour la table `occurenceTags`
--
ALTER TABLE `occurenceTags`
  MODIFY `idOccurence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `idTag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idusr` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
