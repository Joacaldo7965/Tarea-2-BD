<?php
    include_once("header.php");

    if(isset($_SESSION["userUid"]) === false){
        header("location: login.php?error=plslogin");
        exit();
    }
?>

<div class="middleWrapper">
    <section class="profile-info">

        <?php
            include_once("includes/dbh-inc.php");
            include_once("includes/functions-inc.php");

            if(isset($_GET["user"])){
                if($_GET["user"] == $_SESSION["userUid"]){

                    $username = $_SESSION["userUid"];
                    $email = $_SESSION["userEmail"];
                    $fechaReg = $_SESSION["userRegDate"];

                    ?>
                        <h2>Tu Perfil</h2>
                    <?php
                } else{

                    $userData = uidExists($conn, $_GET["user"], "");

                    if($userData !== false){
                        //echo($userData["usersUid"]);

                        $username = $userData["usersUid"];
                        $email = $userData["usersEmail"];
                        $fechaReg = $userData["fecha_reg"];

                        echo("<h2>Perfil de " . $username . "</h2>");

                    } else{
                        header("location: profile.php?error=notfoundprofile");
                        //echo($userData);
                    }
                }
            } else{
                $username = $_SESSION["userUid"];
                $email = $_SESSION["userEmail"];
                $fechaReg = $_SESSION["userRegDate"];

                ?>
                    <h2>Tu Perfil</h2>
                <?php
            }

            $followers = getFollowers($conn, $username);

            $follows = getFollows($conn, $username);
            

            if(isset($_SESSION["userUid"])){
                ?>

                <div class="profile-header">
                    <div class="profile-header-info">
                        <div class="profile-header-info"></div>
                        <h3>Usuario: @<?php echo($username); ?></h3>
                        <h3>Email: <?php echo($email); ?></h3>
                        <h3>Fecha de registro: <?php echo($fechaReg); ?></h3>
                        <h3>Seguidores: <?php echo($followers); ?></h3>
                        <h3>Seguidos: <?php echo($follows); ?></h3>
                    </div>
                    
                        <?php

                            if($username !== $_SESSION["userUid"]){

                                ?>
                                    <div class="profile-header-follow">
                                        <form action="includes/profileFollow-inc.php" method="POST">
                                        <input class="userFeed-buttons-followedUid" type="text" name="uidData" value=<?php echo($username); ?>>
                                <?php
                                
                                if(isFollowdBy($conn, $username, $_SESSION["userUid"]) !== false){
                                    ?>
                                        <input class="userFeed-buttons-unfollow" type="submit" name="unfollow" value="Following">
                                    <?php
                                } else{
                                    ?>
                                        <input class="userFeed-buttons-follow" type="submit" name="follow" value="Follow">
                                    <?php
                                }
                                ?>
                                    </form>
                                <?php

                                if(areCloseFriends($conn, $username, $_SESSION["userUid"])){
                                    ?>
                                        <span>Son amigos cercanos!</span>

                                    <?php
                                }
                                ?>
                                    </div>
                                <?php
                                
                            }else{
                                ?>
                                <div class="profile-header-edit">
                                    <form action="profileEdit.php" method="POST">
                                        <input class="profile-header-edit-button" type="submit" name="editProfile" value="Editar">
                                    </form>
                                </div>
                            <?php
                            }
                        ?>
                </div>

                <?php
            } 
        ?>

        <div class="profile-usmitos">
            <?php
            include_once("includes/dbh-inc.php");
            include_once("includes/functions-inc.php");

            $userUsmitos = getUserUsmitos($conn, $username);
            ?>
            <h2 class="profile-usmitos-title">Usmitos</h2>
            <?php
            if($userUsmitos !== false){
                $n_usmitos = count($userUsmitos);
                ?>
                    <span><?php echo($n_usmitos); ?> usmitos encontrados</span>
                <?php
            }
            ?>
            
        
            <!-- Todo make CRUD for usmitos -->
            <div class="horizontalSeparator1"></div>
            
            <?php 
            //$username = $_SESSION["userUid"];
            
            
            if($userUsmitos !== false){

                showUsmitosFeedFrom($conn, $userUsmitos);
                

            } else{ // User dont have any usmito
                echo("Todavia no hay ningun usmito en esta cuenta :(");
                //echo($_SESSION["userUid"]);
            }

            ?>

                
            
        </div>
        
    </section>
</div>


<?php
    include_once("footer.php")
?>