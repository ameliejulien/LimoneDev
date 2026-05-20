// ============================================================
//  header.js  –  Gestion js du header
// ============================================================

const burger = document.getElementById('burger');
            const fermer = document.getElementById('fermer');
            const overlay = document.getElementById('overlay');
            const menu = document.getElementById('menu-lateral');

            burger.addEventListener('click', () => {
                menu.classList.add('ouvert');
                overlay.classList.add('ouvert');
            });
            fermer.addEventListener('click', fermerMenu);
            overlay.addEventListener('click', fermerMenu);

            function fermerMenu() {
                menu.classList.remove('ouvert');
                overlay.classList.remove('ouvert');
            }