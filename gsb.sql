-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2025 at 07:35 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `date_activites` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id`, `nom`, `description`, `date_activites`) VALUES
(1, 'Conférence sur les antidouleurs', 'Discussion sur les effets des antidouleurs', '2025-04-15'),
(2, 'Webinaire sur les antibiotiques', 'Présentation des nouveaux antibiotiques', '2025-05-10'),
(3, 'Séminaire santé publique', 'Analyse des nouvelles recommandations médicales', '2025-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `comporte`
--

DROP TABLE IF EXISTS `comporte`;
CREATE TABLE IF NOT EXISTS `comporte` (
  `id` int NOT NULL,
  `id_1` int NOT NULL,
  `nom_medicament` varchar(255) DEFAULT NULL,
  `effet_secondaire_descrip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_1`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comporte`
--

INSERT INTO `comporte` (`id`, `id_1`, `nom_medicament`, `effet_secondaire_descrip`) VALUES
(1, 2, 'Doliprane', 'Maux de tête'),
(2, 4, 'Ibuprofène', 'Troubles digestifs'),
(3, 1, 'Aspirine', 'Nausées'),
(4, 3, 'Amoxicilline', 'Somnolence'),
(5, 5, 'Paracétamol', 'Réactions allergiques');

-- --------------------------------------------------------

--
-- Table structure for table `contient`
--

DROP TABLE IF EXISTS `contient`;
CREATE TABLE IF NOT EXISTS `contient` (
  `id` int NOT NULL,
  `id_1` int NOT NULL,
  `nom_medicament` varchar(255) DEFAULT NULL,
  `effet_therapeutique_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_1`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contient`
--

INSERT INTO `contient` (`id`, `id_1`, `nom_medicament`, `effet_therapeutique_description`) VALUES
(1, 1, 'Doliprane', 'Soulagement de la douleur'),
(2, 2, 'Ibuprofène', 'Réduction de l’inflammation'),
(3, 3, 'Aspirine', 'Diminution de la fièvre'),
(4, 4, 'Amoxicilline', 'Traitement des infections'),
(5, 5, 'Paracétamol', 'Amélioration de la circulation sanguine');

-- --------------------------------------------------------

--
-- Table structure for table `effets_secondaires`
--

DROP TABLE IF EXISTS `effets_secondaires`;
CREATE TABLE IF NOT EXISTS `effets_secondaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descriptif` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `effets_secondaires`
--

INSERT INTO `effets_secondaires` (`id`, `descriptif`) VALUES
(1, 'Nausées'),
(2, 'Maux de tête'),
(3, 'Somnolence'),
(4, 'Troubles digestifs'),
(5, 'Réactions allergiques');

-- --------------------------------------------------------

--
-- Table structure for table `effets_therapeutiques`
--

DROP TABLE IF EXISTS `effets_therapeutiques`;
CREATE TABLE IF NOT EXISTS `effets_therapeutiques` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descriptif` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `effets_therapeutiques`
--

INSERT INTO `effets_therapeutiques` (`id`, `descriptif`) VALUES
(1, 'Soulagement de la douleur'),
(2, 'Réduction de l’inflammation'),
(3, 'Diminution de la fièvre'),
(4, 'Traitement des infections'),
(5, 'Amélioration de la circulation sanguine');

-- --------------------------------------------------------

--
-- Table structure for table `inscrit`
--

DROP TABLE IF EXISTS `inscrit`;
CREATE TABLE IF NOT EXISTS `inscrit` (
  `id` int NOT NULL,
  `id_1` int NOT NULL,
  `utilisateur_nom` varchar(255) DEFAULT NULL,
  `activite_nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_1`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inscrit`
--

INSERT INTO `inscrit` (`id`, `id_1`, `utilisateur_nom`, `activite_nom`) VALUES
(1, 1, 'Dupont', 'Conférence sur les antidouleurs'),
(2, 2, 'Martin', 'Webinaire sur les antibiotiques'),
(3, 1, 'Durand', 'Conférence sur les antidouleurs'),
(4, 3, 'Lemoine', 'Séminaire santé publique'),
(5, 2, 'Morel', 'Webinaire sur les antibiotiques');

-- --------------------------------------------------------

--
-- Table structure for table `medicaments`
--

DROP TABLE IF EXISTS `medicaments`;
CREATE TABLE IF NOT EXISTS `medicaments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medicaments`
--

INSERT INTO `medicaments` (`id`, `nom`) VALUES
(1, 'Doliprane'),
(2, 'Ibuprofène'),
(3, 'Aspirine'),
(4, 'Amoxicilline'),
(5, 'Paracétamol');

-- --------------------------------------------------------

--
-- Table structure for table `n_est_pas_compatible`
--

DROP TABLE IF EXISTS `n_est_pas_compatible`;
CREATE TABLE IF NOT EXISTS `n_est_pas_compatible` (
  `id` int NOT NULL,
  `medicament_1_nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_1` int NOT NULL,
  `medicament_2_nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_1`),
  KEY `id_1` (`id_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `n_est_pas_compatible`
--

INSERT INTO `n_est_pas_compatible` (`id`, `medicament_1_nom`, `id_1`, `medicament_2_nom`) VALUES
(1, 'Doliprane', 2, 'Ibuprofène'),
(3, 'Aspirine', 5, 'Paracétamol'),
(4, 'Amoxicilline', 2, 'Ibuprofène');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profession` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `profession`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', 'Médecin'),
(2, 'Martin', 'Sophie', 'sophie.martin@example.com', 'Pharmacien'),
(3, 'Durand', 'Paul', 'paul.durand@example.com', 'Chercheur'),
(4, 'Lemoine', 'Claire', 'claire.lemoine@example.com', 'Étudiant'),
(5, 'Morel', 'Lucas', 'lucas.morel@example.com', 'Biologiste');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
