<?php
    final class Client{
   
    public $mail;
    public $nomUtilisateur;
    public $motDePasse;
    public $type;
    public $id;

    function __construct($mail, $nomUtilisateur, $motDePasse) {
        $this -> mail = $mail;
        $this -> nomUtilisateur = $nomUtilisateur;
        $this -> motDePasse = $motDePasse;
        $this -> type = 0;
    }

    function setId($id) {
        $this -> id = $id;
    }

    
  }
    

?>