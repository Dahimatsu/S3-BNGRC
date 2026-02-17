<?php

namespace app\repositories;

use PDO;

class ArticleRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllArticles()
    {
        $query = "SELECT * FROM articles";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePourcentage($id_article, $percent)
    {
        $sql = "UPDATE articles SET pourcentage_vente = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([$percent, $id_article]);
    }
}