<?php 
    require __DIR__ . '/../repo/UtilisateurRepo.php';

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

?>