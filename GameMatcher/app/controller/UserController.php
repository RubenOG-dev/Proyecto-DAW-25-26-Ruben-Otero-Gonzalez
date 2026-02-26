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

    public function mostrarMain(){
        include_once VIEW_PATH . "main.php";
    }

    /**
     * Requisito 4.1.1: Seguridad y Validación de datos (Sanitización)
     */
    public function procesarRegistro()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            // REQUISITO 4.1.1: Sanitización de entradas para evitar XSS
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
            $pass = $_POST['password'] ?? '';
            $passConfirm = $_POST['password_confirm'] ?? '';

            if (empty($nombre) || empty($email) || empty($pass)) {
                echo json_encode(['success' => false, 'message' => 'Por favor, completa todos os campos obrigatorios.']);
                exit;
            }

            if ($pass !== $passConfirm) {
                echo json_encode(['success' => false, 'message' => 'As contrasinais non coinciden.']);
                exit;
            }

            $nombreCompleto = $nombre . " " . $apellidos;
            $model = new User();

            if ($model->registrar($nombreCompleto, $email, $pass)) {
                echo json_encode(['success' => true, 'message' => '¡Rexistro exitoso! Xa podes entrar.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro: O email xa existe ou hai un problema coa base de datos.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
        }
        exit;
    }

    /**
     * Requisito 4.1.1: Comunicación asíncrona y Seguridad
     */
    public function procesarLogin()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            // REQUISITO 4.1.1: Validación de datos de entrada
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Email e contrasinal son obrigatorios.']);
                exit;
            }

            $model = new User();
            $user = $model->login($email, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

                echo json_encode([
                    'success' => true,
                    'message' => '¡Ola de novo, ' . htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8') . '!',
                    'redirect' => 'index.php?controller=User&action=mostrarMain'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email ou contrasinal incorrectos.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
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
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry', 'Opera Mini', 'IEMobile'];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) return true;
        }
        return false;
    }
}