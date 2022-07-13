<?php

if(isset($_POST["submitUsmito"])){
    
    session_start();
    $username = $_SESSION["userUid"];
    $message = trim($_POST['message']);
    $likes = 0;
    $tags;
    $type = "USMITO";
    //$idPadre;
    $closeFriends = $_POST['closeFriends'];

    require_once("dbh-inc.php");
    require_once("functions-inc.php");

    if(emptyInputMessage($message) !== false){
        header("location: ../index.php?error=emptyinput");
        exit();
    }
    // If user pass all error handling
    $tags = getTagsFromMessage($conn, $message);  // Return the tags separated by commas and upload it to db

    $cf;
    if(isset($closeFriends)){
        $cf = 1;
    }else{
        $cf = 0;
    }

    /* ---- Testing ---- */
    
    //$username = "Pepito";
    //$message = "Test message with #hashtag";
    //$likes = 0;
    //$tags;
    //$tags = getTagsFromMessage($conn, $message);
    //$type = "USMITO";
    //$closeFriends = 1;
    
    /* ------------------- */

    $fechapub = date("d/m/y - H:i:s");
    //$fechapub = date("DATE_W3C");
    
    createUsmito($conn, $username, $message, $likes, $tags, $type, $cf, $fechapub); // Upload to db
}
else{
    header("location: ../index.php");
    exit();
}