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
                    villes.nom as nomVille, 
                    articles.nom as nomArticle,
                    articles.unite as unite,
                    besoins_villes.quantite_demandee as qteDemandee,
                    IFNULL(SUM(distributions.quantite_donnee), 0) as qteDonnee,
                    (besoins_villes.quantite_demandee - IFNULL(SUM(distributions.quantite_donnee), 0)) as resteAFaire
                  FROM besoins_villes
                  JOIN villes ON besoins_villes.id_ville = villes.id
                  JOIN articles ON besoins_villes.id_article = articles.id
                  LEFT JOIN distributions ON besoins_villes.id_ville = distributions.id_ville
                  GROUP BY 
                    besoins_villes.id, 
                    villes.nom, 
                    articles.nom, 
                    articles.unite, 
                    besoins_villes.quantite_demandee";
                  
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>