<?php

/*
Name: 
*   emptyInputSignup
Params:
* String $username
* String $email
* String $pwd
* String $pwdRepeat
Returns:
* Retorna true si hay algun parametro vacio.
*/
function emptyInputSignup($username, $email, $pwd, $pwdRepeat){
    $result;
    if(empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   invalidUid
Params:
* String $username
Returns:
* Retorna true si el username es invalido.
*/
function invalidUid($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]+$/", $username)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   invalidEmail
Params:
* String $email
Returns:
* Retorna true si el email es invalido.
*/
function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   pwdMatch
Params:
* String $pwd
* String: $pwdRepeat
Returns:
* Retorna true si las contraseñas son distintas.
*/
function pwdMatch($pwd, $pwdRepeat){
    $result;
    if($pwd !== $pwdRepeat){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   uidExists
Params:
* $conn : MySQL connection Object
* String $username
* String $email
Returns:
* Retorna los datos de la db del username si existe, en caso contrario retorna false.
*/
function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

/*
Name: 
*   createUser
Params:
* $conn : MySQL connection Object
* String $username
* String $email
* String $pwd
* String $fechareg
Returns:
* No retorna nada
Abstract:
* Realiza una inserción en la db, creando un usuario en la tabla "users"
*/
function createUser($conn, $username, $email, $pwd, $fechareg){
    $sql = "INSERT INTO users(usersUid, usersEmail, usersPwd, fecha_reg) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    // Hashing password
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $fechareg);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}

/*
Name: 
*   emptyInputLogin
Params:
* String $username
* String $pwd
Returns:
* Retorna true si hay algun parametro vacio.
*/
function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   loginUser
Params:
* $conn : MySQL connection Object
* String $username
* String $pwd
Returns:
* No retorna nada
Abstract:
* Revisa si el usuario existe y luego verifica si la contraseña es correcta,
* finalmente crea una sesión con los datos de usuario.
*/
function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];

    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        //$_SESSION["userId"] = $uidExists["usersId"];
        $_SESSION["userUid"] = $uidExists["usersUid"];
        $_SESSION["userEmail"] = $uidExists["usersEmail"];
        $_SESSION["userRegDate"] = $uidExists["fecha_reg"];
        header("location: ../index.php");
        exit();
    }
}

/*
Name: 
*   emptyInputMessage
Params:
* String $message
Returns:
* Retorna true si hay algun parametro vacio.
*/
function emptyInputMessage($message){
    $result;
    if(empty($message)){
        $result = true;
    } else{
        $result = false;
    }
    return $result;
}

/*
Name: 
*   tagExists
Params:
* $conn : MySQL connection Object
* String $tag
Returns:
* Retorna los datos de la db del tag si existe, en caso contrario retorna false. 
*/
function tagExists($conn, $tag){
    $sql = "SELECT * FROM tags WHERE tagsId=?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $tag);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_all($resultData);
    mysqli_stmt_close($stmt);

    return $row;
}

/*
Name: 
*   createTagRelations
Params:
* $conn : MySQL connection Object
* String $tags : Tags separados por comas -> "tag1,tag2,tag3,...,tagn"
Returns:
* No retorna nada.
Abstract:
* Obtiene los datos de los tags de la db y luego crea las relaciones usmito-tag.
*/
function createTagRelations($conn, $tags){
    $sql = "SELECT * FROM usmitos WHERE usmitosTags=? ORDER BY usmitosFechaPub DESC;";   // Keep a look at this

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $tags);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_all($resultData);
    mysqli_stmt_close($stmt);

    createUsmitoTagRelation($conn, $row[0][0], $tags);
    //exit();
}

