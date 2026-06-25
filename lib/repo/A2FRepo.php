<?php
require_once __DIR__ . '/GlobalRepo.php';

function mettreSecretBDD($id, $secret) {
    $PDO = connecterBDD();

    $query = 
    "UPDATE utilisateur
    SET secret_utilisateur = ?
    WHERE id_utilisateur = ?";

    $prepare = $PDO->prepare($query);

    $prepare->execute([$secret, $id]);
}
?>