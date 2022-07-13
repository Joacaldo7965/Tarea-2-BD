<?php
session_start();
include_once("dbh-inc.php");
include_once("functions-inc.php");

if(isset($_POST["follow"])){
    //echo("You have followed " . $_POST["followedUid"] . "!");

    $uid = $_POST["uidData"];
    $uidFollower = $_SESSION["userUid"];

    //echo($uidFollower . " siguió a " . $uid);

    createFollow($conn, $uidFollower, $uid, "location: ../explore.php");
    //header("location: ../explore.php");

} elseif($_POST["unfollow"]){
    //echo("Has dejado de seguir a " . $_POST["uidData"]);
    $uid = $_POST["uidData"];
    $uidFollower = $_SESSION["userUid"];

    deleteFollow($conn, $uidFollower, $uid, "location: ../explore.php");
    //header("location: ../explore.php");

} else{
    echo("Sendo error xd");
}