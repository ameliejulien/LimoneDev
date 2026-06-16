<?php
    require "GlobalRepo.php";

    function trouverUUID($mail, $mdp) {
        $connectBDD = connecterBDD();
        // requête
        $requete = 
        "SELECT utilisateur.uuid_utilisateur FROM limone.utilisateur
        WHERE utilisateur.email_utilisateur = :mail AND utilisateur.mdp_utilisateur = :mdp";

        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->bindValue(":mail", $mail);
        $requetePreparee->bindValue(":mdp", $mdp);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $utilisateur = $requetePreparee->fetch(PDO::FETCH_ASSOC);

        return $utilisateur['uuid_utilisateur'];
    }

    function creerUtilisateurBdd($client) {
        $connectBDD = connecterBDD();
        $requeteUtilisateur = 
        "INSERT INTO limone.Utilisateur 
        (email_utilisateur, nom_utilisateur, mdp_utilisateur, type_utilisateur, telephone_utilisateur)
        VALUES 
        (:mail, :nomUtilisateur,:motDePasse,'1', :telephone) 
        RETURNING id_utilisateur;";

        $requetePreparee = $connectBDD->prepare($requeteUtilisateur);

        // binding des valeurs
        $requetePreparee->bindValue(":mail", $client["mail"]);
        $requetePreparee->bindValue(":nomUtilisateur", $client["nomUtilisateur"]);
        $requetePreparee->bindValue(":motDePasse", $client["motDePasse"]);
        $requetePreparee->bindValue(":telephone", $client["telephone"]);
        $requetePreparee->execute(); 

        return $requetePreparee->fetch(PDO::FETCH_ASSOC)['id_utilisateur'];
    }

    function trouverInfosUtilisateur($uuid) {
        $connectBDD = connecterBDD();
        $requete = 
        "SELECT 
            utilisateur.nom_utilisateur,
            utilisateur.email_utilisateur,
            utilisateur.telephone_utilisateur,
            utilisateur.type_utilisateur
        FROM utilisateur
        WHERE uuid_utilisateur = :id";

        $prepare = $connectBDD->prepare($requete);
        $prepare->bindValue(":id", $uuid);
        $prepare->execute();

        return $prepare->fetch(PDO::FETCH_ASSOC);
    }

    function trouverIDUtilisateur($uuid) {
        $connectBDD = connecterBDD();
        $requete = 
        "SELECT 
            utilisateur.id_utilisateur
        FROM utilisateur
        WHERE uuid_utilisateur = :id";

        $prepare = $connectBDD->prepare($requete);
        $prepare->bindValue(":id", $uuid);
        $prepare->execute();

        return $prepare->fetch(PDO::FETCH_ASSOC)['id_utilisateur'];
    }

?>