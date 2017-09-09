<?php
include("inc/config.php");

if(isset($_SESSION["loggedIn"])){
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>