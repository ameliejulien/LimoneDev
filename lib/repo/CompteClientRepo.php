<?php
    /**
     * @Brief ajoute une instance dans utilisateur et client en bdd
     * @Params prends un instance de client en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function creerClientBdd($client) {
        $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur, mdp_utilisateur, type_utilisateur)".
                                "VALUES ('{$client->mail}','$mdpHash','{$client->type}') RETURNING id_utilisateur;";

        // récupération du client avec le returning (pas fini)
        $idClient;
        
        // requête création Client (dans la table Client)
        $requeteClient = "INSERT INTO limone.Client (id_client)".
        "VALUES ('$idClient');";

    }


    /**
     * @Brief ajoute une instance dans utilisateur et client en bdd
     * @Params prends un instance de client en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function rechercherClient($mail, $hashMdp) {
        $requete =   "SELECT mdp_utilisateur FROM Utilisateur WHERE email_utilisateur = '$hashMdp'";

        // TODO : sauvegarder le retour de la requête

    }

?>