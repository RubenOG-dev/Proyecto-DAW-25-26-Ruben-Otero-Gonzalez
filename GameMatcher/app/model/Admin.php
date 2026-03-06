<?php
require_once __DIR__ . '/Conexion.php';

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conectar();
    }

    public function getEstadisticas()
    {
        return [
            'total_usuarios' => $this->db->query("SELECT COUNT(*) FROM USUARIO")->fetchColumn(),
            'total_posts'    => $this->db->query("SELECT COUNT(*) FROM POST")->fetchColumn(),
            'total_foros'    => $this->db->query("SELECT COUNT(*) FROM FORO")->fetchColumn()
        ];
    }

    public function getAllUsuarios()
    {
        return $this->db->query("SELECT id_usuario, nombre, email, tipo_usuario FROM USUARIO ORDER BY id_usuario DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllForosAdmin()
    {
        return $this->db->query("SELECT * FROM FORO ORDER BY tipo_entidad ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUltimosPostsGlobales($limite = 10)
    {
        $sql = "SELECT p.*, u.nombre as autor, f.titulo as nombre_foro 
            FROM POST p 
            JOIN USUARIO u ON p.id_usuario = u.id_usuario 
            JOIN FORO f ON p.id_foro = f.id_foro
            ORDER BY p.data_publicacion DESC LIMIT " . (int)$limite;
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarUsuario($id)
    {
        $stmt = $this->db->prepare("DELETE FROM USUARIO WHERE id_usuario = ? AND tipo_usuario != 'admin'");
        return $stmt->execute([$id]);
    }

    public function eliminarPost($id)
    {
        $this->db->prepare("DELETE FROM COMENTARIO WHERE id_post = ?")->execute([$id]);
        return $this->db->prepare("DELETE FROM POST WHERE id_post = ?")->execute([$id]);
    }

    public function eliminarComentario($id)
    {
        return $this->db->prepare("DELETE FROM COMENTARIO WHERE id_comentario = ?")->execute([$id]);
    }

    public function getAllComentarios($limite = 20)
    {
        $sql = "SELECT c.*, u.nombre as autor, p.titulo as post_titulo 
            FROM COMENTARIO c
            JOIN USUARIO u ON c.id_usuario = u.id_usuario
            JOIN POST p ON c.id_post = p.id_post
            ORDER BY c.data_publicacion DESC LIMIT " . (int)$limite;
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
