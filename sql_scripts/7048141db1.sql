-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2017 um 18:21
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
  `gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bestellungen`
--

INSERT INTO `bestellungen` (`bid`, `produktid`, `pid`, `datum`, `zid`, `anzahl`, `gid`) VALUES
(1, 4, 1, '2017-05-20 15:47:12', 1, 1, 1),
(1, 5, 1, '2017-05-20 15:47:12', 1, 3, 1),
(1, 7, 1, '2017-05-20 15:47:12', 1, 2, 1),
(2, 2, 1, '2017-05-20 15:53:52', 2, 2, NULL),
(2, 6, 1, '2017-05-20 15:53:03', 2, 3, 0);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `detail_rechnungen`
--
CREATE TABLE `detail_rechnungen` (
`bezeichnung` varchar(50)
,`preis` decimal(10,2)
,`anzahl` int(11)
,`brutto` decimal(20,2)
,`datum` timestamp
,`bid` int(11)
,`pid` int(11)
,`zid` int(11)
,`gid` int(11)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `detail_rechnungen_ext`
--
CREATE TABLE `detail_rechnungen_ext` (
`anrede` varchar(50)
,`vorname` varchar(50)
,`nachname` varchar(50)
,`strasse` varchar(255)
,`plz` varchar(6)
,`ort` varchar(255)
,`zahlungsart` varchar(50)
,`total` decimal(42,2)
,`datum` timestamp
,`bid` int(11)
,`gid` int(11)
,`pid` int(11)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `gesamt_rechnungen`
--
CREATE TABLE `gesamt_rechnungen` (
`anrede` varchar(50)
,`vorname` varchar(50)
,`nachname` varchar(50)
,`strasse` varchar(255)
,`plz` varchar(6)
,`ort` varchar(255)
,`zahlungsart` varchar(50)
,`total` decimal(42,2)
,`netto` decimal(43,2)
,`datum` timestamp
,`bid` int(11)
,`pid` int(11)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gutschein`
--

CREATE TABLE `gutschein` (
  `gid` int(11) NOT NULL,
  `wert` decimal(10,2) DEFAULT NULL,
  `ablauf_datum` timestamp NULL DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `gutschein`
--

INSERT INTO `gutschein` (`gid`, `wert`, `ablauf_datum`, `code`, `pid`) VALUES
(1, '20.00', '2017-10-17 22:00:00', 'TEST1', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `kid` int(11) NOT NULL,
  `bezeichnung` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`kid`, `bezeichnung`) VALUES
(1, 'Banana'),
(2, 'Yoghurt'),
(3, 'Eggs'),
(4, 'Rice'),
(5, 'Costumes');

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

--
-- Daten für Tabelle `person`
--

INSERT INTO `person` (`pid`, `anrede`, `vorname`, `nachname`, `email`, `aid`, `activ`, `uid`) VALUES
(1, 'Frau', 'Gundelfide', 'Braun', 'gundelfide.braun@bananamail.com', 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkt`
--

CREATE TABLE `produkt` (
  `produktid` int(11) NOT NULL,
  `bezeichnung` varchar(50) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL,
  `preis` decimal(10,2) DEFAULT NULL,
  `bewertung` int(1) DEFAULT NULL,
  `kid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `produkt`
--

INSERT INTO `produkt` (`produktid`, `bezeichnung`, `bild`, `preis`, `bewertung`, `kid`) VALUES
(1, 'Green banana', '../pictures/banana/green_banana.jpg', '1.99', 0, 1),
(2, 'Yellow banana', '../pictures/banana/yellow_banana.jpg', '0.99', 0, 1),
(3, 'Red banana', '../pictures/banana/red_banana.jpg', '2.99', 0, 1),
(4, 'Diamond banana', '../pictures/banana/diamond_banana.jpg', '1599.99', 0, 1),
(5, 'Strawberry yoghurt', '../pictures/yoghurt/strawberry_yoghurt.png', '3.99', 0, 2),
(6, 'Apple yoghurt', '../pictures/yoghurt/apple_yoghurt.jpg', '2.99', 0, 2),
(7, 'Banana yoghurt', '../pictures/yoghurt/_yoghurt.jpg', '1.99', 0, 2),
(8, 'Meat yoghurt', '../pictures/yoghurt/strawberry_yoghurt.jpg', '7.99', 0, 2),
(9, 'Pumpkin yoghurt', '../pictures/yoghurt/strawberry_yoghurt.jpg', '9.99', 0, 2),
(10, 'Chicken egg', '../pictures/egg/chicken_egg.jpg', '0.99', 0, 3),
(11, 'Ostrich egg', '../pictures/egg/ostrich_egg.jpg', '2.99', 0, 3),
(12, 'Easter egg', '../pictures/egg/easter_egg.jpg', '4.99', 0, 3),
(13, 'Black rice', '../pictures/rice/black_rice.jpg', '14.99', 0, 4),
(14, 'White rice', '../pictures/rice/white_rice.jpg', '14.99', 0, 4),
(15, 'Brown rice', '../pictures/rice/brown_rice.jpg', '14.99', 0, 4),
(16, 'Banana costume', '../pictures/costumes/banana_costume.jpg', '49.99', 0, 5),
(17, 'Egg costume', '../pictures/costumes/egg_costume.jpg', '24.99', 0, 5),
(18, 'Minion costume, XL', '../pictures/costumes/minion_costume.jpg', '99.99', 0, 5);

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

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`UID`, `username`, `password`, `role`) VALUES
(1, 'bananalover69', 'yoghurt', 'user');

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

--
-- Daten für Tabelle `zahlungsinfo`
--

INSERT INTO `zahlungsinfo` (`zid`, `zahlungsart`) VALUES
(1, 'DinersClub'),
(2, 'VISA'),
(3, 'MasterCard');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zahlungsinfo_person`
--

CREATE TABLE `zahlungsinfo_person` (
  `zid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `zahlungsinfo_person`
--

INSERT INTO `zahlungsinfo_person` (`zid`, `pid`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struktur des Views `detail_rechnungen`
--
DROP TABLE IF EXISTS `detail_rechnungen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_rechnungen`  AS  select `produkt`.`bezeichnung` AS `bezeichnung`,`produkt`.`preis` AS `preis`,`bestellungen`.`anzahl` AS `anzahl`,(`produkt`.`preis` * `bestellungen`.`anzahl`) AS `brutto`,`bestellungen`.`datum` AS `datum`,`bestellungen`.`bid` AS `bid`,`bestellungen`.`pid` AS `pid`,`bestellungen`.`zid` AS `zid`,`bestellungen`.`gid` AS `gid` from (`bestellungen` join `produkt` on((`bestellungen`.`produktid` = `produkt`.`produktid`))) ;

-- --------------------------------------------------------

--
-- Struktur des Views `detail_rechnungen_ext`
--
DROP TABLE IF EXISTS `detail_rechnungen_ext`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detail_rechnungen_ext`  AS  select `person`.`anrede` AS `anrede`,`person`.`vorname` AS `vorname`,`person`.`nachname` AS `nachname`,`adresse`.`strasse` AS `strasse`,`adresse`.`plz` AS `plz`,`adresse`.`ort` AS `ort`,`zahlungsinfo`.`zahlungsart` AS `zahlungsart`,sum(`detail_rechnungen`.`brutto`) AS `total`,`detail_rechnungen`.`datum` AS `datum`,`detail_rechnungen`.`bid` AS `bid`,`detail_rechnungen`.`gid` AS `gid`,`detail_rechnungen`.`pid` AS `pid` from (((`detail_rechnungen` join `person` on((`detail_rechnungen`.`pid` = `person`.`pid`))) join `adresse` on((`person`.`aid` = `adresse`.`aid`))) join `zahlungsinfo` on((`detail_rechnungen`.`zid` = `zahlungsinfo`.`zid`))) group by `person`.`anrede`,`person`.`vorname`,`person`.`nachname`,`adresse`.`strasse`,`adresse`.`plz`,`adresse`.`ort`,`zahlungsinfo`.`zahlungsart`,`detail_rechnungen`.`datum`,`detail_rechnungen`.`bid`,`detail_rechnungen`.`pid` ;

-- --------------------------------------------------------

--
-- Struktur des Views `gesamt_rechnungen`
--
DROP TABLE IF EXISTS `gesamt_rechnungen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gesamt_rechnungen`  AS  select `detail_rechnungen_ext`.`anrede` AS `anrede`,`detail_rechnungen_ext`.`vorname` AS `vorname`,`detail_rechnungen_ext`.`nachname` AS `nachname`,`detail_rechnungen_ext`.`strasse` AS `strasse`,`detail_rechnungen_ext`.`plz` AS `plz`,`detail_rechnungen_ext`.`ort` AS `ort`,`detail_rechnungen_ext`.`zahlungsart` AS `zahlungsart`,`detail_rechnungen_ext`.`total` AS `total`,(`detail_rechnungen_ext`.`total` - coalesce(`gutschein`.`wert`,0)) AS `netto`,`detail_rechnungen_ext`.`datum` AS `datum`,`detail_rechnungen_ext`.`bid` AS `bid`,`detail_rechnungen_ext`.`pid` AS `pid` from (`detail_rechnungen_ext` left join `gutschein` on((`detail_rechnungen_ext`.`gid` = `gutschein`.`gid`))) ;

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
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `gutschein`
--
ALTER TABLE `gutschein`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `person`
--
ALTER TABLE `person`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produktid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `zahlungsinfo`
--
ALTER TABLE `zahlungsinfo`
  MODIFY `zid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
