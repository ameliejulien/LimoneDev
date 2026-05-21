<?php
include "../../lib/service/ServiceClient.php";
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
    $data["reponse"] = $retour;

} else if ($data["typeRequete"] == "connexion") {
    $retour = connexionClient($data);
    $data["reponse"] = $retour;
    ajouterClientCookie($data);
} else if ($data["typeRequete"] == "deconnexion") {
    $retour = deconnecterClient();
    $data["reponse"] = $retour;

} else if ($data["typeRequete"] == "modificationMdp") {
    $retour = modificationMdpClient($data);
    $data["reponse"] = $retour;
} else if ($data["typeRequete"] == "modification") {
    $idClient = obtenirIdClientConnecte();
    $retour = modifierClientBDD($data, $_FILES, $idClient);
    $data["reponse"] = $retour;
}

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code($retour);
echo json_encode($data);
?>