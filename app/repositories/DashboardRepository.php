<?php 

namespace app\repositories;

use PDO;

class DashboardRepository
{    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDashboard()
    {
        $query = "SELECT 
                v.id as idVille,
                v.nom as nomVille, 
                a.id as idArticle,
                a.nom as nomArticle, 
                a.unite,
                bv.quantite_demandee as qteDemandee, 
                (SELECT IFNULL(SUM(quantite_donnee), 0) 
                 FROM distributions 
                 WHERE id_ville = v.id AND id_article = a.id) as qteDonnee
              FROM besoins_villes bv
              JOIN villes v ON bv.id_ville = v.id
              JOIN articles a ON bv.id_article = a.id
              ORDER BY v.nom ASC, a.nom ASC";

        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
