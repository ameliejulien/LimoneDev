<?php
    include __DIR__ . '/../../lib/service/ConnexionService.php';

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $data = json_decode(file_get_contents("php://input"), true);

    $user = connecter($data);

    if (!$user) {
        http_response_code(401);
        echo json_encode(["error" => "invalid credentials"]);
    }


    if ($user["type_utilisateur"] == 1) {
        creerCookieConnexion($user, "client");
    } else if ($user["type_utilisateur"] == 2) {
        creerCookieConnexion($user, "vendeur");
    }

    $user["reponse"] = 200;

    http_response_code(200);
    echo json_encode($user);

?>