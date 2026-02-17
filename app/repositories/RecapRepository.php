<?php
namespace app\repositories;
use PDO;

class RecapRepository
{
    private PDO $pdo;
    private int $idArgent = 5; 

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFinancialRecap()
    {
        $sql = "SELECT 
            -- 1. Besoins totaux en montant (Ar)
            (SELECT SUM(bv.quantite_demandee * a.prix_unitaire) 
             FROM besoins_villes bv 
             JOIN articles a ON bv.id_article = a.id) as besoinTotal,
            
            -- 2. Besoins satisfaits (Dons directs + Achats) * Prix
            (SELECT SUM((
                IFNULL((SELECT SUM(quantite_donnee) FROM distributions WHERE id_article = a.id AND id_ville = bv.id_ville), 0) + 
                IFNULL((SELECT SUM(quantite) FROM achats WHERE id_article = a.id AND id_ville = bv.id_ville), 0)
            ) * a.prix_unitaire) 
            FROM besoins_villes bv 
            JOIN articles a ON bv.id_article = a.id) as besoinSatisfait,

            -- 3. Dons reçus en argent
            (SELECT SUM(quantite_recue) FROM stock_dons WHERE id_article = ?) as donsRecus,

            -- 4. Dons dispatchés (Argent distribué + Argent dépensé en achats)
            (SELECT (IFNULL(SUM(quantite_donnee), 0) + 
                    IFNULL((SELECT SUM(montant_total) FROM achats), 0))
             FROM distributions WHERE id_article = ?) as donsDispatches";

        $st = $this->pdo->prepare($sql);
        $st->execute([$this->idArgent, $this->idArgent]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}