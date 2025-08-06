<?php
namespace BrunaW\MinhaApi\Core;

class View {
    private string $view;
    private function __construct(string $output) {
        $this->view = $output;
    }

    public static function make(string $view, $data = []): View {
        extract($data);
        ob_start();

        $path = __DIR__ . "/../Views/{$view}.phtml";
        if (!file_exists($path)) {
            throw new \RuntimeException("View não encontrada: {$path}");
        }
        require $path;
        $output = ob_get_clean();
        if ($output === false) {
            throw new \RuntimeException("Falha ao capturar o buffer de saída.");
        }
        return new self($output);
    }

    public function __toString() {
        return $this->view;
    }
}