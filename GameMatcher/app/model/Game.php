<?php
require_once __DIR__ . '/Conexion.php';

class Game {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
    }

    /**
     * Obtiene los juegos en tendencia de la API.
     * @param int $cantidad Número de juegos a recuperar (ahora 40)
     */
    public function getTopRatedFromApi($cantidad = 20) {
        $api_key = RAWG_API_KEY; 
        
        // -added es el estándar de RAWG para "Popularidad/Tendencia"
        $url = "https://api.rawg.io/api/games?key=$api_key&ordering=-added&page_size=$cantidad";

        try {
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'header' => "User-Agent: GameMatcherApp/1.0\r\n"
                ]
            ]); 
            
            $response = @file_get_contents($url, false, $ctx);
            
            if ($response === false) return [];

            $data = json_decode($response, true);
            return $data['results'] ?? [];
            
        } catch (Exception $e) {
            return [];
        }
    }
}