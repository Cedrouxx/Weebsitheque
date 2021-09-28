-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 sep. 2021 à 12:41
-- Version du serveur : 5.7.31
-- Version de PHP : 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `weebsitheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `artwork`
--

DROP TABLE IF EXISTS `artwork`;
CREATE TABLE IF NOT EXISTS `artwork` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `number_volume` int(5) NOT NULL,
  `type` enum('Manga','Anime') COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `artwork`
--

INSERT INTO `artwork` (`id`, `name`, `slug`, `author_id`, `number_volume`, `type`, `image`, `release_date`) VALUES
(2, 'Violet Evergarden', 'violet-evergarden', 1, 14, 'Anime', 'ressources/img/artwork/anime/violet-evergarden.jpg', '2018-01-11'),
(3, 'Chobits', 'chobits', 2, 8, 'Manga', 'ressources/img/artwork/manga/chobits.jpeg', '2020-01-15'),
(4, 'Kyoukai no Kanata', 'kyoukai-no-kanata', 1, 12, 'Anime', 'ressources/img/artwork/anime/kyoukai-no-kanata.jpg', '2013-12-19'),
(5, 'Made in abyss', 'made-in-abyss', 3, 13, 'Anime', 'ressources/img/artwork/anime/made-in-abyss.jpg', '2017-07-07'),
(6, 'L\'Enfant Du Dragon Fantôme', 'l-enfant-du-dragon-fantôme', 4, 1, 'Manga', 'ressources/img/artwork/manga/l-enfant-du-dragon-fantome.jpg', '2021-05-21'),
(10, 'Steins;Gate', 'steins-gate', 6, 25, 'Anime', 'ressources/img/artwork/anime/steins-gate.jpg', '2011-04-05'),
(12, 'The Rising of the Shield Hero', 'the-rising-of-the-shield-hero', 8, 19, 'Manga', 'ressources/img/artwork/manga/the-rising-of-the-shield-hero.jpg', '2016-04-14'),
(13, 'Kumo desu ga, nani ka?', 'kumo-desu-ga,-nani-ka', 9, 24, 'Anime', 'ressources/img/artwork/anime/kumo-desu-ga,-nani-ka.jpg', '2021-01-08'),
(14, 'Aime ton prochain', 'aime-ton-prochain', 10, 6, 'Manga', 'ressources/img/artwork/manga/aime-ton-prochain.jpg', '2015-09-15'),
(19, 'Miss Kobayashi\'s Dragon Maid', 'miss-kobayashi-s-dragon-maid', 1, 13, 'Anime', 'ressources/img/artwork/anime/miss-kobayashi-s-dragon-maid.jpg', '2017-01-11'),
(20, 'Fairy Tail', 'fairy-tail', 13, 63, 'Manga', 'ressources/img/artwork/anime/fairy-tail.jpg', '2006-08-02'),
(21, 'Full Métal Alchemist: Brotherwood', 'full-métal-alchemist--brotherwood', 5, 68, 'Anime', 'ressources/img/artwork/anime/full-métal-alchemist--brotherwood.jpg', '2009-04-05');

-- --------------------------------------------------------

--
-- Structure de la table `artwork_genre`
--

DROP TABLE IF EXISTS `artwork_genre`;
CREATE TABLE IF NOT EXISTS `artwork_genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artwork_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artwork_id` (`artwork_id`),
  KEY `genre_id` (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `artwork_genre`
--

INSERT INTO `artwork_genre` (`id`, `artwork_id`, `genre_id`) VALUES
(1, 3, 2),
(2, 2, 2),
(3, 2, 1),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(9, 10, 2),
(14, 10, 3),
(15, 13, 2),
(16, 14, 1),
(22, 19, 2),
(23, 20, 1),
(24, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'Kyoto animation'),
(2, 'Clamp'),
(3, 'Kinema Citrus'),
(4, 'Yukishiro Ichi'),
(5, 'Studio Bones'),
(6, 'White Fox'),
(7, 'Kinema Citrus'),
(8, 'Aiya Kyū'),
(9, 'Millepensee'),
(10, 'Chida Daisuke'),
(11, 'A-1 Pictures'),
(12, 'Wit Studio'),
(13, 'Hiro Mashima');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `note` int(2) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `artwork_id` (`artwork_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `artwork_id`, `note`, `content`, `created_at`) VALUES
(1, 1, 2, 10, 'Trop bien !!!', '2021-09-06 08:45:10'),
(4, 1, 3, 8, 'Bon manga', '2021-09-06 08:45:10'),
(5, 2, 2, 10, 'Le meilleur anime de tout les temps !', '2021-09-06 08:45:10'),
(6, 2, 4, 8, 'Super bien !!!', '2021-09-06 08:45:10'),
(7, 2, 6, 7, 'J\'ai lu que le 1er tome mais il est bien.\r\nJe recommande !', '2021-09-06 08:45:10'),
(8, 1, 5, 8, 'Vraiment Bien !!!\r\nRecommande.', '2021-09-06 08:45:10'),
(9, 2, 3, 7, 'Je ne l\'ai pas fini,\r\nmais j\'aime bien.', '2021-09-06 08:45:10'),
(10, 2, 10, 9, 'Un des meilleurs !', '2021-09-06 08:46:53'),
(11, 2, 10, 7, 'Vraiment très bien.', '2021-09-06 08:47:11'),
(12, 1, 13, 8, 'Très bonne anime !', '2021-09-15 11:56:15'),
(13, 1, 19, 6, 'Pas fini mais plutôt bien !', '2021-09-20 08:33:57');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Shounen'),
(2, 'Seinen'),
(3, 'Shoujo');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ressources/img/user/default.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `is_admin`, `image`) VALUES
(1, 'Admin', 'admin@admin.fr', '$2y$10$ggXPCPqvVF.GuJ.k3jWWouTDtRbXOvS2qJyuflOy6tKiaHdWu6Eq2', 1, 'ressources/img/user/admin.png'),
(2, 'Pomme', 'pomme@pomme.fr', '$2y$10$iHLkHuO/ujjkbsmHfge9quno5oGWXqlT8BDEOXEgqufo.fW6gMF4O', 0, 'ressources/img/user/pomme.png'),
(3, '<script>alert(\'pomme\')</script>', 'hack@gmail.com', '$2y$10$NhUqJV5bm9YgkevEcrpLre4qFUi3pFir7/zYehE/V2bKz5/.jE75O', 0, 'ressources/img/user/default.png'),
(4, 'Poire', 'poire@fruit.fr', '$2y$10$3wr7MkqKZpk6Btdt23SDQu6vtkl5xCJk/R5BoEgKjgNMjBfooOIXG', 0, 'ressources/img/user/default.png'),
(5, 'Je suis un nom super long', 'nomsuperlong@long.fr', '$2y$10$Vl0AuGkf9OG0QsdspLuDF.wGz4AwLt/J.5lMcuiLKG70zQghzbpyW', 0, 'ressources/img/user/default.png'),
(6, 'Cédrouxx;--', 'cedrouxx@cedrouxx.fr', '$2y$10$yOB6BjsPACExkXL2e/cQ8ug2uJz5ML5T4gCTjbls0RPcHOqkyFq4e', 0, 'ressources/img/user/default.png');

