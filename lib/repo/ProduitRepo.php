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

<<<<<<< Updated upstream
function trouverLesCategories() {
=======
function trouverProduitParId(int $id): array|false {
>>>>>>> Stashed changes

    $PDO = connecterBDD();

    $query = "
<<<<<<< Updated upstream
    SELECT * 
    FROM categorie
    ORDER BY nom_categorie;
    ";

    return $PDO->query($query)->fetchAll();
=======
    SELECT p.*, c.nom_categorie, c.id_categorie, ph.photo_produit, v.denomination_vendeur
    FROM limone.produit p
    INNER JOIN limone.categorie_produit cp ON p.id_produit = cp.id_produit
    INNER JOIN limone.categorie c ON cp.id_categorie = c.id_categorie
    LEFT JOIN limone.photo_produit ph ON p.id_produit = ph.id_produit
    INNER JOIN limone.vendeur v ON p.vendeur_produit = v.id_vendeur
    WHERE p.id_produit = :id
    LIMIT 1;";

    $stmt = $PDO->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function trouverPremierProduit(): array|false {

    $PDO = connecterBDD();

    $query = "
    SELECT p.*, c.nom_categorie, c.id_categorie, ph.photo_produit, v.denomination_vendeur
    FROM limone.produit p
    INNER JOIN limone.categorie_produit cp ON p.id_produit = cp.id_produit
    INNER JOIN limone.categorie c ON cp.id_categorie = c.id_categorie
    LEFT JOIN limone.photo_produit ph ON p.id_produit = ph.id_produit
    INNER JOIN limone.vendeur v ON p.vendeur_produit = v.id_vendeur
    WHERE p.stock_produit > 0
    LIMIT 1;";

    return $PDO->query($query)->fetch();
>>>>>>> Stashed changes
}

?>