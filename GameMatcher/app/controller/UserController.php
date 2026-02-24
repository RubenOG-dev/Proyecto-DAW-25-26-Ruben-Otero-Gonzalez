<?php
require_once MODEL_PATH . "User.php";

class UserController
{

    public function mostrarAuth()
    {
        include_once VIEW_PATH . "auth.php";
    }

    public function procesarRegistro()
    {
        header('Content-Type: application/json');

        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $passConfirm = $_POST['password_confirm'] ?? '';

        if ($pass !== $passConfirm) {
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
            return;
        }

        $nombreCompleto = $nombre . " " . $apellidos;
        $model = new User();

        if ($model->registrar($nombreCompleto, $email, $pass)) {
            echo json_encode(['success' => true, 'message' => '¡Registro exitoso! Ya puedes entrar.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: El email ya existe o hay un problema con la base de datos.']);
        }
    }

    public function procesarLogin()
    {
        header('Content-Type: application/json');

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
                'message' => '¡Hola de nuevo, ' . $user['nombre'] . '!'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email o contraseña incorrectos.']);
        }
    }
}
