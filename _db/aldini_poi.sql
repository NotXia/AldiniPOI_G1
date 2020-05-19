-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 19, 2020 alle 20:12
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.3

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aldini_poi`
--
CREATE DATABASE IF NOT EXISTS `aldini_poi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aldini_poi`;

-- --------------------------------------------------------

--
-- Struttura della tabella `autenticazioni`
--

CREATE TABLE `autenticazioni` (
  `selector` varchar(20) NOT NULL,
  `token` varchar(60) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `web_agent` varchar(500) DEFAULT NULL,
  `data_scadenza` datetime NOT NULL,
  `cod_utente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `dispositivi`
--

CREATE TABLE `dispositivi` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(100) NOT NULL,
  `mac_address` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini`
--

CREATE TABLE `immagini` (
  `id` int(11) NOT NULL,
  `percorso` varchar(500) NOT NULL,
  `descrizione` varchar(500) DEFAULT NULL,
  `cod_laboratorio` varchar(20) NOT NULL,
  `cod_permesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `laboratori`
--

CREATE TABLE `laboratori` (
  `tag` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `piano` int(11) NOT NULL,
  `num_pc` int(11) DEFAULT NULL,
  `presenza_lim` tinyint(1) DEFAULT NULL,
  `descrizione` varchar(500) DEFAULT NULL,
  `id_html_map` varchar(100) DEFAULT NULL,
  `label_html_map` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `permessi`
--

CREATE TABLE `permessi` (
  `id` int(11) NOT NULL,
  `tipologia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `permessi`
--

INSERT INTO `permessi` (`id`, `tipologia`) VALUES
(1, 'Base'),
(2, 'Avanzato'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `psw` varchar(60) DEFAULT NULL,
  `cod_utente` int(11) NOT NULL,
  `cod_dispositivo` int(11) DEFAULT NULL,
  `cod_visita` int(11) NOT NULL,
  `cod_permesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `psw` varchar(60) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `ddn` date NOT NULL,
  `data_creazione` datetime NOT NULL,
  `verifica_mail` tinyint(1) NOT NULL,
  `ultima_modifica_psw` datetime DEFAULT NULL,
  `cod_permesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `visite`
--

CREATE TABLE `visite` (
  `id` int(11) NOT NULL,
  `data_inizio` date NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL,
  `posti_disponibili` int(11) NOT NULL
) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autenticazioni`
--
ALTER TABLE `autenticazioni`
  ADD PRIMARY KEY (`selector`),
  ADD KEY `cod_utente` (`cod_utente`);

--
-- Indici per le tabelle `dispositivi`
--
ALTER TABLE `dispositivi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mac_address` (`mac_address`);

--
-- Indici per le tabelle `immagini`
--
ALTER TABLE `immagini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_laboratorio` (`cod_laboratorio`),
  ADD KEY `cod_permesso` (`cod_permesso`);

--
-- Indici per le tabelle `laboratori`
--
ALTER TABLE `laboratori`
  ADD PRIMARY KEY (`tag`),
  ADD UNIQUE KEY `id_html_map` (`id_html_map`),
  ADD UNIQUE KEY `label_html_map` (`label_html_map`);

--
-- Indici per le tabelle `permessi`
--
ALTER TABLE `permessi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_utente` (`cod_utente`),
  ADD KEY `cod_dispositivo` (`cod_dispositivo`),
  ADD KEY `cod_visita` (`cod_visita`),
  ADD KEY `cod_permesso` (`cod_permesso`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `cod_permesso` (`cod_permesso`);

--
-- Indici per le tabelle `visite`
--
ALTER TABLE `visite`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `dispositivi`
--
ALTER TABLE `dispositivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `immagini`
--
ALTER TABLE `immagini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `permessi`
--
ALTER TABLE `permessi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `visite`
--
ALTER TABLE `visite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `autenticazioni`
--
ALTER TABLE `autenticazioni`
  ADD CONSTRAINT `autenticazioni_ibfk_1` FOREIGN KEY (`cod_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`cod_laboratorio`) REFERENCES `laboratori` (`tag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `immagini_ibfk_2` FOREIGN KEY (`cod_permesso`) REFERENCES `permessi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`cod_utente`) REFERENCES `utenti` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`cod_dispositivo`) REFERENCES `dispositivi` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`cod_visita`) REFERENCES `visite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_4` FOREIGN KEY (`cod_permesso`) REFERENCES `permessi` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`cod_permesso`) REFERENCES `permessi` (`id`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
