-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 06 mai 2021 à 10:06
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `stuliday`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(255) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`) VALUES
(1, 'Appartement'),
(2, 'Maison'),
(3, 'Colocation'),
(4, 'Camping');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_name` varchar(255) NOT NULL,
  `products_description` text NOT NULL,
  `products_price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `author` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`products_id`),
  KEY `fk_author_users` (`author`),
  KEY `fk_category_categories` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`products_id`, `products_name`, `products_description`, `products_price`, `created_at`, `author`, `category`) VALUES
(2, 'VCub', 'Un VÃ©lo sympathique que j\'ai \"empruntÃ©\" Ã  la mairie de Bordeaux', 50, '2021-04-29 10:25:28', 2, 2),
(5, 'Maison', 'Blanche', 600, '2021-05-03 10:00:31', 6, 2),
(6, 'T3', 'balcon, parking', 500, '2021-05-05 10:51:26', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` mediumtext NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'ROLE_USER',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(2, 'b', 'b@b.com', '$2y$10$uue3XF5KQNY5vkXUjJzdg.rzaNnfbej1ZNWj6B6mW5Ot1C2o3oq9i', 'ROLE_USER'),
(6, 'lam', 'llam@a.com', '$2y$10$dACz5cqLl4ERkCVaIWp8..98pSE/frxDk6kON9uVubnlAn2w3GvfG', 'ROLE_ADMIN'),
(7, 'c', 'c@c.com', '$2y$10$1ZcmBAmlkaMwpeqzWokO7uJgcRYVC12v9SKncjT9MwcgV4meh41Ce', 'ROLE_USER');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_author_users` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_category_categories` FOREIGN KEY (`category`) REFERENCES `categories` (`categories_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
