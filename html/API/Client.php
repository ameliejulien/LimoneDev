<?php
require_once "../../lib/service/ServiceClient.php";
require_once "../../lib/service/ServiceUtilisateur.php";
require_once __DIR__ . '/../../lib/Constantes.php';


header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input");
$data = json_decode($fetchData, true);

if (!$data) {
    $data = $_POST;
}

$retour = HTTP_ERR_GENERIQUE;

// ajoute un cookie client
if ($data["typeRequete"] == REQ_CREATION) {
    $retour = confimerInscription($data);
} else if ($data["typeRequete"] == REQ_DECONNEXION) {
    $retour = deconnecterUtilisateur();
} else if ($data["typeRequete"] == REQ_MODIF_MDP) {
    $idClient = trouverIDUtilisateur($_COOKIE['uuid']);
    $retour = modificationMdpClient($data, $idClient);
} else if ($data["typeRequete"] == REQ_MODIF_INFOS) {

    $retour = modifierClientBDD($data, $_FILES);
}

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
?>