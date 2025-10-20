<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "root2025";
    private $database = "php_demo";
    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>
