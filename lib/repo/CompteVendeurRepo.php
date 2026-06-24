<?php

require_once "GlobalRepo.php";
require_once __DIR__ . "/UtilisateurRepo.php";

/**
 * @Brief ajoute une instance dans utilisateur et vendeur en bdd
 * @Param string  un mail représentant le vendeur
 * @Return int un code rest indiquant la validité du retour
 */
function creerVendeurBdd($vendeur)
{
    if (!chercherVendeur($vendeur)) {
        $codeRetour = 200;
        $connectBDD = connecterBDD();

        // requête création adresse
        $requeteAdresse = "INSERT INTO limone.Adresse (adresse, ville_adresse, code_postal_adresse, facturation_adresse)" .
            "VALUES (:adresseVendeur,:villeVendeur,:codePostalVendeur,false)" .
            " RETURNING id_adresse;";
        $requeteAdressePreparee = $connectBDD->prepare($requeteAdresse);

        // binding des valeurs
        $requeteAdressePreparee->bindValue(":adresseVendeur", $vendeur["adresseVendeur"]);
        $requeteAdressePreparee->bindValue(":villeVendeur", $vendeur["villeVendeur"]);
        $requeteAdressePreparee->bindValue(":codePostalVendeur", $vendeur["codePostalVendeur"]);
        try {
            $requeteAdressePreparee->execute();
        } catch (Exception $e) {
            echo "code erreur recuperation : " . $e->getCode();
            $codeRetour = $e->getCode();
        }

        // récupération identifiant adresse
        $rowAdresse = $requeteAdressePreparee->fetch(PDO::FETCH_ASSOC);
        $idAdresse = $rowAdresse['id_adresse'];



        // requête création vendeur
        $requeteUtilisateur = "INSERT INTO limone.Utilisateur (email_utilisateur,nom_utilisateur, telephone_utilisateur, mdp_utilisateur, type_utilisateur)" .
            "VALUES (:mailVendeur,:denominationVendeur,:telVendeur,:mdpVendeur,'2')" .
            " RETURNING id_utilisateur;";

        // binding des valeurs
        $requeteUtilisateurPreparee = $connectBDD->prepare($requeteUtilisateur);
        $requeteUtilisateurPreparee->bindValue(":mailVendeur", $vendeur["mail"]);
        $requeteUtilisateurPreparee->bindValue(":denominationVendeur", $vendeur["denomination"]);
        $requeteUtilisateurPreparee->bindValue(":telVendeur", $vendeur["telephone"]);
        $requeteUtilisateurPreparee->bindValue(":mdpVendeur", $vendeur["motDePasse"]);
        try {
            $requeteUtilisateurPreparee->execute();
        } catch (Exception $e) {
            echo "code erreur recuperation : " . $e->getCode();
            $codeRetour = $e->getCode();
        }

        // récupération du client avec le returning
        $rowUtilisateur = $requeteUtilisateurPreparee->fetch(PDO::FETCH_ASSOC);
        $idUtilisateur = $rowUtilisateur['id_utilisateur'];


        // requête création Client (dans la table Client)
        $requeteVendeur = "INSERT INTO limone.Vendeur (id_vendeur, denomination_vendeur, siret_vendeur, addresse_vendeur)" .
            " VALUES (:idUtilisateur,:denominationVendeur,:siret,:adresse);";

        $requeteVendeurPreparee = $connectBDD->prepare($requeteVendeur);

        // binding des valeurs
        $requeteVendeurPreparee->bindValue("idUtilisateur", $idUtilisateur);
        $requeteVendeurPreparee->bindValue(":denominationVendeur", $vendeur["denomination"]);
        $requeteVendeurPreparee->bindValue(":siret", $vendeur["siret"]);
        $requeteVendeurPreparee->bindValue(":adresse", $idAdresse);

        try {
            $requeteVendeurPreparee->execute();
        } catch (Exception $e) {
            echo "code erreur insertion : " . $e->getCode();
            $codeRetour = $e->getCode();
        }

    } else {
        $codeRetour = 409;
    }

    return $codeRetour;
}

/**
 * @Brief cherche l'existence d'un vendeur via son email
 * @Param string un mail de vendeur
 * @Return bool représentant l'existance du vendeur
 */
