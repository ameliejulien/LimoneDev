<?php

    include __DIR__ . '/../../connect_params.php';
    include __DIR__ . '/../repo/CompteClientRepo.php';
    
    /**
     * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
     * cette fonction redirige vers la page de connexion
     * @Return Un object Client en base de données
    */
    function confimerInscirption($client) {

        // Transformation champs formulaires
        $client["mail"] = strtolower($client["mail"]);
        $mdp = $client["motDePasse"];
        $confMdp = $client["confMotDePasse"];
        $client["motDePasse"] = hash('sha256', $client["motDePasse"]);
        $code_retour;

        // Comparaison des mots de passe
        $mdpEgaux = ($mdp == $confMdp);

        if ($mdpEgaux && !champVide($client)) {
            $code_retour = creerClientBdd($client);
            
        } else {
            $code_retour = 400; 
        }
        return $code_retour;
    }

    /**
     * @Brief regarde si une des valeurs saisie est vide
     * @Param une instance de la classe client
     * @Retuns unn booléen confirmant si un des champs est vide
     */
    function champVide($client) {
        foreach ($client as $value) {
            if (empty($value)) {
                return true;
            }
        }
        return false;
    }
?>