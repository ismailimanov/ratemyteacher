<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}

if(isset($_GET["update"])){
    $password = filter_input(INPUT_POST, 'password') or besked("fejl", "Ugyldig kodeord");
    updateInfo($link, $_SESSION["userId"], $password);
}
?>
<!doctype html>
<html lang="da">
    <head>
        <title>Rate my Teacher - Indstillinger</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
        <link href="css/main.css" rel="stylesheet" type="text/css">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    </head>
    <body>
        <?php
        include("menu.php");
        ?>
        <div class="loginBox">
            <?php
            if(isset($GLOBALS["besked"])){
                ?>
                <div class="besked <?=$GLOBALS["beskedStil"]?>"><?=$GLOBALS["beskedTekst"]?></div>
                <?php
            }
            ?>
            <form class="form" action="?update=1" method="post">
                <input type="password" name="password" placeholder="Kodeord" required>
                <input type="submit" name="signup" value="Opdater">
            </form>
        </div>
        <script src="js/script.js" type="text/javascript"></script>
        <script src="js/classie.js"></script>
        <script src="js/main.js"></script>
        </body>
</html>