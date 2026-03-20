<?php
require_once MODEL_PATH . 'Valoracion.php';

class GamesController
{
    public function catalogo()
    {
        $page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '';
        $genres = isset($_GET['genres']) ? preg_replace('/[^0-9,]/', '', $_GET['genres']) : ''; // RAWG usa IDs numéricos separados por comas
        $platforms = isset($_GET['platforms']) ? preg_replace('/[^0-9,]/', '', $_GET['platforms']) : '';
        $ordering = isset($_GET['ordering']) ? preg_replace('/[^a-zA-Z0-9,-]/', '', $_GET['ordering']) : '';
        $dates = isset($_GET['dates']) ? preg_replace('/[^0-9,-]/', '', $_GET['dates']) : '';

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

        $gameId = isset($_GET['id']) ? preg_replace('/[^0-9a-zA-Z_-]/', '', $_GET['id']) : null;

        $url = "https://api.rawg.io/api/games/{$gameId}?key=" . RAWG_API_KEY . "&lang=es";
        $json = $this->peticionApi($url);
        $gameData = json_decode($json, true);

        if (isset($gameData['detail']) && $gameData['detail'] === "Not found.") {
            die("Error: El juego no existe.");
        }

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

        $urlScreenshots = "https://api.rawg.io/api/games/{$gameId}/screenshots?key=" . RAWG_API_KEY;
        $jsonScreenshots = $this->peticionApi($urlScreenshots);
        $screenshotsData = json_decode($jsonScreenshots, true);
        $screenshots = $screenshotsData['results'] ?? [];

        $background = $gameData['background_image'] ?? '';
        $screenshotUrls = array_column($screenshots, 'image');

        $allImages = array_values(array_filter(array_merge([$background], $screenshotUrls)));
        $gameData['all_images'] = $allImages;

        $valModel = new Valoracion();
        $resumenBD = $valModel->obtenerMedia($gameId);

        $gameData['rating_comunidad'] = $resumenBD['media'] ? round($resumenBD['media'], 1) : null;
        $gameData['total_votos'] = $resumenBD['total'] ?? 0;

        include_once VIEW_PATH . "game_detail.php";
    }

    private function peticionApi($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'GameMatcherApp/1.0');
        $res = curl_exec($ch);
        return $res;
    }

    public function guardarValoracion()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?controller=User&action=mostrarAuth");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once MODEL_PATH . 'Valoracion.php';

            $valModel = new Valoracion();
            $id_usuario = $_SESSION['id_usuario'];
            $game_id = isset($_POST['game_id']) ? preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['game_id']) : null;
            $puntos = isset($_POST['puntuacion']) ? (int)$_POST['puntuacion'] : 0;
            $comentario = !empty($_POST['comentario']) ? htmlspecialchars(trim($_POST['comentario']), ENT_QUOTES, 'UTF-8') : null;

            if (!$game_id || $puntos < 1 || $puntos > 5 ) {
                header("Location: index.php?controller=Games&action=catalogo");
                exit;
            }

            $res = $valModel->guardar($id_usuario, $game_id, $puntos, $comentario);

            $redireccion = "index.php?controller=Games&action=detalle&id=" . $game_id;

            if ($res) {
                header("Location: " . $redireccion . "&success=1");
            } else {
                header("Location: " . $redireccion . "&error=1");
            }
            exit;
        }
    }
}
