<?php
require('./lib/repo/GlobalRepo.php');

function enregistrerFacture(String $name, String $email, String $telephone, String $adresse, String $adressFacturation, String $codePostal, String $ville) {
    $query = "INSERT INTO limone.Facture(nom_client_facture, email_facture, telephone_facture, adresse_facture, adresse_facturation_facture, code_postal_facture, ville_facture)
    VALUE ($name, $email, $telephone, $adresse, $adressFacturation, $codePostal, $ville)";

    faireRequeteBDD($query);
}

?>