<?php
class Database {
    private $host = "localhost";
    private $db_name = "test";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_errno) {
                throw new Exception("Failed to connect to MySQL: " . $this->conn->connect_error);
            }
        } catch (Exception $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
