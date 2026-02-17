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
            // 1. Désactiver les contraintes pour éviter les blocages SQL
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

            // 2. Nettoyage des tables de données
            $this->pdo->exec("DELETE FROM achats");
            $this->pdo->exec("DELETE FROM distributions");
            $this->pdo->exec("DELETE FROM stock_dons");
            $this->pdo->exec("DELETE FROM besoins_villes");

            // 3. Insertion des 10 Besoins par défaut
            $besoins = [
                [1, 1, 500],
                [1, 2, 200],
                [2, 1, 300],
                [2, 3, 50],
                [3, 2, 100],
                [3, 4, 20],
                [4, 1, 450],
                [4, 5, 1000000],
                [5, 2, 150],
                [5, 3, 30]
            ];
            $sqlBesoin = "INSERT INTO besoins_villes (id_ville, id_article, quantite_demandee) VALUES (?, ?, ?)";
            $stmtBesoin = $this->pdo->prepare($sqlBesoin);
            foreach ($besoins as $besoin) {
                $stmtBesoin->execute($besoin);
            }

            // 4. Insertion des 10 Dons par défaut
            $dons = [
                [1, 1000, '2026-02-01'],
                [2, 500, '2026-02-02'],
                [3, 100, '2026-02-03'],
                [4, 50, '2026-02-04'],
                [5, 2000000, '2026-02-05'],
                [1, 200, '2026-02-06'],
                [2, 300, '2026-02-07'],
                [3, 80, '2026-02-08'],
                [4, 150, '2026-02-09'],
                [5, 500000, '2026-02-10']
            ];
            $sqlDon = "INSERT INTO stock_dons (id_article, quantite_recue, date_reception) VALUES (?, ?, ?)";
            $stmtDon = $this->pdo->prepare($sqlDon);
            foreach ($dons as $d) {
                $stmtDon->execute($d);
            }

            // 5. Réactiver les contraintes
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            // DEBUG : Affiche l'erreur dans les logs de PHP ou via var_dump pour comprendre
            // error_log($e->getMessage()); 
            return false;
        }
    }
}