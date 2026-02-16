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
        $query = "SELECT id, nom, unite FROM articles";
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
        $query = "SELECT SUM(quantite_recue) as total FROM stock_dons WHERE id_article = ?";

        $st = $this->pdo->prepare($query);
        $st->execute([$id_article]);

        $totalRecu = $st->fetchColumn() ?: 0;

        $queryDist = "SELECT SUM(d.quantite_donnee) 
                      FROM distributions d
                      JOIN besoins_villes bv ON d.id_besoin = bv.id
                      WHERE bv.id_article = ?";

        $stDist = $this->pdo->prepare($queryDist);
        $stDist->execute([$id_article]);

        $totalDistribue = $stDist->fetchColumn() ?: 0;

        return $totalRecu - $totalDistribue;
    }

    public function getGlobalStockStatus()
    {
        $query = "SELECT a.nom, a.unite, SUM(s.quantite_recue) as total_stock
                  FROM articles a
                  LEFT JOIN stock_dons s ON a.id = s.id_article
                  GROUP BY a.id, a.nom, a.unite";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingNeeds()
    {
        $query = "SELECT bv.id, v.nom as ville, a.nom as article, a.unite, a.id as id_article,
              bv.quantite_demandee - IFNULL(SUM(d.quantite_donnee), 0) as reste
              FROM besoins_villes bv
              JOIN villes v ON bv.id_ville = v.id
              JOIN articles a ON bv.id_article = a.id
              LEFT JOIN distributions d ON d.id_besoin = bv.id
              GROUP BY bv.id
              HAVING reste > 0";
        
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