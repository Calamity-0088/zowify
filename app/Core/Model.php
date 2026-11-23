<?php

require_once('../app/Core/Database.php');

class Model
{
    public Database $database;
    public PDO $conn;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->conn = $database->connect();
    }
}
