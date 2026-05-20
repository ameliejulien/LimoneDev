<?php
    include "../../lib/service/ServicePanier.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // décodage du fichier json envoyé
    $fetchData = file_get_contents("php://input"); 
    $data = json_decode($fetchData, true);
    if (intval($data['id_produit']) !== 0) {
        ajouterProduitToCookie($data['id_produit']);
        // code de la réponse + envoi du tableau data (réponse HTTP)
        http_response_code(200);
    } else {
        http_response_code(500);
    }
?>