-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 24 Janvier 2017 à 11:50
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `greenhand`
--

-- --------------------------------------------------------

--
-- Structure de la table `achievement`
--

CREATE TABLE IF NOT EXISTS `achievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `badge` varchar(255) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `achievement`
--

INSERT INTO `achievement` (`id`, `title`, `description`, `badge`) VALUES
(1, 'Mangeur de patate', 'Tu as réussi le défi "Manger 5kg de patate"', 'badge'),
(2, 'Coquin chauffant', 'Tu aimes faire l''amour', 'love'),
(3, 'Héros', 'Tu as sauvé le monde au moins une fois', 'star'),
(4, 'Fast Food Pro', '', 'default');

-- --------------------------------------------------------

--
-- Structure de la table `challenge`
--

CREATE TABLE IF NOT EXISTS `challenge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateEnd` timestamp NULL DEFAULT NULL,
  `category` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `achievement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`author`),
  KEY `category` (`category`),
  KEY `achievement` (`achievement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `challenge`
--

INSERT INTO `challenge` (`id`, `title`, `description`, `dateCreation`, `dateEnd`, `category`, `author`, `achievement`) VALUES
(5, 'Je me mets au pain de savon', 'Si le savon de type savon de Marseille ou d’Alep est 100% biodégradable, c’est loin d’être le cas pour le gel douche. Les nombreux produits chimiques entrant dans sa composition nécessitent un retraitement en station d’épuration. Les flacons plastiques contenant le gel douche génèrent des tonnes de déchets chaque année. Une famille de 4 personnes génère près de 3 kg de déchets plastiques pour la seule utilisation de gel douche. A contrario, le savon en pain c’est quasiment zéro emballage !\r\n\r\nDû à son faible coût, l’huile de palme est fréquemment utilisée dans l’agroalimentaire (céréales, margarine, biscuits, crèmes glacées…) et les cosmétiques comme le savon ou le gel douche. Or, cette consommation démesurée engendre la déforestation des forêts d’Asie du sud-est et d’Afrique centrale au profit de plantations de palmiers à huile.\r\n\r\nUne véritable catastrophe écologique en termes d’impact sur la biodiversité.\r\n\r\nOpter pour un pain de savon, bio de préférence, c''est remédier à toutes ces problématiques, sans même y penser au quotidien. Les gels douche contiennent aussi très souvent de l''alcool, qui a tendance à assécher la peau, vous obligeant à compenser avec d''autres produits hydratants.\r\n\r\n\r\n\r\nProduits conseillés\r\nSavon au lait d''ânesse bio sans parfum (3€)\r\n\r\nLes savons SoapWalla\r\n', '2017-01-23 15:23:27', NULL, 1, 8, 1),
(6, 'J’apprends à éviter l’huile de palme', 'Plus de 8,7 millions hectares de forêt ont été rasés en Indonésie, en Malaisie et en Papouasie-Nouvelle-Guinée, au profit des cultures de palmiers à huile depuis 1990. Si la production d''huile de palme continue à ce rythme, il est probable que les orang-outangs aient complètement disparu à l’état sauvage dans 20 ans.\r\n\r\nDe manière générale, gardez en tête que 85% des aliments industriels comme les plats préparés, les gâteaux en barquette, les sauces, contiennent de l''huile de palme.\r\n\r\nPréférez des produits à base d''autres huiles végétales, comme le colza ou le coprah (noix de coco). Attention, dans certaines listes d''ingrédients la simple mention "huile végétale" ne vous garantit pas que le produit ne contienne pas d''huile de palme.\r\n\r\nAussi, sachez l''huile de palme bio n''est pas meilleure pour l''environnement et que beaucoup de gens vivent très bien en se passant de Nutella !', '2017-01-23 15:29:07', NULL, 1, 8, 1),
(7, 'Je branche mes appareils électriques sur une multiprise avec interrupteur', '11% de notre consommation électrique annuelle provient des appareils en veille, soit la production de deux réacteurs nucléaires. \r\n\r\nTélévision, lecteur DVD, box internet, ordinateur, radio-réveil, l''impact est énorme, et surtout inutile.\r\n\r\nUne solution simple est de brancher les chargeurs sur une multi-prise munie d''un interrupteur. Ainsi, vous pourrez couper rapidement l''alimentation de tous vos appareils !\r\n', '2017-01-23 15:29:07', NULL, 1, 8, 1),
(8, 'Je colle un autocollant STOP PUB sur ma boite aux lettres', 'En France, chaque foyer reçoit en moyenne 31 kilogrammes de publicité non adressée par an dans sa boîte aux lettres.\r\n\r\nColler un sticker sur sa boîte aux lettres permet de réduire de 80% le nombre de prospectus.\r\n\r\nVous pouvez très bien le dessiner vous-même, ou télécharger les modèles existants comme ceux du Ministère de l''Écologie (on vient de vous les envoyer par email).\r\n', '2017-01-23 15:31:10', NULL, 1, 8, 1),
(9, 'J''ajoute un "Stop douche" sur mon pommeau', 'Non, vous n''avez pas besoin que l''eau coule pendant que vous vous savonnez les cheveux. Mais oui, c''est parfois fastidieux de devoir régler la bonne température toutes les cinq secondes.\r\n\r\nPour 5€, vous pouvez installer un petit accessoire avant votre pommeau de douche qui vous permettra de couper le débit d''eau tout en conservant votre température. Il vous suffit de le visser entre votre pommeau et votre flexible de douche. Si vous pensiez acheter un nouveau flexible, il en existe désormais qui intègre directement des économiseurs d''eau !\r\n', '2017-01-23 15:31:10', NULL, 1, 8, 1),
(10, 'Je tiens 1 semaine sans manger de viande', 'Entre 1970 et 2009 la consommation de viande est passée de 25 kg par personne et par an à 38 kg. Or il faut 10 000 litres d''eau pour produire 1 kilo de boeuf. La culture du soja, en majorité au Brésil, nécessaire pour nourrir le bétail, ainsi que l''administration d''antibiotiques pour protéger les bêtes des maladies qui se développent par la promiscuité dans les évelages, sont autant de questions qui pèsent sur la production de viande. Sans compter que 25% de la production mondiale n''est tout simplement pas mangée.\r\n\r\nSe passer de viande, c''est aussi s''ouvrir à une gastronomie méconnue, sans oublier les économies non négligeables que vous pourrez réaliser.\r\n\r\nSurtout, arrêter la viande ça ne veut pas dire remplacer son steak par du tofu. C''est développer de nouvelles manières de s''alimenter.\r\n\r\nQue ce soit pour une semaine ou pour la vie, que ce soit pour en manger moins ou ne plus en manger du tout, interroger sa consommation de viande c''est un passage important dans la transition.', '2017-01-23 15:32:26', NULL, 1, 8, 1),
(11, 'J''achète du vinaigre blanc', 'Faire le ménage, ça peut paraître anodin, mais l''impact environnemental est conséquent. Les produits chimiques voire toxiques qu''on utilise nécessitent d''être traités longuement avant de pouvoir être rejetés dans les rivières. Aussi, les multiples emballages représentent une pollution de plus. Sans parler du coût de ces produits toujours plus dégraissant, toujours plus éclatants, toujours plus blancs.\r\n\r\nSi vous essayez, vous allez vous rendre compte qu''avec du vinaigre blanc vous pouvez laver la grande majorité de votre intérieur. Ajoutez un peu de bicarbonate de soude pour les tâches tenaces.', '2017-01-23 15:32:26', NULL, 1, 8, 1),
(12, 'Je mets un sac de course réutilisable dans mn sac à main', 'Environ 80 % des sacs plastiques ne sont ni triés ni recyclés. Composés de pétrole, ils ne se dégradent pas avant 100 à 400 ans et leur poids les rend très susceptibles de s''envoler pour aller polluer les milieux naturels. Sur les 5000 kilomètres de côtes du littoral français, on estime à 122 millions le nombre de sacs plastiques abandonnés et ils sont responsables de la mort de milliers d''espèces marines chaque année.\r\n\r\nDésormais, tous les magasins d''alimentation proposent des sacs pliables réutilisables pour quelques euros, qu''il sera facile d''avoir toujours avec vous pour le moment où vous en aurez besoin !\r\n', '2017-01-23 15:34:05', NULL, 1, 8, 1),
(13, 'Je m''achète une gourde à eau', 'La France est le premier producteur mondial d''eau en bouteille.\r\n\r\nSaviez-vous que la France est le premier producteur de bouteille d''eau en plastique au monde, avec 5,5 milliards de bouteilles vendues chaque année ? Il faut de l''énergie pour les produire, les transporter puis les recycler : une bouteille en plastique parcourt en moyenne 300km de l''embouteillage au recyclage. \r\n\r\nOr, l''eau en bouteille coûte 100 fois plus cher que l''eau du robinet.\r\n\r\nPour conserver le même niveau de confort, investissez quelques euros dans une gourde que vous pourrez remplir chez vous ou au bureau !\r\n\r\nDécouvrez la GOBI, made in France (on vous l''a envoyée par email)', '2017-01-23 15:34:05', NULL, 1, 8, 1),
(14, 'Pendant un mois, éteindre son ordinateur au lieu de le mettre en veille.', 'Mettre son ordinateur en veille contribue largement à augmenter la consommation d''énergie', '2017-01-23 15:36:27', NULL, 1, 1, 1),
(15, 'Pendant trois mois, baisser son chauffage / baisser la climatisation d’un degré', 'Un degré, allez-vous le sentir ? Pourtant, l''impact écologie et polluant d''un dégré est considérable', '2017-01-23 15:36:27', NULL, 1, 1, 1),
(16, 'Planter ses propres herbes aromatiques', 'C''est tellement plus bio et tellement meilleur !', '2017-01-23 15:37:06', NULL, 1, 1, 1),
(17, 'Trouver un moyen de recycler son huile de cuisson et le partager sur le mur', 'Défi amusant ! A vous les créatifs !', '2017-01-23 15:37:06', NULL, 1, 1, 1),
(20, 'Contenir l’ensemble de ses déchets dans le gobelet', 'Bien qu''il ne soit absolument pas conseillé de manger dans des fast-food, il se peut qu''on arrive de craquer !\r\n\r\nEssayez donc de faire arriver à contenir l’ensemble de ses déchets dans le gobelet et partager la photo !', '2017-01-23 15:38:43', NULL, 1, 1, 1),
(21, 'Trouver un moyen de recycler un produit périmé et le partager sur le mur', '', '2017-01-23 15:38:43', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `challengeachievement`
--

CREATE TABLE IF NOT EXISTS `challengeachievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `challenge` int(11) NOT NULL,
  `achievement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `challenge` (`challenge`),
  KEY `achivement` (`achievement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `challengeachievement`
--

INSERT INTO `challengeachievement` (`id`, `challenge`, `achievement`) VALUES
(3, 20, 4);

-- --------------------------------------------------------

--
-- Structure de la table `challengecategory`
--

CREATE TABLE IF NOT EXISTS `challengecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `challengecategory`
--

INSERT INTO `challengecategory` (`id`, `title`, `description`) VALUES
(1, 'Test', 'Cette catégorie ne contient que des défis factices');

-- --------------------------------------------------------

--
-- Structure de la table `challengelike`
--

CREATE TABLE IF NOT EXISTS `challengelike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `challenge` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `challenge` (`challenge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `challengeobjective`
--

CREATE TABLE IF NOT EXISTS `challengeobjective` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instruction` text NOT NULL,
  `challenge` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `challenge` (`challenge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `challengeobjective`
--

INSERT INTO `challengeobjective` (`id`, `instruction`, `challenge`) VALUES
(8, 'Acheter du savon ', 5);

-- --------------------------------------------------------

--
-- Structure de la table `challengepost`
--

CREATE TABLE IF NOT EXISTS `challengepost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `signaled` tinyint(1) NOT NULL DEFAULT '0',
  `user` int(11) DEFAULT NULL,
  `challenge` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `challenge` (`challenge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `challengepost`
--

INSERT INTO `challengepost` (`id`, `content`, `date`, `signaled`, `user`, `challenge`) VALUES
(1, 'MickaStark a terminé l''objectif "Acheter du savon " ! D''ailleurs, en voici <a href=''/GreenHand/Asset/Image/evidence/5/8/1/big.jpg'' class=''evidence fancybox''>une preuve</a>.', '2017-01-23 17:57:39', 0, NULL, 5),
(2, 'MickaStark a terminé l''objectif "Acheter du savon " ! D''ailleurs, en voici <a href=''/GreenHand/Asset/Image/evidence/5/8/1/big.jpg'' class=''evidence fancybox''>une preuve</a>.', '2017-01-23 17:57:39', 0, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `recipient` (`recipient`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `content`, `date`, `author`, `recipient`) VALUES
(1, 'Hello !', '2017-01-12 12:22:46', 1, 8),
(2, 'Hi friend !', '2017-01-12 12:22:56', 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `notification`
--

INSERT INTO `notification` (`id`, `content`, `user`, `isRead`) VALUES
(3, 'Tu as réussi un défi !', 1, 0),
(4, 'Tu as réussi un autre défi !', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `presentation` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` int(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `priceType` varchar(128) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `priceType`, `category`) VALUES
(1, 'Produit factice n°1', 'Produit qui n''existe pas...', 0, '€', 1);

-- --------------------------------------------------------

--
-- Structure de la table `productcategory`
--

CREATE TABLE IF NOT EXISTS `productcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `productcategory`
--

INSERT INTO `productcategory` (`id`, `title`, `description`) VALUES
(1, 'Test', 'Produits factices pour des tests');

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE IF NOT EXISTS `profils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `birth` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_2` (`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `profils`
--

INSERT INTO `profils` (`id`, `firstName`, `lastName`, `description`, `birth`, `gender`, `facebook`, `twitter`, `URL`, `user`) VALUES
(1, 'Mickaël', 'Boidin', 'Je suis l''un des fondateurs de GreenHand avec Emma Louviot.', '1992-08-23', 1, 'mickastark13', '', '', 1),
(14, 'Emma', 'Louviot', 'Je suis la deuxième fondatrice de GreenHand, en collaboration avec Mickaël.', '1992-08-23', 0, '', '', 'http://localhost:8888/GreenHand/accueil', 8);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`id`, `title`, `description`, `link`, `category`) VALUES
(1, 'La ruche qui dit oui', 'Rassemblons-nous pour acheter les meilleurs produits\naux agriculteurs et aux artisans de nos régions', 'https://laruchequiditoui.fr/fr', 1),
(2, 'Amap', 'Vous trouverez sur ce site : des informations sur ce qu''est une AMAP, un annuaire d''AMAP et un guide pour vous aider à créer votre AMAP.', 'http://www.reseau-amap.org/', 1),
(3, 'Consoglobe', 'Ce portail informe sur la la consommation durable et sur les styles de vie engagés. Il s''intéresse à différents thèmes : environnement, éthique, partage, services ...', 'http://www.consoglobe.com/', 1),
(4, 'GreenWeez', '35 300 produits bio, produits écologiques et produits bien-être sont en ligne sur Greenweez.com, le plus grand magasin bio et écologique en ligne.', 'https://www.greenweez.com', 3),
(5, 'MyTroc', ' Sur MyTroc tout peut se prêter, tout peut s''échanger! Troc de biens et de services. Consommer autrement, responsable. Vivre plus écolo, plus économe, plus solidaire, plus libre... ', 'https://mytroc.fr/', 4);

-- --------------------------------------------------------

--
-- Structure de la table `servicecategory`
--

CREATE TABLE IF NOT EXISTS `servicecategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `idAttr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `servicecategory`
--

INSERT INTO `servicecategory` (`id`, `title`, `description`, `idAttr`) VALUES
(1, 'Mieux se nourrir', '', 'nourrir'),
(2, 'Jardinage écolo', '', 'jardin'),
(3, 'Se soigner naturellement', '', 'soigner'),
(4, 'Autres', '', 'others');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isProducer` tinyint(1) NOT NULL DEFAULT '0',
  `validationKey` varchar(32) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numConnection` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `isAdmin`, `isProducer`, `validationKey`, `valid`, `name`, `dateRegistration`, `numConnection`) VALUES
(1, 'mickael@boidin.fr', 'v4Ww7kD2JOILAJCz1ulhsw==', 1, 0, 'd8926941f4df618530cf9ec181c3684a', 1, 'MickaStark', '2017-01-11 19:47:32', 22),
(8, 'mickael@boidin2.fr', 'urHUxyeJf91U60oJTiPGtQ==', 0, 0, '2a4d7dc61d5e7968e4b71cdbeed8ecfe', 1, 'fqsdfqsd', '2017-01-11 21:26:01', 7),
(9, 'emma.louviot@gmail.com', 'xjG6mPOeHMMUnjWVvrHe+w==', 1, 0, 'a30d0eeb22c9084f1c769d71b795aa6b', 1, 'vww3', '2017-01-23 15:25:43', 4);

-- --------------------------------------------------------

--
-- Structure de la table `usersachievementsuccess`
--

CREATE TABLE IF NOT EXISTS `usersachievementsuccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `achievement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `achievement` (`achievement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `usersachievementsuccess`
--

INSERT INTO `usersachievementsuccess` (`id`, `user`, `achievement`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `userschallengeparticipation`
--

CREATE TABLE IF NOT EXISTS `userschallengeparticipation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `challenge` int(11) NOT NULL,
  `dateParticipation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateSuccess` timestamp NULL DEFAULT NULL,
  `giveUp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user` (`user`),
  KEY `challenge` (`challenge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `userschallengeparticipation`
--

INSERT INTO `userschallengeparticipation` (`id`, `user`, `challenge`, `dateParticipation`, `dateSuccess`, `giveUp`) VALUES
(2, 1, 20, '2017-01-23 15:41:33', NULL, 0),
(3, 1, 5, '2017-01-23 17:49:11', '2017-01-23 17:57:39', 0);

-- --------------------------------------------------------

--
-- Structure de la table `usersobjectivesuccess`
--

CREATE TABLE IF NOT EXISTS `usersobjectivesuccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `objective` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `objective` (`objective`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `usersobjectivesuccess`
--

INSERT INTO `usersobjectivesuccess` (`id`, `user`, `objective`) VALUES
(4, 1, 8);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `challenge`
--
ALTER TABLE `challenge`
  ADD CONSTRAINT `fk_achievement` FOREIGN KEY (`achievement`) REFERENCES `achievement` (`id`),
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category`) REFERENCES `challengecategory` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `challengeachievement`
--
ALTER TABLE `challengeachievement`
  ADD CONSTRAINT `fk_achiv_challenge` FOREIGN KEY (`achievement`) REFERENCES `achievement` (`id`),
  ADD CONSTRAINT `fk_challenge_achiv` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`);

--
-- Contraintes pour la table `challengelike`
--
ALTER TABLE `challengelike`
  ADD CONSTRAINT `fk_challenge_like` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`),
  ADD CONSTRAINT `fk_user_like` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `challengeobjective`
--
ALTER TABLE `challengeobjective`
  ADD CONSTRAINT `fk_challenge_objective` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`);

--
-- Contraintes pour la table `challengepost`
--
ALTER TABLE `challengepost`
  ADD CONSTRAINT `fk_challenge_post` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`),
  ADD CONSTRAINT `fk_user_post` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_user_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_recipient` FOREIGN KEY (`recipient`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_user_notify` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category`) REFERENCES `productcategory` (`id`);

--
-- Contraintes pour la table `profils`
--
ALTER TABLE `profils`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_service_category` FOREIGN KEY (`category`) REFERENCES `servicecategory` (`id`);

--
-- Contraintes pour la table `usersachievementsuccess`
--
ALTER TABLE `usersachievementsuccess`
  ADD CONSTRAINT `fk_achievement_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_achievement` FOREIGN KEY (`achievement`) REFERENCES `achievement` (`id`);

--
-- Contraintes pour la table `userschallengeparticipation`
--
ALTER TABLE `userschallengeparticipation`
  ADD CONSTRAINT `fk_challenge_participation` FOREIGN KEY (`challenge`) REFERENCES `challenge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_participation` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersobjectivesuccess`
--
ALTER TABLE `usersobjectivesuccess`
  ADD CONSTRAINT `fk_objective_user` FOREIGN KEY (`objective`) REFERENCES `challengeobjective` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_objective` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
