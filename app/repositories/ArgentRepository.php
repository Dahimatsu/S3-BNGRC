<?php
namespace app\repositories;

use PDO;

class ArgentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getArgentId() {
        $stmt = $this->pdo->query("SELECT id FROM articles WHERE nom = 'Argent'");

        return $stmt->fetchColumn();
    }
}