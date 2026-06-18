<?php 
    require_once __DIR__ . '/../repo/UtilisateurRepo.php';

    function recupererInfosUtilisateur($uuid) {
        return trouverInfosUtilisateur($uuid);
    }

    /**
     * @Brief supprime l'uuid pour le déconnecter
     * @Return bool retourne un booléen confirmant ou non la suppression du cookie
     */
    function deconnecterUtilisateur()
    {
        setcookie("uuid", "", time() - 1, "/");
        unset($_COOKIE["uuid"]);

        if (!isset($_COOKIE["uuid"])) {
            return 200;
        }
        return 500;
    }

    /**
     * @Brief vérifie si l'utilisateur a les droits d'accès à la page en fonction de son rôle
     * @Return redirige vers la page d'erreur si l'utilisateur n'a pas les droits d'accès
     */

    function droitsAccesPage($uuid, $typeUtilisateurAttendu) {
        $typeUtilisateur = trouverTypeUtilisateur($uuid);
        if ($typeUtilisateur['type_utilisateur'] != $typeUtilisateurAttendu) {
            header('Location: /Erreur/index.php');
            exit();
        }
    }

?>