/*
Name: 
*   createUsmitoTagRelation
Params:
* $conn : MySQL connection Object
* String $usmitoId
* String $tagsString : Tags separados por comas -> "tag1,tag2,tag3,...,tagn"
Returns:
* No retorna nada.
Abstract:
* Por cada tag en el tagString se inserta en la db una relacion usmito-tag
*/
function createUsmitoTagRelation($conn, $usmitoId, $tagsString){
    // Add to relation

    $tags = explode(",", $tagsString);

    for ($i = 0; $i < count($tags); $i++) { 
    
        $sql = "INSERT INTO usmitos_tags(usmitos_tagsUsmitoId, usmitos_tagsTagId) VALUES (?, ?);";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "is", $usmitoId, $tags[$i]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}


/*
Name: 
*   getTagsFromMessage
Params:
* $conn : MySQL connection Object
* String $message
Returns:
* Retorna un string de tags separados por comas encontrados en el mensaje.
Abstract:
* Obtiene los tags definidos por un "#", los inserta o actualiza en la tabla "tags" y
* finalmente los deja como un string separados por comas
*/
function getTagsFromMessage($conn, $message){
    $message = $message . " ";

    preg_match_all("/#\w+\s/", $message, $matches);

    $matches = $matches[0];

    $n_matches = count($matches);

    $csvtags = "";

    if($n_matches > 0){
        for($i = 0; $i < $n_matches; $i++){
            $tag = ltrim(rtrim($matches[$i], " "), "#");
            $csvtags = $csvtags . ($tag . ",");

            
            if($tagData = tagExists($conn, $tag)){
            
                // Update if exists
                $sql = "UPDATE tags SET tagsCount=tagsCount + 1 WHERE tagsId=?";

                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: ../index.php?error=stmtfailed");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "s", $tag);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);


            }else{
                // Insert if doesn't exists
                $sql = "INSERT INTO tags(tagsId, tagsCount, tagsRegisterDate) VALUES (?, ?, ?);";
    
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("location: ../index.php?error=stmtfailed");
                    exit();
                }

                $tagCount = 1;
                $tagRegDate = date("d/m/y");

                mysqli_stmt_bind_param($stmt, "sis", $tag, $tagCount, $tagRegDate);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }     
        }
        $csvtags = substr_replace($csvtags ,"", -1); // remove last comma from csvtags
    }
    $message = substr_replace($message ,"", -1); // remove last space from message
    return $csvtags;
}

/*
Name: 
*   createUsmito
Params:
* $conn : MySQL connection Object
* String $username
* String $message
* int $likes
* String $tags
* int $type
* int $closeFriends
* String $fechapub
Returns:
* No retorna nada
Abstract:
* Inserta en la db en la tabla "usmitos" el usmito creado por los parametros.
*/
function createUsmito($conn, $username, $message, $likes, $tags, $type, $closeFriends, $fechapub){
    include_once("dbh-inc.php");
    $sql = "INSERT INTO usmitos(usmitosUid, usmitosMessage, usmitosLikes, usmitosTags, usmitosTipo, usmitosCloseFriends, usmitosFechaPub) VALUES (?, ?, ?, ?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssissis", $username, $message, $likes, $tags, $type, $closeFriends, $fechapub);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    createTagRelations($conn, $tags);

    header("location: ../index.php?error=none");
    exit();
}

/*
Name: 
*   getUserUsmitos
Params:
* $conn : MySQL connection Object
* String $username
Returns:
* Retorna un array de usmitos donde el emisor es el usuario de los parametros.
* retorna false en caso de que no tenga usmitos.
*/
function getUserUsmitos($conn, $username){
    $sql = "SELECT * FROM usmitos WHERE usmitosUid=?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    header("location: ../profile.php?error=none");
    exit();

}

