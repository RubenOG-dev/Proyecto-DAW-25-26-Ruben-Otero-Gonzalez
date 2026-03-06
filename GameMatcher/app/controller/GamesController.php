<?php

class GamesController
{
    /* --- Catálogo General de Juegos --- */
    public function catalogo()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = $_GET['search'] ?? '';
        $genres = $_GET['genres'] ?? '';
        $platforms = $_GET['platforms'] ?? '';
        $ordering = $_GET['ordering'] ?? '';
        $dates = $_GET['dates'] ?? '';

        $pageSize = 40;
        $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&page={$page}&page_size={$pageSize}";

        if ($search !== '') $url .= "&search=" . urlencode($search);
        if ($genres !== '') $url .= "&genres=" . $genres;
        if ($platforms !== '') $url .= "&platforms=" . $platforms;
        if ($ordering !== '') $url .= "&ordering=" . $ordering;
        if ($dates !== '') $url .= "&dates=" . $dates;

        $json = $this->peticionApi($url);

        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo $json;
            exit;
        }

        $data = json_decode($json, true);
        $games = $data['results'] ?? [];
        $nextPage = $page + 1;
        $prevPage = ($page > 1) ? $page - 1 : null;

        include_once VIEW_PATH . "catalogo.php";
    }

    /* --- API: Listado de los más populares --- */
    public function listarTop()
    {
        header('Content-Type: application/json');
        $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&ordering=-added&page_size=40";
        echo $this->peticionApi($url);
    }

    /* --- Ficha Detallada del Juego --- */
    public function detalle()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php");
            exit;
        }

        $gameId = $_GET['id'];

        $url = "https://api.rawg.io/api/games/{$gameId}?key=" . RAWG_API_KEY . "&lang=es";
        $json = $this->peticionApi($url);
        $gameData = json_decode($json, true);

        if (isset($gameData['detail']) && $gameData['detail'] === "Not found.") {
            die("Error: El juego no existe.");
        }

        /* Procesamiento de descripción y selección de idioma */
        $textoOriginal = $gameData['description'] ?? '';
        $resultado = '';

        if (stripos($textoOriginal, 'Español') !== false) {
            $partes = preg_split('/Español/i', $textoOriginal);
            $resultado = end($partes);
        } elseif (stripos($textoOriginal, 'Spanish') !== false) {
            $partes = preg_split('/Spanish/i', $textoOriginal);
            $resultado = end($partes);
        } else {
            $resultado = $textoOriginal;
        }

        $gameData['description_limpia'] = trim(strip_tags($resultado));

        if (empty($gameData['description_limpia'])) {
            $gameData['description_limpia'] = trim(strip_tags($textoOriginal));
        }

        /* Obtención de capturas de pantalla */
        $urlScreenshots = "https://api.rawg.io/api/games/{$gameId}/screenshots?key=" . RAWG_API_KEY;
        $jsonScreenshots = $this->peticionApi($urlScreenshots);
        $screenshotsData = json_decode($jsonScreenshots, true);
        $screenshots = $screenshotsData['results'] ?? [];

        $background = $gameData['background_image'] ?? '';
        $screenshotUrls = array_column($screenshots, 'image');

        /* Preparación de galería multimedia */
        $allImages = array_values(array_filter(array_merge([$background], $screenshotUrls)));
        $gameData['all_images'] = $allImages;

        include_once VIEW_PATH . "game_detail.php";
    }

    /* --- Helper: Petición cURL --- */
    private function peticionApi($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherApp/1.0');
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}