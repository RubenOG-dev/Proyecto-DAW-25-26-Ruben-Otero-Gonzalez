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
        $return_to = $_GET['return_to'] ?? null;
        include_once VIEW_PATH . "auth.php";
    }

    public function mostrarMain()
    {
        include_once VIEW_PATH . "main.php";
    }

    public function procesarRegistro()
{
    // Limpiamos cualquier salida previa para asegurar un JSON limpio
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json');

    try {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
        $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
        $pass = $_POST['password'] ?? '';
        $passConfirm = $_POST['password_confirm'] ?? '';

        // Validación básica de campos
        if (empty($nombre) || empty($email) || empty($pass)) {
            echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
            exit;
        }

        if ($pass !== $passConfirm) {
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
            exit;
        }

        $model = new User();
        $nombreCompleto = trim($nombre . " " . $apellidos);
        
        // Intentar registro: Ahora $id_nuevo_usuario recibirá el ID de lastInsertId()
        $id_nuevo_usuario = $model->registrar($nombreCompleto, $email, $pass);

        if ($id_nuevo_usuario) {
            // --- AUTO-LOGIN ---
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            $_SESSION['id_usuario'] = $id_nuevo_usuario;
            $_SESSION['nombre'] = $nombre; // Guardamos solo el nombre de pila para saludar
            $_SESSION['tipo_usuario'] = 'free'; // Valor inicial según tu INSERT en el modelo

            // Registramos la sesión técnica en la tabla SESION
            $model->registrarSesionBD($id_nuevo_usuario);

            // --- REDIRECCIÓN INTELIGENTE ---
            // Por defecto a principal
            $redirectUrl = 'index.php?controller=MainController&action=principal';
            
            // Si el campo oculto 'return_to' tiene un ID de juego, redirigimos allí
            if (!empty($_POST['return_to'])) {
                $redirectUrl = 'index.php?controller=Games&action=detalle&id=' . urlencode($_POST['return_to']);
            }

            echo json_encode([
                'success' => true, 
                'message' => '¡Registro exitoso! Hola, ' . htmlspecialchars($nombre) . '. Iniciando sesión...',
                'redirect' => $redirectUrl
            ]);
        } else {
            // Si el modelo devuelve false, es que el email ya está en uso
            echo json_encode(['success' => false, 'message' => 'Error: El correo electrónico ya está registrado.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
    }
    exit;
}

    public function procesarLogin()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'El email y la contraseña son obligatorios.']);
                exit;
            }

            $model = new User();
            $user = $model->login($email, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['tipo_usuario'] = $user['tipo_usuario'];

                $model->registrarSesionBD($user['id_usuario']);

                $redirectUrl = 'index.php?controller=User&action=mostrarMain';

                if (!empty($_POST['return_to'])) {
                    $redirectUrl = 'index.php?controller=Games&action=detalle&id=' . $_POST['return_to'];
                }

                echo json_encode([
                    'success' => true,
                    'message' => '¡Hola de nuevo, ' . htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8') . '!',
                    'redirect' => $redirectUrl
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

        if (isset($_SESSION['id_usuario'])) {
            $model = new User();
            $model->cerrarSesionBD($_SESSION['id_usuario']);
        }

        session_unset();
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
