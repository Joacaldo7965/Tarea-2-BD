<?php
    include_once("dbh-inc.php");
    include_once("functions-inc.php");

    $username = $_SESSION["userUid"];
    //$username = "Joacaldo";
    $userUsmitos = getUserUsmitos($conn, $username);
    //echo($username);
    if($userUsmitos !== false){

        showUsmitosFeedFrom($userUsmitos);
        

    } else{ // User dont have any usmito
        echo("No tienes ningun usmito :(");
        //echo($_SESSION["userUid"]);
    }