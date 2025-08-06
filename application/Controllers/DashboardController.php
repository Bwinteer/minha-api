<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Core\View;

//Esse controller serve para renderizar a página de dashboard da aplicação, passando à view dois dados abaixo
class DashboardController {
    public function index(): View {
        return View::make('dashboard/index', [
            'title' => 'Dashboard',
            'user' => 'Bruna Teste'
        ]);
    }
}