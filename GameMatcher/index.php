<?php
require_once "app/globals.php";

/* echo "<pre style='color: #00ff00; background: #000; padding: 10px; font-size: 12px; border: 2px solid green;'>";
echo "DEBUG RUTA: " . VIEW_PATH . "\n";
echo "ARCHIVO MOBILE EXISTE?: " . (file_exists(VIEW_PATH . "main_mobile.php") ? "SI ✅" : "NO ❌") . "\n";
echo "ARCHIVO DESKTOP EXISTE?: " . (file_exists(VIEW_PATH . "main_desktop.php") ? "SI ✅" : "NO ❌") . "\n";
echo "USER AGENT: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
echo "</pre>"; */

include_once CONTROLLER_PATH . "MainController.php";
include_once CONTROLLER_PATH . "GamesController.php";
include_once CONTROLLER_PATH . "BotController.php";

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$controller = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : 'MainController';
$action = isset($_GET['action']) ? $_GET['action'] : 'principal';

try {
    if (class_exists($controller)) {
        $object = new $controller();
        if (method_exists($object, $action)) {
            $object->$action();
        } else {
            throw new Exception("Acción no encontrada");
        }
    } else {
        throw new Exception("Controlador no encontrado");
    }
} catch (Throwable $th) {
    $object = new MainController();
    $object->principal();
}