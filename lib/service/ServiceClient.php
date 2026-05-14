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
        $client = new Client($mail, $nomUtilisateur, $mdp, $numTelephone);
        $inputVide = champVide($client);


        if ($mdpEgaux) {
            $code_retour = ajouterClientBdd($client);
            
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
     * @Brief ajoute une instance dans utilisateur et client en bdd
     * @Params prends un instance de client en paramètre
     * @Returns un code rest retourné en cas d'erreur
     */
    function ajouterClientBdd(Client $client) {

        $mdpHash =  hash('sha256', $client->motDePasse);
        $retour; // a ajuster en fonction de la valeur du code

        // requête création Client (dans la table utilisateur)
        $requeteUtilisateur =   "INSERT INTO limone.Utilisateur (email_utilisateur, mdp_utilisateur, type_utilisateur)".
                                "VALUES ('{$client->mail}','$mdpHash','{$client->type}') RETURNING id_utilisateur;";

        // récupération du client
        $idClient;
        
        // requête création Client (dans la table Client)
        $requeteClient = "INSERT INTO limone.Client (id_client)".
        "VALUES ('$idClient');";

        return $retour;
        
    }

    

?>