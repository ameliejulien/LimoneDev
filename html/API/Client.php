<?php
require_once "../../lib/service/ServiceClient.php";
require_once "../../lib/service/ServiceUtilisateur.php";
header('Content-Type: application/json');

// décodage du fichier json envoyé
$fetchData = file_get_contents("php://input");
$data = json_decode($fetchData, true);

if (!$data) {
    $data = $_POST;
}

$retour = 500;

// ajoute un cookie client
if ($data["typeRequete"] == "creation") {
    $retour = confimerInscription($data);
} else if ($data["typeRequete"] == "deconnexion") {
    $retour = deconnecterUtilisateur();
} else if ($data["typeRequete"] == "modificationMdp") {
    $idClient = trouverIDUtilisateur($_COOKIE['uuid']);
    $retour = modificationMdpClient($data, $idClient);
} else if ($data["typeRequete"] == "modification") {
    $retour = modifierClientBDD($data, $_FILES);
}

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
?>