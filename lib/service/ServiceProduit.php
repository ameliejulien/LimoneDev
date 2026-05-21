<?php

require __DIR__ . '/../repo/ProduitRepo.php';

function recupererlesProduits(): array {
    return trouverLesProduits();
}

function recupererLesCategories(): array {
    return trouverLesCategories();
}

?>