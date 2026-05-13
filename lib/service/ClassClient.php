<?php
    final class Client{
   
    public $mail;
    public $nomUtilisateur;
    public $motDePasse;
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
    

?>