<?php
chdir(__DIR__ . '/../../');
require_once 'html/Produit/Produit.php';
require_once 'connect_params.php';
require_once 'lib/repo/PanierRepo.php';
require_once 'lib/repo/GlobalRepo.php';

function getProduitsFromPanier(array $panier)
{

    $dbh = connecterBDD();
    $stringListe = "(" . implode(", ", $panier) . ")";

    $query = "select * from produit where id_produit in $stringListe";

    $stmt = $dbh->prepare($query);

    $stmt->execute();

    $retour = $stmt->fetchAll();

    return $retour;
}

/**
 * Prend en paramètre un produit déjà initialisé
 * @param Produit $produit La variable Produit qui a permis de remplir la page produit detaillée
 */
function ajouterProduit(Produit $produit, $userId = null)
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
}
?>