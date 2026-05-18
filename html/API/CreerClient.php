<?php
include "../../lib/service/ServiceClient.php";
header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input"); 
$data = json_decode($fetchData, true);
$retour;
if ($data["typeRequete"] == "creation") {
    $retour=confimerInscirption($data);
    $data["reponse"] = $retour;

} else if ($data["typeRequete"] == "connexion") {
    $retour=connexionClient($data);
    $data["reponse"] = $retour;
}




// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
echo json_encode($data); 
?>