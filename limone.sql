DROP SCHEMA IF EXISTS  limone CASCADE;
CREATE SCHEMA limone;

-- =======================
-- ======= Adresse =======
-- =======================
CREATE TABLE limone.Adresse (
    id_adresse serial PRIMARY KEY,
    adresse varchar(50),
    ville_adresse varchar (30),
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
    nom_utilisateur varchar(30),
    email_utilisateur varchar(320),
    telephone_utilisateur varchar(15),
    mdp_utilisateur varchar(72),
    pp_utilisateur bytea,
    type_utilisateur int,

    CONSTRAINT fk_utilisateur FOREIGN KEY(type_utilisateur) REFERENCES limone.Type(id_type)
);

-- ================================
-- ======= Utilisateur UUID =======
-- ================================
CREATE TABLE limone.Utilisateur_UUID (
    id_utilisateur int,
    uuid_utilisateur uuid DEFAULT uuidv7(),

    CONSTRAINT pk_utilisateur_uuid PRIMARY KEY(id_utilisateur, uuid_utilisateur),
    CONSTRAINT fk_utilisateur_uuid FOREIGN KEY(id_utilisateur) REFERENCES limone.Utilisateur(id_utilisateur)
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
    nom_produit varchar(100),
    description_produit text,
    prix_ht_produit numeric,
    stock_produit int,
    catalogue_produit boolean,
    promotion_produit boolean,
    reduction_produit numeric,
    tva_produit numeric,
    produit_supprime boolean,
    vendeur_produit int,
    nb_ventes_produit int,

    CONSTRAINT fk_produit FOREIGN KEY (vendeur_produit) REFERENCES limone.Vendeur(id_vendeur)
);

-- ==============================
-- ======= Photo Produit ========
-- ==============================
CREATE TABLE limone.Photo_Produit (
    id_photo_produit serial PRIMARY KEY,
    id_produit int,
    photo_produit varchar(30),
    photo_principale boolean,

    CONSTRAINT fk_photo_produit FOREIGN KEY (id_produit) REFERENCES limone.Produit(id_produit)
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
    nom_categorie varchar(30)
);

-- ====================================
-- ======= Categorie Produit ==========
-- ====================================
CREATE TABLE limone.Categorie_Produit (
    id_produit int,
    id_categorie int,

    CONSTRAINT pk_categorie_produit PRIMARY KEY (id_produit, id_categorie),
    CONSTRAINT fk1_categorie_produit FOREIGN KEY(id_categorie) REFERENCES limone.Categorie(id_categorie),
    CONSTRAINT fk2_categorie_produit FOREIGN KEY(id_produit) REFERENCES limone.Produit(id_produit)
);

-- =======================
-- ======= Etat ==========
-- =======================
CREATE TABLE limone.Etat (
    id_etat int,
    nom_etat varchar(20),

    CONSTRAINT pk_etat PRIMARY KEY(id_etat)
);

-- ===========================
-- ======= Commande ==========
-- ===========================
CREATE TABLE limone.Commande (
    id_commande serial,
    id_suivi_livraison varchar(30),
    etat int,

    CONSTRAINT pk_commande PRIMARY KEY (id_commande),
    CONSTRAINT fk_commande FOREIGN KEY (etat) REFERENCES limone.Etat(id_etat)
);

-- ==========================
-- ======= Facture ==========
-- ==========================
CREATE TABLE limone.Facture (
    id_facture serial PRIMARY KEY,
    nom_client_facture varchar(30),
    telephone_client_facture varchar(15),
    email_client_facture varchar(320),
    adresse_client_facture varchar(50),
    ville_client_facture varchar(30),
    code_postal_client_facture varchar(5),
    adresse_facturation_client_facture varchar(50),
    ville_facturation_client_facture varchar(30),
    code_postal_facturation_client_facture varchar(5),
    adresse_alizon_facture varchar(50),
    ville_alizon_facture varchar(30),
    code_postal_alizon_facture varchar(5)
);

-- ==========================
-- ======= Achat ==========
-- ==========================
CREATE TABLE limone.Achat (
    id_achat serial PRIMARY KEY,
    id_client int,
    id_produit int,
    id_facture int,
    id_commande int,

    CONSTRAINT fk1_achat FOREIGN KEY (id_client) REFERENCES limone.Client(id_client),
    CONSTRAINT fk2_achat FOREIGN KEY (id_produit) REFERENCES limone.Produit(id_produit),
    CONSTRAINT fk3_achat FOREIGN KEY (id_facture) REFERENCES limone.Facture(id_facture),
    CONSTRAINT fk4_achat FOREIGN KEY (id_commande) REFERENCES limone.Commande(id_commande)
);

-- ==========================
-- ======= Commande ==========
-- ==========================
create table limone.Ligne_Commande (
    id_ligne_commande serial PRIMARY KEY,
    id_commande int,
    id_produit_commande int,
    nom_produit varchar(100), 
    quantite int, 
    prix_ht_commande numeric,
    tva_commande numeric,

    CONSTRAINT fk1_ligne_commande FOREIGN KEY (id_commande) REFERENCES limone.Commande(id_commande),
    CONSTRAINT fk2_ligne_commande FOREIGN KEY (id_produit_commande) REFERENCES limone.Produit(id_produit)
);



-- =======================================
-- ======= Clé authentification ==========
-- =======================================
create table limone.Cle_Authentification (
    clee VARCHAR(10) PRIMARY KEY,
    utilisee BOOLEAN
);