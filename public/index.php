<?php
use BrunaW\MinhaApi\Controllers\DashboardController;
use BrunaW\MinhaApi\Controllers\UsuarioController;
use BrunaW\MinhaApi\Core\Router;
require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->get('/', [DashboardController::class, 'index']);
$router->get('/usuarios', [UsuarioController::class, 'listarUsuarios']);

$router->get('/usuarios/{id}', function($id) {
    $controller = new UsuarioController();
    return $controller->buscarUsuario($id);
});

$router->post('/usuarios/criar', function() {
    //Está lendo o conteúdo bruto da requisição
    $json = file_get_contents('php://input');

    //Decodifica o JSON em um array associativo
    $dados = json_decode($json, true);

    //Verifica se a decodificação foi bem-sucedida
    if ($dados === null) {
        // Envie uma resposta de erro se o JSON for inválido
        header('Content-Type: application/json');
        http_response_code(400); // Bad Request
        return json_encode(['error' => 'JSON inválido.']);
    }

    $controller = new UsuarioController();
    return $controller->criarUsuario($dados);
});

$router->put('/usuarios/atualizar/{id}', function($id) {
    $controller = new UsuarioController();
    return $controller->atualizarUsuario($id);
});

$router->delete('/usuarios/delete/{id}', function($id) {
    $controller = new UsuarioController();
    return $controller->deletarUsuario($id);
});

echo $router->run();