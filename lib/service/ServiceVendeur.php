<?php

    include __DIR__ . '/../../connect_params.php';
    include __DIR__ . '/../repo/CompteVendeurRepo.php';
    
    /**
     * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
     * cette fonction redirige vers la page de connexion
     * @Return Un object Client en base de données
    */
    function confimerInscirption($vendeur) {

        // tests ou transformations des champs du formulaire
        $vendeur["mail"] = strtolower($vendeur["mail"]);
        $mdp = $vendeur["motDePasse"];
        $confMdp = $vendeur["confMotDePasse"];
        $vendeur["motDePasse"] = hash('sha256', $vendeur["motDePasse"]);
        $codePostal = intval($vendeur["codePostalVendeur"]);
        $codeRetour;

        // Comparaison des mots de passe
        $mdpEgaux = ($mdp == $confMdp);

        if ($mdpEgaux && !champVide($vendeur) && certifierClee($vendeur["cleAuth"]) && ($codePostal != 0)) {
            $codeRetour = creerVendeurBdd($vendeur);
            
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
    function champVide($vendeur) {
        foreach ($vendeur as $vendeur) {
            if (empty($vendeur)) {
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
    function connexionVendeur($vendeur) {
        $vendeur["mail"] = strtolower($vendeur["mail"]);
        $vendeur["motDePasse"] = hash('sha256', $vendeur["motDePasse"]);
        $retour = connecterVendeur($vendeur);

        if ($retour == false ) {
            $codeRetour = 400;
        } else {
            $codeRetour = 200;
        }

        return $codeRetour;
    }

    /**
     * @Brief transfère le retour de la requête de vérification du vendeur 
     * @Param la clée à certifier
     * @Retuns un booléen déterminant la certification de la clée
     */
    function certifierClee($clee) {
        return certifierCleeBDD($clee);
    }

    /**
     * @Brief génère une clée d'authentification vendeur
     * @Returns la clée générée
     */
    function creerCleeAuth() {
        $clee = "";
        
        for ($i = 1; $i <= 9; $i++) {
            $clee .= rand(0, 9);
        }

        ajouterCleeBDD($clee);
        return $clee;
    }


    /**
     * @Brief génère un cookie pour la connexion vendeur
     */
    function creerCookieVendeur($vendeur) {
        if ($_COOKIE['vendeur'] != null) { // cookie déjà créé
            $vendeur = json_decode($_COOKIE['vendeur'],true);
        }
        error_log("vendeur reçu : " . var_export($vendeur, true));
        $id = getVendeurId($vendeur);
        error_log("id trouvé : " . var_export($id, true));


        $tab["mail"] = $vendeur["mail"];
        $tab["idVendeur"] = $id["id_vendeur"];

        // Modifie la liste de produit dans le cookie
        setcookie('vendeur', json_encode($tab), time() + 3*24*60*60, "/");
    }


    /**
     * @Brief récupère les informations du vendeur connecté
     * @Return retourne un tableau contenant les informations du vendeur
     */
    function recupererInfosVendeur() {
        
        if ($_COOKIE['vendeur'] != null) { // cookie déjà créé
            $vendeur = json_decode($_COOKIE['vendeur'],true); 
        }
        $idVendeur = $vendeur["idVendeur"];

        $infos = infosVendeurBDD($idVendeur);
        return $infos;
    }


    /**
     * @Brief met à jour les informations du vendeur
     * @Return retourne un tableau contenant les informations du vendeur
     */
    function modificationVendeur($vendeur) {
        modifierVendeurBDD($vendeur);
        return 200;
    }  

?>
