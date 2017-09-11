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
    $stmt->close();
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
    $stmt->close();
}

function createTeacher($link, $teacherName, $teacherImage, $imageType, $imageFile, $subject){
    if($imageType != "jpg" && $imageType != "png"){
        besked("fejl", "Filtypen er ikke tilladt");
    } else {
        if(move_uploaded_file($imageFile["tmp_name"], $teacherImage)) {
            $sql = 'INSERT INTO teacher (teacherName, teacherImage) VALUES (?, ?)';
            $stmt = $link->prepare($sql);
            $stmt->bind_param('ss', $teacherName, $teacherImage);
            $stmt->execute();
            $teacherId = $link->insert_id;

            if($stmt->affected_rows > 0){
                besked("success", "Læreren er nu tilføjet");
            }
            $stmt->close();

            $addSubject = 'INSERT INTO teacherSubject (teacherId, subjectId) VALUES (?, ?)';
            $stmt = $link->prepare($addSubject);
            $stmt->bind_param('ii', $teacherId, $subject);
            $stmt->execute();

            if($stmt->affected_rows < 1){
                besked("fejl", "Kunne ikke tilføje fag");
            }
            $stmt->close();

        } else {
            besked("fejl", "Billedet kunne ikke tilføjes");
        }
    }
}

function getSubjects($link){
    $subjects = 'SELECT subjectId, subjectName from subject';
    $stmt = $link->prepare($subjects);
    $stmt->execute();
    $stmt->bind_result($subjectId, $subjectName);

    while($stmt->fetch()){
        echo '<option value="' . $subjectId . '">' . $subjectName . '</option>';
    }
    $stmt->close();
}

function getTeacher($link){
    // $teacher = 'SELECT t.teacherId, t.teacherName, t.teacherImage, r.userId, r.teacherId FROM teacher t, rating r WHERE r.userId = ' . $_SESSION["userId"] . ' AND t.teacherId != r.teacherId ORDER BY rand() LIMIT 1';
    $teacher = 'SELECT teacherId, teacherName, teacherImage FROM teacher WHERE teacherId NOT IN (SELECT teacherId FROM rating WHERE userId = ' . $_SESSION["userId"] . ') ORDER BY rand() LIMIT 1';
    $stmt = $link->prepare($teacher);
    $stmt->execute();
    $stmt->bind_result($teacherId, $teacherName, $teacherImage);
    $stmt->store_result();

    if($stmt->num_rows >= 1){
        while ($stmt->fetch()) {
            $GLOBALS["teacherId"] = $teacherId;
            ?>
            <img src="<?= $teacherImage ?>" class="teacherImage">
            <span class="teacherName"><?= $teacherName ?></span>
            <?php
        }
    } else {
        ?>
        <div class="besked rod">Ikke flere du kan stemme på</div>
        <?php
    }

    $stmt->close();
}

function getRating($link, $teacherId){
    $rating = 'SELECT avg(rating) FROM rating WHERE teacherId = ?';

    $stmt = $link->prepare($rating);
    $stmt->bind_param('i', $teacherId);
    $stmt->execute();
    $stmt->bind_result($avgRating);

    while($stmt->fetch()){
        $avg = round($avgRating, 1);
        ?>
        <span class="avgRating">
            <span class="rated">Bedømmmelse: </span>
            <span class="ratingValue"><?=$avg?></span>
        </span>
        <form action="?vurder=1" method="post">
            <input type="hidden" name="teacherId" id="teacherId" value="<?=$teacherId?>">
            <div class="rating">
                <input type="radio" id="5stjerne" name="rating" value="5" /><label class="full" for="5stjerne" title="Klart over middel"></label>
                <input type="radio" id="4stjerne" name="rating" value="4" /><label class="full" for="4stjerne" title="Over middel"></label>
                <input type="radio" id="3stjerne" name="rating" value="3" /><label class="full" for="3stjerne" title="Middel"></label>
                <input type="radio" id="2stjerne" name="rating" value="2" /><label class="full" for="2stjerne" title="Under middel"></label>
                <input type="radio" id="1stjerne" name="rating" value="1" /><label class="full" for="1stjerne" title="Klart under middel"></label>
            </div>
        </form>
        <?
    }
    $stmt->close();
}

function rate($link, $tid, $rat){
    $rate = 'INSERT INTO rating (userId, rating, teacherId) VALUES (?, ?, ?)';
    $stmt = $link->prepare($rate);
    $stmt->bind_param('iii', $_SESSION["userId"], $rat, $tid);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        besked("success", "Din vurdering er nu gemt");
    } else {
        besked("fejl", "Din vurdering kunne ikke gemmes");
    }

    $stmt->close();
}

function getToplist($link){
    $toplist = 'SELECT teacher.teacherId AS id, teacher.teacherName AS `name`, teacher.teacherImage AS image, SUM(rating.rating) / count(rating) AS average, `subject`.subjectName as subjectName FROM teacher JOIN rating ON teacher.teacherId = rating.teacherId JOIN teacherSubject ON teacher.teacherId = teacherSubject.teacherId JOIN subject ON teacherSubject.subjectId = subject.subjectId GROUP BY id ORDER BY average DESC LIMIT 10';
    $stmt = $link->prepare($toplist);
    $stmt->execute();
    $stmt->bind_result($tid, $tname, $timage, $average, $subjectName);

    $i = 1;
    while($stmt->fetch()){

        ?>
            <img src="<?=$timage?>" class="teacherImage">
            <span class="rank">
                <?=$i?>. <?=$tname?>
            </span>
            <span class="fag">
                Fag: <?=$subjectName?>
            </span>
            <span class="snit">
                Gennemsnit: <?=round($average, 1)?>
            </span>
            <div class="divider"></div>
        <?php
        $i++;
    }

    $stmt->close();
}

