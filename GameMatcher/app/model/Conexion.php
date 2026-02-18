<?php
class Conexion {
    public function conectar() {
        try {
            return new PDO(DSN, USER, PASS);
        } catch (PDOException $e) {
            die("Error crítico: " . $e->getMessage());
        }
    }
}