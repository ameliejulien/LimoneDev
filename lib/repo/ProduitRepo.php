<?php 

include 'GlobalRepo.php';

function trouverTousLesProduits(): array {

    $PDO = connecterBDD();

    $query = "
    SELECT * 
    FROM produit 
    INNER JOIN photo_produit on id_produit = id_photo_produit
    ORDER BY id_produit;";

    return $PDO->query($query)->fetchAll();
}

?>