-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 juin 2023 à 14:28
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hackers_poulette`
--

-- --------------------------------------------------------

--
-- Structure de la table `hackers_poulette`
--

CREATE TABLE `hackers_poulette` (
  `id` int(11) NOT NULL,
  `name` char(255) NOT NULL,
  `firstname` char(255) NOT NULL,
  `email` char(255) NOT NULL,
  `file` blob NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `hackers_poulette`
--

INSERT INTO `hackers_poulette` (`id`, `name`, `firstname`, `email`, `file`, `description`) VALUES
(160, 'Heyo@', 'mayeru', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'testy tesy test'),
(161, 'Heyo@', 'mayeru', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'testy tesy test'),
(162, 'testname', 'testfirstname', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'heyyyyy'),
(163, 'testname', 'testfirstname', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'heyyyyy'),
(164, 'Heyo', 'Leeroy', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'gdgdgddgddggd'),
(165, 'Heyo', 'Leeroy', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'gdgdgddgddggd'),
(166, 'Heyo@', 'Leeroy', 'perplexity@yopmail.com', 0x342e342e206a61766173637269707420756e646566696e65642e706e67, 'hey yo leeroy');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `hackers_poulette`
--
ALTER TABLE `hackers_poulette`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `hackers_poulette`
--
ALTER TABLE `hackers_poulette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
