<?php

include_once("header.php");

if(isset($_SESSION["userUid"]) === false){
    header("location: login.php?error=plslogin");
    exit();
}

if(isset($_POST["editProfile"]) === false){
    header("location: profile.php");
    exit();
}

// In this point user have session and it comes in natural way
?>
<div class="middleWrapper">
    <form action="includes/profileEdit-inc.php" method="POST">

        <input type="text" name="newUid" placeholder=<?php echo($_SESSION["userUid"]); ?>>
        <input type="password" name="newPwd" placeholder="Nueva contraseña">
        <input type="password" name="newPwd2" placeholder="Repetir Nueva contraseña">
        <input type="submit" name="submitEdit" value="Actualizar">

        <input type="submit" name="deleteProfile" value="BORRAR PERFIL">

    </form>
</div>

