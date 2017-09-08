<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="da">
    <head>
        <title>Rate my Teacher</title>
        <meta charset="utf-8">
        <link href="css/main.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        Hej <?=$_SESSION["username"]?>
    </body>
</html>