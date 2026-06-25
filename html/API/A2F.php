<?php
require_once __DIR__ . '/../../lib/Constantes.php';
require_once __DIR__ . '/../../lib/service/ServiceA2F.php';

header('Content-Type: application/json');
$codeRetour = HTTP_OK;

try {
    if (!$_COOKIE['uuid']) {
        throw new Exception("Unauthorized");
    }

    $fetchData = file_get_contents("php://input");
    $data = json_decode($fetchData, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codeRetour = HTTP_CREATED;
        creationA2F($_COOKIE['uuid'], $data['secret'], $data['otp']);
    }
} catch (Exception $e) {
    $message = $e->getMessage();

    if ($message === "Unauthorized") {
        $codeRetour = HTTP_UNAUTHORIZED;
    } else if ($message === "IncorrectOTP") {
        $codeRetour = HTTP_UNPROCESSABLE;
    } else {
        $codeRetour = HTTP_ERR_GENERIQUE;
    }
}

http_response_code($codeRetour);
?>