<?php
require_once MODEL_PATH . 'Bot.php';

class BotController
{
    public function responder()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['id_usuario'])) {
            echo json_encode(["response" => "Debes iniciar sesión para hablar conmigo."]);
            return;
        }

        if ($_SESSION['tipo_usuario'] === 'free') {
            if (!isset($_SESSION['bot_usage'])) $_SESSION['bot_usage'] = 0;

            $limite = 5;
            if ($_SESSION['bot_usage'] >= $limite) {
                echo json_encode([
                    "response" => "⚠️ <b>Límite acadado.</b> Como usuario GRATIS tes un máximo de $limite consultas. <br><br> ¿Queres desbloquear o poder ilimitado?",
                    "options" => [
                        ["name" => "💎 HACERME PREMIUM", "link" => "index.php?controller=User&action=comprarPremium"]
                    ]
                ]);
                return;
            }
            $_SESSION['bot_usage']++;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $message = $input['message'] ?? '';

        if (empty(trim($message))) {
            echo json_encode(["response" => "O mensaxe non puede estar baleiro."]);
            return;
        }

        $bot = new Bot();
        $result = $bot->getResponse($message);

        if ($_SESSION['tipo_usuario'] === 'free') {
            $restantes = 5 - $_SESSION['bot_usage'];
            $result['response'] .= "<br><br><small style='color: #888;'>Consultas restantes: $restantes</small>";
        }

        echo json_encode($result);
    }
}
