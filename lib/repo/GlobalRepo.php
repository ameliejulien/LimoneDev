<?php 

/**
 * Créer une connection à la basse de donnée via PDO
 * @return PDO Retourne la connection à la BDD
 */
function connecterBDD() {
    include('connect_params.php');

    try {
        $dbh = new PDO("$driver:host=$server;dbname=$dbName", $dbUser, $dbPassword);
        return $dbh;
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage() . "<br/>";
        die();
    }
}

?>