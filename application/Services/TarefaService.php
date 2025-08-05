<?php
namespace BrunaW\MinhaApi\Services;

use BrunaW\MinhaApi\Config\Database;
use BrunaW\MinhaApi\Models\TarefaModel;
use PDO;

class TarefaService {
    private $conn;
    private $tarefaModel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->tarefaModel = new TarefaModel($this->conn);
    }

    public function listarPorProjeto($projeto_id) {
        return $this->tarefaModel->readByProjeto($projeto_id)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $this->tarefaModel->id = $id;
        if ($this->tarefaModel->readOne()) {
            return [
                'id' => $this->tarefaModel->id,
                'titulo' => $this->tarefaModel->titulo,
                'descricao' => $this->tarefaModel->descricao,
                'status' => $this->tarefaModel->status,
                'prioridade' => $this->tarefaModel->prioridade,
                'data_vencimento' => $this->tarefaModel->data_vencimento,
                'projeto_id' => $this->tarefaModel->projeto_id,
                'usuario_id' => $this->tarefaModel->usuario_id
            ];
        }
        return null;
    }

    public function criar($data) {
        $this->tarefaModel->titulo = $data->titulo ?? '';
        $this->tarefaModel->descricao = $data->descricao ?? '';
        $this->tarefaModel->status = $data->status ?? 'pendente';
        $this->tarefaModel->prioridade = $data->prioridade ?? 'media';
        $this->tarefaModel->data_vencimento = $data->data_vencimento ?? null;
        $this->tarefaModel->projeto_id = $data->projeto_id ?? null;
        $this->tarefaModel->usuario_id = $data->usuario_id ?? null;

        if ($this->tarefaModel->create()) {
            return [
                'sucesso' => true,
                'message' => 'Tarefa criada com sucesso.',
                'id' => $this->tarefaModel->id
            ];
        }

        return ['sucesso' => false, 'message' => 'Erro ao criar a tarefa.'];
    }

    public function atualizar($id, $data) {
        $this->tarefaModel->id = $id;
        $this->tarefaModel->titulo = $data->titulo ?? '';
        $this->tarefaModel->descricao = $data->descricao ?? '';
        $this->tarefaModel->status = $data->status ?? 'pendente';
        $this->tarefaModel->prioridade = $data->prioridade ?? 'media';
        $this->tarefaModel->data_vencimento = $data->data_vencimento ?? null;
        $this->tarefaModel->usuario_id = $data->usuario_id ?? null;

        if ($this->tarefaModel->update()) {
            return ['message' => 'Tarefa atualizada com sucesso.'];
        }

        return ['message' => 'Erro ao atualizar a tarefa.'];
    }

    public function deletar($id) {
        $this->tarefaModel->id = $id;
        if ($this->tarefaModel->delete()) {
            return ['message' => 'Tarefa deletada com sucesso.'];
        }
        return ['message' => 'Erro ao deletar a tarefa.'];
    }
}
