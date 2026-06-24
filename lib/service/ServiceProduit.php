<?php

require_once __DIR__ . '/../repo/ProduitRepo.php';
require_once __DIR__ . '/../repo/UtilisateurRepo.php';

function recupererlesProduits(): array {
    return trouverLesProduits();
}

function recupererLesCategories(): array {
    return trouverLesCategories();
}

function recupererProduitParId(int $id): array|false {
    return trouverProduitParId($id);
}

function recupererPremierProduit(): array|false {
    return trouverPremierProduit();
}

function recupererlesProduitsVendeur($idVendeur): array {
    return trouverLesProduitsVendeur($idVendeur);
}

/**
 * Créer un produit en BDD apres verification des champs
 * @param array $arrayProduit
 */
function creerProduit($arrayProduit, $uuid): array {
    $erreurs = [];
    
    // Champs texte requis
    $requis = ['categorieProduit', 'nomProduit', 'qteProduit', 'tva', 'prixProduit', 'descriptionProduit'];

    foreach ($requis as $champ) {
        if (!isset($arrayProduit[$champ]) 
        ||  trim($arrayProduit[$champ]) === '') {
            $erreurs[] = $champ;
        }
    }

    // Patterns même regex que le HTML
    if (!empty($arrayProduit['qteProduit']) 
    &&  !preg_match('/^[0-9]+$/', $arrayProduit['qteProduit'])) {
        $erreurs[] = 'qteProduit';
    }

    if (!empty($arrayProduit['tva']) 
    &&  !preg_match('/^[0-9][0-9]?$/', $arrayProduit['tva'])) {
        $erreurs[] = 'tva';
    }

    if (!empty($arrayProduit['prixProduit']) 
    &&  !preg_match('/^[0-9]+[.,]?([0-9]?){2}$/', $arrayProduit['prixProduit'])) {
        $erreurs[] = 'prixProduit';
    } else {
        $arrayProduit['prixProduit'] = str_replace(',', '.', $arrayProduit['prixProduit']);
    }
        
    // Longueur description minlength=40, maxlength=256
    if (!empty($arrayProduit['descriptionProduit'])) {
        $len = strlen(($arrayProduit['descriptionProduit']));
        if ($len < 40 
        ||  $len > 256) {
            $erreurs[] = 'descriptionProduit';
        }
    }

    // Image required + accept seulement "image/*"
    if (!isset($_FILES['champImageProduit'])
    ||  $_FILES['champImageProduit']['error'] !== 0) {
        $erreurs[] = 'champImageProduit';
    } else if (!str_starts_with(mime_content_type($_FILES['champImageProduit']['tmp_name']), 'image/')) {
        $erreurs[] = 'champImageProduit';
    }

    if (!empty($erreurs)) return ['succes' => false, 'erreurs' => $erreurs];

    $idVendeur = trouverIDUtilisateur($uuid); 

    // Requête de création à la BDD
    $idProduit = creerProduitBDD($arrayProduit['nomProduit'], $arrayProduit['descriptionProduit'],
                                 $arrayProduit['prixProduit'],  $arrayProduit['qteProduit'], 
                                 $arrayProduit['estDansCatalogue'], $arrayProduit['tva'], 
                                 $idVendeur);
    if ($idProduit === false) return ['succes' => false, 'emplacement' => "Lors de l'insert"];

    $idProduit = $idProduit["id_produit"];

    $resultLiaison = lierCategorie($arrayProduit['categorieProduit'], $idProduit);
    if ($resultLiaison === false) return ['succes' => false, 'emplacement' => "Lors de la laison"];

    $target_dir = "../imagesProduits/";
    $file = $_FILES['champImageProduit']['name'];
	$path = pathinfo($file);
	$ext = $path['extension'];
	$temp_name = $_FILES['champImageProduit']['tmp_name'];
    $name_ext = $idProduit.".".$ext;
	$path_filename_ext = $target_dir.$name_ext;

    if (preg_match("^(jpg|jpeg|jpe|png)$",$ext)
    ||  preg_match("^[-0-9A-Z_\.]{250}$",$name_ext)) {
        return ['succes' => false, 'emplacement' => "Mauvais fromat de nom d'image", $temp_name, $path_filename_ext];
    }

    // Sauvegarde du produit sur le serveur
    if (file_exists($path_filename_ext)
    ||  !move_uploaded_file($temp_name,$path_filename_ext))
        return ['succes' => false, 'emplacement' => "Sauvegarde de l'image", $temp_name, $path_filename_ext];
    
    // Bind de la photo avec le produit
    $resultLiaison = addPhoto($idProduit, $name_ext, true);
    if ($resultLiaison === false) 
        return ['succes' => false, 'emplacement' => "Ajout de l'image dans la BDD"];

    return ['succes' => true, 'idProduit' => $idProduit];
}

?>