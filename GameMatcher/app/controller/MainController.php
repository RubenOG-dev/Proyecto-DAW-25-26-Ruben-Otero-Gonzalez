<?php

class MainController {
    
    public function principal() {
        include_once VIEW_PATH . "main_home.php"; 
    }

    public function error() {
        echo "404 - Página non atopada";
    }
}