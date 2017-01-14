-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Jeu 12 Janvier 2017 à 13:28
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `GreenHand`
--

-- --------------------------------------------------------

--
-- Structure de la table `achievement`
--

CREATE TABLE `achievement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `badge` varchar(255) NOT NULL DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `achievement`
--

INSERT INTO `achievement` (`id`, `title`, `description`, `badge`) VALUES
(1, 'Mangeur de patate', 'Tu as réussi le défi "Manger 5kg de patate"', 'default'),
(2, 'Coquin chauffant', 'Tu aimes faire l\'amour', 'love'),
(3, 'Héros', 'Tu as sauvé le monde au moins une fois', 'star');

-- --------------------------------------------------------

--
-- Structure de la table `challenge`
--

CREATE TABLE `challenge` (
  `id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateEnd` timestamp NULL DEFAULT NULL,
  `category` int(11) NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `challenge`
--

INSERT INTO `challenge` (`id`, `Title`, `Description`, `dateCreation`, `dateEnd`, `category`, `author`) VALUES
(1, 'Manger 5kilos de patates', 'C\'est un défi de test !', '2017-01-11 20:00:30', NULL, 1, 1),
(2, 'Faire l\'amour au lieu d\'allumer le chauffage', 'C\'est un test marrant :).', '2017-01-11 20:33:03', NULL, 1, 1),
(3, 'Sauver le monde', 'Pas facile... The princess is in an other castle !', '2017-01-11 20:34:57', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `challengeCategory`
--

CREATE TABLE `challengeCategory` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `challengeCategory`
--

INSERT INTO `challengeCategory` (`id`, `title`, `description`) VALUES
(1, 'Test', 'Cette catégorie ne contient que des défis factices');

-- --------------------------------------------------------

--
-- Structure de la table `challengeObjective`
--

CREATE TABLE `challengeObjective` (
  `id` int(11) NOT NULL,
  `instruction` text NOT NULL,
  `challenge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `challengeObjective`
--

INSERT INTO `challengeObjective` (`id`, `instruction`, `challenge`) VALUES
(1, 'Vaincre le boss final', 3),
(2, 'Mangez 5kg de patate en un jour.', 1),
(3, 'Faire l\'amour 5 fois dans la semaine', 2),
(4, 'Couper le chauffage pendant l\'amour', 2);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `recipient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `content`, `date`, `author`, `recipient`) VALUES
(1, 'Hello !', '2017-01-12 12:22:46', 1, 8),
(2, 'Hi friend !', '2017-01-12 12:22:56', 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `presentation` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` int(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `priceType` varchar(128) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `priceType`, `category`) VALUES
(1, 'Produit factice n°1', 'Produit qui n\'existe pas...', 0, '€', 1);

-- --------------------------------------------------------

--
-- Structure de la table `productCategory`
--

CREATE TABLE `productCategory` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `productCategory`
--

INSERT INTO `productCategory` (`id`, `title`, `description`) VALUES
(1, 'Test', 'Produits factices pour des tests');

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE `profils` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `birth` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profils`
--

INSERT INTO `profils` (`id`, `firstName`, `lastName`, `description`, `birth`, `gender`, `facebook`, `twitter`, `URL`, `user`) VALUES
(1, 'Mickaël', 'Boidin', 'Je suis l\'un des fondateurs de GreenHand', '2017-01-12', 1, 'mickastark13', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isProducer` tinyint(1) NOT NULL DEFAULT '0',
  `validationKey` varchar(32) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numConnection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `isAdmin`, `isProducer`, `validationKey`, `valid`, `name`, `dateRegistration`, `numConnection`) VALUES
(1, 'mickael@boidin.fr', 'v4Ww7kD2JOILAJCz1ulhsw==', 1, 0, 'd8926941f4df618530cf9ec181c3684a', 1, 'Mickaël', '2017-01-11 19:47:32', 0),
(8, 'mickael@boidin2.fr', 'urHUxyeJf91U60oJTiPGtQ==', 0, 0, '2a4d7dc61d5e7968e4b71cdbeed8ecfe', 1, 'fqsdfqsd', '2017-01-11 21:26:01', 4);

