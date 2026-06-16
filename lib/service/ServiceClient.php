<?php

include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/CompteClientRepo.php';
include __DIR__ . '/../repo/UtilisateurRepo.php';

function fix_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

/**
 * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription, cette fonction redirige vers la page de connexion
 * @Return int Le code de retour
 */
function confimerInscription($client) {
    try {
        if (!preg_match("/[a-zA-Z0-9_-]+$/", $client['nomUtilisateur'])) {
            throw new Exception();
        }
            
        if (!filter_var($client['mail'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception();
        }
    
        if ($client['motDePasse'] !== $client['confMotDePasse']) {
            throw new Exception();
        }
        
        if (!preg_match("/0[1-9](?: [0-9]{2}){4}/", $client['telephone']) && !preg_match("/0[1-9](?:[0-9]{2}){4}/", $client['telephone'])) {
            throw new Exception();
        }
                
        $client["motDePasse"] = hash('sha256', $client['motDePasse']);

        if (!chercherClient($client['mail'])) {
            $idUtilisateur = creerUtilisateurBdd($client);
            creerClientBdd($idUtilisateur);
        } else {
            return 409;
        }
    } catch (Exception $e) {
        return 500;
    } 

    return 201;
}

/**
 * @Brief regarde si une des valeurs saisie est vide
 * @Param Array
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
 * @Brief Récupérer les informations du client connecté
 * @Return array | null Un tableau avec les informations du client connecté ou null si pas de cookie
 */
function recupererInfosClient($uuid) {
    return trouverInfosClient($uuid);
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

?>