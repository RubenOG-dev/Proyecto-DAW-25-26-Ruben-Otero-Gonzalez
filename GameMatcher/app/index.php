<?php
// index.php
require_once "app/globals.php";

// Incluimos los controladores necesarios
include_once CONTROLLER_PATH . "MainController.php";
include_once CONTROLLER_PATH . "GamesController.php";
include_once CONTROLLER_PATH . "BotController.php";

session_start();

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Obtenemos controlador y acción de la URL (ej: index.php?controller=Games&action=listarTop)
$controller = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : 'MainController';
$action = isset($_GET['action']) ? $_GET['action'] : 'principal';

try {
    if (class_exists($controller)) {
        $object = new $controller();
        if (method_exists($object, $action)) {
            $object->$action();
        } else {
            throw new Exception("Acción non encontrada");
        }
    } else {
        throw new Exception("Controlador non encontrado");
    }
} catch (Throwable $th) {
    // Si falla, cargamos el controlador por defecto
    $object = new MainController();
    $object->principal();
}