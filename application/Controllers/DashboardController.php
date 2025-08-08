<?php
namespace BrunaW\MinhaApi\Controllers;

use BrunaW\MinhaApi\Services\DashboardService;

class DashboardController {
    private $dashboardService;

    public function __construct() {
        $this->dashboardService = new DashboardService();
    }

    public function index() {
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