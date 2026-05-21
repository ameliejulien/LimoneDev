
<!-- Ajouter dans le head :  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->

<header class="header">
    <div class="header-interieur">

        <?php
            $panier = isset($_COOKIE['panier']) ? (array) json_decode($_COOKIE['panier']) : [];
            $nbPanier = count($panier);

            $clientConnecte = null;
            $vendeurConnecte = null;
            if (isset($_COOKIE['client']) && !empty($_COOKIE['client'])) {
                $clientConnecte = json_decode($_COOKIE['client'], true);
            } else if (isset($_COOKIE['vendeur']) && !empty($_COOKIE['vendeur'])) {
                $vendeurConnecte = json_decode($_COOKIE['vendeur'], true);
            }
        ?>

        <!-- Logo -->
        <?php if (!$vendeurConnecte): ?>
            <a href="/Catalogue/index.php" class="header-logo">
                <img src="/ui/img/logo.png" alt="Logo Alizon" class="header-logo-image" />
            </a>
        <?php else: ?>
            <a href="/Catalogue/CatalogueVendeur.php" class="header-logo">
                <img src="/ui/img/logo.png" alt="Logo Alizon" class="header-logo-image" />
            </a>
        <?php endif; ?>

        <!-- Barre de recherche -->
        <?php if (!$vendeurConnecte): ?>
        <form class="header-recherche" role="search" method="get">
            <button type="submit" class="header-recherche-bouton" aria-label="Lancer la recherche">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="search" name="q" class="header-recherche-champ" placeholder="Rechercher"
                aria-label="Rechercher un produit" />
        </form>
        <?php endif; ?>

        <!-- Actions utilisateur -->
        <nav class="header-actions" aria-label="Actions utilisateur">

            <?php if ($vendeurConnecte): ?>
                <!-- Vendeur connecté -->
                <a href="/Vendeur/ConsulterCompteVendeur.php" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle"><?= htmlspecialchars($vendeurConnecte['mail']) ?></span>
                </a>
            <?php elseif ($clientConnecte): ?>
                <!-- Client connecté -->
                <a href="/Client/ConsulterCompteClient.php" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle"><?= htmlspecialchars($clientConnecte['mail']) ?></span>
                </a>
            <?php else: ?>
                <!-- Non connecté -->
                <a href="/Connexion" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle">Se connecter</span>
                </a>
                <a href="/Client/CreerCompteClient.php" class="header-action-connexion">
                    <span class="header-action-libelle">Créer un compte</span>
                </a>
            <?php endif; ?>

            <!-- Panier -->
            <?php if ($clientConnecte): ?>
                <a href="/Panier/index.php" class="header-panier" aria-label="Mon panier">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span class="header-panier-compteur"><?= $nbPanier ?></span>
                </a>
            <?php endif; ?>

            <button class="header-burger" id="burger" aria-label="Ouvrir le menu">
                <img src="/ui/img/navOpen.png" id="burger-img" alt="Menu" />
            </button>

        </nav>

    </div>

    <div class="header-overlay" id="overlay"></div>

    <nav class="header-menu-lateral" id="menu-lateral">
        <button class="header-menu-fermer" id="fermer" aria-label="Fermer le menu">
            <img src="/ui/img/navClose.png" alt="Fermer" />
        </button>
        <?php if ($vendeurConnecte): ?>
            <!-- Vendeur connecté -->
            <a href="/Vendeur/ConsulterCompteVendeur.php" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                <span class="header-action-libelle"><?= htmlspecialchars($vendeurConnecte['mail']) ?></span>
            </a>
        <?php elseif ($clientConnecte): ?>
            <!-- Client connecté -->
            <a href="/Client/ConsulterCompteClient.php" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                <span class="header-action-libelle"><?= htmlspecialchars($clientConnecte['mail']) ?></span>
            </a>
        <?php else: ?>
            <!-- Non connecté -->
            <a href="/Connexion" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                Se connecter
            </a>
            <a href="/Client/CreerCompteClient.php" class="header-menu-connexion">
                Créer un compte
            </a>
        <?php endif; ?>
    </nav>
</header>

<script src="/js/header.js" defer></script>