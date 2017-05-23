<?php
require_once('./autoloader.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && $_POST['test'] == 5){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $obj = new User();
        $obj->setUsername($name);
        $obj->setEmail($email);
        $obj->setHashPass($pass);
        $obj->saveToDB($db->conn);
        echo "Utworzono nowe konto dla użytkownika $name";
    } else {
        echo 'Niepoprawnie wypełnione pola';
    }
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
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:30px;">
                    <form action="" method="POST" role="form" class="user_form">
                        <legend>zarejestruj się</legend>
                        <div class="form-group">
                            <label for="name">nazwa użytkownika</label>
                            <input type="text" class="form-control" name="name" id="name" maxlength="255"
                                   placeholder="nazwa...">
                        </div>
                        <div class="form-group">
                            <label for="email">e-mail</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="255"
                                   placeholder="e-mail...">
                        </div>
                        <div class="form-group">
                            <label for="password">hasło</label>
                            <input type="password" class="form-control" name="password" id="password" maxlength="255"
                                   placeholder="hasło...">
                        </div>
                        <div class="form-group">
                            <label for="test">2 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="255"
                                   placeholder="wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">dodaj</button>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
            </div>
        </div>
    </body>
</html>
