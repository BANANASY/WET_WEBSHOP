INSERT INTO `user` (`username`, `password`, `role`)
VALUES ('bananalover69', 'yoghurt', 'user');

INSERT INTO `person` (`anrede`, `vorname`, `nachname`, `email`, `aid`, `active`, `uid`)
VALUES ('Frau', 'Gundelfide', 'Braun', 'gundelfide.braun@bananamail.com', 1, 1, 1);

INSERT INTO `zahlungsinfo` (`zahlungsart`)
VALUES ('Kreditkarte');

INSERT INTO `zahlungsinfo_person`
VALUES (1, 1);

INSERT INTO `gutschein` (`wert`, `ablaufdatum`, `code`, `pid`)
VALUES (10.0, CURRENT_TIMESTAMP + 365, 'TEST1', 1);

-- insert categories

INSERT INTO `kategorie` (`bezeichnung`)
VALUES ('Banana');

INSERT INTO `kategorie` (`bezeichnung`)
VALUES ('Yoghurt');

INSERT INTO `kategorie` (`bezeichnung`)
VALUES ('Eggs');

INSERT INTO `kategorie` (`bezeichnung`)
VALUES ('Rice');

INSERT INTO `kategorie` (`bezeichnung`)
VALUES ('Costumes');

-- insert bananas

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Green banana', '../pictures/banana/green_banana.jpg', 1.99, 0, 1);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Yellow banana', '../pictures/banana/yellow_banana.jpg', 0.99, 0, 1);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Red banana', '../pictures/banana/red_banana.jpg', 2.99, 0, 1);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Diamond banana', '../pictures/banana/diamond_banana.jpg', 1599.99, 0, 1);

-- insert yoghurt

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Strawberry yoghurt', '../pictures/yoghurt/strawberry_yoghurt.png', 3.99, 0, 2);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Apple yoghurt', '../pictures/yoghurt/apple_yoghurt.jpg', 2.99, 0, 2);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Banana yoghurt', '../pictures/yoghurt/_yoghurt.jpg', 1.99, 0, 2);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Meat yoghurt', '../pictures/yoghurt/strawberry_yoghurt.jpg', 7.99, 0, 2);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Pumpkin yoghurt', '../pictures/yoghurt/strawberry_yoghurt.jpg', 9.99, 0, 2);

-- insert eggs

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Chicken egg', '../pictures/egg/chicken_egg.jpg', 0.99, 0, 3);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Ostrich egg', '../pictures/egg/ostrich_egg.jpg', 2.99, 0, 3);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Easter egg', '../pictures/egg/easter_egg.jpg', 4.99, 0, 3);

-- insert rice

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Black rice', '../pictures/rice/black_rice.jpg', 14.99, 0, 4);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('White rice', '../pictures/rice/white_rice.jpg', 14.99, 0, 4);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Brown rice', '../pictures/rice/brown_rice.jpg', 14.99, 0, 4);

-- insert costumes

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Banana costume', '../pictures/costumes/banana_costume.jpg', 49.99, 0, 5);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Egg costume', '../pictures/costumes/egg_costume.jpg', 24.99, 0, 5);

INSERT INTO `produkt` (`bezeichnung`, `bild`, `preis`, `bewertung`, `kid`)
VALUES ('Minion costume, XL', '../pictures/costumes/minion_costume.jpg', 99.99, 0, 5);



INSERT INTO `bestellungen` (`produktid`, `pid`, `datum`, `zid`, `anzahl`, `gid`)
VALUES (4, 1, CURRENT_TIMESTAMP, 1, 1, 1);

INSERT INTO `bestellungen` (`bid`, `produktid`, `pid`, `datum`, `zid`, `anzahl`, `gid`)
VALUES (1, 5, 1, CURRENT_TIMESTAMP, 1, 3, 1);

INSERT INTO `bestellungen` (`bid`, `produktid`, `pid`, `datum`, `zid`, `anzahl`, `gid`)
VALUES (1, 7, 1, CURRENT_TIMESTAMP, 1, 2, 1);

















