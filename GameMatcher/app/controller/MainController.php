<?php
require_once MODEL_PATH . 'Game.php';

class MainController {
    
    public function principal() {
        // 1. Detección de dispositivo
        $isMobile = $this->checkDevice();

        // 2. Lógica de Negocio: Pedir datos al Modelo
        $gameModel = new Game();
        $mejoresJuegos = $gameModel->getTopRatedFromApi(6);

        // 3. Carga de vistas
        $view = $isMobile ? "main_mobile.php" : "main_desktop.php";
        include_once VIEW_PATH . $view;
    }

    /**
     * Helper interno para detectar si es móvil
     */
    private function checkDevice() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry', 'Opera Mini', 'IEMobile'];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) return true;
        }
        return false;
    }

    public function error() {
        echo "404 - Página non atopada";
    }
}