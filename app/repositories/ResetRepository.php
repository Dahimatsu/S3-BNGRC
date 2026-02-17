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
        $pdo = $this->pdo;
        
        try {
            $pdo->beginTransaction();
            $pdo->exec("DELETE FROM besoins_villes WHERE id > 10");
            $pdo->exec("DELETE FROM stock_dons WHERE id > 10");

            $pdo->commit();
            return true;
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}