<?php
namespace BrunaW\MinhaApi\Services;

use BrunaW\MinhaApi\Config\Database;
use BrunaW\MinhaApi\Models\UsuarioModel;
use PDO;

class UsuarioService {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new UsuarioModel($this->db);
    }

    public function listarTodos() {
        $stmt = $this->usuario->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $usuarios_arr = array();
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario_item = [
                    "id" => $row['id'],
                    "nome" => $row['nome'],
                    "email" => $row['email'],
                    "telefone" => $row['telefone'],
                    "created_at" => $row['created_at']
                ];
                
                array_push($usuarios_arr, $usuario_item);
            }

            return $usuarios_arr;
        } else {
            return null;
        }
    }

    public function buscarPorId($id) {
        $this->usuario->id = $id;

        if($this->usuario->readOne()) {
            return [
                "id" => $this->usuario->id,
                "nome" => $this->usuario->nome,
                "email" => $this->usuario->email,
                "telefone" => $this->usuario->telefone,
                "created_at" => $this->usuario->created_at
            ];
        } else {
            return null;
        }
    }

    public function criar($dados) {
        if(!empty($dados->nome) && !empty($dados->email)) {
            $this->usuario->nome = $dados->nome;
            $this->usuario->email = $dados->email;
            $this->usuario->telefone = isset($dados->telefone) ? $dados->telefone : "";

            if($this->usuario->create()) {
                return [
                    "sucesso" => true,
                    "id" => $this->usuario->id,
                    "message" => "Usuário criado com sucesso"
                ];
            } else {
                return [
                    "sucesso" => false,
                    "message" => "Erro ao criar usuário"
                ];
            }
        } else {
            return [
                "sucesso" => false,
                "message" => "Nome e email são obrigatórios"
            ];
        }
    }

    public function atualizar($id, $dados) {
        $this->usuario->id = $id;

        // Primeiro verifica se o usuário existe
        if($this->usuario->readOne()) {
            // Atualiza apenas os campos enviados
            $this->usuario->nome = isset($dados->nome) ? $dados->nome : $this->usuario->nome;
            $this->usuario->email = isset($dados->email) ? $dados->email : $this->usuario->email;
            $this->usuario->telefone = isset($dados->telefone) ? $dados->telefone : $this->usuario->telefone;

            if($this->usuario->update()) {
                return [
                    "sucesso" => true,
                    "message" => "Usuário atualizado com sucesso"
                ];
            } else {
                return [
                    "sucesso" => false,
                    "message" => "Erro ao atualizar usuário"
                ];
            }
        } else {
            return [
                "sucesso" => false,
                "message" => "Usuário não encontrado"
            ];
        }
    }

    public function deletar($id) {
        $this->usuario->id = $id;

        if($this->usuario->readOne()) {
            if($this->usuario->delete()) {
                return [
                    "sucesso" => true,
                    "message" => "Usuário deletado com sucesso"
                ];
            } else {
                return [
                    "sucesso" => false,
                    "message" => "Erro ao deletar usuário"
                ];
            }
        } else {
            return [
                "sucesso" => false,
                "message" => "Usuário não encontrado"
            ];
        }
    }
}
?>