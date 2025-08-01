<?php
class TarefaModel {
    private $conn;
    private $table_name = "tarefas";

    public $id;
    public $titulo;
    public $descricao;
    public $status;
    public $prioridade;
    public $data_vencimento;
    public $projeto_id;
    public $usuario_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (titulo, descricao, status, prioridade, data_vencimento, projeto_id, usuario_id) 
                  VALUES (:titulo, :descricao, :status, :prioridade, :data_vencimento, :projeto_id, :usuario_id)";

        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->prioridade = htmlspecialchars(strip_tags($this->prioridade));
        $this->data_vencimento = htmlspecialchars(strip_tags($this->data_vencimento));
        $this->projeto_id = htmlspecialchars(strip_tags($this->projeto_id));
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));

        // Liga os parâmetros
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':prioridade', $this->prioridade);
        $stmt->bindParam(':data_vencimento', $this->data_vencimento);
        $stmt->bindParam(':projeto_id', $this->projeto_id);
        $stmt->bindParam(':usuario_id', $this->usuario_id);

        return $stmt->execute();
    }

    public function readByProjeto($projeto_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE projeto_id = :projeto_id ORDER BY data_vencimento";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projeto_id', $projeto_id);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
            $this->status = $row['status'];
            $this->prioridade = $row['prioridade'];
            $this->data_vencimento = $row['data_vencimento'];
            $this->projeto_id = $row['projeto_id'];
            $this->usuario_id = $row['usuario_id'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET titulo = :titulo, descricao = :descricao, status = :status, 
                      prioridade = :prioridade, data_vencimento = :data_vencimento, 
                      usuario_id = :usuario_id 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpa
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->prioridade = htmlspecialchars(strip_tags($this->prioridade));
        $this->data_vencimento = htmlspecialchars(strip_tags($this->data_vencimento));
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':prioridade', $this->prioridade);
        $stmt->bindParam(':data_vencimento', $this->data_vencimento);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>
