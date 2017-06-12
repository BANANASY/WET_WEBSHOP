<?php ?>

<h2 class="page-header text-center">We have lot's of love and lot's of passion for Bananas and Yoghurt</h2>
<img class="img-responsive img-thumbnail" id='bud' src="pictures/Banana-Joe.jpg" alt=""/>
<hr>
<h3>FAQs</h3>
<p class='bg'>Q: "Do you have a lot of passion for bananas and yoghurt?"</p>
<p>A: "Yes, yes we have lots and lots of bananas and yoghurt."</p>

<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Holly Bananas!</strong> You're not supposed to see this. Well it's is just for you Frau Pohn ;)<br>
    Admin user: admin<br>
    Password: bananaadmin<br>
    <?php
    $password = "bananaadmin";
    $hash = hash("sha256", $password);
    echo "hashcode: " . $hash;
    ?>
</div>



