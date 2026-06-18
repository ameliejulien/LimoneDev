<?php

include __DIR__ . '/../../connect_params.php';
include __DIR__ . '/../repo/CompteVendeurRepo.php';

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
            throw new Exception(code: 601);
        }

        if (!preg_match("/[ a-zA-Z'.,;:!\(\)]+/", $denomination)) {
            throw new Exception(code: 602);
        }

        if (!preg_match("/0[1-9](?:[0-9]{2}){4}/", $tel)) {
            throw new Exception(code: 603);
        }

        if ($mdp != $confMdp) {
            throw new Exception(code: 604);
        }

        $vendeur["motDePasse"] = hash('sha256', $vendeur["motDePasse"]);

        if (!preg_match("/[0-9]{5}/", $codePostal)) {
            throw new Exception(code: 605);
        }

        if (!preg_match("/[ -a-zA-Z'.,\/]+/", $ville)) {
            throw new Exception(code: 606);
        }

        if (!preg_match("/[ -a-zA-Z'.,\/]+/", $adresse)) {
            throw new Exception(code: 607);
        }

        if (!preg_match("/[0-9]{14}/", $siret)) {
            throw new Exception(code: 608);
        }

        if (!certifierClee($vendeur["cleAuth"])) {
            throw new Exception(code: 609);
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
 * @Retuns un code de réussite ou d'erreur (200 ou 400)
 */
function connexionVendeur($vendeur)
{
    $vendeur["mail"] = strtolower($vendeur["mail"]);
    $vendeur["motDePasse"] = hash('sha256', $vendeur["motDePasse"]);
    $retour = connecterVendeur($vendeur);

    if ($retour == false) {
        $codeRetour = 400;
    } else {
        $codeRetour = 200;
    }

    return $codeRetour;
}

/**
 * @Brief transfère le retour de la requête de vérification du vendeur 
 * @Param la clée à certifier
 * @Retuns un booléen déterminant la certification de la clée
 */
function certifierClee($clee)
{
    return certifierCleeBDD($clee);
}

/**
 * @Brief génère une clée d'authentification vendeur
 * @Returns la clée générée
 */
function creerCleeAuth()
{
    $clee = "";

    for ($i = 1; $i <= 9; $i++) {
        $clee .= rand(0, 9);
    }

    ajouterCleeBDD($clee);
    return $clee;
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
        return 500;
    }

    return 200;
}

/**
 * Brief modfie le mot de passe Vendeur
 */
function modificationMdpVendeur($data)
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
    modifierMdpVendeurBDD($nouveauMdp);
    return 200;
}

function recupererLesVendeurs()
{
    return trouverLesVendeurs();
}

?>