<?php
require_once "GlobalRepo.php";
require_once __DIR__ . '/../Constantes.php';

function trouverUUID($mail)
{
    $connectBDD = connecterBDD();
    // requête
    $requete =
        "SELECT utilisateur.uuid_utilisateur FROM limone.utilisateur
        WHERE utilisateur.email_utilisateur = :mail";

    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":mail", $mail);
    $requetePreparee->execute();

    // résultat de la requête
    $utilisateur = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    if (is_array($utilisateur)) {
        return $utilisateur['uuid_utilisateur'];
    } else {
        return HTTP_ERR_GENERIQUE;
    }
}

function creerUtilisateurBdd($client)
{
    $connectBDD = connecterBDD();
    $requeteUtilisateur =
        "INSERT INTO limone.Utilisateur 
        (email_utilisateur, nom_utilisateur, mdp_utilisateur, type_utilisateur, telephone_utilisateur)
        VALUES 
        (:mail, :nomUtilisateur,:motDePasse,'1', :telephone) 
        RETURNING id_utilisateur;";

    $requetePreparee = $connectBDD->prepare($requeteUtilisateur);

    // binding des valeurs
    $requetePreparee->bindValue(":mail", $client["mail"]);
    $requetePreparee->bindValue(":nomUtilisateur", $client["nomUtilisateur"]);
    $requetePreparee->bindValue(":motDePasse", $client["motDePasse"]);
    $requetePreparee->bindValue(":telephone", $client["telephone"]);
    $requetePreparee->execute();

    return $requetePreparee->fetch(PDO::FETCH_ASSOC)['id_utilisateur'];
}

function trouverInfosUtilisateur($uuid)
{
    $connectBDD = connecterBDD();
    $requete =
        "SELECT 
            utilisateur.nom_utilisateur,
            utilisateur.email_utilisateur,
            utilisateur.telephone_utilisateur,
            utilisateur.type_utilisateur
        FROM utilisateur
        WHERE uuid_utilisateur = :id";

    $prepare = $connectBDD->prepare($requete);
    $prepare->bindValue(":id", $uuid);
    $prepare->execute();

    return $prepare->fetch(PDO::FETCH_ASSOC);
}

function trouverIDUtilisateur($uuid)
{
    $connectBDD = connecterBDD();
    $requete =
        "SELECT 
            utilisateur.id_utilisateur
        FROM utilisateur
        WHERE uuid_utilisateur = :id";

    $prepare = $connectBDD->prepare($requete);
    $prepare->bindValue(":id", $uuid);
    $prepare->execute();

    return $prepare->fetch(PDO::FETCH_ASSOC)['id_utilisateur'];
}

function trouverTypeUtilisateur($uuid)
{
    $connectBDD = connecterBDD();
    $requete =
        "SELECT utilisateur.type_utilisateur
        FROM utilisateur
        WHERE uuid_utilisateur = :id";

    $prepare = $connectBDD->prepare($requete);
    $prepare->bindValue(":id", $uuid);
    $prepare->execute();

    return $prepare->fetch(PDO::FETCH_ASSOC);
}

function getMdpHashFromMail($mail)
{
    $conn = connecterBDD();
    $req = "select utilisateur.mdp_utilisateur, utilisateur.email_utilisateur from utilisateur where email_utilisateur = :email";

    $prep = $conn->prepare($req);
    $prep->bindValue(":email", $mail);
    $prep->execute();
    $res = $prep->fetch(PDO::FETCH_ASSOC);
    file_put_contents("/tmp/debug.log", print_r($res, true) . "\n", FILE_APPEND);
    if($res) {
        return $res["mdp_utilisateur"];
    }
}

function getMdpHashFromUUID($uuid)
{
    $conn = connecterBDD();
    $req = "select utilisateur.mdp_utilisateur from utilisateur where uuid_utilisateur = :uuid";

    $prep = $conn->prepare($req);
    $prep->bindValue(":uuid", $uuid);
    $prep->execute();
    $res = $prep->fetch(PDO::FETCH_ASSOC);
    return $res["mdp_utilisateur"];
}
?>