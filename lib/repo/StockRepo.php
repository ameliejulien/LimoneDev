<?php
    require_once('../../lib/repo/GlobalRepo.php');
    
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
        WHERE utilisateur.id_utilisateur = :idVendeur";

        $requeteStockPreparee = $connectBDD->prepare($query);
        $requeteStockPreparee -> bindValue(":idVendeur", $idVendeur);

        $requeteStockPreparee -> execute();
        $retour = $requeteStockPreparee->fetchAll();

        return $retour;
    }

    
    
    /**
     * Fait une MAJ des lignes modifiées dans le stock
     * @param array $lignesModifiees un tableau contenant les lignes modifiées
     * 
     * TODO : faire un try / catch et voir sil y n'y a pas des solutions moins coûteuses
     */
    function updateStockBDD($lignesModifiees) {
        $connectBDD = connecterBDD();
        $query = "UPDATE produit";
        
        foreach ($lignesModifiees as $ligne) {
            $query.=" SET stock_produit = :stock, catalogue_produit = :catalogue
            WHERE id_produit = :id";
        }

        $requeteStockUpdate = $connectBDD->prepare($query);

        foreach ($lignesModifiees as $ligne) {
            $requeteStockUpdate -> execute([
                ':stock' => $ligne['stock'],
                ':catalogue'=> $ligne['catalogue'],
                ':id' => $ligne['id'],
            ]); 
        }

    }



?>