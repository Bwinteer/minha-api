<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Services\TarefaService;

class TarefaController {
    private $tarefaService;

    public function __construct() {
        $this->tarefaService = new TarefaService();
    }

    public function listarTarefas() {
        $tarefas = $this->tarefaService->listarTodasTarefas();
        echo json_encode($tarefas ?: ["message" => "Nenhuma tarefa encontrada"]);
    }

    public function listarTarefasPorProjeto($projeto_id) {
        $tarefas = $this->tarefaService->listarPorProjeto($projeto_id);
        echo json_encode($tarefas ?: ["message" => "Nenhuma tarefa encontrada para este projeto"]);
    }

    public function buscarTarefa($id) {
        $tarefa = $this->tarefaService->buscarPorId($id);
        echo json_encode($tarefa ?: ["message" => "Tarefa não encontrada"]);
    }

    public function criarTarefa() {
        $data = json_decode(file_get_contents("php://input"));
        $resultado = $this->tarefaService->criar($data);

        if ($resultado['sucesso']) {
            echo json_encode([
                "message" => $resultado['message'],
                "id" => $resultado['id']
            ]);
        } else {
            echo json_encode(["message" => $resultado['message']]);
        }
    }

    public function atualizarTarefa($id) {
        $data = json_decode(file_get_contents("php://input"));
        $resultado = $this->tarefaService->atualizar($id, $data);
        echo json_encode(["message" => $resultado['message']]);
    }

    public function deletarTarefa($id) {
        $resultado = $this->tarefaService->deletar($id);
        echo json_encode(["message" => $resultado['message']]);
    }
}