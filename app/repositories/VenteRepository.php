<?php
namespace app\repositories;

class VenteRepository
{
    private $pdo;
    private $idArgent = 5;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function effectuerVente($id_article, $quantite)
    {
        $sqlNeed = "SELECT 
                        (SELECT IFNULL(SUM(quantite_demandee), 0) FROM besoins_villes WHERE id_article = ?) - 
                        (SELECT IFNULL(SUM(quantite_donnee), 0) FROM distributions WHERE id_article = ?) as restant";
        $st = $this->pdo->prepare($sqlNeed);
        $st->execute([$id_article, $id_article]);
        $besoinRestant = (float) $st->fetchColumn();

        if ($besoinRestant > 0) {
            return ["success" => false, "message" => "VENTE REFUSÉE : Des villes ont encore de cet article !"];
        }

        // 2. Récupérer PU et % de vente
        $stArt = $this->pdo->prepare("SELECT prix_unitaire, pourcentage_vente FROM articles WHERE id = ?");
        $stArt->execute([$id_article]);
        $art = $stArt->fetch();

        $puOriginal = (float) $art['prix_unitaire'];
        $remise = $puOriginal * ($art['pourcentage_vente'] / 100);
        $puVente = $puOriginal - $remise;
        $montantTotal = $puVente * $quantite;

        $this->pdo->beginTransaction();
        try {
            // Enregistrer la vente
            $sqlVente = "INSERT INTO ventes (id_article, quantite, prix_unitaire_vente, montant_total) VALUES (?, ?, ?, ?)";
            $this->pdo->prepare($sqlVente)->execute([$id_article, $quantite, $puVente, $montantTotal]);

            // Sortie de stock (Distribution sans ville_id)
            $sqlOut = "INSERT INTO distributions (id_ville, id_article, quantite_donnee) VALUES (NULL, ?, ?)";
            $this->pdo->prepare($sqlOut)->execute([$id_article, $quantite]);

            // Entrée de l'argent dans le stock global
            $sqlIn = "INSERT INTO stock_dons (id_article, quantite_recue, date_reception) VALUES (?, ?, NOW())";
            $this->pdo->prepare($sqlIn)->execute([$this->idArgent, $montantTotal]);

            $this->pdo->commit();
            return ["success" => true, "message" => "VENTE RÉUSSIE : " . formatNumber($montantTotal) . " Ar récupérés !"];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return ["success" => false, "message" => "ERREUR : " . $e->getMessage()];
        }
    }
}