/*
Name: 
*   getUserFollowedUsmitos
Params:
* $conn : MySQL connection Object
* String $username
Returns:
* Retorna un array de usmitos de personas que sigue el $username y tambien incluye los propios.
* Retorna false si no encuentra ninguno.
*/
function getUserFollowedUsmitos($conn, $username){
    //$sql = "SELECT * FROM usmitos WHERE usmitosUid in (SELECT followsUid FROM follows WHERE followsUidFollower=?) ORDER BY usmitosFechaPub DESC;";
    $sql = "SELECT * FROM usmitos WHERE usmitosUid=?  OR usmitosUid in (SELECT followsUid FROM follows WHERE followsUidFollower=?) ORDER BY usmitosFechaPub DESC;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    //header("location: ../index.php?error=none");
    exit();
}

/*
Name: 
*   showUsmitosFeedFrom
Params:
* $conn : MySQL connection Object
* array de Usmitos: $usmitos
Returns:
* No retorna nada
Abstract:
* Crea el feed mostrando cada Usmito de $usmitos
*/
function showUsmitosFeedFrom($conn, $usmitos){
    if($usmitos){
        $n_usmitos = count($usmitos);

        //include_once("dbh-inc.php");

        for($i = 0; $i < $n_usmitos; $i++){
            /*
            echo("Usmito N°" . ($i + 1) . ":" . "<br>");
            echo($usmitos[$i][0] . "<br>"); // usmitosId
            echo($usmitos[$i][1] . "<br>"); // usmitosUid
            echo($usmitos[$i][2] . "<br>"); // usmitosMessage
            echo($usmitos[$i][3] . "<br>"); // usmitosLikes
            echo($usmitos[$i][4] . "<br>"); // usmitosTags
            echo($usmitos[$i][5] . "<br>"); // usmitosType
            echo($usmitos[$i][6] . "<br>"); // usmitosIdPadre
            echo($usmitos[$i][7] . "<br>"); // usmitosCloseFriends
            echo($usmitos[$i][8] . "<br>"); // usmitosFechaPub
            */

            if($usmitos[$i][1] !== $_SESSION["userUid"]){
                if($usmitos[$i][7] === 1 && areCloseFriends($conn, $_SESSION["userUid"], $usmitos[$i][1]) === false){
                    continue;
                }            
            }
            echo("<div class='usmito'>");

                if($usmitos[$i][5] === "REUSMITO"){
                    echo("<h3 class='usmito-reusmito'>" . $usmitos[$i][1] . " reusmeó</h3>");
                }

            ?>

            <!-- Make General form of a usmito -->
            <div class="usmito-header">
                <h3 class="usmito-header-username"><?php echo($usmitos[$i][1]); ?></h3>
                <a class="usmito-header-profile" href=<?php echo("profile.php?user=" . $usmitos[$i][1]); ?>><?php echo("@" . $usmitos[$i][1]); ?></a>
                <span class="usmito-header-date">- <?php echo($usmitos[$i][8]); ?></span>
                <?php
                if($usmitos[$i][1] !== $_SESSION["userUid"]){
                    if($usmitos[$i][7] === 1 && areCloseFriends($conn, $_SESSION["userUid"], $usmitos[$i][1]) !== false){
                        //echo($usmitos[$i][7]);
                        ?>
                            <label class="usmito-header-closeFriends"><span>Close Friends</span></label>
                        <?php  
                    }            
                }
                if($usmitos[$i][1] === $_SESSION["userUid"]){
                    ?>
                    <form action="includes/deleteUsmito-inc.php" method="POST" style="margin-left: auto;">
                        <input style="visibility: hidden;width: 1px;height: 1px;" type="text" name="usmitoId" value=<?php echo($usmitos[$i][0]); ?>>
                        <input type="submit" name="deleteUsmitoSubmit" value="borrar">
                    </form>
                        <!--<label class="usmito-header-delete"><span>Borrar</span></label>-->
                    <?php          
                }
                ?>
            </div>
            <!--<textarea class="usmito-message" disabled="true"><?php //echo($usmitos[$i][2]); ?></textarea>-->

            <p class="usmito-message"><?php echo($usmitos[$i][2]); ?></p>

            <div class="usmito-buttons">
                <form action="includes/usmito-inc.php" method="POST">
                    <input type="text" name="usmitoId" value=<?php echo($usmitos[$i][0]); ?>>
                    <label>
                        <input type="submit" name="comment" value="comment">
                        <svg class="usmito-buttons-comment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"/></g></svg>
                    </label>
                    <label>
                        <input type="submit" name="reusmear" value="reusmear">
                        <svg class="usmito-buttons-reusmear" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z"/></g></svg>
                    </label>
                    
                    <div class="usmito-buttons-countDiv">
                        
                        <?php
                            if(userLiked($conn, $_SESSION["userUid"], $usmitos[$i][0])){
                                ?>
                                <label>
                                <input type="submit" name="dislike" value="dislike">
                                <svg class="usmito-buttons-likeActive" viewBox="0 0 24 24" aria-hidden="true" class=""><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z"></path></g></svg>
                                </label>
                                <?php
                            }else{
                                ?>
                                <label>
                                <input type="submit" name="like" value="like">
                                <svg class="usmito-buttons-like" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"/></g></svg>
                                </label>
                                <?php
                            }
                        ?>
                        
                        <div class="usmito-buttons-likeCountDiv">
                            <span class="usmito-buttons-likeCount"><?php echo(getUsmitoLikes($conn, $usmitos[$i][0])); ?></span>
                        </div>
                    </div>    
                    
                </form>
            </div>

            </div>
            <div class="horizontalSeparator1"></div>

            <?php    
        }
    }else{
        ?>
        <p>No se encontraron Usmitos</p>
        <?php
    }
}

