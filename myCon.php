<?php
class Database {
    private $host = "yamabiko.proxy.rlwy.net";  // Utiliser MYSQL_PUBLIC_URL
    private $db_name = "railway";
    private $username = "root";
    private $password = "JcVkpkMZMJqFawqpvoHUWJsSFoFZJojy";
    private $port = "37994";  // Port personnalisé de MYSQL_PUBLIC_URL
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
}

?>