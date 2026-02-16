<?php

namespace app\repositories;

use PDO;

class VilleRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllVille()
    {
        $query = "SELECT id, nom
                  FROM villes";

        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}