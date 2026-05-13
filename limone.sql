DROP SCHEMA IF EXISTS  limone CASCADE;
CREATE SCHEMA limone;


-- =======================
-- ======= Adresse =======
-- =======================
CREATE TABLE limone.Adresse (
    id_adresse serial PRIMARY KEY,
    addresse varchar(30),
    ville_addresse varchar (20),
    code_postal_adresse varchar(5),
    facturation_adresse boolean
);

-- ==============================
-- ======= Carte bancaire =======
-- ==============================
CREATE TABLE limone.Carte_Bancaire (
    id_carte serial PRIMARY KEY,
    num_carte  bigint,
    expiration_carte int,
    ccv_carte int,
    nom_carte varchar(30)
);


-- ===========================
-- ======= Type =======
-- ===========================
CREATE TABLE limone.Type (
    id_type serial PRIMARY KEY,
    nom_type varchar(20)
);


-- ===========================
-- ======= Utilisateur =======
-- ===========================
CREATE TABLE limone.Utilisateur (
    id_utilisateur serial PRIMARY KEY,
    email_utilisateur varchar(20),
    mdp_utilisateur varchar(72),
    pp_utiisateur bytea,
    type_utilisateur int,
    CONSTRAINT fk_utilisateur FOREIGN KEY(type_utilisateur) REFERENCES limone.Type(id_type)
);


-- ======================
-- ======= Client =======
-- ======================
CREATE TABLE limone.Client (
    id_client int,
    CONSTRAINT fk1_client FOREIGN KEY (id_client) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT pk_client PRIMARY KEY (id_client)
);


-- ============================
-- ======= Gestionnaire =======
-- ============================
CREATE TABLE limone.Gestionnaire (
    id_gestionnaire int,
    CONSTRAINT fk_gestionnaire FOREIGN KEY (id_gestionnaire) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT pk_gestionnaire PRIMARY KEY (id_gestionnaire)
);


-- =======================
-- ======= Vendeur =======
-- =======================
CREATE TABLE limone.Vendeur (
    id_vendeur int,
    denomination_vendeur varchar(30),
    siret_vendeur bigint,
    ca_vendeur numeric,
    addresse_vendeur int,
    CONSTRAINT fk1_vendeur FOREIGN KEY (id_vendeur) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT fk2_vendeur FOREIGN KEY (addresse_vendeur) REFERENCES limone.Adresse(id_adresse),
    CONSTRAINT pk_vendeur PRIMARY KEY (id_vendeur)
);


-- =========================
-- ======= Produit ========
-- =========================
CREATE TABLE limone.Produit (
    id_produit serial PRIMARY KEY,
    nom_produit varchar(30),
    description_produit text,
    prix_ht_produit numeric,
    stock_produit int,
    catalogue_produit boolean,
    promotion_produit boolean,
    reduction_produit numeric,
    tva_produit numeric,
    produit_supprime boolean,
    vendeur_produit int,
    CONSTRAINT fk_produit FOREIGN KEY (vendeur_produit) REFERENCES limone.Vendeur(id_vendeur)
);

-- ==============================
-- ======= Photo Produit ========
-- ==============================
CREATE TABLE limone.Photo_Produit (
    id_photo_produit serial PRIMARY KEY,
    photo_produit bytea,
    photo_principale boolean
);

