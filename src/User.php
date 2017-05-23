<?php
include_once('src/Db.php');

class User
{
    private $id;
    private $username;
    private $hashPass;
    private $email;

    public function __construct()
    {
        $this->id = -1;
        $this->username = '';
        $this->hashPass = '';
        $this->email = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getHashPass()
    {
        return $this->hashPass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setHashPass($newPass)
    {
        $newHashedPassword = password_hash($newPass, PASSWORD_BCRYPT);
        $this->hashPass = $newHashedPassword;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function saveToDB(PDO $conn)
    {
        if ($this->id == -1) {
            $sql = 'INSERT INTO Users(username, email, hash_pass) VALUES (:username, :email, :pass)';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'email'=> $this->email,
                'pass' => $this->hashPass
            ]);
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $sql = 'UPDATE Users SET username=:username, email=:email, hash_pass=:hash_pass WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'username' => $this->username,
                'email' => $this->email,
                'hash_pass' => $this->hashPass,
                'id' => $this->id
            ]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public static function loadUserById(PDO $conn, $id)
    {
        $sql = 'SELECT * FROM Users WHERE id=:id';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    public static function loadUserByEmail(PDO $conn, $email)
    {
        $sql = 'SELECT * FROM Users WHERE email=:email';
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['email' => $email]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    public static function loadAllUsers(PDO $conn)
    {
        $sql = "SELECT * FROM Users";
        $ret = [];
        $result = $conn->query($sql);
        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->username = $row['username'];
                $loadedUser->hashPass = $row['hash_pass'];
                $loadedUser->email = $row['email'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn)
    {
        if ($this->id != -1) {
            $sql = 'DELETE FROM Users WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

}
