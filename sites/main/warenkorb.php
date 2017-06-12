
<div class='cartContent'>
<?php
    // check if order has been placed

    if(!isset($_SESSION['user'])){
        include 'sites/login.php';
    }else{
        if(isset($_GET['ordertype'])){
        require_once './classes/securitas.class.php';
        
        //determine how payment was delivered
        if($_GET['ordertype']=='gutschein'){
            $coupon = $_POST['gutschein'];
            $sec = new securitas();
            
            if($sec->checkString5($coupon) && $sec->checkCoupon($coupon)){
                $coupon_value = $sec->getCouponValue($coupon);
                if($coupon_value < 0){
                    echo "Coupon either has no value or is expired.";
                }else{
                    paymentByCoupon($coupon, $coupon_value);
                }               
            }else{
                echo "Invalid coupon. Coupon has to be exactly 5 characters and contain numbers. "
                    . "<br/>Or it doesn't exist in our system.<br/><br/>"
                    . "Please contact someone who cares.";
            }
            
        }elseif($_GET['ordertype']=='zahlungsart'){
            $method = $_POST['zahlungsart'];
            $sec = new securitas();
            
            if($sec->checkNumeric($method,1,3)){
                addToBestellung(true, $method);
                
                echo "<h3>Vielen Dank für Ihre Bestellung</h3><hr>"
                    . "<img src='pictures/thankYou.gif' alt=''><hr>";
            }else{
                echo "Invalid payment method. Please sit the fuck down and don't screw with our code";
            }
               
            }       
        }else{
            //check if user wants to place order after confirming shoppingcart
            if(isset($_GET['ordered'])){
                printFormOrder();  
            }else{
                // check if products in shopping cart are available
                if(!isset($_SESSION['shoppingcart'])){
                    echo "Keine Produkte im Warenkorb vorhanden.";
                }else{
                    printTableOrder();
                }
            }
        }
?>
</div>
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

<script src="./scripts/checkOrder.js"></script>

    

    
<?php
}
function printTableOrder(){
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

function printFormOrder(){
        $dbs = new DB();
        
        $username = $_SESSION['user'][0];
        $pid = $dbs->getPid($username);
        
        echo "<form method='post' class='form-inline' id='zahlungsart_form' action='?page=3&ordertype=zahlungsart'>";
            echo "<div class='form-group'>";
                echo "<label class='orderLabel' for='zahlungsart'>Zahlungsart</label>";
                echo "<select class='form-control orderInput' required name='zahlungsart' id='zahlungsart'>";
                    echo "<option value=''>Zahlungsart wählen ...</option>";
                    $dbs->getZahlungsdatenAsOptions($pid);
                echo "</select>";
            echo "</div>";
            echo "<button type='submit' class='btn btn-default'>Senden</button>";
            echo "<div class='order_error_div' id='zahlungsart_error'></div>"; 
        echo "</form>";
        echo "<div><br/>------------------- ODER -------------------</div><br/>";
        echo "<form method='post' class='form-inline' id='gutschein_form' action='?page=3&ordertype=gutschein'>";           
            echo "<div class='form-group'>";
                echo "<label class='orderLabel' for='gutschein'>Gutschein</label>";
                echo "<input type='text' class='form-control orderInput' name='gutschein' required id='gutschein' placeholder='z. B.: X5GA7'>";                
            echo "</div>";           
            echo "<button type='submit' class='btn btn-default'>Senden</button>";
            echo "<div class='order_error_div' id='gutschein_error'></div>"; 
        echo "</form>";       
}

function paymentByCoupon($coupon, $coupon_value){
    $order_price = $_SESSION['shoppingcart'][0]->getPriceAll();
    $order_price = number_format((float)$order_price, 2, '.', '');
    $newCoupon_value = $coupon_value - $order_price;
    
    if($newCoupon_value <= 0){
        echo "Leider ist ihr Gutschein weniger wert als die Bestellung.</br>"
            . "Bestellungen können nur mit Gutscheinen bezahlt werden, wenn sie"
            . " unter dem aktuellen Wert des Gutscheins liegen.";
    }else{
        $sec = new securitas();
        addToBestellung(false, $coupon);

        if($sec->decreaseCouponValue($coupon, $newCoupon_value)){
            echo "<h3>Vielen Dank für Ihre Bestellung!</h3><hr>";
            echo "<img src='pictures/thankYou.gif' alt=''><hr>";
            echo "<h5>Gutschein-Code: ".$coupon."</h5>";
            echo "<table id='orderTable'>";
            echo "<tbody>";
            echo "<tr>";
            echo "<td class='orderDesc'>Gutschein, alt</td><td class='orderVal'>€ ".$coupon_value."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='orderDesc'>- Bestellungswert</td><td class='orderVal'>€ ".$order_price."</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='orderDesc'>Gutschein, neu</td><td class='orderVal'>€ ".$newCoupon_value."</td>";
            echo "</tr>";
            echo "</tbody>";    
            echo "</table>";
        }else{
            echo "HOLY BANANOES! There seems to be a problem with our database.<br/>"
                . "Please contact somebody who cares as fast as possible!";
        }          
    } 
}

function addToBestellung($withZid, $zidOrGid){
    //determine if user pays with coupon or payment method
    $sec = new securitas();
    $db = new DB();
    $success = false;
    if($withZid){
        $zid = $zidOrGid;
        $bid = $sec->getLatestBid() + 1;
        $username = $_SESSION['user'][0];
        $pid = $db->getPid($username);
        
        for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
            $produktid = $_SESSION['shoppingcart'][$i]->getId();
            $anzahl = $_SESSION['shoppingcart'][$i]->getCount();

            $success = $db->insertBestellung($withZid, $bid, $produktid, $pid, $zid, $anzahl);
        }
        unset($_SESSION['shoppingcart']);
        return $success;
        
    }else{
        $gid = $db->getCouponId($zidOrGid);
        $bid = $sec->getLatestBid() + 1;
        $username = $_SESSION['user'][0];
        $pid = $db->getPid($username);
        
        for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
            $produktid = $_SESSION['shoppingcart'][$i]->getId();
            $anzahl = $_SESSION['shoppingcart'][$i]->getCount();

            $success = $db->insertBestellung($withZid, $bid, $produktid, $pid, $gid, $anzahl);
        }
        unset($_SESSION['shoppingcart']);
        return $success;
    }
}