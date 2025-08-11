<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Services\DashboardService;
use BrunaW\MinhaApi\Core\View;

class DashboardController {
    private $dashboardService;

    public function __construct() {
        $this->dashboardService = new DashboardService();
    }

    // Método para renderizar a página HTML do dashboard
    public function index(): View {
        try {
            $dashboardData = $this->dashboardService->getDashboardCompleto();
            
            return View::make('dashboard/dashboard', [
                'title' => 'Dashboard de Projetos',
                'resumo_geral' => $dashboardData['resumo_geral'] ?? null,
                'projetos' => $dashboardData['projetos'] ?? [],
                'timestamp' => $dashboardData['timestamp'] ?? date('Y-m-d H:i:s'),
                'success' => true
            ]);
        } catch (\Exception $e) {
            return View::make('dashboard/dashboard', [
                'title' => 'Dashboard de Projetos',
                'error' => $e->getMessage(),
                'success' => false
            ]);
        }
    }

    // APIs JSON (para chamadas AJAX)
    public function apiInfo() {
        header('Content-Type: application/json');
        echo json_encode([
            "message" => "Dashboard API funcionando!",
            "version" => "1.0.0",
            "endpoints" => [
                "/dashboard/tarefas-por-projeto" => "Estatísticas de tarefas por projeto",
                "/dashboard/resumo-geral" => "Resumo geral do sistema",
                "/dashboard/completo" => "Dashboard completo"
            ]
        ]);
    }

    public function tarefasPorProjeto() {
        header('Content-Type: application/json');
        
        try {
            $estatisticas = $this->dashboardService->estatisticasTarefasPorProjeto();
            
            if ($estatisticas === null) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Nenhum projeto com tarefas encontrado"
                ]);
                return;
            }

            echo json_encode([
                "success" => true,
                "data" => $estatisticas,
                "total_projetos" => count($estatisticas)
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erro interno do servidor"
            ]);
        }
    }

    public function resumoGeral() {
        header('Content-Type: application/json');
        
        try {
            $resumo = $this->dashboardService->resumoGeral();
            
            if ($resumo === null) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Nenhum dado encontrado"
                ]);
                return;
            }

            echo json_encode([
                "success" => true,
                "data" => $resumo
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erro interno do servidor"
            ]);
        }
    }

    public function dashboardCompleto() {
        header('Content-Type: application/json');
        
        try {
            $dashboard = $this->dashboardService->getDashboardCompleto();
            
            if ($dashboard === null) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Nenhum dado encontrado"
                ]);
                return;
            }

            echo json_encode([
                "success" => true,
                "data" => $dashboard
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erro interno do servidor"
            ]);
        }
    }
}