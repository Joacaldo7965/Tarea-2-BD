<?php
    include_once("header.php")
?>

<div class="middleWrapper">
    <section class="explore">

        <!--<h2>Work in Progress</h2>-->

        <h2 class='explore-users-title'>Users</h2>
        <div class="horizontalSeparator1"></div>
        <?php

            if(!isset($_SESSION["userUid"])){
                header("location: login.php?error=plslogin");
                exit();
            }

            include_once("includes/dbh-inc.php");
            include_once("includes/functions-inc.php");

            $users = getAllUsers($conn);

            showUsersFrom($conn, $users);
        ?>
        
    </section>
</div>


<?php
    include_once("footer.php")
?>