<?php


?>

<h2>Welcome to Banana Yoghurt Land</h2>
<h3>to Do</h3>
<ul type="circle">
    <li>destroy session when user closes browser</li>
    <li><a href="https://stackoverflow.com/questions/24402047/php-session-destroy-after-closing-browser" target="_blank">StackOverflow</a></li>
    <li>phpFunctions/load/main.php</li>
    <li>Aus der session checken wer eingeloggt ist, um zu garantieren dass er wirklich zugriff hat.</li>
</ul>

<p class='bg-success'>Admin user: admin<br>Password: bananaadmin<br>
<?php
//include "classes/securitas.class.php";
$password = "bananaadmin";
$hash = hash("sha256", $password);
echo "hashcode: ".$hash;
?></p>
<a href="dbConnectiontest.php?page=9">db tester</a>
<p>1) Users-Registrierung</p>
<ol>
    <li>Jeder User kann ein neues Benutzerkonto für den Webshop anlegen</li>
    <li>Beim Erfassen der Users sind folgende Daten anzugeben:
        <ol>
            <li>Anrede</li>
            <li>Vorname</li>
            <li>Nachname</li>
            <li>Adresse</li>
            <li>PLZ</li>
            <li>Ort</li>
            <li>Emailadresse</li>
            <li>Benutzername</li>
            <li>Passwort</li>
            <li>Zahlungsinformationen</li>
        </ol>
    </li>
    <li>Überprüfen Sie alle Parameter sowohl mittels HTML5/JavaScriptValidierung
        also auch serverseitig auf Vollständigkeit und
        Richtigkeit. Ergänzen Sie etwaige HTML5-Unvollständigkeiten. Das
        Passwort muss immer 2x angegeben werden und die Werte werden
        auf Übereinstimmung geprüft. Erst wenn alle Daten validiert
        wurden, wird der neue User in der DB angelegt. Das Passwort wird
        verschlüsselt in der DB abgelegt.</li>
    <li>Legen Sie manuell in der Datenbank einen weiteren User an, der als
        Administrator gekennzeichnet wird. Die Rechte des Administrators
        unterscheiden sich von herkömmlichen Usern.</li>
    <li>Legen Sie manuell in der Datenbank einen weiteren User an, der als
        Administrator gekennzeichnet wird. Die Rechte des Administrators
        unterscheiden sich von herkömmlichen Usern.</li>
</ol>
<p>2) User-Login</p>
<ol>
    <li>Erstellen Sie ein Login-Formular welches Usernamen und Passwort
        entgegennimmt</li>
    <li>Weiters enthält das Formular eine Checkbox mit der Option „Login
        merken“</li>
    <li>Überprüfen Sie die Werte gegen die Datenbank. Nur wenn es einen
        User in der DB mit den Daten, bekommt der/die UserIn die
        Rückmeldung „Hallo User“. Der Login-Status ist permanent auf der
        Seite sichtbar. Eingeloggte User sehen einen Logout-Button.</li>
    <li>Auf Basis des eingeloggten Users, werden unterschiedliche Menüs
        generiert.
        <ol>
            <li>Ist kein User eingeloggt, sind nur die Bereiche „Home“,
                „Produkte“ und „Warenkorb“ zu sehen</li>
            <li>Ein eingeloggter User sieht die Einträge „Home“, „Produkte“,
                „Mein Konto“, „Warenkorb“</li>
            <li>Ein Administrator sieht „Home“, „Produkte bearbeiten“,
                „Kunden bearbeiten“ und „Gutscheine verwalten“</li>
        </ol>
    </li>
    <li>Falls der User „Login merken“ aktiviert hat, wird auch ein Cookie
        angelegt, welches den User automatisch einloggt, wenn es gesetzt
        ist.</li>
    <li>Achten Sie darauf, dass beim Schließen des Browsers auch die
        Session gelöscht wird und der User ausgeloggt ist, es sei denn, es
        wurde ein Cookie gesetzt, um sich den Login zu merken, dann wird
        der User beim erneuten Öffnen der Web-Adresse als eingeloggt
        angezeigt.</li>
</ol>

