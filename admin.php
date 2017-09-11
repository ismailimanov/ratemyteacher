<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}

if($_SESSION["userId"] != 1){
    header("Location: index.php");
    exit();
}

if(isset($_GET["delete"])){
    $tid = filter_input(INPUT_GET, 'tid', FILTER_VALIDATE_INT);
    deleteSubject($link, $tid);
    deleteRating($link, $tid);
    deleteTeacher($link, $tid);
}
?>
<!doctype html>
<html lang="da">
<head>
    <title>Rate my Teacher - Topliste</title>
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
    <h1>Liste over lærer</h1>
    <?php
        admin($link);
    ?>
</div>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/classie.js"></script>
<script src="js/main.js"></script>
</body>
</html>