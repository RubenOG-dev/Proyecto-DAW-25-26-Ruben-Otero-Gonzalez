<?php
require_once __DIR__ . '/Conexion.php';

class Foro
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conectar();
    }

    public function getForoById($id)
    {
        $sql = "SELECT * FROM FORO WHERE id_foro = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerOCrearForoJuego($game_id, $game_name)
    {
        $sql = "SELECT id_foro FROM FORO WHERE tipo_entidad = 'juego' AND relacion_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$game_id]);
        $foro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($foro) return $foro['id_foro'];

        $sql_ins = "INSERT INTO FORO (titulo, descripcion, tipo_entidad, relacion_id, data_creacion) 
                    VALUES (?, ?, 'juego', ?, NOW())";
        $this->db->prepare($sql_ins)->execute(["Foro de $game_name", "Comunidad de $game_name", $game_id]);

        return $this->db->lastInsertId();
    }

    public function obtenerOCrearForoCategoria($categoria_nombre)
    {
        $sql = "SELECT id_foro FROM FORO WHERE tipo_entidad = 'categoria' AND titulo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoria_nombre]);
        $foro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($foro) return $foro['id_foro'];

        $sql_ins = "INSERT INTO FORO (titulo, descripcion, tipo_entidad, data_creacion) 
                    VALUES (?, ?, 'categoria', NOW())";
        $this->db->prepare($sql_ins)->execute([$categoria_nombre, "Foro de la categoría $categoria_nombre"]);
        $nuevo_id = $this->db->lastInsertId();

        $this->db->prepare("INSERT INTO POST (id_foro, id_usuario, titulo, contido, data_publicacion) VALUES (?, 1, 'Hilo General', 'Bienvenidos', NOW())")
            ->execute([$nuevo_id]);

        return $nuevo_id;
    }

    // --- CORRECCIÓN DE LA ESTRUCTURA DE MENSAJES ---
    public function getMensajesEstructurados($id_foro)
    {
        $sql = "SELECT p.id_post, p.id_usuario, p.contido as contenido, u.nombre, p.data_publicacion as fecha 
        FROM POST p 
        JOIN USUARIO u ON p.id_usuario = u.id_usuario 
        WHERE p.id_foro = ? 
        ORDER BY p.data_publicacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_foro]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($posts as &$post) {
            // Usamos AS id_post para que el front-end no se rompa al buscar el ID
            $sql_comentarios = "SELECT c.id_comentario AS id_post, c.id_usuario, c.contenido, u.nombre, c.data_publicacion as fecha 
                        FROM COMENTARIO c 
                        JOIN USUARIO u ON c.id_usuario = u.id_usuario 
                        WHERE c.id_post = ?
                        ORDER BY c.data_publicacion ASC";
            $stmt_com = $this->db->prepare($sql_comentarios);
            $stmt_com->execute([$post['id_post']]);
            $post['respuestas'] = $stmt_com->fetchAll(PDO::FETCH_ASSOC);
        }

        return $posts;
    }

    public function crearPostPrincipal($id_foro, $id_usuario, $contenido, $titulo)
    {
        $sql = "INSERT INTO POST (id_foro, id_usuario, titulo, contido, data_publicacion) 
            VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_foro, $id_usuario, $titulo, $contenido]);
        return $this->db->lastInsertId();
    }

    public function crearComentario($id_post, $id_usuario, $contenido)
    {
        $sql = "INSERT INTO COMENTARIO (id_post, id_usuario, contenido, data_publicacion) 
            VALUES (?, ?, ?, NOW())";
        return $this->db->prepare($sql)->execute([$id_post, $id_usuario, $contenido]);
    }

    // --- FUNCIONES MEJORADAS PARA EDITAR Y BORRAR (Dual Post/Comentario) ---

    public function eliminarPost($id)
    {
        // Obtenemos el usuario de la sesión para seguridad (esto se valida en el controlador)
        // Intentamos borrar de COMENTARIO primero
        $stmt = $this->db->prepare("DELETE FROM COMENTARIO WHERE id_comentario = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() == 0) {
            // Si no era un comentario, es un POST. Borramos sus hijos y luego el post.
            try {
                $this->db->beginTransaction();
                $this->db->prepare("DELETE FROM COMENTARIO WHERE id_post = ?")->execute([$id]);
                $this->db->prepare("DELETE FROM POST WHERE id_post = ?")->execute([$id]);
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                $this->db->rollBack();
                return false;
            }
        }
        return true;
    }

    public function actualizarPost($id, $contenido)
    {
        // Intentar actualizar en la tabla COMENTARIO
        $stmt = $this->db->prepare("UPDATE COMENTARIO SET contenido = ? WHERE id_comentario = ?");
        $stmt->execute([$contenido, $id]);

        if ($stmt->rowCount() == 0) {
            // Si no afectó a ninguna fila, intentar actualizar en la tabla POST
            $stmt = $this->db->prepare("UPDATE POST SET contido = ? WHERE id_post = ?");
            $stmt->execute([$contenido, $id]);
        }
        return true;
    }

    // --- RESTO DE FUNCIONES ---

    public function getAllForos()
    {
        $sql = "SELECT * FROM FORO ORDER BY tipo_entidad DESC, data_creacion DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerIdForoGlobal()
    {
        $sql = "SELECT id_foro FROM FORO WHERE tipo_entidad = 'global' LIMIT 1";
        $res = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['id_foro'] : 1;
    }

    public function getPostsByForo($id_foro, $limit = 3)
    {
        $sql = "SELECT p.*, u.nombre 
            FROM POST p 
            JOIN USUARIO u ON p.id_usuario = u.id_usuario 
            WHERE p.id_foro = ? 
            ORDER BY p.data_publicacion DESC 
            LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_foro]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id_post)
    {
        // Esta función ahora busca en ambas tablas para que el controlador pueda validar el dueño
        $sql = "SELECT id_usuario FROM POST WHERE id_post = ? 
                UNION 
                SELECT id_usuario FROM COMENTARIO WHERE id_comentario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_post, $id_post]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUltimosComentarios($id_foro, $limite = 3)
    {
        $sql = "SELECT C.contenido, U.nombre, C.data_publicacion 
                FROM COMENTARIO C
                INNER JOIN POST P ON C.id_post = P.id_post
                INNER JOIN USUARIO U ON C.id_usuario = U.id_usuario
                WHERE P.id_foro = ? 
                ORDER BY C.data_publicacion DESC LIMIT " . (int)$limite;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_foro]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
