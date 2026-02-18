<?php
// app/models/Game.php
require_once __DIR__ . './Conexion.php';

class Game {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
    }
    public function asegurarJuegoReferenciado($rawg_id, $nombre) {
        $sql = "SELECT rawg_game_id FROM JUEGO WHERE rawg_game_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $rawg_id]);

        if (!$stmt->fetch()) {
            // No existe, lo insertamos con los datos mínimos
            $insert = "INSERT INTO JUEGO (rawg_game_id, nome_game) VALUES (:id, :nome)";
            $stmtInsert = $this->db->prepare($insert);
            $stmtInsert->execute([
                ':id' => $rawg_id,
                ':nome' => $nombre
            ]);
        }
        return $rawg_id;
    }
}