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
    <body>
        <div class="container">
            <?php require_once('./header.php'); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
                    <?php

                        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            $messages = Message::loadAllMessagesByReceiverId($db->conn, $_SESSION['id']);
                            $statTable = [];
                            foreach ($messages as $row) {
                                if ($row->getStatus() == 0) {
                                    $statTable[] = $row->getStatus();
                                }
                            }
                            if (!isset($_GET['id']) && count($statTable) > 0) {
                                $messagesNumber = count($statTable);
                                echo "<p>Masz $messagesNumber wiadomość/ci </p>";
                                echo "<a class='btn btn-primary' role='button' href='messages.php?id=0'>Odbierz</a>";
                            } else {
                                echo "Brak nieodebranych wiadomości";
                            }
                        }
                        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            if (isset($_GET['id'])) {
                                $messages = Message::loadAllMessagesByReceiverId($db->conn, $_SESSION['id']);
                                foreach ($messages as $row) {
                                    if ($row->getStatus() == 0) {
                                        $obj = new Message();
                                        $update = $obj->loadMessageById($db->conn, $row->getId());
                                        $update->setStatus(1);
                                        $update->saveToDB($db->conn);
                                    }
                                }
                            }
                        }
                     ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="margin-top:60px;">
                    <h4 class="text-center">wiadomości odebrane</h4><br>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>wiadomość</th>
                            <th>data</th>
                            <th>od</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $messages = Message::loadAllMessagesByReceiverId($db->conn, $_SESSION['id']);
                            foreach ($messages as $row) {
                                if ($row->getStatus() == 1) {
                                    echo
                                "<tr><td>"
                                .$row->getText().
                                "</td><td>"
                                .$row->getCreationDate().
                                "</td><td>"
                                .User::loadUserById($db->conn, $row->getSenderId())->getUsername().
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
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="margin-top:60px;">
                    <h4 class="text-center">wiadomości wysłane</h4><br>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>wiadomość</th>
                            <th>data</th>
                            <th>do</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $messages = Message::loadAllMessagesBySenderId($db->conn, $_SESSION['id']);
                            foreach ($messages as $row) {
                                    echo
                                "<tr><td>"
                                .$row->getText().
                                "</td><td>"
                                .$row->getCreationDate().
                                "</td><td>"
                                .User::loadUserById($db->conn, $row->getReceiverId())->getUsername().
                                "</td></tr>";
                            }
                        ?>
                        </tbody>
                      </table>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                </div>
        </div>
    </body>
</html>
