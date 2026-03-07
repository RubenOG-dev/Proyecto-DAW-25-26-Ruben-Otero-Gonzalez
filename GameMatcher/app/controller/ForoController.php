<?php
require_once MODEL_PATH . "Foro.php";
require_once HELPER_PATH . "ForoHelper.php";

class ForoController
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new Foro();
    }

    public function ver()
    {
        $id_foro = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id_foro) {
            header("Location: index.php?controller=Foro&action=listar");
            exit;
        }

        $foro = $this->model->getForoById($id_foro);

        if (!$foro) {
            header("Location: index.php?controller=Foro&action=listar");
            exit;
        }

        $mensajes = $this->model->getMensajesEstructurados($id_foro);
        include_once VIEW_PATH . "detalle_foro.php";
    }

    public function accederJuego()
    {
        $game_id = filter_input(INPUT_GET, 'game_id', FILTER_VALIDATE_INT);
        $game_name = $_GET['name'] ?? 'Juego Desconocido';

        if (!$game_id) {
            header("Location: index.php");
            exit;
        }

        $id_foro = $this->model->obtenerOCrearForoJuego($game_id, $game_name);
        header("Location: index.php?controller=Foro&action=ver&id=" . $id_foro);
        exit;
    }

    public function mostrarListaForos()
    {
        try {
            $foros = $this->model->getAllForos();

            if ($foros) {
                foreach ($foros as &$f) {
                    $posts = $this->model->getPostsByForo($f['id_foro'], 3);
                    $f['posts'] = $posts ? $posts : [];

                    $comentarios = $this->model->getUltimosComentarios($f['id_foro'], 2);
                    $f['ultimos_comentarios'] = $comentarios ? $comentarios : [];
                }
            }

            include_once VIEW_PATH . "lista_foros.php";
        } catch (Exception $e) {
            die("Error en el controlador de foros: " . $e->getMessage());
        }
    }

    public function listar()
    {
        $this->mostrarListaForos();
    }

    public function principal()
    {
        $id_foro_global = $this->model->obtenerIdForoGlobal();
        header("Location: index.php?controller=Foro&action=ver&id=" . $id_foro_global);
        exit;
    }

    public function borrarPost()
    {
        $id_post = $_GET['id_post'] ?? null;
        $id_foro = $_GET['id_foro'] ?? null;
        $id_usuario = $_SESSION['id_usuario'] ?? null;

        if ($id_post && $id_usuario) {
            $item = $this->model->getPostById($id_post);

            if ($item && $item['id_usuario'] == $id_usuario) {
                $this->model->eliminarPost($id_post);
            }
        }

        header("Location: index.php?controller=Foro&action=ver&id=" . $id_foro);
        exit;
    }

    public function editarPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_post = $_POST['id_post'] ?? null;
            $id_foro = $_POST['id_foro'] ?? null;
            $contenido = $_POST['contenido'] ?? '';
            $id_usuario = $_SESSION['id_usuario'] ?? null;

            if ($id_post && $id_usuario) {
                $item = $this->model->getPostById($id_post);

                if ($item && $item['id_usuario'] == $id_usuario) {
                    $this->model->actualizarPost($id_post, $contenido);
                }
            }

            header("Location: index.php?controller=Foro&action=ver&id=" . $id_foro);
            exit;
        }
    }

    public function postear()
    {
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        if (!$id_usuario) {
            header("Location: index.php?controller=User&action=login");
            exit;
        }

        $id_foro = filter_input(INPUT_POST, 'id_foro', FILTER_VALIDATE_INT);
        $contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

        $titulo = trim(preg_replace('/\s+/', ' ', str_replace(['&#13;', '&#10;'], ' ', $titulo)));
        $contenido = trim(preg_replace("/[\r\n]{2,}/", "\n", str_replace(['&#13;', '&#10;'], "\n", $contenido)));

        $id_post_destino = filter_input(INPUT_POST, 'id_post_padre', FILTER_VALIDATE_INT);

        if ($id_foro && !empty($contenido)) {
            if ($id_post_destino) {
                $this->model->crearComentario($id_post_destino, $id_usuario, $contenido);
            } else {
                $titulo_final = !empty($titulo) ? $titulo : "Nuevo Hilo";
                $this->model->crearPostPrincipal($id_foro, $id_usuario, $contenido, $titulo_final);
            }
        }

        header("Location: index.php?controller=Foro&action=ver&id=" . $id_foro);
        exit;
    }
}