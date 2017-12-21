--------------------------------------------------------------------------
-- 0. Créer une bdd animals avec interclassement en UTF8
-- 1. Création des tables et de la vue copier coller le code SQL suivant :
--------------------------------------------------------------------------

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 21 Décembre 2017 à 12:00
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  5.6.32-1+ubuntu16.04.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `animals`
--

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `ani_name` varchar(255) NOT NULL,
  `creation_date` varchar(15) NOT NULL,
  `death_date` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `sexe` varchar(2) NOT NULL,
  `update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Structure de la table `cor_ad`
--

CREATE TABLE `cor_ad` (
  `id_device` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `date_start_tmp` varchar(255) NOT NULL,
  `date_end_tmp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devices`
--

CREATE TABLE `devices` (
  `id_device` int(11) NOT NULL,
  `ref_device` varchar(255) NOT NULL DEFAULT '',
  `id_device_type` int(11) DEFAULT NULL,
  `device_info` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gps_data`
--

CREATE TABLE `gps_data` (
  `id_gps_data` int(11) UNSIGNED NOT NULL,
  `ref_device` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `temperature` varchar(6) NOT NULL,
  `nb_satellites` varchar(10) NOT NULL,
  `altitude` varchar(10) NOT NULL,
  `dateheure` date DEFAULT NULL,
  `ttf` varchar(20) NOT NULL,
  `2d/3d` varchar(2) NOT NULL,
  `h-dop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lib_devices_types`
--

CREATE TABLE `lib_devices_types` (
  `id_device_type` int(11) NOT NULL,
  `type_device` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tmp_cor_ad`
--

CREATE TABLE `tmp_cor_ad` (
  `animal_name` varchar(200) NOT NULL,
  `ref_device` varchar(200) NOT NULL,
  `date_debut` varchar(200) NOT NULL,
  `date_fin` varchar(200) NOT NULL,
  `heure_debut` varchar(200) NOT NULL,
  `heure_fin` varchar(200) NOT NULL,
  `cor_info` varchar(255) NOT NULL,
  `id_device` int(11),
  `id_animal` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(10) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `session_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `identifiant`, `user_name`, `user_firstname`, `pass`, `email`, `session_id`) VALUES
(1, 'admin', 'admin', 'toto', '21232f297a57a5a743894a0e4a801fc3', 'admin@email.com', '5m44ujl2jfolg8kdek6bo5psk1');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_gps_animal`
--
CREATE TABLE `v_gps_animal` (
`id` int(11) unsigned
,`id_animal` int(11)
,`ref_device` varchar(255)
,`dateheure` date
,`latitude` varchar(255)
,`longitude` varchar(255)
,`temperature` varchar(6)
,`nb_satellites` varchar(10)
,`altitude` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_gps_animal`
--
DROP TABLE IF EXISTS `v_gps_animal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`followdem`@`localhost` SQL SECURITY DEFINER VIEW `v_gps_animal`  AS  select `g`.`id_gps_data` AS `id`,`a`.`id_animal` AS `id_animal`,`d`.`ref_device` AS `ref_device`,`g`.`dateheure` AS `dateheure`,`g`.`latitude` AS `latitude`,`g`.`longitude` AS `longitude`,`g`.`temperature` AS `temperature`,`g`.`nb_satellites` AS `nb_satellites`,`g`.`altitude` AS `altitude` from (((`gps_data` `g` join `devices` `d` on((`d`.`ref_device` = `g`.`ref_device`))) join `cor_ad` `c` on((`c`.`id_device` = `d`.`id_device`))) join `animal` `a` on((`a`.`id_animal` = `c`.`id_animal`))) where (((`g`.`dateheure` > `c`.`date_start`) and (`g`.`dateheure` < `c`.`date_end`)) or ((`g`.`dateheure` > `c`.`date_start`) and isnull(`c`.`date_end`))) ;



-------------------------------------------------------------------------------------
-- 2. Intégration des contraintes à chaque table, copier coller le code SQL suivant :
-------------------------------------------------------------------------------------

--
-- Index pour les tables exportées
--

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`);

--
-- Index pour la table `cor_ad`
--
ALTER TABLE `cor_ad`
  ADD KEY `cor_ad_ibfk_2` (`id_animal`);

--
-- Index pour la table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id_device`),
  ADD UNIQUE KEY `ref_device` (`ref_device`),
  ADD KEY `id_device_type` (`id_device_type`);

--
-- Index pour la table `gps_data`
--
ALTER TABLE `gps_data`
  ADD PRIMARY KEY (`id_gps_data`),
  ADD KEY `ref_device` (`ref_device`);

--
-- Index pour la table `lib_devices_types`
--
ALTER TABLE `lib_devices_types`
  ADD PRIMARY KEY (`id_device_type`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT pour la table `devices`
--
ALTER TABLE `devices`
  MODIFY `id_device` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `gps_data`
--
ALTER TABLE `gps_data`
  MODIFY `id_gps_data` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=495;
--
-- AUTO_INCREMENT pour la table `lib_devices_types`
--
ALTER TABLE `lib_devices_types`
  MODIFY `id_device_type` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cor_ad`
--
ALTER TABLE `cor_ad`
  ADD CONSTRAINT `cor_ad_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`);

--
-- Contraintes pour la table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`id_device_type`) REFERENCES `lib_devices_types` (`id_device_type`);

--
-- Contraintes pour la table `gps_data`
--
ALTER TABLE `gps_data`
  ADD CONSTRAINT `gps_data_ibfk_1` FOREIGN KEY (`ref_device`) REFERENCES `devices` (`ref_device`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Intégration de données provenant de tableaux xls existants
-- Utiliser la table temp cor_ad pour concaténer les valeurs date et heure
