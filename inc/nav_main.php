<?php
    include "classes/menuItems.class.php";
?>

<nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">BaYo</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        //get user role from db ++toDo++
                        $user_role = "visitor";
                        
                        //generate menu according to user
                        $menuItems = new menuItems();
                        $menuItems->mainMenuGenerator($user_role);
                        
                        ?>
                        <!--<li class="active"><a href="#">Home<span class="sr-only">(current)</span></a></li>-->
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav navbar-right">
                            <li><p class="navbar-text" id="login-msg">You are not logged in.</p></li>
                            <li id="signup"><span class="glyphicon glyphicon-user"></span> Sign Up</li>
                            <li id="login"><span class="glyphicon glyphicon-log-in"></span> Login</li>
                        </ul>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>