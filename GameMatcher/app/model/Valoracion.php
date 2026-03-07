<?php
class Valoracion
{
    private $db;

    public function __construct($pdoConexion = null)
    {
        if ($pdoConexion) {
            $this->db = $pdoConexion;
        } else {
            global $pdo;
            $this->db = $pdo;
        }
    }

    public function guardar($id_usuario, $rawg_game_id, $puntuacion, $comentario)
    {
        if (!$this->db) {
            global $pdo;
            $this->db = $pdo;
        }

        try {
            // 1. SOLUCIÓN AL ERROR: Insertamos el juego en la tabla JUEGO si no existe
            // Usamos INSERT IGNORE para que si ya existe no haga nada y no de error
            $sqlJuego = "INSERT IGNORE INTO JUEGO (rawg_game_id) VALUES (:id_g)";
            $stmtJuego = $this->db->prepare($sqlJuego);
            $stmtJuego->execute([':id_g' => $rawg_game_id]);

            // 2. Ahora que el juego existe sí o sí, hacemos el REPLACE de la valoración
            $sql = "REPLACE INTO VALORACION (id_usuario, rawg_game_id, puntuacion, comentario, data_valoracion) 
                    VALUES (:id_u, :id_g, :punt, :coment, NOW())";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id_u'    => $id_usuario,
                ':id_g'    => $rawg_game_id,
                ':punt'    => $puntuacion,
                ':coment'  => $comentario
            ]);
        } catch (PDOException $e) {
            // Ya sabemos que el error era la Foreign Key, esto lo soluciona
            return false;
        }
    }

    public function obtenerMedia($rawg_game_id)
    {
        if (!$this->db) {
            global $pdo;
            $this->db = $pdo;
        }
        
        try {
            $sql = "SELECT AVG(puntuacion) as media, COUNT(*) as total FROM VALORACION WHERE rawg_game_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $rawg_game_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['media' => 0, 'total' => 0];
        }
    }
}