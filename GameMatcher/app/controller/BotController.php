<?php
class BotController {
    public function responder() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);
        $message = $input['message'] ?? '';
        $messageLow = mb_strtolower(trim($message));

        $response = "Ups, no entiendo eso. Pero puedo ayudarte con lo siguiente: 'top' o 'buscar [juego]'";
        $options = [];
        $gameLink = null;

        if (str_contains($messageLow, "top") || str_contains($messageLow, "ranking")) {
            $hoy = date('Y-m-d');
            if (str_contains($messageLow, "semanal") || str_contains($messageLow, "semana")) {
                $inicio = date('Y-m-d', strtotime('-7 days'));
                $titulo = "Top de la Semana";
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } elseif (str_contains($messageLow, "mensual") || str_contains($messageLow, "mes")) {
                $inicio = date('Y-m-d', strtotime('-30 days'));
                $titulo = "Top del Mes";
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } else {
                $titulo = " Top Juegos de la Historia:";
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&ordering=-rating&page_size=3";
            }

            $data = $this->callAPI($url);
            if ($data && isset($data['results'])) {
                $response = "**$titulo**\n";
                foreach ($data['results'] as $index => $game) {
                    $name = $game['name'];
                    $rating = $game['rating'] ?? 'N/A';
                    $year = $game['released'] ? substr($game['released'], 0, 4) : 'N/A';
                    $response .= ($index + 1) . ". $name ($year) - ⭐ $rating\n";
                }
            } else {
                $response = " No pude conectar con la API de RAWG.";
            }
        } 
        else {
            $term = str_replace("buscar ", "", $messageLow);
            $urlSearch = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&search=" . urlencode($term) . "&page_size=5";
            $data = $this->callAPI($urlSearch);

            if ($data && !empty($data['results'])) {
                $firstGame = $data['results'][0];
                if (strtolower($firstGame['name']) == $term) {
                    $response = " **" . $firstGame['name'] . "**\n";
                    $response .= " Fecha de Lanzamiento: " . ($firstGame['released'] ? substr($firstGame['released'], 0, 4) : 'N/A') . "\n";
                    $response .= " Valoración: " . ($firstGame['rating'] ?? 'S/N') . " / 5";
                    $gameLink = "index.php?controller=Games&action=detalle&id=" . $firstGame['id']; 
                } else {
                    $response = "Encontré varios resultados con ese nombre...";
                    foreach ($data['results'] as $game) {
                        $options[] = ["name" => $game['name']];
                    }
                }
            } else {
                if (str_contains($messageLow, "buscar")) {
                    $response = " No encontré ningún juego que se llame así.";
                }
            }
        }

        echo json_encode([
            "response" => $response, 
            "options" => $options, 
            "gameLink" => $gameLink
        ]);
    }

    private function callAPI($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherBot/1.0'); 
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
}