function updateInfo($link, $uid, $password){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $update = 'UPDATE user SET password=? WHERE userId=?';
    $stmt = $link->prepare($update);
    $stmt->bind_param('si', $password, $uid);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        besked("success", "Dit kodeord er nu ændret");
    } else {
        besked("fejl", "Kodeordet kunne ikke ændres");
    }
}

function getSubject($link){
    $subject = 'SELECT `subject`.subjectId AS sid, `subject`.subjectName AS subjects, COUNT(`subject`.subjectName) AS antal FROM `subject` JOIN teacherSubject on `subject`.subjectId = teacherSubject.subjectId JOIN teacher ON teacher.teacherId = teacherSubject.teacherId GROUP BY subjects ORDER BY sid ASC';
    $stmt = $link->prepare($subject);
    $stmt->execute();
    $stmt->bind_result($subjectId, $subjectName, $amount);

    while($stmt->fetch()){
        echo '<div class="subject"><a href="?subjectId=' . $subjectId . '">' . $subjectName . '</a> ('.$amount.')</div>';
    }
    $stmt->close();
}

function getTeachersbySubject($link, $subjectId, $userId){
    $teachers = 'SELECT teacher.teacherId AS tid,
teacher.teacherName AS tname,
teacher.teacherImage AS timage,
teacherSubject.teacherId AS tstid,
teacherSubject.subjectId AS tssid,
`subject`.subjectId AS sid,
`subject`.subjectName AS sname

FROM teacher

JOIN teacherSubject ON teacher.teacherId = teacherSubject.teacherId
JOIN `subject` ON teacherSubject.subjectId = `subject`.subjectId

WHERE teacher.teacherId NOT IN (SELECT rating.teacherId FROM rating WHERE userId = ?)
AND `subject`.subjectId = ?

ORDER BY rand()

LIMIT 1';

    $stmt = $link->prepare($teachers);
    $stmt->bind_param('ii', $userId, $subjectId);
    $stmt->execute();
    $stmt->bind_result($tid, $tname, $timage, $tstid, $tssid, $sid, $sname);
    $stmt->store_result();

    if($stmt->num_rows >= 1) {
        while ($stmt->fetch()) {
            $GLOBALS["teacherId"] = $tid;
            ?>
            <img src="<?=$timage?>" class="teacherImage">
            <span class="teacherName"><?=$tname?></span>
            <?php
        }
    } else {
        echo '<div class="besked rod">Ikke flere du kan stemme på</div>';
    }
    $stmt->close();
}

function admin($link){
    $admin = 'SElECT teacher.teacherId AS tid,
teacher.teacherName AS tname,
teacher.teacherImage AS timage,
teacherSubject.teacherId AS tstid,
teacherSubject.subjectId as tssid,
`subject`.subjectName AS sname

FROM teacher

JOIN teacherSubject ON teacher.teacherId = teacherSubject.teacherId
JOIN `subject` ON teacherSubject.subjectId = `subject`.subjectId';
    $stmt = $link->prepare($admin);
    $stmt->execute();
    $stmt->bind_result($tid, $tname, $timage, $tstid, $tssid, $sname);

    echo '<table class="admin" cellpadding="10" cellspacing="10">
                <thead>
                    <th width="100">&nbsp;</th>
                    <th>Navn</th>
                    <th>Fag</th>
                    <th><i class="fa fa-times"></i></th>
                </thead>';

    while($stmt->fetch()){
        ?>
            <tr>
                <td><img src="<?=$timage?>" class="adminImg"></td>
                <td><?=$tname?></td>
                <td><?=$sname?></td>
                <td><a href="?delete=1&tid=<?=$tid?>"><i class="fa fa-times"></i></a></td>
            </tr>
        <?php
    }
    echo '</table>';

    $stmt->close();
}

function deleteSubject($link, $tid){
    $GLOBALS["deleteTeacher"] = 0;
    $fag = 'DELETE FROM teacherSubject WHERE teacherId=?';
    $stmt = $link->prepare($fag);
    $stmt->bind_param('i', $tid);
    $stmt->execute();
    if($stmt->affected_rows > 0){
        $GLOBALS["deleteTeacher"] = 1;
    } else {
        echo "Kunne ikke slette - Del 1";
    }
    $stmt->close();
}

function deleteRating($link, $tid){
    if($GLOBALS["deleteTeacher"] == 1) {
        $rating = 'DELETE FROM rating WHERE teacherId=?';
        $rstmt = $link->prepare($rating);
        $rstmt->bind_param('i', $tid);
        $rstmt->execute();
        if ($rstmt->affected_rows >= 0) {
            $GLOBALS["deleteTeacher"] = 2;
        } else {
            echo "Kunne ikke slette - Del 2";
        }
        $rstmt->close();
    }
}

function deleteTeacher($link, $tid){
    if($GLOBALS["deleteTeacher"] == 2){
        $teacher = 'DELETE FROM teacher WHERE teacherId=?';
        $tstmt = $link->prepare($teacher);
        $tstmt->bind_param('i', $tid);
        $tstmt->execute();
        if($tstmt->affected_rows > 0){
            echo "Læreren er nu slettet";
        } else {
            echo "Kunne ikke slettes - Del 3";
        }
        $tstmt->close();
    }
}