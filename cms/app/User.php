<?php

class User
{
    private $db;
    private $id;
    private $username;
    private $email;
    private $role;

    public function __construct($db){
        $this->db = $db;
    }

    public function register($username, $password, $email){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':username' => $username, ':email' => $email]);
        if ($stmt->rowCount() > 0){
            return false;
        }

        $query = "INSERT INTO users (username, email, password) VALUES(:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        if ($stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword])) {
            return true;
        }
        return false;
    }

    public function login($username, $password){
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':username' => $username]);

        if ($stmt->rowCount() == 1){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])){
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->role = $row['role'];

                $_SESSION['user_id'] = $this->id;
                $_SESSION['username'] = $this->username;
                $_SESSION['role'] = $this->role;
                return true;
            }
        }

        return false;
    }

    public function getAllUsers(){
        $query = "SELECT * FROM users WHERE role != 'admin'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}