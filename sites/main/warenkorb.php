
<div class='cartContent'>
<?php
//    var_dump($_SESSION);
    if(isset($_GET['ordered'])){
        $dbs = new DB();
        $username = $_SESSION['user'][0];
        $pid = $dbs->getPid($username);
        
        echo "<form class='form-inline'>";
            echo "<div class='form-group'>";
                echo "<label class='sr-only' for='zahlungsart'>Zahlungsart</label>";
                echo "call function";
                echo "<select class='form-control' name='zahlungsart' id='zahlungsart'>";
                    echo "<option value=''>Zahlungsart wählen ...</option>";
                    
                    echo $dbs->getZahlungsdatenAsOptions($pid);
                echo "</select>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-default'>Senden</button>";
        echo "</form>";
        echo "<div><br/>------------------- ODER -------------------</div><br/>";
        echo "<form class='form-inline'>";           
            echo "<div class='form-group'>";
                echo "<label class='sr-only' for='gutschein'>Gutschein</label>";
                echo "<input type='text' class='form-control' id='gutschein' placeholder='z. B.: X5GA7'>";
            echo "</div>";           
            echo "<button type='submit' class='btn btn-default'>Senden</button>";
        echo "</form>";
    }else{
        if(!isset($_SESSION['shoppingcart'])){
            echo "Keine Produkte im Warenkorb vorhanden.";
        }else{
            $cartSize = count($_SESSION['shoppingcart']);
            //get table of products in shopping cart

            echo "<table id='cartTable'>";
            echo "<thead>";
            echo "<tr class='cartThead'>";
            echo "<td><b>Bezeichnung</b></td>";
            echo "<td><b>Anzahl</b></td>";
            echo "<td><b>Einzelpreis</b></td>";
            echo "<td><b>Gesamtpreis</b></td>";
            echo "<td style='text-align:center'><b>Löschen</b></td>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                for($i = 1;$i < $cartSize;$i++){

                    $_SESSION['shoppingcart'][$i]->printAsTableRow();
                }
            echo "</tbody>";
            echo "<tr class='tr_borderTop'>";
            echo "<td class='td_pullRight'><b>Total</b></td>";
            echo "<td class='cartResult'><b><div class='displayInline' id='allProductsCount'>".$_SESSION['shoppingcart'][0]->getCount()."</div> Stk.</b></td>";
            echo "<td class='td_pullRight'><b>Summe</b></td>";
            echo "<td class='cartResult'><b>€ <div class='displayInline' id='allProductsPrice'>".$_SESSION['shoppingcart'][0]->getPriceAll()."</div></b></td>";
            echo "</tr>";     
            echo "</table>";
            echo "<a id='orderButton' href='?page=3&ordered=true'>Bestellen</a>";
        }
    }
    
?>

</div>
<br/>
<hr>
<h2>Warenkorb</h2>
<p>5) Produkte bestellen</p>
<ol>
    <li>Im Bereich Warenkorb kann der User, sofern Produkte im
        Warenkorb sind, die Produkte bestellen.</li>
    <li>Bestellungen sind nur möglich, wenn der User angemeldet ist. Nach
        dem Login, sollen immer noch alle Daten im Warenkorb sichtbar
        sein.</li>
    <li>Bei der Bestellung muss der Kunde eine seiner
        Zahlungsmöglichkeiten auswählen oder er bezahlt mittels
        Gutschein. Der Gutscheinwert wird vom Gesamtbetrag abgezogen
        bzw. bleibt der Restwert bei nur teilweiser Einlösung erhalten.</li>
    <li>Sind Daten unvollständig, kann die Bestellung nicht abgeschlossen
        werden und die Produkte verbleiben im Warenkorb.</li>
    <li>Die Bestellung wird in der DB abgelegt, sodass jederzeit
        nachvollziehbar ist, welcher Kunde welche Produkte bestellt hat. Ein
        Kunde solle jederzeit die Details zur Bestellung einsehen können.</li>

</ol>