-- --------------------------------------------------------

--
-- Structure de la table `user_list`
--

DROP TABLE IF EXISTS `user_list`;
CREATE TABLE IF NOT EXISTS `user_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `status` enum('Undefined','To start','In progress','Stopped','Finished') COLLATE utf8_unicode_ci DEFAULT 'Undefined',
  PRIMARY KEY (`id`),
  KEY `artwork_id` (`artwork_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user_list`
--

INSERT INTO `user_list` (`id`, `user_id`, `artwork_id`, `status`) VALUES
(1, 1, 2, 'Finished'),
(5, 1, 13, 'To start'),
(6, 1, 10, 'Undefined'),
(7, 1, 21, 'Stopped'),
(9, 1, 6, 'In progress'),
(10, 1, 4, 'To start'),
(11, 2, 2, 'Undefined'),
(13, 2, 5, 'In progress'),
(14, 2, 4, 'Undefined'),
(15, 1, 3, 'Undefined'),
(19, 1, 19, 'Stopped');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `artwork`
--
ALTER TABLE `artwork`
  ADD CONSTRAINT `artwork_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- Contraintes pour la table `artwork_genre`
--
ALTER TABLE `artwork_genre`
  ADD CONSTRAINT `artwork_genre_ibfk_1` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`),
  ADD CONSTRAINT `artwork_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_list`
--
ALTER TABLE `user_list`
  ADD CONSTRAINT `user_list_ibfk_1` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`id`),
  ADD CONSTRAINT `user_list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
