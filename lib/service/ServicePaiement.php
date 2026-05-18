<?php
/**
 * Valide le format des champs de l'utilisateur coté serveur, pour éviter les bypass du JS
 */
function validerFormulaire() {
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
        $_POST[''];

        // Communication avec la banque
        return true;
    }
}

?>
