<?php

session_start();

include_once("dbh-inc.php");
include_once("functions-inc.php");

if(isset($_POST["comment"])){

    echo("comment pressed " . $_POST["usmitoId"]);

} elseif(isset($_POST["like"])){

    addLike($conn, $_SESSION["userUid"], $_POST["usmitoId"]);

    header("location: ../index.php");
    exit();

} elseif(isset($_POST["dislike"])){
    
    deleteLike($conn, $_SESSION["userUid"], $_POST["usmitoId"]);

    header("location: ../index.php");
    exit();

} elseif(isset($_POST["reusmear"])){

    $usmitoId = $_POST["usmitoId"];

    echo("reusmear pressed " . $usmitoId);

} else{
    header("location: ../index.php");
    exit();
}

