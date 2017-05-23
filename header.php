<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h1>Light Twitter</h1>
        <h4>the heaven defying application</h4>
        <?php if (isset($_SESSION['id'])) {?>
        <br>
        <span> Witaj użytkowniku <b><?php echo User::loadUserById($db->conn, $_SESSION['id'])->getUsername(); ?></b></span>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
        <?php if (isset($_SESSION['id'])) {?>
        <a class="btn btn-primary" href="index.php" role="button">strona główna</a>
        <a class="btn btn-primary" href="mytweets.php" role="button">moje tweety</a>
        <a class="btn btn-primary" href="messages.php" role="button">moje wiadomości</a>
        <a class="btn btn-primary" href="settings.php" role="button">ustawienia</a>
        <a class="btn btn-primary" href="logout.php" role="button">wyloguj</a>
        <?php } ?>
        <?php if (!isset($_SESSION['id'])) {?>
        <a class="btn btn-primary" href="login.php" role="button">logowanie</a>
        <a class="btn btn-primary" href="register.php" role="button">rejestracja</a>
        <?php } ?>

    </div>
</div>
