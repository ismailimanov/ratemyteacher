<?php
    include("inc/config.php");
    if(isset($_POST["login"])){
        $username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) or besked("fejl", "Ugyldigt brugernavn");
        $password   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or besked("fejl", "Ugyldigt kodeord");

        login($link, $username, $password);
    }
?>
<!doctype html>
<html lang="da">
<head>
    <title>Rate my Teacher</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
    <body>
        <img src="img/logo.png" alt="Rate my Teacher logo">
        <div class="loginBox">
            <?php
                if(isset($GLOBALS["besked"])){
                    ?>
                        <div class="besked <?=$GLOBALS["beskedStil"]?>"><?=$GLOBALS["beskedTekst"]?></div>
                    <?php
                }
            ?>
            <form class="form" action="?login=1" method="post">
                <input type="text" name="username" placeholder="Brugernavn" required>
                <input type="password" name="password" placeholder="Kodeord" required>
                <input type="submit" name="login" value="Log ind">
            </form>
            <div class="loginInfo">
                <a href="signup.php">Opret Konto</a>
                <a href="forgotpassword.php">Glemt kodeord</a>
            </div>
        </div>
    </body>
</html>