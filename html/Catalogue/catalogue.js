const sliderMin = document.querySelector('.min-price');
const sliderMax = document.querySelector('.max-price');
const fill = document.querySelector('.range-fill');
const valMin = document.querySelector('.prix-min-val');
const valMax = document.querySelector('.prix-max-val');
const grille = document.querySelector('.grille-produit');
const tri = document.querySelector('.tri');
const compteProduits = document.querySelector('.nombre-produits');
const produits = document.querySelectorAll('.carte-produit');
const searchBar = document.querySelector('.header-recherche-champ');

const params = new URLSearchParams(document.location.search);
const searchParam = params.get('q');

produits.forEach(produit => {
    produit.addEventListener('click', (e) => {
        const id = produit.getAttribute('id_produit');
        window.location.href = `../Produit/Produit.php?id=${id}`;
    });
});

document.querySelectorAll('button').forEach(bouton => {
    bouton.addEventListener('click', (e) => {
        e.stopPropagation();
        const loader = document.getElementById('loader');
        loader.classList.remove('hidden');

        fetch('../API/AjoutPanier.php', {
            method: 'POST',
            body: JSON.stringify({ id_produit: e.currentTarget.getAttribute('id_produit'), quantite: 1 })
        }).then(response => {
            if (response.status === 200) {
                afficherSnackBar('Succes', 'Le produit a été ajouté au panier avec succès');
            } else {
                afficherSnackBar('Erreur', 'Une erreur est survenue');
            }
        }).finally(() => {
            loader.classList.add('hidden');

            const cookies = Object.fromEntries(
                document.cookie.split('; ').map(c => {
                    const [key, val] = c.split('=');
                    return [key, JSON.parse(decodeURIComponent(val))];
                })
            );

            if (cookies.panier) {
                document.querySelector('.header-panier-compteur').textContent = cookies.panier.length;
            }
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

    /////////////
    // Vendeur //
    /////////////

    const vendeur = document.querySelector('input[name="v"]:checked');

    produits.forEach(produit => {
        const vendeurProduit = produit.dataset.vendeur;
        if ((vendeur.id.split('-')[1] === '0' || vendeur.id.split('-')[1] === vendeurProduit) && produit.style.display !== 'none') {
            produit.style.display = '';
        } else if (produit.style.display === 'none') {
            produit.style.display = 'none';
        } else {
            produit.style.display = 'none';
            i--;
        }
    });

    ///////////////
    // Recherche //
    ///////////////

    if (searchParam) {
        searchBar.value = searchParam;

        produits.forEach(produit => {
            if ((produit.children[1].children[1].textContent.toLowerCase().includes(searchParam.toLowerCase())) && produit.style.display !== 'none') {
                produit.style.display = '';
            } else if (produit.style.display === 'none') {
                produit.style.display = 'none';
            } else {
                produit.style.display = 'none';
                i--;
            }
        });
    }

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
        case 'ven':
            [...grille.children].sort((a, b) =>
                parseInt(a.dataset.ventes) < parseInt(b.dataset.ventes)).forEach(node => {
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