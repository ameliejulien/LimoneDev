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
        $codeRetour;

        // Comparaison des mots de passe
        $mdpEgaux = ($mdp == $confMdp);

        if ($mdpEgaux && !champVide($client)) {
            $codeRetour = creerClientBdd($client);
            
        } else {
            $codeRetour = 400; 
        }
        return $codeRetour;
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

    /**
     * @Brief renvoie une requête dans la BDD pour vérifier si le client peut se connecter
     * @Param une map avec les valeurs du formulaire
     * @Retuns un code de réussite ou d'erreur (200 ou 400)
     */
    function connexionClient($client) {
        $client["mail"] = strtolower($client["mail"]);
        $client["motDePasse"] = hash('sha256', $client["motDePasse"]);
        $retour = connecterClient($client);

        if ($retour == false ) {
            $codeRetour = 400;
        } else {
            $codeRetour = 200;
        }

        return $codeRetour;
    }

    function recupererInfosClient(): array {
        return trouverInfosClient();
    }

    /**
     * @Brief création d'un cookie client à la connexion
     */
    function ajouterClientCookie($client) {
        if ($_COOKIE['client'] != null) { // cookie déjà créé
            $client = json_decode($_COOKIE['client']);
        }
        $id = getIdClient($client);

        $tab["mail"] = $client["mail"];
        $tab["idClient"] = $id;

        // Modifie la liste de produit dans le cookie
        setcookie('client', json_encode($tab), time() + 3*24*60*60, "/");
    }
?>
