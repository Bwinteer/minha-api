<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Core\View;

//Permite misturar o PHP com o HTML
class DashboardController {
    public function index(): View {
        return View::make('dashboard/index', [
            'title' => 'Dashboard',
            'user' => 'Bruna Teste'
        ]);
    }
}