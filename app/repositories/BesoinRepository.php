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

    // public function getBesoinVille_byId($id_ville)
    // {
    //     $query = "SELECT * FROM vue_besoins_par_ville WHERE ville_id = ?";
    //     $st = $this->pdo->prepare($query);
    //     $st->execute([
    //         $id_ville
    //     ]);
    //     return $st->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function getAllBesoin()
    // {
    //             $query = "SELECT 
    //         v.nom AS villeNom,
    //         a.nom AS articleNom,
    //         a.unite,
    //         b.quantite_demandee
    //     FROM besoins_villes b
    //     JOIN villes v ON v.id = b.id_ville
    //     JOIN articles a ON a.id = b.id_article
    //     ";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getBesoinsGroupesParVille()
{
    $query = "
        SELECT 
            v.nom AS villeNom,
            a.nom AS articleNom,
            a.unite,
            b.quantite_demandee
        FROM besoins_villes b
        JOIN villes v ON v.id = b.id_ville
        JOIN articles a ON a.id = b.id_article
        ORDER BY v.nom
    ";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped = [];

    foreach ($result as $row) {
        $grouped[$row['villeNom']][] = $row;
    }

    return $grouped;
}

}