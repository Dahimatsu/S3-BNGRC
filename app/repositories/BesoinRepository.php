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

    public function getBesoinVille() 
    {
        $query = "SELECT * FROM vue_besoins_par_ville";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinVille_byId($id_ville)
    {
        $query = "SELECT * FROM vue_besoins_par_ville WHERE ville_id = ?";
        $st = $this->pdo->prepare($query);
        $st->execute([
            $id_ville
        ]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}