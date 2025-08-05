<?php
namespace BrunaW\MinhaApi\Config;

use PDO;
use PDOException;
class Database {
    private $host = '127.0.0.1';
    private $db_name = 'minha_api';
    private $username = 'root';
    private $password = 'root';
    private $port = 3308;
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Cria a conexão PDO(Conecta com o banco de dados)
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>