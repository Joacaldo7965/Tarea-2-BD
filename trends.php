<?php
    include_once("header.php");

    if(!isset($_SESSION["userUid"])){
        header("location: login.php?error=plslogin");
        exit();
    }
?>

<div class="middleWrapper">
    <section class="trends-intro">

        <h2>Tendencias</h2>
        
    </section>

    <div>
    <?php
    include_once("includes/dbh-inc.php");
    include_once("includes/functions-inc.php");

    $tags = getAllTags($conn);

    showTagsFrom($tags);
    ?>
    </div>
</div>

<?php
    include_once("footer.php")
?>