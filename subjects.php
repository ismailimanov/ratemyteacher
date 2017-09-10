<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}

if(isset($_GET["vurder"])){
    $vurder = filter_input(INPUT_GET, 'vurder', FILTER_VALIDATE_INT);
    $teacherId = filter_input(INPUT_GET, 'teacherId', FILTER_VALIDATE_INT);
    rate($link, $teacherId, $vurder);
    header("Location: index.php");
    exit();
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
    <?php
    if(isset($GLOBALS["besked"])){
        ?>
        <div class="besked <?=$GLOBALS["beskedStil"]?>"><?=$GLOBALS["beskedTekst"]?></div>
        <?php
    }

        if(!isset($_GET["subjectId"])) {
            ?>
            <h1>fag</h1>
            <div class="subjects">
                <?php
                getSubject($link);
                ?>
            </div>
    <?php
        } else {
            getTeachersbySubject($link, $_GET["subjectId"], $_SESSION["userId"]);
            if(isset($GLOBALS["teacherId"])) {
                getRating($link, $GLOBALS["teacherId"]);
            }
        }
    ?>
</div>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/classie.js"></script>
<script src="js/main.js"></script>
</body>
</html>