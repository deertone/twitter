<?php

class Comment
{
    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;

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

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
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

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function __construct()
    {
        $this->id = -1;
        $this->userId = '';
        $this->postId = '';
        $this->creationDate = '';
        $this->text = '';
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Comment(userId, postId, creationDate, text) VALUES (:userId, :postId, :creationDate, :text)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'postId'=> $this->postId,
                'creationDate' => $this->creationDate,
                'text' => $this->text
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $sql = 'UPDATE Tweet SET userId=:userId, postId=:postId, creationDate=:creationDate, text=:text WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'userId' => $this->userId,
                'postId'=> $this->postId,
                'creationDate' => $this->creationDate,
                'text' => $this->text,
                'id' => $this->id
            ]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function loadCommentById(PDO $conn, $id)
    {
        $sql = 'SELECT * FROM Comment WHERE id=:id';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['userId'];
            $loadedComment->postId = $row['postId'];
            $loadedComment->creationDate = $row['creationDate'];
            $loadedComment->text = $row['text'];
            return $loadedComment;
        }
        return null;
    }

    public static function loadAllCommentsByPostId(PDO $conn, $postId)
    {
        $sql = "SELECT * FROM Comment WHERE postId=:postId ORDER BY creationDate DESC;";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['postId' => $postId]);
        $returnTable = [];
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->postId = $row['postId'];
                $loadedComment->creationDate = $row['creationDate'];
                $loadedComment->text = $row['text'];
                $returnTable[] = $loadedComment;
            }
        }
        return $returnTable;
    }



}
