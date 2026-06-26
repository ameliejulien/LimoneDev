<?php

    require_once __DIR__ . '/../../connect_params.php';
    require_once __DIR__ . '/../repo/StockRepo.php';
    require_once __DIR__ . '/../repo/UtilisateurRepo.php';


    function getStock($idVendeur) { 
        $dbh = connecterBDD();
        $dbh->beginTransaction(); 
        try {
            $lstArticles = getStockBdd($idVendeur);
            $dbh->commit();
            return $lstArticles;
        } catch (Exception $e) {
            $dbh->rollBack();
        }
        
    }

    function updateStock($lignesModifiees){
        $dbh = connecterBDD();
        $dbh->beginTransaction(); 
        try {
            $codeRetour = updateStockBDD($lignesModifiees);
            $dbh->commit();
            return $codeRetour;
        } catch (Exception $e) {
            $dbh->rollBack();
        }
    }

    function deleteProduit($idProduit) {
        $dbh = connecterBDD();
        $dbh->beginTransaction(); 
        try {
            $deleteResult = deleteProduitBDD($idProduit);
            $dbh->commit();
            return $deleteResult;
        } catch (Exception $e) {
            $dbh->rollBack();
        }
    }
?>