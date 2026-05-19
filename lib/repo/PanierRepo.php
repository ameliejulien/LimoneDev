<?php
chdir(__DIR__ . '/../../');
require_once 'html/Produit/Produit.php';
require_once 'connect_params.php';
require_once 'lib/repo/PanierRepo.php';
require_once 'lib/repo/GlobalRepo.php';

function getDBProduitsFromPanier(Array $panier)
{
    $dbh = connecterBDD();
    $stringListe = "(" . implode(", ", $panier) . ")";

    $query = "select produit.id_produit, nom_produit, description_produit, prix_ht_produit,
    stock_produit, catalogue_produit, promotion_produit, reduction_produit, tva_produit, produit_supprime, photo_produit
    from produit
    join photo_produit on produit.id_produit = photo_produit.id_photo_produit
    where produit.id_produit in $stringListe";
    

    $stmt = $dbh->prepare($query);

    $stmt->execute();

    $retour = $stmt->fetchAll();

    return $retour;
}

function getTousLesProduitsBDD() {
    $dbh = connecterBDD();

    $query = "select id_produit, produit_supprime from produit";

    $stmt = $dbh->prepare($query);

    $stmt->execute();

    $retour = $stmt->fetchAll();

    return $retour;
}

function getStatusDuProduit(String $productId) {
    $dbh = connecterBDD();

    $query = "select produit_supprime from produit where id_produit = $productId";

    $stmt = $dbh->prepare($query);

    $stmt->execute();

    $retour = $stmt->fetch();

    return $retour;
}

/**
 * Prend en paramètre un produit déjà initialisé
 * @param Produit $produit La variable Produit qui a permis de remplir la page produit detaillée
 */
/*function ajouterProduit(Produit $produit, $userId = null)
{
    $productId = $produit->getProduitId();

    // todo finir la querry pour verifier si le produit est encore là
    $query = "SELECT * from ";

    // todo Requete bdd pour verifier si le produit est encoer dans la bdd   
    $res = null;

    if ($res == true) {

        // 
        if ($userId != null) {
            $listeProduit = $produit;

            $quantite = 0;
            foreach ($listeProduit as $produitDansList) {
                if ($produit == $produitDansList) {
                    $quantite++;
                }
            }

            $query = "INSERT INTO Panier (product_id, user_id, quantity) VALUES($productId, $userId, $quantite)";
        }

    }
}*/
?>