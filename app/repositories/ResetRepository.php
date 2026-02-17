<?php
namespace app\repositories;

use PDO;

class ResetRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function reinitialiserTout()
    {
        $this->pdo->beginTransaction();

        try {
            // 1. Nettoyage ciblé : on ne touche pas aux structures (villes, articles, regions)
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $this->pdo->exec("TRUNCATE TABLE achats");
            $this->pdo->exec("TRUNCATE TABLE distributions");
            $this->pdo->exec("TRUNCATE TABLE stock_dons");
            $this->pdo->exec("TRUNCATE TABLE besoins_villes");
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            // 2. Insertion des 25 BESOINS (Ordre 1 à 26, sans le 16)
            $besoins = [
                [1, 5, 200],
                [4, 4, 40],
                [2, 1, 6000000],
                [1, 3, 1500],
                [4, 2, 300],
                [2, 4, 80],
                [4, 1, 4000000],
                [3, 5, 150],
                [2, 2, 500],
                [3, 1, 8000000],
                [5, 2, 700],
                [1, 1, 12000000],
                [5, 1, 10000000],
                [3, 3, 1000],
                [5, 5, 180],
                [1, 2, 800],
                [4, 9, 200],
                [2, 7, 60],
                [5, 3, 1200],
                [3, 2, 600],
                [5, 8, 150],
                [1, 4, 120],
                [4, 7, 30],
                [2, 6, 120],
                [3, 8, 100]
            ];

            $stmtB = $this->pdo->prepare("INSERT INTO besoins_villes (id_ville, id_article, quantite_demandee) VALUES (?, ?, ?)");
            foreach ($besoins as $b) {
                $stmtB->execute($b);
            }

            $dons = [
                [1, 5000000, '2026-02-16'],
                [1, 3000000, '2026-02-16'],
                [1, 4000000, '2026-02-17'],
                [1, 1500000, '2026-02-17'],
                [1, 6000000, '2026-02-17'],
                [2, 400, '2026-02-16'],
                [3, 600, '2026-02-16'],
                [4, 50, '2026-02-17'],
                [5, 70, '2026-02-17'],
                [9, 100, '2026-02-17'],
                [2, 2000, '2026-02-18'],
                [4, 300, '2026-02-18'],
                [3, 5000, '2026-02-18'],
                [1, 20000000, '2026-02-19'],
                [5, 500, '2026-02-19'],
                [9, 88, '2026-02-17']
            ];

            $stmtD = $this->pdo->prepare("INSERT INTO stock_dons (id_article, quantite_recue, date_reception) VALUES (?, ?, ?)");
            foreach ($dons as $d) {
                $stmtD->execute($d);
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}