<?php
namespace BrunaW\MinhaApi\Services;

use BrunaW\MinhaApi\Models\DashboardModel;

class DashboardService {
    private $dashboardModel;

    public function __construct() {
        $this->dashboardModel = new DashboardModel();
    }

    public function estatisticasTarefasPorProjeto() {
        try {
            $dados = $this->dashboardModel->estatisticasTarefasPorProjeto();
            
            if (empty($dados)) {
                return null;
            }

            // Processa os dados para garantir tipos corretos
            $resultado = [];
            foreach ($dados as $projeto) {
                $resultado[] = [
                    'projeto_id' => (int) $projeto['projeto_id'],
                    'projeto_nome' => $projeto['projeto_nome'],
                    'projeto_descricao' => $projeto['projeto_descricao'],
                    'total_tarefas' => (int) $projeto['total_tarefas'],
                    'tarefas_concluidas' => (int) $projeto['tarefas_concluidas'],
                    'tarefas_pendentes' => (int) $projeto['tarefas_pendentes'],
                    'percentual_conclusao' => (float) $projeto['percentual_conclusao']
                ];
            }

            return $resultado;
        } catch (\Exception $e) {
            error_log("Erro ao obter estatísticas por projeto: " . $e->getMessage());
            return null;
        }
    }

    public function resumoGeral() {
        try {
            $dados = $this->dashboardModel->resumoGeral();
            
            if (empty($dados)) {
                return null;
            }

            // Processa os dados para garantir tipos corretos
            return [
                'total_projetos' => (int) $dados['total_projetos'],
                'total_tarefas' => (int) $dados['total_tarefas'],
                'total_concluidas' => (int) $dados['total_concluidas'],
                'total_pendentes' => (int) $dados['total_pendentes'],
                'percentual_geral' => (float) $dados['percentual_geral']
            ];
        } catch (\Exception $e) {
            error_log("Erro ao obter resumo geral: " . $e->getMessage());
            return null;
        }
    }

    public function getDashboardCompleto() {
        try {
            $resumoGeral = $this->resumoGeral();
            $estatisticasPorProjeto = $this->estatisticasTarefasPorProjeto();

            return [
                'resumo_geral' => $resumoGeral,
                'projetos' => $estatisticasPorProjeto,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        } catch (\Exception $e) {
            error_log("Erro ao obter dashboard completo: " . $e->getMessage());
            return null;
        }
    }
}