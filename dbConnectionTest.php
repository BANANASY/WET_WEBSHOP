<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //INCLUDE "./config/dbaccess.php";

        $host = "mysqlsvr71.world4you.com";
        $user = "sql2558943";
        $password = "uxevy+j";
        $dbname = "7048141db1";

        $conn = new mysqli($host, $user, $password, $dbname);


        //$test = new DB();

        if ($conn) {
            echo "<br />DB connected";

            $stmt = "SELECT * FROM adresse;";
            $query = $conn->query($stmt);
            if ($query) {
                while ($row = $query->fetch_object()) {
                    echo $row->ort;
                }
            } else {
                echo "Query failed";
            }
        } else {
            echo "DB connection failed.";
        }
        ?>
    </body>
</html>
