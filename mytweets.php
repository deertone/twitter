<?php
session_start();
require_once('./autoloader.php');
if (!isset($_SESSION['id'])) {
    header('location:./login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['id']) && !empty($_POST['message']) && $_POST['test'] == 5) {
        if ($_SESSION['id'] != $_GET['receiverId']) {
            echo $senderId = $_SESSION['id'];
            echo $receiverId = $_GET['receiverId'];
            echo $text = $_POST['message'];
            echo $creationDate = date('Y-m-d H:i:s', time());
            echo $status = 0;

            $obj = new Message();

            $obj->setSenderId($senderId);
            $obj->setReceiverId($receiverId);
            $obj->setText($text);
            $obj->setCreationDate($creationDate);
            $obj->setStatus($status);
            $obj->saveToDB($db->conn);
            echo 'Wiadomość została wysłana!';
        } else {
            echo 'Nie moża wysyłać wiadmości do siebie';
        }
    }
}

 ?>


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
                    Wszystkie tweety użytkowika
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:30px;">
                    <form action="" method="POST" role="form" class="user_form">
                        <legend>wyślij wiadomość użytkownikowi</legend>
                        <div class="form-group">
                            <label for="message">wiadomość</label>
                            <textarea class="form-control" rows="3" name="message" id="message" maxlength="60" placeholder="Treść wiadomości max 60 znaków..." ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="test">2 + 3 =</label>
                            <input type="number" class="form-control" name="test" id="test" maxlength="1"
                                   placeholder="Wynik...">
                        </div>
                        <button type="submit" name="user" value="user" class="btn btn-primary">dodaj</button>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="margin-top:30px;">
                    <h4 class="text-center">lista tweetów</h4><br>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>tweet</th>
                            <th>data</th>
                            <th>komentarze</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $tweet = new Tweet();
                            if(!empty($_GET['receiverId'])){
                                $allTweets = $tweet->loadAllTweetsByUserId($db->conn, $_GET['receiverId']);
                            }else {
                                $allTweets = $tweet->loadAllTweetsByUserId($db->conn, $_SESSION['id']);
                            }
                            foreach ($allTweets as $row) {
                                echo
                                "<tr><td>"
                                .$row->getText().
                                "</td><td>"
                                .$row->getCreationDate().
                                "</td><td>"
                                .count(Comment::loadAllCommentsByPostId($db->conn, $row->getId())).
                                "</td><td>"
                                ."<a class='btn btn-primary' role='button' href='postcomment.php?id=".$row->getId()."'>więcej</a>".
                                "</td></tr>";
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
