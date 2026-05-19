<?php

require __DIR__ . '/../repo/ProduitRepo.php';

function recupererTouslesProduits(): array {
    return trouverTousLesProduits();
}

?>