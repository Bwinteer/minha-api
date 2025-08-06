<?php
namespace BrunaW\MinhaApi\Core;

class Json {
    private string $json;
    private function __construct(string $output) {
        $this->json = $output;
    }

    public static function make($data = [], int $status = 200): Json {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        http_response_code($status);
        return new self(json_encode($data));
    }

    public function __toString() {
        return $this->json;
    }
}