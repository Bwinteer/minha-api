<?php
// Headers para API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Incluir o controller
include_once __DIR__ . '/../controllers/UsuarioController.php';
include_once __DIR__ . '/../controllers/ProjetoController.php';
include_once __DIR__ . '/../controllers/TarefaController.php';

// Criar instância do controller
$controller = new UsuarioController();

// Pegar o método HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Pegar o ID da URL (se existir)
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            // GET com ID = buscar um usuário específico
            $controller->buscarUsuario($id);
        } else {
            // GET sem ID = listar todos os usuários
            $controller->listarUsuarios();
        }
        break;

    case 'POST':
        $controller->criarUsuario();
        break;

    case 'PUT':
        if ($id) {
            $controller->atualizarUsuario($id);
        } else {
            echo json_encode(["message" => "ID é obrigatório para atualizar"]);
        }
        break;

    case 'DELETE':
        if ($id) {
            $controller->deletarUsuario($id);
        } else {
            echo json_encode(["message" => "ID é obrigatório para deletar"]);
        }
        break;

    default:
        echo json_encode(["message" => "Método não permitido"]);
        break;
}