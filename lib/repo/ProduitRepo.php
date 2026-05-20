<?php 

include 'GlobalRepo.php';

function trouverTousLesProduits(): array {

    $PDO = connecterBDD();

    $query = "
    SELECT * 
    FROM produit 
    INNER JOIN photo_produit on produit.id_produit = photo_produit.id_photo_produit
    ORDER BY produit.id_produit;";

    return $PDO->query($query)->fetchAll();
}

?>