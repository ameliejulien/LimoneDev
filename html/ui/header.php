<!-- Ajouter dans le head :  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->

<header class="header">
    <div class="header-interieur">
        
        <?php
            require_once '../../lib/service/ServiceUtilisateur.php';
            require_once __DIR__ . '/../../lib/Constantes.php';


            $panier = isset($_COOKIE['panier']) ? (array) json_decode($_COOKIE['panier']) : [];
            $nbPanier = count($panier);
            
            $typeUtilisateur = null;
            if (isset($_COOKIE['uuid']) && !empty($_COOKIE['uuid'])) {
                $utilisateur = recupererInfosUtilisateur($_COOKIE['uuid']);
                $typeUtilisateur = $utilisateur['type_utilisateur'];
            }
        ?>

        <!-- Logo -->
        <a href="/Catalogue/index.php" class="header-logo">
            <img src="/ui/img/logo.png" alt="Logo Alizon" title="Logo Alizon" class="header-logo-image" />
        </a>

        <!-- Barre de recherche -->
        <?php if ($typeUtilisateur !== TYPE_VENDEUR): ?>
        <form class="header-recherche" role="search" method="get">
            <button type="submit" title="Rechercher" class="header-recherche-bouton" aria-label="Lancer la recherche">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <input type="search" name="q" title="Barre de recherche" class="header-recherche-champ" placeholder="Rechercher un produit"
                aria-label="Rechercher un produit" />
        </form>
        <?php endif; ?>

        <!-- Actions utilisateur -->
        <nav class="header-actions" aria-label="Actions utilisateur">

            <?php if ($typeUtilisateur === TYPE_VENDEUR): ?>
                <!-- Vendeur connecté -->
                <a href="/Vendeur/ConsulterCompteVendeur.php" title="Mon compte vendeur" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle"><?= htmlspecialchars($utilisateur['email_utilisateur']) ?></span>
                </a>
            <?php elseif ($typeUtilisateur === TYPE_CLIENT): ?>
                <!-- Client connecté -->
                <a href="/Client/ConsulterCompteClient.php" title="Mon compte client" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle"><?= htmlspecialchars($utilisateur['email_utilisateur']) ?></span>
                </a>
            <?php else: ?>
                <!-- Non connecté -->
                <a href="/Connexion" title="Bouton de connexion" class="header-action-connexion">
                    <i class="fa-regular fa-user"></i>
                    <span class="header-action-libelle">Se connecter</span>
                </a>
                <a href="/Client/CreerCompteClient.php" title="Bouton de création de compte" class="header-action-connexion">
                    <span class="header-action-libelle">Créer un compte</span>
                </a>
            <?php endif; ?>

            <!-- Panier -->
            <?php if ($typeUtilisateur !== TYPE_VENDEUR): ?>
                <a href="/Panier/index.php" title="Panier" class="header-panier" aria-label="Mon panier">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span title="Total des produits" class="header-panier-compteur"><?= $nbPanier ?></span>
                </a>
            <?php endif; ?>

            <button class="header-burger" id="burger" aria-label="Ouvrir le menu" title="Ouvrir le menu">
                <img src="/ui/img/navOpen.png" id="burger-img" alt="Menu" />
            </button>

        </nav>

    </div>

    <div class="header-overlay" id="overlay"></div>

    <nav class="header-menu-lateral" id="menu-lateral">
        <button class="header-menu-fermer" id="fermer" aria-label="Fermer le menu" title="Fermer le menu">
            <img src="/ui/img/navClose.png" alt="Fermer" />
        </button>
        <?php if ($typeUtilisateur === TYPE_VENDEUR): ?>
            <!-- Vendeur connecté -->
            <a href="/Vendeur/ConsulterCompteVendeur.php" title="Mon compte vendeur" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                <span class="header-action-libelle"><?= htmlspecialchars($utilisateur['email_utilisateur']) ?></span>
            </a>
        <?php elseif ($typeUtilisateur === TYPE_CLIENT): ?>
            <!-- Client connecté -->
            <a href="/Client/ConsulterCompteClient.php" title="Mon compte client" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                <span class="header-action-libelle"><?= htmlspecialchars($utilisateur['email_utilisateur']) ?></span>
            </a>
        <?php else: ?>
            <!-- Non connecté -->
            <a href="/Connexion" title="Bouton de connexion" class="header-menu-connexion">
                <i class="fa-regular fa-user"></i>
                Se connecter
            </a>
            <a href="/Client/CreerCompteClient.php" title="Bouton de création de compte" class="header-menu-connexion">
                Créer un compte
            </a>
        <?php endif; ?>
    </nav>
</header>

<script src="/js/header.js" defer></script>