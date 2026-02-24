<?php
class User {
    private $db;

    public function __construct() {
        global $pdo; 
        $this->db = $pdo;
    }

    public function registrar($nombre, $email, $password) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            // Ajustado a tus columnas: nombre, contrasenha, email, tipo_usuario, activo
            $sql = "INSERT INTO USUARIO (nombre, contrasenha, email, tipo_usuario, activo) 
                    VALUES (:nombre, :pass, :email, 'free', 1)";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':pass'   => $passwordHash,
                ':email'  => $email
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        // Buscamos por tu columna 'email'
        $sql = "SELECT * FROM USUARIO WHERE email = :email AND activo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos con tu columna 'contrasenha'
        if ($user && password_verify($password, $user['contrasenha'])) {
            unset($user['contrasenha']); // Seguridad
            return $user;
        }
        return false;
    }
}