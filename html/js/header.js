// ============================================================
//  header.js  –  Gestion js du header
// ============================================================

const burger = document.getElementById('burger');
const fermer = document.getElementById('fermer');
const overlay = document.getElementById('overlay');
const menu = document.getElementById('menu-lateral');

if (burger) {
    burger.addEventListener('click', () => {
        menu.classList.add('ouvert');
        overlay.classList.add('ouvert');
    });
    fermer.addEventListener('click', fermerMenu);
    overlay.addEventListener('click', fermerMenu);
}

function fermerMenu() {
    menu.classList.remove('ouvert');
    overlay.classList.remove('ouvert');
}

const search = document.querySelector('.header-recherche');
if (search) {
    search.addEventListener('submit', (e) => {
        e.preventDefault();
        window.location.href = `../Catalogue/?q=${search.q.value}`;
    });
}