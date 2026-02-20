<?php
require_once MODEL_PATH . 'Bot.php'; 

class BotController {
    public function responder() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);
        $message = $input['message'] ?? '';

        if (empty(trim($message))) {
            echo json_encode(["response" => "El mensaje no puede estar vacío."]);
            return;
        }

        $bot = new Bot();
        $result = $bot->getResponse($message);

        echo json_encode($result);
    }
}