function chercherVendeur($vendeur)
{
    $connectBDD = connecterBDD();
    // requête
    $requete = "SELECT email_utilisateur FROM limone.Utilisateur" .
        " WHERE email_utilisateur = :mailVendeur";
    $stmt = $connectBDD->prepare($requete);
    $stmt->bindValue(":mailVendeur", $vendeur["mail"]);
    $stmt->execute();

    // résultat de la requête
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row !== false;
}


/**
 * @Brief cherche la clée de certification du vendeur
 * @Param string la clé dans le formulaire
 * @Return bool valeur représentant la validité de la clé renseignée
 */
function certifiercleBDD($cle)
{
    $connectBDD = connecterBDD();
    $requete = "SELECT cle FROM limone.Cle_Authentification" .
        " WHERE cle = :cleAuth AND utilisee = false";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":cleAuth", $cle);
    $requetePreparee->execute();

    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

    if ($row != false) {
        // update de la valeur utilisée
        $requete = "UPDATE limone.Cle_Authentification" .
            " SET utilisee = true " .
            "WHERE cle = :cleAuth";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":cleAuth", $cle);
        try {
            $requetePreparee->execute();
        } catch (Exception $e) {
            echo "code erreur insertion : " . $e->getCode();
            $codeRetour = $e->getCode();
        }
        return true;
    }

    return false;
}

/**
 * @Brief recherche un vendeur par son email et vérifie le mot de passe de la map
 * @Param array une map avec les informations du vendeur pour la connexion
 * @Return bool un booléen confirmant ou non la connexion
 */
function connecterVendeur($vendeur)
{

    $connectBDD = connecterBDD();
    // requête
    $requete = "SELECT email_utilisateur FROM limone.Utilisateur" .
        " WHERE email_utilisateur = :emailVendeur AND mdp_utilisateur = :mdp";
    $requetePreparee = $connectBDD->prepare($requete);

    // biding des valeurs
    $requetePreparee->bindValue(":emailVendeur", $vendeur["mail"]);
    $requetePreparee->bindValue(":mdp", $vendeur["motDePasse"]);
    $requetePreparee->execute();

    // résultat de la requête
    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

    return $row !== false;
}

/**
 * @Brief ajoute une clée d'authentification en BDD
 */
function ajoutercleBDD($cle)
{
    $connectBDD = connecterBDD();
    $requete = "INSERT INTO Cle_Authentification (cle, utilisee)" .
        "VALUES (cle, false)";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue('cle', $cle);
    $requetePreparee->execute();
}


/**
 * @Brief récup l'id d'un vendeur en fonction de son email
 */
function getVendeurId($vendeur)
{
    $connectBDD = connecterBDD();

    $requete = "SELECT id_vendeur FROM Vendeur INNER JOIN limone.Utilisateur " .
        "ON Utilisateur.id_utilisateur = Vendeur.id_vendeur " .
        "WHERE email_utilisateur = :mailVendeur;";

    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":mailVendeur", $vendeur["mail"]);
    $requetePreparee->execute();
    $id = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return $id;
}

function getVendeurMdpHash($idVendeur)
{
    $connectBDD = connecterBDD();

    $requete = "select id_vendeur, mdp_utilisateur from Vendeur inner join limone.Utilisateur
    on utilisateur.id_utilisateur = Vendeur.id_vendeur
    where id_vendeur = :idVendeur";

    $requete = $connectBDD->prepare($requete);
    $requete->bindValue(":idVendeur", $idVendeur);

    $row = $requete->fetch(PDO::FETCH_ASSOC);
    return $row["mdp_utilisateur"] ?? null;
}

/**
 * @Brief récupère les informations du vendeur en fonction de l'id passé en paramètre
 */
function infosVendeurBDD($idVendeur)
{
    $connectBDD = connecterBDD();

    $requete = "SELECT DISTINCT denomination_vendeur, email_utilisateur, telephone_utilisateur, " .
        "denomination_vendeur, siret_vendeur, adresse, ville_adresse, code_postal_adresse " .
        "FROM Utilisateur JOIN Vendeur ON Utilisateur.id_utilisateur = Vendeur.id_vendeur " .
        "INNER JOIN Adresse on Vendeur.addresse_vendeur = Adresse.id_adresse " .
        "WHERE id_vendeur = :idVendeur;";

    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(":idVendeur", $idVendeur);
    $requetePreparee->execute();
    $infosVendeur = $requetePreparee->fetchall();
    return $infosVendeur;
}

