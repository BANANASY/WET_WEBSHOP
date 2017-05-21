
<?php
include 'inc/nav_sec.php';
?>

<h2>Welcome to the Banana Yoghurt Shopping experience</h2>
<p>toDo:</p>
<ol>
    <li>Im Bereich „Produkte“ werden Produkte angezeigt sowie Kategorien.
        Die erste Kategorie wird standardmäßig ausgewählt und es werden die
        aktuellen Produkte dieser Kategorie angezeigt. Wechselt der User die
        Kategorie, werden neue Produkte geladen. Jedes Produkt wird
        angezeigt mit Name, Bild, Preis und Bewertung.</li>
    <li>Bei jedem Produkt gibt es die Option via Link „In den Warenkorb
        legen“. Klickt der User auf den Link, wird das gewählte Produkt im
        Warenkorb abgelegt.</li>
    <li>Das Ablegen von Produkten im Warenkorb soll via AJAX erfolgen und
        ohne Page-Reload funktionieren.
    <li>Neben einem kleinen Warenkorbsymbol auf der Seite wird die aktuelle
        Anzahl der sich gerade im Warenkorb befindlichen Produkte angezeigt
        – diese Zahl wird ebenfalls via AJAX aktualisiert. Beim Stöbern durch
        die Produkte und beim „Einkaufen“ soll der User nie die Seite verlassen
        müssen.</li>
    <li>Produkte können auch via Drag’n’Drop auf das Warenkorb-Symbol
        gezogen werden, um darin abgelegt zu werden.
    <li>Navigiert der User in den Bereich „Warenkorb“ werden alle Produkte
        als Liste angezeigt, welche im Warenkorb abgelegt wurden sowie der
        Gesamtpreis aller Produkte. Jedes Produkt kann wieder aus dem
        Warenkorb entfernt oder mehrfach abgelegt (Anzahl erhöhen) werden</li>
</ol>