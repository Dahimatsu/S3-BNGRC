DROP DATABASE IF EXISTS 4054_Fanampy;

CREATE DATABASE 4054_Fanampy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE 4054_Fanampy;

CREATE TABLE user (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE regions (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE villes (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(100) NOT NULL,
    id_region INT NOT NULL,
    FOREIGN KEY (id_region) REFERENCES regions(id)
);

CREATE TABLE articles (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    nom               VARCHAR(100) NOT NULL,
    unite             VARCHAR(20) NOT NULL,
    prix_unitaire     DECIMAL(10,2) DEFAULT 0,
    pourcentage_vente DECIMAL(5,2) DEFAULT 10
);

CREATE TABLE besoins_villes (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    id_ville          INT NOT NULL,
    id_article        INT NOT NULL,
    quantite_demandee DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES villes(id),
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

CREATE TABLE stock_dons (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    id_article     INT NOT NULL,
    quantite_recue DECIMAL(15, 2) NOT NULL,
    date_reception DATE NOT NULL,
    FOREIGN KEY (id_article) REFERENCES articles(id)
);

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

INSERT INTO regions (id, nom) VALUES
    (1, 'Analamanga'),
    (2, 'Atsinanana'),
    (3, 'Vatovavy'),
    (4, 'Fitovinany'),
    (5, 'Diana'),
    (6, 'Menabe');

INSERT INTO villes (id, nom, id_region) VALUES
    (1, 'Toamasina', 2),
    (2, 'Mananjary', 3),
    (3, 'Farafangana', 4),
    (4, 'Nosy Be', 5),
    (5, 'Morondava', 6);

INSERT INTO articles (id, nom, prix_unitaire, unite, pourcentage_vente) VALUES
    (1, 'Argent', 1, 'Ar', 0),
    (2, 'Riz', 3000, 'kg', 10),
    (3, 'Eau', 1000, 'L', 10),
    (4, 'Tôle', 25000, 'pièce', 10),
    (5, 'Bâche', 15000, 'pièce', 10),
    (6, 'Huile', 6000, 'L', 10),
    (7, 'Clous', 8000, 'kg', 10),
    (8, 'Bois', 10000, 'pièce', 10),
    (9, 'Haricots', 4000, 'kg', 10);      

INSERT INTO besoins_villes (id_ville, id_article, quantite_demandee) VALUES
    (1, 5, 200),
    (4, 4, 40),
    (2, 1, 6000000),
    (1, 3, 1500),
    (4, 2, 300),
    (2, 4, 80),
    (4, 1, 4000000),
    (3, 5, 150),
    (2, 2, 500),
    (3, 1, 8000000),
    (5, 2, 700),
    (1, 1, 12000000),
    (5, 1, 10000000),
    (3, 3, 1000),
    (5, 5, 180),
    (1, 2, 800),
    (4, 9, 200),
    (2, 7, 60),
    (5, 3, 1200),
    (3, 2, 600),
    (5, 8, 150),
    (1, 4, 120),
    (4, 7, 30),
    (2, 6, 120),
    (3, 8, 100);

INSERT INTO stock_dons (id_article, quantite_recue, date_reception) VALUES
    (1, 5000000, '2026-02-16'),
    (1, 3000000, '2026-02-16'),
    (1, 4000000, '2026-02-17'),
    (1, 1500000, '2026-02-17'),
    (1, 6000000, '2026-02-17'),
    (2, 400, '2026-02-16'),
    (3, 600, '2026-02-16'),
    (4, 50, '2026-02-17'),
    (5, 70, '2026-02-17'),
    (9, 100, '2026-02-17'),
    (2, 2000, '2026-02-18'),
    (4, 300, '2026-02-18'),
    (3, 5000, '2026-02-18'),
    (1, 20000000, '2026-02-19'),
    (5, 500, '2026-02-19'),
    (9, 88, '2026-02-17');