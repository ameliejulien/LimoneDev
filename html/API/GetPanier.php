<?php
require_once "../../lib/service/servicePanier.php";
require_once __DIR__ . '/../../lib/Constantes.php';


header('Content-Type: application/json');
// autoriser les requêtes cross-origin
header('Access-Control-Allow-Origin: *'); 

$data = getPanier();

http_response_code(HTTP_OK);
echo json_encode($data);


?>