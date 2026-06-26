<?php
require_once('../../lib/repo/GlobalRepo.php');

/**
 * Enregistre une commade dans la BDD
 * @param float $montantTtc Montant totale de la commande
 * @param int $etat Etat de la commande
 * @return int Id de la commande qui vient d'etre faite
 */
function enregistrerCommande(float $montantTtc, $etat): int {
    $query = "INSERT INTO Commande(id_suivi_livraison, etat, montant_ttc, paiement_ok)
              VALUES (:suivi, :etat, :montant, true) RETURNING id_commande";

    $dbh = connecterBDD();
    $stmt = $dbh->prepare($query);

    // Mock une valeur de suivi
    $stmt->bindValue(":suivi", bin2hex(random_bytes(7)));
    $stmt->bindValue(":etat", $etat, PDO::PARAM_INT);
    $stmt->bindValue(":montant", $montantTtc);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)["id_commande"];
}

function enreigstrerLigneCommande(int $commandeId, 
                                  String $produitId, 
                                  String $nomProduit, 
                                  float $quantite, 
                                  float $prixHt, 
                                  float $TVA) {

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

    $stmt->bindValue(":commandeId", $commandeId);
    $stmt->bindValue(":produitId", $produitId);
    $stmt->bindValue(":nomProduit", $nomProduit);
    $stmt->bindValue(":quantite", $quantite);
    $stmt->bindValue(":prixHt", $prixHt);
    $stmt->bindValue(":TVA", $TVA);

    $stmt->execute();
}

function decrementerStockProduit(string $produitId, int $quantite) {
    $query = "UPDATE Produit
              SET stock_produit = stock_produit - :qte, nb_ventes_produit = nb_ventes_produit + :qte
              WHERE id_produit = :id_produit AND stock_produit >= :qte";

    try {
        $dbh = connecterBDD();
        $stmt = $dbh->prepare($query);

        $stmt->bindValue(":qte", $quantite, PDO::PARAM_INT);
        $stmt->bindValue(":id_produit", $produitId);

        $stmt->execute();

        return $stmt->rowCount() !== 0;

    } catch (Exception $e) {
        throw new RuntimeException("Stock insuffisant produit $produitId");
    }
    
}

?>