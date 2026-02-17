<?php
/*=============================================
=            LOGICA DEL BOT ACTUALIZADA       =
=============================================*/
header('Content-Type: application/json');

$apiKey = "d12a9754d101459685631ed6177bc24d";
$input = json_decode(file_get_contents("php://input"), true);
$message = $input['message'] ?? '';
$messageLow = mb_strtolower(trim($message));

$response = "Ups, no entiendo eso. Pero puedo ayudarte con lo siguiente: 'top' o 'buscar [juego]'";
$options = [];

// 1. Lógica de TOP
if (str_contains($messageLow, "top")) {
    $url = "https://api.rawg.io/api/games?key=$apiKey&ordering=-rating&page_size=3";
    $data = callAPI($url);

    if ($data && isset($data['results'])) {
        $response = "🏆 **Top Juegos según RAWG:**\n";
        foreach ($data['results'] as $index => $game) {
            $name = $game['name'];
            $rating = $game['rating'] ?? 'N/A';
            $year = substr($game['released'], 0, 4);
            $response .= ($index + 1) . ". $name ($year) - ⭐ $rating\n";
        }
    } else {
        $response = "⚠️ No pude conectar con la API de RAWG.";
    }
} 

// 2. Lógica de BÚSQUEDA / SELECCIÓN
else {
    $term = str_replace("buscar ", "", $messageLow);
    
    // Primero buscamos coincidencia exacta por nombre
    $urlSearch = "https://api.rawg.io/api/games?key=$apiKey&search=" . urlencode($term) . "&page_size=5";
    $data = callAPI($urlSearch);

    if ($data && !empty($data['results'])) {
        $firstGame = $data['results'][0];
        
        // Si el nombre es exactamente igual al buscado, damos la info directa
        if (strtolower($firstGame['name']) == $term) {
            $response = "🎮 **Ficha Técnica:**\n";
            $response .= "Nombre: " . $firstGame['name'] . "\n";
            $response .= "Lanzamiento: " . ($firstGame['released'] ?? 'N/A') . "\n";
            $response .= "Rating: " . ($firstGame['rating'] ?? 'S/N') . " / 5";
        } else {
            // Si hay varios parecidos, mandamos la lista para que el JS haga botones
            $response = "Atopei varios xogos con ese nome...";
            foreach ($data['results'] as $game) {
                $options[] = ["name" => $game['name']];
            }
        }
    } else {
        if (str_contains($messageLow, "buscar")) {
            $response = "🔍 No encontré ningún juego que se llame así.";
        }
    }
}

echo json_encode(["response" => $response, "options" => $options]);

function callAPI($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MiBotDeJuegos/1.0'); 
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}
?>