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

    public function getAllArticles()
    {
        $query = "SELECT id, nom, unite, prix_unitaire FROM articles";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


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

    public function getAvailableStock($id_article)
    {
        $query = "SELECT SUM(quantite_recue) FROM stock_dons WHERE id_article = ?";
        $st = $this->pdo->prepare($query);
        $st->execute([$id_article]);
        $totalRecu = $st->fetchColumn() ?: 0;

        $queryDist = "SELECT SUM(quantite_donnee) FROM distributions WHERE id_article = ?";
        $stDist = $this->pdo->prepare($queryDist);
        $stDist->execute([$id_article]);
        $totalDistribue = $stDist->fetchColumn() ?: 0;

        return $totalRecu - $totalDistribue;
    }

    public function getGlobalStockStatus()
    {
        $query = "SELECT 
                a.nom, 
                a.unite, 
                a.prix_unitaire,
                (
                    IFNULL((SELECT SUM(quantite_recue) FROM stock_dons WHERE id_article = a.id), 0) - 
                    IFNULL((SELECT SUM(quantite_donnee) FROM distributions WHERE id_article = a.id), 0)
                ) as total_stock
              FROM articles a
              GROUP BY a.id, a.nom, a.unite";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveDistribution($id_ville, $id_article, $quantite)
    {
        $query = "INSERT INTO distributions (id_ville, id_article, quantite_donnee) VALUES (?, ?, ?)";
        $st = $this->pdo->prepare($query);
        return $st->execute([
            (int) $id_ville,
            (int) $id_article,
            (float) $quantite
        ]);
    }
}