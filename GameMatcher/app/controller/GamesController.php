<?php

class GamesController {

    public function listarTop() {
        header('Content-Type: application/json');
        
        $hoy = date('Y-m-d');
        $inicio = date('Y-m-d', strtotime('-30 days'));
        
        $url = "https://api.rawg.io/api/games?key=" . RAWG_API_KEY . "&dates=$inicio,$hoy&ordering=-metacritic&page_size=6";

        echo $this->peticionApi($url);
    }

    public function detalle() {
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

    private function peticionApi($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherApp/1.0'); 
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}