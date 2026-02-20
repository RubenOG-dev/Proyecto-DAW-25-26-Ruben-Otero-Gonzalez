<?php
class Bot {
    public function getResponse($message) {
        $messageLow = mb_strtolower(trim($message));
        $options = [];
        $gameLink = null;
        $rating = null;
        $added = null;
        $categories = null;
        $response = "Ups, no entiendo eso. Prueba con: 'top semana' o 'buscar [juego]'";

        if (str_contains($messageLow, "top") || str_contains($messageLow, "ranking")) {
            $hoy = date('Y-m-d');
            if (str_contains($messageLow, "semanal") || str_contains($messageLow, "semana")) {
                $inicio = date('Y-m-d', strtotime('-7 days'));
                $titulo = "TOP SEMANAL"; 
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } elseif (str_contains($messageLow, "mensual") || str_contains($messageLow, "mes")) {
                $inicio = date('Y-m-d', strtotime('-30 days'));
                $titulo = "TOP MENSUAL";
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&dates=$inicio,$hoy&ordering=-added&page_size=3";
            } else {
                $titulo = "TOP HISTÓRICO";
                $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&ordering=-rating&page_size=3";
            }

            $data = $this->callAPI($url);
            if ($data && isset($data['results'])) {
                $response = "<div style='text-align:center; font-weight:bold; margin-bottom:10px; color:#a685ff; border-bottom:1px solid #444;'>$titulo</div>";
                
                foreach ($data['results'] as $index => $game) {
                    $gName = $game['name'];
                    $gRating = $game['rating'] ?? '0';
                    $year = $game['released'] ? substr($game['released'], 0, 4) : 'N/A';
                    
                    $response .= "<table style='width:100%; border-collapse:collapse; margin-bottom:12px;'>";
                    $response .= "<tr><td style='font-weight:bold; color:#fff;'>" . ($index + 1) . ". $gName</td></tr>";
                    $response .= "<tr><td style='font-size:0.85em; color:#bbb; padding-left:15px;'>🗓️ Año: $year</td></tr>";
                    $response .= "<tr><td style='font-size:0.85em; color:#bbb; padding-left:15px;'>⭐ Rating: $gRating / 5</td></tr>";
                    $response .= "</table>";
                }
            }
        } 
        else {
            $term = str_replace("buscar ", "", $messageLow);
            $urlSearch = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&search=" . urlencode($term) . "&page_size=5";
            $data = $this->callAPI($urlSearch);

            if ($data && !empty($data['results'])) {
                $game = $data['results'][0]; 
                $rating = $game['rating'] ?? '0';
                $addedVal = $game['added'] ?? 0;
                $added = number_format($addedVal, 0, ',', '.');
                $categories = !empty($game['genres']) ? implode(", ", array_column($game['genres'], 'name')) : "General";
                $gameLink = "index.php?controller=Games&action=detalle&id=" . $game['id'];

                $response = "¿Es **" . $game['name'] . "** el juego que buscas?";
                
                foreach ($data['results'] as $g) {
                    $options[] = ["name" => $g['name']];
                }

                return [
                    "response" => $response, 
                    "options" => $options, 
                    "rawResults" => $data['results'],
                    "gameName" => $game['name'],
                    "gameLink" => $gameLink,
                    "rating" => $rating,
                    "added" => $addedVal,
                    "categories" => $categories
                ];
            } else if (str_contains($messageLow, "buscar")) {
                $response = "No encontré ningún juego que se llame así.";
            }
        }

        return [
            "response" => $response, 
            "options" => $options, 
            "gameLink" => $gameLink,
            "rating" => $rating,
            "added" => $added,
            "categories" => $categories
        ];
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