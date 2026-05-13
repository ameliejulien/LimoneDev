<?php
include './html/Produit/Produit.php';
include './connect_params.php';

class Panier { 
    private $listeProduit = [];
    private $userId;

    public function __construct(int $userId) {
        $this->userId = $userId;
    }

    /**
     * Prend en paramètre un produit déjà initialisé
     * @param Produit $produit La variable Produit qui a permis de remplir la page produit detaillée
     */
    public function ajouterProduit(Produit $produit, $userId = null) {
        $productId = $produit->getProduitId();

        // todo finir la querry pour verifier si le produit est encore là
        $query="SELECT * from ";

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
}
?>