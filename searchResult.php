<?php

include_once("header.php");

if(isset($_SESSION["userUid"]) === false){
    header("location: login.php?error=plslogin");
    exit();
}

if(isset($_POST["submitSearch"]) === false || empty($_POST["search"])){
    header("location: index.php");
    exit();
}


include_once("includes/dbh-inc.php");
include_once("includes/functions-inc.php");

//showResultFromSearch($conn, $_POST["search"]);

$users = getUsersFromSearch($conn, $_POST["search"]);
$usmitos = getUsmitosFromSearch($conn, $_POST["search"]);
$tags = getTagsFromSearch($conn, $_POST["search"]);

?>
<div class="middleWrapper">
<h1 class="searchTitle">Usuarios</h1>
<div class="horizontalSeparator1"></div>
<?php
showUsersFrom($conn, $users);
?>
<h1 class="searchTitle">Usmitos</h1>
<div class="horizontalSeparator1"></div>
<?php
showUsmitosFeedFrom($conn, $usmitos);
?>
<h1 class="searchTitle">Tags</h1>
<div class="horizontalSeparator1"></div>
<?php
showTagsFrom($tags);
?>
</div>
<?php

?>