<?php 
    require_once __DIR__ . '/../repo/UtilisateurRepo.php';
    require_once __DIR__ . '/../Constantes.php';

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
            return HTTP_OK;
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
     * @Brief vérifie si l'utilisateur est un vendeur, qui n'a pas les droits d'accès aux pages panier, paiement et paiement validé
     * @Return redirige vers la page d'erreur si l'utilisateur n'a pas les droits d'accès
     */

    function droitsAccesPagePanier($uuid, $typeUtilisateurAttendu) {
        $typeUtilisateur = trouverTypeUtilisateur($uuid);
        if ($typeUtilisateur['type_utilisateur'] == $typeUtilisateurAttendu) {
            header('Location: /Erreur/index.php');
            exit();
        }
    }

    /**
     * @Brief vérifie si l'utilisateur a des articles dans son panier, sinon il n'a pas les droits d'accès aux pages paiement et paiement validé
     * @Return redirige vers la page d'erreur si l'utilisateur n'a pas les droits d'accès
     */

    // TODO : faire une fonction qui regarde si l'utilisateur a des articles dans son panier
    function droitsAccesPagePaiement($uuid, $typeUtilisateurAttendu, $quantiteProduitArray) {
        $typeUtilisateur = trouverTypeUtilisateur($uuid);
        if ($typeUtilisateur['type_utilisateur'] == $typeUtilisateurAttendu) {
            header('Location: /Erreur/index.php');
            exit();
        }
        else if (empty($quantiteProduitArray)){
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
        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']);
        $produits = recupererlesProduitsVendeur($idVendeur);
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