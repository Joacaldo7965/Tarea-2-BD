<?php

session_start();

if(isset($_SESSION["userUid"]) === false){
    header("location: login.php?error=plslogin");
    exit();
}

if(isset($_POST["deleteUsmitoSubmit"]) === false){
    header("location: ../index.php?error=xd");
    exit();
}

include_once("dbh-inc.php");
include_once("functions-inc.php");

deleteUsmitoFromId($conn, $_POST["usmitoId"]);
