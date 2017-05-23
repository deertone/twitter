<?php

class Tweet
{
    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function __construct()
    {
        $this->id = -1;
        $this->userId = '';
        $this->text = '';
        $this->creationDate = '';
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Tweet(userId, text, creationDate) VALUES (:userId, :text, :creationDate)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'text'=> $this->text,
                'creationDate' => $this->creationDate
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $sql = 'UPDATE Tweet SET userId=:userId, text=:text, creationDate=:creationDate WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'text'=> $this->text,
                'creationDate' => $this->creationDate,
                'id' => $this->id
            ]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function loadTweetById(PDO $conn, $id)
    {
        $sql = 'SELECT * FROM Tweet WHERE id=:id';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];
            return $loadedTweet;
        }
        return null;
    }

    public static function loadAllTweetsByUserId(PDO $conn, $id)
    {
        $sql = "SELECT * FROM Tweet WHERE userId=:id ORDER BY creationDate DESC;";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        $returnTable = [];
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];
                $returnTable[] = $loadedTweet;
            }
        }
        return $returnTable;
    }

    public static function loadAllTweets(PDO $conn)
    {
        $sql = "SELECT * FROM Tweet ORDER BY creationDate DESC;";
        $ret = [];
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }
}
