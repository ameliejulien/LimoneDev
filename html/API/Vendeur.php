<?php
include "../../lib/service/ServiceVendeur.php";
include "../../lib/service/ServiceUtilisateur.php";
require_once __DIR__ . '/../../lib/Constantes.php';


header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input"); 
$data = json_decode($fetchData, true);
$retour;

if ($data["typeRequete"] == REQ_CREATION) {
    $retour=confimerInscription($data);

} else if ($data["typeRequete"] == REQ_MODIF_INFOS) {
    $retour=modificationVendeur($data);

} else if ($data["typeRequete"] == REQ_MODIF_MDP) {
    $retour=modificationMdpVendeur($data);

} else if ($data["typeRequete"] == REQ_DECONNEXION) {
    $retour=deconnecterUtilisateur();
}

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
?>