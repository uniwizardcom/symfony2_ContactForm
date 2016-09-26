-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 26 Wrz 2016, 23:58
-- Wersja serwera: 5.1.73
-- Wersja PHP: 5.5.38

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `symfony_contactform`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messages_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `email` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`messages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `messages`
--

