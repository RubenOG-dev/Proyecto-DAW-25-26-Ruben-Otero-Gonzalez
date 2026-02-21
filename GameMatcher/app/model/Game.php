<?php
require_once __DIR__ . '/Conexion.php';

class Game {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
    }

    public function getTopRatedFromApi($cantidad = 6) {
        $api_key = RAWG_API_KEY; 
        $url = "https://api.rawg.io/api/games?key=$api_key&ordering=+rating&page_size=$cantidad";

        try {
            $ctx = stream_context_create(['http' => ['timeout' => 3]]); 
            $response = @file_get_contents($url, false, $ctx);
            
            if ($response === false) return [];

            $data = json_decode($response, true);
            return $data['results'] ?? [];
            
        } catch (Exception $e) {
            return [];
        }
    }
}