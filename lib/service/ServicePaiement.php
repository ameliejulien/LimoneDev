<?php
chdir(__DIR__ . '/../../');
require('lib/repo/FacturationRepo.php');

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

        // Verifie le format de l'email
        $regex = "[a-zA-Z\.\-]*@.*";
        if (preg_match($regex, $_POST['email']) > 1) {
            return false;
        }

        // Verifie le format du numero de telephone
        $regex = "0[0-9] ?([0-9]{2} ?){4}";
        if (preg_match($regex, $_POST['telephone']) > 1) {
            return false;
        }

        // Verifie le format de la carte de paiement
        $regex = "[0-9]{16}";
        if (preg_match($regex, $_POST['carteBancaire']) > 1) {
            return false;
        }

        // Verifie le format de la carte de paiement
        $regex = "[0-9]{3}";
        if (preg_match($regex, $_POST['codeSecretCB']) > 1) {
            return false;
        }

        enregistrerFacture(
            $_POST['prenom']." ".$_POST['nom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['ville'],
            $_POST['adressePostal'],
            $_POST['codePostal'],
            $_POST['villeFacturation'],
            $_POST['adressePostalFacturation'],
            $_POST['codePostalFacturation']
        );

        // Communication avec la banque
        return true;
    }
}

?>
