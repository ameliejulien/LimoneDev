<?php
    include "GlobalRepo.php";

    /**
     * @Brief ajoute une instance dans utilisateur et client en bdd
     * @Params prends un instance de client en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function creerClientBdd($client) {
        if (!chercherClient($client)) {
            $codeRetour = 200;
            $connectBDD = connecterBDD();
            $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur, nom_utilisateur, mdp_utilisateur, type_utilisateur, telephone_utilisateur)".
                                "VALUES ('{$client["mail"]}','{$client["nomUtilisateur"]}','{$client["motDePasse"]}','1','{$client["telephone"]}') RETURNING id_utilisateur;";
        
        
       
            $requetePreparee = $connectBDD->prepare($requeteUtilisateur);
            try {
                $requetePreparee->execute(); 
            } catch (Exception $e){
                echo "code erreur recuperation : ". $e->getCode();
                $codeRetour = $e->getCode();
            }
        
    
    
            // récupération du client avec le returning
            $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
            $id = $row['id_utilisateur'];
            
            // requête création Client (dans la table Client)
            $requeteClient = "INSERT INTO limone.Client (id_client) VALUES ('$id');";
            
            $requeteClientPreparee = $connectBDD->prepare($requeteClient);
            
            try {
                $requeteClientPreparee->execute();
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
     * @Brief recherche un client par son email
     * @Params prends un mail en paramètre
     * @Returns le résultat de la requête
     */
    function connecterClient($client) {
        
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$client["mail"]}' AND mdp_utilisateur = '{$client["motDePasse"]}'";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $row !== false;

    }

    /**
     * @Brief cherche l'existence d'un client via son email
     * @Params prends un mail en paramètre
     * @Returns booléen dépendant de l'existance du client
     */
    function chercherClient($client) {
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$client["mail"]}'";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $row !== false;
    }


    /**
     * @Brief Envoie d'une requête dans la BDD pour récupérer les informations d'un client
     */
    function trouverInfosClient($idClient) {

        $connectBDD = connecterBDD();

        $requete =  "SELECT DISTINCT pp_utilisateur, nom_utilisateur, email_utilisateur, ".
                    "telephone_utilisateur ". 
                    //"adresse, code_postal_adresse, ville_adresse ".
                    "FROM Utilisateur ".
                    //"JOIN Client ON Utilisateur.id_utilisateur = Client.id_client ".
                    //"INNER JOIN Adresse on Client.addresse_client = Adresse.id_adresse ".
                    "WHERE id_utilisateur = '{$idClient}';";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute();
        $infosClient = $requetePreparee->fetchall();
        return $infosClient;
    }


    function getIdClient($client){
        $connectBDD = connecterBDD();

        $requete =  "SELECT id_client FROM Client INNER JOIN Utilisateur ".
                    "ON Utilisateur.id_utilisateur = Client.id_client ".
                    "WHERE email_utilisateur = '{$client["mail"]}';";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        $id = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $id;

    }

    /**
     * @Brief Changer les informations du client
     */
    function modifierClientBDD($client) {

        $idClient = json_decode($_COOKIE['client'], true)['idClient'];
        $connectBDD = connecterBDD();

        // Récupération de l'id adresse client
        $requeteGetIdAdresse = "SELECT id_adresse FROM Adresse WHERE id_utilisateur = '{$idClient}' ;";
        $requeteIdAdressePreparee = $connectBDD->prepare($requeteGetIdAdresse);
        $requeteIdAdressePreparee->execute();
        $rowAdresse = $requeteIdAdressePreparee->fetch(PDO::FETCH_ASSOC);
        $idAdresse = $rowAdresse['id_adresse'];

        // Modification de l'adresse
        $requeteAdresse = "UPDATE Adresse ".
                          "SET adresse = '{$client["adresse"]}', ville_adresse = '{$client["ville_adresse"]}', ".
                          "code_postal_adresse = '{$client["code_postal_adresse"]}' WHERE id_adresse = '{$idAdresse}'";

        $requeteUpdateAdresse = $connectBDD->prepare($requeteAdresse);
        $requeteUpdateAdresse->execute();

        // Modification de l'utilisateur
        $requeteUtilisateur = "UPDATE Utilisateur ".
                              "SET nom_utilisateur = '{$client["nom_utilisateur"]}', email_utilisateur = '{$client["email_utilisateur"]}', ".
                              "telephone_utilisateur = '{$client["telephone_utilisateur"]}' WHERE id_utilisateur = '{$idClient}'";

        $requeteUpdateUtilisateur = $connectBDD->prepare($requeteUtilisateur);
        $requeteUpdateUtilisateur->execute();
    }

?>