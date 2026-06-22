<?php
    require_once '../../lib/service/ServiceVendeur.php';

    $returnCode = 200;
    $returnValue;

    try {
        header('Content-Type: application/json');
    
        $fetchData = file_get_contents("php://input"); 
        $data = json_decode($fetchData, true);

        $returnValue = recupererAdressesVendeurs();
    } catch (Exception $e) {
        $returnCode = 500;
        $returnValue = ["details" => "Une erreur est survenue"];
    } finally {
        http_response_code($returnCode);
        echo json_encode($returnValue);
    }
?>