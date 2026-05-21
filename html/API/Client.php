<?php
include "../../lib/service/ServiceClient.php";
header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input"); 
$data = json_decode($fetchData, true);
$retour;

// ajoute un cookie client
if ($data["typeRequete"] == "creation") {
    $retour=confimerInscription($data);
    $data["reponse"] = $retour;

} else if ($data["typeRequete"] == "connexion") {
    $retour=connexionClient($data);
    $data["reponse"] = $retour;
    ajouterClientCookie($data);
<<<<<<< Updated upstream:html/API/Client.php

} else if ($data["typeRequete"] == "deconnexion") {
    $retour = deconnecterClient();
    $data["reponse"] = $retour;
=======
} else if ($data["typeRequete"] == "modification") {
    $retour=modifierClientBDD($data);
    $data["reponse"] = $retour;
    ajouterClientCookie($data);
>>>>>>> Stashed changes:html/API/CreerClient.php
}




// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
echo json_encode($data); 
?>