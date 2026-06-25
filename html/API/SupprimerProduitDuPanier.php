<?php
    include_once '../../lib/service/ServicePanier.php';
    require_once '../../lib/Constantes.php';

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $data = json_decode(file_get_contents("php://input"), true);

    supprimerProduitDesCookies($data);

    http_response_code(HTTP_OK);
?>