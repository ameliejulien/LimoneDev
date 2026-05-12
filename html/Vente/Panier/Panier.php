<?php

include './html/Produit/Produit.php';
include './connect_params.php';

class Panier {
    private $listeProduit = [];

    /**
     * Prend en paramètre un produit déjà initialisé
     * @param Produit $produit La variable Produit qui a permis de remplir la page produit detaillée
     */
    public function ajouterProduit(Produit $produit) {

        $query="";

        if (null) {
            $listeProduit = $produit;
        }
    }

    
}


?>