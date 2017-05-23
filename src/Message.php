<?php

class Message
{
    private $id;
    private $senderId;
    private $receiverId;
    private $text;
    private $creationDate;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
        return $this;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }

    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function __construct()
    {
        $this->id = -1;
        $this->senderId = '';
        $this->receiverId = '';
        $this->text = '';
        $this->creationDate = '';
        $this->status = '';
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Message(senderId, receiverId, text, creationDate, status) VALUES (:senderId, :receiverId, :text, :creationDate, :status)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'senderId' => $this->senderId,
                'receiverId' => $this->receiverId,
                'text'=> $this->text,
                'creationDate' => $this->creationDate,
                'status' => $this->status
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $sql = 'UPDATE Message SET senderId=:senderId, receiverId=:receiverId, text=:text, creationDate=:creationDate, status=:status WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'senderId' => $this->senderId,
                'receiverId' => $this->receiverId,
                'text'=> $this->text,
                'creationDate' => $this->creationDate,
                'status' => $this->status,
                'id' => $this->id
            ]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function loadMessageById(PDO $conn, $id)
    {
        $sql = 'SELECT * FROM Message WHERE id=:id';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->senderId = $row['senderId'];
            $loadedMessage->receiverId = $row['receiverId'];
            $loadedMessage->text = $row['text'];
            $loadedMessage->creationDate = $row['creationDate'];
            $loadedMessage->status = $row['status'];
            return $loadedMessage;
        }
        return null;
    }

    public static function loadAllMessagesBySenderId(PDO $conn, $senderId)
    {
        $sql = "SELECT * FROM Message WHERE senderId=:senderId ORDER BY creationDate DESC;";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['senderId' => $senderId]);
        $returnTable = [];
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['senderId'];
                $loadedMessage->receiverId = $row['receiverId'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creationDate'];
                $loadedMessage->status = $row['status'];
                $returnTable[] = $loadedMessage;
            }
        }
        return $returnTable;
    }

    public static function loadAllMessagesByReceiverId(PDO $conn, $receiverId)
    {
        $sql = "SELECT * FROM Message WHERE receiverId=:receiverId ORDER BY creationDate DESC;";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['receiverId' => $receiverId]);
        $returnTable = [];
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['senderId'];
                $loadedMessage->receiverId = $row['receiverId'];
                $loadedMessage->text = $row['text'];
                $loadedMessage->creationDate = $row['creationDate'];
                $loadedMessage->status = $row['status'];
                $returnTable[] = $loadedMessage;
            }
        }
        return $returnTable;
    }
}
