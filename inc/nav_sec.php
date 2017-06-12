<div class="div_nav">
    <nav class="navbar navbar-default" id="nav_sec">
        <div class="container-fluid" class="nav_sec">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
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
                    $menuItems->secondMenuGenerator($role);
                    ?>
                </ul>
                <?php
                
                if($role == "user"||$role == "visitor" ){
                
                ?>
                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" id='search-input' class="form-control" placeholder="Search">
                    </div>
                </form>
                <?php
                }
                ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
