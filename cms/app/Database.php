<?php

class Database{
    private $host = "project-db:3306";
    private $db_name = "cms";
    private $username = "root";
    private $password = "QWEasd123!";
    private $conn;

    public function connect(){
        $this->conn = null;

        try {

            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
        }catch(PDOException $e){
            echo 'Ошибка подключения: '.$e->getMessage();
        }

        return $this->conn;
    }
}