<?php
include "../../lib/service/ServiceVendeur.php";
include "../../lib/service/ServiceUtilisateur.php";
header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input"); 
$data = json_decode($fetchData, true);
$retour;

if ($data["typeRequete"] == "creation") {
    $retour=confimerInscription($data);

} else if ($data["typeRequete"] == "modification") {
    $retour=modificationVendeur($data);

} else if ($data["typeRequete"] == "modificationMdp") {
    $retour=modificationMdpVendeur($data);

} else if ($data["typeRequete"] == "deconnexion") {
    $retour=deconnecterUtilisateur();
}

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
?>