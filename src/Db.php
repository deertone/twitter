<?php

// $host = 'localhost';
// $db = 'twitter';
// $user = 'root';
// $pass = 'coderslab';
//
// try {
//     $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ]);
// } catch (Exception $e) {
//     echo "Uwaga: " . $e->getMessage() . "<br>";
// }

class Db {
    private $host = null;
    private $db = null;
    private $user = null;
    private $pass = null;
    public $conn = null;

    public function __construct($host = 'localhost', $db = 'twitter', $user = 'root', $pass = 'coderslab'){
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (Exception $e) {
            echo "Uwaga: " . $e->getMessage() . "<br>";
        }
    }
}

$db = new Db();
