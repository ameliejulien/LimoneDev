<?php 
class Produit {
    private $produitId;

    public function __construct(int $produitId) {
        $this->produitId = $produitId;
    }

    public function getProduitId() {
        return $this->produitId;
    }
}
?>