<?php 

/**
 * Créer une connection à la basse de donnée via PDO
 * @return PDO Retourne la connection à la BDD
 */
function connecterBDD(): PDO {
    require __DIR__ . '/../../connect_params.php';

    try {
        static $dbh = null;

        if ($dbh === null) {
            $dbh = new PDO("$driver:host=$server;port=$port;dbname=$dbName", $dbUser, $dbPassword);
            $dbh->exec("SET SCHEMA 'limone';");
        }

        return $dbh;
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage() . "<br/>";
        die();
    }
}

?>