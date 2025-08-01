<?php
include_once __DIR__ . '/../services/ProjetoService.php';

class ProjetoController {
    private $projetoService;

    public function __construct() {
        $this->projetoService = new ProjetoService();
    }

    public function listarProjetos() {
        $projetos = $this->projetoService->listarTodos();
        echo json_encode($projetos ?: ["message" => "Nenhum projeto encontrado"]);
    }

    public function buscarProjeto($id) {
        $projeto = $this->projetoService->buscarPorId($id);
        echo json_encode($projeto ?: ["message" => "Projeto não encontrado"]);
    }

    public function criarProjeto() {
        $data = json_decode(file_get_contents("php://input"));
        $resultado = $this->projetoService->criar($data);

        if ($resultado['sucesso']) {
            echo json_encode([
                "message" => $resultado['message'],
                "id" => $resultado['id']
            ]);
        } else {
            echo json_encode(["message" => $resultado['message']]);
        }
    }

    public function atualizarProjeto($id) {
        $data = json_decode(file_get_contents("php://input"));
        $resultado = $this->projetoService->atualizar($id, $data);
        echo json_encode(["message" => $resultado['message']]);
    }

    public function deletarProjeto($id) {
        $resultado = $this->projetoService->deletar($id);
        echo json_encode(["message" => $resultado['message']]);
    }
}
