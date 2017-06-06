<?php
require_once './classes/DB.class.php';

$db = new DB();
?>


<div class="div_login">
    <h2 id="regform_title">Register form</h2>
    <form class="form-horizontal" action="?page=10" method="post" id="register_form">
        <div class="form-group">
            <label for="salutation" class="col-sm-2 control-label">Salutation:</label>
            <div class="col-sm-5 register_div">
                <select class="form-control" name="salutation" required id="salutation">
                    <option value="">Choose Salutation ...</option>
                    <option value="1">Mr</option>
                    <option value="2">Mrs</option>
                    <option value="3">Something in between</option>
                </select>
            </div>
            <div class="register_error_div col-sm-5" id="salutation_error"></div>
        </div>
        <div class="form-group">
            <label for="firstName" class="col-sm-2 control-label">First Name</label>
            <div class="col-sm-5 register_div">
                <input type="text" class="form-control" required id="firstName" name="firstName">
            </div>
            <div class="register_error_div col-sm-5" id="firstName_error"></div>
        </div>
        <div class="form-group">
            <label for="lastName" class="col-sm-2 control-label">Last Name</label>
            <div class="col-sm-5 register_div">
                <input type="text" class="form-control" required id="lastName" name="lastName">
            </div>
            <div class="register_error_div col-sm-5" id="lastName_error"></div>
        </div>
        <div class="form-group">
            <label for="adress" class="col-sm-2 control-label">Adress</label>
            <div class="col-sm-5 register_div">
                <input type="text" class="form-control" required id="adress" name="adress">
            </div>
            <div class="register_error_div col-sm-5" id="adress_error"></div>
        </div>
        <div class="form-group">
            <label for="zip" class="col-sm-2 control-label">ZIP</label>
            <div class="col-sm-5 register_div">
                <input type="number" class="form-control" required id="zip" name="zip">
            </div>
            <div class="register_error_div col-sm-5" id="zip_error"></div>
        </div>
        <div class="form-group">
            <label for="place" class="col-sm-2 control-label">Place</label>
            <div class="col-sm-5 register_div">
                <input type="text" class="form-control" required id="place" name="place">
            </div>
            <div class="register_error_div col-sm-5" id="place_error"></div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-5 register_div">
                <input type="email" class="form-control" required id="email" name="email">
            </div>
            <div class="register_error_div col-sm-5" id="email_error"></div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-5 register_div">
                <input type="text" class="form-control" required id="username" name="username">
            </div>
            <div class="register_error_div col-sm-5" id="username_error"></div>
        </div>
        <div class="form-group">
            <label for="password1" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-5 register_div">
                <input type="password" class="form-control" required id="password1" name="password1">                
            </div>
            <div class="register_error_div col-sm-5" id="password1_error"></div>
        </div>
        <div class="form-group">
            <label for="password2" class="col-sm-2 control-label">Repeat password</label>
            <div class="col-sm-5 register_div">
                <input type="password" class="form-control" required id="password2" name="password2">
            </div>
            <div class="register_error_div col-sm-5" id="password2_error"></div>
        </div>
        <div class="form-group">
            <label for="credit" class="col-sm-2 control-label">Payment method:</label>
            <div class="col-sm-5 register_div">
                <select class="form-control" name="credit" required id="credit">
                    <option value="">Choose payment method ...</option>
                    <?php
                    $zahlungsarten = $db->getZahlungsinfo();
                    $id=0;
                    foreach($zahlungsarten as $zahlungsart){
                        echo "<option value=".$id.">".$zahlungsart."</option>";
                        $id++;
                    }
                    ?>
                </select>
            </div>
            <div class="register_error_div col-sm-5" id="credit_error"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button id="submit" type="submit" class="btn btn-default">Register</button>
            </div>
        </div>
    </form>
</div>

<!-- checks the form clientside -->
<script src="./scripts/checkRegister.js"></script>
