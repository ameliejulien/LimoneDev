<?php
include_once('../../lib/service/ServiceProduit.php');
include_once('../../lib/service/ServiceUtilisateur.php');
require_once __DIR__ . '/../../lib/Constantes.php';



// Verifie les droits d'accès à cette page
droitsAccesPage($_COOKIE['uuid'] ?? null, 2);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

//$fetchData = json_decode(file_get_contents("php://input"), true);

$data = creerProduit($_POST, $_COOKIE['uuid']);

// code de la réponse + envoi du tableau data (réponse HTTP)
http_response_code(HTTP_OK);
echo json_encode($data);
?>