<?php
session_start();
require_once('./autoloader.php');
if (!isset($_SESSION['id'])) {
    header('location:./login.php');
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Twitter</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body

        <div class="container">
            <?php require_once('./header.php'); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
                    <?php
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $obj = new User();
                        if(!empty($_POST['name']) && $_POST['test'] == 5){
                            $name = $_POST['name'];
                            $user = $obj->loadUserById($db->conn, $_SESSION['id']);
                            $user->setUsername($name);
                            $user->saveToDB($db->conn);
                            echo "<p>Nazwa użytkownika została zmieniona na $name</p>";
                        } elseif(!empty($_POST['email']) && $_POST['test'] == 8) {
                            $email = $_POST['email'];
                            $user = $obj->loadUserById($db->conn, $_SESSION['id']);
                            $user->setEmail($email);
                            $user->saveToDB($db->conn);
                            echo "<p>Adres e-mail został zmieniony na $email</p>";
                        } elseif(!empty($_POST['password']) && $_POST['test'] == 7){
                            $pass = $_POST['password'];
                            $user = $obj->loadUserById($db->conn, $_SESSION['id']);
                            $user->setHashPass($pass);
                            $user->saveToDB($db->conn);
                            echo "<p>Hasło zostało poprawnie zmienione</p>";
                        } else {
                            echo "<p>Zmieniane pola nie mogą być puste</p>";
                        }
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'GET'){
                        $obj = new User();
                        if(!empty($_GET['name']) && $_GET['name'] == "delete"){
                            $user = $obj->loadUserById($db->conn, $_SESSION['id']);
                            $user->delete($db->conn);
                            session_unset();
                            header('location:./login.php');
                        }
                    }
                     ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:30px;">
                    <form action="" method="POST" role="form" class="user_form">
                        <legend>zmiana danych / usuwanie konta</legend>
                        <div class="form-group">
                            <label for="name"> nowa nazwa użytkownika</label>
                            <input type="text" class="form-control" name="name" id="name" maxlength="255"
                                   placeholder="nazwa...">
                        </div>
                        <div class="form-group">
                            <label for="test">2 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="255"
                                   placeholder="wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">zmień</button>
                    </form>
                    <form action="" method="POST" role="form" class="user_form" style="margin-top:30px;">
                        <div class="form-group">
                            <label for="email">nowy e-mail</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="255"
                                   placeholder="e-mail...">
                        </div>
                        <div class="form-group">
                            <label for="test">5 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="255"
                                   placeholder="wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">zmień</button>
                    </form>
                    <form action="" method="POST" role="form" class="user_form" style="margin-top:30px;">
                        <div class="form-group">
                            <label for="password">nowe hasło</label>
                            <input type="password" class="form-control" name="password" id="password" maxlength="255"
                                   placeholder="hasło...">
                        </div>
                        <div class="form-group">
                            <label for="test">4 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="255"
                                   placeholder="wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">zmień</button>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:60px;">
                    <p>Wciśnięcie poniższego przycisku spowoduje <b>bezpowrotne usunięcie</b> konta.<p>
                    <a class="btn btn-primary" href="settings.php?name=delete" role="button">usuń konto</a>
                </div>
            </div>
        </div>
    </body>
</html>
