<?php 

include_once 'GlobalRepo.php';
function trouverLesCategories() {
    
    $PDO = connecterBDD();

    $query = "SELECT id_categorie, nom_categorie
    FROM categorie
    ORDER BY nom_categorie;
    ";

    return $PDO->query($query)->fetchAll();
}

function trouverLesProduits(): array {

    $PDO = connecterBDD();

    $query = "
    SELECT produit.id_produit, produit.nom_produit, produit.description_produit,
           produit.prix_ht_produit, produit.stock_produit, produit.catalogue_produit, 
           produit.promotion_produit, produit.reduction_produit, produit.tva_produit,
           produit.produit_supprime, produit.vendeur_produit, produit.nb_ventes_produit,
           categorie.id_categorie, categorie.nom_categorie, photo_produit.photo_produit, 
           photo_produit.photo_principale, vendeur.id_vendeur, vendeur.denomination_vendeur, 
           vendeur.siret_vendeur, vendeur.addresse_vendeur
    FROM produit 
    INNER JOIN categorie_produit on produit.id_produit = categorie_produit.id_produit
    INNER JOIN categorie on categorie_produit.id_categorie = categorie.id_categorie
    LEFT JOIN photo_produit on produit.id_produit = photo_produit.id_produit
    INNER JOIN vendeur on produit.vendeur_produit = vendeur.id_vendeur
    WHERE produit.catalogue_produit = TRUE
    AND produit.produit_supprime = FALSE
    ORDER BY produit.id_produit;";

    return $PDO->query($query)->fetchAll();
}


function trouverProduitParId(int $id): array|false {

    $PDO = connecterBDD();

    $query = "
    SELECT p.id_produit, p.nom_produit, p.description_produit,
           p.prix_ht_produit, p.stock_produit, p.catalogue_produit, 
           p.promotion_produit, p.reduction_produit, p.tva_produit,
           p.produit_supprime, p.vendeur_produit, p.nb_ventes_produit,
           c.nom_categorie, c.id_categorie, ph.photo_produit,
           v.denomination_vendeur
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
    SELECT p.id_produit, p.nom_produit, p.description_produit,
           p.prix_ht_produit, p.stock_produit, p.catalogue_produit, 
           p.promotion_produit, p.reduction_produit, p.tva_produit,
           p.produit_supprime, p.vendeur_produit, p.nb_ventes_produit,
           c.nom_categorie, c.id_categorie, ph.photo_produit,
           v.denomination_vendeur
    FROM limone.produit p
    INNER JOIN limone.categorie_produit cp ON p.id_produit = cp.id_produit
    INNER JOIN limone.categorie c ON cp.id_categorie = c.id_categorie
    LEFT JOIN limone.photo_produit ph ON p.id_produit = ph.id_produit
    INNER JOIN limone.vendeur v ON p.vendeur_produit = v.id_vendeur
    WHERE p.stock_produit > 0
    LIMIT 1;";

    return $PDO->query($query)->fetch();
}
function trouverLesProduitsVendeur($idVendeur): array {
    $PDO = connecterBDD();


    $query = "
    SELECT produit.id_produit, nom_produit, description_produit,
           prix_ht_produit, stock_produit, catalogue_produit,
           promotion_produit, reduction_produit, tva_produit,
           produit_supprime, vendeur_produit, nb_ventes_produit,
           vendeur.denomination_vendeur, vendeur.id_vendeur,
           categorie.id_categorie, photo_produit.photo_produit
    FROM produit 
    INNER JOIN categorie_produit on produit.id_produit = categorie_produit.id_produit
    INNER JOIN categorie on categorie_produit.id_categorie = categorie.id_categorie
    LEFT JOIN photo_produit on produit.id_produit = photo_produit.id_produit
    INNER JOIN vendeur on produit.vendeur_produit = vendeur.id_vendeur
    WHERE vendeur.id_vendeur = :idVendeur
    AND produit.catalogue_produit = TRUE
    AND produit.produit_supprime = FALSE
    ORDER BY produit.id_produit;";

    $stmt = $PDO->prepare($query);
    $stmt->execute([':idVendeur' => $idVendeur]);
    return $stmt->fetchAll();
}


function creerProduitBDD($nomProduit, $descriptionProduit, $prixProduit, $qteProduit, $estDansCatalogue, $tva, $idVendeur) {
    $PDO = connecterBDD();

    $query = "INSERT INTO Produit (nom_produit, description_produit, prix_ht_produit, stock_produit, catalogue_produit, tva_produit, vendeur_produit) 
              VALUES (:nomProduit, :descriptionProduit, :prixProduit, :qteProduit, :estDansCatalogue, :tva, :idVendeur) 
              RETURNING id_produit";

    try {
        $stmt = $PDO->prepare($query);

        $stmt->bindParam(":nomProduit", $nomProduit);
        $stmt->bindParam(":descriptionProduit", $descriptionProduit);
        $stmt->bindParam(":prixProduit", $prixProduit);
        $stmt->bindParam(":qteProduit", $qteProduit);
        $stmt->bindParam(":estDansCatalogue", $estDansCatalogue);
        $stmt->bindParam(":tva", $tva);
        $stmt->bindParam(":idVendeur", $idVendeur);

        $stmt->execute();
        
        return $stmt->fetch();
    } catch (PDOException $e) {
        return false;
    }
}

function lierCategorie($idCategorie, $idVendeur) {
    $PDO = connecterBDD();

    $query = "INSERT INTO Categorie_Produit (id_produit, id_categorie) 
              VALUES (:idVendeur, :idCategorie);";

    try {
        $stmt = $PDO->prepare($query);

        $stmt->bindParam(":idCategorie", $idCategorie);
        $stmt->bindParam(":idVendeur", $idVendeur);

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

function addPhoto($idProduit, $nomFichier, $estLaMain) {
    $PDO = connecterBDD();

    try {
        $stmt = $PDO->prepare("INSERT INTO photo_produit (id_produit, photo_produit, photo_principale) 
                               VALUES (:id, :nomFichier, :isMain)");

        $stmt->bindValue(":id", $idProduit);
        $stmt->bindValue(":nomFichier", $nomFichier);
        $stmt->bindValue(":isMain", $estLaMain);

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }

    
}

?>