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

    if (!empty($erreurs)) 
        return ['succes' => false, 'erreurs' => $erreurs, 'message' => "Certains champs sont invalides."];

    // Verifie si le nom du produit est déjà utilisé
    if (!nomProduitExiste($arrayProduit['nomProduit'])) 
        return ['succes' => false, 'erreurs' => ['nomProduit'], 'message' => "Le nom du produit existe déjà."];

    $target_dir = basename("../imagesProduits/");
    $file = $_FILES['champImageProduit']['name'];
	$path = pathinfo($file);
	$ext = $path['extension'];
	$temp_name = $_FILES['champImageProduit']['tmp_name'];

    // Le nom du fichier n'a pas besoin d'étre verifié nous le fixons nous même
    if (preg_match("^(jpg|jpeg|jpe|png)$",$ext)) {
        return ['succes' => false, 'message' => "Mauvais fromat d'extension d'image."];
    }

    $idVendeur = trouverIDUtilisateur($uuid); 
    
    // Début requêtes de création en BDD

    // Requête de création à la BDD
    $idProduit = creerProduitBDD($arrayProduit['nomProduit'], $arrayProduit['descriptionProduit'],
                                 $arrayProduit['prixProduit'],  $arrayProduit['qteProduit'], 
                                 $arrayProduit['estDansCatalogue'], $arrayProduit['tva'], 
                                 $idVendeur);
    if ($idProduit === false) return ['succes' => false, 'message' => "Erreur à la création"];

    $idProduit = $idProduit["id_produit"];

    $resultLiaison = lierCategorie($arrayProduit['categorieProduit'], $idProduit);
    if ($resultLiaison === false) return ['succes' => false, 'message' => "Erreur à la laison avec la catégorie"];

    $name_ext = $idProduit.".".$ext;
	$path_filename_ext = $target_dir.$name_ext;

    // Sauvegarde du produit sur le serveur
    if (file_exists($path_filename_ext)
    ||  !move_uploaded_file($temp_name,$path_filename_ext))
        return ['succes' => false, 'message' => "L'image n'a pas pu être sauvegardé, Pensez à la changer.", $temp_name, $path_filename_ext];
    
    // Bind de la photo avec le produit
    $resultLiaison = addPhoto($idProduit, $name_ext, true);
    if ($resultLiaison === false) 
        return ['succes' => false, 'message' => "L'image n'a pas pu être lié, Pensez à la changer."];

    return ['succes' => true, 'idProduit' => $idProduit];
}

?>