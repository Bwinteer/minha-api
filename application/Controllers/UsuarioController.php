<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Services\UsuarioService;

class UsuarioController {
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function listarUsuarios() {
        $usuarios = $this->usuarioService->listarTodos();
        
        if($usuarios) {
            echo json_encode($usuarios);
        } else {
            echo json_encode(["message" => "Nenhum usuário encontrado"]);
        }
    }

    public function buscarUsuario($id) {
        $usuario = $this->usuarioService->buscarPorId($id);
        
        if($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(["message" => "Usuário não encontrado"]);
        }
    }

    public function criarUsuario($data) {
        // Pegar dados enviados (JSON)
        $data = json_decode(file_get_contents("php://input"));
        
        $resultado = $this->usuarioService->criar($data);
        
        if($resultado['sucesso']) {
            echo json_encode([
                "message" => $resultado['message'],
                "id" => $resultado['id']
            ]);
        } else {
            echo json_encode(["message" => $resultado['message']]);
        }
    }

    public function atualizarUsuario($id) {
        $data = json_decode(file_get_contents("php://input"));
        
        $resultado = $this->usuarioService->atualizar($id, $data);
        
        echo json_encode(["message" => $resultado['message']]);
    }

    public function deletarUsuario($id) {
        $resultado = $this->usuarioService->deletar($id);
        
        echo json_encode(["message" => $resultado['message']]);
    }
}
