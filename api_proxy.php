<?php
require_once __DIR__ . "/app/controllers/ChatController.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$message = $data["message"] ?? "";

$chat = new ChatController();
$answer = $chat->handle($message);

echo json_encode([
    "ok" => true,
    "answer" => $answer
]);
