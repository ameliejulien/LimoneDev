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

    //////////////////////////////
    // Vérification des champs //
    ////////////////////////////
    
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
    &&  !preg_match('/^[0-9][0-9][.,]?([0-9]?){2}$/', $arrayProduit['tva'])) {
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

    // Verifie si le nom du produit est déjà utilisé en verifiant si le id_produit est set dans les données returned 
    if (isset(nomProduitExiste($arrayProduit['nomProduit'])['id_produit'])) 
        return ['succes' => false, 'erreurs' => ['nomProduit'], 'message' => "Le nom du produit existe déjà."];

    $target_dir = __DIR__ . "/../../html/imagesProduits/";
    $file = $_FILES['champImageProduit']['name'];
	$path = pathinfo($file);
	$ext = $path['extension'];
	$temp_name = $_FILES['champImageProduit']['tmp_name'];

    // Le nom du fichier n'a pas besoin d'étre verifié nous le fixons nous même
    if (!preg_match("/^(jpg|jpeg|jpe|png)$/",$ext))
        return ['succes' => false, 'message' => "Mauvais fromat d'extension d'image."];

    $idVendeur = trouverIDUtilisateur($uuid); 
    
    ////////////////////////////////////////
    // Début requêtes de création en BDD //
    //////////////////////////////////////

    $path_filename_ext = "";

    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        // Requête de création à la BDD
        $idProduit = creerProduitBDD($arrayProduit['nomProduit'], $arrayProduit['descriptionProduit'],
                                    $arrayProduit['prixProduit'],  $arrayProduit['qteProduit'], 
                                    $arrayProduit['estDansCatalogue'], $arrayProduit['tva'], 
                                    $idVendeur);

        $idProduit = $idProduit["id_produit"];

        lierCategorie($arrayProduit['categorieProduit'], $idProduit);

        $name_ext = $idProduit.".".$ext;
        $path_filename_ext = $target_dir.$name_ext;

        // Sauvegarde du produit sur le serveur
        if (/*file_exists($path_filename_ext)
        || */ !move_uploaded_file($temp_name, $path_filename_ext)) {
            $dbh->rollBack();
            return ['succes' => false, 'message' => "L'image n'a pas pu être sauvegardé, Pensez à la changer."];
        }
        
        // Bind de la photo avec le produit
        addPhoto($idProduit, $name_ext, true);

        $dbh->commit();
        return ['succes' => true, 'idProduit' => $idProduit];
    } catch (Exception $e) {
        if (file_exists($path_filename_ext)) {
            unlink($path_filename_ext);
        }
        $dbh->rollBack();
        return ['succes' => true, 'message' => 'Echech à la création du produit'];
    }
}



