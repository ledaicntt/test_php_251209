<?php

class ApiService {
    private $base;

    public function __construct() {
        $config = include __DIR__ . "/../../config/app.php";
        $this->base = $config["api_base"];
    }

    private function post($path, $data) {
        $url = $this->base . $path;

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }

    public function normalize($text) {
        return $this->post("/normalize", ["text" => $text]);
    }

    public function search($query) {
        return $this->post("/search", ["query" => $query]);
    }

    public function aiSelect($query, $normalized, $candidates) {
        return $this->post("/ai/select", [
            "query" => $query,
            "normalized" => $normalized,
            "candidates" => $candidates
        ]);
    }

    public function aiAnswer($service_id) {
        return $this->post("/ai/answer", ["service_id" => $service_id]);
    }
}
