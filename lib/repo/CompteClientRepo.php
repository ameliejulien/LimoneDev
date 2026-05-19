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
            $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur, mdp_utilisateur, type_utilisateur)".
                                "VALUES ('{$client["mail"]}','{$client["motDePasse"]}','1') RETURNING id_utilisateur;";
        
        
       
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


    function trouverInfosClient(): array {

        $PDO = connecterBDD();

        $requete = "SELECT Utilisateur.id_utilisateur, id_client, Adresse.id_adresse, ".
        "pp_utilisateur, nom_utilisateur, email_utilisateur, telephone_utilisateur, ".
        "adresse, code_postal_adresse, ville_adresse FROM Utilisateur INNER JOIN ".
        "Client ON Utilisateur.id_utilisateur = Client.id_client INNER JOIN ".
        "Adresse_Client ON Utilisateur.id_utilisateur = Adresse_Client.id_utilisateur ".
        "INNER JOIN Adresse ON Adresse_Client.id_adresse = Adresse.id_adresse;";

        return $PDO->query($requete)->fetchAll();
    }

?>