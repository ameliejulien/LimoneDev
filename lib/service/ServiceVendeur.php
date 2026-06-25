<?php

include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/CompteVendeurRepo.php';
require_once __DIR__ . '/../../lib/Constantes.php';

/**
 * @brief modifie ou ajoute des informations d'un vendeur
 */
function modifierVendeurBDD($vendeur)
{
    try {
        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);
        $connectBDD = connecterBDD();

        $idAdresse = obtenirIdAdresseVendeur($connectBDD, $idVendeur);
        mettreAJourAdresseVendeur($connectBDD, $idAdresse, $vendeur);
        mettreAJourUtilisateurVendeur($connectBDD, $idVendeur, $vendeur);
        mettreAJourVendeur($connectBDD, $idVendeur, $vendeur);

    } catch (Exception $e) {
        return HTTP_ERR_GENERIQUE;
    }

    return HTTP_OK;
}

/**
 * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
 * cette fonction redirige vers la page de connexion
 * @Return int
 */
function confimerInscription($vendeur)
{
    try {
        $mail = strtolower($vendeur["mail"]);
        $denomination = $vendeur["denomination"];
        $tel = $vendeur["telephone"];
        $mdp = $vendeur["motDePasse"];
        $confMdp = $vendeur["confMotDePasse"];
        $codePostal = $vendeur["codePostalVendeur"];
        $ville = $vendeur["villeVendeur"];
        $adresse = $vendeur["adresseVendeur"];
        $siret = $vendeur["siret"];

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception(code: HTTP_EMAIL_INVALIDE);
        }

        if (!preg_match("/[ a-zA-Z'.,;:!\(\)]+/", $denomination)) {
            throw new Exception(code: HTTP_DENOMINATION_INVALIDE);
        }

        if (!preg_match("/0[1-9](?:[0-9]{2}){4}/", $tel)) {
            throw new Exception(code: HTTP_TEL_INVALIDE);
        }

        if ($mdp != $confMdp) {
            throw new Exception(code: HTTP_MDP_CONFIRM_DIFF);
        }

        if (password_verify($mdp, getMdpHashFromMail($mail))) {
            throw new Exception(code: HTTP_MDP_IDENTIQUE);
        }

        $vendeur["motDePasse"] = password_hash($vendeur["motDePasse"], PASSWORD_DEFAULT);

        if (!preg_match("/[0-9]{5}/", $codePostal)) {
            throw new Exception(code: HTTP_CODE_POSTAL_INVALIDE);
        }

        if (!preg_match("/[ -a-zA-Z'.,\/]+/", $ville)) {
            throw new Exception(code: HTTP_VILLE_INVALIDE);
        }

        if (!preg_match("/[ -a-zA-Z'.,\/]+/", $adresse)) {
            throw new Exception(code: HTTP_ADRESSE_INVALIDE);
        }

        if (!preg_match("/[0-9]{14}/", $siret)) {
            throw new Exception(code: HTTP_SIRET_INVALIDE);
        }

        if (!certifiercle($vendeur["cleAuth"])) {
            throw new Exception(code: HTTP_CLE_AUTH_INVALIDE);
        }

        return creerVendeurBdd($vendeur);
    } catch (Exception $e) {
        return $e->getCode();
    }
}

/**
 * @Brief regarde si une des valeurs saisie est vide
 * @Param Array instance de la classe client
 * @Return bool booléen confirmant si un des champs est vide
 */
function champVide($vendeur)
{
    foreach ($vendeur as $v) {
        if (empty($v)) {
            return true;
        }
    }
    return false;
}

/**
 * @Brief renvoie une requête dans la BDD pour vérifier si le client peut se connecter
 * @Param array map avec les valeurs du formulaire
 * @Retuns un code de réussite ou d'erreur (HTTP_OK ou 400)
 */
function connexionVendeur($vendeur)
{
    $vendeur["mail"] = strtolower($vendeur["mail"]);
    $vendeur["motDePasse"] = password_hash($vendeur["motDePasse"], PASSWORD_DEFAULT);
    $retour = connecterVendeur($vendeur);

    if ($retour == false) {
        $codeRetour = HTTP_ERR_GENERIQUE;
    } else {
        $codeRetour = HTTP_OK;
    }

    return $codeRetour;
}

/**
 * @Brief transfère le retour de la requête de vérification du vendeur 
 * @Param la clée à certifier
 * @Retuns un booléen déterminant la certification de la clée
 */
function certifiercle($cle)
{
    return certifiercleBDD($cle);
}

/**
 * @Brief génère une clée d'authentification vendeur
 * @Returns la clée générée
 */
function creercleAuth()
{
    $cle = "";

    for ($i = 1; $i <= 9; $i++) {
        $cle .= rand(0, 9);
    }

    ajoutercleBDD($cle);
    return $cle;
}

/**
 * @Brief récupère les informations du vendeur connecté
 * @Return retourne un tableau contenant les informations du vendeur
 */
function recupererInfosVendeur()
{
    $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);

    $infos = infosVendeurBDD($idVendeur);
    return $infos;
}


/**
 * @Brief met à jour les informations du vendeur
 * @Return int un tableau contenant les informations du vendeur
 */
function modificationVendeur($vendeur)
{
    // TODO : uniformiser les valeurs entre les CRU vendeur

    try {
        modifierVendeurBDD($vendeur);
    } catch (Exception $e) {
        return HTTP_ERR_GENERIQUE;
    }

    return HTTP_OK;
}

/**
 * @Brief modfie le mot de passe Vendeur
 */
function modificationMdpVendeur($data)
{
    $mdpCourant = $data["mdpCourant"];
    $nouveauMdp = $data["nouveauMdp"];
    $confNouveauMdp = $data["confNouveauMdp"];

    $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);

    if (password_verify($mdpCourant,  getMdpHashFromUUID($_COOKIE['uuid']))) {
        // Les deux nouveaux mots de passe ne correspondent pas
        if ($nouveauMdp !== $confNouveauMdp) {
            return HTTP_MDP_CONFIRM_DIFF;
        }

        // Le nouveau mot de passe est identique à l'ancien
        if ($mdpCourant === $nouveauMdp) {
            return HTTP_MDP_IDENTIQUE;
        }

        // Tout est valide → on met à jour
        modifierMdpVendeurBDD(password_hash($nouveauMdp, PASSWORD_DEFAULT), $idVendeur);
        return HTTP_OK;
    } else {
        return HTTP_ERR_GENERIQUE;
    }
}

function recupererLesVendeurs()
{
    return trouverLesVendeurs();
}

function recupererAdressesVendeurs()
{
    $adresses = trouverAdressesVendeurs();
    $tabFormate = [];

    foreach ($adresses as $a) {
        $tabFormate[] = [
            'id_vendeur' => $a['id_vendeur'],
            'nom' => $a['denomination_vendeur'],
            'adresse' => $a['adresse'],
            'ville' => $a['ville_adresse'],
            'cp' => $a['code_postal_adresse'],
            'lat' => $a['latitude'],
            'long' => $a['longitude']
        ];
    }

    return $tabFormate;
}

?>