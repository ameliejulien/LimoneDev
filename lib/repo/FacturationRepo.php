<?php
require_once('../../lib/repo/GlobalRepo.php');

function enregistrerFacture(String $nom, 
                            String $email, 
                            String $telephone, 
                            String $ville,
                            String $adresse, 
                            String $codePostal, 
                            String $villeFacturation,
                            String $adressePostalFacturation,
                            String $codePostalFacturation) {
    $query = 
    "INSERT INTO Facture(nom_client_facture, 
                         email_client_facture, 
                         telephone_client_facture, 
                         ville_client_facture, 
                         adresse_client_facture, 
                         code_postal_client_facture, 
                         ville_facturation_client_facture,
                         adresse_facturation_client_facture,
                         code_postal_facturation_client_facture)
    VALUES (:nom, 
            :email, 
            :telephone, 
            :ville,
            :adresse, 
            :codePostal,
            :villeFacturation,
            :adresseFacturation,
            :codePostalFacturation)
    RETURNING id_facture";

    $dbh = connecterBDD();
    $stmt = $dbh->prepare($query);

    $stmt->bindValue(":nom", $nom);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":telephone", $telephone);
    $stmt->bindValue(":ville", $ville);
    $stmt->bindValue(":adresse", $adresse);
    $stmt->bindValue(":codePostal", $codePostal);
    $stmt->bindValue(":villeFacturation", $villeFacturation);
    $stmt->bindValue(":adresseFacturation", $adressePostalFacturation);
    $stmt->bindValue(":codePostalFacturation", $codePostalFacturation);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC)['id_facture'];
}

?>