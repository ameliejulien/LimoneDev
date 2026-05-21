<?php

    require_once "GlobalRepo.php";

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

    /**
     * @Brief ajoute une clée d'authentification en BDD
     */
    function ajouterCleeBDD($clee) {
        $connectBDD = connecterBDD();
        $requete = "INSERT INTO Cle_Authentification (clee, utilisee)".
                   "VALUES ('{$clee}', false)"; 
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute();
    }


    /**
     * @Brief récup l'id d'un vendeur en fonction de son email
     */
    function getVendeurId($vendeur){
        $connectBDD = connecterBDD();

        $requete =  "SELECT id_vendeur FROM Vendeur INNER JOIN limone.Utilisateur ".
                    "ON Utilisateur.id_utilisateur = Vendeur.id_vendeur ".
                    "WHERE email_utilisateur = '{$vendeur["mail"]}';";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        $id = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $id;
    }


    /**
     * @Brief récupère les informations du vendeur en fonction de l'id passé en paramètre
     */
    function infosVendeurBDD($idVendeur) {
        $connectBDD = connecterBDD();

        $requete =  "SELECT DISTINCT denomination_vendeur, email_utilisateur, telephone_utilisateur, ". 
                    "denomination_vendeur, siret_vendeur, adresse, ville_adresse, code_postal_adresse ".
                    "FROM Utilisateur JOIN Vendeur ON Utilisateur.id_utilisateur = Vendeur.id_vendeur ".
                    "INNER JOIN Adresse on Vendeur.addresse_vendeur = Adresse.id_adresse ".
                    "WHERE id_vendeur = '{$idVendeur}';";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute();
        $infosVendeur = $requetePreparee->fetchall();
        return $infosVendeur;
    }


    /**
     * @Brief modifie les informations du vendeur
     */
    function modifierVendeurBDD($vendeur) {
        $idVendeur = json_decode($_COOKIE['vendeur'], true)['idVendeur']; 
        $connectBDD = connecterBDD();
        
        // récupréation de l'id de l'adresse
        $requeteGetIdAdresse =  "SELECT addresse_vendeur FROM Vendeur WHERE id_vendeur = '{$idVendeur}' ;";
        
        $requeteIdAdressePreparee = $connectBDD->prepare($requeteGetIdAdresse);
        $requeteIdAdressePreparee->execute();
        $rowAdresse = $requeteIdAdressePreparee->fetch(PDO::FETCH_ASSOC);
        $idAdresse = $rowAdresse['addresse_vendeur'];

        // MAJ de l'adresse
        $requeteAdresse =   "UPDATE Adresse ".
                            "SET adresse = '{$vendeur["adresse"]}', ville_adresse = '{$vendeur["ville_adresse"]}', ".
                            "code_postal_adresse = '{$vendeur["code_postal_adresse"]}' WHERE id_adresse = '{$idAdresse}'";
        
        $requeteUpdateAdresse = $connectBDD->prepare($requeteAdresse);
        $requeteUpdateAdresse->execute();


        // MAJ de l'utilisateur
        $requeteUtilisateur =   "UPDATE Utilisateur ".
                            "SET nom_utilisateur = '{$vendeur["denomination"]}', email_utilisateur = '{$vendeur["mail"]}', ".
                            "telephone_utilisateur = '{$vendeur["telephone_utilisateur"]}' WHERE id_utilisateur = '{$idVendeur}'";
        
        $requeteUpdateUtilisateur = $connectBDD->prepare($requeteUtilisateur);
        $requeteUpdateUtilisateur->execute();


        // MAJ de l'utilisateur
        $requeteVendeur =   "UPDATE Vendeur SET denomination_vendeur = '{$vendeur["denomination"]}' WHERE id_vendeur = '{$idVendeur}'";
        
        $requeteUpdateVendeur = $connectBDD->prepare($requeteVendeur);
        $rowVendeur = $requeteUpdateVendeur->execute();
    }



    /**
     * @Brief modifie le mot de passe vendeur
     */
    function modifierMdpVendeurBDD($mdp) {
        $connectBDD = connecterBDD();
        $idVendeur = json_decode($_COOKIE['vendeur'], true)['idVendeur']; 

        $requeteVendeur = "UPDATE Utilisateur SET mdp_utilisateur = '{$mdp}' WHERE id_utilisateur = '{$idVendeur}';";
        $requeteUpdateVendeur = $connectBDD->prepare($requeteVendeur);
        $rowVendeur = $requeteUpdateVendeur->execute();
    }

    function trouverLesVendeurs() {
        $PDO = connecterBDD();

        $query = "SELECT * FROM vendeur ORDER BY denomination_vendeur";

        return $PDO->query($query)->fetchall(); 
    }
?>