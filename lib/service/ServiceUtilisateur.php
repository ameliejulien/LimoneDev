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

    /**
     * @Brief vérifie si le vendeur a les droits d'accès à la page produit en fonction des produits qui lui sont associés
     * @Return redirige vers la page d'erreur si le vendeur n'a pas les droits d'accès
     */

    function droitsAccesPageProduit($uuid, $typeUtilisateurAttendu) {
        $typeUtilisateur = trouverTypeUtilisateur($uuid);
        $produits = recupererlesProduitsVendeur();
        if ($typeUtilisateur['type_utilisateur'] == $typeUtilisateurAttendu) {
            $accesAutorise = false;
            foreach ($produits as $produit) {
                if ($produit['id_produit'] == $_GET['id']) {
                    $accesAutorise = true;
                    break;
                }
            }
            if (!$accesAutorise) {
                header('Location: /Erreur/index.php'); // Le vendeur n'a pas les droits d'accès à la page produit
                exit();
            }
        }

    }

    /**
     * @Brief modifie l'interface de la page produit en fonction du rôle de l'utilisateur
     * @Return retourne un booléen confirmant ou non si l'utilisateur est un vendeur
     */

    function droitsAccesProduit($uuid, $typeUtilisateurAttendu) {
        $typeUtilisateur = trouverTypeUtilisateur($uuid);
        if ($typeUtilisateur['type_utilisateur'] == $typeUtilisateurAttendu) {
            return true;
        }
        else {
            return false;
        }
    }

?>