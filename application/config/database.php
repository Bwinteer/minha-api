<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'minha_api';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Cria a conexão PDO(Conecta com o banco de dados)
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
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