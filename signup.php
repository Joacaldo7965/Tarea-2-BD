<?php
    include_once("header.php")
?>

<div class="middleWrapper">
    <section class="signup-form">
        
        <div class="signup-form-div">
            <form class="signup-form-form" action="includes/signup-inc.php" method="post">  
                <h1>Sign Up</h1>
                <input class="input-form" type="email" name="email" placeholder="Email">
                <input class="input-form" type="text" name="uid" placeholder="Username">
                <input class="input-form" type="password" name="pwd" placeholder="Password">
                <input class="input-form" type="password" name="pwd2" placeholder="Repeat Password">
                <button class="signup-form-button" type="submit" name="submit">Sign Up</button>
            </form>
            <?php

            if(isset($_GET["error"])){
                if($_GET["error"] == "emptyinput"){
                    echo('<p class="message-error">Por favor llene todos los campos!</p>');
                } else if($_GET["error"] == "invaliduid"){
                    echo('<p class="message-error">Nombre de usuario no valido</p>');
                } else if($_GET["error"] == "invalidemail"){
                    echo('<p class="message-error">Email no valido</p>');
                } else if($_GET["error"] == "pwddm"){
                    echo('<p class="message-error">Las contraseñas no coinciden</p>');
                } else if($_GET["error"] == "uidtaken"){
                    echo('<p class="message-error">Nombre de usuario o email ya está registrado</p>');
                } else if($_GET["error"] == "stmtfailed"){
                    echo('<p class="message-error">Algo salio mal :(</p>');
                } else if($_GET["error"] == "none"){
                    echo('<p class="message-succes">Te has registrado exitosamente! :D</p>');
                    echo('<p class="message-succes">Por favor inicia sesión</p>');
                } else if($_GET["error"] == "deleteAccount"){
                    echo('<p class="message-normal">Tu cuenta ha sido eliminada :(</p>');
                }
            }
            ?>
        </div>
        
    </section>
</div>


<?php
    include_once("footer.php");
?>