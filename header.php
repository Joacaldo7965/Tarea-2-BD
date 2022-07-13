<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>USMwer</title>
    <meta chaset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <nav id="navbar">
        <div class="wrapper">
            <div class="navbar-logo">
                <a href="index.php"><img src="res/imagenes/Logo.png"></a>
                <h1>USMwer</h1>
            </div>
            
            <ul id="navbar-list">
                <li class="navbar-elem"><a class="navbar-elem-link" href="index.php"><b>Inicio</b></a></li>
                <li class="navbar-elem"><a class="navbar-elem-link" href="explore.php"><b>Explorar</b></a></li>
                <li class="navbar-elem"><a class="navbar-elem-link" href="creator.php"><b>Creador</b></a></li>
                <li class="navbar-elem"><a class="navbar-elem-link" href="trends.php"><b>Tendencias</b></a></li>
                <?php
                    if(isset($_SESSION["userUid"])){
                        ?>
                        <li class="navbar-elem-search">
                            <form action="searchResult.php" method="POST">
                                <div class="navbar-elem-search-div">
                                    <input class="navbar-elem-search-div-search" type="text" name="search" value="">
                                    <input class="navbar-elem-search-div-searchButton" type="submit" name="submitSearch" value="Buscar">
                                </div>
                            </form>
                        </li>
                        <li class="navbar-elem-right"><a class="navbar-elem-link" href="includes/logout-inc.php"><b>Log out</b></a></li>
                        <li class="navbar-elem-right"><a class="navbar-elem-link" href="profile.php"><b>Perfil (<?php echo($_SESSION["userUid"]);	?>)</b></a></li>
                        <?php
                    } else{
                        ?>
                        <li class="navbar-elem-right"><a class="navbar-elem-link" href="signup.php"><b>Sign up</b></a></li>
                        <li class="navbar-elem-right"><a class="navbar-elem-link" href="login.php"><b>Log in</b></a></li>
                        <?php
                    }
                ?>
            </ul>
        
        </div>
    </nav> 
    
    <div class="wrapper2">