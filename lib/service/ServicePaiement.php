<?php
require('./lib/repo/FacturationRepo.php');

/**
 * Valide le format des champs de l'utilisateur coté serveur, pour éviter les bypass du JS
 */
function validerPaiement() {
    $valeurs = $_POST;
    $champsVide = false;

    foreach ($valeurs as $valeur) {
        $estVide = trim($valeur) === "";

        if ($estVide) {
            $champsVide = true;
            return false;
        }
    }

    if ($champsVide) {
        return false;
    } else { // Valider la commande (la mettre en BDD)
        // Todo Verification plus profonde : chaque champs un par un

        // Check the phone format
        $regex = "0[0-9] ?([0-9]{2} ?){4}";
        if (preg_match($regex, $_POST['telephone']) > 1) {
            return false;
        }

        enregistrerFacture(
            $_POST['prenom']." ".$_POST['nom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['adressePostal'],
            $_POST['adresseFacturation'],
            $_POST['codePostal'],
            $_POST['ville']
        );

        // Communication avec la banque
        return true;
    }
}

?>
