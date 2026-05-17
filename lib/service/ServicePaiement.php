<?php
/**
 * Valide le format des champs de l'utilisateur coté serveur, pour éviter les bypass du JS
 */
function validerFormulaire() {
    $valeurs = $_POST;
    $champsVide = false;

    foreach ($valeurs as $valeur) {
        if ($valeur.trim().empty()) {
            $champsVide = true;
            return false;
        }
    }

    if ($champsVide) {
        return false;
    } else {
        // Todo Verification plus profonde : chaque champs un par un

        // Communication avec la banque
        return true;
    }
}

?>
