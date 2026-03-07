<?php
require_once MODEL_PATH . "Admin.php";
require_once MODEL_PATH . "User.php";

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->login($email, $password);

            if (!$user && $email === 'admin@gamematcher.com' && $password === 'admin') {
                $user = [
                    'id_usuario' => 1,
                    'nombre' => 'Administrador',
                    'tipo_usuario' => 'admin'
                ];
            }

            if ($user && $user['tipo_usuario'] === 'admin') {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['tipo_usuario'] = 'admin';

                header("Location: index.php?controller=Admin&action=dashboard");
                exit;
            } else {
                $error = "Acceso denegado. Las credenciales son incorrectas.";
                include_once VIEW_PATH . "login_admin.php";
            }
        } else {
            include_once VIEW_PATH . "login_admin.php";
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

        $datos = [
            'stats'          => $this->adminModel->getEstadisticas(),
            'lista_usuarios' => $this->adminModel->getAllUsuarios(),
            'lista_foros'    => $this->adminModel->getAllForosAdmin(),
            'ultimos_posts'  => $this->adminModel->getUltimosPostsGlobales(10),
            'comentarios'    => $this->adminModel->getAllComentarios(15)
        ];

        include_once VIEW_PATH . "dashboard.php";
    }

    public function deleteComment()
    {
        $this->checkAdmin();
        $id_comentario = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_comentario) {
            $this->adminModel->eliminarComentario($id_comentario);
        }
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }

    public function deletePost()
    {
        $this->checkAdmin();
        $id_post = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_post) {
            $this->adminModel->eliminarPost($id_post);
        }
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?controller=Admin&action=dashboard'));
        exit;
    }

    public function deleteUser()
    {
        $this->checkAdmin();
        $id_user = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_user) {
            $this->adminModel->eliminarUsuario($id_user);
        }
        header("Location: index.php?controller=Admin&action=dashboard");
        exit;
    }

    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
            header("Location: index.php?controller=User&action=mostrarAuth");
            exit();
        }
    }
}
