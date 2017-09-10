<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}

if($create = filter_input(INPUT_POST, 'create')){
    $name           = filter_input(INPUT_POST, 'name') or besked("fejl", "Fejl i navnet");
    $mappenavn      = "uploads/";
    $tidspunkt      = round(microtime(true) * 1000);
    $billede        = $mappenavn . $tidspunkt . "-" . basename($_FILES["image"]["name"]);
    $billedetype    = strtolower(pathinfo($billede, PATHINFO_EXTENSION));
    $billedeFil     = $_FILES["image"];
    $subject        = filter_input(INPUT_POST, 'subject',FILTER_VALIDATE_INT) or besked("fejl", "Ikke gyldig fag");

    createTeacher($link, $name, $billede, $billedetype, $billedeFil, $subject);
}
?>
<!doctype html>
<html lang="da">
<head>
    <title>Rate my Teacher</title>
    <meta charset="utf-8">
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
        <form class="form" action="?create=1" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Lærerens Navn" required>
            <select name="subject" required>
                <?=getSubjects($link)?>
            </select>
            <input type="file" name="image">
            <input type="submit" name="create" value="Tilføj Lærer">
        </form>
    </div>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/classie.js"></script>
<script src="js/main.js"></script>
</body>
</html>