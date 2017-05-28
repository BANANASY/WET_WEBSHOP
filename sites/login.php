<?php

    include "./classes/DB.class.php";
    

?>

<div class="col-md-12 div_login">
        <div class="col-md-5 div_login" id="div_login_left">
            
            <form action="" method="post">
                <h4>Existing Customer</h4>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" >
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
        </div>
            
        <div class="col-md-1" id="div_login_middle"></div>
        
        <div class="col-md-5 div_login" id="div_login_right">
            <div id="div_login_right_inner">
                <h4>New Customer ... ?</h4>
                <p>Click this banana to register!</p>
                <a href="?page=8"> <img id="goRegister" src="./pictures/banana_button.jpg"></a>
            </div>            
        </div>
        </div>


