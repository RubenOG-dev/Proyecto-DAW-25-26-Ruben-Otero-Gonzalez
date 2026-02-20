<?php
// dirname(__DIR__) detecta la carpeta real donde está tu proyecto en el disco duro del servidor
define("BASE_PATH", dirname(__DIR__) . "/"); 

define("DSN", "mysql:host=mysql-8001.dinaserver.com;dbname=rial_campechano;charset=utf8mb4");
define("USER", "rial_campechano");
define("PASS", "BbCoCh19011938.$");

define("MODEL_PATH", BASE_PATH . "app/model/");
define("CONTROLLER_PATH", BASE_PATH . "app/controller/");
define("VIEW_PATH", BASE_PATH . "app/view/");

// Estas rutas son para el HTML (browser), mejor dejarlas relativas
define("IMG_PATH", "assets/img/");
define("CSS_PATH", "assets/css/");

define("RAWG_API_KEY", "d12a9754d101459685631ed6177bc24d");