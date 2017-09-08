<?php
function besked($stil, $besked){
    $GLOBALS["besked"] = 1;
    if($stil == "success") {
        $GLOBALS["beskedStil"] = "gron";
        $GLOBALS["beskedTekst"] = $besked;
    } elseif($stil == "fejl") {
        $GLOBALS["beskedStil"] = "rod";
        $GLOBALS["beskedTekst"] = $besked;
    }
}

function createUser($link, $username, $password, $email){
    $sql = 'INSERT INTO user (username, password, email) VALUE (?, ?, ?)';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('sss', $username, $password, $email);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        besked("success", "Din bruger er nu oprettet");
    } else {
        besked("fejl", "Fejl under oprettelsen");
    }
}

function login($link, $username, $password){
    $sql = 'SELECT userId, username, password FROM user WHERE username=?';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($uid, $usr, $pass);
    $stmt->store_result();

    if($stmt->num_rows == 1){
        while($stmt->fetch()){
            if(password_verify($password, $pass)){
                $_SESSION["loggedIn"] = 1;
                $_SESSION["userId"] = $uid;
                $_SESSION["username"] = $usr;
                header("Location: index.php");
                exit();
            } else {
                besked("fejl", "Forkert kodeord");
            }
        }
    } else {
        besked("fejl", "Brugeren findes ikke");
    }
}