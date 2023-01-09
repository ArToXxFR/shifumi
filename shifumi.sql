-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : lun. 09 jan. 2023 à 11:10
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`id`, `nom`, `image`) VALUES
(1, 'Fry', '/medias/avatars/avatars_fry.png'),
(2, 'Leela', '/medias/avatars/avatars_leela.png'),
(3, 'Amy', '/medias/avatars/avatars_amy.png'),
(4, 'Hermes', '/medias/avatars/avatars_hermes.png'),
(5, 'Kif', '/medias/avatars/avatars_kif.png'),
(6, 'Zoidberg', '/medias/avatars/avatars_zoidberg.png'),
(7, 'Farnsworth', '/medias/avatars/avatars_farnsworth.png'),
(8, 'Scruffy', '/medias/avatars/avatars_scruffy.png'),
(9, 'Nibbler', '/medias/avatars/avatars_nibbler.png'),
(10, 'Calculon', '/medias/avatars/avatars_calculon.png'),
(11, 'Zapp', '/medias/avatars/avatars_zapp.png'),
(12, 'M\'man', '/medias/avatars/avatars_mman.png'),
(13, 'Walt', '/medias/avatars/avatars_walt.png'),
(14, 'Larry', '/medias/avatars/avatars_larry.png'),
(15, 'Ignar', '/medias/avatars/avatars_ignar.png'),
(16, 'Roberto', '/medias/avatars/avatars_roberto.png'),
(17, 'Diable', '/medias/avatars/avatars_le_diable.png'),
(18, 'Elzar', '/medias/avatars/avatars_elzar.png');

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
  `creation_compte` timestamp NULL DEFAULT NULL,
  `date_first_game` timestamp NULL DEFAULT NULL,
  `date_last_game` timestamp NULL DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `stats`
--

INSERT INTO `stats` (`id`, `win`, `loose`, `nulle`, `id_user`, `creation_compte`, `date_first_game`, `date_last_game`, `ip`) VALUES
(2, 5, 4, 1, 9, NULL, '2023-01-09 10:54:07', NULL, '::1'),
(3, 1, 0, 0, 10, NULL, NULL, NULL, ''),
(4, 1, 0, 0, 11, NULL, NULL, NULL, ''),
(5, 1, 0, 0, 12, NULL, NULL, NULL, ''),
(6, 1, 0, 0, 13, NULL, NULL, NULL, ''),
(7, 1, 0, 0, 14, NULL, NULL, NULL, ''),
(8, 0, 1, 2, 15, NULL, '2023-01-08 20:36:58', NULL, ''),
(9, 0, 0, 0, 16, NULL, NULL, NULL, ''),
(10, 0, 0, 0, 17, NULL, NULL, NULL, ''),
(11, 1, 3, 0, 18, NULL, '2023-01-09 10:54:07', NULL, '::1'),
(12, 0, 0, 0, 19, NULL, NULL, NULL, ''),
(13, 0, 0, 0, 20, NULL, NULL, NULL, ''),
(16, 1, 1, 0, 30, '2023-01-09 10:38:14', '2023-01-09 11:07:09', '2023-01-09 11:08:41', '::1');

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `email`, `password`) VALUES
(9, 'ArToXx', 'artoxx@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dXYwUjNNU0h6Y1Bad2lMTg$mEsMAPDkjA5dr+E0qyvM0yYCT+vTgbg+pWSS/eA9fGk'),
(10, 'test', 'TEST@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$MGVhZDhlNzJ0S2VDcTVzLg$RxJ4jbC5XPPhnF3ZD+/1ZNZLiYFv8qys4lnU69Vi5Sg'),
(11, 'fdgfdg', 'test@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$aGo0TzA3d1hucEo5TVZFWg$Ia7z69Cco7Bf0zpWq2qqpsd95BMetGXzR19qx5sbV0Q'),
(13, 'emilien', 'emilien@emilien.cuny', '$argon2id$v=19$m=65536,t=4,p=1$b3NXcXNHTXRQOTFOc1Z4eQ$BMioR2LirPn3rGLAUcrQXGbhqIGkw2blUFmyBH5XHq8'),
(14, 'dada', 'dada@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YkhGRVp6UUd6Q284LzJvVA$CNRlZY9A7yvD3sX9EYR/tBhgAQTZC+F3GZcYu1fXQB8'),
(15, 'Emilien', 'artoxxfr@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$UXRsWnNHY25DRHlEN2ZWNw$guyomBItt5W73ow4TzQ6Mk99K52dLZ0t7mib5gFgYyI'),
(17, 'gdfgfdgfdgdf', 'sdfdsf@gdf.fr', '$argon2id$v=19$m=65536,t=4,p=1$UGJ1Ly9YZVBkOUdpL0hsMA$h3rxY3SrDYmzZ+2q5p6JO3qJSKIx88FHaqFvIdgLYGo'),
(18, 'ArToXx', 'sdfsdfdsfdfdfdddd@g.fr', '$argon2id$v=19$m=65536,t=4,p=1$TzA3eERhallkd2htOVFIbQ$hatPCfmLJpplv9Zt0hNYTf13BaJfgKs41jWydqmcwG8'),
(19, 'sdfdssss', 'artoxxfr@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$WnZQVGY4YS9OcTRHVkJnMg$CsJM7HujE8IlT3Kc+JfhErsg803sbWrPXzw1yx/Uns0'),
(20, 'Test', 'test@test.fr', '$argon2id$v=19$m=65536,t=4,p=1$czYvVktCVU9FeGZ4TFVMYg$BegSzeq6APgBn+KZXj18A+2LiLii1Pa9PK9t5+bfQtc'),
(30, 'comptetest', 'comptetest@test.com', '$argon2id$v=19$m=65536,t=4,p=1$Z285R1pETzlqZFZZRHJiQw$K1sordI3DuiBFoMVT+EMm6RVniq2KGRD+Or7DQ9dLqc');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_has_avatar`
--

DROP TABLE IF EXISTS `utilisateurs_has_avatar`;
CREATE TABLE IF NOT EXISTS `utilisateurs_has_avatar` (
  `id_utilisateurs` int(11) NOT NULL,
  `id_avatar` int(11) NOT NULL,
  PRIMARY KEY (`id_utilisateurs`,`id_avatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `utilisateurs_has_avatar`
--

INSERT INTO `utilisateurs_has_avatar` (`id_utilisateurs`, `id_avatar`) VALUES
(9, 1),
(14, 1),
(15, 3),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(30, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