function modifierProduit($ancienChamps, $nouveauChamps): array {
    $erreurs = [];

    $idProduit 
        = $ancienChamps['id_produit'];
    $nomProduit
        = $nouveauChamps['nomProduit'] === $ancienChamps['nom_produit'] 
        ? $ancienChamps['nom_produit'] 
        : $nouveauChamps['nomProduit'];
    $descriptionProduit
        = $nouveauChamps['descriptionProduit'] === $ancienChamps['description_produit'] 
        ? $ancienChamps['description_produit'] 
        : $nouveauChamps['descriptionProduit'];
    $prixProduit
        = $nouveauChamps['prixProduit'] === $ancienChamps['prix_ht_produit'] 
        ? $ancienChamps['prix_ht_produit'] 
        : $nouveauChamps['prixProduit'];
    $qteProduit
        = $nouveauChamps['qteProduit'] === $ancienChamps['stock_produit'] 
        ? $ancienChamps['stock_produit'] 
        : $nouveauChamps['qteProduit'];
    $estDansCatalogue
        = $nouveauChamps['estDansCatalogue'] === $ancienChamps['catalogue_produit'] 
        ? $ancienChamps['catalogue_produit'] 
        : $nouveauChamps['estDansCatalogue'];
    $tva
        = $nouveauChamps['tva'] === $ancienChamps['tva_produit'] 
        ? $ancienChamps['tva_produit'] 
        : $nouveauChamps['tva'];
    
    //////////////////////////////
    // Vérification des champs //
    ////////////////////////////

    // Champs texte requis
    $requis = ['categorieProduit', 'nomProduit', 'qteProduit', 'tva', 'prixProduit', 'descriptionProduit'];

    foreach ($requis as $champ) {
        if (!isset($nouveauChamps[$champ]) 
        ||  trim($nouveauChamps[$champ]) === '') {
            $erreurs[] = $champ;
        }
    }

    if (!empty($nomProduit)
    &&  !preg_match('/^.{2}(.?){98}$/', $nomProduit)) {
        $erreurs[] = 'nomProduit';
    }

    // Patterns même regex que le HTML
    if (!empty($qteProduit)
    &&  !preg_match('/^[0-9]+$/', $qteProduit)) {
        $erreurs[] = 'qteProduit';
    }

    if (!empty($tva) 
    &&  !preg_match('/^[0-9]?[0-9][.,]?([0-9]?){2}$/', $tva)) {
        $erreurs[] = 'tva';
    }

    if (!empty($prixProduit)
    &&  !preg_match('/^[0-9]+[.,]?([0-9]?){2}$/', $prixProduit)) {
        $erreurs[] = 'prixProduit';
    } else {
        if (isset($prixProduit)
        &&  is_string($prixProduit) 
        &&  str_contains($prixProduit, ',')) {
            $prixProduit = str_replace(',', '.', $prixProduit);
        }
    }
    
    // Longueur description minlength=40, maxlength=256
    if (!empty($descriptionProduit)) {
        $len = strlen(($descriptionProduit));
        if ($len < 40 
        ||  $len > 256) {
            $erreurs[] = 'descriptionProduit';
        }
    }

    // Image required + accept seulement "image/*"
    if (isset($_FILES['champImageProduit'])
    &&  !str_starts_with(mime_content_type($_FILES['champImageProduit']['tmp_name']), 'image/')) {
        $erreurs[] = 'champImageProduit';
    }

    if (!empty($erreurs)) 
        return ['succes' => false, 'erreurs' => $erreurs, 'message' => "Certains champs sont invalides."];

    // Verifie si le nom du produit est déjà utilisé
    $nomProduitExist = nomProduitExiste($nouveauChamps['nomProduit']);
    if (isset($nomProduitExist['id_produit']) 
    &&  $nomProduitExist['id_produit'] !== $idProduit) 
        return ['succes' => false, 'erreurs' => ['nomProduit'], 'message' => "Le nom du produit existe déjà."];

    ////////////////////////////////////////
    // Début requêtes de création en BDD //
    //////////////////////////////////////

    $dbh = connecterBDD();
    $dbh->beginTransaction();    
    try {
        if (isset($_FILES['champImageProduit'])) {
            $target_dir = __DIR__ . "/../../html/imagesProduits/";
            $file = $_FILES['champImageProduit']['name'];
            $path = pathinfo($file);
            $ext = $path['extension'];
            $temp_name = $_FILES['champImageProduit']['tmp_name'];

            // Le nom du fichier n'a pas besoin d'étre verifié nous le fixons nous même
            if (!preg_match("/^(jpg|jpeg|jpe|png)$/", $ext)) {
                $dbh->rollBack();
                return ['succes' => false, 'message' => "Mauvais fromat d'extension d'image."];
            }

            $name_ext = $idProduit.".".$ext;
            $path_filename_ext = $target_dir.$name_ext;

            // Sauvegarde du produit sur le serveur
            if (file_exists($path_filename_ext)) {
                if  (!unlink($path_filename_ext) 
                ||   !move_uploaded_file($temp_name, $path_filename_ext)) {
                    $dbh->rollBack();
                    return ['succes' => false, 'message' => "L'image n'a pas pu être modifié"];
                }
            } else {
                if  (!move_uploaded_file($temp_name, $path_filename_ext)) {
                    $dbh->rollBack();
                    return ['succes' => false, 'message' => "L'image n'a pas pu être sauvegardé"];
                }
            }

            // Supprime le bind de la photo avec le produit
            if (supprimerPhoto($idProduit, true) === false){
                $dbh->rollBack();
                return ['succes' => false, 'message' => "L'image n'a pas pu être supprimer."];
            }
            
            // Bind de la photo avec le produit
            if (addPhoto($idProduit, $name_ext, true) === false) {
                $dbh->rollBack();
                return ['succes' => false, 'message' => "L'image n'a pas pu être lié, Pensez à la changer."];
            }
        }

        // Requête de modification à la BDD
        if (modifierProduitBDD($idProduit, $nomProduit, $descriptionProduit, $prixProduit, $qteProduit,$estDansCatalogue , $tva) === false) {
            $dbh->rollBack();
            return ['succes' => false, 'message' => "Erreur à la modification"];
        }

        if ($nouveauChamps["categorieProduit"] !== $ancienChamps["id_categorie"]) {
            if (suppirmerCategorie($idProduit) === false) {
                $dbh->rollBack();
                return ['succes' => false, 'message' => "Erreur le produit n'a pas pu changer de catégorie"];
            }

            if (lierCategorie($nouveauChamps['categorieProduit'], $idProduit) === false) {
                $dbh->rollBack();
                return ['succes' => false, 'message' => "Erreur à la laison avec la catégorie"];
            }
        }

        $dbh->commit();
        return ['succes' => true, 'idProduit' => $idProduit];
    } catch (Exception $e) {
        $dbh->rollBack();
        return ['succes' => false, 'message' => "Echec de la modification"];
    }
}

?>