-- =============================================
-- ======= Illustre (photo <-> produit) ========
-- =============================================
CREATE TABLE limone.Illustre (
    id_photo_produit integer,
    id_produit integer,
    CONSTRAINT fk1_illustre FOREIGN KEY (id_photo_produit) REFERENCES limone.Photo_Produit(id_photo_produit),
    CONSTRAINT fk2_illustre FOREIGN KEY (id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT pk_illustre PRIMARY KEY (id_produit, id_photo_produit)
);


-- =======================
-- ======= Panier ========
-- =======================
CREATE TABLE limone.Panier (
    id_utilisateur integer,
    id_produit integer,
    quantite integer,
    CONSTRAINT fk1_panier FOREIGN KEY (id_utilisateur) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT fk2_panier FOREIGN KEY (id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT pk_panier PRIMARY KEY (id_utilisateur, id_produit)
);



-- ====================================================
-- ======= Addresse Client (Client <-> Adresse) =======
-- ====================================================
CREATE TABLE limone.Adresse_Client (
    id_utilisateur integer,
    id_adresse integer,
    CONSTRAINT fk1_adresse_client FOREIGN KEY (id_utilisateur) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT fk2_adresse_client FOREIGN KEY (id_adresse) REFERENCES limone.Adresse(id_adresse),
    CONSTRAINT pk_adresse_client PRIMARY KEY (id_utilisateur, id_adresse)
);


-- ====================================================
-- ======= Addresse Vendeur (Vendeur <-> Adresse) =======
-- ====================================================
CREATE TABLE limone.Adresse_Vendeur (
    id_utilisateur integer,
    id_adresse integer,
    CONSTRAINT fk1_adresse_vendeur FOREIGN KEY (id_utilisateur) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT fk2_adresse_vendeur FOREIGN KEY (id_adresse) REFERENCES limone.Adresse(id_adresse),
    CONSTRAINT pk_adresse_vendeur PRIMARY KEY (id_utilisateur, id_adresse)
);


-- ====================================================
-- ======= Carte Client (Client <-> Adresse) ==========
-- ====================================================
CREATE TABLE limone.Carte_Client (
    id_utilisateur integer,
    id_carte integer,
    CONSTRAINT fk1_carte_client FOREIGN KEY (id_utilisateur) REFERENCES limone.Utilisateur(id_utilisateur),
    CONSTRAINT fk2_carte_client FOREIGN KEY (id_carte) REFERENCES limone.Carte_Bancaire(id_carte),
    CONSTRAINT pk_adresse PRIMARY KEY (id_utilisateur, id_carte)
);

-- ============================
-- ======= Categorie ==========
-- ============================
CREATE TABLE limone.Categorie (
    id_categorie serial PRIMARY KEY,
    nom_categorie varchar(10)
);


-- ====================================
-- ======= Categorie Produit ==========
-- ====================================
CREATE TABLE limone.Categorie_Produit (
    id_categorie int,
    id_produit int,
    CONSTRAINT fk1_categorie_produit FOREIGN KEY(id_categorie) REFERENCES limone.Categorie(id_categorie),
    CONSTRAINT fk2_categorie_produit FOREIGN KEY(id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT pk_categorie_produit PRIMARY KEY (id_produit, id_categorie)
);


-- =================================
-- ======= Liste_Produits ==========
-- =================================
CREATE TABLE limone.Liste_Produits (
    id_client int,
    id_produit int,
    CONSTRAINT fk1_liste_produit FOREIGN KEY(id_client) REFERENCES limone.Client(id_client),
    CONSTRAINT fk2_liste_produit FOREIGN KEY(id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT pk_liste_produit PRIMARY KEY (id_client, id_produit)
);

-- =======================
-- ======= Etat ==========
-- =======================
CREATE TABLE limone.Etat (
    id_etat int,
    nom_etat varchar(20),
    CONSTRAINT pk_etat PRIMARY KEY(id_etat)
);


-- =================================
-- ======= Liste Produits ==========
-- =================================
CREATE TABLE limone.Commande (
    id_commande serial,
    etat int,
    CONSTRAINT fk_commande FOREIGN KEY (etat) REFERENCES limone.Etat(id_etat),
    CONSTRAINT pk_commande PRIMARY KEY (id_commande)
);


-- ==========================
-- ======= Facture ==========
-- ==========================
CREATE TABLE limone.Facture (
    id_facture serial PRIMARY KEY,
    nom_client_facture varchar(30),
    denomination_vendeur_facture varchar(30),
    siret_vendeur_facture int,
    date_facture date,
    adresse_client_facture int,
    adresse_vendeur_facture int,
    CONSTRAINT fk1_facture FOREIGN KEY (adresse_client_facture) REFERENCES limone.Adresse(id_adresse),
    CONSTRAINT fk2_facture FOREIGN KEY (adresse_vendeur_facture) REFERENCES limone.Adresse(id_adresse)
);



CREATE TABLE limone.Achat (
    id_achat serial PRIMARY KEY,
    id_client int,
    id_produit int,
    id_facture int,
    id_commande int,
    id_vendeur int,
    CONSTRAINT fk1_achat FOREIGN KEY (id_client) REFERENCES limone.Client(id_client),
    CONSTRAINT fk2_achat FOREIGN KEY (id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT fk3_achat FOREIGN KEY (id_facture) REFERENCES limone.Facture(id_facture),
    CONSTRAINT fk4_achat FOREIGN KEY (id_commande) REFERENCES limone.Commande(id_commande),
    CONSTRAINT fk5_achat FOREIGN KEY (id_vendeur) REFERENCES limone.Vendeur(id_vendeur)

);


create table limone.Ligne_Commande (
    id_ligne_commande serial PRIMARY KEY,
    id_commande int,
    id_produit_commande int, 
    quantite int, 
    prix_ht_commande numeric,
    tva_commande numeric,
    CONSTRAINT fk1_ligne_commande FOREIGN KEY (id_commande) REFERENCES limone.Commande(id_commande),
    CONSTRAINT fk2_ligne_commande FOREIGN KEY (id_produit_commande) REFERENCES limone.Produit(id_produit)
);