<?php
class MainController {
    public function principal() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['id_usuario'])) {
            header("Location: index.php?controller=User&action=mostrarMain");
            exit;
        }

        include_once VIEW_PATH . 'landing.php';
    }

    public function error() {
        echo "404 - Página no encontrada";
    }
}