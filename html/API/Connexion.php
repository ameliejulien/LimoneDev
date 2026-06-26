<?php
    require_once __DIR__ . '/../../lib/service/ConnexionService.php';

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $data = json_decode(file_get_contents("php://input"), true);

    http_response_code(connexion($data["mail"], $data["motDePasse"], $data["otp"] ?? null));
?>