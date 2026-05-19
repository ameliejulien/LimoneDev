<?php

    include "GlobalRepo.php";

    /**
     * @Brief ajoute une instance dans utilisateur et vendeur en bdd
     * @Params prends un instance de vendeur en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function creerVendeurBdd($vendeur) {
        if (!chercherVendeur($vendeur)) {
            $codeRetour = 200;
            $connectBDD = connecterBDD();

            // requête création adresse
            $requeteAdresse =   "INSERT INTO limone.Adresse (adresse, ville_adresse, code_postal_adresse, facturation_adresse)".
                "VALUES ('{$vendeur["adresseVendeur"]}','{$vendeur["villeVendeur"]}',{$vendeur["codePostalVendeur"]},false)".
                " RETURNING id_adresse;";
            $requeteAdressePreparee = $connectBDD->prepare($requeteAdresse);
            try {
                $requeteAdressePreparee->execute(); 
            } catch (Exception $e){
                echo "code erreur recuperation : ". $e->getCode();
                $codeRetour = $e->getCode();
            }

            // récupération identifiant adresse
            $rowAdresse = $requeteAdressePreparee->fetch(PDO::FETCH_ASSOC);
            $idAdresse = $rowAdresse['id_adresse'];



            // requête création vendeur
            $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur,nom_utilisateur, telephone_utilisateur, mdp_utilisateur, type_utilisateur)".
                "VALUES ('{$vendeur["mail"]}','{$vendeur["denomination"]}','{$vendeur["telephone"]}','{$vendeur["motDePasse"]}','2')".
                " RETURNING id_utilisateur;";
            $requeteUtilisateurPreparee = $connectBDD->prepare($requeteUtilisateur);
            try {
                $requeteUtilisateurPreparee->execute(); 
            } catch (Exception $e){
                echo "code erreur recuperation : ". $e->getCode();
                $codeRetour = $e->getCode();
            }
    
            // récupération du client avec le returning
            $rowUtilisateur = $requeteUtilisateurPreparee->fetch(PDO::FETCH_ASSOC);
            $idUtilisateur = $rowUtilisateur['id_utilisateur'];
            
            
            // requête création Client (dans la table Client)
            $requeteVendeur = "INSERT INTO limone.Vendeur (id_vendeur, denomination_vendeur, siret_vendeur, addresse_vendeur)".
            " VALUES ('$idUtilisateur','{$vendeur["denomination"]}','{$vendeur["siret"]}','$idAdresse');";
            
            $requeteVendeurPreparee = $connectBDD->prepare($requeteVendeur);
            
            try {
                $requeteVendeurPreparee->execute();
            } catch (Exception $e){
                echo "code erreur insertion : ". $e->getCode();
                $codeRetour = $e->getCode();
            }

        } else {
            $codeRetour = 409;
        }
        
        return $codeRetour;
    }

    /**
     * @Brief cherche l'existence d'un vendeur via son email
     * @Params prends un mail en paramètre
     * @Returns booléen dépendant de l'existance du client
     */
    function chercherVendeur($vendeur) {
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$vendeur["mail"]}'";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $row !== false;
    }


    /**
     * @Brief cherche la clée de certification du vendeur
     * @Params prends la clée saisie dans le formulaire
     * @Returns booléen dépendant de si la clée existe et si elle n'a pas été utilisée
     */
    function certifierCleeBDD($clee) {
        $connectBDD = connecterBDD();
        $requete =   "SELECT clee FROM limone.Cle_Authentification".
        " WHERE clee = '$clee' AND utilisee = false";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute();

        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        if ($row != false) {
            // update de la valeur utilisée
            $requete =   "UPDATE limone.Cle_Authentification".
                " SET utilisee = true ".
                "WHERE clee= '$clee'";
            $requetePreparee = $connectBDD->prepare($requete);
            try {
                $requetePreparee->execute();
            } catch (Exception $e){
                echo "code erreur insertion : ". $e->getCode();
                $codeRetour = $e->getCode();
            }
            return true;
        }

        return false;
    }

    /**
     * @Brief recherche un vendeur par son email et vérifie le mot de passe de la map
     * @Params une map avec les informations du vendeur pour la connexion
     * @Returns un booléen confirmant ou non la connexion
     */
    function connecterVendeur($vendeur) {
        
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$vendeur["mail"]}' AND mdp_utilisateur = '{$vendeur["motDePasse"]}'";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $row !== false;
    }

?>