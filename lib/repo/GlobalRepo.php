<?php 

/**
 * Créer une connection à la basse de donnée via PDO
 * @return PDO Retourne la connection à la BDD
 */
function connecterBDD(): PDO {
    include('connect_params.php');

    try {
        static $dbh = null;

        if ($dbh === null) {
            $dbh = new PDO("$driver:host=$server;dbname=$dbName", $dbUser, $dbPassword);
        }

        return $dbh;
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage() . "<br/>";
        die();
    }
}

/**
 * Permet d'envoyer une requete à la base de donner en lui indiquant la table à affecter
 * @param String $query requete à envoyer à la BDD
 * @return String[] Retourne le résultat de la requete
 */
function faireRequeteBDD(String $query) {
    $dbh = connecterBDD();

    $resultat[] = "";

    // Évite les injections SQL
    $requetePreparee = $dbh->prepare($query);

    foreach($dbh->query($requetePreparee) as $row) {
        $resultat[] = $row;
    }

    return $resultat;
}

?>