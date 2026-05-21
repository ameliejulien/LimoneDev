<?php 

include_once 'GlobalRepo.php';

function trouverLesProduits(): array {

    $PDO = connecterBDD();

    $query = "
    SELECT * 
    FROM produit 
    INNER JOIN categorie_produit on produit.id_produit = categorie_produit.id_produit
    INNER JOIN categorie on categorie_produit.id_categorie = categorie.id_categorie
    LEFT JOIN photo_produit on produit.id_produit = photo_produit.id_photo_produit
    INNER JOIN vendeur on produit.vendeur_produit = vendeur.id_vendeur
    ORDER BY produit.id_produit;";

    return $PDO->query($query)->fetchAll();
}

function trouverLesCategories() {

    $PDO = connecterBDD();

    $query = "
    SELECT * 
    FROM categorie
    ORDER BY nom_categorie;
    ";

    return $PDO->query($query)->fetchAll();
}

?>