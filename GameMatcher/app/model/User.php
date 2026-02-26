<?php
class User {
    private $db;

    public function __construct($pdoConexion = null) {
        if ($pdoConexion) {
            $this->db = $pdoConexion;
        }else{
            global $pdo;
            if (!$pdo) {
                throw new Exception("La conexión a la base de datos no está disponible", 1);
                
            }
            $this->db=$pdo;
        }
    }

    public function registrar($nombre, $email, $password) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO USUARIO (nombre, contrasenha, email, tipo_usuario, activo) 
                    VALUES (:nombre, :pass, :email, 'free', 1)";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':pass'   => $passwordHash,
                ':email'  => $email
            ]);
        } catch (PDOException $e) {
            // Opcional: registrar error en log
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM USUARIO WHERE email = :email AND activo = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['contrasenha'])) {
                unset($user['contrasenha']);
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}