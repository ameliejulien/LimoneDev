<?php
require "../../lib/service/servicePanier.php";

header('Content-Type: application/json');
// Optionnel : autoriser les requêtes cross-origin
header('Access-Control-Allow-Origin: *');

$data = getPanier();

http_response_code(200); // facultatif, c'est le défaut
echo json_encode($data);


?>