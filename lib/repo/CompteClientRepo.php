<?php
    include "GlobalRepo.php";

    /**
     * @Brief ajoute une instance dans utilisateur et client en bdd
     * @Params prends un instance de client en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function creerClientBdd($client) {
        $connectBDD = connecterBDD();
        $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur, mdp_utilisateur, type_utilisateur)".
                                "VALUES ('{$client["mail"]}','{$client["motDePasse"]}','1') RETURNING id_utilisateur;";
        
        
       
        $requetePreparee = $connectBDD->prepare($requeteUtilisateur);
        $requetePreparee->execute(); // faire un return pour un cas différent
    
    
        // récupération du client avec le returning
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        $id = $row['id_utilisateur'];
        
        // requête création Client (dans la table Client)
        $requeteClient = "INSERT INTO limone.Client (id_client) VALUES ('$id');";
        
        $requeteClientPreparee = $connectBDD->prepare($requeteClient);
        $requeteClientPreparee->execute();

        return 200;
    }


    /**
     * @Brief recherche un client par son email
     * @Params prends un mail en paramètre
     * @Returns le résultat de la requête
     */
    function connecterClient($mail, $hashMdp) {
        $requete =   "SELECT email_utilisateur FROM limone.Utilisateur WHERE email_utilisateur = '$mail' AND mdp_utilisateur = '$hashMdp'";

        // TODO : sauvegarder le retour de la requête

    }
?>