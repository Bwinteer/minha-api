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

$router->post('/usuarios/criar', function($id) {
    $controller = new UsuarioController();
    return $controller->criarUsuario();
});

echo $router->run();