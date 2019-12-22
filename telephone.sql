-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2019 at 05:51 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details_parties`
--

INSERT INTO `details_parties` (`ID`, `ID_partie`, `ID_enigme`, `etat`, `duree_resolution`) VALUES
(126, 53, 3, 5, '00:00:02'),
(125, 53, 2, 0, '00:00:00'),
(124, 53, 1, 5, '01:24:12'),
(123, 52, 3, 5, '00:00:02'),
(122, 52, 2, 0, '00:00:00'),
(121, 52, 1, 5, '01:24:12'),
(120, 51, 3, 5, '00:00:02'),
(119, 51, 2, 0, '00:00:00'),
(118, 51, 1, 5, '01:24:12'),
(128, 54, 2, 0, '00:00:00'),
(127, 54, 1, 5, '01:24:12'),
(129, 54, 3, 5, '00:00:02'),
(130, 55, 1, 5, '01:24:12'),
(131, 55, 2, 0, '00:00:00'),
(132, 55, 3, 5, '00:00:02'),
(133, 56, 1, 5, '01:24:12'),
(134, 56, 2, 0, '00:00:00'),
(135, 56, 3, 5, '00:00:02'),
(138, 57, 3, 5, '00:00:02'),
(136, 57, 1, 5, '01:24:12'),
(137, 57, 2, 0, '00:00:00'),
(139, 58, 1, 5, '01:24:12'),
(140, 58, 2, 0, '00:00:00'),
(141, 58, 3, 5, '00:00:02'),
(142, 59, 1, 5, '01:24:12'),
(143, 59, 2, 0, '00:00:00'),
(144, 59, 3, 5, '00:00:02'),
(145, 60, 1, 5, '01:24:12'),
(146, 60, 2, 0, '00:00:00'),
(147, 60, 3, 5, '00:00:02'),
(148, 61, 1, 5, '01:24:12'),
(149, 61, 2, 0, '00:00:00'),
(150, 61, 3, 5, '00:00:02'),
(151, 62, 1, 5, '01:24:12'),
(152, 62, 2, 0, '00:00:00'),
(153, 62, 3, 5, '00:00:02');

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
  `indice_texte` varchar(1000) DEFAULT NULL,
  `indice_son` int(11) DEFAULT NULL,
  `solution_texte` varchar(1000) DEFAULT NULL,
  `solution_son` int(11) DEFAULT NULL,
  `message_fin_texte` varchar(1000) DEFAULT NULL,
  `message_fin_son` int(11) DEFAULT NULL,
  `numero_tel` int(11) NOT NULL,
  `topic_MQTT` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enigmes`
--

INSERT INTO `enigmes` (`ID`, `nom`, `ordre_apparition`, `type_signal_fin`, `indice_texte`, `indice_son`, `solution_texte`, `solution_son`, `message_fin_texte`, `message_fin_son`, `numero_tel`, `topic_MQTT`) VALUES
(1, 'Casse tête lumineux', 2, 0, 'Bonjour, je suis l\'indice du casse-tete lumineux', NULL, 'Bonjour, je suis la solution du casse-tete lumineux', NULL, 'Bravo, vous avez réussi le casse-tete lumineux', NULL, 165, 'casse-tete'),
(2, 'Jeu des vannes', 3, 1, 'L\'une des vannes dérègle les trois autres, à vous de trouver laquelle', NULL, 'Réglez la quatrième vanne à la moitié de sa course, et jouez avec les trois autres', NULL, 'Bravo, vous avez réussi le jeu des vannes', NULL, 142, 'jeu-vannes'),
(3, 'Ventilateur stroboscopique', 1, 0, 'Tournez légèrement le potentiomètre jusqu\'à pouvoir lire le potentiomètre', NULL, 'Le code à lire était 1498', NULL, 'Bravo, vous avez fini le jeu du ventilateur stroboscopique. Cherchez maintenant à quoi pourra bien vous servir le code !', NULL, 742, '');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_masters`
--

INSERT INTO `game_masters` (`ID`, `nom`, `prenom`, `identifiant`, `hash_mdp`) VALUES
(1, 'Mercy', 'Valentin', 'lcdb', '$2y$10$2C0vCfaLGEEXNe.UMkozYuOr9/zZ4N/fTvr8Ov9KrtINOh6KQOfk2'),
(2, 'Maccou', 'Jean', 'jmaccou', '$2y$10$qJdc6diwazJ3xANe/3JXeeJW10Ds5sehXiMODUGizEllZdlPwinNa');

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
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`ID`, `date_debut`, `date_fin`, `ID_gamemaster`) VALUES
(51, '2019-12-22 00:32:13', '2019-12-22 15:05:10', 1),
(54, '2019-12-22 16:03:51', '2019-12-22 16:05:05', 1),
(52, '2019-12-22 15:05:18', '2019-12-22 15:05:46', 1),
(53, '2019-12-22 15:06:13', '2019-12-22 16:03:50', 1),
(55, '2019-12-22 16:05:07', '2019-12-22 16:10:47', 1),
(56, '2019-12-22 16:10:48', '2019-12-22 16:24:14', 1),
(57, '2019-12-22 16:24:15', '2019-12-22 16:24:32', 1),
(58, '2019-12-22 16:25:11', '2019-12-22 16:25:49', 1),
(59, '2019-12-22 16:25:50', '2019-12-22 16:27:07', 1),
(60, '2019-12-22 16:27:07', '2019-12-22 16:36:29', 1),
(61, '2019-12-22 15:38:52', '2019-12-22 16:39:52', 1),
(62, '2019-12-22 15:39:53', '2019-12-22 18:04:09', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
