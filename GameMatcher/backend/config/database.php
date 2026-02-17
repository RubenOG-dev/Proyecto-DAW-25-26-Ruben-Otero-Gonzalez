<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
    
$host = 'mysql-8001.dinaserver.com';
$db   = 'rial_campechano';
$user = 'rial_campechano';
$pass = 'BbCoCh19011938.$';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    echo "Fallo na conexión: " . $e->getMessage();
}
?>