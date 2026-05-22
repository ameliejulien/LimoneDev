<?php

include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/CompteClientRepo.php';

/**
 * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
 * cette fonction redirige vers la page de connexion
 * @Return Object Un object Client en base de données
 */
function confimerInscription($client)
{
    // Transformation champs formulaires
    $client["mail"] = strtolower($client["mail"]);
    $mdp = $client["motDePasse"];
    $confMdp = $client["confMotDePasse"];
    $client["motDePasse"] = hash('sha256', $client["motDePasse"]);
    $codeRetour = 0;

    // Comparaison des mots de passe
    $mdpEgaux = ($mdp == $confMdp);

    if ($mdpEgaux && !champVide($client)) {
        $codeRetour = creerClientBdd($client);

    } else {
        $codeRetour = 400;
    }
    return $codeRetour;
}

/**
 * @Brief regarde si une des valeurs saisie est vide
 * @Param une instance de la classe client
 * @Return bool Un booléen confirmant si un des champs est vide
 */
function champVide($client)
{
    foreach ($client as $value) {
        if (empty($value)) {
            return true;
        }
    }
    return false;
}

/**
 * @Brief renvoie une requête dans la BDD pour vérifier si le client peut se connecter
 * @Param une map avec les valeurs du formulaire
 * @Return int code de réussite ou d'erreur (200 ou 400)
 */
function connexionClient($client)
{
    $client["mail"] = strtolower($client["mail"]);
    $client["motDePasse"] = hash('sha256', $client["motDePasse"]);
    $retour = connecterClient($client);

    if ($retour == false) {
        $codeRetour = 400;
    } else {
        $codeRetour = 200;
    }

    return $codeRetour;
}


/**
 * @Brief Récupérer les informations du client connecté
 * @Return Object Un tableau avec les informations du client connecté
 */
function recupererInfosClient()
{
    // // Vérifier l'existence du cookie
    // if (!isset($_COOKIE['client']) || empty($_COOKIE['client'])) {
    //     throw new Exception("Client non authentifié");
    // }

    // $client = json_decode($_COOKIE['client'], true);
    
    // // Vérifier que l'ID client existe
    // // if (!isset($client['idClient']) || empty($client['idClient'])) {
    // //     throw new Exception("ID client invalide");
    // // }

    // $idClient = $client["idClient"];

    // $infos = trouverInfosClient($idClient);
    // // return $infos;

    $idClient = null;

    if ($_COOKIE['utilisateur'] != null) { // cookie déjà créé
        $client = json_decode($_COOKIE['utilisateur'], true);
    }
    $idClient = $client["idUtilisateur"];

    $infos = trouverInfosClient($idClient);
    return $infos;
}


/**
 * @Brief création d'un cookie client à la connexion
 */
function ajouterClientCookie($client)
{
    if (isset($_COOKIE['utilisateur'])) { // cookie déjà créé
        $client = json_decode($_COOKIE['utilisateur'], true);
    }

    $id = getIdClient($client);

    $tab["mail"] = $client["mail"];
    $tab["idClient"] = $id["idUtilisateur"];

    // Modifie la liste de produit dans le cookie
    setcookie('client', json_encode($tab), time() + 32460 * 60, "/");
}

/**
 * @Brief modfie le mot de passe Client
 */
function modificationMdpClient($data)
{
    $mdpCourant = hash('sha256', $data["mdpCourant"]);
    $nouveauMdp = hash('sha256', $data["nouveauMdp"]);
    $confNouveauMdp = hash('sha256', $data["confNouveauMdp"]);

    // Les deux nouveaux mots de passe ne correspondent pas
    if ($nouveauMdp !== $confNouveauMdp) {
        return 401;
    }

    // Le nouveau mot de passe est identique à l'ancien
    if ($mdpCourant === $nouveauMdp) {
        return 409;
    }

    // Tout est valide → on met à jour
    modifierMdpClientBDD($nouveauMdp);
    return 200;
}


/**
 * @Brief supprime le cookie client pour le déconnecter
 * @Return bool retourne un booléen confirmant ou non la suppression du cookie
 */
function deconnecterClient()
{
    setcookie("utilisateur", "", time() - 1, "/");
    unset($_COOKIE["utilisateur"]);

    if (!isset($_COOKIE["utilisateur"])) {
        return 200;
    }
    return 400;
}

/**
 * @Brief modifie le mot de passe client
 */
function modifierMdpClientBDD($mdp)
{
    $connectBDD = connecterBDD();
    $idClient = json_decode($_COOKIE['utilisateur'], true)['idUtilisateur'];

    $requeteClient = "UPDATE Utilisateur SET mdp_utilisateur = '{$mdp}' WHERE id_utilisateur = '{$idClient}';";
    $requeteUpdateClient = $connectBDD->prepare($requeteClient);
    $rowClient = $requeteUpdateClient->execute();
}

/**
 * @Brief Récupère l'ID du client connecté depuis le cookie
 */
function obtenirIdClientConnecte()
{
    if (isset($_COOKIE['utilisateur']) && $_COOKIE['utilisateur'] != null) { 
        $client = json_decode($_COOKIE['utilisateur'], true);
        return $client["idUtilisateur"] ?? null;
    }
    return null;
}

?>