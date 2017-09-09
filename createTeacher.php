<?php
include("inc/config.php");

if(!isset($_SESSION["loggedIn"])){
    header("Location: login.php");
    exit();
}

if($create = filter_input(INPUT_POST, 'create')){
    $name = filter_input(INPUT_POST, 'name') or besked("fejl", "Fejl i navnet");
    $mappenavn = "uploads/";
    $tidspunkt = round(microtime(true) * 1000);
    $billede = $mappenavn . $tidspunkt . "-" . basename($_FILES["image"]["name"]);
    $billedetype = strtolower(pathinfo($billede, PATHINFO_EXTENSION));

    if($billedetype != "jpg" && $billedetype != "png"){
        besked("fejl", "Filtypen er ikke tilladt");
    } else {
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $billede)) {
            $sql = 'INSERT INTO teacher (teacherName, teacherImage) VALUES (?, ?)';
            $stmt = $link->prepare($sql);
            $stmt->bind_param('ss', $name, $billede);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                besked("success", "Dit billede er nu tilføjet");
            }
        } else {
            besked("fejl", "Billedet kunne ikke tilføjes");
        }
    }
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
            <input type="file" name="image">
            <input type="submit" name="create" value="Tilføj Lærer">
        </form>
    </div>
</body>
</html>