/**
 * @brief récupère l'ID de l'adresse d'un vendeur
 */
function obtenirIdAdresseVendeur($connectBDD, $idVendeur)
{
    $requete = "SELECT addresse_vendeur FROM Vendeur WHERE id_vendeur = :idVendeur";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(':idVendeur', $idVendeur);
    $requetePreparee->execute();
    $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
    return $row['addresse_vendeur'] ?? null;
}

/**
 * @brief met à jour l'adresse d'un vendeur
 */
function mettreAJourAdresseVendeur($connectBDD, $idAdresse, $vendeur)
{
    $requete = "UPDATE Adresse 
                SET adresse = :adresse, ville_adresse = :ville, code_postal_adresse = :codePostal 
                WHERE id_adresse = :idAdresse";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(':adresse', $vendeur["adresse"]);
    $requetePreparee->bindValue(':ville', $vendeur["ville_adresse"]);
    $requetePreparee->bindValue(':codePostal', $vendeur["code_postal_adresse"]);
    $requetePreparee->bindValue(':idAdresse', $idAdresse);
    $requetePreparee->execute();
}

/**
 * @brief met à jour les infos de l'utilisateur lié au vendeur
 */
function mettreAJourUtilisateurVendeur($connectBDD, $idVendeur, $vendeur)
{
    $requete = "UPDATE Utilisateur 
                SET nom_utilisateur = :denomination, email_utilisateur = :mailVendeur, telephone_utilisateur = :telephone 
                WHERE id_utilisateur = :idVendeur";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(':denomination', $vendeur["denomination"]);
    $requetePreparee->bindValue(':mailVendeur', $vendeur["mail"]);
    $requetePreparee->bindValue(':telephone', $vendeur["telephone_utilisateur"]);
    $requetePreparee->bindValue(':idVendeur', $idVendeur);
    $requetePreparee->execute();
}

/**
 * @brief met à jour la dénomination du vendeur
 */
function mettreAJourVendeur($connectBDD, $idVendeur, $vendeur)
{
    $requete = "UPDATE Vendeur SET denomination_vendeur = :denomination WHERE id_vendeur = :idVendeur";
    $requetePreparee = $connectBDD->prepare($requete);
    $requetePreparee->bindValue(':denomination', $vendeur["denomination"]);
    $requetePreparee->bindValue(':idVendeur', $idVendeur);
    $requetePreparee->execute();
}

/**
 * @Brief modifie le mot de passe vendeur
 */
function modifierMdpVendeurBDD($mdp, $idVendeur)
{
    $connectBDD = connecterBDD();

    $requeteVendeur = "UPDATE Utilisateur SET mdp_utilisateur = :mdp WHERE id_utilisateur = :idVendeur;";
    $requeteUpdateVendeur = $connectBDD->prepare($requeteVendeur);
    $requeteUpdateVendeur->bindValue(":mdp", $mdp);
    $requeteUpdateVendeur->bindValue(":idVendeur", $idVendeur);
    $requeteUpdateVendeur->execute();
}

/**
 * @brief renvoie un id_vendeur et une denomination_vendeur
 */
function trouverLesVendeurs() {
    $PDO = connecterBDD();

    $query =
    "SELECT
    vendeur.id_vendeur,
    vendeur.denomination_vendeur
    FROM vendeur
    ORDER BY denomination_vendeur";

    return $PDO->query($query)->fetchall();
}
    
function trouverAdressesVendeurs() {
    $PDO = connecterBDD();

    $query =
    "SELECT
        vendeur.id_vendeur,
        vendeur.denomination_vendeur,
        adresse.adresse,
        adresse.ville_adresse,
        code_postal_adresse,
        adresse.latitude,
        adresse.longitude
    FROM vendeur
    INNER JOIN adresse ON vendeur.addresse_vendeur = adresse.id_adresse";

    return $PDO->query($query)->fetchall();
}
?>