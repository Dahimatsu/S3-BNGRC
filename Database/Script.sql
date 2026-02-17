DROP DATABASE IF EXISTS 4054_Fanampy;

CREATE DATABASE 4054_Fanampy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE 4054_Fanampy;

CREATE TABLE user (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- 1. Les Régions
CREATE TABLE regions (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- 2. Les Villes
CREATE TABLE villes (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(100) NOT NULL,
    id_region INT NOT NULL,
    FOREIGN KEY (id_region) REFERENCES regions(id)
);

-- 3. Les types d'articles (Riz, Tôle, Argent...)
CREATE TABLE articles (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    nom               VARCHAR(100) NOT NULL,
    unite             VARCHAR(20) NOT NULL,
    prix_unitaire     DECIMAL(10,2) DEFAULT 0,
    pourcentage_vente DECIMAL(5,2) DEFAULT 10
);

-- 4. Besoins saisis par ville
CREATE TABLE besoins_villes (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    id_ville          INT NOT NULL,
    id_article        INT NOT NULL,
    quantite_demandee DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES villes(id),
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

-- 5. Saisie des dons reçus (Stock global)
CREATE TABLE stock_dons (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    id_article     INT NOT NULL,
    quantite_recue DECIMAL(15, 2) NOT NULL,
    date_reception DATE NOT NULL,
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

-- 6. Attribution des dons aux besoins [cite: 15]
CREATE TABLE distributions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ville INT,
    id_article INT NOT NULL,
    quantite_donnee DECIMAL(15, 2) NOT NULL,
    date_distribution DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_article) REFERENCES articles(id),
    FOREIGN KEY (id_ville) REFERENCES villes(id)
);

CREATE TABLE achats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ville INT,
    id_article INT,
    quantite DECIMAL(10,2),
    montant_total DECIMAL(10,2),
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ville) REFERENCES villes(id),
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

CREATE TABLE ventes (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    id_article          INT,
    quantite            DECIMAL(10,2),
    prix_unitaire_vente DECIMAL(15,2),
    montant_total       DECIMAL(15,2),
    date_vente          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

CREATE VIEW vue_besoins_par_ville AS
SELECT 
        villes.id as ville_id,
        villes.nom as villeNom, 
        articles.nom as articleNom, 
        besoins_villes.quantite_demandee as qteDemandee
FROM 
villes JOIN besoins_villes ON villes.id = besoins_villes.id_ville 
JOIN articles ON besoins_villes.id_article = articles.id;

INSERT INTO regions (nom) VALUES
    ('Analamanga'),
    ('Atsinanana');

INSERT INTO villes (nom, id_region) VALUES
    ('Antananarivo', 1),
    ('Toamasina', 2),
    ('Fenerive Est', 2);

INSERT INTO articles (nom, unite, prix_unitaire, pourcentage_vente) VALUES
    ('Riz', 'kg', 1000.00, 10.00),         
    ('Huile', 'litre', 500.00, 15.00),      
    ('Tôle', 'pièce', 2500.00, 25.00),      
    ('Clous', 'kg', 350.00, 25.00),         
    ('Argent', 'Ar', 1.00, 15.00);       


INSERT INTO besoins_villes (id_ville, id_article, quantite_demandee) VALUES
    (1, 1, 500.00), 
    (1, 5, 1000000.00), 
    (2, 3, 200.00);  

INSERT INTO stock_dons (id_article, quantite_recue, date_reception) VALUES
    (1, 1000.00, '2026-02-16'),
    (3, 150.00, '2026-02-16'),
    (5, 500000.00, '2026-02-16');

INSERT INTO distributions (id_ville, id_article, quantite_donnee) VALUES
    (1, 1, 300.00); 