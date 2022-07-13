<?php

session_start();

if(isset($_SESSION["userUid"]) === false){
    header("location: login.php?error=plslogin");
    exit();
}

if(isset($_POST["submitEdit"]) === false && isset($_POST["deleteProfile"]) === false){
    header("location: ../profileEdit.php?error=xd");
    exit();
}

include_once("dbh-inc.php");
include_once("functions-inc.php");

if(isset($_POST["submitEdit"])){

    // TODO: Error handling (all empty inputs)

    if(isset($_POST["newUid"])){
        $newUsername = trim($_POST["newUid"]);

        if(empty($newUsername)){
            $newUsername = $_SESSION["userUid"];
        }

        if(invalidUid($newUsername) !== false){
            header("location: ../profileEdit.php?error=invaliduid");
            exit();
        }
    }else{
        $newUsername = $_SESSION["userUid"];
    }

    if(isset($_POST["newPwd"]) && isset($_POST["newPwd2"])){

        $newPwd = trim($_POST["newPwd"]);
        $newPwd2 = trim($_POST["newPwd2"]);

        if(pwdMatch($newPwd, $newPwd2) !== false){
            header("location: ../profileEdit.php?error=pwddm");
            exit();
        }

    } else{
        $newPwd = false;
    }

    updateUser($conn, $_SESSION["userUid"], $newUsername, $newPwd);

}elseif(isset($_POST["deleteProfile"])){

    // TODO: ask if sure to delete ALL his profile, messages, likes, etc.

    deleteUser($conn, $_SESSION["userUid"]);

} else{
    echo("Error!");
}
//exit();
?>