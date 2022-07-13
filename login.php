<?php
    include_once("header.php")
?>
<div class="middleWrapper">
    <section class="login-form">
        <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "plslogin"){
                echo('<h3 class="message-normal">Por favor ingrese a su cuenta</h3>');
            }
        }
        ?>

        <div class="login-form-div">
            <form class="login-form-form" action="includes/login-inc.php" method="post">  
                <h1>Login</h1>
                <input class="input-form" type="text" name="uid" placeholder="Username/Email">
                <input class="input-form" type="password" name="pwd" placeholder="Password">
                <button class="login-form-button" type="submit" name="submit">Ingresar</button>
            </form>
            <?php

            if(isset($_GET["error"])){
                if($_GET["error"] == "emptyinput"){
                    echo('<p class="message-error">Por favor llene todos los campos!</p>');
                } else if($_GET["error"] == "wronglogin"){
                    echo('<p class="message-error">Nombre de usuario o contraseña incorrectos!</p>');
                }
            }
            ?>
        </div>

        
    </section>
</div>


<?php
    include_once("footer.php")
?>