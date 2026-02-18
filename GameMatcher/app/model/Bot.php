<?php
class Bot {
    private $apiKey = "d12a9754d101459685631ed6177bc24d";

    public function getResponse($message) {
        $messageLow = mb_strtolower(trim($message));
        $options = [];
        $gameLink = null;
        $response = "Ups, no entiendo eso. Pero puedo ayudarte con: 'top' o 'buscar [juego]'";

        if (str_contains($messageLow, "top") || str_contains($messageLow, "ranking")) {
            $hoy = date('Y-m-d');
            if (str_contains($messageLow, "semanal") || str_contains($messageLow, "semana")) {
                $inicio = date('Y-m-d', strtotime('-7 days'));
                $titulo = "Top de la Semana";
                $url = "https://api.rawg.io/api/games?key={$this->apiKey}&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } elseif (str_contains($messageLow, "mensual") || str_contains($messageLow, "mes")) {
                $inicio = date('Y-m-d', strtotime('-30 days'));
                $titulo = "Top del Mes";
                $url = "https://api.rawg.io/api/games?key={$this->apiKey}&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } else {
                $titulo = "Top Juegos de la Historia:";
                $url = "https://api.rawg.io/api/games?key={$this->apiKey}&ordering=-rating&page_size=3";
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
            }
        } else {
            $term = str_replace("buscar ", "", $messageLow);
            $urlSearch = "https://api.rawg.io/api/games?key={$this->apiKey}&search=" . urlencode($term) . "&page_size=5";
            $data = $this->callAPI($urlSearch);

            if ($data && !empty($data['results'])) {
                $firstGame = $data['results'][0];
                if (strtolower($firstGame['name']) == $term) {
                    $response = "**" . $firstGame['name'] . "**\nLanzamiento: " . ($firstGame['released'] ? substr($firstGame['released'], 0, 4) : 'N/A') . "\nValoración: " . ($firstGame['rating'] ?? 'S/N') . " / 5";
                    $gameLink = "juego.php?id=" . $firstGame['id']; 
                } else {
                    $response = "Encontré varios resultados...";
                    foreach ($data['results'] as $game) {
                        $options[] = ["name" => $game['name']];
                    }
                }
            }
        }
        return ["response" => $response, "options" => $options, "gameLink" => $gameLink];
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