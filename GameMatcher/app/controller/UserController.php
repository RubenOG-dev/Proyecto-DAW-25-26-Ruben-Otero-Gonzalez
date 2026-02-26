<?php
require_once MODEL_PATH . "User.php";

class UserController
{

    public function principal()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?controller=User&action=mostrarAuth");
            exit;
        }
        $isMobile = $this->checkDevice();
        $view = $isMobile ? "principal_mobile.php" : "principal_desktop.php";
        include_once VIEW_PATH . $view;
    }
    public function mostrarAuth()
    {
        include_once VIEW_PATH . "auth.php";
    }

    public function procesarRegistro()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            $nombre = $_POST['nombre'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $email = $_POST['email'] ?? '';
            $pass = $_POST['password'] ?? '';
            $passConfirm = $_POST['password_confirm'] ?? '';

            if ($pass !== $passConfirm) {
                echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
                exit;
            }

            $nombreCompleto = $nombre . " " . $apellidos;
            $model = new User();

            if ($model->registrar($nombreCompleto, $email, $pass)) {
                echo json_encode(['success' => true, 'message' => '¡Registro exitoso! Ya puedes entrar.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: El email ya existe o hay un problema con la base de datos.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error interno: ' . $e->getMessage()]);
        }
        exit; // Evita que se procese nada más
    }

    public function procesarLogin()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $model = new User();
            $user = $model->login($email, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

                echo json_encode([
                    'success' => true,
                    'message' => '¡Hola de nuevo, ' . htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8') . '!',
                    // DIRECCIÓN EXACTA A LA VISTA PRIVADA
                    'redirect' => 'index.php?controller=User&action=principal'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email o contraseña incorrectos.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: index.php");
        exit;
    }

    private function checkDevice()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry', 'Opera Mini', 'IEMobile'];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) return true;
        }
        return false;
    }
}
