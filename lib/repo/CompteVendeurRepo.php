<?php

    require_once "GlobalRepo.php";
    require_once __DIR__ . "/UtilisateurRepo.php";

    /**
     * @Brief ajoute une instance dans utilisateur et vendeur en bdd
     * @Param string  un mail représentant le vendeur
     * @Return int un code rest indiquant la validité du retour
     */
    function creerVendeurBdd($vendeur) {
        if (!chercherVendeur($vendeur)) {
            $codeRetour = 200;
            $connectBDD = connecterBDD();

            // requête création adresse
            $requeteAdresse =   "INSERT INTO limone.Adresse (adresse, ville_adresse, code_postal_adresse, facturation_adresse)".
                "VALUES (:adresseVendeur,:villeVendeur,:codePostalVendeur,false)".
                " RETURNING id_adresse;";
            $requeteAdressePreparee = $connectBDD->prepare($requeteAdresse);
            
            // binding des valeurs
            $requeteAdressePreparee->bindValue(":adresseVendeur", $vendeur["adresseVendeur"]);
            $requeteAdressePreparee->bindValue(":villeVendeur", $vendeur["villeVendeur"]);
            $requeteAdressePreparee->bindValue(":codePostalVendeur", $vendeur["codePostalVendeur"]);
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
                "VALUES (:mailVendeur,:denominationVendeur,:telVendeur,:mdpVendeur,'2')".
                " RETURNING id_utilisateur;";

            // binding des valeurs
            $requeteUtilisateurPreparee = $connectBDD->prepare($requeteUtilisateur);
            $requeteUtilisateurPreparee-> bindValue(":mailVendeur", $vendeur["mail"]);
            $requeteUtilisateurPreparee-> bindValue(":denominationVendeur", $vendeur["denomination"]);
            $requeteUtilisateurPreparee-> bindValue(":telVendeur", $vendeur["telephone"]);
            $requeteUtilisateurPreparee-> bindValue(":mdpVendeur", $vendeur["motDePasse"]);
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
            " VALUES (:idUtilisateur,:denominationVendeur,:siret,:adresse);";
            
            $requeteVendeurPreparee = $connectBDD->prepare($requeteVendeur);

            // binding des valeurs
            $requeteVendeurPreparee-> bindValue("idUtilisateur", $idUtilisateur);
            $requeteVendeurPreparee-> bindValue(":denominationVendeur", $vendeur["denomination"]);
            $requeteVendeurPreparee-> bindValue(":siret", $vendeur["siret"]);
            $requeteVendeurPreparee-> bindValue(":adresse",  $idAdresse);
            
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
     * @Param string un mail de vendeur
     * @Return bool représentant l'existance du vendeur
     */
    function chercherVendeur($vendeur) {
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
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
    function certifierCleeBDD($clee) {
        $connectBDD = connecterBDD();
        $requete =   "SELECT clee FROM limone.Cle_Authentification".
        " WHERE clee = :cleeAuth AND utilisee = false";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":cleeAuth", $clee);
        $requetePreparee->execute();

        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        if ($row != false) {
            // update de la valeur utilisée
            $requete =   "UPDATE limone.Cle_Authentification".
                " SET utilisee = true ".
                "WHERE clee = :cleeAuth";
            $requetePreparee = $connectBDD->prepare($requete);
            $requetePreparee->bindValue(":cleeAuth", $clee);
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
     * @Param array une map avec les informations du vendeur pour la connexion
     * @Return bool un booléen confirmant ou non la connexion
     */
    function connecterVendeur($vendeur) {
        
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
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
    function ajouterCleeBDD($clee) {
        $connectBDD = connecterBDD();
        $requete = "INSERT INTO Cle_Authentification (clee, utilisee)".
                   "VALUES (clee, false)"; 
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue('clee', $clee);
        $requetePreparee->execute();
    }


    /**
     * @Brief récup l'id d'un vendeur en fonction de son email
     */
    function getVendeurId($vendeur){
        $connectBDD = connecterBDD();

        $requete =  "SELECT id_vendeur FROM Vendeur INNER JOIN limone.Utilisateur ".
                    "ON Utilisateur.id_utilisateur = Vendeur.id_vendeur ".
                    "WHERE email_utilisateur = :mailVendeur;";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":mailVendeur", $vendeur["mail"]);
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
        // TODO : mettre la logique métier dans le service et faire une fonction par appel BDD

        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']); 
        $connectBDD = connecterBDD();
        
        // récupréation de l'id de l'adresse
        $requeteGetIdAdresse =  "SELECT addresse_vendeur FROM Vendeur WHERE id_vendeur = :idVendeur ;";
        
        $requeteIdAdressePreparee = $connectBDD->prepare($requeteGetIdAdresse);
        $requeteIdAdressePreparee->bindValue(":idVendeur",$idVendeur);
        $requeteIdAdressePreparee->execute();
        $rowAdresse = $requeteIdAdressePreparee->fetch(PDO::FETCH_ASSOC);
        $idAdresse = $rowAdresse['addresse_vendeur'];

        // MAJ de l'adresse
        $requeteAdresse =   "UPDATE Adresse ".
                            "SET adresse = :adresse, ville_adresse = :ville, ".
                            "code_postal_adresse = :codePostal WHERE id_adresse = :idAdresse";
        
        $requeteUpdateAdresse = $connectBDD->prepare($requeteAdresse);

        // biding des valerus de la requête
        $requeteUpdateAdresse->bindValue(":adresse",$vendeur["adresse"]);
        $requeteUpdateAdresse->bindValue(":ville",$vendeur["ville_adresse"]);
        $requeteUpdateAdresse->bindValue(":codePostal",$vendeur["code_postal_adresse"]);
        $requeteUpdateAdresse->bindValue(":idAdresse",$idAdresse);
        $requeteUpdateAdresse->execute();


        // MAJ de l'utilisateur
        $requeteUtilisateur =   "UPDATE Utilisateur ".
                            "SET nom_utilisateur = :denomination, email_utilisateur = :mailVendeur, ".
                            "telephone_utilisateur = :telephone WHERE id_utilisateur = :idVendeur";
        
        $requeteUpdateUtilisateur = $connectBDD->prepare($requeteUtilisateur);

        //Biding des valeurs
        $requeteUpdateUtilisateur->bindValue(":denomination",$vendeur["denomination"]);
        $requeteUpdateUtilisateur->bindValue(":mailVendeur",$vendeur["mail"]);
        $requeteUpdateUtilisateur->bindValue(":telephone",$vendeur["telephone_utilisateur"]);
        $requeteUpdateUtilisateur->bindValue(":idVendeur",$idVendeur);
        $requeteUpdateUtilisateur->execute();


        // MAJ du vendeur
        $requeteVendeur =   "UPDATE Vendeur SET denomination_vendeur = :denomination WHERE id_vendeur = :idVendeur";
        
        $requeteUpdateVendeur = $connectBDD->prepare($requeteVendeur);

        //Biding des valeurs
        $requeteUpdateVendeur->bindValue(":denomination",$vendeur["denomination"]);
        $requeteUpdateVendeur->bindValue(":idVendeur",$idVendeur);
        $rowVendeur = $requeteUpdateVendeur->execute();
    }



    /**
     * @Brief modifie le mot de passe vendeur
     */
    function modifierMdpVendeurBDD($mdp) {
        $connectBDD = connecterBDD();
        $idVendeur = trouverIDUtilisateur($_COOKIE['uuid']); 

        $requeteVendeur = "UPDATE Utilisateur SET mdp_utilisateur = :mdp WHERE id_utilisateur = :idVendeur;";
        $requeteUpdateVendeur = $connectBDD->prepare($requeteVendeur);
        $requeteUpdateVendeur->bindValue(":mdp",$mdp);
        $requeteUpdateVendeur->bindValue(":idVendeur",$idVendeur);
        $rowVendeur = $requeteUpdateVendeur->execute();
    }

    /**
     * Renvoie un id_vendeur et une denomination_vendeur
     */
    function trouverLesVendeurs() {
        $PDO = connecterBDD();

        $query = "SELECT id_vendeur, denomination_vendeur, siret_vendeur, addresse_vendeur FROM vendeur ORDER BY denomination_vendeur";

        return $PDO->query($query)->fetchall(); 
    }
?>