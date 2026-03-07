<?php
class User
{
    private $db;

    public function __construct($pdoConexion = null)
    {
        if ($pdoConexion) {
            $this->db = $pdoConexion;
        } else {
            global $pdo;
            if (!$pdo) {
                throw new Exception("La conexión a la base de datos no está disponible", 1);
            }
            $this->db = $pdo;
        }
    }

    public function registrar($nombre, $email, $password)
    {
        try {
            $checkSql = "SELECT id_usuario FROM USUARIO WHERE email = :email";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':email' => $email]);
            if ($checkStmt->fetch()) {
                return false;
            }

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO USUARIO (nombre, contrasenha, email, tipo_usuario, activo) 
                VALUES (:nombre, :pass, :email, 'free', 1)";

            $stmt = $this->db->prepare($sql);
            $res = $stmt->execute([
                ':nombre' => $nombre,
                ':pass'   => $passwordHash,
                ':email'  => $email
            ]);

            if ($res) {
                return $this->db->lastInsertId();
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password)
    {
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

    public function registrarSesionBD($id_usuario)
    {
        $token = bin2hex(random_bytes(16));
        $sql = "INSERT INTO SESION (id_usuario, token, data_inicio) VALUES (:id, :token, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id_usuario, 'token' => $token]);
    }

    public function cerrarSesionBD($id_usuario)
    {
        $sql = "UPDATE SESION SET data_fin = NOW() WHERE id_usuario = :id AND data_fin IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id_usuario]);
    }

    public function hacerPremium($id_usuario)
    {
        try {
            $sql = "UPDATE USUARIO SET tipo_usuario = 'premium' WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id_usuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
