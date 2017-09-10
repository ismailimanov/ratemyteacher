<?php
    include("inc/config.php");

    if(isset($_POST["signup"])){
        $username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) or die("Invalid username");
        $password   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or die("Invalid passwird");
        $password   = password_hash($password, PASSWORD_DEFAULT);
        $email      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) or die("Invalid email");

        createUser($link, $username, $password, $email);
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
    <form class="form" action="?signup=1" method="post">
        <input type="text" name="username" placeholder="Brugernavn" required>
        <input type="password" name="password" placeholder="Kodeord" required>
        <input type="email" name="email" placeholder="E-mail Adresse" required>
        <input type="submit" name="signup" value="Opret Konto">
    </form>
    <div class="loginInfo">
        <a href="login.php">&laquo; Tilbage</a>
    </div>
</div>
</body>
</html>