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
                [3, 1, 8000000]
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
                [5, 70, '2026-02-17']
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