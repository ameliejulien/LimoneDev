<?php

    include './connect_params.php';


    final class Client {

        // Informations formulaire
        public $mail;
        public $nomUtilisateur;
        public $motDePasse;
        
        // Informations complémentaires
        public $numTelephone;
        public $type;
        public $id;
        
        // Informations de livraisons
        public $adresse;
        public $codePostal;
        public $ville;

        function __construct($mail, $nomUtilisateur, $motDePasse, $numTelephone) {
            $this -> mail = $mail;
            $this -> nomUtilisateur = $nomUtilisateur;
            $this -> motDePasse = $motDePasse;
            $this -> numTelephone = $numTelephone;
            $this -> type = 0;
        }

        function setId($id) {
            $this -> id = $id;
        }

        function setAdresse($adresse) {
            $this -> adresse = $adresse;
        }

        function setCodePostal($codePostal) {
            $this -> codePostal = $codePostal;
        }

        function setVille($ville) {
            $this -> ville = $ville;
        }

    
    }
    
    
    /**
     * @Brief Fonction qui récupère les informations du formulaire pour confirmer l'inscription,
     * cette fonction redirige vers la page de connexion
     * @Return Un object Client en base de données
    */
    function confimerInscirption() {

        // Récupération des champs du formulaire
        $mail = strtolower($_POST["mail"]);
        $nomUtilisateur = $_POST["username"];
        $mdp = $_POST["mdp"];
        $confMdp = $_POST["confMdp"];
        $numTelephone = $_POST["telephone"];
        $code_retour;

        // Comparaison des mots de passe
        $mdpEgaux = ($mdp == $confMdp);

        // hash du mot de passe
        $hashMdp =  hash('sha256', $client->motDePasse);
        $client = new Client($mail, $nomUtilisateur, $hashMdp, $numTelephone);
        $inputVide = champVide($client);


        if ($mdpEgaux) {
            // TODO : repo -> ajouterClientBdd($client);
            
        } else {
            $code_retour = 400;
            echo "<p> inscription non valide $code_retour </p>";
        }
    }

    /**
     * @Brief regarde si une des valeurs saisie est vide
     * @Param une instance de la classe client
     * @Retuns unn booléen confirmant si un des champs est vide
     */
    function champVide(Client $client) {
        if (
            $client -> mail == "" ||
            $client -> nomUtilisateur == "" ||
            $client -> motDePasse == "" || 
            $client -> numTelephone == ""
        ) {
            return true;
        }
        return false;
    }

    /**
     * @Brief récupère le mail et le mot de passe au client et transfère les informations au service
     * @Returns booléen de connexion et un message si la connexion échoue
     */
    function connexionClient() {
        
        // récupération du login + mdp
        $mail = strtolower($_POST["mail"]);
        $mdp = $_POST["mdp"];
        $hashMdp = hash('sha256', $client->motDePasse);

        // TODO : repo -> getClient($mail, $hashMdp);
    
    }

?>