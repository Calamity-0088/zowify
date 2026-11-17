<?php

class Database
{
    private $host,
        $dbname,
        $charset,
        $user,
        $password,
        $conn;

    public function __construct()
    {
        $this->host = $_ENV['DATABASE_HOSTNAME'];
        $this->dbname = $_ENV['DATABASE_NAME'];
        $this->charset = $_ENV['DATABASE_CHARSET'];
        $this->user = $_ENV['DATABASE_USERNAME'];
        $this->password = $_ENV['DATABASE_PASSWORD'];
    }

    public function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;
        } catch (PDOException $error) {
            echo 'Error' . $error;
        }
    }
}
