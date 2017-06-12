<h2 class="page-header">Stammdaten ändern</h2>
<ul class="pager">
    <li class="previous"><a href="?page=2"><span aria-hidden="true">&larr;</span>Zurück</a></li>
</ul>
<?php
INCLUDE_once './classes/securitas.class.php';

if (!empty($_SESSION)) {
    $user = $_SESSION['user'];
    $username = $user[0];
    $sec = new securitas();
    $db = new DB();

    //check if zahlungsart formular was submitted
    if (!empty($_POST['credit'])) {
        if ($sec->checkNumeric($_POST['credit'], 1, 3)) {
            $zid = $_POST['credit'];
            $db = new DB();
            $pid = $db->getPid($username);
            if ($db->insertToZahlung($zid, $pid)) {
                ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Holly Bananas!</strong> Die Zahlungsart wurde hinzugefügt.
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Holly Bananas!</strong> Die Zahlungsart gibt es schon.
                </div>
                <?php
            }
        }
    }

    //check if change password formular was submitted
    if (!empty($_POST['changePass'])) {

        if ($_POST['password1'] === $_POST['password2']) {
            if ($sec->checkPassword($_POST['password1'])) {
                $hash = hash("sha256", $_POST['password1']);
                if ($db->alterPassword($username, $hash)) {
                    ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Holly Bananas!</strong> Das Passwort wurde geändert.
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Holly Bananas!</strong> Das Passwort konnte nicht geändert werden.
                    </div>
                    <?php
                }
            }
        }
    }

    //check if change core formular was submitted
    if (!empty($_POST['core'])) {
        $allGood = true;
        $pid = $db->getPid($username);
        if (!empty($_POST['anrede'])) {
            if ($sec->checkNumeric($_POST['anrede'], 1, 3)) {
                switch ($_POST['anrede']) {
                    case 1:
                        $anrede = "Herr";
                        break;
                    case 2:
                        $anrede = "Frau";
                        break;
                    case 3:
                        $anrede = "Erwin";
                        break;
                }
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['firstName'])) {
            if ($sec->checkString50($_POST['firstName'])) {
                $vorname = $_POST['firstName'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['lastName'])) {
            if ($sec->checkString50($_POST['lastName'])) {
                $nachname = $_POST['lastName'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['adress'])) {
            if ($sec->checkString255($_POST['adress'], true)) {
                $strasse = $_POST['adress'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['zip'])) {
            if ($sec->checkNumeric($_POST['zip'], 1000, 10000)) {
                $plz = $_POST['zip'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['place'])) {
            if ($sec->checkString255($_POST['place'], false)) {
                $ort = $_POST['place'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if (!empty($_POST['email'])) {
            if ($sec->checkEmail($_POST['email'])) {
                $email = $_POST['email'];
            } else {
                $allGood = false;
            }
        } else {
            $allGood = false;
        }
        if ($allGood) {
            if ($db->alterCore($anrede, $vorname, $nachname, $strasse, $plz, $ort, $email, $pid)) {
                ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Holly Bananas!</strong> Die Core Daten wurden geändert.
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Holly Bananas!</strong> Gib die Core Daten gscheit ein!
            </div>
            <?php
        }
    }
}

//User Details anzeigen
if (!empty($username)) {
    if ($db->getCustDetails($username)) {
        
    }
}




$currentUser = $db->getCustDetailsAsArray($username);
?>

<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Holly Bananas!</strong> Hier kannst du deine Stammdaten ändern. Gib immer dein aktuelles Passwort ein!
</div>

<div class="col-md-8">
    <h4>Core bearbeiten</h4>
    <form class="changeButtons form-horizontal" action="?page=15" method="post" id="core_form">
        <div class="form-group">
            <label for="salutation" class="col-sm-3 control-label">Salutation:</label>
            <div class="col-sm-6 register_div">
                <select class="form-control" name="anrede" required id="salutation">
                    <?php
                    $salut = $currentUser['anrede'];
                    switch ($salut) {
                        case "Herr":
                            echo "<option value='1' selected>Mr</option>";
                            echo "<option value='2'>Mrs</option>";
                            echo "<option value='3'>Something in between</option>";
                            break;
                        case "Frau":
                            echo "<option value='1' >Mr</option>";
                            echo "<option value='2' selected>Mrs</option>";
                            echo "<option value='3'>Something in between</option>";
                            break;
                        case "Erwin":

                            echo "<option value='1' >Mr</option>";
                            echo "<option value='2'>Mrs</option>";
                            echo "<option value='3' selected>Something in between</option>";
                            break;
                        default:
                            echo "<option value='1' >Mr</option>";
                            echo "<option value='2'>Mrs</option>";
                            echo "<option value='3'>Something in between</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="register_error_div col-sm-3" id="salutation_error"></div>
        </div>
        <div class="form-group">
            <label for="firstName" class="col-sm-3 control-label">First Name</label>
            <div class="col-sm-6 register_div">
                <input type="text" class="form-control" required id="firstName" name="firstName" <?php echo "value='" . $currentUser['vorname'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="firstName_error"></div>
        </div>
        <div class="form-group">
            <label for="lastName" class="col-sm-3 control-label">Last Name</label>
            <div class="col-sm-6 register_div">
                <input type="text" class="form-control" required id="lastName" name="lastName"<?php echo "value='" . $currentUser['nachname'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="lastName_error"></div>
        </div>
        <div class="form-group">
            <label for="adress" class="col-sm-3 control-label">Adress</label>
            <div class="col-sm-6 register_div">
                <input type="text" class="form-control" required id="adress" name="adress" <?php echo "value='" . $currentUser['strasse'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="adress_error"></div>
        </div>
        <div class="form-group">
            <label for="zip" class="col-sm-3 control-label">ZIP</label>
            <div class="col-sm-6 register_div">
                <input type="number" class="form-control" required id="zip" name="zip" <?php echo "value='" . $currentUser['plz'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="zip_error"></div>
        </div>
        <div class="form-group">
            <label for="place" class="col-sm-3 control-label">Place</label>
            <div class="col-sm-6 register_div">
                <input type="text" class="form-control" required id="place" name="place" <?php echo "value='" . $currentUser['ort'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="place_error"></div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-6 register_div">
                <input type="email" class="form-control" required id="email" name="email" <?php echo "value='" . $currentUser['email'] . "'" ?>>
            </div>
            <div class="register_error_div col-sm-3" id="email_error"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input id="submit" type="submit" class="btn btn-default" value="Änderungen übernehmen" name="core">
            </div>
        </div>
    </form>
</div>
<div class="col-md-4">
    <h4>Zahlungsart hinzufügen</h4>
    <form class = 'form-horizontal changeButtons' id='payment_methodChange' action = '?page=15' method = 'post'>
        <div class='form-group'>
            <select class='form-control' name='credit' required id='credit'>
                <?php
                $zahlungsarten = $db->getZahlungsinfo();
                $id = 1;
                foreach ($zahlungsarten as $zahlungsart) {
                    echo "<option value=" . $id . ">" . $zahlungsart . "</option>";
                    $id++;
                }
                ?>
            </select>
            <div class="register_error_div col-sm-3" id="credit_error"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <input id="submit" type="submit" class="btn btn-default" value="Zahlungsart hinzufügen" name="zahlung">
            </div>
        </div>
    </form>
</div>
<div class="col-md-4">
    <h4>Passwort ändern</h4>
    <form class = 'form-horizontal changeButtons' id='password_change' action = '?page=15' method = 'post'>
        <div class="form-group">
            <label for="password1" class="col-md-4 control-label">Passwort</label>
            <div class="col-md-7 register_div">
                <input type="password" class="form-control" required id="password1" name="password1">                
            </div>
            <div class="register_error_div col-md-1" id="password1_error"></div>
        </div>
        <div class="form-group">
            <label for="password2" class="col-md-4 control-label">Nochmal</label>
            <div class="col-md-7 register_div">
                <input type="password" class="form-control" required id="password2" name="password2">
            </div>
            <div class="register_error_div col-md-1" id="password2_error"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <input id="submit" type="submit" class="btn btn-default" value="Passwort ändern" name="changePass">
            </div>
        </div>


    </form>
</div>
<div class="col-md-4" id="passwordField">
    <div class="col-md-12 jumbotron">
        <h5>Aktuelles Passwort eingeben</h5>
        <input type="password" class="form-control " required id="pw_input" name="password">      
        <div id="wrongPassword"></div>
    </div>

</div>



<!-- checks the form clientside -->
<script src="./scripts/checkRegister.js"></script>

<script>
    $(document).ready(function () {

        $('.changeButtons').submit(function () {
            var pw_input = $('#pw_input').val();
            var passVaild = false;

            $.ajax({
                type: "POST",
                url: 'phpFunctions/checkPassword.php',
                data: {pw: pw_input},
                async: false,
                success: function (data) {
                    remote = data;
                }
            });
            if (remote === "passed") {
                return true;
            } else {
                alert("GUCK MAL UNTEN RECHTS");
                $("#wrongPassword").css("border-left", "5px solid red");
                $("#wrongPassword").css("padding-left", "10px");
                $("#wrongPassword").html("<p class='bg-danger'>Du Pfeife! Gib mal hier dein aktuelles Passwort ein, dann kannst du's nochmal probiern.</p>");
                return false;
            }
        });
    });


</script>
