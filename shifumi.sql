-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 14 déc. 2022 à 17:44
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shifumi`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

DROP TABLE IF EXISTS `avatar`;
CREATE TABLE IF NOT EXISTS `avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`id`, `nom`, `image`) VALUES
(1, 'music-bender', './avatar/music-bender.png'),
(2, 'champagne-bender', './avatar/champagne-bender.png'),
(3, 'chic-bender', './avatar/chic-bender.png'),
(4, 'congrats-bender', './avatar/congrats-bender.png'),
(5, 'cut-bender', './avatar/cut-bender.png'),
(6, 'dancing-bender', './avatar/dancing-bender.png'),
(7, 'drunk-bender', './avatar/drunk-bender.png'),
(8, 'evil-bender', './avatar/evil-bender.png'),
(9, 'exorbitant-eyes-bender', './avatar/exorbitant-eyes.png'),
(10, 'explosion-bender', './avatar/explosion-bender.png'),
(11, 'fingers-bite-bender', './avatar/fingers-bite-bender.png'),
(12, 'heart-bender', './avatar/heart-bender.png'),
(13, 'hey-bender', './avatar/hey-bender.png'),
(14, 'laughing-bender', './avatar/laughing-bender.png'),
(15, 'love-bender', './avatar/love-bender.png'),
(16, 'money-bender', './avatar/money-bender.png'),
(17, 'noo-bender', './avatar/noo-bender.png'),
(18, 'robot-heart-bender', './avatar/robot-heart-bender.png'),
(19, 'rocket-bender', './avatar/rocket-bender.png'),
(20, 'sad-bender', './avatar/sad-bender.png'),
(21, 'sleeping-bender', './avatar/sleeping-bender.png'),
(22, 'smoking-drinking-bender', './avatar/smoking-drinking-bender.png'),
(23, 'smoking-bender', './avatar/smoking-bender.png'),
(24, 'soft-laugh-bender', './avatar/soft-laugh-bender.png'),
(25, 'sunbathing-bender.png', './avatar/surprised-bender.png'),
(26, 'tchin-bender-philip', './avatar/tchin-bender-philip.png'),
(27, 'terminator-bender', './avatar/terminator-bender.png'),
(28, 'the-gender-bender', './avatar/the-gender-bender'),
(29, 'thump-up-bender', './avatar/thump-up-bender.png');

-- --------------------------------------------------------

--
-- Structure de la table `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `win` int(11) NOT NULL DEFAULT '0',
  `loose` int(11) NOT NULL DEFAULT '0',
  `nulle` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  `date_first_game` timestamp NULL DEFAULT NULL,
  `date_last_game` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `stats`
--

INSERT INTO `stats` (`id`, `win`, `loose`, `nulle`, `id_user`, `date_first_game`, `date_last_game`) VALUES
(2, 0, 0, 0, 9, NULL, NULL),
(3, 0, 0, 0, 10, NULL, NULL),
(4, 0, 0, 0, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `email`, `password`) VALUES
(9, 'ArToXx', 'artoxx@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dXYwUjNNU0h6Y1Bad2lMTg$mEsMAPDkjA5dr+E0qyvM0yYCT+vTgbg+pWSS/eA9fGk'),
(10, 'test', 'TEST@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$MGVhZDhlNzJ0S2VDcTVzLg$RxJ4jbC5XPPhnF3ZD+/1ZNZLiYFv8qys4lnU69Vi5Sg'),
(11, 'fdgfdg', 'test@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$aGo0TzA3d1hucEo5TVZFWg$Ia7z69Cco7Bf0zpWq2qqpsd95BMetGXzR19qx5sbV0Q');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_has_avatar`
--

DROP TABLE IF EXISTS `utilisateurs_has_avatar`;
CREATE TABLE IF NOT EXISTS `utilisateurs_has_avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateurs` int(11) NOT NULL,
  `id_avatar` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateurs_has_avatar`
--

INSERT INTO `utilisateurs_has_avatar` (`id`, `id_utilisateurs`, `id_avatar`) VALUES
(1, 9, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
