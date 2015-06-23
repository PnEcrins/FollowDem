-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 23 Juin 2015 à 15:23
-- Version du serveur: 5.5.43
-- Version de PHP: 5.3.10-1ubuntu3.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `followdem`
--

-- --------------------------------------------------------

--
-- Structure de la table `gps_data`
--

CREATE TABLE IF NOT EXISTS `gps_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tracked_objects` varchar(255) NOT NULL,
  `dateheure` datetime NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `temperature` varchar(6) NOT NULL,
  `nb_satellites` int(10) NOT NULL,
  `altitude` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_objet` (`id_tracked_objects`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32244 ;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84030 ;

-- --------------------------------------------------------

--
-- Structure de la table `objects_features`
--

CREATE TABLE IF NOT EXISTS `objects_features` (
  `id_tracked_objects` varchar(255) NOT NULL,
  `nom_prop` varchar(255) NOT NULL,
  `valeur_prop` text NOT NULL,
  KEY `id_objet` (`id_tracked_objects`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Propriétés associées à un objet';

-- --------------------------------------------------------

--
-- Structure de la table `tracked_objects`
--

CREATE TABLE IF NOT EXISTS `tracked_objects` (
  `id` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_maj` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) unsigned NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `nom_user` varchar(50) NOT NULL,
  `prenom_user` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
