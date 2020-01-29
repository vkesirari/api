<?php
class Database
{
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "root";
    public $conn;

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;
        try {
            //database config
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            //for any exception if dtaabase or any other not    
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>