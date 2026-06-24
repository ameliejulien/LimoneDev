<?php

require_once __DIR__ . '/../repo/ProduitRepo.php';

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

?>