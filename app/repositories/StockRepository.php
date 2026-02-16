<?php

namespace app\repositories;

use PDO;

class StockRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer tous les articles pour tes listes déroulantes (Riz, Huile, Argent, etc.)
    public function getAllArticles()
    {
        $query = "SELECT id, nom, unite FROM articles";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistrer un nouveau don reçu (Entrée en stock)
    public function saveDonation($id_article, $quantite, $date_reception)
    {
        $query = "INSERT INTO stock_dons (id_article, quantite_recue, date_reception) 
                  VALUES (?, ?, ?)";

        $st = $this->pdo->prepare($query);
        $st->execute([
            $id_article,
            $quantite,
            $date_reception
        ]);

        return $this->pdo->lastInsertId();
    }

    // Calculer le stock TOTAL disponible pour un article spécifique
    // Utile pour la règle : "Erreur si quantité donnée > stock"
    public function getAvailableStock($id_article)
    {
        // On fait la somme de tout ce qu'on a reçu
        $query = "SELECT SUM(quantite_recue) as total FROM stock_dons WHERE id_article = ?";

        $st = $this->pdo->prepare($query);
        $st->execute([$id_article]);

        $totalRecu = $st->fetchColumn() ?: 0;

        // On soustrait ce qui a déjà été distribué
        $queryDist = "SELECT SUM(d.quantite_donnee) 
                      FROM distributions d
                      JOIN besoins_villes bv ON d.id_besoin = bv.id
                      WHERE bv.id_article = ?";

        $stDist = $this->pdo->prepare($queryDist);
        $stDist->execute([$id_article]);

        $totalDistribue = $stDist->fetchColumn() ?: 0;

        return $totalRecu - $totalDistribue;
    }

    // Pour ton tableau de bord : liste globale du stock actuel
    public function getGlobalStockStatus()
    {
        $query = "SELECT a.nom, a.unite, SUM(s.quantite_recue) as total_stock
                  FROM articles a
                  LEFT JOIN stock_dons s ON a.id = s.id_article
                  GROUP BY a.id, a.nom, a.unite";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}