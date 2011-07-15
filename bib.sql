-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 22 Jun 2011 om 09:59
-- Serverversie: 5.1.41
-- PHP-Versie: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bib`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `OpenLibrarySearch` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `DatabaseId` varchar(255) NOT NULL DEFAULT '',
  `IsInWishlist` tinyint(1) DEFAULT NULL,
  `Summary` longtext,
  `Title` varchar(255) DEFAULT NULL,
  `Author` int(11) DEFAULT NULL,
  `Editor` int(11) DEFAULT NULL,
  `ISBN` varchar(50) DEFAULT NULL,
  `ASIN` varchar(50) NOT NULL,
  `EAN` varchar(50) NOT NULL,
  `Languages` int(11) DEFAULT NULL,
  `Length` int(11) DEFAULT NULL,
  `PublishDate` date DEFAULT NULL,
  `Location` int(11) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `Translator` int(11) DEFAULT NULL,
  `Code` int(11) DEFAULT NULL,
  `Dimensions` varchar(50) DEFAULT NULL,
  `Link` text,
  `DateAcquired` date DEFAULT NULL,
  `Format` int(11) DEFAULT NULL,
  `ProductGroup` int(11) DEFAULT NULL,
  `Studio` int(11) DEFAULT NULL,
  `Feature` int(11) DEFAULT NULL,
  `Price` varchar(50) DEFAULT NULL,
  `SalesRank` varchar(50) DEFAULT NULL,
  `DateModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`DatabaseId`),
  FULLTEXT KEY `OpenLibrarySearch` (`Title`,`Summary`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `editors`
--

CREATE TABLE IF NOT EXISTS `editors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `OpenLibrarySearch` (`editor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productGroups`
--

CREATE TABLE IF NOT EXISTS `productGroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productgroup` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `studios`
--

CREATE TABLE IF NOT EXISTS `studios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studio` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;
