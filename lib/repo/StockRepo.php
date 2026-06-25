<?php
    require_once('../../lib/repo/GlobalRepo.php');
    require_once(__DIR__ . '../Constantes.php');
    
    /**
     * Fonction qui retourne les produits d'un vendeur (en fonction de l'idVendeur)
     * @param int $idVendeur un vendeur
     * @return array un tableau avec les produits de ce vendeur
     */
    function getStockBdd($idVendeur) {
    
        $connectBDD = connecterBDD();

        $query=
        "SELECT produit.id_produit, produit.nom_produit, produit.stock_produit, produit.catalogue_produit, produit.vendeur_produit, photo_produit.photo_produit
        FROM produit
        LEFT JOIN photo_produit ON produit.id_produit = photo_produit.id_produit AND photo_produit.photo_principale = TRUE
        INNER JOIN utilisateur ON produit.vendeur_produit = utilisateur.id_utilisateur 
        WHERE utilisateur.id_utilisateur = :idVendeur
        AND produit.produit_supprime = FALSE";

        $requeteStockPreparee = $connectBDD->prepare($query);
        $requeteStockPreparee -> bindValue(":idVendeur", $idVendeur);

        $requeteStockPreparee -> execute();
        $retour = $requeteStockPreparee->fetchAll();

        return $retour;
    }

    
    
    /**
     * Fait une MAJ des lignes modifiées dans le stock
     * @param array $lignesModifiees un tableau contenant les lignes modifiées
     * @return int un code d'erreur indiquant la réussite ou l'échec de l'opération
     */
    function updateStockBDD($lignesModifiees) {
        $connectBDD = connecterBDD();
        $query = "UPDATE produit SET stock_produit = :stock, catalogue_produit = :catalogue
            WHERE id_produit = :id";
        $requeteStockUpdate = $connectBDD->prepare($query);

        try {

        
            foreach ($lignesModifiees as $ligne) {
                $requeteStockUpdate -> execute([
                    ':stock' => $ligne['stock'],
                    ':catalogue'=> $ligne['catalogue'],
                    ':id' => $ligne['id'],
                ]); 
                
            }
        return HTTP_OK;
        } catch (PDOException $e) {
            return $e->getCode();
        }
        
    }



    function deleteProduitBDD($idProduit) {
                $connectBDD = connecterBDD();
        $query = "UPDATE produit SET catalogue_produit = FALSE, produit_supprime = TRUE
            WHERE id_produit = :id";
        $requeteDelete = $connectBDD->prepare($query);

        try {
            $requeteDelete -> execute([":id" => $idProduit]);
            return HTTP_OK;
        } catch (PDOException $e) {
            return $e->getCode();
        }
    }

?>