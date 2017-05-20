-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2017 um 15:52
-- Server-Version: 10.1.16-MariaDB
-- PHP-Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `7048141db1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adresse`
--

CREATE TABLE `adresse` (
  `aid` int(11) NOT NULL,
  `strasse` varchar(255) NOT NULL,
  `plz` varchar(6) NOT NULL,
  `ort` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `adresse`
--

INSERT INTO `adresse` (`aid`, `strasse`, `plz`, `ort`) VALUES
(1, 'Heinzgasse 2', '4200', 'Peppidorf');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `bid` int(11) NOT NULL,
  `produktid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zid` int(11) NOT NULL,
  `anzahl` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gutschein`
--

CREATE TABLE `gutschein` (
  `gid` int(11) NOT NULL DEFAULT '0',
  `wert` decimal(10,2) DEFAULT NULL,
  `ablauf_datum` date DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `kid` int(11) NOT NULL DEFAULT '0',
  `bezeichnung` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `person`
--

CREATE TABLE `person` (
  `pid` int(11) NOT NULL,
  `anrede` varchar(50) DEFAULT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `aid` int(11) NOT NULL COMMENT 'FK_adresse_aid',
  `activ` tinyint(1) NOT NULL DEFAULT '1',
  `uid` int(11) NOT NULL COMMENT 'FK_user_uid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkt`
--

CREATE TABLE `produkt` (
  `produktid` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(50) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL,
  `preis` decimal(10,2) DEFAULT NULL,
  `bewertung` int(1) DEFAULT NULL,
  `kid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UID` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `warenkorb`
--

CREATE TABLE `warenkorb` (
  `produktid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `anzahl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zahlungsinfo`
--

CREATE TABLE `zahlungsinfo` (
  `zid` int(11) NOT NULL,
  `zahlungsart` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zahlungsinfo_person`
--

CREATE TABLE `zahlungsinfo_person` (
  `zid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`aid`);

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`bid`,`produktid`,`pid`);

--
-- Indizes für die Tabelle `gutschein`
--
ALTER TABLE `gutschein`
  ADD PRIMARY KEY (`gid`),
  ADD KEY `pid` (`pid`);

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kid`);

--
-- Indizes für die Tabelle `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `aid` (`aid`);

--
-- Indizes für die Tabelle `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`produktid`),
  ADD KEY `kid` (`kid`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- Indizes für die Tabelle `warenkorb`
--
ALTER TABLE `warenkorb`
  ADD PRIMARY KEY (`produktid`,`pid`);

--
-- Indizes für die Tabelle `zahlungsinfo`
--
ALTER TABLE `zahlungsinfo`
  ADD PRIMARY KEY (`zid`);

--
-- Indizes für die Tabelle `zahlungsinfo_person`
--
ALTER TABLE `zahlungsinfo_person`
  ADD PRIMARY KEY (`zid`,`pid`),
  ADD KEY `pid` (`pid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adresse`
--
ALTER TABLE `adresse`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `person`
--
ALTER TABLE `person`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `zahlungsinfo`
--
ALTER TABLE `zahlungsinfo`
  MODIFY `zid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
