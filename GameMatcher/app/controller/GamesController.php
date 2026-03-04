<?php

class GamesController
{

    public function catalogo()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $genres = isset($_GET['genres']) ? $_GET['genres'] : '';
        $platforms = isset($_GET['platforms']) ? $_GET['platforms'] : '';
        $ordering = isset($_GET['ordering']) ? $_GET['ordering'] : '';
        $dates = isset($_GET['dates']) ? $_GET['dates'] : '';

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

    public function listarTop()
    {
        header('Content-Type: application/json');
        $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&ordering=-added&page_size=40";

        echo $this->peticionApi($url);
    }

    public function detalle()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php");
            exit;
        }

        $gameId = $_GET['id'];

        $url = "https://api.rawg.io/api/games/{$gameId}?key=" . RAWG_API_KEY;
        $json = $this->peticionApi($url);
        $gameData = json_decode($json, true);

        if (isset($gameData['detail']) && $gameData['detail'] === "Not found.") {
            die("Erro: O xogo non existe.");
        }

        include_once VIEW_PATH . "game_detail.php";
    }

    private function peticionApi($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherApp/1.0');
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherApp/1.0');
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
