<header class="header">
    <div class="header-interieur">

        <!-- Logo -->
        <a href="#" class="header-logo">
            <img src="../ui/img/logo.png" alt="Logo Alizon" class="header-logo-image" />
        </a>

        <!-- Barre de recherche -->
        <form class="header-recherche" role="search" action="#" method="get">
            <button type="submit" class="header-recherche-bouton" aria-label="Lancer la recherche">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="search" name="q" class="header-recherche-champ" placeholder="Rechercher"
                aria-label="Rechercher un produit" />
        </form>

        <!-- Actions utilisateur -->
        <nav class="header-actions" aria-label="Actions utilisateur">

            <!-- Connexion -->
            <a href="#" class="header-action-connexion">
                <i class="fa-regular fa-user"></i>
                <span class="header-action-libelle">Se connecter</span>
            </a>

            <!-- Panier -->
            <a href="#" class="header-panier" aria-label="Mon panier">
                <i class="fa-solid fa-basket-shopping"></i>
                <span class="header-panier-compteur">100</span>
            </a>

            <button class="header-burger" id="burger" aria-label="Ouvrir le menu">
                <img src="img/navOpen.png" id="burger-img" alt="Menu" />
            </button>

        </nav>

    </div>

    <div class="header-overlay" id="overlay"></div>

    <nav class="header-menu-lateral" id="menu-lateral">
        <button class="header-menu-fermer" id="fermer" aria-label="Fermer le menu">
            <img src="img/navClose.png" alt="Fermer" />
        </button>
        <a href="#" class="header-menu-connexion">
            <i class="fa-regular fa-user"></i>
            Se connecter
        </a>
    </nav>
</header>

<script src="../js/header.js" defer></script>