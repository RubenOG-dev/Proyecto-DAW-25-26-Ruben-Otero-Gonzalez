<?php
require_once "app/globals.php";

include_once CONTROLLER_PATH . "MainController.php";
include_once CONTROLLER_PATH . "GamesController.php";
include_once CONTROLLER_PATH . "BotController.php";
include_once CONTROLLER_PATH . "UserController.php";

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$controllerName = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : 'MainController';
$action = isset($_GET['action']) ? $_GET['action'] : 'principal';

try {
    if (class_exists($controllerName)) {
        $object = new $controllerName();
        if (method_exists($object, $action)) {
            $object->$action();
        } else {
            throw new Exception("Acción no encontrada");
        }
    } else {
        throw new Exception("Controlador no encontrado: " . $controllerName);
    }
} catch (Throwable $th) {
    $object = new MainController();
    $object->principal();
}