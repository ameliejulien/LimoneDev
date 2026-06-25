<?php
    require_once '../../lib/service/ServiceVendeur.php';
    require_once __DIR__ . '/../../lib/Constantes.php';


    $returnCode = HTTP_OK;
    $returnValue;

    try {
        header('Content-Type: application/json');
    
        $fetchData = file_get_contents("php://input"); 
        $data = json_decode($fetchData, true);

        $returnValue = recupererAdressesVendeurs();
    } catch (Exception $e) {
        $returnCode = HTTP_ERR_GENERIQUE;
        $returnValue = ["details" => "Une erreur est survenue"];
    } finally {
        http_response_code($returnCode);
        echo json_encode($returnValue);
    }
?>