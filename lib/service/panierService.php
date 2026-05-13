<?php
include './html/Produit/Produit.php';
include './connect_params.php';

class Panier
{
    private $listeProduit = [];
    private $utilisateurId;

    public function __construct(int $utilisateurId)
    {
        $this->utilisateurId = $utilisateurId;
    }

    /**
     * Prend en paramètre un produit déjà initialisé
     * @param int $produitId La variable produitId qui est à ajouter
     */
    public function ajouterProduit(int $produitId)
    {

        // todo finir la querry pour verifier si le produit est encore là
        $query = "SELECT * from ";

        // todo Requete bdd pour verifier si le produit est encoer dans la bdd   
        $res = null;

        if ($res == true) {
            // Save dans les cookies
            if ($_COOKIE['panier'] == null) { // cookie pas encore créé
                $this->listeProduit[] = $produitId;
            } else { // cookie créé
                $this->listeProduit = (array) json_decode($_COOKIE['panier']);
            }

            // Modifie la liste de produit dans le cookie
            setcookie('panier', json_encode($this->listeProduit));

            // Save dans la BDD
            /*
            if ($userId != null) {
                $quantite = 0;
                foreach ($listeProduit as $produitDansList) {
                    if ($produitId == $produitDansList) {
                        $quantite++;
                    }
                }

                // Préparation de la query pour ajout à la bdd
                $query = "INSERT INTO Panier (product_id, user_id, quantity) VALUES($produitId, $this->utilisateurId, $quantite)";
            }
            */
        }
    }

    /**
     * Supprimer un produit du panier et du cookie
     * @param int $produitId id du produit à supprimer
     */
    public function supprimerPanier(int $produitId)
    {
        if ($_COOKIE['panier'] != null) {
            $this->listeProduit = (array) json_decode($_COOKIE['panier']);

            // Passe à traver toutes valeurs de la liste de produit et supprime ceux qui sont égale au produit id
            for ($i = 0; $i < sizeof($this->listeProduit); $i++) {
                if ($this->listeProduit[$i] == $produitId) {
                    unset($this->listeProduit[$i]);
                }
            }

            // Sauvegarde le cookie avec le produit supprimer
            setcookie('panier', json_encode($this->listeProduit));
        }
    }
}
