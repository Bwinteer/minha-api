<?php
namespace BrunaW\MinhaApi\Models;

use BrunaW\MinhaApi\Config\Database;
use PDO;

class DashboardModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function estatisticasTarefasPorProjeto() {
        $query = "SELECT 
                    p.id as projeto_id,
                    p.nome as projeto_nome,
                    p.descricao as projeto_descricao,
                    COUNT(t.id) as total_tarefas,
                    SUM(CASE WHEN t.status = 'Concluído' THEN 1 ELSE 0 END) as tarefas_concluidas,
                    SUM(CASE WHEN t.status IN ('Pendente', 'Em andamento') OR t.status IS NULL THEN 1 ELSE 0 END) as tarefas_pendentes,
                    ROUND(
                        (SUM(CASE WHEN t.status = 'Concluído' THEN 1 ELSE 0 END) * 100.0 / 
                        NULLIF(COUNT(t.id), 0)), 2
                    ) as percentual_conclusao
                  FROM projetos p
                  LEFT JOIN tarefas t ON p.id = t.projeto_id
                  GROUP BY p.id, p.nome, p.descricao
                  HAVING COUNT(t.id) > 0
                  ORDER BY p.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resumoGeral() {
        $query = "SELECT 
                    COUNT(DISTINCT p.id) as total_projetos,
                    COUNT(t.id) as total_tarefas,
                    SUM(CASE WHEN t.status = 'Concluído' THEN 1 ELSE 0 END) as total_concluidas,
                    SUM(CASE WHEN t.status IN ('Pendente', 'Em andamento') OR t.status IS NULL THEN 1 ELSE 0 END) as total_pendentes,
                    ROUND(
                        (SUM(CASE WHEN t.status = 'Concluído' THEN 1 ELSE 0 END) * 100.0 / 
                        NULLIF(COUNT(t.id), 0)), 2
                    ) as percentual_geral
                  FROM projetos p
                  LEFT JOIN tarefas t ON p.id = t.projeto_id
                  WHERE t.id IS NOT NULL";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProjetosSemTarefas() {
        $query = "SELECT 
                    p.id as projeto_id,
                    p.nome as projeto_nome,
                    p.descricao as projeto_descricao
                  FROM projetos p
                  LEFT JOIN tarefas t ON p.id = t.projeto_id
                  WHERE t.id IS NULL
                  ORDER BY p.nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}