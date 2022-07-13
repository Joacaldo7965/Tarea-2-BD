<?php
session_start();
include_once("dbh-inc.php");
include_once("functions-inc.php");

if(isset($_POST["follow"])){
    //echo("You have followed " . $_POST["followedUid"] . "!");

    $uid = $_POST["uidData"];
    $uidFollower = $_SESSION["userUid"];

    //echo($uidFollower . " siguió a " . $uid);

    $header = "location: ../profile.php?user=" . $uid;

    createFollow($conn, $uidFollower, $uid, $header);

} elseif($_POST["unfollow"]){
    //echo("Has dejado de seguir a " . $_POST["uidData"]);
    $uid = $_POST["uidData"];
    $uidFollower = $_SESSION["userUid"];

    $header = "location: ../profile.php?user=" . $uid;

    deleteFollow($conn, $uidFollower, $uid, $header);

} else{
    echo("Sendo error xd");
}