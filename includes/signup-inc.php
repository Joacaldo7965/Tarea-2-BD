<?php

if(isset($_POST["submit"])){
    
    $username = trim($_POST['uid']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $pwdRepeat = trim($_POST['pwd2']);

    require_once("dbh-inc.php");
    require_once("functions-inc.php");

    if(emptyInputSignup($username, $email, $pwd, $pwdRepeat) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidUid($username) !== false){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if(invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    if(pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: ../signup.php?error=pwddm");
        exit();
    }

    if(uidExists($conn, $username, $email) !== false){
        header("location: ../signup.php?error=uidtaken");
        exit();
    }

    // If user pass all error handling
    $fechareg = date("d/m/y");

    createUser($conn, $username, $email, $pwd, $fechareg);

}
else{
    header("location: ../signup.php");
    exit();
}