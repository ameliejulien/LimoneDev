<?php

require_once __DIR__ . '/../../connect_params.php';
require_once __DIR__ . '/../repo/CompteClientRepo.php';
require_once __DIR__ . '/../repo/UtilisateurRepo.php';
require_once __DIR__ . '/../Constantes.php';

/**
 * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription, cette fonction redirige vers la page de connexion
 * @Return int Le code de retour
 */
function confimerInscription($client)
{
    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        if (!preg_match("/[a-zA-Z0-9_-]+$/", $client['nomUtilisateur'])) {
            throw new Exception(code: HTTP_USERNAME_INVALIDE);
        }

        if (!filter_var($client['mail'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception(code: HTTP_EMAIL_INVALIDE);
        }

        if ($client['motDePasse'] !== $client['confMotDePasse']) {
            throw new Exception(code: HTTP_MDP_CONFIRM_DIFF);
        }

        if (!preg_match("/0[1-9](?: [0-9]{2}){4}/", $client['telephone']) && !preg_match("/0[1-9](?:[0-9]{2}){4}/", $client['telephone'])) {
            throw new Exception(code: HTTP_TEL_INVALIDE);
        }

        error_log("utilisateur existe pas déjà");
        $client["motDePasse"] = password_hash($client['motDePasse'], PASSWORD_DEFAULT);

        if (!chercherClient($client['mail'])) {
            $idUtilisateur = creerUtilisateurBdd($client);
            creerClientBdd($idUtilisateur);
        } else {
            $dbh->rollBack();
            return HTTP_EMAIL_EXISTANT;
        }
        $dbh->commit();
        return HTTP_OK;
    } catch (Exception $e) {
        $dbh->rollBack();
        return HTTP_ERR_GENERIQUE;
    }
}

/**
 * @Brief Récupérer les informations du client connecté
 * @Return array | null Un tableau avec les informations du client connecté ou null si pas de cookie
 */
function recupererInfosClient($uuid)
{
    return trouverInfosClient($uuid);
}

/**
 * @Brief modfie le mot de passe Client
 */
function modificationMdpClient($data, $idClient)
{
    $mdpCourant = $data["mdpCourant"];
    $nouveauMdp = $data["nouveauMdp"];
    $confNouveauMdp = $data["confNouveauMdp"];

    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        file_put_contents('/tmp/debug.log', print_r([$mdpCourant, $nouveauMdp, $confNouveauMdp, getMdpHashFromUUID($_COOKIE['uuid']), password_verify($mdpCourant, getMdpHashFromUUID($_COOKIE['uuid'])) ? "true" : "false"], true) . "\n", FILE_APPEND);

        if (password_verify($mdpCourant, getMdpHashFromUUID($_COOKIE['uuid']))) {
            // Les deux nouveaux mots de passe ne correspondent pas
            if ($nouveauMdp !== $confNouveauMdp) {
                return 401;
            }

            // Le nouveau mot de passe est identique à l'ancien
            if ($mdpCourant === $nouveauMdp) {
                return 409;
            }

            // Tout est valide → on met à jour
            modifierMdpClientBDD(password_hash($nouveauMdp, PASSWORD_DEFAULT), $idClient);
        } else {
            $dbh->rollBack();
            return 400;
        }
        $dbh->commit();
        return HTTP_OK;
    } catch (Exception $e) {
        $dbh->rollBack();
        return 400;
    }
}

/**
 * @Brief Changer ou ajouter les informations du client
 */
function modifierClientBDD($client, $files = [])
{
    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        $idClient = trouverIDUtilisateur($_COOKIE['uuid']);
        $connectBDD = connecterBDD();

        // adress e: mise à jour ou création + liaison
        $idAdresse = obtenirIdAdresseClient($connectBDD, $idClient);
        if ($idAdresse !== null) {
            mettreAJourAdresse($connectBDD, $idAdresse, $client);
        } else {
            $idAdresse = insererAdresse($connectBDD, $client);
            lierAdresseClient($connectBDD, $idClient, $idAdresse);
        }

        // utilisateur : avec ou sans nouvelle photo
        if (isset($files['picture']) && $files['picture']['error'] == UPLOAD_ERR_OK) {
            mettreAJourUtilisateurAvecPhoto($connectBDD, $idClient, $client, $files['picture']);
        } else {
            mettreAJourUtilisateurSansPhoto($connectBDD, $idClient, $client);
        }

        $dbh->commit();

    } catch (Exception $e) {
        $dbh->rollBack();
        return 500;
    }

    return HTTP_OK;
}

?>