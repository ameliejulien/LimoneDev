<?php
require_once '../../lib/repo/PanierRepo.php';

$listeProduit = [];
$utilisateurId = null;

 /**
 * Prend en paramètre un produit déjà initialisé
 * @param int $produitId La variable produitId qui est à ajouter
 */
function ajouterProduitToCookie(int $produitId, int $qte = 1)
{
    // Verifier si l'article existe
    $produitSupprime = getStatusDuProduit($produitId);
    $listeProduit = [];

    if (!$produitSupprime) {
        // Save dans les cookies
        if (isset($_COOKIE['panier'])) { // cookie déjà créé
            $listeProduit = (array) json_decode($_COOKIE['panier']);
        }

        for ($i=0; $i < $qte; $i++) { 
            $listeProduit[] = $produitId;
        }

        // Modifie la liste de produit dans le cookie
        setcookie('panier', json_encode($listeProduit), time() + 3*24*60*60, "/");
    }
}


/**
 * Supprimer un produit du panier et du cookie
 * @param int $produitId id du produit à supprimer
 */
function supprimerProduitDesCookies(int $produitId)
{
    if ($_COOKIE['panier'] != null) {
        $listeProduit = (array) json_decode($_COOKIE['panier']);

        $nouvelListProduit = [];

        // Passe à traver toutes valeurs de la liste de produit et supprime ceux qui sont égale au produit id
        for ($i = 0; $i < sizeof($listeProduit); $i++) {
            if ($listeProduit[$i] != $produitId) {
                $nouvelListProduit[] = $listeProduit[$i];
            }
        }

        // Sauvegarde le cookie avec le produit supprimer
        setcookie('panier', json_encode($nouvelListProduit), time() + 3*24*60*60, "/");
    }
}

/**
 * Valide le panier, verifie tous les produits pour voir si tous les produits du panier sont encore dans la BDD et sépare les valides des invalides.
 * @return mixed retourne un JSON de fromat : {"valides":["id_1", "id_2", ..."], "manquants":["nom_1", "nom_2", ...]}
 */
function validerPanier()
{
    $listeProduit = (array) json_decode($_COOKIE['panier']);

    // Recupére la table des produits pour vérifier si tous les produits du panier sont présent dans la BDD
    $tousLesProduitsBDD = getTousLesProduitsBDD();
    $listProduitBDDNonSupprimer = [];
    $listeProduitSupprime = [];

    // Garde seuelement les id qui ne sont pas supprimé
    foreach ($tousLesProduitsBDD as $produitBDD) {
        // Vérifie si le produit n'est pas supprimé
        if ($produitBDD['produit_supprime'] == false) {
            $listProduitBDDNonSupprimer[] = $produitBDD['id_produit'];
        }
    }

    // Supprime le produit du panier car il n'est plus présent
    foreach ($listeProduit as $produit) {
        if (!in_array($produit, $listProduitBDDNonSupprimer)) {
            supprimerProduitDesCookies($produit);
            $listeProduitSupprime[] = getNomProduit($produit);
        }
    }

    $listeRetournee['valides'] = $listeProduit;
    $listeRetournee['manquants'] = $listeProduitSupprime;

    return json_encode($listeRetournee);
}

function getPanierIDs()
{
    if (isset($_COOKIE['paner'])) {
        return (array) json_decode($_COOKIE['panier']);
    } else {
        return [];
    }
}

function getPanierArticles(Array $articlesIDs)
{
    return(getDBProduitsFromPanier($articlesIDs));
}