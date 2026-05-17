<?php
require "../../lib/service/servicePanier.php";

header('Content-Type: application/json');
// autoriser les requêtes cross-origin
header('Access-Control-Allow-Origin: *'); // todo Verifier 

$data = getPanier();

http_response_code(200);
echo json_encode($data);


?>