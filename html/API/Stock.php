<?php
    include "../../lib/service/ServiceStock.php";


    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $fetchData = file_get_contents("php://input");
    $data = json_decode($fetchData, true);

    if ($data["typeRequete"] == "update") {
        $retour = updateStock($data['lignesModifiees']);
    } 

    http_response_code($retour);
    echo json_encode($data);

?>