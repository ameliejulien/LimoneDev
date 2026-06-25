<?php
    include "../../lib/service/ServicePanier.php";
        require_once '../../lib/Constantes.php';

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $data = (array) json_decode(validerPanier());

    // code de la réponse + envoi du tableau data (réponse HTTP)
    http_response_code(HTTP_OK);
    echo json_encode($data);
?>