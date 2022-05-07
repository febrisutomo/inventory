<?php
class Database
{
    protected $db;

    public function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'db_inventory');

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

}
