<?php

    require_once __DIR__ . '/../../connect_params.php';
    require_once __DIR__ . '/../repo/StockRepo.php';
    require_once __DIR__ . '/../repo/UtilisateurRepo.php';


    function getStock($idVendeur) { 
        $lstArticles = getStockBdd($idVendeur);
        return $lstArticles;
    }

    function updateStock($lignesModifiees){
        $codeRetour = updateStockBDD($lignesModifiees);
        error_log("code retour ".$codeRetour);
        return $codeRetour;

    }

?>