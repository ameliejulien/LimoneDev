////////////////////
// PARTIE LEAFLET //
////////////////////

const map = L.map('map').setView([48.171, -2.753], 6.7);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

async function recupAdresses() {
    const reponseAdresses = await fetch('/API/AdressesVendeurs.php');

    if (reponseAdresses.ok) {
        const adresses = await reponseAdresses.json();
        
        return adresses
    } else {
        return null;
    }
}

recupAdresses().then((adresses) => {
    const markers = [];

    for (const a of adresses) {
        markers.push(L.marker([a.lat, a.long]).addTo(map).bindTooltip(
            `<b>${a.nom}</b>
            <br>
            <span>${a.adresse}</span>
            <br>
            <span>${a.ville}</span>
            <br>
            <span>${a.cp}</span>`
        ));
    }

    ////////////////////
    // PARTIE FILTRES //
    ////////////////////
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

        // Mettre les vendeurs Leaflet en fonction des filtres

        for (const m of markers) {
            map.removeLayer(m);
        }

        markers.length = 0;

        const vendeursRestant = [...produits].filter((p) => p.style.display !== 'none').map(
            (p) => parseInt(p.dataset.vendeur)).filter(
                (value, index, array) => array.indexOf(value) === index);
            
        adresses.filter((a) => vendeursRestant.includes(a.id_vendeur)).forEach((a) => {
            markers.push(L.marker([a.lat, a.long]).addTo(map).bindTooltip(
                `<b>${a.nom}</b>
                <br>
                <span>${a.adresse}</span>
                <br>
                <span>${a.ville}</span>
                <br>
                <span>${a.cp}</span>`
            ).on('click', () => {
                document.getElementById(`v-${a.id_vendeur}`).checked = true;

                filtrerProduits();
            }));
        });
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
});
