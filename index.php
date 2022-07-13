<?php
    include_once("header.php")
?>
<div class="leftWrapper">
    <?php
        if(isset($_SESSION["userUid"])){
            include_once("includes/functions-inc.php");
            include_once("includes/dbh-inc.php");
    
            showTop10Trends($conn);
        } else{
            header("location: login.php?error=plslogin");
            exit();
        }
        
    ?>
</div>
<div class="middleWrapper">
    <section class="index-intro">
        <?php
            if(isset($_SESSION["userUid"])){
                echo('<h1 class="index-intro-welcome">Bienvenido/a ' . $_SESSION["userUid"] . '!</h1>');
            } else{
                header("location: login.php?error=plslogin");
                exit();
            }
        ?>
        <!-- <h1>Aqui va el Feed lmao</h1> -->
        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Semper auctor neque vitae tempus quam pellentesque nec nam. Pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus. Cras ornare arcu dui vivamus arcu felis bibendum ut tristique. Ipsum dolor sit amet consectetur adipiscing. Quam viverra orci sagittis eu volutpat odio. Arcu non sodales neque sodales ut. Blandit turpis cursus in hac habitasse platea dictumst quisque. A iaculis at erat pellentesque adipiscing commodo elit. In massa tempor nec feugiat nisl pretium. Facilisis mauris sit amet massa vitae tortor condimentum lacinia quis. Ullamcorper morbi tincidunt ornare massa eget. Donec enim diam vulputate ut pharetra sit. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Praesent tristique magna sit amet purus gravida quis blandit turpis.</p> -->
    </section>
    <!--  Aqui pongo para twittear, asi como un scroll con el feed donde el primer elemento permite twittear en la cuenta  -->
    <section class="index-main">

        <div class="index-post">
            <div class="index-post-wrapper">
                <a class="index-post-user" href="profile.php"><?php echo("@" . $_SESSION["userUid"])?></a>
            </div>
            <form class="index-post-textContainer" action="includes/index-inc.php" method="POST">
                <textarea id="postTextarea" maxlength="279" name="message" placeholder="What's happening?"></textarea>
                <!---->
                <div class="hash-box-wrapper">
                    <div class="hash-box" role="listbox" aria-multiselectable="false">
                    <ul>
                    </ul>
                    </div>
                </div>
                <div class="buttonsContainer">
                    <input type="submit" id="submitPostButton" name="submitUsmito" role="button" value="POST">
                    <div class="w-count-wrapper">
                        <div id="count">279 max</div>
                        <div class="vertical-pipe"></div>
                    </div>
                    <div class="index-post-checkbox">
                        <input type="checkbox" id="closeFriends" name="closeFriends" value="closeFriends">
                        <label for="closeFriends">Close Friends?</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="horizontalSeparator2"></div>
        <div class="index-feed">
        <?php

            include_once("includes/functions-inc.php");
            include_once("includes/dbh-inc.php");

            $username = $_SESSION["userUid"];
            $feedUsmitos = getUserFollowedUsmitos($conn, $username);

            if($feedUsmitos !== false){
                showUsmitosFeedFrom($conn, $feedUsmitos);
            } else{
                echo("No hay usmitos que mostrar :(");
            }

            

        ?>
        </div>
    </section>
</div>
<div class="rightWrapper">

</div>

<?php
    include_once("footer.php")
?>