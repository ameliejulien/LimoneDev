<?php
require('./lib/repo/GlobalRepo.php');

/**
 * Lance une requete à la BDD
 * @param String $query requete à envoyer à la BDD
 * @return String[] Retourne le résultat de la requete
 */
function faireRequeteBDD(String $query) {
    $dbh = connecterBDD();

    $resultat[] = "";
    $requetePreparee = $dbh->prepare($query);

    foreach($dbh->query($requetePreparee) as $row) {
        $resultat[] = $row;
    }

    return $resultat;
}


?>