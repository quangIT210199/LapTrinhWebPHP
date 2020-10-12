<?php

class Database
{
    private $host ;
    private $database_name;
    private $username;
    private $password;

    private $conn = null;
    function __construct() {
        $this->host = $_ENV["HOST"];        
        $this->database_name = $_ENV["DATABASE_NAME"];
        $this->username = $_ENV["USERNAME_DB"];
        $this->password = $_ENV["PASSWORD_DB"];
    }
    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException  $e) {
            echo "Database could not be connected: " . $e->getMessage();
        }
        return $this->conn;
    }
}
