<?php

namespace app\repositories;

use PDO;

class BesoinRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function createBesoin($id_ville, $id_article, $quantite)
    {
        $query = "INSERT INTO besoins_villes (id_ville, id_article, quantite_demandee) 
                  VALUES (?, ?, ?)";

        $st = $this->pdo->prepare($query);
        $st->execute([
            $id_ville,
            $id_article,
            $quantite
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAllVille()
    {
        $query = "SELECT id, nom
                  FROM villes";

        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
}