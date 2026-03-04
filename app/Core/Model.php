<?php

require_once('../app/Core/Database.php');

class Model
{
    public $db;

    public function __construct(Database $database)
    {
        $this->db = $database->connect();
    }
}
