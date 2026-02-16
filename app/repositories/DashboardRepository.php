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
        $query = "SELECT villes.id, villes.nom, 
                         besoins_villes.id_besoin, besoins_villes.description_besoin, besoins_villes.id_article, besoins_villes.quantite_besoin, besoins_villes.quantite_demandee,
                         
        FROM villes
                  JOIN besoins_villes ON villes.id = besoins_villes.id_ville 
    }
}

?>