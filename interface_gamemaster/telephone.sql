-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 29, 2019 at 10:48 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telephone`
--

-- --------------------------------------------------------

--
-- Table structure for table `bandes_son`
--

DROP TABLE IF EXISTS `bandes_son`;
CREATE TABLE IF NOT EXISTS `bandes_son` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'sert également de nom de fichier .mp3',
  `titre` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bandes_son`
--

INSERT INTO `bandes_son` (`ID`, `titre`) VALUES
(4, 'Chant de coq'),
(3, 'Coeur qui bat'),
(2, 'Clavier d\'ordinateur');

-- --------------------------------------------------------

--
-- Table structure for table `details_parties`
--

DROP TABLE IF EXISTS `details_parties`;
CREATE TABLE IF NOT EXISTS `details_parties` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_partie` int(11) NOT NULL,
  `ID_enigme` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `duree_resolution` time DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details_parties`
--

INSERT INTO `details_parties` (`ID`, `ID_partie`, `ID_enigme`, `etat`, `duree_resolution`) VALUES
(227, 86, 5, 5, '00:00:02'),
(226, 86, 4, 0, '00:00:00'),
(225, 86, 3, 5, '00:00:01'),
(224, 86, 1, 0, '00:00:00'),
(223, 85, 4, 0, '00:00:00'),
(222, 85, 3, 5, '00:57:04'),
(221, 85, 1, 0, '00:00:00'),
(220, 84, 4, 0, '00:00:00'),
(219, 84, 3, 0, '00:00:00'),
(218, 84, 1, 0, '00:00:00'),
(217, 83, 4, 0, '00:00:00'),
(216, 83, 3, 5, '01:07:38'),
(215, 83, 1, 0, '00:00:00'),
(214, 82, 5, 5, '00:00:03'),
(213, 82, 4, 0, '00:00:00'),
(212, 82, 3, 5, '00:00:01'),
(211, 82, 1, 0, '00:00:00'),
(210, 81, 4, 1, '00:00:00'),
(209, 81, 3, 5, '00:00:05'),
(208, 81, 1, 2, '00:00:00'),
(207, 80, 4, 0, '00:00:00'),
(206, 80, 3, 0, '00:00:00'),
(205, 80, 1, 0, '00:00:00'),
(204, 79, 4, 0, '00:00:00'),
(203, 79, 3, 5, '00:06:58'),
(202, 79, 1, 0, '00:00:00'),
(201, 78, 4, 0, '00:00:00'),
(200, 78, 3, 5, '00:00:09'),
(199, 78, 1, 1, '00:00:00'),
(198, 77, 4, 1, '00:00:00'),
(197, 77, 3, 5, '00:01:07'),
(196, 77, 1, 0, '00:00:00'),
(195, 76, 4, 0, '00:00:00'),
(194, 76, 3, 0, '00:00:00'),
(193, 76, 1, 0, '00:00:00'),
(192, 75, 4, 0, '00:00:00'),
(191, 75, 3, 0, '00:00:00'),
(190, 75, 1, 0, '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `enigmes`
--

DROP TABLE IF EXISTS `enigmes`;
CREATE TABLE IF NOT EXISTS `enigmes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `ordre_apparition` int(11) NOT NULL,
  `type_signal_fin` tinyint(1) DEFAULT NULL,
  `numero_tel` int(11) NOT NULL,
  `topic_MQTT` varchar(255) DEFAULT NULL,
  `type_indice_1` int(11) DEFAULT NULL COMMENT '0 pour absent, 1 pour texte, 2 pour son',
  `texte_indice_1` varchar(1000) DEFAULT NULL COMMENT 'vide si type_indice != texte',
  `type_indice_2` int(11) DEFAULT NULL COMMENT '0 pour absent, 1 pour texte, 2 pour son',
  `texte_indice_2` varchar(1000) DEFAULT NULL COMMENT 'vide si type_indice != texte',
  `type_message_fin` int(11) DEFAULT NULL COMMENT '0 pour absent, 1 pour texte, 2 pour son',
  `texte_message_fin` varchar(1000) DEFAULT NULL COMMENT 'vide si type_indice != texte',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enigmes`
--

INSERT INTO `enigmes` (`ID`, `nom`, `ordre_apparition`, `type_signal_fin`, `numero_tel`, `topic_MQTT`, `type_indice_1`, `texte_indice_1`, `type_indice_2`, `texte_indice_2`, `type_message_fin`, `texte_message_fin`) VALUES
(1, 'Casse tête lumineux', 3, 1, 165, 'casse-tete', 1, 'Bonjour, je suis le premier indice du casse-tete lumineux', 0, NULL, 1, 'Bravo, vous avez réussi le casse-tête lumineux !'),
(3, 'Ventilateur stroboscopique', 1, 0, 742, '', 1, 'Tournez légèrement le potentiomètre jusqu\'à pouvoir lire le code sur les pales du ventilateur', 0, NULL, 1, 'Bravo, vous avez fini le jeu du ventilateur stroboscopique. Cherchez maintenant à quoi pourra bien vous servir le code !'),
(4, 'Jeu des vannes', 2, 1, 327, 'jeu_vannes', 1, 'Tournez les potentiomètres jusqu\'à trouver la bonne combinaison de positions', 1, 'Le premier potentiomètre joue un rôle décisif sur la position des trois autres !', 1, 'Bravo, vous avez résolu l\'énigme des vannes !'),
(5, 'Jeu du parcours', 4, 0, 284, NULL, 2, NULL, 2, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `game_masters`
--

DROP TABLE IF EXISTS `game_masters`;
CREATE TABLE IF NOT EXISTS `game_masters` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `hash_mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_masters`
--

INSERT INTO `game_masters` (`ID`, `nom`, `prenom`, `identifiant`, `hash_mdp`) VALUES
(1, 'Mercy', 'Valentin', 'lcdb', '$2y$10$2C0vCfaLGEEXNe.UMkozYuOr9/zZ4N/fTvr8Ov9KrtINOh6KQOfk2');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime DEFAULT NULL,
  `ID_gamemaster` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`ID`, `date_debut`, `date_fin`, `ID_gamemaster`) VALUES
(85, '2019-12-28 23:37:27', '2019-12-29 00:34:36', 1),
(84, '2019-12-28 23:13:24', '2019-12-28 23:36:52', 1),
(83, '2019-12-28 19:58:27', '2019-12-28 23:08:14', 1),
(82, '2019-12-28 19:55:04', '2019-12-28 19:55:09', 1),
(81, '2019-12-28 18:05:30', '2019-12-28 18:06:57', 1),
(80, '2019-12-28 18:04:51', '2019-12-28 18:05:19', 1),
(79, '2019-12-28 17:57:36', '2019-12-28 18:04:49', 1),
(78, '2019-12-28 17:43:20', '2019-12-28 17:51:12', 1),
(77, '2019-12-28 17:39:32', '2019-12-28 17:43:07', 1),
(76, '2019-12-28 17:22:40', '2019-12-28 17:22:42', 1),
(75, '2019-12-28 17:18:51', '2019-12-28 17:20:00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
