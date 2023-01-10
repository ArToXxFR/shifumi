-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 10 jan. 2023 à 12:24
-- Version du serveur : 10.10.2-MariaDB
-- Version de PHP : 8.0.26

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
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`id`, `name`, `image`) VALUES
(1, 'Fry', '/medias/avatars/avatars_fry.png'),
(2, 'Calculon', '/medias/avatars/avatars_calculon.png'),
(3, 'Elzar', '/medias/avatars/avatars_elzar.png'),
(4, 'Farnsworth', '/medias/avatars/avatars_farnsworth.png'),
(5, 'Amy', '/medias/avatars/avatars_amy.png'),
(6, 'Hermes', '/medias/avatars/avatars_hermes.png'),
(7, 'Ignar', '/medias/avatars/avatars_ignar.png'),
(8, 'Kif', '/medias/avatars/avatars_kif.png'),
(9, 'Larry', '/medias/avatars/avatars_larry.png'),
(10, 'Le Diable', '/medias/avatars/avatars_le_diable.png'),
(11, 'Leela', '/medias/avatars/avatars_leela.png'),
(12, 'M\'man', '/medias/avatars/avatars_mman.png'),
(13, 'Nibbler', '/medias/avatars/avatars_nibbler.png'),
(14, 'Roberto', '/medias/avatars/avatars_roberto.png'),
(15, 'Scruffy', '/medias/avatars/avatars_scruffy.png'),
(16, 'Walt', '/medias/avatars/avatars_walt.png'),
(17, 'Zapp', '/medias/avatars/avatars_zapp.png'),
(18, 'Zoidberg', '/medias/avatars/avatars_zoidberg.png');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wins` int(11) DEFAULT 0,
  `looses` int(11) DEFAULT 0,
  `nuls` int(11) DEFAULT 0,
  `creation_account` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_first_game` timestamp NULL DEFAULT NULL,
  `date_last_game` timestamp NULL DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `avatar_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `wins`, `looses`, `nuls`, `creation_account`, `date_first_game`, `date_last_game`, `ip`, `avatar_id`) VALUES
(1, 'ArToXx', 'artoxxfr@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YUFraVh6ZHM2Nk8uZXZTcg$9B78MRK84Dvi3eQPrmTNvwt8EM9bR+69KIPVL6Mgav0', 3, 4, 3, '2023-01-10 12:07:18', '2023-01-10 12:20:30', '2023-01-10 12:23:32', '::1', 8),
(2, 'comptetest', 'test@test.fr', '$argon2id$v=19$m=65536,t=4,p=1$WXRKcGhIUnpRNjNmUkJFTg$U+WfRzfARi0Y4o/knQrtoJi+4AYv7MNLY3Y52JblE/E', 0, 0, 0, '2023-01-10 12:13:13', NULL, NULL, NULL, 6),
(3, 'azertyuiop', 'azertyuiop@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$R0gyc1dtbjhUUlgvaE1KWA$qfHklAu99xmm2oSFGngRzP8VqoxXburz5S3lUvi+tD0', 0, 0, 0, '2023-01-10 12:13:36', NULL, NULL, NULL, 1),
(4, 'aqwzsxedc', 'aqwzsxedc@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YmdUcXBXd2lXei8vcER3MA$sG5StNnhEz9D2iPaL5dV5heRTLK13b34Y9xR6Bsu7aQ', 0, 0, 0, '2023-01-10 12:13:59', NULL, NULL, NULL, 7),
(5, 'Emilien', 'emilien@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$djJ2V21WL1hHcnBLak1aZQ$Dt3WaXfZtm46HCMm43HMN+FFW4MuOeSAvUNpfq9NHKs', 0, 0, 0, '2023-01-10 12:14:29', NULL, NULL, NULL, 1),
(6, 'blablabla', 'blablabla@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$YjZqYjZqYXVVdWt1VEdGcA$/bvzgIdDNKft8zu7STRn8adc4l2XxW1+sK82Ol/ZARQ', 0, 0, 0, '2023-01-10 12:16:51', NULL, NULL, NULL, 11),
(7, 'azerty', 'azerty@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$V3JLb1pYUWREN3pMNXhSTQ$7pDM7xLiGuCCy+Lis37kgyaYSJrBT/kzcUOlFWi8lds', 0, 0, 0, '2023-01-10 12:17:40', NULL, NULL, NULL, 12),
(8, 'adf', 'adf@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$LnRCdFpRdVFQeUNQMlNtYQ$nZj4wQOywZ+E3u8ePV/8iheGxA+0t5Ch516DQP69Gwc', 0, 0, 0, '2023-01-10 12:18:24', NULL, NULL, NULL, 1),
(9, 'aaaaaa', 'aaaaaa@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$c3kuZG8wZzdqL3JERC5iLg$F8cXa9u7pZqP7bBGO7HRAQ2R/EnqzEQD3DVLOOQTQhg', 0, 0, 0, '2023-01-10 12:18:47', NULL, NULL, NULL, 1),
(10, 'bbbbbb', 'bbbbbb@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bk94Q09iV1VtT2VnazRtSA$vgovxctRkW8E8Ix9ryRdguL+tb2kJfBNNhbS+XD1ucQ', 0, 0, 0, '2023-01-10 12:19:15', NULL, NULL, NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
