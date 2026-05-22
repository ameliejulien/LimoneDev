const sliderMin = document.querySelector('.min-price');
const sliderMax = document.querySelector('.max-price');
const fill = document.querySelector('.range-fill');
const valMin = document.querySelector('.prix-min-val');
const valMax = document.querySelector('.prix-max-val');
const grille = document.querySelector('.grille-produit');
const tri = document.querySelector('.tri');
const compteProduits = document.querySelector('.nombre-produits');
const produits = document.querySelectorAll('.carte-produit');

document.querySelectorAll('button').forEach(bouton => {
    bouton.addEventListener('click', (e) => {
        const loader = document.getElementById('loader');
        loader.classList.remove('hidden');

        fetch('../API/AjoutPanier.php', {
            method: 'POST',
            body: JSON.stringify({ id_produit: e.currentTarget.getAttribute('id_produit') })
        }).then(response => {
            if (response.status === 200) {
                afficherSnackBar('Succes', 'Le produit a été ajouté au panier avec succes');
            } else {
                afficherSnackBar('Erreur', 'Une erreur est survenue');
            }
        }).finally(() => {
            loader.classList.add('hidden');
        });
    })
});

function filtrerProduits() {
    let i = produits.length;

    //////////
    // Prix //
    //////////

    const min = parseInt(sliderMin.value);
    const max = parseInt(sliderMax.value);
    const total = sliderMin.max - sliderMin.min;

    fill.style.left = ((min - sliderMin.min) / total) * 100 + '%';
    fill.style.right = (((sliderMin.max - sliderMax.value) / total) * 100) + '%';

    valMin.textContent = min;
    valMax.textContent = max;

    produits.forEach(produit => {
        const prix = parseFloat(produit.dataset.prix);

        if (prix >= min && prix <= max) {
            produit.style.display = '';
        } else {
            produit.style.display = 'none';
            i--;
        }
    });

    ///////////////
    // Catégorie //
    ///////////////

    const categorie = document.querySelector('input[name="c"]:checked');

    produits.forEach(produit => {
        const categorieProduit = produit.dataset.categorie;
        if ((categorie.id.split('-')[1] === '0' || categorie.id.split('-')[1] === categorieProduit) && produit.style.display !== 'none') {
            produit.style.display = '';
        } else if (produit.style.display === 'none') {
            produit.style.display = 'none';
        } else {
            produit.style.display = 'none';
            i--;
        }
    });

    compteProduits.textContent = i;
}

sliderMin.addEventListener('input', () => {
    if (parseInt(sliderMin.value) > parseInt(sliderMax.value))
        sliderMin.value = sliderMax.value;
    filtrerProduits();
});

sliderMax.addEventListener('input', () => {
    if (parseInt(sliderMax.value) < parseInt(sliderMin.value))
        sliderMax.value = sliderMin.value;
    filtrerProduits();
});

document.querySelectorAll('.categorie').forEach(categorie => {
    categorie.addEventListener('change', (e) => {
        filtrerProduits();
    });
});

document.querySelectorAll('.vendeur').forEach(categorie => {
    categorie.addEventListener('change', (e) => {
        filtrerProduits();
    });
});

function trierProduits() {
    switch (tri.value) {
        case 'cro':
            [...grille.children].sort((a, b) =>
                parseFloat(a.dataset.prix) > (b.dataset.prix)).forEach(node => {
                    grille.appendChild(node);
                }
                );
            break;
        case 'dec':
            [...grille.children].sort((a, b) =>
                parseFloat(a.dataset.prix) < (b.dataset.prix)).forEach(node => {
                    grille.appendChild(node);
                }
                );
            break;
        case 'AZ':
            [...grille.children].sort((a, b) =>
                a.children[1].children[1].textContent > b.children[1].children[1].textContent).forEach(node => {
                    grille.appendChild(node);
                }
                );
            break;
    }
}

document.querySelector('.tri').addEventListener('change', (e) => {
    trierProduits();
});

filtrerProduits();
trierProduits();