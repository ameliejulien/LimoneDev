<?php
function enregistrerAchat(String $commandeId, String $produitId, String $factureId, $clientId = null) {

    if ($clientId !== null) {
        $query = 
        "INSERT INTO Achat(id_commande, 
                           id_produit, 
                           id_facture, 
                           id_client)
        VALUES (:commandeId, 
                :produitId, 
                :factureId, 
                :clientId);";

        $dbh = connecterBDD();
        $stmt = $dbh->prepare($query);

        $stmt->bindValue(":commandeId", $commandeId);
        $stmt->bindValue(":produitId", $produitId);
        $stmt->bindValue(":factureId", $factureId);
        $stmt->bindValue(":clientId", $clientId);

        
    } else {
        $query = 
        "INSERT INTO Achat(id_commande, 
                           id_produit, 
                           id_facture)
        VALUES (:commandeId, 
                :produitId, 
                :factureId);";

        $dbh = connecterBDD();
        $stmt = $dbh->prepare($query);

        $stmt->bindValue(":commandeId", $commandeId);
        $stmt->bindValue(":produitId", $produitId);
        $stmt->bindValue(":factureId", $factureId);
    }
    
    $stmt->execute();

}
?>