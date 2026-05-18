<?php
include "../../lib/service/ServiceClient.php";
header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input"); 
$data = json_decode($fetchData, true);

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code(200);
echo json_encode($data); 
?>