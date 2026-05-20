<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Header - Alizon</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alatsi&family=Farro:wght@300;400;500;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Feuille de style principale du projet -->
        <link rel="stylesheet" href="../Global.css">
    </head>
    <body>
        <header class="header">
            <div class="header-interieur">

                <!-- Logo -->
                <a href="#" class="header-logo">
                    <img src="img/logo.png" alt="Logo Alizon" class="header-logo-image" />
                </a>

                <!-- Barre de recherche -->
                <form class="header-recherche" role="search" action="#" method="get">
                    <button type="submit" class="header-recherche-bouton" aria-label="Lancer la recherche">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input
                        type="search"
                        name="q"
                        class="header-recherche-champ"
                        placeholder="Rechercher"
                        aria-label="Rechercher un produit"
                    />
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
</body>
</html>