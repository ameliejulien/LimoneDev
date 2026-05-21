<?php 

    include "GlobalRepo.php";
    function connexionBDD($utilisateur){
        $connectBDD = connecterBDD();
        // requête
        $requete =   "SELECT email_utilisateur, type_utilisateur, id_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$utilisateur["mail"]}' AND mdp_utilisateur = '{$utilisateur["motDePasse"]}'";
        $requetePreparee = $connectBDD->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        return $requetePreparee->fetch(PDO::FETCH_ASSOC);

    }


    function getutilisateurId($utilisateur){
        $dbh = connecterBDD();

        $requete =   "SELECT id_utilisateur FROM limone.Utilisateur".
        " WHERE email_utilisateur = '{$utilisateur["mail"]}' AND mdp_utilisateur = '{$utilisateur["motDePasse"]}'";

        $requetePreparee = $dbh->prepare($requete);
        $requetePreparee->execute(); 
        
        // résultat de la requête
        $row = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $row["id_utilisateur"];
    }
?>