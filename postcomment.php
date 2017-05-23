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
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="margin-top:30px;">
                    <h3 class="text-center" style="margin-bottom:30px;">tweet info</h3>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>tweet</th>
                            <th>data</th>
                            <th>użytkownik</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(isset($_GET['id'])){
                                $obj = new Tweet();
                                $tweet = $obj->loadTweetById($db->conn, $_GET['id']);
                                $username = User::loadUserById($db->conn, $tweet->getUserId())->getUsername();
                                    echo
                                    "<tr><td>"
                                    .$tweet->getText().
                                    "</td><td>"
                                    .$tweet->getCreationDate().
                                    "</td><td>"
                                    .$username.
                                    "</td><td>"
                                    ."<a class='btn btn-primary' role='button' href='mytweets.php?receiverId=".$tweet->getUserId()."'>wyślij prywatną wiadomość</a>".
                                    "</td></tr>";
                            }
                            else {
                                echo "Uwaga! Coś poszło nie tak, brak danych ";
                            }
                        ?>
                        </tbody>
                      </table>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['comment']) && $_POST['test'] == 5) {
                        $postId = $_GET['id'];
                        $userId = $_SESSION['id'];
                        $creationDate = date('Y-m-d H:i:s', time());
                        $text = $_POST['comment'];

                        $obj = new Comment();

                        $obj->setPostId($postId);
                        $obj->setUserId($userId);
                        $obj->setCreationDate($creationDate);
                        $obj->setText($text);
                        $obj->saveToDB($db->conn);

                        echo "<p>nowy komentarz został dodany</p>";
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
                        <legend>dodaj komentarz</legend>
                        <div class="form-group">
                            <label for="comment">treść komentarza</label>
                            <textarea class="form-control" name="comment" id="comment" maxlength="60" placeholder="komentarz max 60 znaków..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="test">2 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="1"
                                   placeholder="wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">Dodaj</button>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="margin-top:30px;">
                    <h4 class="text-center">komentarze</h4><br>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>komentarz</th>
                            <th>data</th>
                            <th>użytkownik</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(isset($_GET['id'])){
                                $comments = Comment::loadAllCommentsByPostId($db->conn, $_GET['id']);
                                foreach ($comments as $row) {
                                    echo
                                    "<tr><td>"
                                    .$row->getText().
                                    "</td><td>"
                                    .$row->getCreationDate().
                                    "</td><td>"
                                    .User::loadUserById($db->conn, $row->getUserId())->getUsername().
                                    "</td></tr>";
                                }
                            }
                        ?>
                        </tbody>
                      </table>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
            </div>
        </div>
    </body>
</html>
