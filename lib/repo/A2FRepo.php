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

function getSecretParMail($mail) {
    $PDO = connecterBDD();

    $query =
    "SELECT secret_utilisateur
    FROM utilisateur
    WHERE email_utilisateur = ?";

    $prepare = $PDO->prepare($query);
    $prepare->execute([$mail]);

    $res = $prepare->fetch(PDO::FETCH_ASSOC);

    return $res ? $res['secret_utilisateur'] : null;
}

function getSecretParUUID($uuid) {
    $PDO = connecterBDD();

    $query =
    "SELECT secret_utilisateur
    FROM utilisateur
    WHERE uuid_utilisateur = ?";

    $prepare = $PDO->prepare($query);
    $prepare->execute([$uuid]);

    $res = $prepare->fetch(PDO::FETCH_ASSOC);

    return $res ? $res['secret_utilisateur'] : null;
}
?>