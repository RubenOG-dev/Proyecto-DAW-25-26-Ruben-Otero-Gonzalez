<?php
require_once MODEL_PATH . 'Game.php';

class MainController {
    
    public function principal() {
        /* $isMobile = $this->checkDevice();
        $gameModel = new Game();
        $mejoresJuegos = $gameModel->getTopRatedFromApi(6);
        $view = $isMobile ? "landing_mobile.php" : "landing_desktop.php"; 
        include_once VIEW_PATH . $view;*/
        include_once VIEW_PATH . 'landing.php';
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