/*
Name: 
*   getAllUsers
Params:
* $conn : MySQL connection Object
Returns:
* Retorna un array de users con los 100 ultimos usuarios registrados.
* Retorna false si no encuentra ninguno.
*/
function getAllUsers($conn){
    $sql = "SELECT * FROM users ORDER BY fecha_reg DESC LIMIT 100;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   showUsersFrom
Params:
* $conn : MySQL connection Object
* array de Users: $users
Returns:
* No retorna nada
Abstract:
* Crea el feed mostrando cada User de $users.
*/
function showUsersFrom($conn, $users){
    if($users){
        $n_users = count($users);
        for($i = 0; $i < $n_users; $i++){
            if($users[$i][0] === $_SESSION["userUid"]){
                continue; // Do not show the self user
            }
            /*
            echo("User N°" . ($i + 1) . ":" . "<br>");
            //echo($users[$i][0] . "<br>"); // usersId
            echo("" . $users[$i][1] . "<br>"); // usersUid
            //echo($users[$i][2] . "<br>"); // usersEmail
            //echo($users[$i][3] . "<br>"); // usersPwd
            //echo($users[$i][4] . "<br>"); // fecha_reg

            // new db
            echo("User N°" . ($i + 1) . ":" . "<br>");
            echo($users[$i][0] . "<br>"); // usersUid
            echo($users[$i][1] . "<br>"); // usersEmail
            echo($users[$i][2] . "<br>"); // usersPwd
            echo($users[$i][3] . "<br>"); // fecha_reg
            */
            ?>
            <div class='userFeed'>

                <!-- Make General form of a user -->
                <div class="userFeed-username">
                    <h3 class="userFeed-username-name"><?php echo($users[$i][0]); ?></h3>
                    <a class="userFeed-username-at" href=<?php echo("profile.php?user=" . $users[$i][0]); ?>><?php echo("@" . $users[$i][0]); ?></a>
                </div>
                <div class="userFeed-buttons">
                    <form action="includes/userFeed-inc.php" method="POST">
                        <input class="userFeed-buttons-followedUid" type="text" name="uidData" value=<?php echo($users[$i][0]); ?>>
                        <label>
                            <?php
                                if(isFollowdBy($conn, $users[$i][0], $_SESSION["userUid"]) !== false){
                                    ?>
                                    <input class="userFeed-buttons-unfollow" type="submit" name="unfollow" value="Following">
                                    <?php
                                } else{
                                    ?>
                                    <input class="userFeed-buttons-follow" type="submit" name="follow" value="Follow">
                                    <?php
                                }
                            
                            ?>
                        </label>
                    </form>
                </div>

            </div>
            <div class="horizontalSeparator1"></div>
            <?php        
        }
    }else{
        ?>
        <p>No se encontraron Usuarios</p>
        <?php
    }
}

/*
Name: 
*   createFollow
Params:
* $conn : MySQL connection Object
* String $uidFollower
* String $uid
* String $header
Returns:
* No retorna nada
Abstract:
* Crea el follow en la tabla "follows", tal que $uidFollower sigue a $uid, 
* luego se redirige a la pagina $header
*/
function createFollow($conn, $uidFollower, $uid, $header){
    $sql = "INSERT INTO follows(followsUid, followsUidFollower) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    //$followDate = date("d/m/y");

    mysqli_stmt_bind_param($stmt, "ss", $uid, $uidFollower);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header($header);
    exit();
}

/*
Name: 
*   isFollowedBy
Params:
* $conn : MySQL connection Object
* String $uid
* String $uidFollower
Returns:
* No retorna nada
Abstract:
* Retorna los datos de la relacion si $uidFollower sigue a $uid.
* Retorna false si $uidFollower no sigue a $uid
*/
function isFollowdBy($conn, $uid, $uidFollower){
    $sql = "SELECT * FROM follows WHERE followsUid=? AND followsUidFollower=?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uid, $uidFollower);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   deleteFollow
Params:
* $conn : MySQL connection Object
* String $uidFollower
* String $uid
* String $header
Returns:
* No retorna nada
Abstract:
* Borra la relación follow de la db donde $uidFollower sigue a $uid,
* luego se redirige a la pagina $header
*/
function deleteFollow($conn, $uidFollower, $uid, $header){
    $sql = "DELETE FROM follows WHERE followsUid=? AND followsUidFollower=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uid, $uidFollower);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header($header);
    exit();
}

/*
Name: 
*   areCloseFriends
Params:
* $conn : MySQL connection Object
* String $uid1
* String $uid2
Returns:
* Retorna true si son amigos cercanos (si se siguen mutuamente),
* Retorna false en caso contrario
*/
function areCloseFriends($conn, $uid1, $uid2){
    if(isFollowdBy($conn, $uid1, $uid2) !== false && isFollowdBy($conn, $uid2, $uid1) !== false){
        return true;
    }
    return false;
}

/*
Name: 
*   showTop10Trends
Params:
* $conn : MySQL connection Object
Returns:
* No retorna nada.
Abstract:
* Realiza la consulta a la db usando el view "viewtop10trends", 
* luego con los datos se muestra un feed con los 10 tags que mas se han utilizado.
*/
function showTop10Trends($conn){
    //echo("lmao");
    //$sql = "SELECT * FROM tags WHERE tagsCount > 0 ORDER BY tagsCount DESC LIMIT 10;";
    $sql = "SELECT * FROM viewtop10trends;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($trendsData = mysqli_fetch_all($resultData)){
        $n_trends = count($trendsData);
    } else{
        $n_trends = 0;
    }
    mysqli_stmt_close($stmt);

    // TODO: recorrer los n tags y llenar un top 10 fijo de 10 posiciones xdxdxdxd
    //       con data o sin el en su defecto
    ?>
        <div class="trendsWrapper">
        <div class="trends-top10">
        <h1 class="trends-top10Title">TOP 10 trends</h1>
        <div class="horizontalSeparator1"></div>
    <?php
    //                           0        1          2             3
    // $trendsData[$i][0-3] -> tagsId, tagsName, tagsCount, tagsRegisterDate

    // new db
    // $trendsData[$i][0-2] -> tagsId, tagsCount, tagsRegisterDate

    for($i = 0; $i < $n_trends; $i++){
        //echo($trendsData[$i][1] . " ");
        if($i < 3){
            $class = "trends-top10-elem" . ($i + 1);
        }else{
            $class = "trends-top10-elem";
        }
        ?>
            
            <div class=<?php echo($class); ?>>
                <div class="trends-top10-elem-header">
                    <span class="trends-top10-elem-header-top"><?php echo("Top " . ($i + 1)); ?></span>
                    <h3 class="trends-top10-elem-header-tag"><?php echo("#" . $trendsData[$i][0]); ?></h3>
                </div>
                <span class="trends-top10-elem-count"><?php echo($trendsData[$i][1] . " usmitos"); ?></span>
            </div>
            <div class="horizontalSeparator1"></div>
        <?php
    }

    ?>
        </div>
        </div>
    <?php

    //exit();
}

/*
Name: 
*   updateUser
Params:
* $conn : MySQL connection Object
* String $userUid
* String $newUid
* String $newPwd
Returns:
* No retorna nada.
Abstract:
* Actualiza en la db el usuario $userUid con los parametros, si estos son cambiados
*/
function updateUser($conn, $userUid, $newUid, $newPwd){
    // $newPwd can be false if not changed

    if($newPwd === false){
        $sql = "UPDATE users SET usersUid=? WHERE usersUid=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $newUid, $userUid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Update new user in current session
        $_SESSION["userUid"] = $newUid;

        header("location: ../profile.php?error=none1");
    } elseif($newPwd !== false){
        $sql = "UPDATE users SET usersUid=?, usersPwd=? WHERE usersUid=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }

        // Hashing password
        $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sss", $newUid, $hashedPwd, $userUid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Update new user in current session
        $_SESSION["userUid"] = $newUid;

        header("location: ../profile.php?error=none2");
    } 

    exit();
}

/*
Name: 
*   deleteUser
Params:
* $conn : MySQL connection Object
* String $userUid
Returns:
* No retorna nada.
Abstract:
* Elimina de la db el usuario $userUid.
*/
function deleteUser($conn, $userUid){
    $sql = "DELETE FROM users WHERE usersUid=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userUid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    session_start();
    session_unset();
    session_destroy();

    header("location: ../signup.php?error=deleteAccount");
    exit();

    
}

/*
Name: 
*   getUsersFromSearch
Params:
* $conn : MySQL connection Object
* String $search
Returns:
* Retorna los datos de la tabla "users" donde el nombre sea parecido a $search,
* Retorna false si no encuentra nada
*/
function getUsersFromSearch($conn, $search){
    $sql = "SELECT * FROM users WHERE usersUid LIKE ? ORDER BY fecha_reg DESC LIMIT 10;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $sqlsearch = "%" . $search . "%";

    mysqli_stmt_bind_param($stmt, "s", $sqlsearch);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   getUsmitosFromSearch
Params:
* $conn : MySQL connection Object
* String $search
Returns:
* Retorna los datos de la tabla "usmitos" donde el mensaje sea parecido a $search,
* Retorna false si no encuentra nada
*/
function getUsmitosFromSearch($conn, $search){
    $sql = "SELECT * FROM usmitos WHERE usmitosMessage LIKE ? ORDER BY usmitosFechaPub DESC LIMIT 10;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $sqlsearch = "%" . $search . "%";

    mysqli_stmt_bind_param($stmt, "s", $sqlsearch);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   getTagsFromSearch
Params:
* $conn : MySQL connection Object
* String $search
Returns:
* Retorna los datos de la tabla "tags" donde el tag sea parecido a $search,
* Retorna false si no encuentra nada
*/
function getTagsFromSearch($conn, $search){
    $sql = "SELECT * FROM tags WHERE tagsId LIKE ? AND tagsCount > 0 ORDER BY tagsRegisterDate DESC LIMIT 10;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    $sqlsearch = "%" . $search . "%";

    mysqli_stmt_bind_param($stmt, "s", $sqlsearch);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   showTagsFrom
Params:
* array de Tags $tags : array de Tags siendo Tags una fila de la tabla "tags"
Returns:
* No retorna nada
Abstract:
* Muestra un feed con todos los tag de $tags
*/
function showTagsFrom($tags){

    if($tags !== false){
        ?>
            <div class="tag">
        <?php

        // new db
        // $tags[$i][0-2] -> tagsId, tagsCount, tagsRegisterDate

        $n_tags = count($tags);

        for($i = 0; $i < $n_tags; $i++){
            ?>  
                <div class="tag-div">
                    <h3 class="tag-div-name"><?php echo("#" . $tags[$i][0]); ?></h3>
                    <span class="tag-div-count"><?php echo($tags[$i][1] . " usmitos"); ?></span>               
                </div>
                <div class="horizontalSeparator1"></div>
            <?php
        }

        ?>
            </div>
        <?php
    }else{
        ?>
        <p>No se encontraron Tags</p>
        <?php
    }
}

/*
Name: 
*   deleteUsmitoFromId
Params:
* $conn : MySQL connection Object
* int $usmitoId
Returns:
* No retorna nada
Abstract:
* Elimina de la tabla usmitos el usmito con el id $usmitoId
*/
function deleteUsmitoFromId($conn, $usmitoId){
    $sql = "DELETE FROM usmitos WHERE usmitosId=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $usmitoId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../profile.php?error=deletedUsmito");
    exit();
}

/*
Name: 
*   getAllTags
Params:
* $conn : MySQL connection Object
Returns:
* Retorna un array de tags con los 100 ultimos tags registrados.
* Retorna false si no encuentra ninguno.
*/
function getAllTags($conn){
    $sql = "SELECT * FROM tags WHERE tagsCount > 0 ORDER BY tagsRegisterDate DESC LIMIT 100;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_all($resultData)){
        return $row;
    } else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   getFollowers
Params:
* $conn : MySQL connection Object
* String $uid
Returns:
* Retorna la cantidad de seguidores que tiene el usuario $uid
*/
function getFollowers($conn, $uid){
    $sql = "SELECT count(*) FROM follows WHERE followsUid = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    $row = mysqli_fetch_all($resultData);
    return $row[0][0];
    

    mysqli_stmt_close($stmt);

    exit();
}

/*
Name: 
*   getFollows
Params:
* $conn : MySQL connection Object
* String $uid
Returns:
* Retorna la cantidad de seguidos que tiene el usuario $uid
*/
function getFollows($conn, $uid){
    $sql = "SELECT count(*) FROM follows WHERE followsUidFollower = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_all($resultData);
    return $row[0][0];
    
    mysqli_stmt_close($stmt);

    exit();
}

function addLike($conn, $userUid, $usmitoId){
    $sql = "INSERT INTO likes(likesUsmitoId, likesUserUid) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "is", $usmitoId, $userUid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function userLiked($conn, $userUid, $usmitoId){
    $sql = "SELECT count(*) FROM likes WHERE likesUserUid = ? AND likesUsmitoId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $userUid, $usmitoId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_all($resultData);
    $count = $row[0][0];

    mysqli_stmt_close($stmt);

    if($count > 0){
        return true;
    } 
    return false;
}

function getUsmitoLikes($conn, $usmitoId){
    $sql = "SELECT count(*) FROM likes WHERE likesUsmitoId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $usmitoId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_all($resultData);
    return $row[0][0];
    
    mysqli_stmt_close($stmt);

    exit();
}

function deleteLike($conn, $userUid, $usmitoId){
    $sql = "DELETE FROM likes WHERE likesUserUid=? AND likesUsmitoId=?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../explore.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $userUid, $usmitoId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
