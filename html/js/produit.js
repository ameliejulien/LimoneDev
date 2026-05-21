const qtyVal   = document.getElementById('quantite');
const btnMoins = document.getElementById('btn-moins');
const btnPlus  = document.getElementById('btn-plus');
const stock    = parseInt(document.getElementById('bouton-ajouter').dataset.stock);

btnMoins.addEventListener('click', () => {
    let v = parseInt(qtyVal.textContent);
    if (v > 1) qtyVal.textContent = v - 1;
});

btnPlus.addEventListener('click', () => {
    let v = parseInt(qtyVal.textContent);
    if (v < stock) qtyVal.textContent = v + 1;
});

document.getElementById('bouton-ajouter')?.addEventListener('click', (e) => {
    const loader    = document.getElementById('loader');
    const idProduit = e.currentTarget.dataset.id;
    const quantite  = parseInt(qtyVal.textContent);

    loader.classList.remove('hidden');

    fetch('../API/AjoutPanier.php', {
        method: 'POST',
        body: JSON.stringify({ id_produit: idProduit, quantite: quantite })
    }).then(response => {
        if (response.status === 200) {
            afficherSnackBar('Succès', `${quantite} article${quantite > 1 ? 's' : ''} ajouté${quantite > 1 ? 's' : ''} au panier`);
        } else {
            afficherSnackBar('Erreur', 'Une erreur est survenue');
        }
    }).finally(() => {
        loader.classList.add('hidden');
    });
});