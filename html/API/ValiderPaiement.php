<?php
require "../../lib/service/ServicePaiement.php";

header('Content-Type: application/json');
// autoriser les requêtes cross-origin
header('Access-Control-Allow-Origin: *');

$data = validerFormulaire();

http_response_code(200);
echo json_encode($data);
?>