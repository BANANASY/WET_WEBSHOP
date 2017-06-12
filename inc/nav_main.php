<?php
include "classes/menuItems.class.php";
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="?page=0"><img src="pictures/logo.png" style="height:50px" alt="BaYo"/></a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar_left">
                <?php
                //get user role from db 
                if (!empty($_SESSION['user'])) {
                    $user = $_SESSION['user'];
                    $role = $user[1];
                } else {
                    $role = "visitor";
                }
                //generate menu according to user
                $menuItems = new menuItems();
                //toDo++ get get page prüfen und mit weitegben
                $menuItems->mainMenuGenerator($role);
                ?>
                <!--<li class="active"><a href="#">Home<span class="sr-only">(current)</span></a></li>-->

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if (!empty($_SESSION['user'])) {
                        $user = $_SESSION['user'];
                        if ($user[1] == "user" || $user[1] == "admin") {

                            echo "<li><p class = 'navbar-text' id = 'login-msg'>Welcome " . $user[0] . "! Enjoy your Banana Shopping experience.</p></li>";
                            echo "<li id= 'logout' class = 'login-out'><span class = 'glyphicon glyphicon-log-out'></span> Logout</li>";
                        } else {
                            echo "Fuck off. Don't mess with our session.";
                        }
                    } else {
                        echo "<li><p class = 'navbar-text' id = 'login-msg'>You are not logged in.</p></li>";
                        echo "<li id = 'signup'><span class = 'glyphicon glyphicon-user'></span> Sign Up</li>";
                        echo "<li id = 'login' class = 'login-out'><span class = 'glyphicon glyphicon-log-in'></span> Login</li>";
                    }
                    ?>

                </ul>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<script type="text/javascript" src="./scripts/navbar.js"></script>