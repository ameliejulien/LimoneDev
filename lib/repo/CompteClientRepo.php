<?php
function creerClientBdd($idClient)
{
    $connectBDD = connecterBDD();
    $requeteClient = "INSERT INTO limone.Client (id_client) VALUES (:id);";

    $requeteClientPreparee = $connectBDD->prepare($requeteClient);
    $requeteClientPreparee->bindValue(":id", $idClient);

    $requeteClientPreparee->execute();
}

/**
 * @Brief modifie le mot de passe client
 */
function modifierMdpClientBDD($mdp)
{
    $connectBDD = connecterBDD();
    $idClient = trouverIDUtilisateur($_COOKIE['uuid']);

    $requeteClient = "UPDATE Utilisateur SET mdp_utilisateur = '{$mdp}' WHERE id_utilisateur = '{$idClient}';";
    $requeteUpdateClient = $connectBDD->prepare($requeteClient);
    $requeteUpdateClient->execute();
}

/**
 * @Brief cherche l'existence d'un client via son email
 * @Param array un client sous forme de map 
 * @Return bool un booléen correspondant à l'existance du client
 */
function chercherClient($mail)
{
    $connectBDD = connecterBDD();
    // requête
    $requete =
        "SELECT 1 FROM limone.Utilisateur
        WHERE email_utilisateur = :mail";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":mail", $mail);
    $requetePreparee->execute();

    // résultat de la requête
    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

    return $row !== false;
}


/**
 * @Brief Envoie d'une requête dans la BDD pour récupérer les informations d'un client
 */
function trouverInfosClient($uuidClient)
{

    $connectBDD = connecterBDD();

    $requete =
        "SELECT 
            u.pp_utilisateur, 
            u.nom_utilisateur, 
            u.email_utilisateur, 
            u.telephone_utilisateur, 
            a.adresse, a.code_postal_adresse, 
            a.ville_adresse
        FROM limone.Utilisateur u 
        LEFT JOIN limone.Adresse_Client ac ON u.id_utilisateur = ac.id_utilisateur 
        LEFT JOIN limone.Adresse a ON ac.id_adresse = a.id_adresse
        WHERE u.uuid_utilisateur = :uuidClient;";

    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([':uuidClient' => $uuidClient]);
    $infosClient = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return $infosClient;
}


function getIdClient($client)
{
    $connectBDD = connecterBDD();

    $requete = "SELECT id_client FROM Client INNER JOIN Utilisateur " .
        "ON Utilisateur.id_utilisateur = Client.id_client " .
        "WHERE email_utilisateur = :mail;";

    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":mail", $client["mail"]);
    $requetePreparee->execute();
    $id = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return $id;

}

/**
 * Récupère l'ID de l'adresse d'un client
 */
function obtenirIdAdresseClient($connectBDD, $idClient)
{
    $requete = "SELECT ac.id_adresse FROM limone.Adresse_Client ac WHERE ac.id_utilisateur = :idClient";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([':idClient' => $idClient]);
    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return ($row && !empty($row['id_adresse'])) ? $row['id_adresse'] : null;
}

/**
 * Met à jour une adresse existante
 */
function mettreAJourAdresse($connectBDD, $idAdresse, $client)
{
    $requete = "UPDATE limone.Adresse 
                SET adresse = :adresse, ville_adresse = :ville, code_postal_adresse = :code 
                WHERE id_adresse = :idAdresse";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([
        ':adresse' => $client["adresse"],
        ':ville' => $client["ville_adresse"],
        ':code' => $client["code_postal_adresse"],
        ':idAdresse' => $idAdresse
    ]);
}

/**
 * Insère une nouvelle adresse et retourne son ID
 */
function insererAdresse($connectBDD, $client)
{
    $requete = "INSERT INTO limone.Adresse (adresse, ville_adresse, code_postal_adresse, facturation_adresse) 
                VALUES (:adresse, :ville, :code, false) RETURNING id_adresse";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([
        ':adresse' => $client["adresse"],
        ':ville' => $client["ville_adresse"],
        ':code' => $client["code_postal_adresse"]
    ]);
    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return $row['id_adresse'];
}

/**
 * Crée la liaison entre un client et une adresse
 */
function lierAdresseClient($connectBDD, $idClient, $idAdresse)
{
    $requete = "INSERT INTO limone.Adresse_Client (id_utilisateur, id_adresse) 
                VALUES (:idClient, :idAdresse)";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([
        ':idClient' => $idClient,
        ':idAdresse' => $idAdresse
    ]);
}

/**
 * Met à jour les infos utilisateur avec une nouvelle photo de profil
 */
function mettreAJourUtilisateurAvecPhoto($connectBDD, $idClient, $client, $fichierPhoto)
{
    $requete = "UPDATE limone.Utilisateur 
                SET nom_utilisateur = :nom, email_utilisateur = :email, telephone_utilisateur = :phone, pp_utilisateur = :pp
                WHERE id_utilisateur = :idClient";
    $requetePreparee = $connectBDD->prepare($requete);

    $imageFlux = fopen($fichierPhoto['tmp_name'], 'rb');

    $requetePreparee->bindValue(':nom', $client["nom_utilisateur"]);
    $requetePreparee->bindValue(':email', $client["email_utilisateur"]);
    $requetePreparee->bindValue(':phone', $client["telephone_utilisateur"]);
    $requetePreparee->bindValue(':idClient', $idClient);
    $requetePreparee->bindValue(':pp', $imageFlux, PDO::PARAM_LOB);

    $requetePreparee->execute();

    if (is_resource($imageFlux)) {
        fclose($imageFlux);
    }
}

/**
 * Met à jour les infos utilisateur sans changer la photo de profil
 */
function mettreAJourUtilisateurSansPhoto($connectBDD, $idClient, $client)
{
    $requete = "UPDATE limone.Utilisateur 
                SET nom_utilisateur = :nom, email_utilisateur = :email, telephone_utilisateur = :phone 
                WHERE id_utilisateur = :idClient";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->execute([
        ':nom' => $client["nom_utilisateur"],
        ':email' => $client["email_utilisateur"],
        ':phone' => $client["telephone_utilisateur"],
        ':idClient' => $idClient
    ]);
}

?>