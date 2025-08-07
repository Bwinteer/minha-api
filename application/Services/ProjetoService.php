<?php
namespace BrunaW\MinhaApi\Services;

use BrunaW\MinhaApi\Config\Database;
use BrunaW\MinhaApi\Models\ProjetoModel;
use PDO;

class ProjetoService {
    private $conn;
    private $projetoModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->projetoModel = new ProjetoModel($this->conn);
    }

    public function listarTodos() {
        $stmt = $this->projetoModel->read();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $this->projetoModel->id = $id;
        if ($this->projetoModel->readOne()) {
            return [
                'id' => $this->projetoModel->id,
                'nome' => $this->projetoModel->nome,
                'descricao' => $this->projetoModel->descricao,
                'created_at' => $this->projetoModel->created_at
            ];
        }
        return null;
    }

    public function criar($data) {
        $this->projetoModel->nome = $data->nome ?? '';
        $this->projetoModel->descricao = $data->descricao ?? '';

        if ($this->projetoModel->create()) {
            return [
                'sucesso' => true,
                'message' => 'Projeto criado com sucesso.',
                'id' => $this->projetoModel->id
            ];
        }

        return ['sucesso' => false, 'message' => 'Erro ao criar o projeto.'];
    }

    public function atualizar($id, $data) {
        $this->projetoModel->id = $id;
        $this->projetoModel->nome = $data->nome ?? '';
        $this->projetoModel->descricao = $data->descricao ?? '';

        if ($this->projetoModel->update()) {
            return ['message' => 'Projeto atualizado com sucesso.'];
        }

        return ['message' => 'Erro ao atualizar o projeto.'];
    }

    public function deletar($id) {
        $this->projetoModel->id = $id;
        if ($this->projetoModel->delete()) {
            return ['message' => 'Projeto deletado com sucesso.'];
        }
        return ['message' => 'Erro ao deletar o projeto.'];
    }
}