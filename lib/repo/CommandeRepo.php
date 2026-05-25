<?php
require_once('../../lib/repo/GlobalRepo.php');

/**
 * Enregistre une commade dans la BDD
 * @return int Id de la commande qui vient d'etre faite
 */
function enregistrerCommande() {
    $query = "INSERT INTO Commande(id_suivi_livraison) VALUES ('012356789ABCDE') RETURNING id_commande";

    $dbh = connecterBDD();
    $stmt = $dbh->prepare($query);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)["id_commande"];
}

function enreigstrerLigneCommande(float $commandeId, 
                                  String $produitId, 
                                  String $nomProduit, 
                                  int $quantite, 
                                  int $prixHt, 
                                  int $TVA) {

    $query = "INSERT INTO Ligne_Commande(id_commande, 
                                         id_produit_commande, 
                                         nom_produit, 
                                         quantite, 
                                         prix_ht_commande, 
                                         tva_commande)
    VALUES (:commandeId,
            :produitId, 
            :nomProduit, 
            :quantite, 
            :prixHt, 
            :TVA)
    RETURNING id_commande";

    $dbh = connecterBDD();
    $stmt = $dbh->prepare($query);

    $stmt->bindValue(":commandeId", (int) $commandeId);
    $stmt->bindValue(":produitId", $produitId);
    $stmt->bindValue(":nomProduit", $nomProduit);
    $stmt->bindValue(":quantite", $quantite);
    $stmt->bindValue(":prixHt", $prixHt);
    $stmt->bindValue(":TVA", $TVA);

    $stmt->execute();
}

?>