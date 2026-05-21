<?php
    include "../../lib/service/ServicePanier.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $data = (array) json_decode(validerPanier());

    // code de la réponse + envoi du tableau data (réponse HTTP)
    http_response_code(200);
    echo json_encode($data);
?>