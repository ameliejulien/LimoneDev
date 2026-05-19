<?php
include '../../html/Produit/Produit.php';
include './connect_params.php';

$listeProduit = [];
$utilisateurId = null;

/**
 * Prend en paramètre un produit déjà initialisé
 * @param int $produitId La variable produitId qui est à ajouter
 */
function ajouterProduit(int $produitId)
{
    // todo verifier si l'article existe
    $res = true;

    if ($res == true) {
        // Save dans les cookies
        if ($_COOKIE['panier'] == null) { // cookie pas encore créé
            $listeProduit[] = $produitId;
        } else { // cookie créé
            $listeProduit = (array) json_decode($_COOKIE['panier']);
        }

        // Modifie la liste de produit dans le cookie
        setcookie('panier', json_encode($listeProduit));
    }
}

/**
 * Supprimer un produit du panier et du cookie
 * @param int $produitId id du produit à supprimer
 */
function supprimerProduit(int $produitId)
{
    if ($_COOKIE['panier'] != null) {
        $listeProduit = (array) json_decode($_COOKIE['panier']);

        // Passe à traver toutes valeurs de la liste de produit et supprime ceux qui sont égale au produit id
        for ($i = 0; $i < sizeof($listeProduit); $i++) {
            if ($listeProduit[$i] == $produitId) {
                unset($listeProduit[$i]);
            }
        }

        // Sauvegarde le cookie avec le produit supprimer
        setcookie('panier', json_encode($listeProduit));
    }
}

/**
 * Valide le panier, verifie tous les produits pour voir si tous les produits du panier sont encore dans la BDD et sépare les valides des invalides.
 * @return JSON retourne un JSON de fromat : {"valide":["id_1", "id_2", ..."], "manquants":["id_1", ...]}
 */
function validerPanier()
{
    $listeProduit = json_decode($_COOKIE['panier']);

    // Recupére la table des produits pour vérifier si tous les produits du panier sont présent dans la BDD
    $query = "SELECT id_produit, produit_supprime FROM Produit";
    // Todo récup le tableau d'id produit 
    $produitBDD = [];
    $listProduitBDDNonSupprimer = [];

    // Garde seuelement les id qui ne sont pas supprimer
    foreach ($produitBDD as $valueBDD) {
        // Vérifie si le produit n'est pas supprimé
        if ($valueBDD['produit_supprime'] == false) {
            $listProduitBDDNonSupprimer = $valueBDD['id_produit'];
        }
    }

    $listeProduitSupprime = [];

    foreach ($listeProduit as $produit) {
        if (!in_array($produit, $listProduitBDDNonSupprimer)) {
            // Supprime le produit du panier car il n'est plus présent
            supprimerProduit($produit);
            $listeProduitSupprime = $produit;
        }
    }

    $listeRetournee['valides'] = $listeProduit;
    $listeRetournee['manquants'] = "$listeProduitSupprime";

    return json_encode($listeRetournee);
}

function getPanier()
{
    return json_decode($_COOKIE['panier']);
}