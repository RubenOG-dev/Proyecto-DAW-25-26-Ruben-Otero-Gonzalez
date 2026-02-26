<?php
include_once("../globals.php");
class Conexion {
    public function conectar() {
        try {
            $pdo = new PDO(DSN,USER,PASS);
            return $pdo;
        } catch (PDOException $e) {
            die("Error crítico: " . $e->getMessage());
        }
    }
}