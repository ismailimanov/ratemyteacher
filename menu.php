<div class="menuIndhold">
    <nav class="menu">
        <div class="profil"><img src="http://lorempixel.com/42/42/" alt="Ismail Imanov"/><span><?=$_SESSION["username"]?></span></div>
        <div class="menuPunkter">
            <a href="index.php"><span>Forside</span></a>
            <a href="toplist.php"><span>Topliste</span></a>
            <a href="subjects.php"><span>Fag</span></a>
            <a href="settings.php"><span>Indstillinger</span></a>
        </div>
        <div class="ikoner">
            <a href="index.php"><i class="fa fa-fw fa-home"></i></a>
            <a href="createTeacher.php"><i class="fa fa-fw fa-plus"></i></a>
            <?=($_SESSION["userId"] == 1 ? '<a href="admin.php"><i class="fa fa-fw fa-lock"></i></a>' : '')?>
            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i></a>
        </div>
    </nav>
</div>
<button class="menuKnap" id="aabnMenu"><i class="fa fa-fw fa-cog fa-spin"></i><span>Åbn Menu</span></button>