-- --------------------------------------------------------

--
-- Structure de la table `usersAchievementSuccess`
--

CREATE TABLE `usersAchievementSuccess` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `achievement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usersAchievementSuccess`
--

INSERT INTO `usersAchievementSuccess` (`id`, `user`, `achievement`) VALUES
(1, 1, 3),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `usersChallengeParticipation`
--

CREATE TABLE `usersChallengeParticipation` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `challenge` int(11) NOT NULL,
  `dateParticipation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateSuccess` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usersChallengeParticipation`
--

INSERT INTO `usersChallengeParticipation` (`id`, `user`, `challenge`, `dateParticipation`, `dateSuccess`) VALUES
(2, 1, 2, '2017-01-12 12:18:28', '2017-01-09 23:00:00'),
(3, 1, 1, '2017-01-12 12:18:28', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `usersObjectiveSuccess`
--

CREATE TABLE `usersObjectiveSuccess` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `objective` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usersObjectiveSuccess`
--

INSERT INTO `usersObjectiveSuccess` (`id`, `user`, `objective`) VALUES
(1, 1, 3),
(2, 1, 4);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `challenge`
--
ALTER TABLE `challenge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`author`),
  ADD KEY `category` (`category`);

--
-- Index pour la table `challengeCategory`
--
ALTER TABLE `challengeCategory`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `challengeObjective`
--
ALTER TABLE `challengeObjective`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge` (`challenge`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `recipient` (`recipient`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Index pour la table `productCategory`
--
ALTER TABLE `productCategory`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_2` (`user`),
  ADD KEY `user` (`user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `usersAchievementSuccess`
--
ALTER TABLE `usersAchievementSuccess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `achievement` (`achievement`);

--
-- Index pour la table `usersChallengeParticipation`
--
ALTER TABLE `usersChallengeParticipation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `challenge` (`challenge`);

--
-- Index pour la table `usersObjectiveSuccess`
--
ALTER TABLE `usersObjectiveSuccess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `objective` (`objective`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `achievement`
--
ALTER TABLE `achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `challenge`
--
ALTER TABLE `challenge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `challengeCategory`
--
ALTER TABLE `challengeCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `challengeObjective`
--
ALTER TABLE `challengeObjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `productCategory`
--
ALTER TABLE `productCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `usersAchievementSuccess`
--
ALTER TABLE `usersAchievementSuccess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `usersChallengeParticipation`
--
ALTER TABLE `usersChallengeParticipation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `usersObjectiveSuccess`
--
ALTER TABLE `usersObjectiveSuccess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `challenge`
--
ALTER TABLE `challenge`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `challengeCategory` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `challengeObjective`
--
ALTER TABLE `challengeObjective`
  ADD CONSTRAINT `fk_challenge_objective` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_user_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_recipient` FOREIGN KEY (`recipient`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category`) REFERENCES `productCategory` (`id`);

--
-- Contraintes pour la table `profils`
--
ALTER TABLE `profils`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `usersAchievementSuccess`
--
ALTER TABLE `usersAchievementSuccess`
  ADD CONSTRAINT `fk_achievement_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_achievement` FOREIGN KEY (`achievement`) REFERENCES `achievement` (`id`);

--
-- Contraintes pour la table `usersChallengeParticipation`
--
ALTER TABLE `usersChallengeParticipation`
  ADD CONSTRAINT `fk_challenge_participation` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`),
  ADD CONSTRAINT `fk_user_participation` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `usersObjectiveSuccess`
--
ALTER TABLE `usersObjectiveSuccess`
  ADD CONSTRAINT `fk_objective_user` FOREIGN KEY (`objective`) REFERENCES `challengeObjective` (`id`),
  ADD CONSTRAINT `fk_user_objective` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
