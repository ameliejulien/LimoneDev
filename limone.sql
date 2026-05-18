DROP SCHEMA IF EXISTS  limone CASCADE;
CREATE SCHEMA limone;


-- =======================
-- ======= Adresse =======
-- =======================
CREATE TABLE limone.Adresse (
    id_adresse serial PRIMARY KEY,
    adresse varchar(30),
    ville_adresse varchar (30),
    code_postal_adresse varchar(5),
    facturation_adresse boolean

-- ===========================
-- ======= Commande ==========
-- ===========================
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