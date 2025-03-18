<?php
class Database {
    private $host = "mysql.railway.internal";  // Extrait de MYSQL_PUBLIC_URL
    private $db_name = "railway";
    private $username = "root";
    private $password = "JcVkpkMZMJqFawqpvoHUWJsSFoFZJojy";
    private $port = "3306";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            return $this->conn;
        } catch(PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
            return null;
        }
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>